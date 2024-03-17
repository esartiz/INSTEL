<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Lab404\Impersonate\Models\Impersonate;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Impersonate;

    static $rules = [
		'cod' => 'required',
		'doc' => 'required',
		'nombres' => 'required',
		'apellidos' => 'required',
		'telefono' => 'required',
		'fecha_nac' => 'required',
		'email' => 'required',
		'rol' => 'required',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['prg','cod','tipoDoc','doc','doc_ex','nombres','apellidos','telefono','fecha_nac','email','rol','ciclo','grupo', 'sexo','otraPer','password','fcm_token'];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function lasMatriculas(){
        return $this->hasMany('App\Models\Matricula', 'estudiante', 'id');
    }
    
    public function getPrograma()
    {
        return $this->hasOne('App\Models\Programa', 'id', 'prg');
    }
    public function misSesiones()
    {
        return $this->hasMany('App\Models\DataSesion', 'user', 'id')->where('status',0)->get();
    }
    public function dataSiet()
    {
        return $this->hasOne('App\Models\Siet', 'user', 'id');
    }
    public function misDeudas()
    {
        return $this->hasMany('App\Models\FBill', 'user', 'id')->where('status',0);
    }
    public function miPagare()
    {
        return $this->hasOne('App\Models\FBill', 'user', 'id')->where('contratoID', 'NOT LIKE', '%NOTA%')->where('status',0)->first();
    }
    public function miOtraDeuda()
    {
        return $this->hasOne('App\Models\FBill', 'user', 'id')->where('contratoID', 'LIKE', '%NOTA%')->where('status',0)->first();
    }
    public function misPagos()
    {
        return $this->hasOne('App\Models\FConcepto', 'user', 'id');
    }
    public function misDocumentos()
    {
        return $this->hasMany('App\Models\User_doc', 'user', 'id');
    }
    public function modulosAsignados()
    {
        return $this->hasMany('App\Models\Assignment', 'user', 'id')->where('estado', 0)->orderBy('modulo')->orderBy('grupo');
    }
    public function sesionesAsignadas()
    {
        return $this->hasMany('App\Models\DataSesion', 'docente', 'id')->get();
    }
    public function misBoxMatriculas()
    {
        return $this->hasMany('App\Models\MatriculasCaja', 'user', 'id');
    }
    public function misEntregas()
    {
        return $this->hasMany('App\Models\Entrega', 'de', 'id');
    }
    public function misAsistencias()
    {
        return $this->hasMany('App\Models\Asistencia', 'estudiante', 'id');
    }
    public function getPruebas()
    {
        return $this->hasMany('App\Models\Prueba', 'user', 'id')->get();
    }
}
