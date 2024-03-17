<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddCorsHeaders
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Reemplaza example.com con tu dominio permitido
        $response->header('Access-Control-Allow-Origin', 'https://www.instel.edu.co');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, x-csrf-token');
        // Agrega otros encabezados CORS si es necesario

        return $response;
    }
}
