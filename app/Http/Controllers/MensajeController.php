<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\SendPushNotification;
use Kreait\Laravel\Firebase\Facades\Firebase;

use Auth, Session, Notification;

class MensajeController extends Controller
{
    public function index()
    {
        /*
        $bandeja = Mensaje::whereDate('end_date', '>', now())->where('para','=',Auth::user()->id)->orWhere('de','=',Auth::user()->id)->orderBy('start_date','DESC')->get();
        $msj = "";
        $guia = "";
        return view('mensaje.index', compact('bandeja','msj','guia'));
        */
    }

    public function create()
    {
    }
    
    public function store(Request $request)
    {
        /*
        $datos['de'] = Auth::user()->id;
        $datos['para'] = Session::get('de');
        $datos['asunto'] = "";
        $datos['mensaje'] = $request->mensaje;
        $datos['start_date'] = date("Y-m-d H:i:s");
        $datos['end_date'] = date("Y-m-d H:i:s",strtotime(date('Y-m-d H:i:s')."+ 6 months"));
        $datos['status'] = 0;
        $mensaje = Mensaje::create($datos);
        
        //Envia la notificación
        Notpush::enviaNotificacion($datos['para'], Auth::user()->nombres.' te ha enviado un mensaje', $request->mensaje, 0);

        return redirect()->back();
        */
    }
    
    public function show($id)
    {
        /*
        $inboxP = User::where('cod',$id)->first();
        //Crear variable de sesion porque no la toma en la función del $query
        Session::put('de',$inboxP->id);
        Session::put('de_nombre',$inboxP->nombres.' '.$inboxP->apellidos);
        //
        $bandeja = Mensaje::whereDate('end_date', '>', now())->where('para','=',Auth::user()->id)->orWhere('de','=',Auth::user()->id)->orderBy('start_date','DESC')->get();
        
        $msj = Mensaje::where(function ($query) {
            $query->where('de', Session::get('de'))
                ->where('para', Auth::user()->id);
        })->orWhere(function($query) {
            $query->where('para', Session::get('de'))
                ->where('de', Auth::user()->id);
        })->orderBy('start_date','DESC')->get();

        Mensaje::where('para', Auth::user()->id)->where('de', Session::get('de'))->update(array('status' => '1'));

        $noReadMsj = Mensaje::where('para',Auth::user()->id)->where('status',0)->count();
        Session::put('notifMsj',$noReadMsj);
        
        $guia = $id;
        return view('mensaje.index', compact('bandeja','msj','guia'));
        */
    }
    
    public function edit($id)
    {
        /*
        $mensaje = Mensaje::find($id);
        return view('mensaje.edit', compact('mensaje'));
        */
    }
    
    public function update(Request $request, Mensaje $mensaje)
    {
        /*
        $mensaje->update($request->all());

        return redirect()->route('inicio_admin')
            ->with('success', 'Anuncio modificado exitosamente');
        */
    }
    
    public function destroy($id)
    {
        //$mensaje = Mensaje::find($id)->delete();

        //return redirect()->back();
    }

    public function listaCompleta(){
        //$mensajes = Mensaje::orderBy('created_at','DESC')->get();
        //return view('mensaje.control', compact('mensajes'));
    }
}
