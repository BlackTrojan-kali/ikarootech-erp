<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Role;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminPageController extends Controller
{
    //
    public function show(Request $request){
        $stocks = Stock::with("article")->get();
        return view('super.dashboard',["stocks"=>$stocks]);
    }

    public function showUsers(Request $request){
        $users = User::where("role","!=","super")->get();
        return view("super.manageUsers",["users"=>$users]);
    }
    
    public function addUserForm(Request $request){
        $regions = Region::all();
        $roles = Role::all();
        return view("super.addUser",["regions"=>$regions,"roles"=>$roles]);
    }
    public function editUser(Request $request, $id){
        $user = User::findOrFail($id);
        $regions = Region::all();
        $roles = Role::all();
        return view("super.editUser",["user"=>$user,"regions"=>$regions,"roles"=>$roles]);
    }   
    public function updateUser(Request $request,$id){
        $request->validate([
            "name"=>"string|required",
            "role"=>"string| required",
            "region"=>"string | required"
        ]);
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->role = $request->role;
        $user->region = $request->region;
        $user->save();
        return redirect()->route('super.manageUsers')->withSuccess("utilisateur modifier avec success");
    }
    public function deleteUser(Request $request, $id){
        $user=  User::findOrFail($id);
        $user->delete();
        return  response()->json(["message"=>"element supprime avec success"]);
    }
}