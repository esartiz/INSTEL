<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Recurso
 *
 * @property $id
 * @property $modulo
 * @property $titulo
 * @property $tipo
 * @property $file
 * @property $created_at
 * @property $updated_at
 *
 * @property Modulo $modulo
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Recurso extends Model
{
    
    static $rules = [
		'modulo' => 'required',
		'titulo' => 'required',
		'tipo' => 'required',
		'file' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['modulo','titulo','tipo','file','author','cRec','fechas'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function modulo()
    {
        return $this->hasOne('App\Models\Modulo', 'id', 'modulo');
    }

    public function elTiempo()
    {
        return $this->hasOne('App\Models\Crono', 'id', 'tiempo');
    }
    

}
