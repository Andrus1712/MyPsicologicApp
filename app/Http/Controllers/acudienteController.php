<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateacudienteRequest;
use App\Http\Requests\UpdateacudienteRequest;
use App\Repositories\acudienteRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class acudienteController extends AppBaseController
{
    /** @var  acudienteRepository */
    private $acudienteRepository;

    public function __construct(acudienteRepository $acudienteRepo)
    {
        $this->middleware('auth');
        $this->acudienteRepository = $acudienteRepo;
    }

    /**
     * Display a listing of the acudiente.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth()->user();
        if ($user->havePermission('show.acudientes')) {
            $this->acudienteRepository->pushCriteria(new RequestCriteria($request));
            $acudientes = $this->acudienteRepository->all();

            return view('acudientes.index')
                ->with('acudientes', $acudientes);
        } else {
            return redirect('/home');
        }
    }

    public function getAcudientes()
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
                $acudientes = DB::table(DB::raw('acudientes a'))
                    ->where(DB::raw('a.deleted_at'), '=', NULL)
                    ->select('a.*')
                    ->get();
            } else if ($queryUsers[0]->role_id == 2) {
                $acudientes = DB::table(DB::raw('acudientes a'))
                    ->where(DB::raw('a.deleted_at'), '=', NULL)
                    ->join(DB::raw('estudiante e'), 'e.acudiente_id', '=', 'a.id')
                    ->select('a.*')
                    ->get();
            } else if ($queryUsers[0]->role_id == 3) {
                $acudientes = DB::table(DB::raw('acudientes a'))
                    ->where(DB::raw('a.deleted_at'), '=', NULL)
                    ->select('a.*')
                    ->get();
            } else if ($queryUsers[0]->role_id == 4) {
                $acudientes = DB::table(DB::raw('acudientes a'))
                    ->where(DB::raw('a.deleted_at'), '=', NULL)
                    ->select('a.*')
                    ->get();
            } else {
                $acudientes = DB::table(DB::raw('acudientes a'))
                    ->where(DB::raw('a.deleted_at'), '=', NULL)
                    ->select('a.*')
                    ->get();
            }
        }


        //Permisos que tiene el usuario
        $permisos = [];

        if ($user->havePermission('edit.acudientes')) {
            array_push($permisos, "edit.acudientes");
        }

        if ($user->havePermission('delete.acudientes')) {
            array_push($permisos, "delete.acudientes");
        }

        if ($user->havePermission('create.acudientes')) {
            array_push($permisos, "create.acudientes");
        }

        $datos = [
            'acudientes' => $acudientes,
            'rol' => $rol,
            'permisos' => $permisos
        ];
        return response()->json($datos);
    }

    /**
     * Show the form for creating a new acudiente.
     *
     * @return Response
     */
    public function create()
    {
        return view('acudientes.create');
    }

    /**
     * Store a newly created acudiente in storage.
     *
     * @param CreateacudienteRequest $request
     *
     * @return Response
     */
    public function store(CreateacudienteRequest $request)
    {
        $input = $request->all();

        $acudiente = $this->acudienteRepository->create($input);

        Flash::success('Acudiente saved successfully.');

        return redirect(route('acudientes.index'));
    }

    /**
     * Display the specified acudiente.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $acudiente = $this->acudienteRepository->findWithoutFail($id);

        if (empty($acudiente)) {
            Flash::error('Acudiente not found');

            return redirect(route('acudientes.index'));
        }

        return view('acudientes.show')->with('acudiente', $acudiente);
    }

    /**
     * Show the form for editing the specified acudiente.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $acudiente = $this->acudienteRepository->findWithoutFail($id);

        if (empty($acudiente)) {
            Flash::error('Acudiente not found');

            return redirect(route('acudientes.index'));
        }

        return view('acudientes.edit')->with('acudiente', $acudiente);
    }

    /**
     * Update the specified acudiente in storage.
     *
     * @param  int              $id
     * @param UpdateacudienteRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateacudienteRequest $request)
    {
        $acudiente = $this->acudienteRepository->findWithoutFail($id);

        if (empty($acudiente)) {
            Flash::error('Acudiente not found');

            return redirect(route('acudientes.index'));
        }

        $acudiente = $this->acudienteRepository->update($request->all(), $id);

        Flash::success('Acudiente updated successfully.');

        return redirect(route('acudientes.index'));
    }

    /**
     * Remove the specified acudiente from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $acudiente = $this->acudienteRepository->findWithoutFail($id);

        if (empty($acudiente)) {
            Flash::error('Acudiente not found');

            return redirect(route('acudientes.index'));
        }

        $this->acudienteRepository->delete($id);

        Flash::success('Acudiente deleted successfully.');

        return redirect(route('acudientes.index'));
    }
}
