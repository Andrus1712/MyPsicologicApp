<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class avances
 * @package App\Models
 * @version September 29, 2020, 12:07 am UTC
 *
 * @property integer actividad_id
 * @property integer comportamiento_id
 * @property string titulo
 * @property string estado
 * @property string fecha
 * @property string documento
 */
class avances extends Model
{
    use SoftDeletes;

    public $table = 'avances';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'actividad_id',
        'tipo_comportamiento_id',
        'descripcion',
        'fecha_avance',
        'evidencias'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'actividad_id' => 'integer',
        'tipo_comportamiento_id' => 'integer',
        'descripcion' => 'string',
        'fecha_avance' => 'date',
        'evidencias' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
