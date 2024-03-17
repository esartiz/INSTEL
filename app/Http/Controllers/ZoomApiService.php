<?php

namespace App\Http\Controllers;

use App\Models\DataSesion;
use App\Models\Evento;
use App\Models\Modulo;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ZoomApiService extends Controller
{
    public function index($fecha){
        $filtro = ($fecha == 0 ? date('Y-m-d') : $fecha );
        $diaIni = Carbon::parse($filtro)->startOfWeek();
        $diasSemana = [];
        $theWeek = [];
        for ($i = 0; $i < 6; $i++) {
            $diasSemana[$i] = $diaIni->format('Y-m-d');
            $diaIni->addDay();
        }
        $eventos = Evento::where('fecha', '>=', $diasSemana[0])->where('fecha', '<=', $diasSemana[5])->get();
        $modulos = Modulo::orderBy('titulo')->get();
        $sesiones = DataSesion::where('fecha', '>=', $diasSemana[0])->where('fecha', '<=', $diasSemana[5])->get();
        $theWeek[1] = Carbon::parse($filtro)->addWeek();
        $theWeek[0] = Carbon::parse($filtro)->subWeek();
        return view('zoom.lista',compact('sesiones', 'diasSemana','modulos','eventos','theWeek'));
    }

    public function createMeeting(Request $request){
        $nFecha = Carbon::parse($request->fecha);
        $repet = ($request->opcion == "si" ? $request->msemanas : 1);
            for ($i=0; $i < $repet; $i++) { 
                $addEvent = Evento::create([
                    'modulo' => $request->modulo,
                    'grupo' => $request->grupo,
                    'fecha' => $nFecha,
                    'sala' => $request->sala,
                    'link' => $request->link,
                    'firma' => Auth::user()->nombres,
                    'nombre' => ($request->nombre ? $request->nombre : ($request->preNombre == "Clase" ? "Unidad ".($i+1) : "Práctica").' '.$request->nombremd)
                ]);
                $nFecha = $nFecha->addWeek();
            }
        return back()->with('success', 'Se programó la actividad satisfactoriamente');
    }

    public function deleteEvent(Request $request){
        $deleteEvent = Evento::find($request->deleteme)->delete();
        return back()->with('success', 'Evento eliminado satisfactoriamente');
    }

    public function editarMeeting(Request $request, $id){
        $nCh = Evento::find($id)->update([
            'grupo' => $request->grupo,
            'fecha' => $request->fecha,
            'sala' => $request->sala,
            'link' => $request->link,
            'nombre' => $request->nombre
        ]);
        return back()->with('success', 'Se programó la actividad satisfactoriamente');
    }
}
