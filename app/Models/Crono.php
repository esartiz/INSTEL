<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Crono
 *
 * @property $id
 * @property $ini
 * @property $fin
 * @property $nombre
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Crono extends Model
{
    
    static $rules = [
		'ini' => 'required',
		'fin' => 'required',
		'nombre' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['ini','fin','nombre'];



}
