<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatedocenteAPIRequest;
use App\Http\Requests\API\UpdatedocenteAPIRequest;
use App\Models\docente;
use App\Repositories\docenteRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

use App\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

/**
 * Class docenteController
 * @package App\Http\Controllers\API
 */

class docenteAPIController extends AppBaseController
{
    /** @var  docenteRepository */
    private $docenteRepository;

    public function __construct(docenteRepository $docenteRepo)
    {
        $this->docenteRepository = $docenteRepo;
    }

    /**
     * Display a listing of the docente.
     * GET|HEAD /docentes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $docentes = DB::table(DB::raw('docentes d'))
            ->where(DB::raw('d.deleted_at', '=', NULL))
            ->select('d.*')
            ->get();

        return $this->sendResponse($docentes->toArray(), 'Docentes retrieved successfully');
    }

    /**
     * Store a newly created docente in storage.
     * POST /docentes
     *
     * @param CreatedocenteAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatedocenteAPIRequest $request)
    {
        $input = $request->all();

        $user = User::where('identificacion', '=', $request->identificacion)->first();

        if ($user === null) {

            $usuario = User::create([
                'identificacion' => $request->identificacion,
                'name' => $request->nombres . ' ' . $request->apellidos,
                'email' => $request->correo,
                'password' => Hash::make($request->identificacion),
            ]);

            $usuario->asignarRol(3);

            $docente = $this->docenteRepository->create($input);

            return $this->sendResponse($docente->toArray(), 'Docente saved successfully');
        } else {

            return $this->sendError('id-registrada');
        }
    }

    /**
     * Display the specified docente.
     * GET|HEAD /docentes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var docente $docente */
        $docente = $this->docenteRepository->findWithoutFail($id);

        if (empty($docente)) {
            return $this->sendError('Docente not found');
        }

        return $this->sendResponse($docente->toArray(), 'Docente retrieved successfully');
    }

    /**
     * Update the specified docente in storage.
     * PUT/PATCH /docentes/{id}
     *
     * @param  int $id
     * @param UpdatedocenteAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedocenteAPIRequest $request)
    {
        $input = $request->all();

        /** @var docente $docente */
        $docente = $this->docenteRepository->findWithoutFail($id);

        if (empty($docente)) {
            return $this->sendError('Docente not found');
        }

        //Actualizamos el user
        $user = User::where('email', $docente->correo)->first();

        $user->name = $request->nombres . ' ' . $request->apellidos;
        $user->email = $request->correo;
        $user->save();

        //Actualizamos el Docente
        $docente = $this->docenteRepository->update($input, $id);

        return $this->sendResponse($docente->toArray(), 'docente updated successfully');
    }

    /**
     * Remove the specified docente from storage.
     * DELETE /docentes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var docente $docente */
        $docente = docente::find($id);
        $user = User::where('email', $docente->correo)->first();


        $docente->delete();
        $user->delete();

        return response()->json(['status' => 'Docente deleted successfully']);
    }
}
