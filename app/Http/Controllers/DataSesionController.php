<?php

namespace App\Http\Controllers;

use App\Models\DataSesion;
use App\Models\DataSeminar;
use App\Models\User;
use Illuminate\Http\Request;

class DataSesionController extends Controller
{
    
    public function index()
    {
        $listaDocente = User::where('rol','Docente')->orderBy('apellidos', 'ASC')->get();
        $dataSesions = DataSesion::where('status',0)->join('users', 'data_sesions.user', '=', 'users.id')->orderBy('users.apellidos')->select('data_sesions.id as id', 'users.id as idUser', 'nombres','apellidos','docente','zoom','fecha','retro','seminarID','repositorio','cuentaZoom')->get();
        return view('data-sesion.index', compact('dataSesions','listaDocente'));
    }
    
    public function create()
    {
        $dataSesion = new DataSesion();
        return view('data-sesion.create', compact('dataSesion'));
    }
    
    public function store(Request $request)
    {
        $getSesiones = DataSeminar::where('prg',$request->programa)->get();
        $f1 = $request->fecha1;
        $semanaSanta = [strtotime("2024-03-24"),strtotime("2024-03-30")];
        foreach ($getSesiones as $item) {
            //Si hay sesiones creadas, las elimina
            $checkSession = DataSesion::where('user',$request->user)->where('seminarID', $item->id)->where('status',0);
            if($checkSession->count() > 0) {
                $checkSession->delete();
            }
            $dataSesion = DataSesion::create(['seminarID' => $item->id, 'docente' => $item->docente, 'zoom' => NULL, 'cuentaZoom' => NULL, 'fecha' => $f1, 'status' => 0,'user' => $request->user]);
            $f1 = date('Y-m-d',strtotime("+7 day", strtotime($f1)));
            if (strtotime($f1) >= $semanaSanta[0] && strtotime($f1) <= $semanaSanta[1]){
                $f1 = date('Y-m-d',strtotime("+7 day", strtotime($f1)));
            }        
        }
        return redirect()->back()->with('success', 'Sesiones creadas para el usuario satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataSesion = DataSesion::find($id);

        return view('data-sesion.show', compact('dataSesion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $listaDocente = User::where('rol','Docente')->orderBy('apellidos', 'ASC')->get();
        $dataSesion = DataSesion::find($id);
        return view('data-sesion.edit', compact('dataSesion','listaDocente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  DataSesion $dataSesion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DataSesion $dataSesion)
    {
        $dataSesion->update($request->all());
        return redirect()->back()->with('success', 'Sesión modificada con éxito.');
    }
    
    public function destroy($id)
    {
        $dataSesion = DataSesion::where('user', $id)->where('status',0)->delete();
        return redirect()->back()->with('success', 'Sesiones eliminadas a este usuario');
    }
}
