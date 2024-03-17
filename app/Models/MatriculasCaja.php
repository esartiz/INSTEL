<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MatriculasCaja
 *
 * @property $id
 * @property $user
 * @property $estado
 * @property $nivel
 * @property $periodo
 * @property $fechaEgreso
 * @property $acta
 * @property $folio
 * @property $otros
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class MatriculasCaja extends Model
{
    static $rules = [
		'estado' => 'required',
		'nivel' => 'required',
		'periodo' => 'required',
		'fechaIngreso' => 'required'
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['prg','fechaIngreso','user','estado','nivel','periodo','fechaEgreso','acta','folio','otros'];

    public function getPrograma()
    {
        return $this->hasOne('App\Models\Programa', 'id', 'prg')->first();
    }
    public function getProgramaMtr()
    {
        return $this->belongsTo(Programa::class, 'prg');
    }
    public function getEstudiante()
    {
        return $this->hasOne('App\Models\User', 'id', 'user')->first();
    }
    public function getSesiones()
    {
        return $this->hasOne('App\Models\DataSesion', 'user', 'user')->get();
    }
    public function getDeuda()
    {
        return $this->hasOne('App\Models\FBill', 'matricula', 'id')->first();
    }
    public function materias()
    {
        return $this->hasMany('App\Models\Matricula', 'box', 'id')->get();
    }
    public function user() {
        return $this->belongsTo('App\Models\User');
    }    
}
