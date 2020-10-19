<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateestudianteAPIRequest;
use App\Http\Requests\API\UpdateestudianteAPIRequest;
use App\Models\estudiante;
use App\Repositories\estudianteRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

/**
 * Class estudianteController
 * @package App\Http\Controllers\API
 */

class estudianteAPIController extends AppBaseController
{
    /** @var  estudianteRepository */
    private $estudianteRepository;

    public function __construct(estudianteRepository $estudianteRepo)
    {
        $this->estudianteRepository = $estudianteRepo;
    }

    /**
     * Display a listing of the estudiante.
     * GET|HEAD /estudiantes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $estudiantes = DB::table(DB::raw('estudiantes e'))->where(DB::raw('e.deleted_at', '=', 'NULL'))
            ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
            ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
            ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
            ->select(
                'e.id',
                'e.tipoIdentificacion',
                'e.identificacion',
                'e.nombres',
                'e.apellidos',
                'e.edad',
                'e.telefono',
                'e.correo',
                'e.fechaNacimiento',
                DB::raw('a.nombres as nombre_acudiente'),
                DB::raw('a.apellidos as apellido_acudiente'),
                DB::raw('a.telefono as telefono_acudiente'),
                DB::raw('a.correo as correo_acudiente'),
                'g.grado',
                'g.curso',
                DB::raw('d.nombres as nombre_docente'),
                DB::raw('d.apellidos as apellidos_docente'),
                'e.created_at'
            )
            ->get();

        return $this->sendResponse($estudiantes->toArray(), 'Estudiantes retrieved successfully');
    }

    /**
     * Store a newly created estudiante in storage.
     * POST /estudiantes
     *
     * @param CreateestudianteAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateestudianteAPIRequest $request)
    {
        $input = $request->all();

        $estudiante = $this->estudianteRepository->create($input);

        // 'name', 'email', 'password',

        $usuario = User::create([
            'name' => $request->nombres . ' ' . $request->apellidos,
            'email' => $request->correo,
            'password' => Hash::make($request->identificacion),
        ]);


        $usuario->asignarRol(2);


        return $this->sendResponse($estudiante->toArray(), 'Estudiante saved successfully');
    }

    /**
     * Display the specified estudiante.
     * GET|HEAD /estudiantes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var estudiante $estudiante */
        $estudiante = $this->estudianteRepository->findWithoutFail($id);

        if (empty($estudiante)) {
            return $this->sendError('Estudiante not found');
        }

        return $this->sendResponse($estudiante->toArray(), 'Estudiante retrieved successfully');
    }

    /**
     * Update the specified estudiante in storage.
     * PUT/PATCH /estudiantes/{id}
     *
     * @param  int $id
     * @param UpdateestudianteAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateestudianteAPIRequest $request)
    {
        $input = $request->all();

        /** @var estudiante $estudiante */
        $estudiante = $this->estudianteRepository->findWithoutFail($id);

        if (empty($estudiante)) {
            return $this->sendError('Estudiante not found');
        }

        //Actualizamos el user
        $user = User::where('email', $estudiante->correo)->first();

        $user->name = $request->nombres . ' ' . $request->apellidos;
        $user->email = $request->correo;
        $user->save();

        //Actualizamos al estudiante
        $estudiante = $this->estudianteRepository->update($input, $id);

        return $this->sendResponse($estudiante->toArray(), 'estudiante updated successfully');
    }

    /**
     * Remove the specified estudiante from storage.
     * DELETE /estudiantes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var estudiante $estudiante */
        $estudiante = estudiante::find($id);

        $user = User::where('email', $estudiante->correo)->first();

        $estudiante->delete();
        $user->delete();

        return response()->json(['status' => 'Estudiante deleted successfully']);
    }
}
