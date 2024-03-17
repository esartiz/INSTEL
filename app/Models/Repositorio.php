<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repositorio extends Model
{
    
    protected $fillable = ['modulo','fecha','nombre','ruta','grupo'];
    
    public function elModulo()
    {
        return $this->hasOne('App\Models\Modulo', 'id', 'modulo');
    }

}