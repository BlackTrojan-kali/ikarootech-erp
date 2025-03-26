<?php

namespace App\Exports;

use App\Models\Versement;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class VersementExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $depart;
    private $fin;
    private $bank;
    private $region;
    private $role;
    public function __construct(string $depart, string $fin, string $bank, string $region, string $role)
    {
        $this->depart = $depart;
        $this->fin = $fin;
        $this->bank = $bank;
        $this->region = $region;
        $this->role = $role;
    }
    public function view(): View
    {
        //
        if ($this->bank == "all") {
            $afb = Versement::where("bank", "AFB")->where("region", $this->region)->where("service", $this->role)->whereBetween("created_at", [$this->depart, $this->fin])->get();
            $cca = Versement::where("bank", "CCA")->where("region", $this->region)->where("service", $this->role)->whereBetween("created_at", [$this->depart, $this->fin])->get();
            $caisse = Versement::where("bank", "CAISSE")->where("region", $this->region)->where("service", $this->role)->whereBetween("created_at", [$this->depart, $this->fin])->get();
            return view("VersementExcelAll", ["fromDate" => $this->depart, "toDate" => $this->fin, "afb" => $afb, "cca" => $cca, "bank" => $this->bank, "caisse" => $caisse]);
        } else {
            $deposit = Versement::where("bank", $this->bank)->where("region", $this->region)->where("service", $this->role)->whereBetween("created_at", [$this->depart, $this->fin])->get();

            return view("versementExcel", ["fromDate" => $this->depart, "toDate" => $this->fin, "deposit" => $deposit, "bank" => $this->bank]);
        }
    }
}
