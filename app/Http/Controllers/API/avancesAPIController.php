<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateavancesAPIRequest;
use App\Http\Requests\API\UpdateavancesAPIRequest;
use App\Models\avances;
use App\Repositories\avancesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use Illuminate\Support\Facades\DB;

/**
 * Class avancesController
 * @package App\Http\Controllers\API
 */

class avancesAPIController extends AppBaseController
{
    /** @var  avancesRepository */
    private $avancesRepository;

    public function __construct(avancesRepository $avancesRepo)
    {
        $this->avancesRepository = $avancesRepo;
    }

    /**
     * Display a listing of the avances.
     * GET|HEAD /avances
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $avances = DB::table(DB::raw('avances av'))->where(DB::raw('av.deleted_at', '=', 'NULL'))
            ->join(DB::raw('actividades ac'), 'av.actividad_id', '=', 'ac.id')
            ->join(DB::raw('comportamientos cp'), 'ac.comportamiento_id', '=', 'cp.id')
            ->join(DB::raw('tipo_comportamientos tc'), 'ac.tipo_comportamiento_id', '=', 'tc.id')
            ->join(DB::raw('estudiantes e'), 'cp.estudiante_id', '=', 'e.id')
            ->select('av.id', DB::raw('av.descripcion as avance'), 'av.fecha_avance',
                DB::raw('ac.id as id_actividad'),DB::raw('ac.estado as estado_actividad'),
                DB::raw('ac.titulo as titulo_actividad'),DB::raw('ac.descripcion as descripcion_actividad'),
                DB::raw('ac.fecha as fecha_actividad'),
                DB::raw('cp.titulo as comportamiento_registrado'),
                DB::raw('tc.titulo as titulo_tipo_comportamiento'),
                DB::raw('e.nombres as nombre_estudiante'),
                DB::raw('e.apellidos as apellido_estudiante'),
                'av.evidencias', 'av.created_at')
        ->get();

        return $this->sendResponse($avances->toArray(), 'Avances retrieved successfully');
    }

    /**
     * Store a newly created avances in storage.
     * POST /avances
     *
     * @param CreateavancesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateavancesAPIRequest $request)
    {
        $input = $request->all();

        $avances = $this->avancesRepository->create($input);

        return $this->sendResponse($avances->toArray(), 'Avances saved successfully');
    }

    /**
     * Display the specified avances.
     * GET|HEAD /avances/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var avances $avances */
        $avances = $this->avancesRepository->findWithoutFail($id);

        if (empty($avances)) {
            return $this->sendError('Avances not found');
        }

        return $this->sendResponse($avances->toArray(), 'Avances retrieved successfully');
    }

    /**
     * Update the specified avances in storage.
     * PUT/PATCH /avances/{id}
     *
     * @param  int $id
     * @param UpdateavancesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateavancesAPIRequest $request)
    {
        $input = $request->all();

        /** @var avances $avances */
        $avances = $this->avancesRepository->findWithoutFail($id);

        if (empty($avances)) {
            return $this->sendError('Avances not found');
        }

        $avances = $this->avancesRepository->update($input, $id);

        return $this->sendResponse($avances->toArray(), 'avances updated successfully');
    }

    /**
     * Remove the specified avances from storage.
     * DELETE /avances/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var avances $avances */
        $avances =avances::find($id);

        $avances->delete();

        return response()->json(['status' =>'Actividades deleted successfully']);
    }
}
