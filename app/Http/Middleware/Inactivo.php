<?php

namespace App\Http\Middleware;

use Closure, Auth;
use Illuminate\Http\Request;

class Inactivo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() &&  Auth::user()->rol == "Inactivo") {
            return $next($request);
       }

       abort(402);
    }
}
