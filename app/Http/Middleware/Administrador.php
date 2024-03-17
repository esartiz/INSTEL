<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class Administrador
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() &&  Auth::user()->rol == "Administrador") {
            return $next($request);
       }

       abort(402);
    }
}
