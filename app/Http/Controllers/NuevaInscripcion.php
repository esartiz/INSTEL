<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\SendPushNotification;
use App\Models\Inscripciones;
use App\Models\Programas;
use Carbon\Carbon;

class NuevaInscripcion extends Controller
{
    public function inscripcionInstel(Request $request){
        Notpush::enviaNotificacion(3, 'Hola', 'Bola', 0);
        
        return "nice";
    }
}
