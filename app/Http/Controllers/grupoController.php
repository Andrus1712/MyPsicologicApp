<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreategrupoRequest;
use App\Http\Requests\UpdategrupoRequest;
use App\Repositories\grupoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class grupoController extends AppBaseController
{
    /** @var  grupoRepository */
    private $grupoRepository;

    public function __construct(grupoRepository $grupoRepo)
    {
        $this->middleware('auth');
        $this->grupoRepository = $grupoRepo;
    }

    /**
     * Display a listing of the grupo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth()->user();
        if ($user->havePermission('show.cursos')) {
            $this->grupoRepository->pushCriteria(new RequestCriteria($request));
            $grupos = $this->grupoRepository->all();

            return view('grupos.index')
                ->with('grupos', $grupos);
        } else {
            return redirect('/home');
        }
    }

    /**
     * Show the form for creating a new grupo.
     *
     * @return Response
     */
    public function create()
    {
        return view('grupos.create');
    }

    public function getGrupos()
    {
        $user = Auth()->user();

        $rol = $user->tieneRol();
        if ($rol == 'psi-user') {
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
        } else if ($rol == 'doc-user') {
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
        } else if ($rol == 'est-user') {
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
        } else if ($rol == 'acu-user') {
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
        } else {
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
        }
        //Permisos que tiene el usuario
        $permisos = [];

        if ($user->havePermission('edit.cursos')) {
            array_push($permisos, "edit.cursos");
        }

        if ($user->havePermission('delete.cursos')) {
            array_push($permisos, "delete.cursos");
        }

        if ($user->havePermission('create.cursos')) {
            array_push($permisos, "create.cursos");
        }
        if ($user->havePermission('create.cursos')) {
            array_push($permisos, "create.cursos");
        }

        $datos = [
            'cursos' => $grupos,
            'rol' => $rol,
            'permisos' => $permisos
        ];
        return response()->json($datos);
    }

    /**
     * Store a newly created grupo in storage.
     *
     * @param CreategrupoRequest $request
     *
     * @return Response
     */
    public function store(CreategrupoRequest $request)
    {
        $input = $request->all();

        $grupo = $this->grupoRepository->create($input);

        Flash::success('Grupo saved successfully.');

        return redirect(route('grupos.index'));
    }

    /**
     * Display the specified grupo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $grupo = $this->grupoRepository->findWithoutFail($id);

        if (empty($grupo)) {
            Flash::error('Grupo not found');

            return redirect(route('grupos.index'));
        }

        return view('grupos.show')->with('grupo', $grupo);
    }

    /**
     * Show the form for editing the specified grupo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $grupo = $this->grupoRepository->findWithoutFail($id);

        if (empty($grupo)) {
            Flash::error('Grupo not found');

            return redirect(route('grupos.index'));
        }

        return view('grupos.edit')->with('grupo', $grupo);
    }

    /**
     * Update the specified grupo in storage.
     *
     * @param  int              $id
     * @param UpdategrupoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdategrupoRequest $request)
    {
        $grupo = $this->grupoRepository->findWithoutFail($id);

        if (empty($grupo)) {
            Flash::error('Grupo not found');

            return redirect(route('grupos.index'));
        }

        $grupo = $this->grupoRepository->update($request->all(), $id);

        Flash::success('Grupo updated successfully.');

        return redirect(route('grupos.index'));
    }

    /**
     * Remove the specified grupo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $grupo = $this->grupoRepository->findWithoutFail($id);

        if (empty($grupo)) {
            Flash::error('Grupo not found');

            return redirect(route('grupos.index'));
        }

        $this->grupoRepository->delete($id);

        Flash::success('Grupo deleted successfully.');

        return redirect(route('grupos.index'));
    }
}
