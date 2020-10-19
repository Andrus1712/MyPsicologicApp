<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUsuariosAPIRequest;
use App\Http\Requests\API\UpdateUsuariosAPIRequest;
// use App\Models\Usuarios;
use App\User;
use App\Role;
use App\Repositories\UsuariosRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
//Este modelo no lo estoy usando 
/**
 * Class UsuariosController
 * @package App\Http\Controllers\API
 */

class UsuariosAPIController extends AppBaseController
{
    /** @var  UsuariosRepository */
    private $usuariosRepository;

    public function __construct(UsuariosRepository $usuariosRepo)
    {
        $this->usuariosRepository = $usuariosRepo;
    }

    /**
     * Display a listing of the Usuarios.
     * GET|HEAD /usuarios
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        // $this->usuariosRepository->pushCriteria(new RequestCriteria($request));
        // $this->usuariosRepository->pushCriteria(new LimitOffsetCriteria($request));
        $usuarios = User::all();

        foreach ($usuarios as $usuario) {
            $usuario->roles;
        }


        return $this->sendResponse($usuarios->toArray(), 'Usuarios retrieved successfully');
    }

    /**
     * Store a newly created Usuarios in storage.
     * POST /usuarios
     *
     * @param CreateUsuariosAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $role_id = $request->role_id;

        $role = Role::find($role_id);

        $usuario = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);

        $usuario->asignarRol($role);


        return $this->sendResponse($usuario->toArray(), 'Usuario saved successfully');
    }

    /**
     * Display the specified Usuarios.
     * GET|HEAD /usuarios/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Usuarios $usuarios */
        $usuarios = User::find($id);

        return $this->sendResponse($usuarios->toArray(), 'Usuarios retrieved successfully');
    }

    /**
     * Update the specified Usuarios in storage.
     * PUT/PATCH /usuarios/{id}
     *
     * @param  int $id
     * @param UpdateUsuariosAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {

        /** @var Usuarios $usuarios */
        $usuario = User::find($id);

        $role_id = $request->role_id;

        if ($request->name != null || $request->email != null || $request->password != null || $role_id==null) {
            $usuario->name = $request->name;
            $usuario->email = $request->email;
            $usuario->password = bcrypt($request->password);
            
        } else {
            $usuario->roles()->sync($role_id);
        }  
            
        $usuario->save();

        return $this->sendResponse($usuario->toArray(), 'Usuarios updated successfully');
    }

    /**
     * Remove the specified Usuarios from storage.
     * DELETE /usuarios/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Usuarios $usuarios */
        $usuario = User::find($id);

        $usuario->delete();

        return $this->sendResponse($usuario->toArray(), 'Usuarios updated successfully');
    }
}
