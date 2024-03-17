<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DataSeminar
 *
 * @property $id
 * @property $prg
 * @property $sesionID
 * @property $docente
 * @property $repositorio
 * @property $recurso
 * @property $tareaTipo
 * @property $tarea
 * @property $updated_at
 * @property $created_at
 *
 * @property DataSesion[] $dataSesions
 * @property Programa $programa
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class DataSeminar extends Model
{
    
    static $rules = [
		'sesionID' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['prg','sesionID','docente','recurso','tareaTipo','tarea','zoom','cuentaZoom'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dataSesions()
    {
        return $this->hasMany('App\Models\DataSesion', 'seminarID', 'id')->get();
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function programa()
    {
        return $this->hasOne('App\Models\Programa', 'id', 'prg')->first();
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'docente')->first();
    }
    

}
