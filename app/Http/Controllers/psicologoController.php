<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatepsicologoRequest;
use App\Http\Requests\UpdatepsicologoRequest;
use App\Repositories\psicologoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class psicologoController extends AppBaseController
{
    /** @var  psicologoRepository */
    private $psicologoRepository;

    public function __construct(psicologoRepository $psicologoRepo)
    {
        $this->middleware('auth');
        $this->psicologoRepository = $psicologoRepo;
    }

    /**
     * Display a listing of the psicologo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth()->user();
        if ($user->havePermission('show.psicologos')) {
            $this->psicologoRepository->pushCriteria(new RequestCriteria($request));
            $psicologos = $this->psicologoRepository->all();

            return view('psicologos.index')
                ->with('psicologos', $psicologos);
        } else {
            return redirect('/home');
        }
    }

    /**
     * Show the form for creating a new psicologo.
     *
     * @return Response
     */
    public function create()
    {
        return view('psicologos.create');
    }

    public function getPsicologos()
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
                $psicologos = DB::table(DB::raw('psicologos p'))
                    ->where(DB::raw('p.deleted_at', '=', 'NULL'))
                    ->select('p.*')
                    ->get();
            } else if ($queryUsers[0]->role_id == 2) {
                $psicologos = DB::table(DB::raw('psicologos p'))
                    ->where(DB::raw('p.deleted_at', '=', 'NULL'))
                    ->select('p.*')
                    ->get();
            } else if ($queryUsers[0]->role_id == 3) {
                $psicologos = DB::table(DB::raw('psicologos p'))
                    ->where(DB::raw('p.deleted_at', '=', 'NULL'))
                    ->select('p.*')
                    ->get();
            } else if ($queryUsers[0]->role_id == 4) {
                $psicologos = DB::table(DB::raw('psicologos p'))
                    ->where(DB::raw('p.deleted_at', '=', 'NULL'))
                    ->select('p.*')
                    ->get();
            } else {
                $psicologos = DB::table(DB::raw('psicologos p'))
                    ->where(DB::raw('p.deleted_at', '=', 'NULL'))
                    ->select('p.*')
                    ->get();
            }
        }

        //Permisos que tiene el usuario
        $permisos = [];

        if ($user->havePermission('edit.psicologos')) {
            array_push($permisos, "edit.psicologos");
        }

        if ($user->havePermission('delete.psicologos')) {
            array_push($permisos, "delete.psicologos");
        }

        if ($user->havePermission('create.psicologos')) {
            array_push($permisos, "create.psicologos");
        }
        if ($user->havePermission('create.psicologos')) {
            array_push($permisos, "create.psicologos");
        }

        $datos = [
            'psicologos' => $psicologos,
            'rol' => $rol,
            'permisos' => $permisos
        ];
        return response()->json($datos);
    }

    /**
     * Store a newly created psicologo in storage.
     *
     * @param CreatepsicologoRequest $request
     *
     * @return Response
     */
    public function store(CreatepsicologoRequest $request)
    {
        $input = $request->all();

        $psicologo = $this->psicologoRepository->create($input);

        Flash::success('Psicologo saved successfully.');

        return redirect(route('psicologos.index'));
    }

    /**
     * Display the specified psicologo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $psicologo = $this->psicologoRepository->findWithoutFail($id);

        if (empty($psicologo)) {
            Flash::error('Psicologo not found');

            return redirect(route('psicologos.index'));
        }

        return view('psicologos.show')->with('psicologo', $psicologo);
    }

    /**
     * Show the form for editing the specified psicologo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $psicologo = $this->psicologoRepository->findWithoutFail($id);

        if (empty($psicologo)) {
            Flash::error('Psicologo not found');

            return redirect(route('psicologos.index'));
        }

        return view('psicologos.edit')->with('psicologo', $psicologo);
    }

    /**
     * Update the specified psicologo in storage.
     *
     * @param  int              $id
     * @param UpdatepsicologoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepsicologoRequest $request)
    {
        $psicologo = $this->psicologoRepository->findWithoutFail($id);

        if (empty($psicologo)) {
            Flash::error('Psicologo not found');

            return redirect(route('psicologos.index'));
        }

        $psicologo = $this->psicologoRepository->update($request->all(), $id);

        Flash::success('Psicologo updated successfully.');

        return redirect(route('psicologos.index'));
    }

    /**
     * Remove the specified psicologo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $psicologo = $this->psicologoRepository->findWithoutFail($id);

        if (empty($psicologo)) {
            Flash::error('Psicologo not found');

            return redirect(route('psicologos.index'));
        }

        $this->psicologoRepository->delete($id);

        Flash::success('Psicologo deleted successfully.');

        return redirect(route('psicologos.index'));
    }
}
