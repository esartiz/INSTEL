<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siet extends Model
{
    protected $fillable = ['user','pais','ciudad','barrio','direccion','estrato','zona','lugarNace','estadoCivil','tipoSangre','nivelFormacion','ocupacion','discapacidad','transporte','multicult','eps','ars','aseguradora','sisben'];

    public function userSIET()
    {
        return $this->hasOne('App\Models\User', 'id', 'user')->withTrashed();
    }
}