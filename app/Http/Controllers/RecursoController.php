<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use Illuminate\Http\Request;

use Session, Storage;

class RecursoController extends Controller
{
    public function index()
    {
        $recursos = Recurso::paginate();

        return view('recurso.index', compact('recursos'))
            ->with('i', (request()->input('page', 1) - 1) * $recursos->perPage());
    }
    
    public function create()
    {
        $recurso = new Recurso();
        return view('recurso.create', compact('recurso'));
    }
    
    public function store(Request $request)
    {
        $dataExtra = ['modulo' => Session::get('idModulo')->id];
        if($request->hasFile('file')){
            $fext = $request->file('file')->extension();
            $fn_extra = date('dHis');
            $fileNewName = preg_replace('/\W+/', '-', strtolower(trim($request->titulo))).'_'.$fn_extra.'.'.$fext;
            $request->file('file')->storeAs('userfiles/files', $fileNewName);
            $dataExtra['file'] = $fileNewName;
        }
        $dataExtra['fechas'] = "|0|0|0|0|0|0|0|0";
        $dataExtra['cRec'] = md5(uniqid(rand(), true));
        $recurso = Recurso::create(array_merge($request->all(), $dataExtra));

        $rutaFin = 'modulo.view';
        if($request->author != NULL){
            $rutaFin = 'modulo.edit';
        }
        return redirect()->back()->with('success', 'Recurso agregado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recurso = Recurso::find($id);

        return view('recurso.show', compact('recurso'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $recurso = Recurso::find($id);

        return view('recurso.edit', compact('recurso'));
    }
    
    public function update(Request $request, Recurso $recurso)
    {
        $dataExtra = ['modulo' => Session::get('idModulo')->id, 'sem' => $request->sem];

        if($request->hasFile('file')){
            if($recurso->file != ''  && $recurso->file != null){
                $file_old = 'userfiles/files/'.$recurso->file;
                if(Storage::exists($file_old)){
                    Storage::delete($file_old);
                }
            }
            $fext = $request->file('file')->extension();
            $fileNewName = preg_replace('/\W+/', '-', strtolower(trim($request->titulo))).'_'.date('siHd').'.'.$fext;
            $request->file('file')->storeAs('userfiles/files/', $fileNewName);
            $dataExtra['file'] = $fileNewName;
        }

        $recurso->update(array_merge($request->all(), $dataExtra));
        return redirect()->back()->with('success', 'Recurso actualizado correctamente');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $recurso = Recurso::find($id);
        $file_old = 'userfiles/files/'.$recurso->file;
        if(Storage::exists($file_old)){
            Storage::delete($file_old);
        }

        $recurso->delete();

        return redirect()->back()->with('success', 'Recurso eliminado.');
    }
}
