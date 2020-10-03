<?php

namespace App\Repositories;

use App\Models\acudiente;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class acudienteRepository
 * @package App\Repositories
 * @version September 27, 2020, 11:22 pm UTC
 *
 * @method acudiente findWithoutFail($id, $columns = ['*'])
 * @method acudiente find($id, $columns = ['*'])
 * @method acudiente first($columns = ['*'])
*/
class acudienteRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'tipoIdentificacion',
        'identificacion',
        'nombres',
        'apellidos',
        'fechaNacimiento',
        'correo',
        'direccion',
        'telefono',
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return acudiente::class;
    }
}
