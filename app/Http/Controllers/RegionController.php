<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    //
    public function index()
    {
        $regions = Region::all();
        return view("super.region_list", ["regions" => $regions]);
    }
    public function create()
    {
        return view("super.region_create");
    }
    public function store(Request $request)
    {
        $request->validate([
            "region" => "string | min:3 | required",
        ]);
        $region = new Region();
        $region->region = $request->region;
        $region->save();
        return back()->withSuccess("region saved successfully");
    }
    public function delete($id)
    {
        $region = Region::find($id);
        $region->delete();
        return response()->json(["message" => "Region deleted successfully"]);
    }
}
