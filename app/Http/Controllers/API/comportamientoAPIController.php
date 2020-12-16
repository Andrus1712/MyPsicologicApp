<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatecomportamientoAPIRequest;
use App\Http\Requests\API\UpdatecomportamientoAPIRequest;
use App\Models\comportamiento;
use App\Repositories\comportamientoRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\actividades;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            ->leftjoin(DB::raw('tipo_comportamientos tc'), 'c.tipo_comportamiento_id', '=', 'tc.id')
            ->where(DB::raw('c.deleted_at', '!=', 'date()'))
            ->select(
                'c.id',
                'tc.id as tipo_comportamiento',
                'c.titulo',
                'c.descripcion',
                'c.fecha',
                'e.nombres',
                'e.apellidos',
                DB::raw('a.nombres as nombre_acudiente'),
                DB::raw('a.apellidos as apellido_acudiente'),
                'g.grado',
                'g.curso',
                'c.multimedia',
                'c.emisor',
                'e.created_at'
            )
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
        if (isset($request->id) && $request->method == 'update') {
            if ($request->file('multimedia')) {
                $path = Storage::disk('public')->put('documentosPSI', $request->file('multimedia'));

                $url_multimedia = './' . $path;
            } else {
                $url_multimedia = $request->multimedia;
            }

            comportamiento::where('id', $request->id)->update([
                'estudiante_id' => $request->estudiante_id,
                'tipo_comportamiento_id' => $request->tipo_comportamiento_id,
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'fecha' => $request->fecha,
                'multimedia'  => $url_multimedia,
                // 'emisor'  => $request->emisor,
            ]);
            return response()->json(['status' => 'Avances updated successfully.']);

        } else {
            if ($request->file('multimedia')) {
                $path = Storage::disk('public')->put('documentosPSI', $request->file('multimedia'));
                $url_multimedia = './' . $path;
            } else {
                $url_multimedia = null;
            }

            // $input = $request->all();

            $this->comportamientoRepository->create([
                'estudiante_id' => $request->estudiante_id,
                'titulo' => $request->titulo,
                'descripcion'  => $request->descripcion,
                'fecha' => $request->fecha,
                'multimedia'   => $url_multimedia,
                'tipo_comportamiento_id'   => $request->tipo_comportamiento_id,
                'emisor'   => Auth()->user(),
            ]);

            return response()->json(['status' => 'Avances saved successfully.']);
        }
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

        //Buscamos las actividades de este comportamiento
        actividades::where('comportamiento_id', $comportamiento->id)
            ->each(function ($actividad, $key) {
                $actividad->delete();
            });

        $comportamiento->delete();

        return response()->json(['status' => 'Comportamiento retrieved successfully']);
    }
}
