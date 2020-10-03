<?php

namespace App\Repositories;

use App\Models\docente;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class docenteRepository
 * @package App\Repositories
 * @version September 28, 2020, 3:22 am UTC
 *
 * @method docente findWithoutFail($id, $columns = ['*'])
 * @method docente find($id, $columns = ['*'])
 * @method docente first($columns = ['*'])
*/
class docenteRepository extends BaseRepository
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
        return docente::class;
    }
}
