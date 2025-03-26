<?php

namespace App\Exports;

use App\Models\Vente;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class VentesExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $name;
    private $depart;
    private $fin;
    private $sale;
    private $region;
    public function __construct(string $name = null, string $depar, string $fin, string $sale, string $region)
    {
        $this->name = $name;
        $this->depart = $depar;
        $this->fin = $fin;
        $this->sale = $sale;
        $this->region = $region;
    }
    public function view(): View
    {
        //
        if ($this->name) {
            $sales = Vente::whereBetween("created_at", [$this->depart, $this->fin])->where("type", $this->sale)->where("region", $this->region)->where("customer", $this->name)->get();
        } else {
            $sales = Vente::whereBetween("created_at", [$this->depart, $this->fin])->where("type", $this->sale)->where("region", $this->region)->get();
        }
        return  view("VentesExcel", ["fromDate" => $this->depart, "toDate" => $this->fin, "sales" => $sales, "type" => $this->sale]);
    }
}