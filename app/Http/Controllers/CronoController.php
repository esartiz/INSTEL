<?php

namespace App\Http\Controllers;

use App\Models\Crono;
use Illuminate\Http\Request;

/**
 * Class CronoController
 * @package App\Http\Controllers
 */
class CronoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cronos = Crono::paginate();

        return view('crono.index', compact('cronos'))
            ->with('i', (request()->input('page', 1) - 1) * $cronos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $crono = new Crono();
        return view('crono.create', compact('crono'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Crono::$rules);

        $crono = Crono::create($request->all());

        return redirect()->route('cronos.index')
            ->with('success', 'Periodo de tiempo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $crono = Crono::find($id);

        return view('crono.show', compact('crono'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $crono = Crono::find($id);

        return view('crono.edit', compact('crono'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Crono $crono
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Crono $crono)
    {
        request()->validate(Crono::$rules);

        $crono->update($request->all());

        return redirect()->route('cronos.index')
            ->with('success', 'Periodo de tiempo editado');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $crono = Crono::find($id)->delete();

        return redirect()->route('cronos.index')
            ->with('success', 'Se ha eliminado el periodo de tiempo seleccionado');
    }
}
