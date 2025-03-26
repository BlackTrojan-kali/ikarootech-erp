<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Article;
use App\Models\Broute;
use App\Models\Citerne;
use App\Models\Stock;
use App\Models\Movement;
use App\Models\Receive;
use App\Models\Vracstock;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MagazinierController extends Controller
{
    //
    public function show(Request $request)
    {

        $categorie = Auth::user()->role;

        $stocks = Stock::where("region", "=", Auth::user()->region)->where("category", "=", $categorie)->with("article")->get();
        $accessories = Article::where("type", "=", "accessoire")->get("title");
        $vracstocks = Citerne::where("type", "mobile")->get();

        $mobile = Citerne::where("type", "mobile")->get();
        $fixe  = Citerne::where("type", "fixe")->get();
        return view('manager.dashboard', ["stocks" => $stocks, "accessories" => $accessories, "vrac" => $vracstocks, "fixe" => $fixe, "mobile" => $mobile]);
    }
    public function showmove(Request $request)
    {
        return  view("manager.moveActions");
    }
    public function showTypeChoice(Request $request, $action)
    {
        if ($action == "entry") {
            return view("manager.MovetypeAdd", ["action" => $action]);
        } else {
            return view("manager.MovetypeAdd", ["action" => $action]);
        }
    }


    public function registerAction(Request $request, $action, $type)
    {
        if ($type == "bouteille-gaz") {

            return view("manager.registerBottleGaz", ["action" => $action]);
        } elseif ($type == "accessiore") {
            $articles = Article::where("type", "=", "accessoire");
            return view("manager.registerAccessory", ["action" => $action]);
        }
    }
    public function showHistory(Request $request)
    {
        $accessories = Article::where("type", "=", "accessoire")->get("title");
        $allMoves = Movement::with("fromStock", "fromArticle")->where("entree", 1)->where("service", Auth::user()->role)->orderBy("created_at", "DESC")->get();
        $allMovesOut = Movement::with("fromStock", "fromArticle")->where("sortie", 1)->where("service", Auth::user()->role)->orderBy("created_at", "DESC")->get();
        $vracstocks = Citerne::where("type", "mobile")->get();
        $mobile = Citerne::where("type", "mobile")->get();
        $fixe  = Citerne::where("type", "fixe")->get();
        return view("manager.history", ["accessories" => $accessories, "allMoves" => $allMoves, "allMovesOut" => $allMovesOut, "vrac" => $vracstocks, "fixe" => $fixe, "mobile" => $mobile]);
    }
    public function showfilteredHistory(Request $request)
    {
        $request->validate([
            "fromdate" => "date|required",
            "todate" => "date|required",
            "type" => "string|required"
        ]);
        $fromdate = /*Carbon::createFromFormat("Y-m-d",*/ $request->fromdate; //)->toString();
        $todate = /*Carbon::createFromFormat("Y-m-d",$request->*/ $request->todate; //)->toString();
        $accessories = Article::where("type", "=", "accessoire")->where("service", Auth::user()->role)->get("title");
        $mobile = Citerne::where("type", "mobile")->get();
        if ($request->type == "boutielles-pleines") {
            $type = "bouteille-gaz";
            $state = 1;
        } elseif ($request->type == "bouteilles-vides") {
            $type = "bouteille-gaz";
            $state = 0;
        } else {
            $type = "accessoire";
            $state = 0;
        }
        $allMoves = Movement::join("articles", "movements.article_id", "=", "articles.id")->whereBetween("movements.created_at", [$fromdate, $todate])->where("movements.entree", 1)->where("service", Auth::user()->role)->where("articles.type", $type)->where("articles.state", $state)->select("movements.*")->get();

        $allMovesOut = Movement::join("articles", "movements.article_id", "=", "articles.id")->whereBetween("movements.created_at", [$fromdate, $todate])->where("articles.type", $type)->where("movements.entree", 0)->where("articles.state", $state)->where("service", Auth::user()->role)->select("movements.*")->get();
        $vracstocks = Citerne::where("type", "mobile")->get();

        $fixe  = Citerne::where("type", "fixe")->get();
        return view("manager.history", ["accessories" => $accessories, "vrac" => $vracstocks, "mobilce" => $mobile, "allMoves" => $allMoves, "allMovesOut" => $allMovesOut, "fixe" => $fixe]);
    }
    public function saveBottleMove(Request $request, $action, $state)
    {
        $request->validate([
            "origin" => "string | required",
            "weight" => "string |required",
            "label" => "string | |required",
            "qty" => "numeric | required  ",
            "bord" => "string | required "
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
                    if ($stock->qty < 0) {
                        $stock->qty = 0;

                        $stockQty =  $stock->qty;

                        return response()->json(["error" => "stock negatif operation impossible"]);
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
                $move->bordereau = $request->bord;
                $move->stock_id = $stock->id;
                $move->origin = $request->origin;
                $move->stock = $stockQty;
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
    //delete move

    public function deleteMove($id, Request $request)
    {
        $move = Movement::findOrFail($id);
        $stock = Stock::findOrFail($move->stock_id);

        if ($move->entree == 1) {
            $stock->qty -= $move->qty;
            if ($stock->qty < 0) {

                return response()->json(["message" => "stock negatif operation impossible"]);
            }
            $stock->save();
        } else if ($move->sortie == 1) {
            $stock->qty += $move->qty;
            $stock->save();
        }
        if ($move->label == "vente" || $move->label == "consigne") {

            return response()->json(["message" => "supprimer d'abord la vente "]);
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
    //SAVE ACCESSORIES
    public function saveAccessoryMoves(Request $request, $action)
    {
        $request->validate([
            "title" => "string |required",
            "qty" => "numeric | required",
            "operation" => "string | required",
            "label" => "string | max:250 |required",
            "bord" => "string | required"
        ]);
        $article = Article::where("title", "=", $request->title)->where("type", "=", "accessoire")->first();
        if ($article) {

            $stock = Stock::where("article_id", "=", $article->id)->where("category", "=", Auth::user()->role)->where("region", "=", Auth::user()->region)->first();

            if ($stock) {
                if ($action == "entry") {
                    $stock->qty = $stock->qty + $request->qty;

                    $stockQty = $stock->qty;
                    $stock->save();
                } else {
                    $stock->qty = $stock->qty - $request->qty;

                    $stockQty = $stock->qty;
                    if ($stock->qty <= 0) {
                        $stock->qty = 0;

                        return response()->json(["message" => "stock negatif operation impossible"]);
                        $stockQty = $stock->qty;
                    }
                    $stock->save();
                }


                $move = new Movement();
                $move->article_id = $article->id;
                $move->qty = $request->qty;
                $move->stock = $stockQty;
                $move->stock_id = $stock->id;
                $move->origin = $request->operation;
                $move->bordereau = $request->bord;
                $move->service = Auth::user()->role;
                $move->label = $request->label;
                if ($action == "entry") {
                    $move->entree = 1;
                    $move->sortie = 0;
                } else {

                    $move->entree = 0;
                    $move->sortie = 1;
                }
                $move->save();


                return response()->json(["success" => "mouvement enregistre avec succes"]);
            }
        } else {
            return response()->json(["error" => "stock inexistant"]);
        }
    }
    //generate broute pdf
    public function generateBroutePDF(Request $request)
    {
        $request->validate([
            "matricule" => "string | min:4 | required",
            "depart" => "string |min:2| required",
            "arrivee" => "string |min:2 |",
            "date_depart" => "date | required",
            "date_arrivee" => "date | required",
            "nom_chauffeur" => "string | min :2 | required",
            "permis" => "string | min :2 | required",
            "aide_chauffeur" => "string | min :2 ",
            "contact" => "string | min:4 |required",
            "details" => "string | min:4 |required",

        ]);
        $broute = new Broute();
        $broute->matricule = $request->matricule;
        $broute->depart = $request->depart;
        $broute->arrivee = $request->arrivee;
        $broute->region = Auth::user()->region;
        $broute->date_depart = $request->date_depart;
        $broute->date_arrivee = $request->date_arrivee;
        $broute->nom_chauffeur = $request->nom_chauffeur;
        $broute->permis = $request->permis;
        $broute->aide_chauffeur = $request->aide_chauffeur;
        $broute->contact = $request->contact;
        $broute->details = $request->details;
        $broute->save();

        $pdf = Pdf::loadview("manager.broute", ["broute" => $broute]);
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(510, 800, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));

        return $pdf->download($broute->nom_chauffeur . $broute->region . $broute->created_at . ".pdf");
    }
    public function show_broute_list()
    {
        $broutes = Broute::where("region", Auth::user()->region)->get();
        $categorie = Auth::user()->role;

        $stocks = Stock::where("region", "=", Auth::user()->region)->where("category", "=", $categorie)->with("article")->get();
        $accessories = Article::where("type", "=", "accessoire")->get("title");
        $vracstocks = Citerne::where("type", "mobile")->get();

        $mobile = Citerne::where("type", "mobile")->get();
        $fixe  = Citerne::where("type", "fixe")->get();
        return view("manager.list-broute", ["broutes" => $broutes, "stocks" => $stocks, "accessories" => $accessories, "vrac" => $vracstocks, "fixe" => $fixe, "mobile" => $mobile]);
    }
    public function BroutePDF(Request $request, $idRoute)
    {
        $broute = Broute::findOrFail($idRoute);
        $pdf = Pdf::loadView("manager.broute", ["broute" => $broute]);

        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(510, 800, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
        return $pdf->download($broute->nom_chauffeur . $broute->created_at . ".pdf");
    }
    public function deleteBroute($idRoute)
    {
        $broute = Broute::findOrFail($idRoute);
        $broute->delete();
        return response()->json(["message" => "element supprime avec succes"]);
    }
    //modify movements
    public function modifyMove($idMove, Request $request)
    {


        $categorie = Auth::user()->role;

        $stocks = Stock::where("region", "=", Auth::user()->region)->where("category", "=", $categorie)->with("article")->get();
        $accessories = Article::where("type", "=", "accessoire")->get("title");
        $vracstocks = Citerne::where("type", "mobile")->get();

        $mobile = Citerne::where("type", "mobile")->get();
        $fixe  = Citerne::where("type", "fixe")->get();
        $move = Movement::findOrFail($idMove);
        return view("manager.modifMove", ["stocks" => $stocks, "accessories" => $accessories, "vrac" => $vracstocks, "fixe" => $fixe, "mobile" => $mobile, "move" => $move]);
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
