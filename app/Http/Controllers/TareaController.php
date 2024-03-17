<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;
use Session, Auth, Storage;

class TareaController extends Controller {
    
    public function index()
    {
        $tareas = Tarea::paginate();

        return view('tarea.index', compact('tareas'))
            ->with('i', (request()->input('page', 1) - 1) * $tareas->perPage());
    }
    
    public function create()
    {
        $tarea = new Tarea();
        return view('tarea.create', compact('tarea'));
    }

    public function store(Request $request)
    {
        $dataExtra = ['modulo' => Session::get('idModulo')->id];

        if($request->hasFile('isAU')){
            $fext = $request->file('isAU')->extension();
            $fn_extra = date('dHis');
            $fileNewName = 'autoevaluacion_'.Session::get('idModulo')->id.'_'.$fn_extra.'.'.$fext;
            $request->file('isAU')->storeAs('userfiles/files/au', $fileNewName);
            $dataExtra['isAU'] = $fileNewName;
        }
        
        if(Auth::user()->rol != "Administrador"){
            $dataExtra['tipo'] = 0;
        }

        $tarea = Tarea::create(array_merge($request->all(), $dataExtra));
        return redirect()->back()->with('success', 'Actividad creada satisfactoriamente.');
    }
    
    public function show($id)
    {
        $tarea = Tarea::find($id);
        return view('tarea.show', compact('tarea'));
    }
    
    public function edit($id)
    {
        $tarea = Tarea::find($id);
        return view('tarea.edit', compact('tarea'));
    }
    
    public function update(Request $request, Tarea $tarea)
    {
        $dataExtra = ['modulo' => Session::get('idModulo')->id];

        if($request->hasFile('isAU')){
            if($tarea->isAU != ''  && $tarea->isAU != null){
                $file_old = 'userfiles/files/au/'.$tarea->isAU;
                if(Storage::exists($file_old)){
                    Storage::delete($file_old);
                }
            }
            $fext = $request->file('isAU')->extension();
            $fn_extra = date('dHis');
            $fileNewName = 'autoevaluacion_'.Session::get('idModulo')->id.'_'.$fn_extra.'.'.$fext;
            $request->file('isAU')->storeAs('userfiles/files/au', $fileNewName);
            $dataExtra['isAU'] = $fileNewName;
        }
        $dataExtra['fechas'] = '|'.$request->ord.'|'.$request->ord.'|'.$request->ord.'|'.$request->ord.'|'.$request->ord.'|'.$request->ord.'|'.$request->ord.'|'.$request->ord;
        $tarea->update(array_merge($request->all(), $dataExtra));
        return redirect()->back()->with('success', 'Actividad modificada .');
    }
    
    public function destroy($id) {
        $tt = Tarea::find($id);
        $file_old = 'userfiles/files/au/'.$tt->isAU;
        if(Storage::exists($file_old)){
            Storage::delete($file_old);
        }
        $tt->delete();
        return redirect()->back()->with('success', 'Actividad eliminada del módulo');
    }
}
