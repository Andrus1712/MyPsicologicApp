<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateavancesRequest;
use App\Http\Requests\UpdateavancesRequest;
use App\Repositories\avancesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class avancesController extends AppBaseController
{
    /** @var  avancesRepository */
    private $avancesRepository;

    public function __construct(avancesRepository $avancesRepo)
    {
        $this->middleware('auth');
        $this->avancesRepository = $avancesRepo;
    }

    /**
     * Display a listing of the avances.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth()->user();
        if ($user->havePermission('show.avances')) {
            $this->avancesRepository->pushCriteria(new RequestCriteria($request));
            $avances = $this->avancesRepository->all();

            return view('avances.index')
                ->with('avances', $avances);
        } else {
            return redirect('/home');
        }
    }

    public function getAvances()
    {
        $user = Auth()->user();

        $rol = $user->tieneRol();
        $queryUsers = DB::table('role_user')
            ->select('role_user.*')
            ->where('role_user.user_id', '=', Auth()->user()->id)
            ->limit(1)
            ->get();
        if (count($queryUsers) != 0) {
            if ($queryUsers[0]->role_id == 1) {
                $avances = DB::table(DB::raw('avances av'))->where(DB::raw('av.deleted_at', '=', 'NULL'))
                    ->join(DB::raw('actividades a'), 'av.actividad_id', '=', 'a.id')
                    ->join(DB::raw('comportamientos c'), 'a.comportamiento_id', '=', 'c.id')
                    ->join(DB::raw('tipo_comportamientos tc'), 'c.tipo_comportamiento_id', '=', 'tc.id')
                    ->join(DB::raw('estudiantes e'), 'cp.estudiante_id', '=', 'e.id')
                    ->select(
                        'av.id',
                        DB::raw('av.descripcion as avance'),
                        'av.fecha_avance',
                        DB::raw('a.estado as estado_actividad'),
                        DB::raw('a.titulo as titulo_actividad'),
                        DB::raw('a.descripcion as descripcion_actividad'),
                        DB::raw('a.fecha as fecha_actividad'),
                        DB::raw('c.titulo as comportamiento_registrado'),
                        DB::raw('t.titulo as titulo_tipo_comportamiento'),
                        DB::raw('e.nombres as nombre_estudiante'),
                        DB::raw('e.apellidos as apellido_estudiante'),
                        'av.evidencias',
                        DB::raw('a.id as id_actividad'),
                        'av.created_at'
                    )
                    ->get();
            } else if ($queryUsers[0]->role_id == 2) {
                $avances = DB::table(DB::raw('avances av'))->where(DB::raw('av.deleted_at', '=', 'NULL'))
                    ->join(DB::raw('actividades a'), 'av.actividad_id', '=', 'a.id')
                    ->join(DB::raw('comportamientos c'), 'a.comportamiento_id', '=', 'c.id')
                    ->join(DB::raw('tipo_comportamientos tc'), 'c.tipo_comportamiento_id', '=', 'tc.id')
                    ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                    ->where(DB::raw('e.correo'), '=', $user->email)
                    ->select(
                        'av.id',
                        DB::raw('av.descripcion as avance'),
                        'av.fecha_avance',
                        // DB::raw('a.id as id_actividad'),
                        DB::raw('a.estado as estado_actividad'),
                        DB::raw('a.titulo as titulo_actividad'),
                        DB::raw('a.descripcion as descripcion_actividad'),
                        DB::raw('a.fecha as fecha_actividad'),
                        DB::raw('c.titulo as comportamiento_registrado'),
                        // DB::raw('tc.titulo as titulo_tipo_comportamiento'),
                        // DB::raw('e.nombres as nombre_estudiante'),
                        // DB::raw('e.apellidos as apellido_estudiante'),
                        'av.evidencias',
                        'av.created_at'
                    )
                    ->get();
            } else if ($queryUsers[0]->role_id == 3) {
                $avances = DB::table(DB::raw('avances av'))->where(DB::raw('av.deleted_at', '=', 'NULL'))
                    ->join(DB::raw('actividades a'), 'av.actividad_id', '=', 'a.id')
                    ->join(DB::raw('comportamientos c'), 'a.comportamiento_id', '=', 'c.id')
                    ->join(DB::raw('tipo_comportamientos tc'), 'c.tipo_comportamiento_id', '=', 'tc.id')
                    ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                    ->where(DB::raw('e.id'), '=', DB::raw('c.estudiante_id'))
                    ->select(
                        'av.id',
                        DB::raw('av.descripcion as avance'),
                        'av.fecha_avance',
                        // DB::raw('a.id as id_actividad'),
                        DB::raw('a.estado as estado_actividad'),
                        DB::raw('a.titulo as titulo_actividad'),
                        DB::raw('a.descripcion as descripcion_actividad'),
                        DB::raw('a.fecha as fecha_actividad'),
                        DB::raw('c.titulo as comportamiento_registrado'),
                        DB::raw('tc.titulo as titulo_tipo_comportamiento'),
                        DB::raw('e.nombres as nombre_estudiante'),
                        DB::raw('e.apellidos as apellido_estudiante'),
                        'av.evidencias',
                        'av.created_at'
                    )
                    ->get();
            } else if ($queryUsers[0]->role_id == 4) {
                $avances = DB::table(DB::raw('avances av'))->where(DB::raw('av.deleted_at', '=', 'NULL'))
                    ->join(DB::raw('actividades a'), 'av.actividad_id', '=', 'a.id')
                    ->join(DB::raw('comportamientos c'), 'a.comportamiento_id', '=', 'c.id')
                    ->join(DB::raw('tipo_comportamientos tc'), 'c.tipo_comportamiento_id', '=', 'tc.id')
                    ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                    ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
                    ->where(DB::raw('a.correo'), '=', $user->email)
                    ->select(
                        'av.id',
                        DB::raw('av.descripcion as avance'),
                        'av.fecha_avance',
                        // DB::raw('a.id as id_actividad'),
                        DB::raw('a.estado as estado_actividad'),
                        DB::raw('a.titulo as titulo_actividad'),
                        DB::raw('a.descripcion as descripcion_actividad'),
                        DB::raw('a.fecha as fecha_actividad'),
                        DB::raw('c.titulo as comportamiento_registrado'),
                        DB::raw('tc.titulo as titulo_tipo_comportamiento'),
                        DB::raw('e.nombres as nombre_estudiante'),
                        DB::raw('e.apellidos as apellido_estudiante'),
                        'av.evidencias',
                        'av.created_at'
                    )
                    ->get();
            } else {
                $avances = DB::table(DB::raw('avances av'))->where(DB::raw('av.deleted_at', '=', 'NULL'))
                    ->join(DB::raw('actividades a'), 'av.actividad_id', '=', 'a.id')
                    ->join(DB::raw('comportamientos c'), 'a.comportamiento_id', '=', 'c.id')
                    ->join(DB::raw('tipo_comportamientos tc'), 'c.tipo_comportamiento_id', '=', 'tc.id')
                    ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                    ->select(
                        'av.id',
                        DB::raw('av.descripcion as avance'),
                        'av.fecha_avance',
                        DB::raw('a.estado as estado_actividad'),
                        DB::raw('a.titulo as titulo_actividad'),
                        DB::raw('a.descripcion as descripcion_actividad'),
                        DB::raw('a.fecha as fecha_actividad'),
                        DB::raw('c.titulo as comportamiento_registrado'),
                        DB::raw('tc.titulo as titulo_tipo_comportamiento'),
                        DB::raw('e.nombres as nombre_estudiante'),
                        DB::raw('e.apellidos as apellido_estudiante'),
                        'av.evidencias',
                        DB::raw('a.id as id_actividad'),
                        'av.created_at'
                    )
                    ->get();
            }
        }
        //Permisos que tiene el usuario
        $permisos = [];

        if ($user->havePermission('show.actividades')) {
            array_push($permisos, "show.actividades");
        }

        if ($user->havePermission('edit.actividades')) {
            array_push($permisos, "edit.actividades");
        }

        if ($user->havePermission('delete.actividades')) {
            array_push($permisos, "delete.actividades");
        }

        if ($user->havePermission('create.actividades')) {
            array_push($permisos, "create.actividades");
        }

        if ($user->havePermission('edit.avances')) {
            array_push($permisos, "edit.avances");
        }

        if ($user->havePermission('delete.avances')) {
            array_push($permisos, "delete.avances");
        }

        if ($user->havePermission('create.avances')) {
            array_push($permisos, "create.avances");
        }

        $datos = [
            'avances' => $avances,
            'rol' => $rol,
            'permisos' => $permisos
        ];
        return response()->json($datos);
    }


    /**
     * Show the form for creating a new avances.
     *
     * @return Response
     */
    public function create()
    {
        return view('avances.create');
    }

    /**
     * Store a newly created avances in storage.
     *
     * @param CreateavancesRequest $request
     *
     * @return Response
     */
    public function store(CreateavancesRequest $request)
    {
        $input = $request->all();

        $avances = $this->avancesRepository->create($input);

        Flash::success('Avances saved successfully.');

        return redirect(route('avances.index'));
    }

    /**
     * Display the specified avances.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $avances = $this->avancesRepository->findWithoutFail($id);

        if (empty($avances)) {
            Flash::error('Avances not found');

            return redirect(route('avances.index'));
        }

        return view('avances.show')->with('avances', $avances);
    }

    /**
     * Show the form for editing the specified avances.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $avances = $this->avancesRepository->findWithoutFail($id);

        if (empty($avances)) {
            Flash::error('Avances not found');

            return redirect(route('avances.index'));
        }

        return view('avances.edit')->with('avances', $avances);
    }

    /**
     * Update the specified avances in storage.
     *
     * @param  int              $id
     * @param UpdateavancesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateavancesRequest $request)
    {
        $avances = $this->avancesRepository->findWithoutFail($id);

        if (empty($avances)) {
            Flash::error('Avances not found');

            return redirect(route('avances.index'));
        }

        $avances = $this->avancesRepository->update($request->all(), $id);

        Flash::success('Avances updated successfully.');

        return redirect(route('avances.index'));
    }

    /**
     * Remove the specified avances from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $avances = $this->avancesRepository->findWithoutFail($id);

        if (empty($avances)) {
            Flash::error('Avances not found');

            return redirect(route('avances.index'));
        }

        $this->avancesRepository->delete($id);

        Flash::success('Avances deleted successfully.');

        return redirect(route('avances.index'));
    }
}
