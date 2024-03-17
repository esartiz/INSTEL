<?php

namespace App\Http\Controllers;

use App\Models\FConcepto;
use Illuminate\Http\Request;

/**
 * Class FConceptoController
 * @package App\Http\Controllers
 */
class FConceptoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fConceptos = FConcepto::paginate();

        return view('f-concepto.index', compact('fConceptos'))
            ->with('i', (request()->input('page', 1) - 1) * $fConceptos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fConcepto = new FConcepto();
        return view('f-concepto.create', compact('fConcepto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(FConcepto::$rules);

        $fConcepto = FConcepto::create($request->all());

        return redirect()->route('f-conceptos.index')
            ->with('success', 'FConcepto created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fConcepto = FConcepto::find($id);

        return view('f-concepto.show', compact('fConcepto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fConcepto = FConcepto::find($id);

        return view('f-concepto.edit', compact('fConcepto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  FConcepto $fConcepto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FConcepto $fConcepto)
    {
        request()->validate(FConcepto::$rules);

        $fConcepto->update($request->all());

        return redirect()->route('f-conceptos.index')
            ->with('success', 'FConcepto updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $fConcepto = FConcepto::find($id)->delete();

        return redirect()->route('f-conceptos.index')
            ->with('success', 'FConcepto deleted successfully');
    }
}
