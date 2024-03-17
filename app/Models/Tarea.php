<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
/**
 * Class Tarea
 *
 * @property $id
 * @property $modulo
 * @property $enunciado
 * @property $tipo_rta
 * @property $limite
 * @property $ord
 * @property $created_at
 * @property $updated_at
 *
 * @property Entrega[] $entregas
 * @property Modulo $modulo
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Tarea extends Model
{
    
    static $rules = [
		'modulo' => 'required',
		'enunciado' => 'required',
		'tipo_rta' => 'required',
		'desde' => 'required',
		'limite' => 'required',
		'ord' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['modulo','tipo','enunciado','tipo_rta','desde','limite','ord','isAU','fechas'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entregas()
    {
        return $this->hasOne('App\Models\Entrega', 'tarea', 'id')->where('de',Auth::user()->id);
    }

    public function retroAlimentacion()
    {
        return $this->hasOne('App\Models\Entrega', 'tarea', 'id')->where('de',Auth::user()->id);
    }

    public function entregasDoc()
    {
        return $this->hasMany('App\Models\Entrega', 'tarea', 'id');
    }

    public function entregasR()
    {
        return $this->hasOne('App\Models\Entrega', 'tarea', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function modulo()
    {
        return $this->hasOne('App\Models\Modulo', 'id', 'modulo');
    }

    public function kindSend($data){
        $dataIc = [
            ['tipo' => 'pdf', 'icon' => 'file-pdf', 'txt' => 'PDF'],
            ['tipo' => 'audio', 'icon' => 'music', 'txt' => 'AUDIO'],
            ['tipo' => 'texto', 'icon' => 'keyboard', 'txt' => 'TEXTO'],
            ['tipo' => 'link', 'icon' => 'link', 'txt' => 'LINK'],
        ];
        $rta = "";
        $ft = explode('|',$data);
        foreach ($ft as $item) {
            if($item != ""){
                $kk = array_search($item, array_column($dataIc, 'tipo'));
                $rta .= '<i class="fa-solid fa-'.$dataIc[$kk]['icon'].'"></i> RESPUESTA EN '.$dataIc[$kk]['txt'].'<br>';
            }
        }
        return $rta;
    }
}
