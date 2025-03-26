<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Broute;
use App\Models\Citerne;
use App\Models\Movement;
use App\Models\Receive;
use App\Models\Stock;
use App\Models\Vente;
use App\Models\Versement;
use Barryvdh\DomPDF\Facade\Pdf;
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
        return view("controller.ControllerDashboard", ["stocks" => $stocks, "mobile" => $mobile, "fixe" => $fixe]);
    }

    public function showCiterne()
    {

        $stocks = Stock::where("category", Auth::user()->role)->where("region", Auth::user()->region)->get();
        $fixe  = Citerne::with(["Stock" => function ($query) {
            $query->where("region", Auth::user()->region);
        }])->where("type", "fixe")->get();
        $mobile = Citerne::where("type", "mobile")->get();


        return view("controller.citerne", ["stocks" => $stocks, "fixe" => $fixe, "mobile" => $mobile]);
    }
    public function generate_receive_pdf(Request $request)
    {
        $request->validate([
            "depart" => "date | required",
            "fin" => "date | required",
            "citerne" => "string | required",
            "service" => "string | required"
        ]);
        $fromDate = $request->depart;
        $toDate = $request->fin;
        $idCitern = intval($request->citerne);
        if ($request->citerne == "global") {
            $receive = Receive::whereBetween("created_at", [$request->depart, $request->fin])->where("region", Auth::user()->region)->get();
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
        $fromDate = $request->depart;
        $toDate = $request->fin;
        if ($request->name) {

            $sales = Vente::whereBetween("created_at", [$request->depart, $request->fin])->where("type", $request->sale)->where("region", Auth::user()->region)->where("customer", $request->customer)->get();
        } else {
            $sales = Vente::whereBetween("created_at", [$request->depart, $request->fin])->where("type", $request->sale)->where("region", Auth::user()->region)->get();
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
        $fromDate = $request->depart;
        $toDate = $request->fin;
        if ($request->bank == "all") {
            $afb = Versement::where("bank", env("COMPANIE_BANK_1"))->where("region", Auth::user()->region)->where("service", $request->service)->whereBetween("created_at", [$fromDate, $toDate])->get();
            $cca = Versement::where("bank", env("COMPANIE_BANK_2"))->where("region", Auth::user()->region)->where("service", $request->service)->whereBetween("created_at", [$fromDate, $toDate])->get();
            $pdf = Pdf::loadview("versementPdfAll", ["fromDate" => $fromDate, "toDate" => $toDate, "afb" => $afb, "cca" => $cca, "bank" => $request->bank])->setPaper("A4", 'landscape');

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
        ]);
        $fromdate = $request->depart;
        $todate = $request->fin;
        $first = null;
        $region = Auth::user()->region;
        $service = $request->service;
        if ($request->type == "777") {
            if ($request->move == "777") {
                $data  = Movement::join("articles", "movements.article_id", "articles.id")->where("movements.service", $request->service)->where("stocks.region", Auth::user()->region)->where("article.type", "accessoire")->with("fromArticle")->select("movements.*")->orderBy("id")->get();
                $data2  = Movement::join("articles", "movements.article_id", "articles.id")->join("stocks", "movements.stock_id", "stocks.id")->whereBetween("movements.created_at", [$request->depart, $request->fin])->where("movements.service", $request->service)->where("stocks.region", Auth::user()->region)->where("article.type", "accessoire")->with("fromArticle")->select("movements.*")->orderBy("id")->get();
            } else {
                $data  = Movement::join("articles", "movements.article_id", "articles.id")->join("stocks", "movements.stock_id", "stocks.id")->whereBetween("movements.created_at", [$request->depart, $request->fin])->where("movements.entree", $request->move)->where("movements.service", $request->service)->where("stocks.region", Auth::user()->region)->where("article.type", "accessoire")->with("fromArticle")->select("movements.*")->orderBy("id")->get();
            }
        } else {
            if ($request->move == "777") {
                $data  = Movement::leftjoin("articles", "movements.article_id", "articles.id")->leftjoin("stocks", "movements.stock_id", "stocks.id")->whereBetween("movements.created_at", [$request->depart, $request->fin])->where("movements.service", $request->service)->where("stocks.region", Auth::user()->region)->where("articles.type", "bouteille-gaz")->where("articles.weight", floatval($request->type))->where("articles.state", 1)->with("fromArticle")->select("movements.*")->orderBy("id")->get();
                $data2  = Movement::leftjoin("articles", "movements.article_id", "articles.id")->leftjoin("stocks", "movements.stock_id", "stocks.id")->whereBetween("movements.created_at", [$request->depart, $request->fin])->where("movements.service", $request->service)->where("stocks.region", Auth::user()->region)->where("articles.type", "bouteille-gaz")->where("articles.weight", floatval($request->type))->where("articles.state", 0)->with("fromArticle")->select("movements.*")->orderBy("id")->get();

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
    public function show_broute_list()
    {
        $broutes = Broute::where("region", Auth::user()->region)->get();

        $stocks = Stock::with("article")->where("region", Auth::user()->region)->get();
        $mobile = Citerne::where("type", "mobile")->get();
        $fixe  = Citerne::where("type", "fixe")->get();
        return view("controller.list-broute", ["broutes" => $broutes, "stocks" => $stocks, "mobile" => $mobile, "fixe" => $fixe]);
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
}
