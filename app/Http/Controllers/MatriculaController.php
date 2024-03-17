<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\User;
use App\Models\Modulo;
use Illuminate\Http\Request;
use Storage;


class MatriculaController extends Controller
{
    public function index()
    {
        $matriculas = Matricula::paginate();

        return view('matricula.index', compact('matriculas'))
            ->with('i', (request()->input('page', 1) - 1) * $matriculas->perPage());
    }
    
    public function create()
    {
        $matricula = new Matricula();
        return view('matricula.create', compact('matricula'));
    }
    
    public function store(Request $request)
    {
        //Matrícula Recomendada
        if($request->matriculaRecomendada){
            $user = User::find($request->matriculaRecomendada);
            $listaMateria = Modulo::where('programa',$user->prg)->where('ciclo',$user->ciclo)->get();
            foreach ($listaMateria as $item) {
                $r1 = Matricula::where('estudiante', $user->id)->where('materia', $item->id)->first();
                if($r1 == null){
                    Matricula::create(array('materia' => $item->id, 'n_materia' => $item->titulo, 'sem' => $item->ciclo, 'estudiante' => $user->id, 'grupo' => $user->grupo, 'status' => 0));
                }
            }
            return redirect()->route('users.edit', $user->id)->with('success', 'Se matricularon los módulos sugeridos');
        } else {
            //Matricula en bloque

            $dt = explode(",", $request->matriculaMasiva);
            for($a=0; $a<count($dt); $a++){
                $data['materia'] = $dt[$a];
                $r1 = Modulo::find($dt[$a]);
                Matricula::updateOrCreate(
                    ['estudiante' => $request->estudiante, 'materia' => $dt[$a]],
                    array('materia' => $dt[$a], 
                            'n_materia' => $r1->titulo, 
                            'sem' => $request->semestre, 
                            'estudiante' => $request->estudiante, 
                            'grupo' => $request->grupo, 
                            'box' => $request->elBox,
                            'status' => '0')
                );
            }
            return redirect()->back()->with('success', 'Módulos matriculados satisfactoriamente');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $matricula = Matricula::find($id);

        return view('matricula.show', compact('matricula'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $matricula = Matricula::find($id);

        return view('matricula.edit', compact('matricula'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Matricula $matricula
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matricula $matricula)
    {
        request()->validate(Matricula::$rules);

        $matricula->update($request->all());

        return redirect()->route('matriculas.index')
            ->with('success', 'Matricula updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $matricula = Matricula::find($id)->delete();

        return redirect()->back()->with('success', 'Se ha desvinculado el módulo al usuario');
    }

    public function modulo_est(Request $request){
        for($a=0; $a<count($request->losEstudiantes); $a++){
            $elEst = $request->losEstudiantes[$a];
            $r1 = Matricula::where('estudiante', $elEst)->where('materia', $request->modulo)->first();
            if($r1 == null){
                $data['materia'] = $request->modulo;
                $data['estudiante'] = $elEst;
                $data['grupo'] = User::find($elEst)->grupo;
                $data['status'] = 0;
                $matricula = Matricula::create($data);
            }
        }
        return redirect()->back()
            ->with('success', 'Estudiantes agregados al módulo satisfactoriamente');
    }

    
    public function doc_save(Request $request){
        //return response()->json($request);

        $fext = $request->file('archivo')->extension();
        $fileNewName = $request->idFile.'.'.$fext;
        $request->file('archivo')->storeAs('userfiles/profiles/'.$request->tipoFile.'/', $fileNewName);
        return redirect()->back()
            ->with('success', 'Archivo cargado');
    }
}
