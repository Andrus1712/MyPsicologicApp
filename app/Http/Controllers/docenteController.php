<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatedocenteRequest;
use App\Http\Requests\UpdatedocenteRequest;
use App\Repositories\docenteRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class docenteController extends AppBaseController
{
    /** @var  docenteRepository */
    private $docenteRepository;

    public function __construct(docenteRepository $docenteRepo)
    {
        $this->middleware('auth');
        $this->docenteRepository = $docenteRepo;
    }

    /**
     * Display a listing of the docente.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth()->user();
        if ($user->havePermission('show.docentes')) {
            $this->docenteRepository->pushCriteria(new RequestCriteria($request));
            $docentes = $this->docenteRepository->all();

            return view('docentes.index')
                ->with('docentes', $docentes);
        } else {
            return redirect('/home');
        }
    }


    public function getDocentes()
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
                $docentes = DB::table(DB::raw('docentes d'))
                    ->where(DB::raw('d.deleted_at', '=', NULL))
                    ->select('d.*')
                    ->get();
            } else if ($queryUsers[0]->role_id == 2) {
                $docentes = DB::table(DB::raw('docentes d'))
                    ->where(DB::raw('d.deleted_at', '=', NULL))
                    ->select('d.*')
                    ->get();
            } else if ($queryUsers[0]->role_id == 3) {
                $docentes = DB::table(DB::raw('docentes d'))
                    ->where(DB::raw('d.deleted_at', '=', NULL))
                    ->select('d.*')
                    ->get();
            } else if ($queryUsers[0]->role_id == 4) {
                $docentes = DB::table(DB::raw('docentes d'))
                    ->where(DB::raw('d.deleted_at', '=', NULL))
                    ->select('d.*')
                    ->get();
            } else {
                $docentes = DB::table(DB::raw('docentes d'))
                    ->where(DB::raw('d.deleted_at', '=', NULL))
                    ->select('d.*')
                    ->get();
            }
        }

        //Permisos que tiene el usuario
        $permisos = [];

        if ($user->havePermission('edit.docentes')) {
            array_push($permisos, "edit.docentes");
        }

        if ($user->havePermission('delete.docentes')) {
            array_push($permisos, "delete.docentes");
        }

        if ($user->havePermission('create.docentes')) {
            array_push($permisos, "create.docentes");
        }
        if ($user->havePermission('create.actividades')) {
            array_push($permisos, "create.actividades");
        }

        $datos = [
            'docentes' => $docentes,
            'rol' => $rol,
            'permisos' => $permisos
        ];
        return response()->json($datos);
    }

    /**
     * Show the form for creating a new docente.
     *
     * @return Response
     */
    public function create()
    {
        return view('docentes.create');
    }

    /**
     * Store a newly created docente in storage.
     *
     * @param CreatedocenteRequest $request
     *
     * @return Response
     */
    public function store(CreatedocenteRequest $request)
    {
        $input = $request->all();

        $docente = $this->docenteRepository->create($input);

        Flash::success('Docente saved successfully.');

        return redirect(route('docentes.index'));
    }

    /**
     * Display the specified docente.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $docente = $this->docenteRepository->findWithoutFail($id);

        if (empty($docente)) {
            Flash::error('Docente not found');

            return redirect(route('docentes.index'));
        }

        return view('docentes.show')->with('docente', $docente);
    }

    /**
     * Show the form for editing the specified docente.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $docente = $this->docenteRepository->findWithoutFail($id);

        if (empty($docente)) {
            Flash::error('Docente not found');

            return redirect(route('docentes.index'));
        }

        return view('docentes.edit')->with('docente', $docente);
    }

    /**
     * Update the specified docente in storage.
     *
     * @param  int              $id
     * @param UpdatedocenteRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedocenteRequest $request)
    {
        $docente = $this->docenteRepository->findWithoutFail($id);

        if (empty($docente)) {
            Flash::error('Docente not found');

            return redirect(route('docentes.index'));
        }

        $docente = $this->docenteRepository->update($request->all(), $id);

        Flash::success('Docente updated successfully.');

        return redirect(route('docentes.index'));
    }

    /**
     * Remove the specified docente from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $docente = $this->docenteRepository->findWithoutFail($id);

        if (empty($docente)) {
            Flash::error('Docente not found');

            return redirect(route('docentes.index'));
        }

        $this->docenteRepository->delete($id);

        Flash::success('Docente deleted successfully.');

        return redirect(route('docentes.index'));
    }
}
