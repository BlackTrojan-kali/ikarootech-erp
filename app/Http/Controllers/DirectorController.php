<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use App\Models\Region;
use App\Models\Stock;
use App\Models\Vente;
use App\Models\Versement;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirectorController extends Controller
{
    //
    public function index()
    {
        $stocks = Stock::with("article")->orderBy("region")->get();
        $region = Region::all();
        return view("director.dashboard", ["stocks" => $stocks, "region" => $region]);
    }
    //versemnents gpl
    public function getCAGlobal()
    {
        $year = 2024;
        $region = Region::all();
        $versements =  DB::table('versements')
            ->select(
                DB::raw('YEAR(created_at) as annee'),
                DB::raw('MONTH(created_at) as mois'),
                'bank',
                DB::raw('SUM(montant_gpl) as total_gpl')
            )
            ->groupBy('annee', 'mois', 'bank')
            ->orderBy('annee')
            ->orderBy('mois')
            ->orderBy('bank')
            ->get();


        //Versement::
        //selectRaw('YEAR(created_at) as annee, MONTH(created_at) as mois,bank,SUM(montant_gpl) as total_gpl')->whereYear("created_at", $year)->groupBy("annee", "mois", "bank",)->get();
        $type = "GPL";
        return view("director.globalCA", ["versements" => $versements, "region" => $region, "type" => $type]);
    }
    //function consigne versement
    public function getCAGlobalConsigne()
    {
        $year = 2024;
        $region = Region::all();
        $versements =  DB::table('versements')
            ->select(
                DB::raw('YEAR(created_at) as annee'),
                DB::raw('MONTH(created_at) as mois'),
                'bank',
                DB::raw('SUM(montant_consigne) as total_gpl')
            )
            ->groupBy('annee', 'mois', 'bank')
            ->orderBy('annee')
            ->orderBy('mois')
            ->orderBy('bank')
            ->get();
        //Versement::selectRaw('YEAR(created_at) as annee, MONTH(created_at) as mois,bank,SUM(montant_consigne) as total_gpl')->whereYear("created_at", $year)->groupBy("annee", "mois", "bank",)->get();
        $type = "Consigne";
        return view("director.globalCA", ["versements" => $versements, "region" => $region, "type" => $type]);
    }
    public function getCAGlobalRegion($regionHere)
    {
        $year = 2024;
        $region = Region::all();
        $versements = DB::table('versements')
            ->select(
                DB::raw('YEAR(created_at) as annee'),
                DB::raw('MONTH(created_at) as mois'),
                'bank',
                DB::raw('SUM(montant_gpl) as total_gpl')
            )->where("region", $regionHere)
            ->groupBy('annee', 'mois', 'bank')
            ->orderBy('annee')
            ->orderBy('mois')
            ->orderBy('bank')
            ->get();
        // Versement::selectRaw('YEAR(created_at) as annee, MONTH(created_at) as mois,region,bank,SUM(montant_gpl) as total_gpl')->where("region", $regionHere)->whereYear("created_at", $year)->groupBy("annee", "mois", "region", "bank")->get();
        $type = "GPL";
        return view("director.CAPerRegion", ["versements" => $versements, "region" => $region, "here" => $regionHere, "type" => $type]);
    }

    public function getCAGlobalRegionConsigne($regionHere)
    {
        $year = 2024;
        $region = Region::all();
        $versements = DB::table('versements')
            ->select(
                DB::raw('YEAR(created_at) as annee'),
                DB::raw('MONTH(created_at) as mois'),
                'bank',
                DB::raw('SUM(montant_consigne) as total_gpl')
            )->where("region", $regionHere)
            ->groupBy('annee', 'mois', 'bank')
            ->orderBy('annee')
            ->orderBy('mois')
            ->orderBy('bank')
            ->get();
        //Versement::selectRaw('YEAR(created_at) as annee, MONTH(created_at) as mois,region,bank,SUM(montant_consigne) as total_gpl')->where("region", $regionHere)->whereYear("created_at", $year)->groupBy("annee", "mois", "region", "bank")->get();
        $type = "consigne";
        return view("director.CAPerRegion", ["versements" => $versements, "region" => $region, "here" => $regionHere, "type" => $type]);
    }

    //VENTES CONSOLIDEES
    public function globalSales()
    {
        $year = 2024;
        $region = Region::all();
        $ventes =  DB::table('ventes')
            ->select(
                DB::raw('YEAR(created_at) as annee'),
                DB::raw('MONTH(created_at) as mois'),
                DB::raw('SUM(prix_total) as total_gpl'),
                DB::raw("SUM(qty_6) as somme_qty_6"),
                DB::raw("SUM(qty_12) as somme_qty_12"),
                DB::raw("SUM(qty_50) as somme_qty_50"),
            )->where("type", "vente")
            ->groupBy('annee', 'mois')
            ->orderBy('annee')
            ->orderBy('mois')
            ->get();
        //Vente::selectRaw("YEAR(created_at) as annee, MONTH(created_at) as mois,SUM(prix_total) as total_gpl")->where("type", "vente")->groupBy("annee", "mois", "type")->get();
        $type = "VENTE GPL";
        return view("director.globalSales", ["ventes" => $ventes, "region" => $region, "type" => $type]);
    }

    public function getRegionSales($regionHere)
    {
        $year = 2024;
        $region = Region::all();
        $versements = DB::table('ventes')
            ->select(
                DB::raw('YEAR(created_at) as annee'),
                DB::raw('MONTH(created_at) as mois'),
                DB::raw('SUM(prix_total) as total_gpl'),
                DB::raw("SUM(qty_6) as somme_qty_6"),
                DB::raw("SUM(qty_12) as somme_qty_12"),
                DB::raw("SUM(qty_50) as somme_qty_50"),
            )->where("type", "vente")
            ->where("region", $regionHere)
            ->groupBy('annee', 'mois')
            ->orderBy('annee')
            ->orderBy('mois')
            ->get();
        //Vente::selectRaw('YEAR(created_at) as annee, MONTH(created_at) as mois,SUM(prix_total) as total_gpl')->where("type", "vente")->where("region", $regionHere)->whereYear("created_at", $year)->groupBy("annee", "mois", "region")->get();
        $type = "Vente GPL";
        return view("director.SalesPerRegion", ["ventes" => $versements, "region" => $region, "here" => $regionHere, "type" => $type]);
    }
    //CONSIGNE CONSOLIDES

    public function globalConsigne()
    {
        $year = 2024;
        $region = Region::all();
        $ventes = DB::table('ventes')
            ->select(
                DB::raw('YEAR(created_at) as annee'),
                DB::raw('MONTH(created_at) as mois'),
                DB::raw('SUM(prix_total) as total_gpl'),
                DB::raw("SUM(qty_6) as somme_qty_6"),
                DB::raw("SUM(qty_12) as somme_qty_12"),
                DB::raw("SUM(qty_50) as somme_qty_50"),
            )->where("type", "consigne")
            ->groupBy('annee', 'mois')
            ->orderBy('annee')
            ->orderBy('mois')
            ->get();
        //Vente::selectRaw("YEAR(created_at) as annee, MONTH(created_at) as mois,SUM(prix_total) as total_gpl")->where("type", "consigne")->groupBy("annee", "mois", "type")->get();
        $type = "CONSIGNES";
        return view("director.globalSales", ["ventes" => $ventes, "region" => $region, "type" => $type]);
    }
    public function getRegionConsignes($regionHere)
    {
        $year = 2024;
        $region = Region::all();
        $versements = DB::table('ventes')
            ->select(
                DB::raw('YEAR(created_at) as annee'),
                DB::raw('MONTH(created_at) as mois'),
                DB::raw('SUM(prix_total) as total_gpl'),
                DB::raw("SUM(qty_6) as somme_qty_6"),
                DB::raw("SUM(qty_12) as somme_qty_12"),
                DB::raw("SUM(qty_50) as somme_qty_50"),
            )->where("type", "consigne")
            ->where("region", $regionHere)
            ->groupBy('annee', 'mois')
            ->orderBy('annee')
            ->orderBy('mois')
            ->get();

        //Vente::selectRaw('YEAR(created_at) as annee, MONTH(created_at) as mois,SUM(prix_total) as total_gpl')->where("type", "consigne")->where("region", $regionHere)->whereYear("created_at", $year)->groupBy("annee", "mois", "region")->get();
        $type = "CONSIGNE";
        return view("director.SalesPerRegion", ["ventes" => $versements, "region" => $region, "here" => $regionHere, "type" => $type]);
    }
    //entrees bouteilles pleines globale
    public function globalFullBottles()
    {
        $year = 2024;
        $region = Region::all();
        $entrees = Movement::join("articles", "articles.id", "movements.article_id")->leftjoin("stocks", "stocks.id", "movements.stock_id")->where("stocks.region", "!=", "central")->where("movements.service", "magasin")->selectRaw("YEAR(movements.created_at) as annee, MONTH(movements.created_at) as mois, weight,SUM(movements.qty) as total_qty")->where("entree", 1)->groupBy("annee", "mois", "weight")->get();
        $type = "ENTREES BOUTEILLES PLEINES";
        return view("director.fullBottles", ["entrees" => $entrees, "region" => $region, "type" => $type]);
    }
    //entrees bouteilles vides globale
    public function globalEmptyBottles()
    {
        $year = 2024;
        $region = Region::all();
        $entrees = Movement::join("articles", "articles.id", "movements.article_id")->leftjoin("stocks", "stocks.id", "movements.stock_id")->where("stocks.region", "!=", "central")->where("movements.service", "magasin")->selectRaw("YEAR(movements.created_at) as annee, MONTH(movements.created_at) as mois, weight,SUM(movements.qty) as total_qty")->where("entree", 0)->groupBy("annee", "mois", "weight")->get();

        $type = "ENTREES BOUTEILLES VIDES";
        return view("director.fullBottles", ["entrees" => $entrees, "region" => $region, "type" => $type]);
    }
    //entrees bouteilles pleines globale
    public function RegionFullBottles($theRegion)
    {
        $year = 2024;
        $region = Region::all();
        $entrees = Movement::join("articles", "articles.id", "movements.article_id")->join("stocks", "stocks.id", "movements.stock_id")->where("region", $theRegion)->where("articles.state", 1)->where("movements.service", "magasin")->selectRaw("YEAR(movements.created_at) as annee, MONTH(movements.created_at) as mois, weight,SUM(movements.qty) as total_qty")->where("entree", 1)->groupBy("annee", "mois", "weight")->get();
        $type = "ENTREES BOUTEILLES PLEINES" . $theRegion;
        return view("director.RegionFullBottles", ["entrees" => $entrees, "region" => $region, "type" => $type]);
    }
    //entrees bouteilles vides globale
    public function RegionEmptyBottles($theRegion)
    {
        $year = 2024;
        $region = Region::all();
        $entrees = Movement::join("articles", "articles.id", "movements.article_id")->join("stocks", "stocks.id", "movements.stock_id")->where("region", $theRegion)->where("articles.state", 0)->where("movements.service", "magasin")->selectRaw("YEAR(movements.created_at) as annee, MONTH(movements.created_at) as mois, weight,SUM(movements.qty) as total_qty")->where("entree", 1)->groupBy("annee", "mois", "weight")->get();
        $type = "ENTREES BOUTEILLES VIDES" . $theRegion;
        return view("director.RegionFullBottles", ["entrees" => $entrees, "region" => $region, "type" => $type]);
    }
    //generation des fichiers pdf
    public function generateCaPDF()
    {
        $region = Region::all();
        return view("director.CaPdf", ["region" => $region]);
    }
    //genreration de fichier pdf ventes
    public function GSalesPDF()
    {
        $region = Region::all();
        return view("director.GsalesPdf", ["region" => $region]);
    }
    public function postGeneratePDF(Request $request)
    {
        $request->validate([
            "region" => "string| required"
        ]);
        if ($request->region == "global") {
            if ($request->type == "gpl") {
                $region = Region::all();
                $versements =  DB::table('versements')
                    ->select(
                        DB::raw('YEAR(created_at) as annee'),
                        DB::raw('MONTH(created_at) as mois'),
                        'bank',
                        DB::raw('SUM(montant_gpl) as total_gpl')
                    )
                    ->groupBy('annee', 'mois', 'bank')
                    ->orderBy('annee')
                    ->orderBy('mois')
                    ->orderBy('bank')
                    ->get();
                $pdf = Pdf::loadview("director.GcaPDF", ["versements" => $versements, "region" => $region, "type" => $request->type]);

                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();

                $canvas = $dom_pdf->get_canvas();
                $canvas->page_text(720, 550, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
                return $pdf->download($request->region . $request->type . "GLOBAL.pdf");
            } else {
                $region = Region::all();
                $versements =  DB::table('versements')
                    ->select(
                        DB::raw('YEAR(created_at) as annee'),
                        DB::raw('MONTH(created_at) as mois'),
                        'bank',
                        DB::raw('SUM(montant_consigne) as total_gpl')
                    )
                    ->groupBy('annee', 'mois', 'bank')
                    ->orderBy('annee')
                    ->orderBy('mois')
                    ->orderBy('bank')
                    ->get();
                $pdf = Pdf::loadview("director.GcaPDF", ["versements" => $versements, "region" => $region, "type" => $request->type]);

                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();

                $canvas = $dom_pdf->get_canvas();
                $canvas->page_text(720, 550, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
                return $pdf->download($request->region . $request->type . "GLOBAL.pdf");
            }
        } else {
            if ($request->type == "gpl") {
                $region = Region::all();
                $versements = DB::table('versements')
                    ->select(
                        DB::raw('YEAR(created_at) as annee'),
                        DB::raw('MONTH(created_at) as mois'),
                        'bank',
                        DB::raw('SUM(montant_gpl) as total_gpl')
                    )->where("region", $request->region)
                    ->groupBy('annee', 'mois', 'bank')
                    ->orderBy('annee')
                    ->orderBy('mois')
                    ->orderBy('bank')
                    ->get();
                $pdf = Pdf::loadview("director.GcaRegionPDF", ["versements" => $versements, "here" => $request->region, "region" => $region, "type" => $request->type]);

                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();

                $canvas = $dom_pdf->get_canvas();
                $canvas->page_text(720, 550, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
                return $pdf->download($request->region . $request->type . "GLOBAL.pdf");
            } else {
                $region = Region::all();
                $versements = DB::table('versements')
                    ->select(
                        DB::raw('YEAR(created_at) as annee'),
                        DB::raw('MONTH(created_at) as mois'),
                        'bank',
                        DB::raw('SUM(montant_consigne) as total_gpl')
                    )->where("region", $request->region)
                    ->groupBy('annee', 'mois', 'bank')
                    ->orderBy('annee')
                    ->orderBy('mois')
                    ->orderBy('bank')
                    ->get();
                $pdf = Pdf::loadview("director.GcaRegionPDF", ["versements" => $versements, "here" => $request->region, "region" => $region, "type" => $request->type]);

                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();
                $canvas = $dom_pdf->get_canvas();
                $canvas->page_text(720, 550, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
                return $pdf->download($request->region . $request->type . "GLOBAL.pdf");
            }
        }
    }

    public function postGenerateSalesPDF(Request $request)
    {
        $request->validate([
            "region" => "string| required"
        ]);
        if ($request->region == "global") {
            if ($request->type == "gpl") {
                $region = Region::all();
                $ventes =  DB::table('ventes')
                    ->select(
                        DB::raw('YEAR(created_at) as annee'),
                        DB::raw('MONTH(created_at) as mois'),
                        DB::raw('SUM(prix_total) as total_gpl'),
                        DB::raw("SUM(qty_6) as somme_qty_6"),
                        DB::raw("SUM(qty_12) as somme_qty_12"),
                        DB::raw("SUM(qty_50) as somme_qty_50"),
                    )->where("type", "vente")
                    ->groupBy('annee', 'mois')
                    ->orderBy('annee')
                    ->orderBy('mois')
                    ->get();
                //Vente::selectRaw("YEAR(created_at) as annee, MONTH(created_at) as mois,SUM(prix_total) as total_gpl")->where("type", "vente")->groupBy("annee", "mois", "type")->get();
                $type = "VENTE GPL";
                $pdf = Pdf::loadview("director.globalSalesPdf", ["ventes" => $ventes, "region" => $region, "type" => $type]);

                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();

                $canvas = $dom_pdf->get_canvas();
                $canvas->page_text(720, 550, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
                return $pdf->download($request->region . $request->type . "GLOBAL.pdf");
            } else {
                $region = Region::all();
                $ventes =  DB::table('ventes')
                    ->select(
                        DB::raw('YEAR(created_at) as annee'),
                        DB::raw('MONTH(created_at) as mois'),
                        DB::raw('SUM(prix_total) as total_gpl'),
                        DB::raw("SUM(qty_6) as somme_qty_6"),
                        DB::raw("SUM(qty_12) as somme_qty_12"),
                        DB::raw("SUM(qty_50) as somme_qty_50"),
                    )->where("type", "consigne")
                    ->groupBy('annee', 'mois')
                    ->orderBy('annee')
                    ->orderBy('mois')
                    ->get();
                //Vente::selectRaw("YEAR(created_at) as annee, MONTH(created_at) as mois,SUM(prix_total) as total_gpl")->where("type", "vente")->groupBy("annee", "mois", "type")->get();
                $type = "VENTE CONSIGNE";
                $pdf = Pdf::loadview("director.globalSalesPdf", ["ventes" => $ventes, "region" => $region, "type" => $type]);

                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();

                $canvas = $dom_pdf->get_canvas();
                $canvas->page_text(720, 550, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
                return $pdf->download($request->region . $request->type . "GLOBAL.pdf");
            }
        } else {
            if ($request->type == "gpl") {
                $region = Region::all();
                $versements = DB::table('ventes')
                    ->select(
                        DB::raw('YEAR(created_at) as annee'),
                        DB::raw('MONTH(created_at) as mois'),
                        DB::raw('SUM(prix_total) as total_gpl'),
                        DB::raw("SUM(qty_6) as somme_qty_6"),
                        DB::raw("SUM(qty_12) as somme_qty_12"),
                        DB::raw("SUM(qty_50) as somme_qty_50"),
                    )->where("type", "vente")
                    ->where("region", $request->region)
                    ->groupBy('annee', 'mois')
                    ->orderBy('annee')
                    ->orderBy('mois')
                    ->get();
                //Vente::selectRaw('YEAR(created_at) as annee, MONTH(created_at) as mois,SUM(prix_total) as total_gpl')->where("type", "vente")->where("region", $regionHere)->whereYear("created_at", $year)->groupBy("annee", "mois", "region")->get();
                $type = "Vente GPL";

                $pdf = Pdf::loaview("director.regionSalesPdf", ["ventes" => $versements, "region" => $region, "here" => $request->region, "type" => $type]);

                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();

                $canvas = $dom_pdf->get_canvas();
                $canvas->page_text(720, 550, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
                return $pdf->download($request->region . $request->type . "GLOBAL.pdf");
            } else {
                $region = Region::all();
                $versements = DB::table('ventes')
                    ->select(
                        DB::raw('YEAR(created_at) as annee'),
                        DB::raw('MONTH(created_at) as mois'),
                        DB::raw('SUM(prix_total) as total_gpl'),
                        DB::raw("SUM(qty_6) as somme_qty_6"),
                        DB::raw("SUM(qty_12) as somme_qty_12"),
                        DB::raw("SUM(qty_50) as somme_qty_50"),
                    )->where("type", "vente")
                    ->where("region", $request->region)
                    ->groupBy('annee', 'mois')
                    ->orderBy('annee')
                    ->orderBy('mois')
                    ->get();
                //Vente::selectRaw('YEAR(created_at) as annee, MONTH(created_at) as mois,SUM(prix_total) as total_gpl')->where("type", "vente")->where("region", $regionHere)->whereYear("created_at", $year)->groupBy("annee", "mois", "region")->get();
                $type = "Vente GPL";

                $pdf = Pdf::loaview("director.regionSalesPdf", ["ventes" => $versements, "region" => $region, "here" => $request->region, "type" => $type]);

                $pdf->output();
                $dom_pdf = $pdf->getDomPDF();
                $canvas = $dom_pdf->get_canvas();
                $canvas->page_text(720, 550, "[{PAGE_NUM} sur {PAGE_COUNT}]", null, 15, array(0, 0, 0));
                return $pdf->download($request->region . $request->type . "GLOBAL.pdf");
            }
        }
    }
}
