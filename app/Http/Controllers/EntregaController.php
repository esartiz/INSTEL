<?php

namespace App\Http\Controllers;

use App\Models\Entrega;
use Illuminate\Http\Request;

use Storage; 

class EntregaController extends Controller
{
    public function index()
    {
        $entregas = Entrega::orderBy('created_at','DESC')->get();
        return view('entrega.index', compact('entregas'));
    }

    public function create()
    {
        $entrega = new Entrega();
        return view('entrega.create', compact('entrega'));
    }

    public function store(Request $request)
    {
        request()->validate(Entrega::$rules);

        $entrega = Entrega::create($request->all());

        return redirect()->route('entregas.index')
            ->with('success', 'Entrega created successfully.');
    }

    public function show($id)
    {
        $entrega = Entrega::find($id);

        return view('entrega.show', compact('entrega'));
    }
    
    public function edit($id)
    {
        $entrega = Entrega::find($id);

        return view('entrega.edit', compact('entrega'));
    }

    public function update(Request $request, Entrega $entrega)
    {
        request()->validate(Entrega::$rules);

        $entrega->update($request->all());

        return redirect()->route('entregas.index')
            ->with('success', 'Entrega updated successfully');
    }

    public function destroy($id)
    {
        $entrega = Entrega::find($id);
        $file_old = "";
        if(str_contains($entrega->tarea()->first()->tipo_rta, 'audio')){
            $file_old = 'userfiles/entregas/audio/'.$entrega->idUnico.'.mp3';
        }
        if(str_contains($entrega->tarea()->first()->tipo_rta, 'pdf')){
            $file_old = 'userfiles/entregas/pdf/'.$entrega->idUnico.'.pdf';
        }
        
        if(Storage::exists($file_old)){
            Storage::delete($file_old);
        }

        $entrega->delete();

        return redirect()->route('entr.index')->with('success', 'Entrega eliminada');
    }
}
