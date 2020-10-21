<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateactividadesAPIRequest;
use App\Http\Requests\API\UpdateactividadesAPIRequest;
use App\Models\actividades;
use App\Models\estudiante;
use App\Repositories\actividadesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\comportamiento;
use App\Models\HistorialActividades;
use App\Notifications\ActividadPospuesta;
use Illuminate\Support\Facades\Auth;
use Response;

use Illuminate\Support\Facades\DB;

use App\User;
use App\Role;


/**
 * Class actividadesController
 * @package App\Http\Controllers\API
 */

class actividadesAPIController extends AppBaseController
{
    /** @var  actividadesRepository */
    private $actividadesRepository;

    public function __construct(actividadesRepository $actividadesRepo)
    {
        $this->actividadesRepository = $actividadesRepo;
    }

    /**
     * Display a listing of the actividades.
     * GET|HEAD /actividades
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $actividades = DB::table(DB::raw('actividades ac'))->where(DB::raw('ac.deleted_at', '=', NULL))
            ->join(DB::raw('comportamientos c'), 'ac.comportamiento_id', '=', 'c.id')
            ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
            ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
            ->join(DB::raw('tipo_comportamientos tc'), 'ac.tipo_comportamiento_id', '=', 'tc.id')
            ->select(
                'ac.id',
                'ac.titulo',
                'ac.fecha',
                'ac.descripcion',
                'ac.estado',
                DB::raw('c.titulo as titulo_comportamiento'),
                DB::raw('c.descripcion as descripcion_comportamiento'),
                DB::raw('e.nombres as nombre_estudiante'),
                DB::raw('e.apellidos as apellido_estudiante'),
                DB::raw('e.telefono as telefono_estudiante'),
                DB::raw('e.correo as correo_estudiante'),
                DB::raw('a.nombres as nombre_acudiente'),
                DB::raw('a.apellidos as apellido_acudiente'),
                DB::raw('a.telefono as telefono_acudiente'),
                DB::raw('a.correo as correo_acudiente'),
                DB::raw('tc.titulo as titulo_tipo_comportamiento'),
                DB::raw('tc.descripcion as descripcion_tipo_comportamiento'),
                'ac.created_at',
                'ac.deleted_at'
            )
            // ->where(DB::raw('e.correo'), '=', Auth()->user()->email)
            ->get();

        return $this->sendResponse($actividades->toArray(), 'Actividades retrieved successfully');
    }

    /**
     * Store a newly created actividades in storage.
     * POST /actividades
     *
     * @param CreateactividadesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateactividadesAPIRequest $request)
    {
        $input = $request->all();

        $actividades = $this->actividadesRepository->create($input);

        return $this->sendResponse($actividades->toArray(), 'Actividades saved successfully');
    }

    /**
     * Display the specified actividades.
     * GET|HEAD /actividades/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var actividades $actividades */
        $actividades = $this->actividadesRepository->findWithoutFail($id);

        if (empty($actividades)) {
            return $this->sendError('Actividades not found');
        }

        return $this->sendResponse($actividades->toArray(), 'Actividades retrieved successfully');
    }

    /**
     * Update the specified actividades in storage.
     * PUT/PATCH /actividades/{id}
     *
     * @param  int $id
     * @param UpdateactividadesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateactividadesAPIRequest $request)
    {
        if ($request->method == 'reprogramar') {

            $input = $request->all();
            /** @var actividades $actividades */
            $actividades = $this->actividadesRepository->findWithoutFail($id);

            if (empty($actividades)) {
                return $this->sendError('Actividades not found');
            }

            HistorialActividades::create([
                'actividad_id' => $actividades->id,
                'fecha_historial' => $actividades->fecha
            ]);

            $actividades = $this->actividadesRepository->update($input, $id);

            $estudiante = DB::table(DB::raw('actividades ac'))->where(DB::raw('ac.deleted_at', '=', NULL))
                ->join(DB::raw('comportamientos c'), 'ac.comportamiento_id', '=', 'c.id')
                ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                ->where(DB::raw('ac.id'), '=', $actividades->id)
                ->select(DB::raw('e.id'))->first();

            $est = estudiante::find($estudiante->id);

            $user_id = User::where('email', $est->correo)->value('id');
            $user = User::find($user_id);

            $user->notify(new ActividadPospuesta($actividades));

            return $this->sendResponse($actividades->toArray(), 'actividades updated successfully');
        } else {

            $input = $request->all();
            /** @var actividades $actividades */
            $actividades = $this->actividadesRepository->findWithoutFail($id);

            if (empty($actividades)) {
                return $this->sendError('Actividades not found');
            }

            $actividades = $this->actividadesRepository->update($input, $id);

            return $this->sendResponse($actividades->toArray(), 'actividades updated successfully');
        }
    }

    /**
     * Remove the specified actividades from storage.
     * DELETE /actividades/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var actividades $actividades */
        $actividades = actividades::find($id);

        // if (empty($actividades)) {
        //     return $this->sendError('Actividades not found');
        // }

        $actividades->delete();

        return response()->json(['status' => 'Actividades deleted successfully']);
    }
}
