<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatedocenteAPIRequest;
use App\Http\Requests\API\UpdatedocenteAPIRequest;
use App\Models\docente;
use App\Repositories\docenteRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

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
        $this->docenteRepository->pushCriteria(new RequestCriteria($request));
        $this->docenteRepository->pushCriteria(new LimitOffsetCriteria($request));
        $docentes = $this->docenteRepository->all();

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

        $docente = $this->docenteRepository->create($input);

        return $this->sendResponse($docente->toArray(), 'Docente saved successfully');
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
        $docente = $this->docenteRepository->findWithoutFail($id);

        if (empty($docente)) {
            return $this->sendError('Docente not found');
        }

        $docente->delete();

        return $this->sendSuccess('Docente deleted successfully');
    }
}
