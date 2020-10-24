<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateestudianteRequest;
use App\Http\Requests\UpdateestudianteRequest;
use App\Repositories\estudianteRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class estudianteController extends AppBaseController
{
    /** @var  estudianteRepository */
    private $estudianteRepository;

    public function __construct(estudianteRepository $estudianteRepo)
    {
        $this->estudianteRepository = $estudianteRepo;
    }

    /**
     * Display a listing of the estudiante.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth()->user();
        if ($user->havePermission('show.estudiantes')) {
            $this->estudianteRepository->pushCriteria(new RequestCriteria($request));
            $estudiantes = $this->estudianteRepository->all();

            return view('estudiantes.index')->with('estudiantes', $estudiantes);
        } else {
            return redirect('/home');
        }
    }

    public function getEstudiantes()
    {
        $user = Auth()->user();

        $rol = $user->tieneRol();

        if ($rol == 'psi-user') {
            $estudiantes = DB::table(DB::raw('estudiantes e'))->where(DB::raw('e.deleted_at', '=', 'NULL'))
                ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
                ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
                ->select(
                    'e.id',
                    'e.tipoIdentificacion',
                    'e.identificacion',
                    'e.nombres',
                    'e.apellidos',
                    'e.edad',
                    'e.telefono',
                    'e.correo',
                    'e.fechaNacimiento',
                    DB::raw('a.nombres as nombre_acudiente'),
                    DB::raw('a.apellidos as apellido_acudiente'),
                    DB::raw('a.telefono as telefono_acudiente'),
                    DB::raw('a.correo as correo_acudiente'),
                    'g.grado',
                    'g.curso',
                    DB::raw('d.nombres as nombre_docente'),
                    DB::raw('d.apellidos as apellidos_docente'),
                    'e.created_at'
                )->get();
        } else if ($rol == 'est-user') {
            $estudiantes = DB::table(DB::raw('estudiantes e'))->where(DB::raw('e.deleted_at', '=', 'NULL'))
                ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
                ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
                ->where(DB::raw('e.correo'), '=', $user->email)
                ->select(
                    'e.id',
                    'e.tipoIdentificacion',
                    'e.identificacion',
                    'e.nombres',
                    'e.apellidos',
                    'e.edad',
                    'e.telefono',
                    'e.correo',
                    'e.fechaNacimiento',
                    DB::raw('a.nombres as nombre_acudiente'),
                    DB::raw('a.apellidos as apellido_acudiente'),
                    DB::raw('a.telefono as telefono_acudiente'),
                    DB::raw('a.correo as correo_acudiente'),
                    'g.grado',
                    'g.curso',
                    DB::raw('d.nombres as nombre_docente'),
                    DB::raw('d.apellidos as apellidos_docente'),
                    'e.created_at'
                )->get();
        } else if ($rol == 'acu-user') {
            $estudiantes = DB::table(DB::raw('estudiantes e'))->where(DB::raw('e.deleted_at', '=', 'NULL'))
                ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
                ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
                ->where(DB::raw('a.correo'), '=', $user->email)
                ->select(
                    'e.id',
                    'e.tipoIdentificacion',
                    'e.identificacion',
                    'e.nombres',
                    'e.apellidos',
                    'e.edad',
                    'e.telefono',
                    'e.correo',
                    'e.fechaNacimiento',
                    DB::raw('a.nombres as nombre_acudiente'),
                    DB::raw('a.apellidos as apellido_acudiente'),
                    DB::raw('a.telefono as telefono_acudiente'),
                    DB::raw('a.correo as correo_acudiente'),
                    'g.grado',
                    'g.curso',
                    DB::raw('d.nombres as nombre_docente'),
                    DB::raw('d.apellidos as apellidos_docente'),
                    'e.created_at'
                )->get();
        } else if ($rol == 'doc-user') {
            $estudiantes = DB::table(DB::raw('estudiantes e'))->where(DB::raw('e.deleted_at', '=', 'NULL'))
                ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
                ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
                ->select(
                    'e.id',
                    'e.tipoIdentificacion',
                    'e.identificacion',
                    'e.nombres',
                    'e.apellidos',
                    'e.edad',
                    'e.telefono',
                    'e.correo',
                    'e.fechaNacimiento',
                    DB::raw('a.nombres as nombre_acudiente'),
                    DB::raw('a.apellidos as apellido_acudiente'),
                    DB::raw('a.telefono as telefono_acudiente'),
                    DB::raw('a.correo as correo_acudiente'),
                    'g.grado',
                    'g.curso',
                    DB::raw('d.nombres as nombre_docente'),
                    DB::raw('d.apellidos as apellidos_docente'),
                    'e.created_at'
                )->get();
        } else {
            $estudiantes = DB::table(DB::raw('estudiantes e'))->where(DB::raw('e.deleted_at', '=', 'NULL'))
                ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
                ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
                ->select(
                    'e.id',
                    'e.tipoIdentificacion',
                    'e.identificacion',
                    'e.nombres',
                    'e.apellidos',
                    'e.edad',
                    'e.telefono',
                    'e.correo',
                    'e.fechaNacimiento',
                    DB::raw('a.nombres as nombre_acudiente'),
                    DB::raw('a.apellidos as apellido_acudiente'),
                    DB::raw('a.telefono as telefono_acudiente'),
                    DB::raw('a.correo as correo_acudiente'),
                    'g.grado',
                    'g.curso',
                    DB::raw('d.nombres as nombre_docente'),
                    DB::raw('d.apellidos as apellidos_docente'),
                    'e.created_at'
                )->get();
        }

        //Permisos que tiene el usuario
        $permisos = [];

        if ($user->havePermission('edit.estudiantes')) {
            array_push($permisos, "edit.estudiantes");
        }

        if ($user->havePermission('delete.estudiantes')) {
            array_push($permisos, "delete.estudiantes");
        }
        
        if ($user->havePermission('create.estudiantes')) {
            array_push($permisos, "create.estudiantes");
        }
        if ($user->havePermission('create.estudiantes')) {
            array_push($permisos, "create.estudiantes");
        }

        $datos = [
            'estudiantes' => $estudiantes,
            'rol' => $rol,
            'permisos' => $permisos
        ];

        return response()->json($datos);
    }

    /**
     * Show the form for creating a new estudiante.
     *
     * @return Response
     */
    public function create()
    {
        return view('estudiantes.create');
    }

    /**
     * Store a newly created estudiante in storage.
     *
     * @param CreateestudianteRequest $request
     *
     * @return Response
     */
    public function store(CreateestudianteRequest $request)
    {
        $input = $request->all();

        $estudiante = $this->estudianteRepository->create($input);

        Flash::success('Estudiante saved successfully.');

        return redirect(route('estudiantes.index'));
    }

    /**
     * Display the specified estudiante.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $estudiante = $this->estudianteRepository->findWithoutFail($id);

        if (empty($estudiante)) {
            Flash::error('Estudiante not found');

            return redirect(route('estudiantes.index'));
        }

        return view('estudiantes.show')->with('estudiante', $estudiante);
    }

    /**
     * Show the form for editing the specified estudiante.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $estudiante = $this->estudianteRepository->findWithoutFail($id);

        if (empty($estudiante)) {
            Flash::error('Estudiante not found');

            return redirect(route('estudiantes.index'));
        }

        return view('estudiantes.edit')->with('estudiante', $estudiante);
    }

    /**
     * Update the specified estudiante in storage.
     *
     * @param  int              $id
     * @param UpdateestudianteRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateestudianteRequest $request)
    {
        $estudiante = $this->estudianteRepository->findWithoutFail($id);

        if (empty($estudiante)) {
            Flash::error('Estudiante not found');

            return redirect(route('estudiantes.index'));
        }

        $estudiante = $this->estudianteRepository->update($request->all(), $id);

        Flash::success('Estudiante updated successfully.');

        return redirect(route('estudiantes.index'));
    }

    /**
     * Remove the specified estudiante from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $estudiante = $this->estudianteRepository->findWithoutFail($id);

        if (empty($estudiante)) {
            Flash::error('Estudiante not found');

            return redirect(route('estudiantes.index'));
        }

        $this->estudianteRepository->delete($id);

        Flash::success('Estudiante deleted successfully.');

        return redirect(route('estudiantes.index'));
    }
}
