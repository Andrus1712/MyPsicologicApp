<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatecomportamientoAPIRequest;
use App\Http\Requests\API\UpdatecomportamientoAPIRequest;
use App\Models\comportamiento;
use App\Repositories\comportamientoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use Illuminate\Support\Facades\DB;
/**
 * Class comportamientoController
 * @package App\Http\Controllers\API
 */

class comportamientoAPIController extends AppBaseController
{
    /** @var  comportamientoRepository */
    private $comportamientoRepository;

    public function __construct(comportamientoRepository $comportamientoRepo)
    {
        $this->comportamientoRepository = $comportamientoRepo;
    }

    /**
     * Display a listing of the comportamiento.
     * GET|HEAD /comportamientos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $comportamientos = DB::table(DB::raw('comportamientos c'))->where(DB::raw('c.deleted_at'), '=', NULL)
                        ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                        ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
                        ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                        ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
                        ->where(DB::raw('c.deleted_at', '!=', 'date()'))
                        ->select('c.id', 'c.cod_comportamiento', 'c.titulo', 'c.descripcion', 'c.fecha',
                                'e.nombres', 'e.apellidos', DB::raw('a.nombres as nombre_acudiente'), DB::raw('a.apellidos as apellido_acudiente'),
                                'g.grado', 'g.curso', 'c.multimedia', 'c.emisor', 'e.created_at')
                        ->get();

        return $this->sendResponse($comportamientos->toArray(), 'Comportamientos retrieved successfully');
    }

    /**
     * Store a newly created comportamiento in storage.
     * POST /comportamientos
     *
     * @param CreatecomportamientoAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatecomportamientoAPIRequest $request)
    {
        $input = $request->all();

        $comportamiento = $this->comportamientoRepository->create($input);

        return $this->sendResponse($comportamiento->toArray(), 'Comportamiento saved successfully');
    }

    /**
     * Display the specified comportamiento.
     * GET|HEAD /comportamientos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var comportamiento $comportamiento */
        $comportamiento = $this->comportamientoRepository->findWithoutFail($id);

        if (empty($comportamiento)) {
            return $this->sendError('Comportamiento not found');
        }

        return $this->sendResponse($comportamiento->toArray(), 'Comportamiento retrieved successfully');
    }

    /**
     * Update the specified comportamiento in storage.
     * PUT/PATCH /comportamientos/{id}
     *
     * @param  int $id
     * @param UpdatecomportamientoAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatecomportamientoAPIRequest $request)
    {
        $input = $request->all();

        /** @var comportamiento $comportamiento */
        $comportamiento = $this->comportamientoRepository->findWithoutFail($id);

        if (empty($comportamiento)) {
            return $this->sendError('Comportamiento not found');
        }

        $comportamiento = $this->comportamientoRepository->update($input, $id);

        return $this->sendResponse($comportamiento->toArray(), 'comportamiento updated successfully');
    }

    /**
     * Remove the specified comportamiento from storage.
     * DELETE /comportamientos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var comportamiento $comportamiento */
        $comportamiento = comportamiento::find($id);
        
        $comportamiento->delete();

        return response()->json(['status' => 'Comportamiento retrieved successfully']);
    }
}
