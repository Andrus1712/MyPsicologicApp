<?php

namespace App\Repositories;

use App\Models\psicologo;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class psicologoRepository
 * @package App\Repositories
 * @version September 28, 2020, 3:34 am UTC
 *
 * @method psicologo findWithoutFail($id, $columns = ['*'])
 * @method psicologo find($id, $columns = ['*'])
 * @method psicologo first($columns = ['*'])
*/
class psicologoRepository extends BaseRepository
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
        'telefono',
        'direccion'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return psicologo::class;
    }
}
