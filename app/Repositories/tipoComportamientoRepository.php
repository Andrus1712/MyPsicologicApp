<?php

namespace App\Repositories;

use App\Models\tipoComportamiento;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class tipoComportamientoRepository
 * @package App\Repositories
 * @version September 28, 2020, 11:53 pm UTC
 *
 * @method tipoComportamiento findWithoutFail($id, $columns = ['*'])
 * @method tipoComportamiento find($id, $columns = ['*'])
 * @method tipoComportamiento first($columns = ['*'])
*/
class tipoComportamientoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'titulo',
        'descripcion'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return tipoComportamiento::class;
    }
}
