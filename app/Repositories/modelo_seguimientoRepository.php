<?php

namespace App\Repositories;

use App\Models\modelo_seguimiento;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class modelo_seguimientoRepository
 * @package App\Repositories
 * @version October 7, 2020, 3:37 am UTC
 *
 * @method modelo_seguimiento findWithoutFail($id, $columns = ['*'])
 * @method modelo_seguimiento find($id, $columns = ['*'])
 * @method modelo_seguimiento first($columns = ['*'])
*/
class modelo_seguimientoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'fecha',
        'nombre',
        'estamento',
        'medio_comunicacion',
        'clasificacion_caso_presentado',
        'descripcion',
        'solucion',
        'remitido',
        'estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return modelo_seguimiento::class;
    }
}
