<?php

namespace App\Http\Controllers;

use App\Models\DataSesion;
use App\Models\Encuesta;
use App\Models\User;
use App\Models\Modulo;
use App\Models\Matricula;
use App\Models\Inscripciones;
use App\Models\Graduando;
use App\Models\FConcepto;
use App\Models\Siet;
use App\Models\Programa;
use App\Models\FBill;
use App\Models\MatriculasCaja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Storage, Image, Auth, Session;

class UserController extends Controller
{   
    public function index(Request $id)
    {
        $users = User::where('rol','=','Estudiante')->get();
        $tipoDato = "";
        return view('user.index', compact('users','tipoDato'));
    }
    
    public function create($data)
    {
        $user = new User($data);
        $user->cod = User::where('rol',$user['rol'])->withTrashed()->orderBy('cod', 'desc')->first()->cod + 1;
        $programas = Programa::orderBy('tipo')->orderBy('nombre')->get();

        //return response()->json($user);
        return view('user.create', compact('user','programas'));
    }
    
    public function store(Request $request)
    {
        $data = $request->except(['_token','_method']);
        $data['password'] = Hash::make($data['doc']);
        
        if($request->fotoPerfil != null){
            $laFoto = Image::make($request->file('fotoPerfil'))->orientate();
            $laFoto->resize(null, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img = $laFoto->save(storage_path('app/userfiles/profiles/0/'.$request->cod.'.jpg'), 72);
                //Miniatura
                $laFotoMini = $laFoto->resize(null, 100, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img = $laFotoMini->save(storage_path('app/userfiles/profiles/0/t/'.$request->cod.'.jpg'), 72);
        }

        if($request->tipoDoc == "TI"){
            $dtOt = ['nombre' => $request->otPr1, 'doc' => $request->otPr2, 'doc_ex' => $request->otPr3];
            $request['otraPer'] = json_encode($dtOt);
        }
        $nUsuario = User::create($data);
        
        //Creamos los datos de SIET de una vez
        $dataSiet['user'] = $nUsuario->id;
        Siet::create($dataSiet);

        return redirect('/users/'.strtolower($request->rol))->with('success', 'Usuario creado satisfactoriamente.');
    }
    
    public function show($id)
    {
        if($id == 'egresados'){
            $users = MatriculasCaja::where('estado','GRADUADO')->get();
        } else {
            $users = User::where('rol','=',ucfirst($id))->orderBy('apellidos')->get();
        }
        $tipoDato = ucfirst($id);
        $ciclo = Session::get('config')['ciclos'];
        $listaFiltro = Programa::orderBy('tipo')->orderBy('nombre')->get();
        return view('user.'.$id, compact('users','tipoDato','ciclo','listaFiltro'));
    }
    
    public function edit($id)
    {
        $user = User::find($id);
        if($user->rol == "Docente"){
            $sesiones = DataSesion::where('docente',$id)->get();
            $modulos = Modulo::orderBy('titulo')->get();
            return view('user.edit_docente', compact('user','sesiones','modulos'));
        } else {
            $user = User::where('id', $id)->withTrashed()->first();
            $user->msjIni ="";
            $matriculas = Matricula::where('estudiante',$id)->get();
            $matriculasBox = MatriculasCaja::where('user',$id)->orderBy('periodo', 'ASC')->orderBy('nivel', 'ASC')->orderBy('fechaIngreso', 'ASC')->get();
            //$programas = Programa::orderBy('tipo')->orderBy('nombre')->get();
            $programas = Programa::select(['id', 'tipo', 'nombre'])
                            ->selectRaw("CONCAT(tipo, '-', nombre) AS nombre_tipo")
                            ->orderBy('tipo','DESC')
                            ->orderBy('nombre')
                            ->get();
            $financiero = FConcepto::where('user',$id)->where('status',1)->orderBy('fecha', 'DESC')->get();
            $deuda = FBill::where('user', $id)->orderBy('created_at', 'DESC')->get();
            $modulos = Modulo::orderBy('titulo','ASC')->get();
            $certificados = Graduando::where('documento',$user->doc)->get();
            $docReq = \AppHelper::checkDocsReqs($user);
            return view('user.edit', compact('user','matriculas','matriculasBox','modulos', 'certificados','financiero','docReq','programas','deuda'));
        }
    }
    
    public function update(Request $request, User $user)
    {
        if($request->fotoPerfil != null){
            $laFoto = Image::make($request->file('fotoPerfil'))->orientate();
            
                $laFoto->resize(null, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img = $laFoto->save(storage_path('app/userfiles/profiles/0/'.$request->cod.'.jpg'), 72);
                //Miniatura
                $laFotoMini = $laFoto->resize(null, 100, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img = $laFotoMini->save(storage_path('app/userfiles/profiles/0/t/'.$request->cod.'.jpg'), 72);
        }
        if($request->tipoDoc == "TI"){
            $dtOt = ['nombre' => $request->otPr1, 'doc' => $request->otPr2, 'doc_ex' => $request->otPr3];
            $request['otraPer'] = json_encode($dtOt);
        }
        $user->update($request->all());

        return redirect()->back()->with('danger', 'Usuario editado satisfactoriamente');
    }
    
    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return redirect('/users/estudiante')->with('danger', 'Usuario eliminado de la base de datos');
    }

    public function deshabilitados()
    {
        $users = User::onlyTrashed()->get();
        $tipoDato = "Desahbilitado";
        return view('user.restore', compact('users','tipoDato'));
    }

    public function usercheck(Request $request){
        $result = User::where('doc',$request->checkID)->withTrashed();
        //Reviso que no esté en la BD de usuarios
        if($result->count() == 0){
            $uu['rol'] = $request->rol;
            $uu['doc'] = $request->checkID;
            //Reviso que no esté en los inscritos, si lo está, ofrece datos
            $rest2 = Inscripciones::where('doc',$request->checkID)->first();
            if($rest2 != NULL){
                $uu['nombres'] = $rest2->nombre;
                $uu['fecha_nac'] = $rest2->fechaNac;
                $uu['telefono'] = $rest2->telefono;
                $uu['email'] = $rest2->correo;
                $uu['msjIni'] = " <b>Datos obtenidos por una coincidencia en la base de inscripciones</b>";
            }
            return $this->create($uu);
        } else {
            $dt = $result->first();
            return redirect()->route('users.edit', $dt->id);
            /*
            if($dt->deleted_at == NULL){
                return redirect()->route('users.edit', $dt->id);
            } else {
                return redirect()->back()->with('success', 'Existe un usuario llamado <b>'.$dt->nombres." ".$dt->apellidos.'</b> con indentificación '.$dt->doc.' y se encuentra deshabilitado. <b><a href="/restoreUser/'.$dt->id.'">Habilítelo haciendo clic aquí</a></b>');
            }
            */
        }
        return response()->json($request);
    }

    public function restoreUser($id){
        User::where('id',$id)->withTrashed()->update([
           'deleted_at' => NULL
        ]);
        return $this->edit($id);
    }

    public function restore(Request $request){

        $user = User::withTrashed()->find($request->user);
        $user->deleted_at = NULL;
        $user->update($request->all());
        return redirect()->route('users.del')
            ->with('danger', 'Usuario restaurado de la base de datos');
    }

    public function buscar($id){
        $result = User::where('doc',$id)->withTrashed()->first();
        $miMatr = MatriculasCaja::where('user',$result->id)->where('estado', 'ACTIVO')->get();
        if($result->tipoDoc == "TI"){
            $result->nombreCompleto = json_decode($result->otraPer)->nombre;
            $result->doc = json_decode($result->otraPer)->doc;
        } else {
            $result->nombreCompleto = $result->nombres.' '.$result->apellidos;
        }
        //Datos del SIET
        $result['direccion'] = $result->dataSiet->direccion;
        $result['ciudad'] = $result->dataSiet->ciudad;
        $result['barrio'] = $result->dataSiet->barrio;
        $result['refID'] = ($result->misDeudas() ? $result->misDeudas()->get() : '');
        //Datos de la Matrícula
        $datMatArr = array();
        foreach($miMatr as $itemPgMt){
            array_push($datMatArr, array(
                'idMat' => $itemPgMt->id,
                'nombre' => $itemPgMt->getPrograma()->nombre,
                'valor' => $itemPgMt->getPrograma()->v_total, 
                'cuotas' => $itemPgMt->getPrograma()->n_pagos,
                'periodo' => $itemPgMt->periodo
            ));
        }
        $result['mtr'] = $datMatArr;
        //Otros datos
        $result['codUnicoEstu'] = substr($result->cod, 5,4);

        return response()->json($result);
    }

    public function buscarCodigo($id){
        $result = User::where('cod',$id)->withTrashed();
        if($result->count() > 0){
            return 1;
        } else {
            return 0;
        }
    }

    public function profileView(){
        $certificados = Graduando::where('documento',Auth::user()->doc)->get();
        $docReq = \AppHelper::checkDocsReqs(Auth::user());
        return view('user.profile',compact('certificados','docReq'));
    }

    public function usuadmclave(Request $request){
        $user = User::find($request->idRest);
        $pswd = Hash::make($user->doc);
        $user->update(array('password' => $pswd));
        return redirect()->back()->with('danger', 'La contraseña de '.$user->nombres.' ha sido reestablecida');
    }

    public function generarLista($id){
        $listado = MatriculasCaja::where('estado','ACTIVO')->get();
        return view('admin.listadousu',compact('listado'));
    }

    public function userbuscar(Request $request)
    {
        $users = User::where('nombres','LIKE','%'.$request->buscar.'%')->orWhere('apellidos','LIKE','%'.$request->buscar.'%')->orWhere('doc','LIKE','%'.$request->buscar.'%')->withTrashed()->get();
        $tipoDato = "Resultados de Búsqueda";
        return view('user.index', compact('users','tipoDato'));
    }

    public function simular($id){
        $userToImpersonate = User::find($id);
        Auth::user()->impersonate($userToImpersonate);
        return redirect('/');
    }
}
