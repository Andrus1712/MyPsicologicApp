<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class estudiante
 * @package App\Models
 * @version September 27, 2020, 11:31 pm UTC
 *
 * @property string tipoIdentificacion
 * @property string identificacion
 * @property string nombres
 * @property string apellidos
 * @property string correo
 * @property string fechaNacimiento
 * @property string grado
 * @property string telefono
 * @property string sexo
 * @property string actaAprobacion
 * @property integer acudiente_id
 */
class estudiante extends Model
{
    use SoftDeletes;

    public $table = 'estudiantes';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'tipoIdentificacion',
        'identificacion',
        'nombres',
        'apellidos',
        'correo',
        'fechaNacimiento',
        'grado',
        'telefono',
        'sexo',
        'actaAprobacion',
        'acudiente_id'
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
        'grado' => 'string',
        'telefono' => 'string',
        'sexo' => 'string',
        'actaAprobacion' => 'string',
        'acudiente_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
