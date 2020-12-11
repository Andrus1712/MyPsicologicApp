<?php

namespace App\Repositories;

use App\Models\actividades;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class actividadesRepository
 * @package App\Repositories
 * @version September 28, 2020, 11:58 pm UTC
 *
 * @method actividades findWithoutFail($id, $columns = ['*'])
 * @method actividades find($id, $columns = ['*'])
 * @method actividades first($columns = ['*'])
*/
class actividadesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'titulo',
        'fecha',
        'descripcion',
        'estado',
        'comportamiento_id',
        // 'tipo_comportamiento_id',
        'estudiante_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return actividades::class;
    }
}
