<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    //
    public function show(Request $request)
    {
        return view("Auth.login");
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            "email" => ['required', 'email'],
            "password" => ['required']
        ]);
        if (Auth::guard("web")->attempt($credentials)) {
            $request->session()->regenerate();
            switch (Auth::user()->role) {
                case "super":
                    return redirect()->route('dashboard')->withSuccess("You have successfully  logged in");
                    break;
                case "magasin":
                    return redirect()->route("dashboard-manager")->withSuccess("You have successfully  logged in");
                    break;
                case "production":
                    return redirect()->route("dashboard-producer")->withSuccess("You have successfully logged in");
                case "commercial":
                    return redirect()->route("dashboardCom")->withSuccess("You have successfully logged in");
                case "controller":
                    return redirect()->route("bossDashboard")->withSuccess("You have successfully logged in");
                case "direction":
                    return redirect()->route("director-dashboard")->withSuccess("You have successfully logged in");
            }
        }
        return back()->withErrors([
            'email' => "l'email incorrect ou inexistante"
        ])->onlyInput('email');
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            "name" => "string|required",
            "email" => "email | required |unique:users,email",
            "password" => "required|min:8|confirmed",
            "password_confirmation" => "required",
            "role" => "required| string",
            "region" => "required| string"
        ]);
        $region = $request->region;
        $hashPassword = Hash::make($request->password);
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $hashPassword,
            "role" => $request->role,
            "region" => $region
        ]);
        return redirect()->route('addUser')->withSuccess("utilisateur insere avec succes");
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/login');
    }
}
