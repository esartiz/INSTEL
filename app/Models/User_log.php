<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_log extends Model
{
    
    static $rules = [
		'user' => 'required',
		'fecha' => 'required'
    ];

    protected $perPage = 20;

    protected $fillable = ['user','ip','fecha'];
    
    public function userLog()
    {
        return $this->hasOne('App\Models\User', 'id', 'user')->withTrashed();
    }

}
