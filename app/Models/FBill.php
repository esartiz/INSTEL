<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FBill extends Model
{
  static $rules = [
    'fecha' => 'required',
  ];

  protected $perPage = 20;
  protected $fillable = ['user', 'contratoID', 'deudor', 'codeudor', 'semestre', 'cicloAc', 'valor', 'cuotas', 'saldo', 'fecha', 'status', 'matricula', 'plan', 'otros'];

  public function pagEstudiante()
  {
    return $this->hasOne('App\Models\User', 'id', 'user')->withTrashed()->first();
  }
  public function pagosHechos()
  {
    return $this->hasMany('App\Models\FConcepto', 'user', 'user')->where('status', 1)->where('idRecibo', 'NOT LIKE', 0)->orderBy('cuota', 'ASC')->orderBy('fecha', 'ASC')->get();
  }
  public function matriculaCredito(){
    return $this->hasOne('App\Models\MatriculasCaja', 'id', 'matricula')->first();
  }
  public function pagosSobreDeuda()
  {
    return $this->hasMany('App\Models\FConcepto', 'pagareID', 'contratoID')->where('status', 1)->get();
  }
}