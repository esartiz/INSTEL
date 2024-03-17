<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Mensaje
 *
 * @property $id
 * @property $start_date
 * @property $end_date
 * @property $de
 * @property $para
 * @property $asunto
 * @property $mensaje
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Mensaje extends Model
{
    
    static $rules = [
		'start_date' => 'required',
		'end_date' => 'required',
		'de' => 'required',
		'para' => 'required',
		'asunto' => 'required',
		'mensaje' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['start_date','end_date','de','para','asunto','mensaje'];

    public function userDe()
    {
        return $this->hasOne('App\Models\User', 'id', 'de')->withTrashed();
    }

    public function userPara()
    {
        return $this->hasOne('App\Models\User', 'id', 'para')->withTrashed();
    }

}