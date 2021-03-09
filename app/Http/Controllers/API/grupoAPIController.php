<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreategrupoAPIRequest;
use App\Http\Requests\API\UpdategrupoAPIRequest;
use App\Models\grupo;
use App\Repositories\grupoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
            ->select(
                'g.id',
                'g.grado',
                'g.curso',
                'g.docente_id',
                DB::raw('CONCAT(TRIM(d.nombres), " ", TRIM(d.apellidos) ) AS docente'),
                'g.created_at'
            )
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
        $grado = $input['grado'];
        $curso = $input['curso'];
        $messages = [
            'grado.required' => 'El grupo es requerido',
            'grado.numeric' => 'El grupo debe ser numerico',
            'curso.required' => 'El curso es requerido',
            'grado.unique' => 'El grupo y el grado ya estan asignados',
            'docente_id.required' => 'El docente es requerido',
            'docente_id.unique' => 'El docente ya esta asignado',
        ];

        $validator = Validator::make($input, [
            'grado' => [
                'required', 'numeric',
                Rule::unique('grupos')->where(function ($query) use ($grado, $curso) {
                    return $query->where('grado', $grado)
                        ->where('curso', $curso);
                }),
            ],
            'curso' => ['required'],
            'docente_id' => ['required', 'numeric', 'unique:grupos'],
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->messages(),
                "data" => null
            ]);
        } else {
            $grupo = $this->grupoRepository->create($input);
            return response()->json([
                "success" => true,
                "message" => "Grupo saved successfully",
                "data" => $grupo
            ]);
            // return $this->sendResponse($grupo->toArray(), 'Grupo saved successfully');
        }
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
        $grado = $input['grado'];
        $curso = $input['curso'];
        $messages = [
            'grado.required' => 'El grupo es requerido',
            'grado.numeric' => 'El grupo debe ser numerico',
            'curso.required' => 'El curso es requerido',
            'grado.unique' => 'El grupo y el grado ya estan asignados',
            'curso.unique' => 'El grupo ya esta asignado',
            'docente_id.required' => 'El docente es requerido',
            'docente_id.unique' => 'El docente ya esta asignado',
        ];

        $grupo = $this->grupoRepository->findWithoutFail($id);

        if (empty($grupo)) {
            return $this->sendError('Grupo not found');
        }

        $validator = Validator::make($input, [
            'grado' => [
                'required', 'numeric',
                Rule::unique('grupos')->where(function ($query) use ($grado, $curso) {
                    return $query->where('grado', $grado)
                        ->where('curso', $curso);
                })->ignore($grupo->id)
            ],
            'curso' => [
                'required',
            ],
            'docente_id' => [
                'required', 'numeric',
                Rule::unique('grupos')->ignore($grupo->id)
            ],
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->messages(),
                "data" => null
            ]);
        } else {
            $grupo = $this->grupoRepository->update($input, $id);
            return response()->json([
                "success" => true,
                "message" => $validator->messages(),
                "data" => $grupo
            ]);
            //return $this->sendResponse($grupo->toArray(), 'grupo updated successfully');
        }
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
