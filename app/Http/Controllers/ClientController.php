<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Citerne;
use App\Models\Client;
use App\Models\Clientcat;
use App\Models\Clientprice;
use App\Models\Region;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Ramsey\Uuid\v1;

class ClientController extends Controller
{
    //
    public function showCats()
    {
        $clientcats = Clientcat::all();
        switch (Auth::user()->role) {
            case "super":
                return view("super.list_client_cats", ["clientcats" => $clientcats]);
            case "controller":
                $stocks = Stock::with("article")->where("region", Auth::user()->region)->get();
                $mobile = Citerne::where("type", "mobile")->get();
                $fixe  = Citerne::where("type", "fixe")->get();
                $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
                $clients = Client::where("region",Auth::user()->region)->get();
                return view("controller.list_client_cats", ["clientsList" => $clients, "articlesList" => $articles, "clientcats" => $clientcats, "mobile" => $mobile, "fixe" => $fixe, "stocks" => $stocks]);
            case "commercial":
                $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
                $clients = Client::where("region",Auth::user()->region)->get();
                $stocks = Stock::where("region", "=", Auth::user()->region)->where("category", "commercial")->with("article")->get();
                $accessories = Article::where("type", "=", "accessoire")->get("title");
                return view("commercial.list_client_cats", ["clientsList" => $clients, "articlesList" => $articles, "clientcats" => $clientcats, "stocks" => $stocks, "accessories" => $accessories]);
            default:
                return back()->withErrors(["error" => "you are not authorized to access this ressource"]);
        }
    }
    public function createCat()
    {
        switch (Auth::user()->role) {
            case "super":
                return view("super.create_client_cat");
            case "controller":
                $stocks = Stock::with("article")->where("region", Auth::user()->region)->get();
                $mobile = Citerne::where("type", "mobile")->get();
                $fixe  = Citerne::where("type", "fixe")->get();
                $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
                $clients = Client::where("region",Auth::user()->region)->get();
                return view("controller.create_client_cat", ["clientsList" => $clients, "articlesList" => $articles,"mobile" => $mobile, "fixe" => $fixe, "stocks" => $stocks]);
            case "commercial":
                $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
                $clients = Client::where("region",Auth::user()->region)->get();
                $stocks = Stock::where("region", "=", Auth::user()->region)->where("category", "commercial")->with("article")->get();
                $accessories = Article::where("type", "=", "accessoire")->get("title");
                return view("commercial.create_client_cat", ["clientsList" => $clients, "articlesList" => $articles, "stocks" => $stocks, "accessories" => $accessories]);

            default:
                return back()->withErrors(["error" => "you are not authorized to access this ressource"]);
        }
    }
    public function storeCat(Request $request)
    {
        $request->validate([
            "name" => "string | max:20 |min:4",
        ]);
        $clientcat = new Clientcat();
        $clientcat->name = $request->name;
        $clientcat->reduction = 0;
        $clientcat->save();
        return back()->withSuccess("categorie client creee avec succes");
    }
    public function modifCat($id)
    {
        $clientcat = Clientcat::findOrFail($id);

        switch (Auth::user()->role) {
            case "super":
                return view("super.modify_client_cat", ["clientCat" => $clientcat]);
            case "controller":
                $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
                $clients = Client::where("region",Auth::user()->region)->get();
                $stocks = Stock::with("article")->where("region", Auth::user()->region)->get();
                $mobile = Citerne::where("type", "mobile")->get();
                $fixe  = Citerne::where("type", "fixe")->get();
                return view("controller.modify_client_cat", ["clientsList" => $clients, "articlesList" => $articles,"clientCat" => $clientcat, "mobile" => $mobile, "fixe" => $fixe, "stocks" => $stocks]);
            case "commercial":
                $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
                $clients = Client::where("region",Auth::user()->region)->get();
                $stocks = Stock::where("region", "=", Auth::user()->region)->where("category", "commercial")->with("article")->get();
                $accessories = Article::where("type", "=", "accessoire")->get("title");
                return view("commercial.modify_client_cat", ["clientsList" => $clients, "articlesList" => $articles, "clientCat" => $clientcat, "stocks" => $stocks, "accessories" => $accessories]);

            default:
                return back()->withErrors(["error" => "you are not authorized to access this ressource"]);
        }
    }
    public function updateCat(Request $request, $id)
    {
        $request->validate([
            "name" => "string | max:20 | min:4",
            "redux" => "numeric | nullable",
        ]);
        $clientcat = Clientcat::findOrFail($id);
        $clientcat->name = $request->name;
        $clientcat->reduction = $request->redux;
        $clientcat->save();
        return back()->withSuccess("categorie client modifiee avec succes");
    }
    public function deleteCat($id)
    {
        $clientcat = Clientcat::find($id);
        $clientcat->delete();
        return response()->json(["message" => "categorie client supprimee avec succes"]);
    }
    //gestion clients
    public function showClients()
    {
        switch (Auth::user()->role) {
            case "super":
                $clients = Client::with("Clientcat")->get();
                return view("super.list-clients", ["clients" => $clients]);
            case "controller":
                $clients = Client::with("Clientcat")->get();
                $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
                $stocks = Stock::with("article")->where("region", Auth::user()->region)->get();
                $mobile = Citerne::where("type", "mobile")->get();
                $fixe  = Citerne::where("type", "fixe")->get();
                return view("controller.list-clients", ["clientsList" => $clients, "articlesList" => $articles, "clients" => $clients, "mobile" => $mobile, "fixe" => $fixe, "stocks" => $stocks]);
            case "commercial":
                $clients = Client::where("region",Auth::user()->region)->with("Clientcat")->get();
                $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
                $stocks = Stock::where("region", "=", Auth::user()->region)->where("category", "commercial")->with("article")->get();
                $accessories = Article::where("type", "=", "accessoire")->get("title");
                return view("commercial.list-clients", ["clientsList" => $clients, "articlesList" => $articles, "clients" => $clients, "stocks" => $stocks, "accessories" => $accessories]);
            default:
                return back()->withErrors(["error" => "you are not authorized to access this ressource"]);
        }
    }
    public function createClient()
    {
        $categories = Clientcat::all();
        $regions = Region::all();
        switch (Auth::user()->role) {
            case "super":
                return view("super.create_client", ["categories" => $categories, "regions" => $regions]);
            case "controller":
                $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
                $clients = Client::where("region",Auth::user()->region)->get();
                $stocks = Stock::with("article")->where("region", Auth::user()->region)->get();
                $mobile = Citerne::where("type", "mobile")->get();
                $fixe  = Citerne::where("type", "fixe")->get();
                $regions = Region::all();
                return view("controller.create_client", ["regions"=>$regions,"clientsList" => $clients, "articlesList" => $articles,"categories" => $categories, "regions" => $regions, "mobile" => $mobile, "fixe" => $fixe, "stocks" => $stocks]);
            case "commercial":
                $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
                $clients = Client::where("region",Auth::user()->region)->get();
                $stocks = Stock::where("region", "=", Auth::user()->region)->where("category", "commercial")->with("article")->get();
                $accessories = Article::where("type", "=", "accessoire")->get("title");
                return view("commercial.create_client", ["clientsList" => $clients, "articlesList" => $articles, "categories" => $categories, "regions" => $regions, "stocks" => $stocks, "accessories" => $accessories]);
            default:
                return back()->withErrors(["error" => "you are not authorized to access this ressource"]);
        }
    }
    public function storeClient(Request $request)
    {
        $request->validate([
            "name" => "string | min:3 | required",
            "address" => "string | min:3 | required",
            "fname" => "string | min:3 | required",
            "email" => "email | required",
            "phone" => "numeric | required",
            "category" => "required",
            "region" => " string |required",
            "registre"=>"string |nullable",
            "numero_unique"=>"string| nullable",
        ]);
        $client = new Client();
        $client->nom = $request->name;
        $client->prenom = $request->fname;
        $client->email = $request->email;
        $client->address = $request->address;
        $client->numero = $request->phone;
        $client->region = $request->region;
        $client->registre_commerce= $request->registre;
        $client->id_clientcat = $request->category;
        $client->numero_unique = $request->numero_unique;
        $client->save();
        return back()->withSuccess("client created successfully");
    }
    public function modifClient($id)
    {
        $client = Client::where("id", $id)->first();
        $categories = Clientcat::all();
        switch (Auth::user()->role) {
            case "super":
                return view("super.modif_client", ["client" => $client, "categories" => $categories]);
            case "controller":
                $stocks = Stock::with("article")->where("region", Auth::user()->region)->get();
                $mobile = Citerne::where("type", "mobile")->get();
                $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
                $clients = Client::where("region",Auth::user()->region)->get();
                $fixe  = Citerne::where("type", "fixe")->get();
                $regions = Region::all();
                return view("controller.modif_client", ["regions"=>$regions,"clientsList" => $clients, "articlesList" => $articles,"client" => $client, "categories" => $categories, "mobile" => $mobile, "fixe" => $fixe, "stocks" => $stocks]);
            case "commercial":
                $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
                $clients = Client::where("region",Auth::user()->region)->get();
                $stocks = Stock::where("region", "=", Auth::user()->region)->where("category", "commercial")->with("article")->get();
                $accessories = Article::where("type", "=", "accessoire")->get("title");
                return view("commercial.modif_client", ["clientsList" => $clients, "articlesList" => $articles, "client" => $client, "categories" => $categories, "stocks" => $stocks, "accessories" => $accessories]);
            default:
                return back()->withErrors(["error" => "you are not authorized to access this ressource"]);
        }
    }
    public function updateClient(Request $request, $id)
    {
        $request->validate([
            "name" => "string | min:3 | required",
            "address" => "string | min:3 | required",
            "fname" => "string | min:3 | required",
            "email" => "email | required",
            "phone" => "numeric | required",
            "category" => "required",
            "region"=>"string|required",
            "registre"=>"string | nullable",
            "redux" => "numeric |nullable",
        ]);
        $client = Client::where("id", $id)->first();
        $client->nom = $request->name;
        $client->prenom = $request->fname;
        $client->email = $request->email;
        $client->address = $request->address;
        $client->numero = $request->phone;
        $client->region = $request->region;
        $client->registre_commerce = $request->registre;
        $client->id_clientcat = $request->category;
        $client->numero_unique = $request->numero_unique;
        $client->save();
        return back()->withSuccess("client updated successfully");
    }
    public function deleteClient($id)
    {
        $client = Client::find($id);
        $client->delete();
        return response()->json(["message" => "Client deleted successfully"]);
    }
    public function showPrice()
    {
        $prices = Clientprice::with("client", "article")->get();
        switch (Auth::user()->role) {
            case "super":
                return view("super.prix-client", ["prices" => $prices]);
            case "controller":
                $stocks = Stock::with("article")->where("region", Auth::user()->region)->get();
                $mobile = Citerne::where("type", "mobile")->get();
                $fixe  = Citerne::where("type", "fixe")->get();
                $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
                $clients = Client::where("region",Auth::user()->region)->get();
                $prices = Clientprice::with("client", "article")->get();
                return view("controller.prix-client", ["clientsList" => $clients, "articlesList" => $articles,"prices" => $prices, "mobile" => $mobile, "fixe" => $fixe, "stocks" => $stocks]);
            case "commercial":
                $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
                $clients = Client::where("region",Auth::user()->region)->get();
                $prices = Clientprice::with("client", "article")->where("region",Auth::user()->region)->get();
                $stocks = Stock::where("region", "=", Auth::user()->region)->where("category", "commercial")->with("article")->get();
                $accessories = Article::where("type", "=", "accessoire")->get("title");
                return view("commercial.prix-client", ["clientsList" => $clients, "articlesList" => $articles, "clientsList" => $clients, "articlesList" => $articles, "prices" => $prices, "stocks" => $stocks, "accessories" => $accessories]);
            default:
                return back()->withErrors(["error" => "you are not authorized to access this ressource"]);
        }
    }
    public function createPrice()
    {
        $cats = Clientcat::all();
        $articles = Article::all();
        switch (Auth::user()->role) {
            case "super":
                $region = Region::all();
                return view("super.create-client-price", ["regions"=>$region,"clients" => $cats, "articles" => $articles]);
            case "controller":
                $stocks = Stock::with("article")->where("region", Auth::user()->region)->get();
                $mobile = Citerne::where("type", "mobile")->get();
                $fixe  = Citerne::where("type", "fixe")->get();
                $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
                $clients = Client::where("region",Auth::user()->region)->get();
                $regions = Region::all();
                return view("controller.create-client-price", ["regions"=>$regions,"clientsList" => $clients, "articlesList" => $articles,"clients" => $cats, "articles" => $articles, "mobile" => $mobile, "fixe" => $fixe, "stocks" => $stocks]);
            case "commercial":
                $stocks = Stock::where("region", "=", Auth::user()->region)->where("category", "commercial")->with("article")->get();
                $accessories = Article::where("type", "=", "accessoire")->get("title");
                $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
                $clients = Client::where("region",Auth::user()->region)->get();
                $cats = Clientcat::all();
                return view("commercial.create-client-price", ["clientsList" => $clients, "articlesList" => $articles, "clients" => $cats, "articles" => $articles, "stocks" => $stocks, "accessories" => $accessories]);
            default:
                return back()->withErrors(["error" => "you are not authorized to access this ressource"]);
        }
    }
    public function storePrice(Request $request)
    {
        $request->validate([
            "client" => "string | required",
            "article" => "string | required",
            "price" => "numeric | required",
            "region"=>"string|required",
            "consigne_price" => "numeric | required",
        ]);
        $exist = ClientPrice::where("id_cat",$request->client)->where("id_article",$request->article)->where("region",$request->region)->first();
        if($exist){
            return back()->withErrors(["message"=>"le prix de cet article existe deja "]);
        }
        $price = new Clientprice();
        $price->id_cat = $request->client;
        $price->id_article = $request->article;
        $price->unite_price = $request->price;
        $price->region = $request->region;
        $price->consigne_price = $request->consigne_price;
        $price->save();
        return back()->withSuccess("price created with success");
    }
    public function deletePrice($idPrice)
    {
        $price = Clientprice::findOrFail($idPrice);
        $price->delete();
        return response()->json(["message" => "price deleted successfully"]);
    }
    public function editPrice($idPrice)
    {
        $price = Clientprice::where("id", $idPrice)->with("client", "article")->first();
        switch (Auth::user()->role) {
            case "super":
                return view("super.edit-prices", ["price" => $price]);
            case "controller":
                $stocks = Stock::with("article")->where("region", Auth::user()->region)->get();
                $mobile = Citerne::where("type", "mobile")->get();
                $fixe  = Citerne::where("type", "fixe")->get();
                $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
                $clients = Client::where("region",Auth::user()->region)->get();
              
                return view("controller.edit-prices", ["clientsList" => $clients, "articlesList" => $articles,"price" => $price, "mobile" => $mobile, "fixe" => $fixe, "stocks" => $stocks]);
            case "commercial":
                $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
                $clients = Client::where("region",Auth::user()->region)->get();
                $stocks = Stock::where("region", "=", Auth::user()->region)->where("category", "commercial")->with("article")->get();
                $accessories = Article::where("type", "=", "accessoire")->get("title");
                return view("commercial.edit-prices", ["clientsList" => $clients, "articlesList" => $articles, "price" => $price, "stocks" => $stocks, "accessories" => $accessories]);
        }
    }
    public function updatePrice($idPrice, Request $request)
    {
        $request->validate([
            "price" => "numeric | required",
            "consigne_price" => "numeric | required",
        ]);

        $price = Clientprice::findOrFail($idPrice);
        $price->unite_price = $request->price;
        $price->consigne_price = $request->consigne_price;
        $price->save();
        return back()->withSuccess("price modified successfully");
    }
}
