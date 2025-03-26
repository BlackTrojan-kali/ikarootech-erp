<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Article;
use App\Models\Citerne;
use App\Models\Movement;
use App\Models\Producermove;
use App\Models\Receive;
use App\Models\Relhistorie;
use App\Models\Stock;
use App\Models\Transmit;
use App\Models\Vracmovement;
use App\Models\Vracstock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Database\Eloquent\Builder;
use function Ramsey\Uuid\v1;

class ProducerController extends Controller
{
    //
    public function show()
    {
        $stocks = Stock::where("category", "production")->where("region", Auth::user()->region)->get();
        $allvrackstocks = Citerne::all();
        $vracstocks = Citerne::where("type", "mobile")->get();
        $fixe  = Citerne::where("type", "fixe")->get();
        return view("producer.dashboard", ["vrac" => $vracstocks, "stocks" => $stocks, "fixe" => $fixe, "all" => $allvrackstocks]);
    }

    public function deleteMove($id)
    {
        $move = Movement::findOrFail($id);
        $stock = Stock::where("id", $move->stock_id)->with("article")->first();
        if ($move->id_citerne) {
            $weight = $stock->article->weight;

            $citerne = Citerne::where("name", $move->id_citerne)->first();
            /*
            all method not more working
            $citerne = Citerne::where("name", $move->id_citerne)->with("stock")->first();

            $citerne->stock->stock_theo += ($move->qty * $weight);
            $citerne->stock->stock_rel = $citerne->stock->stock_theo;
            $citerne->stock->save();*/
            $citStock = Vracstock::where("citerne_id", $citerne->id)->where("region", Auth::user()->region)->first();
            $citStock->stock_theo += ($move->qty * $weight);
            $citStock->stock_rel = $citStock->stock_theo;
            $citStock->save();
        }
        if ($move->entree == 1) {
            $stock->qty -= $move->qty;
            if ($stock->qty < 0) {
                return response()->json(["message" => "stock negatif operation impossible"]);
            }
            if ($stock->article->state == 1) {
                $article2 = Article::where("weight", $stock->article->weight)->where("state", 0)->first();
                $stock2 = Stock::where("article_id", $article2->id)->where("region", Auth::user()->region)->where("category", Auth::user()->role)->first();

                $stock2->qty += $move->qty;
                $stock2->save();
            }
            $stock->save();
        } else if ($move->sortie == 1) {
            $stock->qty += $move->qty;
            $stock->save();
        }
        $move->delete();
        return response()->json(["message" => "movement supprime avec success"]);
    }
    public function deleteReception($id)
    {
        $reception = Receive::findOrFail($id);
        $reception->delete();
        return response()->json(["message" => "reception supprime avec success"]);
    }
    //Etats des mouvements 
    public function showEntry(Request $request, $state, $type, $weight)
    {
        $stocks = Stock::where("category", "production")->where("region", Auth::user()->region)->get();
        $allvrackstocks = Citerne::all();
        $vracstocks = Citerne::where("type", "mobile")->get();
        $fixe  = Citerne::with(["Stock" => function ($query) {
            $query->where("region", Auth::user()->region);
        }])->where("type", "fixe")->get();
        if ($weight > 0) {
            $moves = Movement::join("articles", "movements.article_id", "articles.id")->leftjoin("stocks", "movements.stock_id", "stocks.id")->where("stocks.region", Auth::user()->region)->where("movements.entree", $type)->where("movements.service", Auth::user()->role)->where("articles.state", $state)->where("articles.weight", $weight)->select("movements.*")->with("fromArticle")->get();

            $moves2 = Movement::join("articles", "movements.article_id", "articles.id")->leftjoin("stocks", "movements.stock_id", "stocks.id")->where("stocks.region", Auth::user()->region)->where("movements.entree", $type)->where("movements.service", Auth::user()->role)->where("articles.state", 0)->where("articles.weight", $weight)->select("movements.*")->with("fromArticle")->get();
        } else {
            $moves2 = Movement::join("articles", "movements.article_id", "articles.id")->leftjoin("stocks", "movements.stock_id", "stocks.id")->where("stocks.region", Auth::user()->region)->where("movements.entree", $type)->where("movements.service", Auth::user()->role)->where("articles.state", 0)->where("articles.weight", $weight)->select("movements.*")->with("fromArticle")->get();
            $moves = Movement::join("articles", "movements.article_id", "articles.id")->leftjoin("stocks", "movements.stock_id", "stocks.id")->where("stocks.region", Auth::user()->region)->where("movements.entree", $type)->where("movements.service", Auth::user()->role)->where("articles.type", "accessoire")->select("movements.*")->get();
        }
        if (Auth::user()->role == "magasin") {

            $mobile = Citerne::where("type", "mobile")->get();
            $accessories = Article::where("type", "=", "accessoire")->get("title");
            return view("manager.moveEntryMan", ["mobile" => $mobile, "vrac" => $vracstocks, "stocks" => $stocks, "accessories" => $accessories, "fixe" => $fixe, "all" => $allvrackstocks, "moves" => $moves, "moves2" => $moves2]);
        } else if (Auth::user()->role == "commercial") {

            $stocks = Stock::where("region", "=", Auth::user()->region)->where("category", "commercial")->with("article")->get();
            $accessories = Article::where("type", "=", "accessoire")->get("title");
            return view("commercial.ComHistory", ["stocks" => $stocks, "accessories" => $accessories, "moves" => $moves, "moves2" => $moves2]);
        }
        return view("producer.moveEntry", ["vrac" => $vracstocks, "stocks" => $stocks, "fixe" => $fixe, "all" => $allvrackstocks, "moves" => $moves, "moves2" => $moves2]);
    }

    public function showCiterne()
    {

        $stocks = Stock::where("category", Auth::user()->role)->where("region", Auth::user()->region)->get();
        $vracstocks = Citerne::where("type", "mobile")->get();
        $fixe  =  Citerne::with(array('Stock' => function (Builder $query) {
            $query->where("region", Auth::user()->region);
        }))->where("type", "fixe")->get();
        $accessories = Article::where("type", "accessoire")->get("title");

        $allvrackstocks = Citerne::all();
        if (Auth::user()->role == "magasin") {
            $mobile = Citerne::where("type", "mobile")->get();
            return  view("manager.citernes", ["mobile" => $mobile, "vrac" => $vracstocks, "stocks" => $stocks, "fixe" => $fixe, "accessories" => $accessories]);
        }
        return view("producer.citernes", ["vrac" => $vracstocks, "stocks" => $stocks, "fixe" => $fixe, "all" => $allvrackstocks]);
    }
    public function makeRel($id)
    {

        $stocks = Stock::where("category", "production")->get();
        $vracstocks = Citerne::where("type", "mobile")->get();
        $fixe  = Citerne::with(["Stock" => function ($query) {
            $query->where("region", Auth::user()->region);
        }])->where("type", "fixe")->get();
        $fixer = Citerne::where("id", $id)->with(["Stock" => function ($query) {
            $query->where("region", Auth::user()->region);
        }])->first();

        $accessories = Article::where("type", "accessoire")->get("title");
        $mobile = Citerne::where("type", "mobile")->get();
        $allvrackstocks = Citerne::all();
        return view("producer.citerneRel", ["vrac" => $vracstocks, "stocks" => $stocks, "fixe" => $fixe, "mobile" => $mobile, "fixer" => $fixer, "id" => $id, "all" => $allvrackstocks, "accessories" => $accessories]);
    }
    public function postRel(Request $request, $id)
    {
        $request->validate([
            "qty" => "numeric|required"
        ]);
        $fixe = Vracstock::join("citernes", "vracstocks.citerne_id", "citernes.id")->where("citernes.id", $id)->where("vracstocks.region", Auth::user()->region)->where("citernes.type", "fixe")->select("vracstocks.*", "citernes.name")->first();
        /*Citerne::with(["Stock" => function ($query) {
            $query->where("region", Auth::user()->region);
        }])->where("id", $id)->first();*/
        $move = new Relhistorie();
        $move->citerne = $fixe->name;
        $move->stock_theo = $fixe->stock_theo;
        $move->stock_rel = $request->qty;
        $move->ecart = $request->qty - $fixe->stock_theo;
        $move->region = Auth::user()->region;

        $move->save();
        $stock = Vracstock::where("id", $fixe->id)->first();
        $stock->stock_rel = $request->qty;

        $stock->save();
        return back()->withSuccess("success");
    }

    public function depotage(Request $request)
    {
        $request->validate([
            "fixe" => "string | required",
            "mobile" => "string | required",
            "qty" => "numeric |required",
            "matricule" => "string |required"
        ]);
        $fixe = intval($request->fixe);
        $mobile = intval($request->mobile);
        $stock = Vracstock::where("citerne_id", $fixe)->where("region", Auth::user()->region)->with("citerne")->first();
        $capacity = intval($stock->citerne->capacity);
        $qty = intval($request->qty);
        $total = $stock->qty + $qty;
        if ($total < $capacity) {
            $stock->stock_theo = $stock->stock_rel + $request->qty;
            $stock->stock_rel = $stock->stock_theo;
            $stock->save();
        } else {
            return response()->json(["error" => "espace citerne insuffisant"]);
        }
        $move = new Vracmovement();
        $move->citerne_id = $fixe;
        $move->vracstock_id = $stock->id;
        $move->service = Auth::user()->role;
        $move->qty = $request->qty;
        $move->matricule = $request->matricule;
        $move->save();
        return response()->json(["success" => "mouvement enregistre avec success"]);
    }

    public function saveBottleMove(Request $request, $action, $state)
    {
        $request->validate([
            "origin" => "string | required",
            "weight" => "string |required",
            "label" => "string  |required",
            "qty" => "numeric | required",
            "bord" => "required | string"
        ]);
        $state = intval($state);
        $weight = floatval($request->weight);
        $region = Auth::user()->region;
        $service = Auth::user()->role;
        $article = Article::where("type", "=", "bouteille-gaz")->where("weight", "=", $weight)->where("state", "=", $state)->first();
        if ($article) {
            $stock = Stock::where("article_id", "=", $article->id)->where("category", "=", Auth::user()->role)->where("region", "=", $region)->first();


            if ($stock) {
                if ($action == "entry") {
                    $stock->qty = $stock->qty + $request->qty;
                    $stockQty =  $stock->qty;
                    $stock->save();
                    //notify boss
                    $actions = new Action();
                    $actions->description = Auth::user()->name . "[entry] - [{{$request->qty}}] - [{{$article->type}}]- [{{$article->weighy}} KG]";
                    $actions->id_user = Auth::user()->id;
                } else {
                    $stock->qty = $stock->qty - $request->qty;
                    $stockQty =  $stock->qty;
                    if ($stock->qty <= 0) {
                        $stock->qty = 0;
                        $stockQty =  $stock->qty;

                        return response()->json(["message" => "stock negatif operation impossible"]);
                    }
                    $stock->save();

                    //notify boss
                    $actions = new Action();
                    $actions->description = Auth::user()->name . "[outcome] - [{{$request->qty}}] - [{{$article->type}}]- [{{$article->weighy}} KG]";
                    $actions->id_user = Auth::user()->id;
                }
                $move = new Movement();
                $move->article_id = $article->id;
                $move->qty = $request->qty;
                $move->stock_id = $stock->id;
                $move->origin = $request->origin;
                $move->stock = $stockQty;
                $move->bordereau = $request->bord;
                $move->service = $service;
                $move->label = $request->label;
                if ($action == "entry") {
                    $move->entree = 1;
                    $move->sortie = 0;
                } else {

                    $move->entree = 0;
                    $move->sortie = 1;
                }
                $move->save();


                return response()->json(['success' => 'mouvement enregistre avec succes']);
            } else {
                return response()->json(["error" => "stock inexistant"]);
            }
        } else {
            return response()->json(["error" => "stock inexistant"]);
        }
    }

    public function produceGas(Request $request)
    {
        $request->validate([
            "citerne" => "string | required",
            "type" => "string |required",
            "qty" => "numeric | required",
            "bord" => "string | required",
        ]);
        $type = floatval($request->type);
        $move = new Producermove();
        $citerne = Citerne::with(['Stock' => function ($query) {
            $query->where('region', Auth::user()->region);
        }])->where("name", $request->citerne)->first();
        $stockQty = intval($citerne->stock[0]->stock_rel);

        $article = Article::where("weight", $type)->where("state", 0)->with("hasStock")->first();
        $article2 = Article::where("weight", $type)->where("state", 1)->with("hasStock")->first();
        if ($citerne->type == "mobile") {

            $move->id_citerne = $citerne->id;
            $move->type = $type;
            $move->qty = $request->qty;
            $move->bordereau = $request->bord;
            $move->region = Auth::user()->region;
            $citerne->stock[0]->stock_theo = 30000;
            $citerne->stock[0]->stock_rel = 30000;
            $citerne->stock[0]->save();
            $article->hasStock[0]->qty -= $request->qty;
            $article->hasStock[0]->save();
            $article2->hasStock[0]->qty += $request->qty;
            $article2->hasStock[0]->save();
            $move2 = new Movement();
            $move2->article_id = $article2->id;
            $move2->stock_id = $article2->hasStock[0]->id;
            $move2->origin = "production";
            $move2->label = "production de bouteille gaz a partir de citern mobile";
            $move2->entree = 1;
            $move2->sortie = 0;
            $move2->qty = $request->qty;
            $move2->service = Auth::user()->role;
            $move2->bordereau = $request->bord;
            $move2->stock = $article2->hasStock[0]->qty;
            $move2->id_citerne = $request->citerne;
            $move2->save();
            $move->idmove = $move2->id;
            $move->save();
            // $citerne->stock->stock_theo -= $request->qty*$type;
            return response()->json(["success" => "mouvement insere avec success"]);
        }
        if ($stockQty < (intval($request->qty) * floatval($type))) {
            return response()->json(["error" => "stock citerne insuffisant"]);
        }

        $move->id_citerne = $citerne->id;
        $move->type = $type;
        $move->qty = $request->qty;
        $move->bordereau = $request->bord;
        $move->region = Auth::user()->region;
        $citerne->stock[0]->stock_theo = $stockQty - (intval($request->qty) * floatval($type));
        $citerne->stock[0]->stock_rel = $stockQty - (intval($request->qty) * floatval($type));
        $citerne->stock[0]->save();
        //$move->save();

        if ($article) {
            if ($article->hasStock[0]->qty < $request->qty) {
                return response()->json(["error" => "stock insufisant bouteilles vides"]);
            } else {
                $article->hasStock[0]->qty -= $request->qty;
                $article->hasStock[0]->save();
                $article2->hasStock[0]->qty += $request->qty;
                $article2->hasStock[0]->save();
                $move2 = new Movement();
                $move2->article_id = $article2->id;
                $move2->stock_id = $article2->hasStock[0]->id;
                $move2->origin = "production";
                $move2->label = "production de bouteille gaz";
                $move2->entree = 1;
                $move2->sortie = 0;
                $move2->qty = $request->qty;
                $move2->service = Auth::user()->role;
                $move2->bordereau = $request->bord;
                $move2->stock = $article2->hasStock[0]->qty;
                $move2->id_citerne = $request->citerne;
                $move2->save();
                $move->idmove = $move2->id;
                $move->save();
                // $citerne->stock->stock_theo -= $request->qty*$type;
                return response()->json(["success" => "mouvement insere avec success"]);
            }
        } else {
            return response()->json(["error" => "stock inexistant"]);
        }
        //return response()->json(["success"=>"mouvement enregistre avec succes"]);

    }
    public function transmitGas(Request $request)
    {
        $request->validate([
            "state" => "required| string",
            "type" => "required| string",
            "destination" => "required | string",
            "qty" => "required| numeric",
            "bord" => "required | string"
        ]);
        $state = intval($request->state);
        $type = floatval($request->type);
        $article = Article::where("weight", $type)->where("state", $state)->first();
        $stock = Stock::where("article_id", $article->id)->where("region", Auth::user()->region)->where("category", "production")->first();
        $move = new Movement();
        $move->origin = Auth::user()->role;
        $move->article_id = $article->id;
        $move->stock_id = $stock->id;
        $move->label = "production";
        $move->entree = 0;
        $move->sortie = 1;
        $move->qty = $request->qty;
        $move->service = Auth::user()->role;
        $move->bordereau = $request->bord;


        $article = Article::where("state", $state)->where("weight", $type)->with("hasStock")->first();
        if ($article) {
            if ($stock->qty < $request->qty) {
                return response()->json(["error" => "stock insufisant"]);
            } else {
                $move->stock = $stock->qty - $request->qty;
                $move->save();
                $stock->qty -= $request->qty;
                $stock->save();
                return response()->json(["success" => "insersion reussie"]);
            }
        } else {
            return response()->json(["error" => "stock inexistant"]);
        }
    }
    public function showProdHist()
    {
        $stocks = Stock::where("category", "production")->where("region", Auth::user()->region)->get();
        $allvrackstocks = Citerne::all();
        $vracstocks = Citerne::where("type", "mobile")->get();
        $fixe  = Citerne::where("type", "fixe")->get();
        $datas = Producermove::where("region", Auth::user()->region)->get();
        $mobile = Citerne::where("type", "mobile")->get();
        if (Auth::user()->role == "controller") {
            return view("controller.ProdMoves", ["datas" => $datas, "mobile" => $mobile, "fixe" => $fixe, "vrac" => $vracstocks, "all" => $allvrackstocks, "stocks" => $stocks]);
        }
        return view("producer.ProdMoves", ["datas" => $datas, "fixe" => $fixe, "vrac" => $vracstocks, "all" => $allvrackstocks, "stocks" => $stocks]);
    }
    public function ProdHistPDF(Request $request)
    {

        $request->validate([
            "depart" => "date | required",
            "fin" => "date | required",
            "citerne" => "string | required"
        ]);
        $fromDate = $request->depart;
        $toDate = $request->fin;
        $idCitern = intval($request->citerne);
        if ($request->citerne == "global") {
            $datas = Producermove::whereBetween("created_at", [$request->depart, $request->fin])->where("region", Auth::user()->region)->get();
            $pdf = Pdf::loadview("ProductionPdf", ["datas" => $datas, "fromDate" => $fromDate, "toDate" => $toDate]);
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->get_canvas();
            $canvas->page_text(510, 800, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
            return  $pdf->download("historique des production.pdf");
        }
        $datas =  Producermove::where("id_citerne", $idCitern)->whereBetween("created_at", [$request->depart, $request->fin])->get();
        $pdf = Pdf::loadview("ProductionPdf", ["datas" => $datas, "fromDate" => $fromDate, "toDate" => $toDate]);
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(510, 800, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
        return  $pdf->download("historique des production.pdf");
        $datas = Producermove::where("region", Auth::user()->region)->get();
    }
    //modify movements
    public function modifyMove($idMove, Request $request)
    {


        $stocks = Stock::where("category", "production")->where("region", Auth::user()->region)->get();
        $allvrackstocks = Citerne::all();
        $vracstocks = Citerne::where("type", "mobile")->get();
        $fixe  = Citerne::where("type", "fixe")->get();
        $move = Movement::findOrFail($idMove);
        return view("producer.modifMove", ["vrac" => $vracstocks, "stocks" => $stocks, "fixe" => $fixe, "all" => $allvrackstocks, "move" => $move]);
    }
    public function updateMove($idMove, Request $request)
    {
        $request->validate([
            "origin" => "string | required",
            "qty" => "numeric | required",
            "label" => "string | required",
            "bord" => "string | required",
            "stock_qty" => "string | required",
        ]);
        $move = Movement::findOrFail($idMove);
        $move->origin = $request->origin;
        $move->qty = $request->qty;
        $move->label = $request->label;
        $move->bordereau = $request->bord;
        $move->stock = $request->stock_qty;
        $move->save();
        return back()->withSuccess("movement modifié avec succès");
    }
}
