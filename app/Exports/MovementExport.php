<?php

namespace App\Exports;

use App\Models\Movement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MovementExport implements FromView, WithHeadings
{

    private $depart;
    private $fin;
    private $type;
    private $etat;
    private $service;
    private $region;
    public function __construct(string $depart, string $fin, string $type, bool $etat, string $service, string $region)
    {
        $this->depart = $depart;
        $this->fin = $fin;
        $this->type = $type;
        $this->etat = $etat;
        $this->service = $service;
        $this->region = $region;
    }
    public function view(): View
    {
        $first = new Movement();
        $movesP =  Movement::leftjoin("articles", "movements.article_id", "articles.id")->leftjoin("stocks", "movements.stock_id", "stocks.id")->whereBetween("movements.created_at", [$this->depart, $this->fin])->where("movements.service", $this->service)->where("stocks.region", $this->region)->where("articles.type", "bouteille-gaz")->where("articles.weight", floatval($this->type))->where("articles.state", 1)->with("fromArticle")->select("movements.*")->orderBy("id")->get();
        $movesV = Movement::leftjoin("articles", "movements.article_id", "articles.id")->leftjoin("stocks", "movements.stock_id", "stocks.id")->whereBetween("movements.created_at", [$this->depart, $this->fin])->where("movements.service", $this->service)->where("stocks.region", $this->region)->where("articles.type", "bouteille-gaz")->where("articles.weight", floatval($this->type))->where("articles.state", 0)->with("fromArticle")->select("movements.*")->orderBy("id")->get();
        return View("ExcelMove", ["bouteille_pleines" => $movesP, "bouteille_vides" => $movesV, "service" => $this->service, "region" => $this->region, "type" => $this->type, "depart" => $this->depart, "fin" => $this->fin]);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Movement Type',
            'Amount',
            'Date',
            // Add more headings as needed
        ];
    }
}