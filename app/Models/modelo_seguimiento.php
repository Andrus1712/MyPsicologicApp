<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class modelo_seguimiento
 * @package App\Models
 * @version October 7, 2020, 3:37 am UTC
 *
 * @property string fecha
 * @property string nombre
 * @property string estamento
 * @property string medio_comunicacion
 * @property string clasificacion_caso_presentado
 * @property string descripcion
 * @property string solucion
 * @property string remitido
 * @property string estado
 */
class modelo_seguimiento extends Model
{
    use SoftDeletes;

    public $table = 'modelo_seguimientos';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'fecha',
        'nombre',
        'estamento',
        'medio_comunicacion',
        'clasificacion_caso_presentado',
        'descripcion',
        'solucion',
        'remitido',
        'estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'fecha' => 'date',
        'nombre' => 'string',
        'estamento' => 'string',
        'medio_comunicacion' => 'string',
        'clasificacion_caso_presentado' => 'string',
        'descripcion' => 'string',
        'solucion' => 'string',
        'remitido' => 'string',
        'estado' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
