<?php

namespace App\Http\Controllers;

use App\Models\Graduando;
use App\Models\Programa;
use Illuminate\Http\Request;

class GraduandoController extends Controller {
    
    public function index()
    {
        $graduandos = Graduando::paginate();

        return view('certificados.index', compact('graduandos'))
            ->with('i', (request()->input('page', 1) - 1) * $graduandos->perPage());
    }
    
    public function create()
    {
        $graduando = new Graduando();
        return view('certificados.create', compact('graduando'));
    }
    
    public function store(Request $request) {
        $data = $request->except(['_token','_method']);
        $data['idUnico'] = md5(uniqid(rand(), true));
        Graduando::create($data);
        return back()->with('success', 'Se ha generado el certificado en el perfil del estudiante');
    }
    
    public function show($id)
    {
        $graduando = Graduando::find($id);
        return view('certificados.show', compact('graduando'));
    }
    
    public function edit($id)
    {
        $graduando = Graduando::find($id);
        $programas = Programa::where('tipo','Seminario-Taller')->orderBy('nombre')->get();
        return view('certificados.edit', compact('graduando','programas'));
    }
    
    public function update(Request $request, $id)
    {
        $elGraduando = Graduando::find($id);
        $elGraduando->update($request->all());
        return back()->with('success', 'Se actualizó el certificado.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $graduando = Graduando::find($id)->delete();

        return back()->with('success', 'Se ha eliminó el certificado.');

    }
}
