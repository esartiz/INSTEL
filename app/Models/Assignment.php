<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = ['user', 'modulo', 'grupo','estado'];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user')->first();
    }
    public function modulo()
    {
        return $this->hasOne('App\Models\Modulo', 'id', 'modulo')->first();
    }
    public function entregas()
    {
        return $this->hasMany('App\Models\Entrega', 'modulo', 'modulo')->get();
    }
    public function estudiantesAsignados()
    {
        return $this->hasMany('App\Models\Matricula', 'materia', 'modulo')->where('status', 0);
    }
    public function eventos()
    {
        return $this->hasMany('App\Models\Evento', 'modulo', 'modulo')->get();
    }
    public function recursos()
    {
        return $this->hasMany('App\Models\Recurso', 'modulo', 'modulo')->get();
    }
    public function tareas()
    {
        return $this->hasMany('App\Models\Tarea', 'modulo', 'modulo')->orderBy('limite')->get();
    }
    public function asistencias()
    {
        return $this->hasMany('App\Models\Asistencia', 'modulo', 'modulo')->where('grupo', $this->grupo)->orderBy('fecha')->orderBy('id')->get();
    }
    public function grabaciones()
    {
        return $this->hasMany('App\Models\Repositorio', 'modulo', 'modulo')->where('grupo', $this->grupo)->orderBy('fecha')->get();
    }
}
