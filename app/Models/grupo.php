<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class grupo
 * @package App\Models
 * @version September 28, 2020, 11:52 pm UTC
 *
 * @property string nombre
 * @property string curso
 * @property integer docente_id
 */
class grupo extends Model
{
    use SoftDeletes;

    public $table = 'grupos';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'grado',
        'curso',
        'docente_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'grado' => 'string',
        'curso' => 'string',
        'docente_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'grado' => 'required',
        'curso'  => 'required',
        'docente_id' => 'required'
    ];

    
}
