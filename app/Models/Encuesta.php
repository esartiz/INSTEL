<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    
    static $rules = [
		'modulo' => 'required',
		'docente' => 'required',
		'user' => 'required',
		'fecha' => 'required',
		'rtas' => 'required',
    ];

    protected $perPage = 20;
    protected $fillable = ['modulo','docente','user','fecha','rtas'];
    
    public function elModulo()
    {
        return $this->hasOne('App\Models\Modulo', 'id', 'modulo');
    }
    
    public function elDocente()
    {
        return $this->hasOne('App\Models\User', 'id', 'docente');
    }
    
    public function elEstudiante()
    {
        return $this->hasOne('App\Models\User', 'id', 'user')->withTrashed();
    }
}
