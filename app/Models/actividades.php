<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class actividades
 * @package App\Models
 * @version September 28, 2020, 11:58 pm UTC
 *
 * @property string titulo
 * @property string fecha
 * @property string descripcion
 */
class actividades extends Model
{
    use SoftDeletes;

    public $table = 'actividades';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'titulo',
        'fecha',
        'descripcion',
        'estado',
        'comportamiento_id',
        // 'tipo_comportamiento_id',
        'estudiante_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'titulo' => 'string',
        'fecha' => 'date',
        'descripcion' => 'string',
        'estado' => 'integer',
        'comportamiento_id' => 'integer',
        // 'tipo_comportamiento_id' => 'integer',
        'estudiante_id' => 'intger'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
