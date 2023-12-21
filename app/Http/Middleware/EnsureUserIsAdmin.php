<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Assurez-vous que l'utilisateur est connecté
        if (Auth::check()) {
            // Vérifiez si l'utilisateur a le rôle d'administrateur
            if (Auth::user()->role->name == 'admin') {
                return $next($request);
            }
        }

        return response()->json(['message' => 'Accès non autorisé'], 403);
    }
}
