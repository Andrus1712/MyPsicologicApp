<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Createmodelo_seguimientoAPIRequest;
use App\Http\Requests\API\Updatemodelo_seguimientoAPIRequest;
use App\Models\modelo_seguimiento;
use App\Repositories\modelo_seguimientoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use Illuminate\Support\Facades\DB;

/**
 * Class modelo_seguimientoController
 * @package App\Http\Controllers\API
 */

class modelo_seguimientoAPIController extends AppBaseController
{
    /** @var  modelo_seguimientoRepository */
    private $modeloSeguimientoRepository;

    public function __construct(modelo_seguimientoRepository $modeloSeguimientoRepo)
    {
        $this->modeloSeguimientoRepository = $modeloSeguimientoRepo;
    }

    /**
     * Display a listing of the modelo_seguimiento.
     * GET|HEAD /modeloSeguimientos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $modeloSeguimiento = DB::table(DB::raw('modelo_seguimientos modelo'))
        ->where(DB::raw('modelo.deleted_at', '=', 'NULL'))
        ->select(DB::raw('modelo.*'))
        ->get();

        return $this->sendResponse($modeloSeguimiento->toArray(), 'Modelo Seguimiento saved successfully');
    }

    /**
     * Store a newly created modelo_seguimiento in storage.
     * POST /modeloSeguimientos
     *
     * @param Createmodelo_seguimientoAPIRequest $request
     *
     * @return Response
     */
    public function store(Createmodelo_seguimientoAPIRequest $request)
    {      
        $input = $request->all();

        $modeloSeguimiento = $this->modeloSeguimientoRepository->create($input);

        return $this->sendResponse($modeloSeguimiento->toArray(), 'Modelo Seguimiento saved successfully');
    }

    /**
     * Display the specified modelo_seguimiento.
     * GET|HEAD /modeloSeguimientos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var modelo_seguimiento $modeloSeguimiento */
        $modeloSeguimiento = $this->modeloSeguimientoRepository->findWithoutFail($id);

        if (empty($modeloSeguimiento)) {
            return $this->sendError('Modelo Seguimiento not found');
        }

        return $this->sendResponse($modeloSeguimiento->toArray(), 'Modelo Seguimiento retrieved successfully');
    }

    /**
     * Update the specified modelo_seguimiento in storage.
     * PUT/PATCH /modeloSeguimientos/{id}
     *
     * @param  int $id
     * @param Updatemodelo_seguimientoAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Updatemodelo_seguimientoAPIRequest $request)
    {
        $input = $request->all();

        /** @var modelo_seguimiento $modeloSeguimiento */
        $modeloSeguimiento = $this->modeloSeguimientoRepository->findWithoutFail($id);

        if (empty($modeloSeguimiento)) {
            return $this->sendError('Modelo Seguimiento not found');
        }

        $modeloSeguimiento = $this->modeloSeguimientoRepository->update($input, $id);

        return $this->sendResponse($modeloSeguimiento->toArray(), 'modelo_seguimiento updated successfully');
    }

    /**
     * Remove the specified modelo_seguimiento from storage.
     * DELETE /modeloSeguimientos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var modelo_seguimiento $modeloSeguimiento */

        $modeloSeguimiento = modelo_seguimiento::find($id);

        $modeloSeguimiento->delete();

        return response()->json(['status' => 'Modelo Seguimiento deleted successfully']);
    }
}
