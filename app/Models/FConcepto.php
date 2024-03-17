<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FConcepto extends Model
{
    static $rules = [
		'fecha' => 'required',
		'nombre' => 'required',
		'documento' => 'required',
		'formaPago' => 'required',
		'observ' => 'required',
		'dto' => 'required',
		'valor' => 'required',
		'concept' => 'required',
    ];

    protected $perPage = 20;
    protected $fillable = ['user','idRecibo','idConcepto','fecha','formaPago','observ','dto','valor','concept','status','pagareID','cuota'];
    
    public function persona()
    {
        return $this->hasOne('App\Models\User', 'id', 'user')->withTrashed()->first();
    }

    public function esDePagare()
    {
        return $this->hasOne('App\Models\FBill', 'contratoID', 'pagareID')->where('status', 0)->first();
    }

    public function siet()
    {
        return $this->hasOne('App\Models\Siet', 'user', 'user')->first();
    }
}
