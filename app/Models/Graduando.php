<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Graduando extends Model
{
    
    static $rules = [
		'nombre' => 'required',
		'documento' => 'required',
		'tipoDoc' => 'required',
		'correo' => 'required',
		'programa' => 'required',
		'intensidad' => 'required',
		'fecha' => 'required',
		'idUnico' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','documento','tipoDoc','lugar_exp','tel','correo','programa','intensidad','fecha','idUnico'];
}
