<?php

namespace App\Repositories;

use App\Models\estudiante;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class estudianteRepository
 * @package App\Repositories
 * @version September 27, 2020, 11:31 pm UTC
 *
 * @method estudiante findWithoutFail($id, $columns = ['*'])
 * @method estudiante find($id, $columns = ['*'])
 * @method estudiante first($columns = ['*'])
*/
class estudianteRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
     * Configure the Model
     **/
    public function model()
    {
        return estudiante::class;
    }
}
