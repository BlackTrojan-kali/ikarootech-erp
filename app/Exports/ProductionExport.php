<?php

namespace App\Exports;

use App\Models\Producermove;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ProductionExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $depart;
    private $fin;
    private $citerne;
    private $region;
    public function __construct(string $depart, string $fin, string $citerne, string $region)
    {
        $this->depart = $depart;
        $this->fin = $fin;
        $this->citerne = $citerne;
        $this->region = $region;
    }

    public function view(): View
    {
        //

        if ($this->citerne == "global") {
            $datas = Producermove::whereBetween("created_at", [$this->depart, $this->fin])->where("region", $this->region)->get();

            return view("ProductionExcel", ["datas" => $datas, "fromDate" => $this->depart, "toDate" => $this->fin]);
        } else {
            $datas =  Producermove::where("id_citerne", $this->citerne)->whereBetween("created_at", [$this->depart, $this->fin])->get();
            return view("ProductionExcel", ["datas" => $datas, "fromDate" => $this->depart, "toDate" => $this->fin]);
        }
    }
}
