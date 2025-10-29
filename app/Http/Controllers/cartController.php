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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class cartController extends Controller
{
    /**
     * Ajoute un article au panier en déterminant le prix spécifique au client (unite_price et consigne_price).
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "article" => "required|numeric",
            "qty" => "required|numeric|min:1",
            "client_id" => "required|numeric", // Clé nécessaire pour déterminer le prix
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        try {
            $article = Article::findOrFail(intval($request->article));
            $client = Client::findOrFail(intval($request->client_id));
            
            // 1. Récupérer le prix spécifique pour cet article, cette catégorie de client et cette région
            $articlePriceEntry = Clientprice::where('id_article', $article->id)
                ->where('id_cat', $client->id_clientcat)
                ->where('region', $client->region) // Utilisation de la région du client
                ->first();

            // Si le prix n'est pas trouvé dans la table clientprices, on peut utiliser un prix par défaut 
            // (ici, je lève une erreur, mais vous pourriez mettre un fallback si vous le souhaitez)
            if (!$articlePriceEntry) {
                 return response()->json([
                    'errors' => ["Aucun prix spécifique n'est défini pour cet article dans la catégorie du client et sa région ({$client->region})."]
                 ], 404);
            }

            // Le prix de base (unite_price) est celui que nous utilisons pour le calcul du total
            $basePrice = $articlePriceEntry->unite_price;

            // Le poids sera probablement stocké comme une propriété directe de CartItem
            $weight = property_exists($article, 'weight') ? (float) $article->weight : 0;
            
            // 2. Ajouter l'article au panier avec le prix unitaire.
            // Nous stockons aussi le prix de consigne et l'ID du client en options pour la validation finale
            Cart::add(
                $article->id,           // id
                $article->title,        // name
                $request->qty,          // qty
                $basePrice,             // price (Utilise le prix unitaire du client)
                $weight,                // weight
                [
                    'consigne_price' => $articlePriceEntry->consigne_price, // Prix de consigne pour référence
                    'client_id' => $client->id,                         // ID du client sélectionné
                ]
            );

            return response()->json(['success' => "Article ajouté au panier avec succès !"]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Client ou Article non trouvé lors de l'ajout au panier.");
            return response()->json(['errors' => ['L\'article ou le client sélectionné n\'existe pas.']], 404);
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

    /**
     * Valide la commande, met à jour le prix si nécessaire (pour la consigne), enregistre la facture et génère le PDF.
     */
    public function validate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "client" => "required|numeric",
            "currency" => "string|required",
            "type" => "string|required", // 'vente' ou 'consigne'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }
        
        $client = Client::findOrFail($request->client);
        
        // La catégorie client est déjà chargée via la relation mais on peut le faire manuellement
        $clientcat = $client->clientCat; // Utilisation de la relation clientCat

        if (Cart::content()->isEmpty()) {
            return response()->json(['errors' => ["Votre panier est vide."]], 400); 
        }

        // Récupérer tous les prix spécifiques de la catégorie du client
        $clientPrices = Clientprice::where("id_cat", $clientcat->id)
                                    ->where("region", Auth::user()->region)
                                    ->get()
                                    ->keyBy('id_article');

        // Mise à jour finale du prix du panier selon le type (vente/consigne)
        foreach (Cart::content() as $content) {
            if (isset($clientPrices[$content->id])) {
                $articlePrice = $clientPrices[$content->id];
                
                // Si le type est 'consigne', on met à jour le prix avec le prix de consigne.
                // Sinon (type 'vente'), on garde le prix unitaire déjà défini lors du Cart::add.
                if ($request->type == "consigne") {
                    $priceToSet = $articlePrice->consigne_price;
                    Cart::update($content->rowId, ['price' => $priceToSet]);
                }
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
            
            // ... (Le reste de la logique d'enregistrement dans Invoicetrace reste inchangée)
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
            
            // Génération du PDF
            $pdf = Pdf::loadView("commercial.invoice3", ["invoice" => $invoice, "client" => $client]);
            $pdfContent = $pdf->output();
            $base64Pdf = base64_encode($pdfContent);

            $filename = $client->nom . '_' . $client->prenom . '_' . $invoice->created_at->format('Ymd_His') . ".pdf";
            
            Cart::destroy(); // Vider le panier

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
    // ... (Les autres fonctions restent inchangées : printInvoice, modifySales, updateSales, deleteSale)
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

    public function destroy()
    {
        // La méthode Cart::destroy() vide complètement le panier pour l'instance courante.
        Cart::destroy();

        // Rediriger l'utilisateur vers le formulaire avec un message de succès
        return redirect()->back()->with('success', 'Le panier a été vidé avec succès, monsieur.');
        
        // Remplacez 'votre_route_du_formulaire' par le nom réel de la route de votre vue (par exemple: 'formulaireVentesConsigne').
    }
}