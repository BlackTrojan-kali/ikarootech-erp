<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Client;
use App\Models\Clientcat;
use App\Models\Clientprice;
use App\Models\Invoices;
use App\Models\Invoicetrace;
use App\Models\Stock;
use Barryvdh\DomPDF\Facade\Pdf;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Added for logging
use Illuminate\Support\Facades\Validator; // Added for validation

class cartController extends Controller
{
      public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "article" => "required|numeric",
            "qty" => "required|numeric|min:1",
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        try {
            $article = Article::findOrFail(intval($request->article));
            
            // C'est la ligne la plus importante à corriger !
            // La trace indique qu'il attendait une chaîne (pour le poids probablement)
            // avant le tableau d'options.

            // Utilisez la signature suivante, en passant le poids comme 5ème argument.
            // Le 6ème argument est le tableau d'options (qui peut être vide si le poids est déjà passé).
            // Le poids sera probablement stocké comme une propriété directe de CartItem, et non dans 'options'.
            // Assurez-vous que $article->weight est bien un nombre ou une chaîne convertible en nombre.
            $weight = (float) $article->weight; // Convertir en float pour s'assurer que c'est numérique

            Cart::add(
                $request->article,      // id
                $article->title,        // name
                $request->qty,          // qty
                $article->price,        // price
                $weight,                // Le poids comme 5ème argument (string/numeric)
                []                      // Le tableau d'options (vide ou avec d'autres options si nécessaire)
            );

            // Si vous avez d'autres options à passer en plus du poids, vous les mettez ici :
            // Cart::add($request->article, $article->title, $request->qty, $article->price, $weight, ['color' => 'red']);

            return response()->json(['success' => "Article ajouté au panier avec succès !"]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Article non trouvé lors de l'ajout au panier: " . $request->article);
            return response()->json(['errors' => ['L\'article sélectionné n\'existe pas.']], 404);
        } catch (\Exception $e) {
            Log::error("Erreur inattendue lors de l'ajout au panier: " . $e->getMessage(), ['exception' => $e]);
            return response()->json(['errors' => ['Une erreur interne est survenue. Veuillez réessayer.']], 500);
        }
    }

    public function cartlist()
    {
        $stocks = Stock::where("region", "=", Auth::user()->region)->where("category", "commercial")->with("article")->get();
        $accessories = Article::where("type", "=", "accessoire")->get("title");
        $clients = Client::where("region",Auth::user()->region)->get();
        $articles  = Article::where("state", 1)->orWhere("type", "accessoire")->get();
        return view("commercial.cartlist", ["clientsList" => $clients, "articlesList" => $articles, "articles" => $articles, "accessories" => $accessories, "stocks" => $stocks, "clients" => $clients]);
    }

    public function updateCart($rowID, Request $request)
    {
        $request->validate(["qtyup" => "numeric|required|min:0", "rowId" => "string|required"]);
        Cart::update($rowID, $request->qtyup);
        return back()->withSuccess("Quantité mise à jour avec succès !");
    }

    public function deleteItem($rowID)
    {
        Cart::remove($rowID);
        return back()->withSuccess("Article supprimé du panier avec succès !");
    }

    public function validate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "client" => "required|numeric",
            "currency" => "string|required",
            "type" => "string|required",
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }
        
        $client = Client::findOrFail($request->client);
        
        $clientcat = Clientcat::where("id",$client->id_clientcat)->first();
        $clientPrices = Clientprice::where("id_cat", $clientcat->id)
                                    ->where("region", Auth::user()->region)
                                    ->get()
                                    ->keyBy('id_article');

        if (Cart::content()->isEmpty()) {
            return response()->json(['errors' => ["Votre panier est vide."]], 400); // Bad Request
        }

        foreach (Cart::content() as $content) {
            if (isset($clientPrices[$content->id])) {
                $articlePrice = $clientPrices[$content->id];
                $priceToSet = ($request->type == "vente") ? $articlePrice->unite_price : $articlePrice->consigne_price;
                Cart::update($content->rowId, ['price' => $priceToSet]);
            }
        }

        try {
            $invoice = new Invoices();
            $invoice->commercial = Auth::user()->name;
            $invoice->id_client = $client->id;
            $invoice->currency = $request->currency;
            $invoice->region = Auth::user()->region;
            $invoice->articles = json_encode(Cart::content());
            $invoice->total_price = floatval(str_replace(",", "", Cart::priceTotal()));
            $invoice->type = $request->type;
            
            $invoice->save();
            
            foreach (Cart::content() as $content) {
                $trace = new Invoicetrace();
                $trace->id_invoice = $invoice->id;
                $trace->id_article = $content->id;
                $trace->qty = $content->qty;
                $trace->unit_price = $content->price;
                $trace->region = $invoice->region;
                $trace->type = $request->type;
                $trace->save();
            }
            
            // Générer le PDF et l'encoder en Base64
            $pdf = Pdf::loadView("commercial.invoice3", ["invoice" => $invoice, "client" => $client]);
            $pdfContent = $pdf->output(); // Obtient le contenu brut du PDF
            $base64Pdf = base64_encode($pdfContent); // Encode en Base64

            $filename = $client->nom . '_' . $client->prenom . '_' . $invoice->created_at->format('Ymd_His') . ".pdf";
            
            Cart::destroy(); // Vider le panier après génération de la facture

            // Retourner la réponse JSON avec le PDF encodé
            return response()->json([
                'success' => 'Facture validée et PDF généré avec succès !',
                'pdf' => $base64Pdf,
                'filename' => $filename
            ]);

        } catch (\Exception $e) {
            Log::error("Erreur lors de la validation du panier et génération PDF: " . $e->getMessage(), ['exception' => $e]);
            return response()->json(['errors' => ['Une erreur est survenue lors de la validation. Veuillez réessayer.']], 500);
        }
    }

    public function printInvoice($id)
    {
        // Cette fonction sera toujours pour un téléchargement direct, pas besoin de la changer si elle est appelée séparément
        $invoice = Invoices::findOrFail($id);
        $client = Client::findOrFail($invoice->id_client);
        $pdf = Pdf::loadView("commercial.invoice3", ["invoice" => $invoice, "client" => $client]);
        $filename = $client->nom . '_' . $client->prenom . '_' . $invoice->created_at->format('Ymd_His') . ".pdf";
        return $pdf->download($filename);
    }

    public function modifySales($idSale)
    {
        $stocks = Stock::where("region", "=", Auth::user()->region)->where("category", "commercial")->with("article")->get();
        $accessories = Article::where("type", "=", "accessoire")->get("title");
        $sale = Invoices::findOrFail($idSale);
        $clients = Client::all();
        $articles = Article::all();
        return view("commercial.ModifInvoice", ["clientsList" => $clients, "clients"=>$clients,"articlesList" => $articles, "stocks" => $stocks, "accessories" => $accessories, "sale" => $sale]);
    }

    public function updateSales(Request $request, $idSale)
    {
        $request->validate(["currency" => "string | required"]);
        $sale = Invoices::findOrFail($idSale);
        $sale->currency = $request->currency;
        $sale->save();
        return back()->withSuccess("Facture modifiée avec succès !");
    }

    public function deleteSale($idSale)
    {
        $sale = Invoices::findOrFail($idSale);
    
        $sale->delete();
        return response()->json(["message" => "Vente supprimée avec succès !"]);
    }
}