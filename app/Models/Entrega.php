<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Entrega
 *
 * @property $id
 * @property $de
 * @property $modulo
 * @property $tarea
 * @property $respuesta
 * @property $retro
 * @property $status
 * @property $created_at
 * @property $updated_at
 *
 * @property Modulo $modulo
 * @property Tarea $tarea
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Entrega extends Model
{
    
    static $rules = [
		'de' => 'required',
		'modulo' => 'required',
		'tarea' => 'required',
		'respuesta' => 'required',
		'retro' => 'required',
		'status' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['de','modulo','tarea','idUnico','respuesta','link','retro','status'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function modulo()
    {
        return $this->hasOne('App\Models\Modulo', 'id', 'modulo');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tarea()
    {
        return $this->hasOne('App\Models\Tarea', 'id', 'tarea');
    }
    
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'de')->withTrashed();
    }

    public function matriculaMod($est)
    {
        return $this->hasOne('App\Models\Matricula', 'materia', 'modulo')->where('estudiante', $est);
    }
}
