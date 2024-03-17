<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth, Session;

class Notpush extends Controller
{
    public function updateDeviceToken(Request $request)
    {
        Auth::user()->fcm_token =  $request->token;
        Auth::user()->save();
        return response()->json(['Token successfully stored.']);
    }

    public function sendNotification(Request $request)
    {
        $this->enviaNotificacion($request->destino,$request->title,$request->body,$request->tipo);
        return redirect()->back()->with('success', 'La notificación se ha enviado');
        /*
        $usuario = User::find($request->id);
        $url = 'https://fcm.googleapis.com/fcm/send';

        $FcmToken = User::where('id',$request->id)->pluck('fcm_token')->all();

    
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $usuario->nombres.' '.$request->title,
                "body" => $request->body,
            ]
        ];
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
        // Close connection
        curl_close($ch);
        // FCM response
        dd($result);
        */
    }

    public static function enviaNotificacion(int $destino, string $titulo, $msj, int $tipo) {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = '';
        
        //Tipo de envio
        switch($tipo){
            case 0:
                //Se lo envía a una sola persona
                $usuario = User::find($destino);
                $titulo = $titulo;
                $FcmToken = User::where('id',$destino)->pluck('fcm_token')->all();
                break;
            case 1:
                //Se lo envía todos
                $FcmToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();
                break;
            case 2:
                //Se lo envía todos los DOCENTES
                $FcmToken = User::where('rol', 'Docente')->whereNotNull('fcm_token')->pluck('fcm_token')->all();
                break;
            case 3:
                //Se lo envía todos los ESTUDIANTES
                $FcmToken = User::where('rol', 'Estudiante')->whereNotNull('fcm_token')->pluck('fcm_token')->all();
                break;
            case 4:
                //Se lo envía todos los ADMINS
                $FcmToken = User::where('rol', 'Administrador')->whereNotNull('fcm_token')->pluck('fcm_token')->all();
                break;
            case 5:
                //Se lo envía a un módulo en específico
                $FcmToken = User::whereNotNull('fcm_token')->whereHas('lasMatriculas', function ($modulo) use ($destino){
                    $modulo->where('materia',$destino);
                })->pluck('fcm_token')->all();
                break;
        }
    
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $titulo,
                "body" => $msj,
                "icon" => 'https://virtual.instel.edu.co/apple-icon-72x72.png',
                "click_action" => 'https://virtual.instel.edu.co/',
            ]
        ];
        
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
        // Close connection
        curl_close($ch);
        // FCM response
        //dd($result);
    }
}