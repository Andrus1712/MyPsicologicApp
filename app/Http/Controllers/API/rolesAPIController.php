<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreaterolesAPIRequest;
use App\Http\Requests\API\UpdaterolesAPIRequest;
use App\Role;
use App\Repositories\rolesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Permission;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class rolesController
 * @package App\Http\Controllers\API
 */

class rolesAPIController extends AppBaseController
{
    /** @var  rolesRepository */
    private $rolesRepository;

    public function __construct(rolesRepository $rolesRepo)
    {
        $this->rolesRepository = $rolesRepo;
    }

    /**
     * Display a listing of the roles.
     * GET|HEAD /roles
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $roles = Role::all();

        foreach ($roles as $role) {
            $role->permissions;
        }
        // $this->rolesRepository->pushCriteria(new RequestCriteria($request));
        // $this->rolesRepository->pushCriteria(new LimitOffsetCriteria($request));
        // $roles = $this->rolesRepository->all();

        return $this->sendResponse($roles->toArray(), 'Roles retrieved successfully');
    }

    /**
     * Store a newly created roles in storage.
     * POST /roles
     *
     * @param CreaterolesAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // $roles = $this->rolesRepository->create($input);

        $lista_permisos = $request->permission;

        $roles = Role::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'descripcion' => $request->descripcion,
        ]);

        foreach ($lista_permisos as $key => $permiso) {
            $p = Permission::where('slug', $permiso)->limit(1)->get();
            $roles->asignarPermisos($p);
        }

        return $this->sendResponse($roles->toArray(), 'Roles saved successfully');
    }

    /**
     * Display the specified roles.
     * GET|HEAD /roles/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var roles $roles */
        $roles = $this->rolesRepository->findWithoutFail($id);

        if (empty($roles)) {
            return $this->sendError('Roles not found');
        }

        return $this->sendResponse($roles->toArray(), 'Roles retrieved successfully');
    }

    /**
     * Update the specified roles in storage.
     * PUT/PATCH /roles/{id}
     *
     * @param  int $id
     * @param UpdaterolesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $lista_permisos = $request->permission;

        /** @var roles $roles */
        $role = Role::find($id);

        if (empty($role)) {
            return $this->sendError('Roles not found');
        }

        $role->name = $request->name;
        $role->descripcion = $request->descripcion;
        $role->slug = $request->slug;
        $role->save();

        $role->permissions()->detach();

        if ($lista_permisos != 0) {
            foreach ($lista_permisos as $key => $permiso) {
                $p = Permission::where('slug', $permiso)->limit(1)->get();
                $role->asignarPermisos($p);
            }
        }

        return $this->sendResponse($role->toArray(), 'roles updated successfully');
    }

    /**
     * Remove the specified roles from storage.
     * DELETE /roles/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var roles $roles */
        $roles = Role::find($id);

        $roles->delete();

        return response()->json(['' => 'Roles deleted successfully']);
    }
}
