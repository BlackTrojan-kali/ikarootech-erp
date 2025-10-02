<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Broute;
use App\Models\Citerne;
use App\Models\Client;
use App\Models\Movement;
use App\Models\Receive;
use App\Models\Region;
use App\Models\Stock;
use App\Models\Vente;
use App\Models\Versement;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BossController extends Controller
{
    //
    public function index()
    {
        $stocks = Stock::with("article")->where("region", Auth::user()->region)->get();
        $mobile = Citerne::where("type", "mobile")->get();
        $fixe  = Citerne::where("type", "fixe")->get();
        $articles = Article::where("state", 1)->orWhere("type", "accessoire")->get();
        $clients = Client::all();
        $regions = Region::all();
        return view("controller.ControllerDashboard", ["regions"=>$regions,"clientsList" => $clients, "articlesList" => $articles,"stocks" => $stocks, "mobile" => $mobile, "fixe" => $fixe]);
    }

    public function showCiterne()
    {

        $stocks = Stock::where("category", Auth::user()->role)->where("region", Auth::user()->region)->get();
        $fixe  = Citerne::with(["Stock" => function ($query) {
            $query->where("region", Auth::user()->region);
        }])->where("type", "fixe")->get();
        $mobile = Citerne::where("type", "mobile")->get();
        $articles = Article::where("state", 1)->orWhere("type", "accessoire")->get();
        $clients = Client::all();
        $regions = Region::all();
        return view("controller.citerne", ["regions"=>$regions,"clientsList" => $clients, "articlesList" => $articles,"stocks" => $stocks, "fixe" => $fixe, "mobile" => $mobile]);
    }
    public function generate_receive_pdf(Request $request)
    {
        $request->validate([
            "depart" => "date | required",
            "fin" => "date | required",
            "citerne" => "string | required",
            "service" => "string | required"
        ]);
        $fromDate =  Carbon::parse($request->depart)->startOfDay();
        $toDate =  Carbon::parse($request->fin)->endOfDay();
        $idCitern = intval($request->citerne);
        if ($request->citerne == "global") {
            $receive = Receive::whereBetween("created_at", [$fromDate, $toDate])->where("region", Auth::user()->region)->get();
            $pdf = Pdf::loadview("RecievePdf", ["receive" => $receive, "fromDate" => $fromDate, "toDate" => $toDate]);
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->get_canvas();
            $canvas->page_text(510, 800, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
            return  $pdf->download("historique des releves.pdf");
        }
        $receive = Receive::where("id_citerne", $idCitern)->where("receiver", $request->service)->whereBetween("created_at", [$request->depart, $request->fin])->with("citerne")->get();

        $pdf = Pdf::loadview("RecievePdf", ["receive" => $receive, "fromDate" => $fromDate, "toDate" => $toDate]);
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(510, 800, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
        return  $pdf->download("historique des receptions.pdf", ["region" => Auth::user()->region]);
    }

    public function generate_sale_state(Request $request)
    {
        $request->validate(
            [
                "depart" => "date | required",
                "fin" => "date | required",
                "name" => "string | nullable",
                "sale" => "string |required",
            ]
        );
        $fromDate = Carbon::parse($request->depart)->startOfDay();
        $toDate = Carbon::parse($request->fin)->endOfDay();
        if ($request->name) {

            $sales = Vente::whereBetween("created_at", [$fromDate, $toDate])->where("type", $request->sale)->where("region", Auth::user()->region)->where("customer", $request->customer)->get();
        } else {
            $sales = Vente::whereBetween("created_at", [$fromDate, $toDate])->where("type", $request->sale)->where("region", Auth::user()->region)->get();
        }
        $pdf = Pdf::loadview("salesPdf", ["fromDate" => $fromDate, "toDate" => $toDate, "sales" => $sales, "type" => $request->sale]);
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(510, 800, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
        return $pdf->download(Auth::user()->role . "" . $request->region . $fromDate . $toDate . ".pdf");
    }

    public function generate_versements_state(Request $request)
    {
        $request->validate(
            [
                "depart" => "date | required",
                "fin" => "date | required",
                "bank" => "string | required ",
                "service" => "string | required",
            ]
        );
        $fromDate = Carbon::parse($request->depart)->startOfDay();
        $toDate = Carbon::parse($request->depart)->startOfDay();
        if ($request->bank == "all") {
            $afb = Versement::where("bank", env("COMPANIE_BANK_1"))->where("region", Auth::user()->region)->where("service", $request->service)->whereBetween("created_at", [$fromDate, $toDate])->with("Invoice")->get();
            $cca = Versement::where("bank", env("COMPANIE_BANK_2"))->where("region", Auth::user()->region)->where("service", $request->service)->whereBetween("created_at", [$fromDate, $toDate])->with("Invoice")->get();
            $caisse = Versement::where("bank", "CAISSE")->where("region", Auth::user()->region)->where("service", Auth::user()->role)->whereBetween("created_at", [$fromDate, $toDate])->with("Invoice")->get();
          
            $pdf = Pdf::loadview("versementPdfAll", ["fromDate" => $fromDate, "toDate" => $toDate, "afb" => $afb, "cca" => $cca, "bank" => $request->bank,"caisse"=>$caisse])->setPaper("A4", 'landscape');
          
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->get_canvas();
            $canvas->page_text(720, 550, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
            return $pdf->download($request->role . "versementsglobal" . Auth::user()->region . $fromDate . $toDate . $request->bank . ".pdf");
        } else {
            $deposit = Versement::where("bank", $request->bank)->where("region", Auth::user()->region)->where("service", $request->service)->whereBetween("created_at", [$fromDate, $toDate])->get();
            $pdf = Pdf::loadview("versementPdf", ["fromDate" => $fromDate, "toDate" => $toDate, "deposit" => $deposit, "bank" => $request->bank]);

            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->get_canvas();
            $canvas->page_text(510, 800, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
            return $pdf->download(Auth::user()->role . "versements" . Auth::user()->region . $fromDate . $toDate . $request->bank . ".pdf");
        }
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
        "origin" => "nullable |string",
    ]);

    $fromdate = Carbon::parse($request->depart)->startOfDay();
    $todate = Carbon::parse($request->fin)->endOfDay();
    $first = null;
    $region = Auth::user()->region;
    $service = $request->service;
    $data = collect();
    $data2 = collect(); // Initialisation
    // Initialisation du filtre 'origin' (closure pour la réutilisation)
    $applyOriginFilter = function ($query) use ($request) {
        if ($request->origin) {
            $query->where("movements.origin", $request->origin);
        }
        return $query;
    };
    // ---

    // CAS ACCESSOIRE ("777")
    if ($request->type == "777") {
        
        $baseAccessoryQuery = Movement::join("articles", "movements.article_id", "articles.id")
                                      ->join("stocks", "movements.stock_id", "stocks.id")
                                      ->where("movements.service", $service)
                                      ->where("stocks.region", $region)
                                      ->where("articles.type", "accessoire")
                                      ->with("fromArticle")
                                      ->select("movements.*");

        if ($request->move == "777") {
            // Requête data: sans filtre de date (historique initial) - Logique maintenue
            $queryData = clone $baseAccessoryQuery;
            
            // Requête data2: avec filtre de date
            $queryData2 = clone $baseAccessoryQuery;
            $queryData2->whereBetween("movements.created_at", [$fromdate, $todate]);
            
            // FILTRAGE CONDITIONNEL PAR ORIGIN (Appliqué après le clonage)
            $queryData = $applyOriginFilter($queryData);
            $queryData2 = $applyOriginFilter($queryData2);
            
            $data = $queryData->orderBy("id")->get();
            $data2 = $queryData2->orderBy("id")->get();

        } else {
            // Cas où move est spécifié (pas "777")
            $queryData = clone $baseAccessoryQuery;
            $queryData->whereBetween("movements.created_at", [$fromdate, $todate])
                      ->where("movements.entree", $request->move);
            
            // FILTRAGE CONDITIONNEL PAR ORIGIN
            $queryData = $applyOriginFilter($queryData);

            $data = $queryData->orderBy("id")->get();
        }
    } 
    
    // ---

    // CAS BOUTEILLE-GAZ (type != "777")
    else {
        // Base de la requête pour les bouteilles-gaz
        $queryGasBase = Movement::leftJoin("articles", "movements.article_id", "articles.id")
                                ->leftJoin("stocks", "movements.stock_id", "stocks.id")
                                ->whereBetween("movements.created_at", [$fromdate, $todate])
                                ->where("movements.service", $service)
                                ->where("stocks.region", $region)
                                ->where("articles.type", "bouteille-gaz")
                                ->where("articles.weight", floatval($request->type))
                                ->with("fromArticle")
                                ->select("movements.*");
        
        if ($request->move == "777") {
            // Tous les mouvements de bouteilles-gaz (pleines et vides)
            
            // Requête data: Pleines (articles.state = 1)
            $queryData = clone $queryGasBase;
            $queryData->where("articles.state", 1);

            // Requête data2: Vides (articles.state = 0)
            $queryData2 = clone $queryGasBase;
            $queryData2->where("articles.state", 0);
            
            // FILTRAGE CONDITIONNEL PAR ORIGIN
            $queryData = $applyOriginFilter($queryData);
            $queryData2 = $applyOriginFilter($queryData2);

            $data = $queryData->orderBy("id")->get();
            $data2 = $queryData2->orderBy("id")->get();

            if ($data->isEmpty() && $data2->isEmpty()) {
                return back()->withErrors("aucune donnee disponible");
            }
            // Utiliser $data->first() ou $data2->first() pour obtenir $first
            if (!$data->isEmpty()) {
                $first = $data->first()->fromArticle;
            } elseif (!$data2->isEmpty()) {
                $first = $data2->first()->fromArticle;
            }

        } else {
            // Mouvements spécifiques (entree ou sortie)
            $queryData = clone $queryGasBase;
            $queryData->where("articles.state", $request->state) // state (pleine/vide)
                      ->where("movements.entree", intval($request->move)); // move (entree/sortie)
            
            // FILTRAGE CONDITIONNEL PAR ORIGIN
            $queryData = $applyOriginFilter($queryData);

            $data = $queryData->orderBy("id")->get();
            
            if ($data->isEmpty()) {
                return back()->withErrors("aucune donnee disponible");
            }
            $first = $data->first()->fromArticle;
        }
    }

    // ---
    // GÉNÉRATION PDF (inchangée)
    if ($request->move == "777") {
        $pdf = Pdf::loadview("pdfGlobalFile", [
            "bouteille_vides" => $data2, 
            "bouteille_pleines" => $data, 
            "service" => $service, 
            "region" => $region, 
            "first" => $first, 
            "fromdate" => $fromdate, 
            "todate" => $todate,
        ])->setPaper("A4", 'landscape');

        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(720, 550, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
        return $pdf->download($service . $region . $fromdate->toDateString() . $todate->toDateString() . "GLOBAL.pdf");
    } else {
        $pdf = Pdf::loadview("pdfFile", [
            "data" => $data, 
            "fromdate" => $fromdate, 
            "todate" => $todate, 
            "first" => $first, 
            "service" => $service, 
            "region" => $region
        ]);

        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(510, 800, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
        return $pdf->download($service . $region . $fromdate->toDateString() . $todate->toDateString() . ".pdf");
    }
}
    public function show_broute_list()
    {
        $broutes = Broute::where("region", Auth::user()->region)->get();

        $stocks = Stock::with("article")->where("region", Auth::user()->region)->get();
        $mobile = Citerne::where("type", "mobile")->get();
        $fixe  = Citerne::where("type", "fixe")->get();
        $articles = Article::where("state", 1)->orwhere("type", "accessoire")->get();
        $clients = Client::where("region",Auth::user()->region)->get();
        $regions= Region::all();
        return view("controller.list-broute", ["regions"=>$regions,"clientsList" => $clients,"articlesList" => $articles,"broutes" => $broutes, "stocks" => $stocks, "mobile" => $mobile, "fixe" => $fixe]);
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

    //new sales state pdf
    
}
