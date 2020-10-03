<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class tipoComportamiento
 * @package App\Models
 * @version September 28, 2020, 11:53 pm UTC
 *
 * @property string conducta
 * @property string descripcion
 */
class tipoComportamiento extends Model
{
    use SoftDeletes;

    public $table = 'tipo_comportamientos';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'titulo',
        'descripcion'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'titulo' => 'string',
        'descripcion' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
