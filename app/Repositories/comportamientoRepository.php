<?php

namespace App\Repositories;

use App\Models\comportamiento;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class comportamientoRepository
 * @package App\Repositories
 * @version September 28, 2020, 11:56 pm UTC
 *
 * @method comportamiento findWithoutFail($id, $columns = ['*'])
 * @method comportamiento find($id, $columns = ['*'])
 * @method comportamiento first($columns = ['*'])
*/
class comportamientoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'estudiante_id',
        'tipo_comportamiento_id',
        'titulo',
        'descripcion',
        'fecha',
        'emisor',
        'multimedia'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return comportamiento::class;
    }
}
