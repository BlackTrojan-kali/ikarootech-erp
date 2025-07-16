<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Citerne;
use App\Models\Movement;
use App\Models\Stock;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Region;
use App\Models\Role;
use App\Models\Vracstock;
use App\Models\Relhistorie;
use App\Models\Articlefamily;
use Carbon\Carbon;

class ArticleController extends Controller
{
    //
    public function show(Request $request)
    {
        $articles = Article::all();
        $families = Articlefamily::all();
        return view("super.article_list", ["articles" => $articles,"families"=>$families ]);
    }
    public function insert(Request $request)
    {
        $families = Articlefamily::all();
        return view("super.addArticle",["families"=>$families]);
    }
    public function insertAcc(Request $request)
    {
        $families = Articlefamily::all();
        return view("super.addAccessory",["families"=>$families]);
    }

    //NEW ADD ARTICLE FAMILY
    public function add_article_family(Request $request){
        return view("super.add_family");
    }
    public function insert_article_family(Request $request){
        $request->validate([
            "name"=>"required| string"
        ]);
        $family = new Articlefamily();
        $family->name = $request->name;
        $family->save();
        return back()->withSuccess("Article family inserted successfully");
    }
    public function delete_article_family($id){
        $family = Articlefamily::findOrFail($id);
        $family->delete();
        return response()->json(["message"=>"family deleted successfully"]);
    }
    public function generatePdf(Request $request)
    {
        $request->validate([
            "depart" => "date | required",
            "fin" => "date | required",
            "state" => "string | required",
            "move" => "string| required",
            "type" => "string | required",
            "service" => "required | string",
        ]);
        $fromdate = Carbon::parse($request->depart)->startOfDay();
        $todate = Carbon::parse($request->fin)->endOfDay();
        $first = null;
        $region = Auth::user()->region;
        $service = $request->service;
        if ($request->type == "777") {
            if ($request->move == "777") {
                $data  = Movement::join("articles", "movements.article_id", "articles.id")->where("movements.service", $request->service)->where("stocks.region", Auth::user()->region)->where("article.type", "accessoire")->with("fromArticle")->select("movements.*")->orderBy("id")->get();
                $data2  = Movement::join("articles", "movements.article_id", "articles.id")->join("stocks", "movements.stock_id", "stocks.id")->whereBetween("movements.created_at", [$fromdate, $todate])->where("movements.service", $request->service)->where("stocks.region", Auth::user()->region)->where("article.type", "accessoire")->with("fromArticle")->select("movements.*")->orderBy("id")->get();
            } else {
                $data  = Movement::join("articles", "movements.article_id", "articles.id")->join("stocks", "movements.stock_id", "stocks.id")->whereBetween("movements.created_at", [$fromdate, $todate])->where("movements.entree", $request->move)->where("movements.service", $request->service)->where("stocks.region", Auth::user()->region)->where("article.type", "accessoire")->with("fromArticle")->select("movements.*")->orderBy("id")->get();
            }
        } else {
            if ($request->move == "777") {
                $data  = Movement::leftjoin("articles", "movements.article_id", "articles.id")->leftjoin("stocks", "movements.stock_id", "stocks.id")->whereBetween("movements.created_at", [$fromdate, $todate])->where("movements.service", $request->service)->where("stocks.region", Auth::user()->region)->where("articles.type", "bouteille-gaz")->where("articles.weight", floatval($request->type))->where("articles.state", 1)->with("fromArticle")->select("movements.*")->orderBy("id")->get();
                $data2  = Movement::leftjoin("articles", "movements.article_id", "articles.id")->leftjoin("stocks", "movements.stock_id", "stocks.id")->whereBetween("movements.created_at", [$fromdate, $todate])->where("movements.service", $request->service)->where("stocks.region", Auth::user()->region)->where("articles.type", "bouteille-gaz")->where("articles.weight", floatval($request->type))->where("articles.state", 0)->with("fromArticle")->select("movements.*")->orderBy("id")->get();

                if (!empty($data[0])) {
                    $first = $data[0]->fromArticle;
                } else {
                    return back()->withErrors("aucune donnee disponible");
                }
            } else {
                $data  = Movement::leftjoin("articles", "movements.article_id", "articles.id")->leftjoin("stocks", "movements.stock_id", "stocks.id")->whereBetween("movements.created_at", [$request->depart, $request->fin])->where("movements.service", $request->service)->where("stocks.region", Auth::user()->region)->where("articles.type", "bouteille-gaz")->where("articles.state", $request->state)->where("articles.weight", floatval($request->type))->where("movements.entree", intval($request->move))->with("fromArticle")->select("movements.*")->orderBy("id")->get();

                if (!empty($data[0])) {
                    $first = $data[0]->fromArticle;
                } else {
                    return back()->withErrors("aucune donnee disponible");
                }
            }
        }
        if ($request->move == "777") {
            $pdf = Pdf::loadview("pdfGlobalFile", ["bouteille_vides" => $data2, "bouteille_pleines" => $data, "service" => $service, "region" => $region, "first" => $first, "fromdate" => $fromdate, "todate" => $todate,])->setPaper("A4", 'landscape');

            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->get_canvas();
            $canvas->page_text(720, 550, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
            return $pdf->download($service . $region . $fromdate . $todate . "GLOBAL.pdf");
        } else {
            $pdf = Pdf::loadview("pdfFile", ["data" => $data, "fromdate" => $fromdate, "todate" => $todate, "first" => $first, "service" => $service, "region" => $region]);

            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->get_canvas();
            $canvas->page_text(510, 800, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
            return $pdf->download($service . $region . $fromdate . $todate . ".pdf");
        }
    }
    public function choose(Request $request)
    {
        return view("super.choseProductType");
    }
    public function delete(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return response()->json(["message" => "element supprime avec succes"]);
    }

    public function MoveGlobal(Request $request, $type, $weight)
    {
        $stocks = Stock::where("region", "=", Auth::user()->region)->where("category", Auth::user()->role)->with("article")->get();
        $accessories = Article::where("type", "=", "accessoire")->get("title");
        $articles  = Movement::join("articles", "movements.article_id", "articles.id")->leftjoin("stocks", "movements.stock_id", "stocks.id")->where("articles.type", $type)->where("articles.state", 1)->where("articles.weight", $weight)->where("stocks.region", Auth::user()->region)->where("movements.service", Auth::user()->role)->select("movements.*", "articles.*")->get();
        $articles1  = Movement::join("articles", "movements.article_id", "articles.id")->leftjoin("stocks", "movements.stock_id", "stocks.id")->where("articles.type", $type)->where("articles.state", 0)->where("articles.weight", $weight)->where("stocks.region", Auth::user()->region)->where("movements.service", Auth::user()->role)->select("movements.*", "articles.*")->get();
        $vracstocks = Citerne::where("type", "mobile")->get();
        $allvrackstocks = Citerne::all();
        $fixe  = Citerne::where("type", "fixe")->get();
        $mobile = Citerne::where("type", "mobile")->get();
        switch (Auth::user()->role) {
            case "commercial":
                return view("commercial.moveGlobalCom", ["bouteille_pleines" => $articles, "bouteille_vides" => $articles1, "accessories" => $accessories, "stocks" => $stocks, "weight" => $weight]);
                break;
            case "production":
                return view("producer.moveGlobalPro", ["bouteille_pleines" => $articles, "bouteille_vides" => $articles1, "vrac" => $vracstocks, "stocks" => $stocks, "fixe" => $fixe, "all" => $allvrackstocks, "weight" => $weight]);
                break;
            case "magasin":
                return view("manager.moveGlobalMan", ["mobile" => $mobile, "bouteille_pleines" => $articles, "bouteille_vides" => $articles1, "accessories" => $accessories, "stocks" => $stocks, "vrac" => $vracstocks, "fixe" => $fixe, "weight" => $weight]);
                break;
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            "title" => "string| required",
            "poids" => "numeric|required",
            "state" => "string|max:1",
            "unity"=>"string|required",
            "family"=>"string|nullable",
            "type" => "string|required"
        ]);
        $type = $request->type;
        $weight = floatval($request->poids);
        $state = intval($request->state);
        if ($type == "bouteille-gaz") {
            $acticles = Article::where("weight", "=", $weight)->where("state", "=", $state)->get();
            if (count($acticles) >= 1) {
                return back()->withErrors(["message" => "article existe deja"]);
            }

            $article = new Article();
            $article->title = $request->title;
            $article->weight = $weight;
            $article->state = $state;
            $article->unity = $request->unity;
            $article->family = 
            $article->type = $type;
            $article->save();
        
            /*   
        $stock = new Stock();
        $stock->qty = 0;
        $stock->type = $article->type;
        $stock->region = "centre";
        $stock->category = "magasin";
        $article->hasStock()->save($stock);
        
        $stock2 = new Stock();
        $stock2->qty = 0;
        $stock2->type = $article->type;
        $stock2->region = "centre";
        $stock2->category = "production";
        $article->hasStock()->save($stock2);
     
        $stock8 = new Stock();
        $stock8->qty = 0;
        $stock8->type = $article->type;
        $stock8->region = "centre";
        $stock8->category = "commercial";
        $article->hasStock()->save($stock8);
     
        $stock3 = new Stock();
        $stock3->qty = 0;
        $stock3->type = $article->type;
        $stock3->region="ouest";
        $stock3->category ="commercial";
        $article->hasStock()->save($stock3);

        $stock4 = new Stock();
        $stock4->qty = 0;
        $stock4->type = $article->type;
        $stock4->region="littoral";
        $stock4->category ="commercial";
        $article->hasStock()->save($stock4);

        $stock5 = new Stock();
        $stock5->qty = 0;
        $stock5->type = $article->type;
        $stock5->region="sud";
        $stock5->category ="commercial";
        $article->hasStock()->save($stock5);

        $stock6 = new Stock();
        $stock6->qty = 0;
        $stock6->type = $article->type;
        $stock6->region="est";
        $stock6->category ="commercial";
        $article->hasStock()->save($stock6);

        $stock7 = new Stock();
        $stock7->qty = 0;
        $stock7->type = $article->type;
        $stock7->region="nord";
        $stock7->category ="commercial";
        $article->hasStock()->save($stock7);
    */


            return back()->withSuccess("article insere avec succes");
        } else {
            $articles = Article::where("title", "=", $request->title)->get();
            $state = 0;
            $weight = 0;
            if (count($articles) >= 1) {
                return back()->withErrors(["message" => "article existe deja"]);
            }
            $article = new Article();
            $article->title = $request->title;
            $article->weight = $weight;
            $article->state = $state;
            $article->family = $request->family;
            $article->unity = $request->unity;
            $article->type = $type;
            $article->save();
      
            /*
        $stock = new Stock();
        $stock->qty = 0;
        $stock->type = $article->type;
        $stock->region = "centre";
        $stock->category = "magasin";
        $article->hasStock()->save($stock);     
     
        $stock8 = new Stock();
        $stock8->qty = 0;
        $stock8->type = $article->type;
        $stock8->region = "centre";
        $stock8->category = "commercial";
        $article->hasStock()->save($stock8);
     
        $stock3 = new Stock();
        $stock3->qty = 0;
        $stock3->type = $article->type;
        $stock3->region="ouest";
        $stock3->category ="commercial";
        $article->hasStock()->save($stock3);

        $stock4 = new Stock();
        $stock4->qty = 0;
        $stock4->type = $article->type;
        $stock4->region="littoral";
        $stock4->category ="commercial";
        $article->hasStock()->save($stock4);

        $stock5 = new Stock();
        $stock5->qty = 0;
        $stock5->type = $article->type;
        $stock5->region="sud";
        $stock5->category ="commercial";
        $article->hasStock()->save($stock5);

        $stock6 = new Stock();
        $stock6->qty = 0;
        $stock6->type = $article->type;
        $stock6->region="est";
        $stock6->category ="commercial";
        $article->hasStock()->save($stock6);

        $stock7 = new Stock();
        $stock7->qty = 0;
        $stock7->type = $article->type;
        $stock7->region="nord";
        $stock7->category ="commercial";
        $article->hasStock()->save($stock7);
        
*/

            return back()->withSuccess("article insere avec succes");
        }
    }
    public function ModifyTheo(Request $request, $id)
    {
        $accessories = Article::where("type", "=", "accessoire")->get("title");
        $allMoves = Movement::with("fromStock", "fromArticle")->where("entree", 1)->where("service", Auth::user()->role)->orderBy("created_at", "DESC")->get();
        $allMovesOut = Movement::with("fromStock", "fromArticle")->where("sortie", 1)->where("service", Auth::user()->role)->orderBy("created_at", "DESC")->get();
        $vracstocks = Citerne::where("type", "mobile")->get();

        $fixe  = Citerne::where("type", "fixe")->get();
        $citerne = Citerne::where("id", $id)->with("stock")->first();
        $mobile = Citerne::where("type", "mobile")->get();
        return view("ModifStock", ["mobile" => $mobile, "citerne" => $citerne, "accessories" => $accessories, "allMoves" => $allMoves, "allMovesOut" => $allMovesOut, "vrac" => $vracstocks, "fixe" => $fixe, "citerne" => $citerne]);
    }
    public function postModif(Request $request, $id)
    {
        $request->validate([
            "qty" => "numeric | required",
        ]);
        $citerne = Vracstock::join("citernes", "citernes.id", "vracstocks.citerne_id")->where("citernes.id", $id)->where("vracstocks.region", Auth::user()->region)->select("vracstocks.*", "citernes.name")->first();

        $citerne->stock_theo = $request->qty;
        $citerne->save();

        $move = new Relhistorie();
        $move->citerne = $citerne->name;
        $move->stock_theo = $request->qty;
        $move->stock_rel = $citerne->stock_rel;
        $move->ecart = $request->qty - $citerne->stock_theo;
        $move->region = Auth::user()->region;
        $move->save();
        return back()->withSuccess("stock theorique modifie avec succes");
    }
}
