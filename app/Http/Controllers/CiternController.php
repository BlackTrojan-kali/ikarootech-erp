<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Citerne;
use App\Models\Receive;
use App\Models\Region;
use App\Models\Relhistorie;
use App\Models\Stock;
use App\Models\Vracmovement;
use App\Models\Vracstock;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CiternController extends Controller
{
    
    //new manage citernes
    public function manage_citernes(){
        $citernes = Citerne::all();
        return view("super.citernelist",["citernes"=>$citernes]);
    }
    public function show(Request $request)
    {

        $categorie = Auth::user()->role;

        $stocks = Stock::where("region", "=", Auth::user()->region)->where("category", "=", $categorie)->with("article")->get();
        $accessories = Article::where("type", "=", "accessoire")->get("title");
        $vracstocks = Citerne::where("type", "mobile")->get();

        $mobile = Citerne::where("type", "mobile")->get();
        $fixe  = Citerne::where("type", "fixe")->get();
        $depotages = Relhistorie::all();
        if (Auth::user()->role == "controller") {
            return view("controller.history-transmit", ["depotages" => $depotages, "stocks" => $stocks, "fixe" => $fixe, "mobile" => $mobile]);
        }
        return view("manager.history-transmit", ["depotages" => $depotages, "stocks" => $stocks, "accessories" => $accessories, "vrac" => $vracstocks, "fixe" => $fixe, "mobile" => $mobile]);
    }
    public function showReleve(Request $request)
    {
        $accessories = Article::where("type", "=", "accessoire")->get("title");
        $vracstocks = Citerne::where("type", "mobile")->get();
        $receptions = Receive::with("citerne")->where("region", Auth::user()->region)->get();
        $fixe  = Citerne::where("type", "fixe")->get();
        $stocks = Stock::where("category", Auth::user()->role)->where("region", Auth::user()->region)->get();
        $mobile = Citerne::where("type", "mobile")->get();
        $allvrackstocks = Citerne::all();
        if (Auth::user()->role == "magasin") {
            return view("manager.reception", ["mobile" => $mobile, "accessories" => $accessories, "vrac" => $vracstocks, "receptions" => $receptions, "fixe" => $fixe, "all" => $allvrackstocks]);
        } else if (Auth::user()->role == "controller") {
            return view("controller.citerneRel", ["receptions" => $receptions, "stocks" => $stocks, "fixe" => $fixe, "mobile" => $mobile]);
        } else {
            return view("producer.reception", ["receptions" => $receptions, "vrac" => $vracstocks, "fixe" => $fixe, "all" => $allvrackstocks]);
        }
    }
    public function showFormAddCitern(Request $request)
    {
        return view("super.addCitern");
    }
    public function moveGpl(Request $request)
    {
        $request->validate([
            "citerne" => "string| required",
            "qty" => "numeric| required",
            "provenance" => "string| required",
            "matricule" => "string | required",
            "livraison" => "string | required"
        ]);
        $citerne = Citerne::where("name", $request->citerne)->first();
        $move = new Receive();
        $move->id_citerne = $citerne->id;
        $move->livraison = $request->livraison;
        $move->matricule = $request->matricule;
        $move->qty = $request->qty;
        $move->provenance = $request->provenance;
        $move->receiver = Auth::user()->role;
        $move->region = Auth::user()->region;
        $move->save();

        return response()->json(["success" => "mouvement inserer avec success"]);
    }
    public function validateFormAddCitern(Request $request)
    {
        $request->validate([
            "name" => "string| required |unique:citernes,name",
            "capacity" => "numeric| required ",
            "type" => "string |required",
        ]);
        $regions = Region::all();
        $citern = new Citerne();
        $citern->name = $request->name;
        $citern->capacity = $request->capacity;
        $citern->type = $request->type;
        $citern->save();
        $citern =  Citerne::where("name", $request->name)->first();

        foreach ($regions as $region) {
            $vracstock = new Vracstock();
            $vracstock->citerne_id = $citern->id;
            $vracstock->stock_theo = 0;
            $vracstock->stock_rel = 0;
            $vracstock->region = $region->region;
            $vracstock->save();
        }

        return back()->withSuccess("citern inseree avec success");
    }
    public function delete(Request $request, $id)
    {
        $article = Citerne::findOrFail($id);
        $article->delete();
        return response()->json(["message" => "element supprime avec succes"]);
    }

    public function generate_receive_pdf(Request $request)
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
            $receive = Receive::whereBetween("created_at", [$request->depart, $request->fin])->where("region", Auth::user()->region)->get();
            $pdf = Pdf::loadview("RecievePdf", ["receive" => $receive, "fromDate" => $fromDate, "toDate" => $toDate]);
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->get_canvas();
            $canvas->page_text(510, 800, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
            return  $pdf->download("historique des releves.pdf");
        }
        $receive = Receive::where("id_citerne", $idCitern)->where("region", Auth::user()->region)->whereBetween("created_at", [$request->depart, $request->fin])->with("citerne")->get();

        $pdf = Pdf::loadview("RecievePdf", ["receive" => $receive, "fromDate" => $fromDate, "toDate" => $toDate]);
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(510, 800, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
        return  $pdf->download("historique des receptions.pdf");
    }
    public function generate_rel_pdf(Request $request)
    {
        $request->validate([
            "depart" => "date | required",
            "fin" => "date | required",
            "citerne" => "string | required"
        ]);
        $fromDate = $request->depart;
        $toDate = $request->fin;
        $idCitern = $request->citerne;
        if ($request->citerne == "global") {
            $receive = Relhistorie::whereBetween("created_at", [$request->depart, $request->fin])->where("region", Auth::user()->region)->get();
            $pdf = Pdf::loadview("RelevePdf", ["releve" => $receive, "fromDate" => $fromDate, "toDate" => $toDate]);
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->get_canvas();
            $canvas->page_text(510, 800, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
            return  $pdf->download("historique des releves.pdf");
        }
        $receive = Relhistorie::where("citerne", $idCitern)->whereBetween("created_at", [$request->depart, $request->fin])->get();
        $pdf = Pdf::loadview("RelevePdf", ["releve" => $receive, "fromDate" => $fromDate, "toDate" => $toDate]);
        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();
        $canvas->page_text(510, 800, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
        return  $pdf->download("historique des releves.pdf");
    }
}