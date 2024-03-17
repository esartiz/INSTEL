<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth, Session;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Datos globales de la aplicación
        $configuracion = [
            "ciclos" => [
                ["id" => "1", "nm" =>"Primer Ciclo"],
                ["id" => "2", "nm" =>"Segundo Ciclo"],
                ["id" => "3", "nm" =>"Tercer Ciclo"],
                ["id" => "4PTV", "nm" =>"Fase Profundización Presentación de TV"],
                ["id" => "4PLC", "nm" =>"Fase Profundización Locución Comercial"],
                ["id" => "5", "nm" =>"Proceso Técnico de Certificación Académica para Locutores Empíricos"],
                ["id" => "6", "nm" =>"Diplomado en Comunicación Organizacional & Jefatura de Prensa"],
                ["id" => "7", "nm" =>"Proceso Técnico de Certificación Académica en Periodismo con énfasis en Reportería"],
                ["id" => "8", "nm" =>"Proceso Técnico de Actualización y Certificación para Egresados Antiguos"],
                ["id" => "9", "nm" =>"Homologación Técnica para Egresados en Comunicación de otras instituciones"],
                ["id" => "10", "nm" =>"Seminarios"]
            ],
            "tipodoc" => ["CC","TI","CE","DNI","PEP","OTR"],
            "sexo" => ["Femenino", "Masculino"],
            "rol" => ["Estudiante","Docente","Administrador","Egresado","Inscrito","Inactivo"],
            "nombrePeriodos" => ["", "ENERO-JUNIO","MARZO-AGOSTO","JULIO-DICIEMBRE","SEPTIEMBRE-FEBRERO", "ENERO-JUNIO SAB","MARZO-AGOSTO SAB","JULIO-DICIEMBRE SAB","SEPTIEMBRE-FEBRERO SAB"],
            "gruposNombre" => ["", "A","B","C","D","AS","BS","CS","DS"]
        ];
        Session::put('config',$configuracion);

        return redirect()->route(strtolower(Auth::user()->rol));
    }

    

    public function updateToken(Request $request){
        try{
            $request->user()->update(['fcm_token'=>$request->token]);
            return response()->json([
                'success'=>true
            ]);
        }catch(\Exception $e){
            report($e);
            return response()->json([
                'success'=>false
            ],500);
        }
    }
}
