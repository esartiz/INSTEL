<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class Docente
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() &&  Auth::user()->rol == "Docente" || "Administrador") {
            return $next($request);
       }

       abort(402);
    }
}
