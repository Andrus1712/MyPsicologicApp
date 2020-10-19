<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Usuarios
 * @package App\Models
 * @version October 10, 2020, 3:20 am UTC
 *
 * @property string nombre
 * @property string email
 * @property string password
 */
class Usuarios extends Model
{
    use SoftDeletes;

    public $table = 'usuarios';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'nombre',
        'email',
        'password'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nombre' => 'string',
        'email' => 'string',
        'password' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
