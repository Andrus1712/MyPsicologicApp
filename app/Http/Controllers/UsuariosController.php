<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsuariosRequest;
use App\Http\Requests\UpdateUsuariosRequest;
use App\Repositories\UsuariosRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\acudiente;
use App\Models\docente;
use App\Models\estudiante;
use App\Models\psicologo;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UsuariosController extends AppBaseController
{
    /** @var  UsuariosRepository */
    private $usuariosRepository;

    public function __construct(UsuariosRepository $usuariosRepo)
    {
        $this->middleware('auth');
        $this->usuariosRepository = $usuariosRepo;
    }

    /**
     * Display a listing of the Usuarios.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth()->user();
        if ($user->havePermission('show.user')) {
            $this->usuariosRepository->pushCriteria(new RequestCriteria($request));
            $usuarios = User::all();

            return view('usuarios.index')->with('usuarios', $usuarios);
        } else {
            return redirect('/home');
        }
    }

    public function getUsuarios()
    {
        $user = Auth()->user();
        $rol = $user->tieneRol();


        $usuarios = User::all();

        foreach ($usuarios as $usuario) {
            $usuario->roles;
        }

        //Permisos que tiene el usuario
        $permisos = [];

        if ($user->havePermission('edit.user')) {
            array_push($permisos, "edit.user");
        }

        if ($user->havePermission('delete.user')) {
            array_push($permisos, "delete.user");
        }

        if ($user->havePermission('create.user')) {
            array_push($permisos, "create.user");
        }

        $datos = [
            'usuarios' => $usuarios,
            'rol' => $rol,
            'permisos' => $permisos
        ];
        return response()->json($datos);
    }

    public function getProfile()
    {
        $user = Auth()->user();

        $p = DB::table('psicologos')->where('correo', $user->email)->select('direccion')->get();
        $e = DB::table('estudiantes')->where('estudiantes.correo', $user->email)
        ->join('acudientes', 'acudientes.id', '=', 'estudiantes.acudiente_id')
        ->select('acudientes.direccion')->get();
        $d = DB::table('docentes')->where('correo', $user->email)->select('direccion')->get();
        $a = DB::table('acudientes')->where('correo', $user->email)->select('direccion')->get();



        $dir = [];

        if (count($p) != 0) {
            array_push($dir, $p);
        } else if (count($e) != 0) {
            array_push($dir, $e);
        } else if (count($d) != 0) {
            array_push($dir, $d);
        } else if (count($a) != 0) {
            array_push($dir, $a);
        } else {
            array_push($dir, "sin direccion");
        }

        $datos = [
            "nombre" => $user->name,
            "rol" => $user->nombreRol(),
            "descripcion" => $user->descripcionRol(),
            "direccion" => $dir
        ];


        return view('profile')->with('datos', $datos);
    }
    /**
     * Show the form for creating a new Usuarios.
     *
     * @return Response
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created Usuarios in storage.
     *
     * @param CreateUsuariosRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // $input = $request->all();
        // $usuarios = $this->usuariosRepository->create($input);

        $role_id = $request->role_id;

        $role = Role::find($role_id);

        $usuarios = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);

        $usuarios->asignarRol($role);


        Flash::success('Usuarios saved successfully.');

        return redirect(route('usuarios.index'));
    }

    public function readNotification(Request $request)
    {
        $notify_id = $request->id;

        $notification = auth()->user()->unreadNotifications->find($notify_id);
        if ($notification) {
            $notification->markAsRead();
        }
        return redirect()->back();
    }

    /**
     * Display the specified Usuarios.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $usuarios = $this->usuariosRepository->findWithoutFail($id);

        if (empty($usuarios)) {
            Flash::error('Usuarios not found');

            return redirect(route('usuarios.index'));
        }

        return view('usuarios.show')->with('usuarios', $usuarios);
    }

    /**
     * Show the form for editing the specified Usuarios.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $usuarios = $this->usuariosRepository->findWithoutFail($id);

        if (empty($usuarios)) {
            Flash::error('Usuarios not found');

            return redirect(route('usuarios.index'));
        }

        return view('usuarios.edit')->with('usuarios', $usuarios);
    }

    /**
     * Update the specified Usuarios in storage.
     *
     * @param  int              $id
     * @param UpdateUsuariosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUsuariosRequest $request)
    {
        $usuarios = $this->usuariosRepository->findWithoutFail($id);

        if (empty($usuarios)) {
            Flash::error('Usuarios not found');

            return redirect(route('usuarios.index'));
        }

        $usuarios = $this->usuariosRepository->update($request->all(), $id);

        Flash::success('Usuarios updated successfully.');

        return redirect(route('usuarios.index'));
    }

    /**
     * Remove the specified Usuarios from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $usuarios = $this->usuariosRepository->findWithoutFail($id);

        if (empty($usuarios)) {
            Flash::error('Usuarios not found');

            return redirect(route('usuarios.index'));
        }

        $this->usuariosRepository->delete($id);

        Flash::success('Usuarios deleted successfully.');

        return redirect(route('usuarios.index'));
    }
}
