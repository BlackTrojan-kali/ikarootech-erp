<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Region;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    //
    public function show_stocks(){
        $stocks = Stock::with("article")->get();
        return view("super.stocksList",["stocks"=>$stocks]);
    }
    public function add_stock(){
        $region = Region::all();
        $articles = Article::all();
        return view("super.add_stock",["regions"=>$region,"articles"=>$articles]);
    }
    public function post_stock(Request $request){
        $request->validate([
            "article"=>"string|required",
            "region"=>"string|required",
        ]);
        $article = Article::findOrFail(intval($request->article));
      
        $roles = ["magasin","production","commercial"];
        foreach($roles as $role){  
        $exist = Stock::where("region",$request->region)->where("category",$role)->where("article_id",$article->id)->get();
        if(count($exist) >0){
            return back()->withErrors(["message"=>"stock existe deja"]);
        }
        $stock = new Stock();
        $stock->qty =0;
        $stock->article_id = $request->article;
        $stock->type = $article->type;
        $stock->category = $role;
        $stock->region = $request->region;
        $stock->save();
        }
        return back()->withSuccess("stock cree avec success");
    }
    public function delete_stock($id){
        $stock = Stock::findOrFail($id);
        $stock->delete();
        return response()->json(["message"=>"stock deleted successfully"]);
    }
}
