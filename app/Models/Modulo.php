<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modulo extends Model
{
    static $rules = [
		'titulo' => 'required',
		'image' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['programa','ciclo','docente','titulo','image','descripcion','fechas','semanas'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function programas()
    {
        return $this->hasOne('App\Models\Programa', 'id', 'programa');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'docente')->withTrashed();
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'modulo')->orderBy('limite');
    }
    public function recursos()
    {
        return $this->hasMany(Recurso::class, 'modulo');
    }

    public function grupos()
    {
        return $this->hasMany(Matricula::class, 'materia')->where('status',0);
    }
    public function entregasPendientes()
    {
        return $this->hasMany(Entrega::class, 'modulo')->get();
    }
    public function practica()
    {
        return $this->hasOne('App\Models\Sala', 'asignada', 'id')->first();
    }
    public function videos(){
        return $this->hasOne('App\Models\Repositorio', 'modulo', 'id')->orderBy('fecha');
    }

    public function eventos()
    {
        return $this->hasMany('App\Models\Evento', 'modulo', 'id')->get();
    }

    public function docentes()
    {
        return $this->hasMany('App\Models\Assignment', 'modulo', 'id')->get();
    }
}
