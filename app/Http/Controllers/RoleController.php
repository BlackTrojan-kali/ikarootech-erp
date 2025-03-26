<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function index(){
        $roles = Role::all();
        return view("super.role_list", compact('roles'));
    }
    public function create(){
        return view("super.role_create");
    }
       //
       public function store(Request $request){
        $request->validate([
            "role"=>"string | min:3 | required",
        ]);
        $role = new Role();
        $role->role = $request->role;
        $role->save();
        return back()->withSuccess("role saved successfully");
    }
    public function delete($id){
        $role = Role::find($id);
        $role->delete();
        return response()->json(["message"=>"Region deleted successfully"]);	

    }
}