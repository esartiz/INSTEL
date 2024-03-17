<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anuncio extends Model
{
    protected $fillable = ['modulo','vence','texto','nivel','ruta'];
    
    public function elModulo()
    {
        return $this->hasOne('App\Models\Programa', 'id', 'modulo');
    }
}
