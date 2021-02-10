<?php

namespace App\Repositories;

use App\Models\grupo;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class grupoRepository
 * @package App\Repositories
 * @version September 28, 2020, 11:52 pm UTC
 *
 * @method grupo findWithoutFail($id, $columns = ['*'])
 * @method grupo find($id, $columns = ['*'])
 * @method grupo first($columns = ['*'])
*/
class grupoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'grado',
        'curso',
        'docente_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return grupo::class;
    }
}
