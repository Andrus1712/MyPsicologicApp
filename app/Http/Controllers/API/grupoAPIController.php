<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreategrupoAPIRequest;
use App\Http\Requests\API\UpdategrupoAPIRequest;
use App\Models\grupo;
use App\Repositories\grupoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

use Illuminate\Support\Facades\DB;
/**
 * Class grupoController
 * @package App\Http\Controllers\API
 */

class grupoAPIController extends AppBaseController
{
    /** @var  grupoRepository */
    private $grupoRepository;

    public function __construct(grupoRepository $grupoRepo)
    {
        $this->grupoRepository = $grupoRepo;
    }

    /**
     * Display a listing of the grupo.
     * GET|HEAD /grupos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $grupos = DB::table(DB::raw('grupos g'))->where(DB::raw('g.deleted_at', '=', 'NULL'))
                ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
                ->select('g.id', 'g.grado', 'g.curso', 'g.docente_id', 
                    DB::raw('CONCAT(TRIM(d.nombres), " ", TRIM(d.apellidos) ) AS docente'),
                    'g.created_at')
                ->get();


        return $this->sendResponse($grupos->toArray(), 'Grupos retrieved successfully');
    }

    

    /**
     * Store a newly created grupo in storage.
     * POST /grupos
     *
     * @param CreategrupoAPIRequest $request
     *
     * @return Response
     */
    public function store(CreategrupoAPIRequest $request)
    {
        $input = $request->all();

        $grupo = $this->grupoRepository->create($input);

        return $this->sendResponse($grupo->toArray(), 'Grupo saved successfully');
    }

    /**
     * Display the specified grupo.
     * GET|HEAD /grupos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var grupo $grupo */
        $grupo = $this->grupoRepository->findWithoutFail($id);

        if (empty($grupo)) {
            return $this->sendError('Grupo not found');
        }

        return $this->sendResponse($grupo->toArray(), 'Grupo retrieved successfully');
    }

    /**
     * Update the specified grupo in storage.
     * PUT/PATCH /grupos/{id}
     *
     * @param  int $id
     * @param UpdategrupoAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdategrupoAPIRequest $request)
    {
        $input = $request->all();

        /** @var grupo $grupo */
        $grupo = $this->grupoRepository->findWithoutFail($id);

        if (empty($grupo)) {
            return $this->sendError('Grupo not found');
        }

        $grupo = $this->grupoRepository->update($input, $id);

        return $this->sendResponse($grupo->toArray(), 'grupo updated successfully');
    }

    /**
     * Remove the specified grupo from storage.
     * DELETE /grupos/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var grupo $grupo */
        // $grupo = grupo::find($id);
        DB::table('grupos')->whereId($id)->delete();


        // $grupo->delete();

        return response()->json(['status' => 'Grupo deleted successfully']);
    }
}
