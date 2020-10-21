<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatecomportamientoRequest;
use App\Http\Requests\UpdatecomportamientoRequest;
use App\Repositories\comportamientoRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\acudiente;
use Illuminate\Http\Request;
use App\Models\comportamiento;
use App\Models\psicologo;
use App\Notifications\NuevoComportamiento;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Storage;
use Flash;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class comportamientoController extends AppBaseController
{
    /** @var  comportamientoRepository */
    private $comportamientoRepository;

    public function __construct(comportamientoRepository $comportamientoRepo)
    {
        $this->comportamientoRepository = $comportamientoRepo;
    }

    /**
     * Display a listing of the comportamiento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->comportamientoRepository->pushCriteria(new RequestCriteria($request));
        $comportamientos = $this->comportamientoRepository->all();

        return view('comportamientos.index')
            ->with('comportamientos', $comportamientos);
    }

    public function getComportamientos()
    {
        $queryUsers = DB::table('role_user')
            ->select('role_user.*')
            ->where('role_user.user_id', '=', Auth()->user()->id)
            ->limit(1)
            ->get();
        if (count($queryUsers) != 0) {
            //ROl psicoorientador
            if ($queryUsers[0]->role_id == 1) {
                $comportamientos = DB::table(DB::raw('comportamientos c'))->where(DB::raw('c.deleted_at'), '=', NULL)
                    ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                    ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
                    ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                    ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
                    ->where(DB::raw('c.deleted_at', '!=', 'date()'))
                    ->select(
                        'c.id',
                        'c.cod_comportamiento',
                        'c.titulo',
                        'c.descripcion',
                        'c.fecha',
                        'c.emisor',
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
                return response()->json($comportamientos);
            } else if ($queryUsers[0]->role_id == 2) {
                $comportamientos = [];
                return response()->json($comportamientos);
            } else if ($queryUsers[0]->role_id == 3) {
                $comportamientos = DB::table(DB::raw('comportamientos c'))->where(DB::raw('c.deleted_at'), '=', NULL)
                    ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                    ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
                    ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                    ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
                    ->where(DB::raw('c.deleted_at', '!=', 'date()'))
                    ->where(DB::raw('c.emisor'), '=', auth()->user())
                    ->select(
                        'c.id',
                        'c.cod_comportamiento',
                        'c.titulo',
                        'c.descripcion',
                        'c.fecha',
                        'e.nombres',
                        'e.apellidos',
                        'g.grado',
                        'g.curso',
                        'c.multimedia'
                    )
                    ->get();
                return response()->json($comportamientos);
            } else if ($queryUsers[0]->role_id == 4) {
                $comportamientos = DB::table(DB::raw('comportamientos c'))->where(DB::raw('c.deleted_at'), '=', NULL)
                    ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                    ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
                    ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                    ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
                    ->where(DB::raw('c.deleted_at', '!=', 'date()'))
                    ->where(DB::raw('c.emisor'), '=', auth()->user())
                    ->select(
                        'c.id',
                        'c.cod_comportamiento',
                        'c.titulo',
                        'c.descripcion',
                        'c.fecha',
                        'e.nombres',
                        'e.apellidos',
                        'g.grado',
                        'g.curso',
                        'c.multimedia'
                    )
                    ->get();
                return response()->json($comportamientos);
            }
        }
    }

    public function getCountComp()
    {
        $queryUsers = DB::table('role_user')
            ->select('role_user.*')
            ->where('role_user.user_id', '=', Auth()->user()->id)
            ->limit(1)
            ->get();

        if (count($queryUsers) != 0) {

            // SELECT 
            // COUNT(c.id)
            // FROM comportamientos c
            // WHERE c.deleted_at IS NULL 
            // AND c.id NOT IN(
            // SELECT 
            // c.id
            // FROM comportamientos c
            // INNER JOIN actividades act ON (c.id = act.comportamiento_id)
            // WHERE c.deleted_at IS NULL 
            // )
            if ($queryUsers[0]->role_id == 1) {

                //Consultar cuantos comportamientos no tienen asignada actividades
                $array = DB::table(DB::raw('comportamientos co'))
                    ->where(DB::raw('co.deleted_at'), '=', NULL)
                    ->select(DB::raw('co.id'))
                    ->join(DB::raw('actividades a'), 'co.id', '=', 'a.comportamiento_id')
                    ->where(DB::raw('a.deleted_at'), '=', NULL)
                    ->groupBy(DB::raw('co.id'))
                    ->get();
                if(count($array) != 0)
                {
                    foreach ($array as $a) {
                        $data[] = $a->id;
                    }
                
                    $contador = DB::table(DB::raw('comportamientos c'))
                        ->select(DB::raw('c.id'))
                        ->where(DB::raw('c.deleted_at'), '=', NULL)
                        ->whereNotIn(DB::raw('c.id'), $data)
                        ->get();
                    return response()->json($contador);
                }else
                {
                    $contador= [];
                    return response()->json($contador);
                }
                
            } else if ($queryUsers[0]->role_id == 2) {

                //Consultar cuantos comportamientos no tienen asignada actividades
                //Y que solo fueron agregados por el usuario logeado
                $array = DB::table(DB::raw('comportamientos co'))
                    ->where(DB::raw('co.deleted_at'), '=', NULL)
                    ->select(DB::raw('co.id'))
                    ->join(DB::raw('actividades a'), 'co.id', '=', 'a.comportamiento_id')
                    ->groupBy(DB::raw('co.id'))
                    ->get();

                foreach ($array as $a) {
                    $data[] = $a->id;
                }

                $contador = DB::table(DB::raw('comportamientos c'))
                    ->select(DB::raw('c.id'))
                    ->where(DB::raw('c.deleted_at'), '=', NULL)
                    ->where(DB::raw('c.emisor'), '=', auth()->user())
                    ->whereNotIn(DB::raw('c.id'), $data)
                    ->get();
                return response()->json($contador);
            } else if ($queryUsers[0]->role_id == 3) {

                //Consultar cuantos comportamientos no tienen asignada actividades
                //Y que solo fueron agregados por el usuario logeado
                $array = DB::table(DB::raw('comportamientos co'))
                    ->where(DB::raw('co.deleted_at'), '=', NULL)
                    ->select(DB::raw('co.id'))
                    ->join(DB::raw('actividades a'), 'co.id', '=', 'a.comportamiento_id')
                    ->groupBy(DB::raw('co.id'))
                    ->get();

                foreach ($array as $a) {
                    $data[] = $a->id;
                }

                $contador = DB::table(DB::raw('comportamientos c'))
                    ->select(DB::raw('c.id'))
                    ->where(DB::raw('c.deleted_at'), '=', NULL)
                    ->where(DB::raw('c.emisor'), '=', auth()->user())
                    ->whereNotIn(DB::raw('c.id'), $data)
                    ->get();
                return response()->json($contador);
            } else if ($queryUsers[0]->role_id == 4) {

                //Consultar cuantos comportamientos no tienen asignada actividades
                //Y que solo fueron agregados por el usuario logeado
                $array = DB::table(DB::raw('comportamientos co'))
                    ->where(DB::raw('co.deleted_at'), '=', NULL)
                    ->select(DB::raw('co.id'))
                    ->join(DB::raw('actividades a'), 'co.id', '=', 'a.comportamiento_id')
                    ->groupBy(DB::raw('co.id'))
                    ->get();

                foreach ($array as $a) {
                    $data[] = $a->id;
                }

                $contador = DB::table(DB::raw('comportamientos c'))
                    ->select(DB::raw('c.id'))
                    ->where(DB::raw('c.deleted_at'), '=', NULL)
                    ->where(DB::raw('c.emisor'), '=', auth()->user())
                    ->whereNotIn(DB::raw('c.id'), $data)
                    ->get();
                return response()->json($contador);
            }
        }
    }


    /**
     * Show the form for creating a new comportamiento.
     *
     * @return Response
     */
    public function create()
    {
        return view('comportamientos.create');
    }

    /**
     * Store a newly created comportamiento in storage.
     *
     * @param CreatecomportamientoRequest $request
     *
     * @return Response
     */
    public function store(CreatecomportamientoRequest $request)
    {
        $input = $request->all();

        $comportamiento = $this->comportamientoRepository->create($input);

        Flash::success('Comportamiento saved successfully.');

        return redirect(route('comportamientos.index'));
    }

    public function add_comportamientos(Request $request)
    {
        // dd($request->all());
        
        if (isset($request->id) && $request->method == 'update') {
            
            $url_multimedia = $request->archivos != 0 ? '' : $request->tempMultimedia;

            for($i=0; $i<$request->archivos; $i++)
            {
                if(is_numeric($i))
                {
                    if ($request->file("file$i")) {
                        $path = Storage::disk('public')->put('documentosPSI', $request->file("file$i"));
                        $url_multimedia .= 'PSIAPP./' . $path;
                    }
                }                    
            }

            comportamiento::where('id', $request->id)->update([
                'cod_comportamiento' => $request->cod_comportamiento,
                'estudiante_id' => $request->estudiante_id,
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'fecha' => $request->fecha,
                'multimedia'  => $url_multimedia,
                // 'emisor'  => $request->emisor,
            ]);
            return response()->json(['status' => 'Avances updated successfully.']);
        } else {
            $url_multimedia = $request->archivos != 0 ? '' : null;

            for($i=0; $i<$request->archivos; $i++)
            {
                if(is_numeric($i))
                {
                    if ($request->file("file$i")) {
                        $path = Storage::disk('public')->put('documentosPSI', $request->file("file$i"));
                        $url_multimedia .= 'PSIAPP./' . $path;
                    }
                }                    
            }
            // dd($archivosR);
            

            $emisor = auth()->user();


            // $this->comportamientoRepository->create([
            //     'estudiante_id' => $request->estudiante_id,
            //     'titulo' => $request->titulo,
            //     'descripcion'  => $request->descripcion,
            //     'fecha' => $request->fecha,
            //     'multimedia'   => $url_multimedia,
            //     'cod_comportamiento'   => $request->cod_comportamiento,
            //     'emisor'   => auth()->user()->id,
            // ]);

            $comportamiento = comportamiento::create([
                'estudiante_id' => $request['estudiante_id'],
                'titulo' => $request['titulo'],
                'descripcion'  => $request['descripcion'],
                'fecha' => $request['fecha'],
                'multimedia'   => $url_multimedia,
                'cod_comportamiento'   => $request['cod_comportamiento'],
                'emisor'   => $emisor,
            ]);
            // $user_psi = DB::table(DB::raw('role_user role'))
            //     ->join(DB::raw('roles r'), 'role.role_id', '=', 'r.id')
            //     ->join(DB::raw('users u'), 'role.user_id', '=', 'u.id')
            //     ->where('role.role_id', '=', '1')
            //     ->select(DB::raw('u.id'))
            //     ->get();


            // //Notificacion via sms
            // $nexmo = app('Nexmo\Client');
            // $nexmo->message()->send([
            //     'to'   => '573177765722',
            //     'from' => '573177765722',
            //     'text' => 'Hola'. $est->nombres . ', Tienes una nueva actividad: ' . $request->titulo .' fecha:'. $request->fecha
            // ]);

            $rol_users = Role::with('users')->where('name', 'Psicoorientador')
                ->each(function (Role $role_user) use ($comportamiento) {
                    foreach ($role_user->users as $u) {
                        $u->notify(new NuevoComportamiento($comportamiento));
                        $psi = psicologo::where('correo', $u->email)->firstOrFail();
                        //Notificacion via sms
                        // $nexmo = app('Nexmo\Client');
                        // $nexmo->message()->send([
                        //     'to'   => '57'.$psi->telefono,
                        //     'from' => '573177765722',
                        //     'text' => 'Hola '. $psi->nombres . ', Hay un nuevo comportamiento registrado: ' . $comportamiento->titulo .' Descripcion:'. $comportamiento->descripcion
                        // ]);
                    }
                });






            return response()->json(['status' => 'Comportamiento saved successfully.']);
        }
    }

    /**
     * Display the specified comportamiento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $queryUsers = DB::table('role_user')
            ->select('role_user.*')
            ->where('role_user.user_id', '=', Auth()->user()->id)
            ->limit(1)
            ->get();
        if (count($queryUsers) != 0) {
            //ROl psicoorientador
            if ($queryUsers[0]->role_id == 1) {
                $comportamiento = DB::table(DB::raw('comportamientos c'))->where(DB::raw('c.deleted_at'), '=', NULL)
                    ->where(DB::raw('c.id'), '=', $id)
                    ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                    ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
                    ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                    ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
                    ->select(
                        'c.id',
                        'c.cod_comportamiento',
                        'c.titulo',
                        'c.descripcion',
                        'c.fecha',
                        'c.emisor',
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
                if (empty($comportamiento)) {
                    Flash::error('Comportamiento not found');

                    return redirect(route('comportamientos.index'));
                }
                return view('comportamientos.show')->with('comportamiento', $comportamiento);
                // dd($comportamiento);

            } else if ($queryUsers[0]->role_id == 2) {
                $comportamiento = [];
                if (empty($comportamiento)) {
                    Flash::error('Comportamiento not found');

                    return redirect(route('comportamientos.index'));
                }
                return view('comportamientos.show')->with('comportamiento', $comportamiento);
            } else if ($queryUsers[0]->role_id == 3) {
                $comportamiento = DB::table(DB::raw('comportamientos c'))->where(DB::raw('c.deleted_at'), '=', NULL)
                    ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                    ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
                    ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                    ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
                    ->where(DB::raw('c.deleted_at', '!=', 'date()'))
                    ->where(DB::raw('c.emisor'), '=', auth()->user())
                    ->where(DB::raw('c.id', '=', $id))
                    ->select(
                        'c.id',
                        'c.cod_comportamiento',
                        'c.titulo',
                        'c.descripcion',
                        'c.fecha',
                        'e.nombres',
                        'e.apellidos',
                        'g.grado',
                        'g.curso',
                        'c.multimedia'
                    )
                    ->get();
                if (empty($comportamiento)) {
                    Flash::error('Comportamiento not found');

                    return redirect(route('comportamientos.index'));
                }
                return view('comportamientos.show')->with('comportamiento', $comportamiento . toArray);
            } else if ($queryUsers[0]->role_id == 4) {
                $comportamiento = DB::table(DB::raw('comportamientos c'))->where(DB::raw('c.deleted_at'), '=', NULL)
                    ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                    ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
                    ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                    ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
                    ->where(DB::raw('c.deleted_at', '!=', 'date()'))
                    ->where(DB::raw('c.emisor'), '=', auth()->user())
                    ->where(DB::raw('c.id', '=', $id))
                    ->select(
                        'c.id',
                        'c.cod_comportamiento',
                        'c.titulo',
                        'c.descripcion',
                        'c.fecha',
                        'e.nombres',
                        'e.apellidos',
                        'g.grado',
                        'g.curso',
                        'c.multimedia'
                    )
                    ->get();

                if (empty($comportamiento)) {
                    Flash::error('Comportamiento not found');

                    return redirect(route('comportamientos.index'));
                }

                return view('comportamientos.show')->with('comportamiento', $comportamiento);
            }
        }

        // $comportamiento = $this->comportamientoRepository->findWithoutFail($id);

        // if (empty($comportamiento)) {
        //     Flash::error('Comportamiento not found');

        //     return redirect(route('comportamientos.index'));
        // }

        // return view('comportamientos.show')->with('comportamiento', $comportamiento);
    }

    /**
     * Show the form for editing the specified comportamiento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $comportamiento = $this->comportamientoRepository->findWithoutFail($id);

        if (empty($comportamiento)) {
            Flash::error('Comportamiento not found');

            return redirect(route('comportamientos.index'));
        }

        return view('comportamientos.edit')->with('comportamiento', $comportamiento);
    }

    /**
     * Update the specified comportamiento in storage.
     *
     * @param  int              $id
     * @param UpdatecomportamientoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatecomportamientoRequest $request)
    {
        $comportamiento = $this->comportamientoRepository->findWithoutFail($id);

        if (empty($comportamiento)) {
            Flash::error('Comportamiento not found');

            return redirect(route('comportamientos.index'));
        }

        $comportamiento = $this->comportamientoRepository->update($request->all(), $id);

        Flash::success('Comportamiento updated successfully.');

        return redirect(route('comportamientos.index'));
    }

    /**
     * Remove the specified comportamiento from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $comportamiento = $this->comportamientoRepository->findWithoutFail($id);

        if (empty($comportamiento)) {
            Flash::error('Comportamiento not found');

            return redirect(route('comportamientos.index'));
        }

        $this->comportamientoRepository->delete($id);

        Flash::success('Comportamiento deleted successfully.');

        return redirect(route('comportamientos.index'));
    }
}
