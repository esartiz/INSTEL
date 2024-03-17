<?php

namespace App\Http\Controllers;

use App\Models\PruebasCaja;
use App\Models\Siet;
use Illuminate\Http\Request;
use App\Models\Anuncio;
use App\Models\DataSesion;
use App\Models\User_log;
use App\Models\Repositorio;
use App\Models\Inscripciones;
use App\Models\Graduando;
use App\Models\User;
use App\Models\Programa;
use App\Models\Matricula;
use App\Models\Entrega;
use App\Models\Tarea;
use App\Models\Modulo;
use App\Models\User_doc;
use App\Models\Encuesta;
use App\Models\FBill;
use App\Models\MatriculasCaja;
use App\Models\Prueba;
use App\Models\Assignment;
use Barryvdh\DomPDF\Facade\Pdf;
use Luecano\NumeroALetras\NumeroALetras;
use Carbon\Carbon;

use Auth, Session, Storage, DB;

class Administrador extends Controller
{
    public function __construct()
    {
        $this->middleware('Administrador');
    }
    public function index()
    {
        $listaModulos = Modulo::orderBy('titulo')->get();
        $anuncio = Anuncio::where('modulo', NULL)->whereDate('vence', '>=', now())->orWhere('vence', '2022-01-01 00:00:00')->orderBy('vence', 'ASC')->get();
        $programas = Programa::orderBy('nombre', 'ASC')->get();
        $estudiantes = User::whereNull('deleted_at')->orderBy('apellidos', 'ASC')->get();
        return view('admin.index', compact('anuncio', 'listaModulos', 'programas', 'estudiantes'));
    }
    public function logUser()
    {
        $fecha2dias = date("Y-m-d H:i:s", strtotime(date('Y-m-d H:i:s') . "- 3 days"));
        $dataLog = User_log::where('fecha', '>', $fecha2dias)->orderBy('fecha', 'DESC')->get();
        return view('admin.log', compact('dataLog'));
    }
    public function repositorioadd(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        Repositorio::create($data);
        return back()->with('success', 'Link de la clase cargado satisfactoriamente');
    }
    public function repositoriodel($id)
    {
        $tt = Repositorio::find($id);
        $tt->delete();
        return back()->with('success', 'Link de la clase se ha eliminado');
    }

    //Inscripciones
    public function inscripcioneslist()
    {
        $req = Inscripciones::orderBy('fechaForm', 'DESC')->get();
        return view('admin.inscripciones', compact('req'));
    }
    public function inscripcionesDel($id)
    {
        $req = Inscripciones::find($id);
        $req->delete();
        return back()->with('success', 'Inscripción eliminada');
    }

    public function addCertificado($id)
    {
        $user = User::find($id);
        $graduados = Graduando::orderBy('fecha', 'DESC')->get();
        $programas = Programa::where('tipo', 'Seminario-Taller')->orderBy('nombre')->get();
        return view('certificados.index', compact('user', 'graduados', 'programas'));
    }

    public function verListaUsers()
    {
        $users = User::all();
        return view('admin.lista', compact('users'));
    }

    public function blacklist($id)
    {
        $mID = Matricula::find($id);
        if ($mID) {
            $mID->update((is_null($mID->hab) ? array('hab' => 0.0) : array('hab' => NULL)));
            return redirect('/blacklist/lista')->with('success', 'El estado de la recuperación ha cambiado');
        }
        $lista = Matricula::where('status', 0)->get();
        $entrega = Entrega::where('retro', '')->get();
        return view('estudiante.blacklist', compact('lista', 'entrega'));
    }

    public function repone($id)
    {
        $data = explode("|", $id);
        $mID = Matricula::find($data[0]);
        //
        $recupHechas = ($mID == NULL ? '' : explode(",", $mID->rem));
        //Si está en la lista, quítelo si no, agruéguelo
        if (in_array($data[1], $recupHechas)) {
            foreach (array_keys($recupHechas, $data[1], true) as $key) {
                unset($recupHechas[$key]);
            }
        } else {
            array_push($recupHechas, $data[1]);
        }
        $mID->update(['rem' => (count($recupHechas) == 1 ? NULL : implode(",", $recupHechas))]);
        return redirect('/blacklist/lista')->with('success', 'Reposición actualizada');
    }

    public function infoGeneral()
    {
        $losProgramas = Programa::orderBy('tipo')->orderBy('nombre')->get();
        //
        $recursos = Repositorio::where('modulo', NULL)->get();
        return view('admin.infogeneral', compact('recursos', 'losProgramas'));
    }

    public function infoGeneralStore(Request $request)
    {
        $dt = "";
        if ($request->link != null) {
            //Crear un link de repositorio
            Repositorio::create(['modulo' => NULL, 'nombre' => 'video|' . $request->programa . '|' . $request->nombre, 'ruta' => $request->link, 'grupo' => $request->grupo]);
            $dt = "Se cargó el video de repositorio";
        }
        if ($request->documento) {
            //Crear documento
            $nDoc = md5(uniqid(rand(), true)) . '.pdf';
            $request->file('documento')->storeAs('userfiles/files/', $nDoc);
            Repositorio::create(['modulo' => NULL, 'nombre' => 'pdf|' . $request->programa . '|' . $request->nombre, 'ruta' => $nDoc, 'grupo' => $request->grupo]);
            $dt = "Se creó el documento satisfactoriamente";
        }
        $dt = ($dt == "" ? "No subió ningún archivo ni tampoco un link" : $dt);
        return redirect()->back()->with('success', $dt);
    }

    public function infoGeneralDelete($id)
    {
        $deleteMe = Repositorio::find($id);
        $file_old = 'userfiles/files/' . $deleteMe->ruta;
        if (Storage::exists($file_old)) {
            Storage::delete($file_old);
        }
        $deleteMe->delete();
        return redirect()->back()->with('success', 'El recurso se ha eliminado');
    }

    public function sabana()
    {
        $programas = Programa::all();
        $estudiantes = User::where('rol', 'Estudiante')->orderBy('apellidos')->get();
        $matricula = Matricula::where('status', 0)->get();
        return view('admin.sabana', compact('programas', 'estudiantes', 'matricula'));
    }

    //Ver encuestas
    public function encuestas()
    {
        $dataEnc = Encuesta::all();
        return view('encuesta.index', compact('dataEnc'));
    }

    public function archivarModulo(Request $request)
    {
        $modArchivo = Matricula::where('id', $request->id)->first();
        //Revisa si la nota final obedece a una habilitación o a la nota promediada
        if ($modArchivo->hab == NULL) {
            $notaPromedio = number_format($modArchivo->n1 * 0.3 + $modArchivo->n2 * 0.3 + $modArchivo->n3 * 0.4, 1, '.', '');
            $resultado = ($notaPromedio < 3.5 ? 'No Aprobado' : 'Aprobado');
        } else {
            $notaPromedio = $modArchivo->hab;
            $resultado = ($notaPromedio < 3.5 ? 'Habilitación No Aprobada' : 'Habilitación Aprobada');
        }
        //Reviso si es una reposición y a cuál corresponde
        $resultado .= ($modArchivo->rem != NULL ? ' con Reposición' : '');
        $modArchivo->update(['status' => $request->laAccion, 'def' => $notaPromedio, 'resultado' => $resultado]);
    }

    public function matricularModulo(Request $request)
    {
        Matricula::create(array('materia' => $request->materia, 'n_materia' => $request->n_materia, 'sem' => $request->sem, 'estudiante' => $request->user, 'grupo' => $request->grupo, 'status' => 0));
    }

    public function addCNotas($id)
    {
        $formatter = new NumeroALetras();
        $formatter->conector = ' ';
        $data = explode('-', $id);
        $tipoCert = $data[0];

        $lasMatriculas = MatriculasCaja::where('user', $data[1])->orderBy('nivel')->get();
        //return view('estudiante.cnotas', compact('lasMatriculas', 'tipoCert', 'formatter'));
        $pdf = Pdf::loadView('estudiante.cnotas', compact('lasMatriculas', 'tipoCert', 'formatter'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream();
    }

    public function editaNota(Request $request)
    {
        $matricula = Matricula::find($request->idMatr);
        $matricula->update($request->all());
        return redirect()->back()->with('success', 'Nota modificada con éxito');
    }

    public function ajusteNotas(Request $request)
    {
        $mID = Matricula::find($request->idMatr);
        $notaPromedio = number_format(($request->parcial1 * 0.3) + ($request->parcial2 * 0.3) + ($request->parcial3 * 0.4), 1, '.', '');
        if ($mID) {
            $mID->update([
                'n1' => $request->parcial1,
                'n2' => $request->parcial2,
                'n3' => $request->parcial3,
                'def' => $notaPromedio
            ]);
        }
        return "Data saved";
    }

    public function addRegistroAc(Request $request, $user){
        $datRegAc = "Registro Académico|".$request->gradoAnt;
        for ($i = 0; $i < count($request->empresa); $i++) {
            $datRegAc .= '|<table>
            <tr>
                <td><b>Empresa:</b></td>
                <td>'.$request->empresa[$i].'</td>
                <td><b>Teléfono:</b></td>
                <td>'.$request->telefono[$i].'</td>
            </tr>
            <tr>
                <td><b>Tipo Experiencia:</b></td>
                <td>'.$request->tipo_experiencia[$i].'</td>
                <td><b>Duración: </b></td>
                <td>'.$request->tiempo_labor[$i].'</td>
            </tr><tr>
                <td><b>Labores Realizadas:</b></td>
                <td colspan="3">'.str_replace(array("\r\n", "\r", "\n"), '<br>', $request->labores_realizadas[$i]).'</td>
            </tr>
            </table>';
        }
        User_doc::create([
            'user' => $user,
            'file' => md5(uniqid(rand(), true)),
            'descr' => $datRegAc
        ]);
        return redirect()->back()->with('success', 'Registro académico creado con éxito');
    }

    public function promedios(Request $request)
    {
        $listaEst = MatriculasCaja::where('prg', 1)->where('periodo', $request->grupo)->where('nivel', $request->ciclo)->get();
        return view('admin.promedios', compact('listaEst'));
    }
    public function promedios_totales()
    {
        $results = MatriculasCaja::where('estado','ACTIVO')->get();
        /*
        //matriculas.estudiante = users.id WHERE users.deleted_at IS NULL GROUP BY estudiante, sem ORDER BY estudiante ASC, sem ASC;



        $results = Matricula::join('users', 'matriculas.estudiante', '=', 'users.id')
            ->whereNull('users.deleted_at')
            ->where('users.rol', 'Estudiante')
            ->where('users.prg', 1)
            ->select('estudiante', 'sem', DB::raw('SUM(def) as consol'), DB::raw('COUNT(hab) as hbts'), DB::raw('COUNT(rem) as rcp'), DB::raw('COUNT(n_materia) as totalMat'))
            ->groupBy('estudiante', 'sem')
            ->get();
        */

        return view('admin.promedios_total', compact('results'));
    }

    public function homeAdmin()
    {
        $users = User::all();
        $pagosAviso = FBill::where('status','0')->get();

        /*
        $daysOfWeek = [];
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();
        while ($startDate->lte($endDate)) {
            $daysOfWeek[] = $startDate->format('Y-m-d'); // Agrega la fecha al arreglo en formato 'Y-m-d'
            $startDate->addDay(); // Avanza al siguiente día
        }
        $pagosAviso = FBill::orWhere('plan', 'LIKE', '%' . $daysOfWeek[0] . '%')
            ->orWhere('plan', 'LIKE', '%' . $daysOfWeek[1] . '%')
            ->orWhere('plan', 'LIKE', '%' . $daysOfWeek[2] . '%')
            ->orWhere('plan', 'LIKE', '%' . $daysOfWeek[3] . '%')
            ->orWhere('plan', 'LIKE', '%' . $daysOfWeek[4] . '%')
            ->orWhere('plan', 'LIKE', '%' . $daysOfWeek[5] . '%')
            ->orWhere('plan', 'LIKE', '%' . $daysOfWeek[6] . '%')
            ->get();
        */
        $cajaMatr = MatriculasCaja::where('estado', 'ACTIVO')->get();

        //Me muestra los inscritos de las ulitmas 24 horas
        $now = Carbon::now();
        $twentyFourHoursAgo = $now->copy()->subHours(24);
        $nuevosI = Inscripciones::whereBetween('fechaForm', [$twentyFourHoursAgo, $now])->get();
        //
        return view('admin.home', compact('users', 'cajaMatr', 'pagosAviso','nuevosI'));
    }

    public function siet()
    {
        $datos = Siet::whereNotNull('pais')->orderBy('updated_at', 'DESC')->get();
        return view('siet.generador', compact('datos'));
    }

    public function crearPruebasAptitud(Request $request)
    {
        $dataPrueba = "";
        for ($i = 0; $i <= 9; $i++) {
            $dataPrueba .= $request['prueba' . $i] . '|';
        }
        User_doc::create([
            'user' => $request->user,
            'file' => md5(uniqid(rand(), true)),
            'descr' => $dataPrueba
        ]);
        return redirect()->back()->with('success', 'Informe de Prueba de Aptitud creada con éxito');
    }

    public function generadorbckp(Request $request)
    {
        $matriculas = MatriculasCaja::select('matriculas_cajas.*')
            ->join('users', 'matriculas_cajas.user', '=', 'users.id')
            ->where('matriculas_cajas.prg', $request->prg)
            ->where('matriculas_cajas.periodo', $request->year . $request->periodo)
            ->orderBy('matriculas_cajas.nivel')
            ->orderBy('users.apellidos')
            ->get();
        $pdf = Pdf::loadView('admin.backupnotas', compact('matriculas'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->download();
    }

    //Pruebas de aptitud INSTEL
    public function paindex(){
        $docentes = User::where('rol','Docente')->orderBy('apellidos')->get();
        $matriculas = MatriculasCaja::where('nivel', '9')->where('prg', '1')->where('estado', 'ACTIVO')->get();
        $pruebas = PruebasCaja::all();
        return view('pa.index', compact('docentes','matriculas','pruebas'));
    }

    public function paEdit(Request $request, $id){

        $nn = NULL;
        if ($request->hasFile('archivo')) {
            $extension = $request->file('archivo')->getClientOriginalExtension();
            $nn = md5(uniqid(rand(), true)) .'.'. $extension;
            $documentoPath = $request->file('archivo')->storeAs('userfiles/pruebas', $nn);
        }

        $dtCh = PruebasCaja::find($id)->update([
            'nombre' => $request->nombre,
            'texto' => $request->texto,
            'area' => $request->area,
            'jurado1' => ($request->jurado1 == 0 ? NULL : $request->jurado1),
            'jurado2' => ($request->jurado2 == 0 ? NULL : $request->jurado2),
            'instruccion' => $request->criterio_0.'|'.$request->criterio_1.'|'.$request->criterio_2.'|'.$request->criterio_3.'|'.$request->criterio_4,
            'fecha1' => $request->fecha1,
            'fecha2' => $request->fecha2,
            'anexo' => $nn
        ]);
        return redirect()->back()->with('success', 'Parámetros de la prueba modificados con éxito');
    }

    public function paCrear(Request $request){
        $lasPruebas = PruebasCaja::all();
        foreach ($lasPruebas as $vv) {
            Prueba::create(
                ['idPrueba' => $vv->id, 'codigo' => md5(uniqid(rand(), true)), 'fechaIni' => $vv->fecha1, 'fechafinal' => $vv->fecha2, 'user' => $request->user,'box' => NULL]
            );
        }
        return redirect()->back()->with('success', 'Se crearon las pruebas satisfactoriamente');
    }
    public function paBorrar(Request $request, $id){
        //Si es una elmiminación individual resetea las valoraciones
        if($id == 0){
            $ff = Prueba::find($request->deleteme)->update(
                ['valoracion1' => NULL, 'valoracion2' => NULL, 'observacion1' => NULL, 'observacion2' => NULL]
            );
        } else {
        //Si es una eliminación en bloque por usuario
            $ff = Prueba::where('user', $id)->delete();
        }
        return redirect()->back()->with('success', 'Pruebas eliminadas al estudiante');
    }

    public function c_int_generator(){
        $cert = User_doc::where('descr', 'LIKE', '%europacampus%')->orderBy('descr', 'DESC')->get();
        return view('certificados.index', compact('cert'));
    }
    public function c_int_creator(Request $data){
        $upt = User_doc::find($data->dform_6)->update([
            'descr' => $data->dform_0.'|'.$data->dform_1.'|'.$data->dform_2.'|'.$data->dform_3.'|'.$data->dform_4.'|europacampus'
        ]);
        return redirect()->back()->with('success', 'Certificado actualizado');
    }

    public function asignarModulo(Request $request){
        Assignment::create([
            'user' => $request->docente,
            'modulo' => $request->elModuloAsig,
            'grupo' => $request->periodo,
            'estado' => 0
        ]);
        return redirect()->back()->with('success', 'Módulo asignado satisfactoriamente');
    }

    public function cambiarAsignacion(Request $request){
        $r = Assignment::find($request->vt);
        if($request->dt == "delete"){
            $r->delete();
            $msj = "Asignación eliminada satisfactoriamente.";
        } else {
            $r->update(['estado' => $request->dt]);
            $msj = "Se archivó la asignación con éxito";
        }
        return $msj;
    }
}