<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class comportamiento
 * @package App\Models
 * @version September 28, 2020, 11:56 pm UTC
 *
 * @property integer tipo_id
 * @property integer estudiante_id
 * @property string descripcion
 * @property string titulo
 * @property string fecha
 * @property string emisor
 * @property string multimedia
 */
class comportamiento extends Model
{
    use SoftDeletes;

    public $table = 'comportamientos';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'cod_comportamiento',
        'estudiante_id',
        'titulo',
        'descripcion',
        'fecha',
        'emisor',
        'multimedia'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'cod_comportamiento' => 'integer',
        'estudiante_id' => 'integer',
        'titulo' => 'string',
        'descripcion' => 'string',
        'fecha' => 'date',
        'emisor' => 'string',
        'multimedia' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
