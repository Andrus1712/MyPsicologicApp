<?php

namespace App\Repositories;

// use App\Models\Usuarios;
use App\User;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UsuariosRepository
 * @package App\Repositories
 * @version October 10, 2020, 3:20 am UTC
 *
 * @method Usuarios findWithoutFail($id, $columns = ['*'])
 * @method Usuarios find($id, $columns = ['*'])
 * @method Usuarios first($columns = ['*'])
*/
class UsuariosRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombre',
        'email',
        'password'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }
}
