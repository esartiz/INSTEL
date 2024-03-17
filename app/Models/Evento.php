<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    protected $fillable = ['fecha', 'grupo', 'link', 'modulo', 'sala', 'sesionID', 'firma', 'nombre'];

    public function infoModulo()
    {
        return $this->hasOne('App\Models\Modulo', 'id', 'modulo')->first();
    }  
}
