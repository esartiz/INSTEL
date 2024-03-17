<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DataSesion
 *
 * @property $id
 * @property $seminarID
 * @property $fecha
 * @property $envio
 * @property $retro
 * @property $status
 * @property $updated_at
 * @property $created_at
 *
 * @property DataSeminar $dataSeminar
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class DataSesion extends Model
{
    
    static $rules = [
		'status' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['box', 'seminarID','fecha','envio','retro','status','user','repositorio','docente','zoom','cuentaZoom'];

    public function dataSeminar()
    {
        return $this->hasOne('App\Models\DataSeminar', 'id', 'seminarID')->first();
    }

    public function estudiante()
    {
        return $this->hasOne('App\Models\User', 'id', 'user')->withTrashed()->first();
    }

    public function docente()
    {
        return $this->hasOne('App\Models\User', 'id', 'docente')->withTrashed()->first();
    }

    public function theBox()
    {
        return $this->hasOne('App\Models\MatriculasCaja', 'id', 'box');
    }
}
