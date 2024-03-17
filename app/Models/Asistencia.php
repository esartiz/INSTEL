<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asistencia extends Model
{
    static $rules = [
		'fecha' => 'required',
		'estudiante' => 'required',
		'modulo' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['fecha','estudiante','modulo','grupo','presencia'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function elModulo()
    {
        return $this->hasOne('App\Models\Programa', 'id', 'modulo');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'estudiante')->withTrashed();
    }
    
    

}
