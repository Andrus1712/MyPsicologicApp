<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateacudienteAPIRequest;
use App\Http\Requests\API\UpdateacudienteAPIRequest;
use App\Models\acudiente;
use App\Repositories\acudienteRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

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
        $this->acudienteRepository->pushCriteria(new RequestCriteria($request));
        $this->acudienteRepository->pushCriteria(new LimitOffsetCriteria($request));
        $acudientes = $this->acudienteRepository->all();

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
        $acudiente = $this->acudienteRepository->findWithoutFail($id);

        if (empty($acudiente)) {
            return $this->sendError('Acudiente not found');
        }

        $acudiente->delete();

        return $this->sendSuccess('Acudiente deleted successfully');
    }
}
