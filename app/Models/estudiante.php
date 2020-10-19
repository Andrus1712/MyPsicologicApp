<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\actividades;
use App\User;

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
        'edad',
        'telefono',
        'correo',
        'fechaNacimiento',
        'acudiente_id',
        'grupo_id'
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
        'edad' => 'integer',
        'telefono' => 'string',
        'correo' => 'string',
        'fechaNacimiento' => 'date',
        'acudiente_id' => 'integer',
        'grupo_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function actividades()
    {
        return $this->hasMany(actividades::class);
    }
}
