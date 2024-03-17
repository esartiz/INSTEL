<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PruebasCaja extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','texto','area','jurado1','jurado2','instruccion','fecha1','fecha2','anexo'];


    public function jurado1()
    {
        return $this->hasOne('App\Models\User', 'id', 'jurado1')->first();
    }
    public function jurado2()
    {
        return $this->hasOne('App\Models\User', 'id', 'jurado2')->first();
    }
    public function pruebas()
    {
        return $this->hasMany('App\Models\Prueba', 'idPrueba', 'id')->get();
    }
}
