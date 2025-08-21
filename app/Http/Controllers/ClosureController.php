<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Citerne;
use App\Models\Client;
use App\Models\Closure;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClosureController extends Controller
{
    //
    public function index()
    {
        // Récupérer toutes les fermetures (closures) de la base de données
        $closures = Closure::all();

        // Récupérer les autres variables
        $stocks = Stock::with("article")->where("region", Auth::user()->region)->get();
        $mobile = Citerne::where("type", "mobile")->get();
        $fixe  = Citerne::where("type", "fixe")->get();
        $articles = Article::where("state", 1)->orWhere("type", "accessoire")->get();
        $clients = Client::all();

        // Retourner la vue 'closures.index' en lui passant toutes les données
        return view('closures.index', [
            "closures" => $closures,
            "clientsList" => $clients, 
            "articlesList" => $articles,
            "stocks" => $stocks, 
            "mobile" => $mobile, 
            "fixe" => $fixe
        ]);
    } 
    public function edit(Closure $closure)
    {
        // Les variables suivantes sont récupérées pour être utilisées dans la vue si nécessaire
        $stocks = Stock::with("article")->where("region", Auth::user()->region)->get();
        $mobile = Citerne::where("type", "mobile")->get();
        $fixe  = Citerne::where("type", "fixe")->get();
        $articles = Article::where("state", 1)->orWhere("type", "accessoire")->get();
        $clients = Client::all();

        // Retourner la vue 'closures.edit' en lui passant les données de la fermeture et les autres variables
        return view('closures.edit', [
            "closure" => $closure,
            "clientsList" => $clients,
            "articlesList" => $articles,
            "stocks" => $stocks,
            "mobile" => $mobile,
            "fixe" => $fixe
        ]);
    }
     public function update(Request $request, Closure $closure)
    {
        // Validation des données du formulaire
        $request->validate([
            'starting_date' => 'required|date',
            'ending_date' => 'required|date|after_or_equal:starting_date',
        ]);
        
        // Mise à jour de la fermeture avec les nouvelles données
        $closure->update([
            'starting_date' => $request->starting_date,
            'ending_date' => $request->ending_date,
        ]);
        
        // Redirection vers la liste des fermetures avec un message de succès
        return back()->with('success', 'La fermeture a été mise à jour avec succès.');
    }
}
