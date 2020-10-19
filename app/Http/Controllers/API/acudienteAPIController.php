<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateacudienteAPIRequest;
use App\Http\Requests\API\UpdateacudienteAPIRequest;
use App\Models\acudiente;
use App\Repositories\acudienteRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\estudiante;
use Response;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

/**
 * Class acudienteController
 * @package App\Http\Controllers\API
 */

class acudienteAPIController extends AppBaseController
{
    /** @var  acudienteRepository */
    private $acudienteRepository;

    public function __construct(acudienteRepository $acudienteRepo)
    {
        $this->acudienteRepository = $acudienteRepo;
    }

    /**
     * Display a listing of the acudiente.
     * GET|HEAD /acudientes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $acudientes = DB::table(DB::raw('acudientes a'))
            ->where(DB::raw('a.deleted_at'), '=', NULL)
            ->select('a.*')
            ->get();

        return $this->sendResponse($acudientes->toArray(), 'Acudientes retrieved successfully');
    }

    /**
     * Store a newly created acudiente in storage.
     * POST /acudientes
     *
     * @param CreateacudienteAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateacudienteAPIRequest $request)
    {
        $input = $request->all();

        $acudiente = $this->acudienteRepository->create($input);

        $usuario = User::create([
            'name' => $request->nombres . ' ' . $request->apellidos,
            'email' => $request->correo,
            'password' => Hash::make($request->identificacion),
        ]);

        $usuario->asignarRol(4);

        return $this->sendResponse($acudiente->toArray(), 'Acudiente saved successfully');
    }

    /**
     * Display the specified acudiente.
     * GET|HEAD /acudientes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var acudiente $acudiente */
        $acudiente = $this->acudienteRepository->findWithoutFail($id);

        if (empty($acudiente)) {
            return $this->sendError('Acudiente not found');
        }

        return $this->sendResponse($acudiente->toArray(), 'Acudiente retrieved successfully');
    }

    /**
     * Update the specified acudiente in storage.
     * PUT/PATCH /acudientes/{id}
     *
     * @param  int $id
     * @param UpdateacudienteAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateacudienteAPIRequest $request)
    {
        $input = $request->all();

        /** @var acudiente $acudiente */
        $acudiente = $this->acudienteRepository->findWithoutFail($id);

        if (empty($acudiente)) {
            return $this->sendError('Acudiente not found');
        }

        //Actualizamos el user
        $user = User::where('email', $acudiente->correo)->first();

        $user->name = $request->nombres . ' ' . $request->apellidos;
        $user->email = $request->correo;
        $user->save();

        //Actualizamos al Acudiente
        $acudiente = $this->acudienteRepository->update($input, $id);

        return $this->sendResponse($acudiente->toArray(), 'acudiente updated successfully');
    }

    /**
     * Remove the specified acudiente from storage.
     * DELETE /acudientes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var acudiente $acudiente */
        //Buscamos al acudeiete y al usuario
        $acudiente = acudiente::find($id);
        $user_acudiente = User::where('email', $acudiente->correo)->first();


        //Buscamos a los estudiantes de ese acudietne
        estudiante::where('acudiente_id', $acudiente->id)
            ->each(function ($estudiante, $key) {
                $user_est = User::where('email', $estudiante->correo)->first();
                if ($user_est != null) {
                    $user_est->delete();
                }
                $estudiante->delete();
            });



        //emliminamos los registros 
        $acudiente->delete();
        if ($user_acudiente != null) {
            $user_acudiente->delete();
        }


        return response()->json(['' => 'Acudiente deleted successfully']);
    }
}
