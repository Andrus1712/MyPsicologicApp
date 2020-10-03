<?php

namespace App\Repositories;

use App\Models\avances;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class avancesRepository
 * @package App\Repositories
 * @version September 29, 2020, 12:07 am UTC
 *
 * @method avances findWithoutFail($id, $columns = ['*'])
 * @method avances find($id, $columns = ['*'])
 * @method avances first($columns = ['*'])
*/
class avancesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'actividad_id',
        'tipo_comportamiento_id',
        'descripcion',
        'fecha_avance',
        'evidencias'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return avances::class;
    }
}
