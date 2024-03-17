<?php
namespace App\Helpers;
use Storage;

class AppHelper
{
    public static function timeModule($elModulo,$grupo){
        $elGrupo = substr($grupo,-1);
        $semanaSanta = [strtotime("2024-03-24"),strtotime("2024-03-30")];
        $tiempos = [];
        
        $f1 = explode('|', $elModulo['fechas'])[$elGrupo];
        $s1 = explode('|', $elModulo['semanas'])[$elGrupo];

        for ($i=1; $i <= $s1; $i++) {
            $f1 = ($i>1 ? date('Y-m-d',strtotime("+7 day", strtotime($f1))) : $f1);
            if (strtotime($f1) >= $semanaSanta[0] && strtotime($f1) <= $semanaSanta[1]){
                $f1 = date('Y-m-d',strtotime("+7 day", strtotime($f1)));
            }
            $f2 = date('Y-m-d',strtotime("+6 day", strtotime($f1)));
            //Si son virtuales la AUT empieza el jueves. Presenciales el sáb
            $f3 = ($elGrupo < 5 ? date('Y-m-d',strtotime("+3 day", strtotime($f1))) :  date('Y-m-d',strtotime("+5 day", strtotime($f1))));
            //$f3 = date('Y-m-d',strtotime("+3 day", strtotime($f1)));
            $tiempos[$i] = [$f1.' 00:00:00', $f2.' 23:59:59', $f3.' 00:00:00', $f2.' 18:00:00'];
        }
        //Tiempos 0 contiene: inicio, final, cierre del ciclo (cierre es 3 semanas después del final) y fecha de encuesta (ultima semana)
        $finalModulo = $tiempos[$s1][1];
        $cierreModulo = $f2 = date('Y-m-d',strtotime("+166 day", strtotime($finalModulo)));
        $tiempos[0] = [$tiempos[1][0],$finalModulo,$cierreModulo.' 23:59:59',$tiempos[$s1][0]];
        return $tiempos;
    }

    
    public static function checkDocsReqs($user){
        $requisitos = [];
        $miMatrActiva = '';
        $miMatricula = $user->misBoxMatriculas()->where('estado', 'ACTIVO')->first();

        if ($miMatricula !== null && $miMatricula->getPrograma()->tipo !== null) {
            $miMatrActiva = $miMatricula->getPrograma()->tipo;
        }
        if($miMatrActiva == "Técnico Laboral" || "Certificaciones" || "Diplomado"){
            $requisitos = ["Documento de Identidad", "Acta de Grado","Diploma de Grado"];
        }
        if($miMatrActiva == "Certificaciones"){
            $requisitos = ["Documento de Identidad", "Acta de Grado","Diploma de Grado", "Experiencia en Medios"];
        }
        if($miMatrActiva == "Seminario-Taller"){
            $requisitos = ["Documento de Identidad"];
        }
        $pendientes = array();
        foreach ($requisitos as $elDoc) {
            $pendientes = array_merge($pendientes, ($user->misDocumentos()->where('user',$user->id)->where('descr',$elDoc)->count() > 0 ? [] : [$elDoc]));
        }

        //Revisa si tiene la foto de perfil
        if(!Storage::exists("userfiles/profiles/0/{$user->cod}.jpg")){
            array_push($pendientes, "Foto 3x4 tipo Carné");
        }
        return $pendientes;
    }
}
