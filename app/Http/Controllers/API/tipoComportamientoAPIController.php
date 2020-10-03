<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatetipoComportamientoAPIRequest;
use App\Http\Requests\API\UpdatetipoComportamientoAPIRequest;
use App\Models\tipoComportamiento;
use App\Repositories\tipoComportamientoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use Illuminate\Support\Facades\DB;

/**
 * Class tipoComportamientoController
 * @package App\Http\Controllers\API
 */

class tipoComportamientoAPIController extends AppBaseController
{
    /** @var  tipoComportamientoRepository */
    private $tipoComportamientoRepository;

    public function __construct(tipoComportamientoRepository $tipoComportamientoRepo)
    {
        $this->tipoComportamientoRepository = $tipoComportamientoRepo;
    }

    /**
     * Display a listing of the tipoComportamiento.
     * GET|HEAD /tipoComportamientos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $tipoComportamientos = DB::table(DB::raw('tipo_comportamientos t'))->where(DB::raw('t.deleted_at', '=', 'NULL'))
        ->select('t.*')->get();

        return $this->sendResponse($tipoComportamientos->toArray(), 'Tipo Comportamientos retrieved successfully');
    }

    /**
     * Store a newly created tipoComportamiento in storage.
     * POST /tipoComportamientos
     *
     * @param CreatetipoComportamientoAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatetipoComportamientoAPIRequest $request)
    {
        $input = $request->all();

        $tipoComportamiento = $this->tipoComportamientoRepository->create($input);

        return $this->sendResponse($tipoComportamiento->toArray(), 'Tipo Comportamiento saved successfully');
    }

    /**
     * Display the specified tipoComportamiento.
     * GET|HEAD /tipoComportamientos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var tipoComportamiento $tipoComportamiento */
        $tipoComportamiento = $this->tipoComportamientoRepository->findWithoutFail($id);

        if (empty($tipoComportamiento)) {
            return $this->sendError('Tipo Comportamiento not found');
        }

        return $this->sendResponse($tipoComportamiento->toArray(), 'Tipo Comportamiento retrieved successfully');
    }

    /**
     * Update the specified tipoComportamiento in storage.
     * PUT/PATCH /tipoComportamientos/{id}
     *
     * @param  int $id
     * @param UpdatetipoComportamientoAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatetipoComportamientoAPIRequest $request)
    {
        $input = $request->all();

        /** @var tipoComportamiento $tipoComportamiento */
        $tipoComportamiento = $this->tipoComportamientoRepository->findWithoutFail($id);

        if (empty($tipoComportamiento)) {
            return $this->sendError('Tipo Comportamiento not found');
        }

        $tipoComportamiento = $this->tipoComportamientoRepository->update($input, $id);

        return $this->sendResponse($tipoComportamiento->toArray(), 'tipoComportamiento updated successfully');
    }

    /**
     * Remove the specified tipoComportamiento from storage.
     * DELETE /tipoComportamientos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var tipoComportamiento $tipoComportamiento */
        $tipoComportamiento = tipoComportamiento::find($id);

        $tipoComportamiento->delete();

        return response()->json(['' => 'Tipo Comportamiento deleted successfully']);
    }
}
