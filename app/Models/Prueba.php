<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
    use HasFactory;
    protected $fillable = ['idPrueba','codigo','fechaIni','fechafinal','user','box','valoracion1','valoracion2','observacion1','observacion2'];

    public function getEstudiante()
    {
        return $this->hasOne('App\Models\User', 'id', 'user')->first();
    }
    public function laPrueba()
    {
        return $this->hasOne('App\Models\PruebasCaja', 'id', 'idPrueba')->first();
    }
}
