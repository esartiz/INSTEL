<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Inscripcione
 *
 * @property $id
 * @property $nombre
 * @property $programa
 * @property $tipo_programa
 * @property $fechaNac
 * @property $edad
 * @property $lugarNace
 * @property $estadoCivil
 * @property $doc
 * @property $lugarReside
 * @property $telefono
 * @property $correo
 * @property $direccion
 * @property $ultAnoEstudio
 * @property $anoCursoEstudio
 * @property $ie_estudios
 * @property $ciudadEstudios
 * @property $exper_virtual
 * @property $paqCompManeja
 * @property $tituloObtenido
 * @property $duracionEstudio
 * @property $hrsxDiaDisp
 * @property $cursadoLoc
 * @property $experienciaMedios
 * @property $tiempoExperiencia
 * @property $trabaja
 * @property $nombreEmpresa
 * @property $actividadEmpresa
 * @property $funcionesEmpresa
 * @property $tiempoSerEmpresa
 * @property $instelPrAc
 * @property $motivacionInstel
 * @property $aporteInstel
 * @property $estudioAntesTema
 * @property $necesidadEsp
 * @property $ventajas
 * @property $desventajas
 * @property $dependientes
 * @property $ingresos
 * @property $casaTipo
 * @property $medioConocerInstel
 * @property $fechaForm
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Inscripcione extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','programa','tipo_programa','fechaNac','edad','lugarNace','estadoCivil','doc','lugarReside','telefono','correo','direccion','ultAnoEstudio','anoCursoEstudio','ie_estudios','ciudadEstudios','exper_virtual','paqCompManeja','tituloObtenido','duracionEstudio','hrsxDiaDisp','cursadoLoc','experienciaMedios','tiempoExperiencia','trabaja','nombreEmpresa','actividadEmpresa','funcionesEmpresa','tiempoSerEmpresa','instelPrAc','motivacionInstel','aporteInstel','estudioAntesTema','necesidadEsp','ventajas','desventajas','dependientes','ingresos','casaTipo','medioConocerInstel','fechaForm'];



}
