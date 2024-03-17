<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use App\Models\Modulo;
use Illuminate\Http\Request;

class SalaController extends Controller
{
    public function index()
    {
        $salasLista = Sala::orderBy('n_sala')->get();
        $losModulos = Modulo::whereNotNull('docente')->orderBy('titulo')->get();
        return view('salas.base', compact('salasLista','losModulos'));
    }
    
    public function create()
    {
        $sala = new Sala();
        return view('salas.index', compact('sala'));
    }

    public function store(Request $request)
    {
        $datos = $request->except(['_token','_method']);
        if($datos['asignada'] == "0"){ $datos['asignada'] = NULL; }
        $datos['n_sala'] = $request->nn1.'|'.$request->nn2;
        $datos['link'] = date('YmdHis');
        $sala = Sala::create($datos);

        return redirect()->back()->with('success', 'Sala creada con éxito');
    }
    
    public function show($id)
    {
        
    }
    
    public function edit($id)
    {
        
    }
    
    public function update(Request $request, Sala $sala)
    {
        $datos = $request->except(['_token','_method']);
        $datos['n_sala'] = $request->nn1.'|'.$request->nn2;
        $datos['asignada'] = ($request->asignada == 0 ? NULL : $request->asignada);

        $sala->update($datos);

        return redirect()->back()->with('success', 'Sala editada con éxito');

    }
    
    public function destroy($id)
    {
        $sala = Sala::find($id)->delete();

        return redirect()->back()->with('success', 'Sala eliminada con éxito');

    }
}
