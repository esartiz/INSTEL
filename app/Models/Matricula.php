<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Matricula
 *
 * @property $id
 * @property $materia
 * @property $estudiante
 * @property $avance
 * @property $status
 * @property $created_at
 * @property $updated_at
 *
 * @property Modulo $modulo
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Matricula extends Model
{
    static $rules = [
		'materia' => 'required',
		'estudiante' => 'required',
		'avance' => 'required',
		'status' => 'required',
    ];

    protected $perPage = 20;

    protected $fillable = ['box','materia','n_materia','estudiante','grupo','sem','status','def','hab','rem','resultado','n1','n2','n3'];

    public function modulos_s()
    {
        return $this->hasOne('App\Models\Modulo', 'id', 'materia');
    }
    public function theBox()
    {
        return $this->hasOne('App\Models\MatriculasCaja', 'id', 'box');
    }
    
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'estudiante')->withTrashed();
    }

    public function elGrupo($id){
        $opcionesMatr = ["A", "B", "C", "D", "AS", "BS", "CS","DS"];
        $grupo = substr($id, 0, -1).'-'.$opcionesMatr[substr($id, -1)-1];
        return $grupo;
    }

}
