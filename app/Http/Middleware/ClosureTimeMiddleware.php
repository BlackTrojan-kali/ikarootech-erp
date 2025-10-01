<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Closure as ClosureModel; // Alias pour éviter les conflits de nom
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ClosureTimeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupérer le tout premier enregistrement de fermeture
        $closure = ClosureModel::where("region",Auth::user()->region)->first();
        // Vérifier si une fermeture existe et si sa date de fin est passée
        if ($closure && Carbon::parse($closure->ending_date)->lessThan(Carbon::now())) {
            // Si la date est dépassée, rediriger vers la page de connexion
            return redirect()->route("login")->withErrors([
                "warning" => "Période de clôture de compte dépassée."
            ]);
        }

        // Sinon, continuer la requête
        return $next($request);
    }
}
