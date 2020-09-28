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
        $this->estudianteRepository->pushCriteria(new RequestCriteria($request));
        $this->estudianteRepository->pushCriteria(new LimitOffsetCriteria($request));
        $estudiantes = $this->estudianteRepository->all();

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
        $estudiante = $this->estudianteRepository->findWithoutFail($id);

        if (empty($estudiante)) {
            return $this->sendError('Estudiante not found');
        }

        $estudiante->delete();

        return $this->sendSuccess('Estudiante deleted successfully');
    }
}
