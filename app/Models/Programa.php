<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    use HasFactory;
    protected $fillable = ['nombre','pretexto','tipo','modalidad','inscripcion','v_total','n_pagos','distr_pagos','estructura','certificado','duracion','fechaIni'];

    /**
     * Get all of the comments for the Programa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function moduloPrograma(){
        return $this->hasMany('App\Models\Modulo', 'programa', 'id');
    }
}