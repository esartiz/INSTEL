<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripciones extends Model
{
    use HasFactory;
    public function getPrograma()
    {
        return $this->hasOne('App\Models\Programa', 'url', 'programa')->first();
    }
    public function checkUser()
    {
        return $this->hasOne('App\Models\User', 'doc', 'doc');
    }
}
