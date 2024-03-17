<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Texto
 *
 * @property $id
 * @property $nombre
 * @property $imagen
 * @property $categoria
 * @property $url
 * @property $pretexto
 * @property $texto
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Texto extends Model
{
    
    static $rules = [
		'nombre' => 'required',
		'categoria' => 'required',
		'url' => 'required',
		'pretexto' => 'required',
		'texto' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','imagen','categoria','url','pretexto','texto'];



}
