<?php

namespace App\Http\Controllers;

use App\Models\DataSeminar;
use App\Models\Programa;
use App\Models\User;
use Illuminate\Http\Request;

use Storage, Session;

class DataSeminarController extends Controller
{
    public function index()
    {
        $docentes = User::where('rol','Docente')->orderBy('nombres')->get();
        $seminarList = Programa::where('tipo','Seminario-Taller')->orderBy('nombre')->get();
        $dataSeminars = DataSeminar::orderBy('prg')->orderBy('sesionID')->get();
        return view('data-seminar.index', compact('dataSeminars','seminarList','docentes'));
    }
    
    public function create()
    {
        $docentes = User::where('rol','Docente')->orderBy('nombres')->get();
        $seminarList = Programa::where('tipo','Seminario-Taller')->orderBy('nombre')->get();
        $dataSeminar = new DataSeminar();
        return view('data-seminar.create', compact('dataSeminar','seminarList','docentes'));
    }
    
    public function store(Request $request)
    {
        Session::put('seminarioSelect',$request->prg);

        if($request->nSesiones){
            DataSeminar::where('prg',$request->prg)->delete();
            for ($i=1; $i <= $request->nSesiones; $i++) { 
                $nDoc = md5(uniqid(rand(), true));
                $sesionID = ($i < 10 ? "0".$i : $i);
                DataSeminar::create(['prg' => $request->prg,'sesionID' => $sesionID, 'docente' => $request->docente,'zoom' => $request->link, 'recurso' => $nDoc]);
            }
            return redirect()->route('data-seminars.index')->with('success', 'Se han creado las sesiones para el seminario satisfactoriamente.');
        } else {
            $nDoc = md5(uniqid(rand(), true));
            if($request->documento){
                $request->file('documento')->storeAs('userfiles/seminarios/', $nDoc.'.pdf');
            }
            $dataSesion = DataSeminar::create(array_merge($request->all(), ['recurso' => $nDoc]));
            return redirect()->route('data-seminars.index')->with('success', 'Sesión agregada satisfactoriamente.');
        }
    }

    public function show($id)
    {
        $dataSeminar = DataSeminar::find($id);

        return view('data-seminar.show', compact('dataSeminar'));
    }
    
    public function edit($id)
    {
        $docentes = User::where('rol','Docente')->orderBy('nombres')->get();
        $seminarList = Programa::where('tipo','Seminario-Taller')->orderBy('nombre')->get();
        $dataSeminar = DataSeminar::find($id);
        return view('data-seminar.edit', compact('dataSeminar','seminarList','docentes'));
    }
    
    public function update(Request $request, DataSeminar $dataSeminar)
    {
        Session::put('seminarioSelect',$dataSeminar->prg);

        if($request->documento){
            $request->file('documento')->storeAs('userfiles/seminarios/', $dataSeminar->recurso.'.pdf');
        }
        //
        request()->validate(DataSeminar::$rules);
        $dataSeminar->update($request->all());
        return redirect()->route('data-seminars.index')->with('success', 'Información de la sesión actualizada.');
    }
    
    public function destroy($id)
    {
        $dataSeminar = DataSeminar::find($id);
        Session::put('seminarioSelect',$dataSeminar->prg);

        $fileF = 'userfiles/seminarios/'.$dataSeminar->recurso.'.pdf';
        if(Storage::exists($fileF)){
            Storage::delete($fileF);
        }
        $dataSeminar->delete();

        return redirect()->route('data-seminars.index')->with('success', 'Sesión eliminada con éxito');
    }
}
