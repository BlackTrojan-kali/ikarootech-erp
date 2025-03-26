<?php

namespace App\Http\Controllers;

use App\Exports\MovementExport;
use App\Exports\ProductionExport;
use App\Exports\ReceptionExport;
use App\Exports\RelevesExport;
use App\Exports\VentesExport;
use App\Exports\VersementExport;
use App\Http\Controllers\Controller;
use App\Models\Movement;
use App\Models\Vente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    //
    public function export(Request $request)
    {
        return Excel::download(new MovementExport($request->depart, $request->fin, $request->type, $request->state, $request->service, Auth::user()->region), "movements.xlsx");
    }
    public function exportReceives(Request $request)
    {
        $request->validate([
            "depart" => "date | required",
            "fin" => "date | required",
            "citerne" => "string | required"
        ]);
        $idCitern = intval($request->citerne);

        return Excel::download(new ReceptionExport($request->depart, $request->fin, $idCitern, "citerne", Auth::user()->region, Auth::user()->role,), "receives" . $request->depart . ".xlsx");
    }
    public function exportVentes(Request $request)
    {

        $request->validate(
            [
                "depart" => "date | required",
                "fin" => "date | required",
                "name" => "string | nullable",
                "sale" => "string |required",
            ]
        );

        return Excel::download(new VentesExport($request->name, $request->depart, $request->fin, $request->sale, Auth::user()->region), "ventes" . $request->depart . "" . $request->fin . ".xlsx");
    }
    public function exportVersement(Request $request)
    {

        $request->validate(
            [
                "depart" => "date | required",
                "fin" => "date | required",
                "bank" => "string | required ",
                "service" => "string | required"
            ]
        );
        return Excel::download(new VersementExport($request->depart, $request->fin, $request->bank, Auth::user()->region, $request->service), "versement" . $request->depart . "" . $request->fin . ".xlsx");
    }
    public function exportReleves(Request $request)
    {
        $request->validate([
            "depart" => "date | required",
            "fin" => "date | required",
            "citerne" => "string | required",
        ]);
        return  Excel::download(new RelevesExport(Auth::user()->region, $request->depart, $request->fin, $request->citerne), "Releves" . $request->depart . "" . $request->fin . ".xlsx");
    }
    public function exportProduction(Request $request)
    {
        $request->validate([
            "depart" => "date | required",
            "fin" => "date | required",
            "citerne" => "string | required"
        ]);
        return Excel::download(new ProductionExport($request->depart, $request->fin, $request->citerne, Auth::user()->region), "Production" . $request->depart . "" . $request->fin . ".xlsx");
    }
}
