<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sala extends Model
{
    static $rules = [
		'n_sala' => 'required',
		'link_host' => 'required',
		'link' => 'required',
		'asignada' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['n_sala','link_host','link','asignada','cuentaZoom'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function elModulo()
    {
        return $this->hasOne('App\Models\Programa', 'id', 'asignada');
    }    

    public function infoModulo()
    {
        return $this->hasOne('App\Models\Modulo', 'id', 'asignada');
    }    

}
