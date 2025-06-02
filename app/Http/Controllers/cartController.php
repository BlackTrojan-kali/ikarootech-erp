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

class cartController extends Controller
{
    //
    public function add(Request $request)
    {
        $request->validate([
            "article" => "string | required",
            "qty" => "numeric |required",
        ]);

        $article = Article::findOrFail(intval($request->article));
        Cart::add($request->article, $article->title, $request->qty, $article->price, $article->weight);
        return back()->withSuccess("added successfully");
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
        $request->validate(["qtyup" => "numeric | required", "rowId" => "string |required"]);
        Cart::update($rowID, ["qty" => $request->qtyup]);
        return back()->withSuccess("updated successfully");
    }
    public function deleteItem($rowID)
    {
        Cart::remove($rowID);
        return back()->withSuccess("item deleted successfully");
    }
    public function validate(Request $request)
    {
        $request->validate([
            "client" => "required",
            "currency" => "string |required",
            "type" => "string |  required",
        ]);
        $client = Client::findOrFail($request->client);
        
        $clientcat = Clientcat::where("id",$client->id_clientcat)->first();
        $articles = Clientprice::where("id_cat", $clientcat->id)->where("region",Auth::user()->region)->get();
    
        if (count(Cart::content()) <= 0) {
            return back()->withErrors(["message" => "votre panier est vide"]);
        }
        if ($request->type == "vente") {
            foreach ($articles as $article) {
                foreach (Cart::content() as $content) {

                    if ($content->id == $article->id_article) {
                        Cart::update($content->rowId, ["price" => $article->unite_price]);
                    }
                }
            }
        } else {
            foreach ($articles as $article) {
                foreach (Cart::content() as $content) {

                    if ($content->id == $article->id_article) {
                        Cart::update($content->rowId, ["price" => $article->consigne_price]);
                    }
                }
            }
        }
        $invoice = new Invoices();
        $invoice->commercial = Auth::user()->name;
        $invoice->id_client = $client->id;
        $invoice->currency = $request->currency;
        $invoice->region = Auth::user()->region;
        $invoice->articles = Cart::content();
        $invoice->total_price = floatval(str_replace(",", "", Cart::priceTotal()));
        $invoice->type = $request->type;
        
        $invoice->save();
        $pdf = Pdf::loadView("commercial.invoice3", ["invoice" => $invoice, "articles" => $articles, "client" => $client]);


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
        Cart::destroy();
        return $pdf->download($client->nom . $client->prenom . $invoice->created_at . ".pdf");
    }

    public function printInvoice($id)
    {

        $invoice = Invoices::findOrFail($id);
        $client = Client::findOrFail($invoice->id_client);
        $articles = Clientprice::where("id_cat", $client->id_clientcat)->get();
        $pdf = Pdf::loadView("commercial.invoice3", ["invoice" => $invoice, "articles" => $articles, "client" => $client]);
        return $pdf->download($client->nom . $client->prenom . $invoice->created_at . ".pdf");
    }
    public function modifySales($idSale)
    {

        $stocks = Stock::where("region", "=", Auth::user()->region)->where("category", "commercial")->with("article")->get();
        $accessories = Article::where("type", "=", "accessoire")->get("title");
        $sale = Invoices::findOrFail($idSale);
        $clients = Client::all();
        $articles = Article::all();

        return view("commercial.ModifInvoice", ["clientsList" => $clients, "articlesList" => $articles, "stocks" => $stocks, "accessories" => $accessories, "sale" => $sale]);
    }
    public function updateSales(Request $request, $idSale)
    {
        $request->validate([
            "currency" => "string | required",
        ]);
        $sale = Invoices::findOrFail($idSale);
        $sale->currency = $request->currency;
        $sale->save();
        return back()->withSuccess("Invoice modified successfully");
    }
    public function deleteSale($idSale)
    {
        $sale = Invoices::findOrFail($idSale);
        $sale->delete();
        return response()->json(["message" => "Sale deleted successfully"]);
    }
}
