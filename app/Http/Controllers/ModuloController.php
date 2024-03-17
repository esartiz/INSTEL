<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Programa;
use App\Models\Recurso;
use App\Models\Matricula;
use App\Models\Tarea;
use App\Models\User;
use App\Models\Repositorio;
use App\Models\Asistencia;
use App\Models\Sala;
use App\Models\Anuncio;
use App\Models\Entrega;
use App\Models\Encuesta;
use App\Models\Assignment;
use Illuminate\Http\Request;

use Session, Storage, File, Auth;


class ModuloController extends Controller
{
    public function index() {
        $modulos = Modulo::orderBy('fecha1')->get();
        return view('modulo.index', compact('modulos'));
    }
    
    public function create() {
        $modulo = new Modulo();
        $ofertaAcademica = Programa::all();
        $profesores = User::where("rol","=","Docente")->orderBy('nombres','asc')->get();
        $ciclo = Session::get('config')['ciclos'];
        return view('modulo.create', compact('modulo','ofertaAcademica','profesores','ciclo'));
    }
    
    public function store(Request $request) {
        $datos = $request->except(['_token','_method']);
        //upload new file
        if($request->image != null){
            $fext = $request->file('image')->extension();
            $fileNewName = preg_replace('/\W+/', '-', strtolower(trim($request->titulo))).'.'.$fext;
            $request->file('image')->storeAs('userfiles/img/modulos', $fileNewName);
            $datos['image'] = $fileNewName;
        }
        $modulo = Modulo::create($datos);
        return redirect()->route('modulos.index')->with('success', 'Modulo creado.');
    }
    
    
    public function show($id) {
        $modulo = Modulo::find($id);
        return view('modulo.show', compact('modulo'));
    }
    
    public function edit($id)
    {
        $modulo = Modulo::find($id);
        $ofertaAcademica = Programa::orderBy('nombre')->get();
        $profesores = User::where("rol","=","Docente")->orderBy('nombres','asc')->get();    
        $estudiantes = User::where("rol","=","Estudiante")->orderBy('apellidos','asc')->get();    
        $recursos = Recurso::where("modulo", "=", $id)->orderBy('sem')->get();
        $matriculas = Matricula::where("materia",$id)->where('status', 0)->get();
        $tareas = Tarea::where("modulo","=",$id)->orderBy('ord','ASC')->get();
        $grabaciones = Repositorio::where('modulo',$id)->orderBy('fecha','DESC')->get();
        $asistencia = Asistencia::where('modulo','=',$id)->orderBy('fecha')->orderBy('id')->get();
        $encuesta = Encuesta::where('modulo',$id)->get();

        $opcionesMatr = Session::get('config')['gruposNombre'];
        $ciclo = Session::get('config')['ciclos'];

        Session::put('idModulo',$modulo);
        return view('modulo.edit', compact('modulo','ofertaAcademica','profesores','recursos','matriculas','estudiantes','tareas','grabaciones','asistencia','ciclo','opcionesMatr','encuesta'));
    }
    
    public function update(Request $request, $id) {
        $datos = $request->except(['_token','_method']);
        $modID = Modulo::find($id);

        if($request->image != null){
            if($modID->image != ''  && $modID->image != null){
                $file_old = 'userfiles/img/modulos'.$modID->image;
                if(file_exists($file_old)){
                    unlink($file_old);
                }
            }
            //upload new file
            $fext = $request->file('image')->extension();
            $fileNewName = preg_replace('/\W+/', '-', strtolower(trim($request->titulo))).'.'.$fext;
            $request->file('image')->storeAs('userfiles/img/modulos', $fileNewName);
            $datos['image'] = $fileNewName;
        }
        //Creo los tiempos y semanas de los distintos grupos
        $datos['fechas'] = '';
        $datos['semanas'] = '';
        for ($i = 1; $i < 9; $i++) {
            $datos['fechas'] .= '|'.$request['fecha_' . $i];
            $datos['semanas'] .= '|'.$request['semana_' . $i];
        }
        $modID->update($datos);

        return redirect()->back()->with('success', 'Modulo actualizado satisfactoriamente.');
    }
    
    public function destroy($id)
    {
        $modulo = Modulo::find($id);

        $file_old = 'userfiles/img/modulos/'.$modulo->image;
        
        if(Storage::exists($file_old)){
            Storage::delete($file_old);
        }

        $modulo->delete();

        return redirect()->route('modulos.index')
            ->with('success', 'El Modulo ha sido eliminado');
    }
    public function changeWeek(Request $request){
        if($request->tipo == 'tarea'){
            Tarea::where('id', $request->elID)->update(array('fechas' => $request->vv));
        } else {
            Recurso::where('id', $request->elID)->update(array('fechas' => $request->vv));
        }
        return $request;
    }

    public function elModulo($id)
    {
        if (Session::has('msjFinanciero')) {
            if(Session::get('msjFinanciero')[1] > 1){
                return redirect()->route('financiero');
            }
        }

        $modulo = Modulo::find($id);
        $miMatricula = Matricula::where('materia',$id)->where('estudiante',Auth::user()->id)->where('status',0);
        if($miMatricula){
            $recursos = Recurso::where("modulo", "=", $modulo->id)->get();
            $tareas = Tarea::where("modulo", "=", $modulo->id)->orderBy('ord')->get();
            $laSala = Sala::where('asignada','=',$modulo->id)->first();
            $anuncio = Anuncio::where('modulo',$modulo->id)->first();
            $grabaciones = Repositorio::where('modulo',$modulo->id)->where('grupo', $miMatricula->first()->grupo)->orderBy('fecha')->get();

            Session::put('idModulo',$modulo);

            $tiempos = \AppHelper::timeModule($modulo, $miMatricula->first()->grupo);
            //Revisa si es tiempo de encuestas
            $hacerEncuesta = false;
            if(now() < $tiempos[0][1] && now() > $tiempos[0][3]){
                $revisaEnc = Encuesta::where('user', Auth::user()->id)->where('modulo',$modulo->id)->count();
                if($revisaEnc == 0){
                    $hacerEncuesta = true;
                }
            }
            return view('estudiante.modulo',compact('modulo','recursos','tareas','laSala','anuncio','grabaciones','tiempos','miMatricula','hacerEncuesta'));
        }
    }

    public function moduloDocente($id,$grupo)
    {
        $modulo = Assignment::where('modulo',$id)->where('grupo', $grupo)->where('user', Auth::user()->id)->first();
        $anuncio = Anuncio::where('modulo',$id)->first();

        // ----> Guarda los datos del modulo seleccionado
        Session::put('idModulo',$modulo);
        Session::put('miGrupo',$grupo);

        //----> Vigencia del módulo para el docente
        $tiempos = \AppHelper::timeModule($modulo->modulo(), $grupo);
        if($tiempos[0][2] > now()){
            return view('docente.modulo',compact('modulo','anuncio','tiempos'));
        } else {
            $mensaje = ["txt" => $modulo->titulo." del grupo ".$grupo." se cerró el ", "fecha" => $tiempos[0][2]];
            return view('docente.error', compact('mensaje'));
        }
    }

    public function sala($id){
        $laSala = ($id == 1 ? Session::get('idModulo')->sala : $id);
        $rolAsignado = (Auth::user()->rol == "Estudiante" ? 0 : ($id == 83868265619 ? 0 : 1));
        Session::put('rolZoom',$rolAsignado);
        return view('zoom.conf',compact('laSala','rolAsignado'));
    }
    public function meeting(){
        $estudiantes = (Session::get('rolZoom') == 1 ? Matricula::where('materia',Session::get('idModulo')->id)->where('grupo',Session::get('miGrupo'))->get() : 0);
        return view('zoom.meeting', compact('estudiantes'));
    }
}
//{{ AppHelper::timeModule() }}
