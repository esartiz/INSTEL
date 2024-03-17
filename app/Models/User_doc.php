<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_doc extends Model
{
    use HasFactory;
    protected $fillable = ['user','file','descr'];

    public function getEstudiante()
    {
        return $this->hasOne('App\Models\User', 'id', 'user')->first();
    }
}
