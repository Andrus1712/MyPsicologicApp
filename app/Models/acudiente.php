<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class acudiente
 * @package App\Models
 * @version September 27, 2020, 11:22 pm UTC
 *
 * @property string tipoIdentificacion
 * @property string identificacion
 * @property string nombres
 * @property string apellidos
 * @property string fechaNacimiento
 * @property string correo
 * @property string direccion
 * @property string telefono
 * @property string sexo
 * @property string photo
 */
class acudiente extends Model
{
    use SoftDeletes;

    public $table = 'acudientes';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'tipoIdentificacion',
        'identificacion',
        'nombres',
        'apellidos',
        'fechaNacimiento',
        'correo',
        'direccion',
        'telefono',
        'sexo',
        'photo'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'tipoIdentificacion' => 'string',
        'identificacion' => 'string',
        'nombres' => 'string',
        'apellidos' => 'string',
        'fechaNacimiento' => 'date',
        'correo' => 'string',
        'direccion' => 'string',
        'telefono' => 'string',
        'sexo' => 'string',
        'photo' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
