<?php

namespace App\Repositories;

use App\Role;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class rolesRepository
 * @package App\Repositories
 * @version October 5, 2020, 9:50 pm UTC
 *
 * @method roles findWithoutFail($id, $columns = ['*'])
 * @method roles find($id, $columns = ['*'])
 * @method roles first($columns = ['*'])
*/
class rolesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'descripcion'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Role::class;
    }
}
