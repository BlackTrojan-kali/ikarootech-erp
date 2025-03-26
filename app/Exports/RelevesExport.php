<?php

namespace App\Exports;

use App\Models\Relhistorie;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class RelevesExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $depart;
    private $fin;
    private $citerne;
    private $region;
    public function __construct(string $region, string $depart, string $fin, string $citerne)
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
            $releves = Relhistorie::whereBetween("created_at", [$this->depart, $this->fin])->where("region", $this->region)->get();
            return view("RelevesExcel", ["releve" => $releves, "fromDate" => $this->depart, "toDate" => $this->fin]);
        } else {
            $releves = Relhistorie::where("citerne", $this->citerne)->whereBetween("created_at", [$this->depart, $this->fin])->get();
            return view("RelevesExcel", ["releve" => $releves, "fromDate" => $this->depart, "toDate" => $this->fin]);
        }
    }
}