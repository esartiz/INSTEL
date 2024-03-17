<?php

namespace App\Http\Controllers;

use App\Models\MatriculasCaja;
use App\Models\Prueba;
use App\Models\PruebasCaja;
use App\Models\User_doc;
use Illuminate\Http\Request;
use App\Models\Modulo;
use App\Models\Recurso;
use App\Models\Tarea;
use App\Models\Entrega;
use App\Models\Matricula;
use App\Models\Mensaje;
use App\Models\Asistencia;
use App\Models\Sala;
use App\Models\Anuncio;
use App\Models\Repositorio;
use App\Models\DataSeminar;
use App\Models\DataSesion;
use App\Models\Assignment;
use App\Notifications\SendPushNotification;
use Lame\Lame;

use Auth, Session, Notification;

class Docente extends Controller
{
    public function __construct()
    {
        $this->middleware('Docente');
    }
    public function index()
    {
        $misModulos = Assignment::where('user',Auth::user()->id)->where('estado',0)->get();
        $anuncio = Anuncio::where('modulo',NULL)->get();
        
        //INTRO LOGO CHECK
        if(Session::get('intro')){
            return view('docente.index',compact('misModulos','anuncio'));
        } else {
            Session::put('intro', 'INSTEL');
            return view('intro');
        }
    }
    
    public function verMsj($id){
        $elMensaje = Mensaje::find($id);
        if($elMensaje->para == Auth::user()->id){
            Session::put('idMensaje',$id);
            return response()->json($elMensaje);
        } else {
            return 0;
        }
    }

    public function responderMsj(Request $request){

        Mensaje::where('id',Session::get('idMensaje'))->update(array('respuesta' => $request->respuesta));
        return redirect()->route('inicio')->with('success', 'Mensaje enviado satisfactoriamente');
    }

    public function inboxFull()
    {
        $mensajes = Mensaje::whereDate('end_date', '>', now())->where('para','=',Auth::user()->id)->orWhere('de','=',Auth::user()->id)->orderBy('created_at','DESC')->get();
        return view('docente.inbox', compact('mensajes'));
    }

    public function revision(Request $request, $id){
        $entrega = Entrega::find($id);

        //Si tiene audio guarda el audio
        if ($request->hasFile('audioBlob')) {
            $audio = $request->file('audioBlob');
            $wavFilePath = storage_path('app/public/audio/audio.wav'); // Ruta donde se guarda el archivo WAV
            $mp3FilePath = storage_path('app/public/audio/audio.mp3'); // Ruta donde se guardará el archivo MP3
    
            // Mover el archivo de audio al servidor
            $audio->move(storage_path('app/public/audio'), 'audio.wav');
    
            // Comando para convertir el archivo WAV a MP3 utilizando ffmpeg
            $ffmpegCommand = "ffmpeg -i $wavFilePath -b:a 128k $mp3FilePath";
    
            // Ejecutar el comando
            exec($ffmpegCommand);
        } 
        
        $entrega->update(array('retro' => $request->retroalimentacion));
        
        //Cambia la nota si se trata de una reposición o habilitación
        if($request->campo){
            $notaCam = ($request->campo == 'n1' ? $request->revN1 : ($request->campo == 'n2' ? $request->revN2 : ($request->campo == 'n3' ? $request->revN3 : $request->hab)));
            $cambiaNotaHab = Matricula::where('materia', $entrega->modulo)->where('estudiante', $entrega->de)->update(array($request->campo => $notaCam));
        }
        
        //Si hace revisión y cambia la nota guardará la calificación
        if($request->notaAutoEv == 1){
            $cambiaNotaHab = Matricula::where('materia', $entrega->modulo)->where('estudiante', $entrega->de)->update(['n1' => $request->revN1, 'n2' => $request->revN2, 'n3' => $request->revN3]);
        }
        
        /*Enviar notificacion al estudiante
        $title = Auth::user()->nombres." ha revisado tu entrega";
        $message = $request->retroalimentacion;
        Notpush::enviaNotificacion($entrega->user()->first()->id, $title, $request->retroalimentacion, 0);
        */
        
        return 'Enviado con éxito';
    }

    public function asistencia(Request $request){
        $data['modulo'] = Session::get('idModulo')->modulo;
        $data['grupo'] = Session::get('miGrupo');
        $data['fecha'] = $request->fecha;
        //Borro los registros que puedan existir de la lista
        Asistencia::where('modulo',$data['modulo'])->where('fecha',$data['fecha'])->where('grupo',$data['grupo'])->delete();
        //Creo la nueva asitencia
        for($a=1; $a<=$request->totalAtt; $a++){
            $data['estudiante'] = $request['ast_id_'.$a];
            $data['presencia'] = $request['ast_v_'.$a];
            $asistencia = Asistencia::create($data);
        }
        return redirect()->back()->with('success', 'Asistencia tomada satisfactoriamente');
    }

    public function asistencia_edit(Request $request){
        for($a=1; $a<=$request->totalAtt; $a++){
            if($request['ast_v_'.$a] == null){
                $presencia = 0;
            } else {
                $presencia = 1;
            }
            Asistencia::where('id',$request['idEst_'.$a])->update(array('presencia' => $presencia, 'fecha' => $request->fecha));
        }
        return redirect()->back()->with('success', 'Asistencia modificada');
    }

    public function asistencia_delete(Request $request){
        Asistencia::where('modulo',Session::get('idModulo')->modulo)->where('fecha',$request->refDelete)->delete();
        return redirect()->back()->with('success', 'Asistencia eliminada');
    }

    public function notas(Request $request){
        for($a=1; $a<=$request->totalAtt; $a++){
            $idEst = $request['dtNot_'.$a];
            Matricula::where('id',$idEst)->where('materia',Session::get('idModulo')->modulo)->update(array('n1' => $request['n1_'.$idEst], 'n2' => $request['n2_'.$idEst], 'n3' => $request['n3_'.$idEst]));
        }
        return redirect()->back()->with('success', 'Calificaciones actualizadas');
    }

    public function anuncio(Request $request){
        $data = $request->except(['_token','_method']);
        //Detecta si se trata de un evento de calendario
        if($data['modulo'] == "0" ){
            $data['modulo'] = NULL;
            if($data['nivel'] == "1"){
                $data['nivel'] = NULL;
                $data['vence'] = "2022-01-01 00:00:00";
            } else if($data['nivel'] == "2"){
                $data['nivel'] = NULL;
            } else {
                $data['nivel'] = $data['nivel'].(str_contains($data['nivel'], 'CCL') ? $data['grupo'] : '');
            }
            $q = Anuncio::create($data);
        } else { 
            //Si se trata de un aviso de módulo:
            $q = Anuncio::updateOrCreate(
                ['modulo' =>  $data['modulo']], $data
            );
        }
        return redirect()->back()->with('success', 'Anuncio actualizado');
    }

    public function anuncioBorra(Request $request){
        $q = Anuncio::where('id', $request->deleteme)->first();
        $q->delete();
        return redirect()->back()->with('success', 'Evento/Anuncio eliminado');
    }

    public function seminarios(){
        $seminariosAsignados = DataSesion::where('docente',Auth::user()->id)->where('status', 0)->orderBy('fecha','DESC')->get();
        return view('docente.seminarios', compact('seminariosAsignados'));
    }
    public function agendarSeminario(Request $request){
        $sesionDt = DataSesion::find($request->id);
        if($sesionDt->docente == Auth::user()->id){
            $sesionDt->update(['fecha' => $request->nFecha]);
            return "Se modificó la sesión de ".$sesionDt->estudiante()->nombres;
        }        
    }
    public function editarSesion(Request $request){
        $sf = DataSeminar::find($request->idEdit);
        if($sf->docente == Auth::user()->id){
            if($request->archivo){
                $request->file('archivo')->storeAs('userfiles/seminarios/', $sf->recurso.'.pdf');
            }
            $sf->update(['tareaTipo' => $request->tareaTipo, 'tarea' => $request->tarea]);
            return redirect()->back()->with('success', 'Se modificó la información de la sesión con éxito.');
        }
    }
    public function retroSession(Request $request){
        $sesionDt = DataSesion::find($request->idValoracion);
        if($sesionDt->docente == Auth::user()->id){
            $sesionDt->update(['retro' => $request->retro]);
            return redirect()->back()->with('success', 'Se envió la retroalimentación con éxito.');
        }
    }

    public function verEntrega($id){
        //Restringir la vista si es de un estudiante
        if(Auth::user()->rol == "Estudiante"){
            $entrega = Entrega::where('id',$id)->where('de',Auth::user()->id)->first();
        } else {
            $entrega = Entrega::find($id);
        }
        
        return view('entrega.show', compact('entrega'));
    }

    public function pruebasAptitud(){
        //Revisa si se trata de Efrén Alberto Riofrío Bastos quien hace
        //la evaluación del informe de gestión académica  
        if(Auth::user()->id == '40'){
            $estudiantes = MatriculasCaja::where('estado', 'ACTIVO')->where('prg', '1')->where('nivel', '9')->get();
            return view('docente.informe_gestion', compact('estudiantes'));
        } else {
        //Si no es Riofrío, busca el docente de la prueba de aptitud
            $prb = PruebasCaja::where('jurado1', Auth::user()->id)->orWhere('jurado2', Auth::user()->id)->first();
            $pruebas = ($prb ? Prueba::where('idPrueba', $prb->id)->get() : "");
            return view('docente.pruebas', compact('prb', 'pruebas'));
        }
    }
    public function pruebasValorar(Request $request, $id){
        //Revisa si se trata de una valoración o de un informe final
        if($id == "0"){
            $tipoEvl = (count($request->opciones) > 1 ? 'grupo' : 'individual');
            foreach ($request->opciones as $estudiante) {
                $dt = explode('|', $estudiante);
                User_doc::create([
                    'user' => $dt[0],
                    'file' => md5(uniqid(rand(), true)),
                    'descr' => 'INFINRSAC|'.$request->empresa.'|'.$request->fecha.'|'.implode('-',$request->criterio).'|'.implode('·', $request->obs).'|'.$request->observacion.'|'.$tipoEvl.'|'.$dt[1]
                ]);
            }
        } else {
            $dd = Prueba::find($id)->update([
                'valoracion'.$request->idJurado => $request->criterio_1.'|'.$request->criterio_2.'|'.$request->criterio_3.'|'.$request->criterio_4.'|'.$request->criterio_5,
                'observacion'.$request->idJurado => $request->obs_1.'|'.$request->obs_2.'|'.$request->obs_3.'|'.$request->obs_4.'|'.$request->obs_5
            ]);
        }
        return redirect()->back()->with('success', 'Se envió la valoración con éxito.');
    }
}
