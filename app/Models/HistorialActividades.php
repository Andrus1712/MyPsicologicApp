<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistorialActividades extends Model
{
    use SoftDeletes;

    public $table = 'historial_actividades';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'actividad_id',
        'fecha_historial',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'actividad_id' => 'integer',
        'fecha_historial' => 'date',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [];
}
