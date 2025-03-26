<?php

namespace App\Exports;

use App\Models\Receive;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ReceptionExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $depart;
    private $fin;
    private $citerneId;
    private $citerne;
    private $region;
    private $role;
    public function   __construct(string $depart, string $fin, int $citerneId, string $citerne, string $region, string $role)
    {

        $this->depart = $depart;
        $this->fin = $fin;
        $this->citerneId = $citerneId;
        $this->citerne = $citerne;
        $this->region = $region;
        $this->role = $role;
    }
    public function view(): View
    {
        //
        if ($this->citerne == "global") {
            $receive = Receive::whereBetween("created_at", [$this->depart, $this->fin])->where("region", $this->region)->get();
            return view("ReceptionExcel", ["receive" => $receive, "fromDate" => $this->depart, "toDate" => $this->fin, "region" => $this->region]);
        } else {
            $receive = Receive::where("id_citerne", $this->citerneId)->where("region", $this->region)->whereBetween("created_at", [$this->depart, $this->fin])->with("citerne")->get();
            return view("ReceptionExcel", ["receive" => $receive, "fromDate" => $this->depart, "toDate" => $this->fin, "region" => $this->region]);
        }
    }
}
