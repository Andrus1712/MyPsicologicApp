<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class docente
 * @package App\Models
 * @version September 28, 2020, 3:22 am UTC
 *
 * @property string tipoIdentificacion
 * @property string identificacion
 * @property string nombres
 * @property string apellidos
 * @property string correo
 * @property string fechaNacimiento
 * @property string telefono
 * @property string sexo
 */
class docente extends Model
{
    use SoftDeletes;

    public $table = 'docentes';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'tipoIdentificacion',
        'identificacion',
        'nombres',
        'apellidos',
        'correo',
        'fechaNacimiento',
        'telefono',
        'direccion'
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
        'correo' => 'string',
        'fechaNacimiento' => 'date',
        'telefono' => 'string',
        'direccion' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
