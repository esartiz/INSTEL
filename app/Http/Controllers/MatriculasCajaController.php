<?php

namespace App\Http\Controllers;

use App\Models\MatriculasCaja;
use App\Models\Modulo;
use App\Models\Matricula;
use App\Models\DataSeminar;
use App\Models\DataSesion;
use App\Models\Programa;
use App\Models\User_doc;
use Illuminate\Http\Request;
use Auth;

/**
 * Class MatriculasCajaController
 * @package App\Http\Controllers
 */
class MatriculasCajaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matriculasCajas = MatriculasCaja::where('estado', 'ACTIVO')->get();
        return view('matriculas-caja.index', compact('matriculasCajas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $matriculasCaja = new MatriculasCaja();
        return view('matriculas-caja.create', compact('matriculasCaja'));
    }

    public function store(Request $request)
    {
        $datProg = Programa::find($request->prg);
        $status = ($request->estado == "ACTIVO" ? 0 : 1);
        $matBox = ['user' => $request->user, 'estado' => $request->estado, 'prg' => $request->prg, 'nivel' => $request->nivel, 'periodo' => $request->periodo, 'fechaIngreso' => $request->fechaIngreso, 'otros' => Auth::user()->nombres];

        switch ($datProg->tipo) {
            case 'Seminario-Taller':
                $matriculasCaja = MatriculasCaja::create($matBox);
                $this->addSeminarMatrBox($request->user, $status, $datProg->id, $request->fechaIngreso, $matriculasCaja->id);
                break;
            case 'Paquete Seminario':
                $listaSem = explode('|', $datProg->estructura);
                $nFecha = $request->fechaIngreso;
                foreach ($listaSem as $item) {
                    $matBox = ['user' => $request->user, 'estado' => $request->estado, 'prg' => $item, 'nivel' => '0', 'periodo' => $request->periodo, 'fechaIngreso' => $nFecha, 'otros' => Auth::user()->nombres];
                    $matriculasCaja = MatriculasCaja::create($matBox);
                    $nFecha = $this->addSeminarMatrBox($request->user, $status, $item, $nFecha, $matriculasCaja->id);
                }
                break;
            default:
                //Crea la matricula primero 
                $matriculasCaja = MatriculasCaja::create($matBox);
                //Agrega los módulos que el estudiante debe ver en esa matrícula
                $listaMateria = Modulo::where('programa', $datProg->id)->where('ciclo', $request->nivel)->get();
                foreach ($listaMateria as $item) {
                    Matricula::updateOrCreate(
                        ['estudiante' => $request->user, 'materia' => $item->id],
                        array('box' => $matriculasCaja->id, 'materia' => $item->id, 'n_materia' => $item->titulo, 'sem' => $item->ciclo, 'estudiante' => $request->user, 'grupo' => $request->periodo, 'status' => $status)
                    );
                }
                break;
        }
        /*

        if($datProg->tipo == "Técnico Laboral" || "Certificaciones" || "Diplomado"){
            //Agrega los módulos que el estudiante debe ver en esa matrícula
            $listaMateria = Modulo::where('programa', $datProg->id)->where('ciclo', $request->nivel)->get();
            foreach ($listaMateria as $item) {
                Matricula::updateOrCreate(
                    ['estudiante' => $request->user, 'materia' => $item->id],
                    array('materia' => $item->id, 'n_materia' => $item->titulo, 'sem' => $item->ciclo, 'estudiante' => $request->user, 'grupo' => $request->periodo, 'status' => $status)
                );
            }
            $matriculasCaja = MatriculasCaja::create($matBox);
        } 
        if($datProg->tipo == "Seminario-Taller"){
            $this->addSeminarMatrBox($request->user, $status, $datProg->id, $request->fechaIngreso);
            $matriculasCaja = MatriculasCaja::create($matBox);
        }  
        if($datProg->tipo == "Paquete Seminario"){
            $listaSem = explode('|', $datProg->estructura);
            $nFecha = $request->fechaIngreso;
            foreach ($listaSem as $item) {
                $matBox = ['user' => $request->user, 'estado' => $request->estado, 'prg' => $item, 'nivel' => '0', 'periodo' => $request->periodo, 'fechaIngreso' => $nFecha, 'otros' => Auth::user()->nombres];
                $matriculasCaja = MatriculasCaja::create($matBox);
                $nFecha = $this->addSeminarMatrBox($request->user, $status, $item, $nFecha);
            }
        }
        */
        return redirect()->back()->with('success', 'Matrícula agregada al estudiante');
    }

    public function addSeminarMatrBox($user, $status, $elPrg, $f1, $box)
    {
        $getSesiones = DataSeminar::where('prg', $elPrg)->get();
        $semanaSanta = [strtotime("2024-03-24"), strtotime("2024-03-30")];
        foreach ($getSesiones as $item) {
            DataSesion::updateOrCreate(
                ['user' => $user, 'seminarID' => $item->id],
                array('docente' => NULL, 'zoom' => $item->zoom, 'cuentaZoom' => NULL, 'fecha' => $f1, 'status' => $status, 'box' => $box)
            );
            $f1 = date('Y-m-d', strtotime("+7 day", strtotime($f1)));
            if (strtotime($f1) >= $semanaSanta[0] && strtotime($f1) <= $semanaSanta[1]) {
                $f1 = date('Y-m-d', strtotime("+7 day", strtotime($f1)));
            }
        }
        return $f1;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $matriculasCaja = MatriculasCaja::find($id);

        return view('matriculas-caja.show', compact('matriculasCaja'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $matriculasCaja = MatriculasCaja::find($id);

        return view('matriculas-caja.edit', compact('matriculasCaja'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  MatriculasCaja $matriculasCaja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $laMatBox = MatriculasCaja::find($id);
        //Activa o desactiva los módulos o sesiones contenidas así como el periodo de los mismos.
        $idCambia = explode('|', $request->contenidoMat);
        for ($i = 0; $i < count($idCambia); $i++) {
            if ($request->tipoPrgMat == "Seminario-Taller") {
                $f = DataSesion::find($idCambia[$i]);
            } else {
                $f = Matricula::find($idCambia[$i]);
            }
            if ($f) {
                $f->update(['grupo' => $request->periodo_ed, 'status' => ($request->estado_ed == "ACTIVO" ? 0 : 1), 'def' => (($f->n1 * 0.3) + ($f->n2 * 0.3) + ($f->n3 * 0.4))]);
            }
        }
        $laMatBox->update([
            'periodo' => $request->periodo_ed,
            'estado' => $request->estado_ed,
            'fechaEgreso' => $request->fechaEgreso,
            'acta' => $request->acta,
            'folio' => $request->folio
        ]);
        //Si es un Seminario Taller y pasa a GRADUADO, genera el certificado
        if($request->estado_ed == "GRADUADO"){
            //Si se trata de un graduado al que se le asigna certificación internacional
            if($request->especial === '1'){
                //Tomo el último consecutivo
                $datConsc = User_doc::where('descr', 'LIKE', '%europacampus%')->orderBy('descr', 'DESC');
                $ultimoConsecutivo = ($datConsc->count() > 0 ? explode('|', $datConsc->first()->descr)[0] : '2023-001');
                list($year, $consecutivoActual) = explode('-', $ultimoConsecutivo);
                $nuevoConsecutivo = intval($consecutivoActual) + 1;
                $formattedNuevoConsecutivo = sprintf('%03d', $nuevoConsecutivo);
                $nConsc = date('Y') . '-' . $formattedNuevoConsecutivo;
                User_doc::create([
                    'user' => $laMatBox->user,
                    'file' => md5(uniqid(rand(), true)),
                    'descr' => $nConsc .'|'. $laMatBox->getPrograma()->tipo . '|'. $laMatBox->getPrograma()->nombre . '|' . $laMatBox->getPrograma()->duracion . '|' . $request->fechaEgreso . '|europacampus'
                ]);
            }
            //Si es un seminario crea el diploma
            if ($request->tipoPrgMat == "Seminario-Taller"){
                User_doc::create([
                    'user' => $laMatBox->user,
                    'file' => md5(uniqid(rand(), true)),
                    'descr' => $laMatBox->getPrograma()->nombre . '|' . $laMatBox->getPrograma()->duracion . '|' . $request->fechaEgreso . '|INSTEL'
                ]);
            }
        }
        return redirect()->back()->with('success', 'Matrícula actualizada. Se cambiaron como ' . $request->estado . ' el contenido de los módulos / sesiones');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id, Request $request)
    {
        //Si es una eliminación sencilla
        if ($request->tipo == "0") {
            $msj = "Se eliminó la matrícula del estudiante";
        } else {
            //Si se elimina la matrícula y los módulos del mismo
            $idDelete = explode('|', $request->losID);
            for ($i = 0; $i < count($idDelete); $i++) {
                if ($request->tipo == "Seminario-Taller") {
                    $f = DataSesion::find($idDelete[$i]);
                } else {
                    $f = Matricula::find($idDelete[$i]);
                }
                if ($f) {
                    $f->delete();
                }
            }
            $msj = "Se eliminó la matrícula y los " . count($idDelete) . " módulos contenidos en él";
        }
        $matriculasCaja = MatriculasCaja::find($id)->delete();
        return redirect()->back()->with('success', $msj);
    }
}