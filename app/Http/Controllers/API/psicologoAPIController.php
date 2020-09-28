<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatepsicologoAPIRequest;
use App\Http\Requests\API\UpdatepsicologoAPIRequest;
use App\Models\psicologo;
use App\Repositories\psicologoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class psicologoController
 * @package App\Http\Controllers\API
 */

class psicologoAPIController extends AppBaseController
{
    /** @var  psicologoRepository */
    private $psicologoRepository;

    public function __construct(psicologoRepository $psicologoRepo)
    {
        $this->psicologoRepository = $psicologoRepo;
    }

    /**
     * Display a listing of the psicologo.
     * GET|HEAD /psicologos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->psicologoRepository->pushCriteria(new RequestCriteria($request));
        $this->psicologoRepository->pushCriteria(new LimitOffsetCriteria($request));
        $psicologos = $this->psicologoRepository->all();

        return $this->sendResponse($psicologos->toArray(), 'Psicologos retrieved successfully');
    }

    /**
     * Store a newly created psicologo in storage.
     * POST /psicologos
     *
     * @param CreatepsicologoAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatepsicologoAPIRequest $request)
    {
        $input = $request->all();

        $psicologo = $this->psicologoRepository->create($input);

        return $this->sendResponse($psicologo->toArray(), 'Psicologo saved successfully');
    }

    /**
     * Display the specified psicologo.
     * GET|HEAD /psicologos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var psicologo $psicologo */
        $psicologo = $this->psicologoRepository->findWithoutFail($id);

        if (empty($psicologo)) {
            return $this->sendError('Psicologo not found');
        }

        return $this->sendResponse($psicologo->toArray(), 'Psicologo retrieved successfully');
    }

    /**
     * Update the specified psicologo in storage.
     * PUT/PATCH /psicologos/{id}
     *
     * @param  int $id
     * @param UpdatepsicologoAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepsicologoAPIRequest $request)
    {
        $input = $request->all();

        /** @var psicologo $psicologo */
        $psicologo = $this->psicologoRepository->findWithoutFail($id);

        if (empty($psicologo)) {
            return $this->sendError('Psicologo not found');
        }

        $psicologo = $this->psicologoRepository->update($input, $id);

        return $this->sendResponse($psicologo->toArray(), 'psicologo updated successfully');
    }

    /**
     * Remove the specified psicologo from storage.
     * DELETE /psicologos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var psicologo $psicologo */
        $psicologo = $this->psicologoRepository->findWithoutFail($id);

        if (empty($psicologo)) {
            return $this->sendError('Psicologo not found');
        }

        $psicologo->delete();

        return $this->sendSuccess('Psicologo deleted successfully');
    }
}
