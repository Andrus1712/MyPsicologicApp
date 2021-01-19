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
use App\Models\tipoComportamiento;
use App\Notifications\NuevoComportamiento;
use App\Role;
use Carbon\Carbon;
use PDF;
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
        $this->middleware('auth');
        $this->comportamientoRepository = $comportamientoRepo;
    }

    public function download_pdf(Request $request){
        $user = Auth()->user();
        if ($user->havePermission('make.reportes')) {

            $r = $request->all();

            $consulta = DB::table(DB::raw('tipo_comportamientos tc'))
                ->leftjoin(DB::raw('comportamientos c'), 'c.tipo_comportamiento_id', '=', 'tc.id')
                ->leftjoin(DB::raw('actividades ac'), 'ac.comportamiento_id', '=', 'c.id')
                ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                ->where(DB::raw('tc.deleted_at'), '=', NULL)
                ->where(DB::raw('c.deleted_at'), '=', NULL)
                ->whereBetween(DB::raw('c.fecha'), [$r['fecha_i'], $r['fecha_f']])
                ->select(
                    DB::raw('c.id'),
                    DB::raw('c.fecha'),
                    DB::raw('tc.titulo'),
                    DB::raw('c.titulo  AS casos'),
                    DB::raw('c.descripcion  AS caracteristicas'),
                    DB::raw('ac.estado'),
                    DB::raw('ac.titulo AS estrategia')
                )
                ->groupBy(
                    DB::raw('c.id'),
                    DB::raw('c.fecha'),
                    DB::raw('tc.titulo'),
                    DB::raw('ac.estado'),
                    DB::raw('c.descripcion'),
                    DB::raw('ac.titulo'),
                    DB::raw('c.titulo')
                )
                ->get();

            $consulta2 = DB::table(DB::raw('tipo_comportamientos tc'))
                ->leftjoin(DB::raw('comportamientos c'), 'c.tipo_comportamiento_id', '=', 'tc.id')
                ->leftjoin(DB::raw('actividades ac'), 'ac.comportamiento_id', '=', 'c.id')
                ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                ->where(DB::raw('tc.deleted_at'), '=', NULL)
                ->where(DB::raw('c.deleted_at'), '=', NULL)
                ->whereBetween(DB::raw('c.fecha'), [$r['fecha_i'], $r['fecha_f']])
                ->selectRaw("tc.titulo,
                    SUM(CASE WHEN e.sexo = 'M' THEN 1 ELSE 0 END) AS Masculino,
                    SUM(CASE when e.sexo = 'F' THEN 1 ELSE 0 END) AS Femenino,
                    COUNT(e.sexo) AS total
                ")
                ->groupBy(
                    DB::raw('tc.titulo'),
                )
                ->get();

            
            $conteo = DB::table(DB::raw('tipo_comportamientos tc'))
                ->leftjoin(DB::raw('comportamientos c'), 'c.tipo_comportamiento_id', '=', 'tc.id')
                ->leftjoin(DB::raw('actividades ac'), 'ac.comportamiento_id', '=', 'c.id')
                ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                ->where(DB::raw('tc.deleted_at'), '=', NULL)
                ->where(DB::raw('c.deleted_at'), '=', NULL)
                ->whereBetween(DB::raw('c.fecha'), [$r['fecha_i'], $r['fecha_f']])
                ->select(
                    DB::raw('tc.titulo'),
                    DB::raw('COUNT(tc.titulo)  AS cantidad'),
                )
                ->groupBy(
                    DB::raw('tc.titulo'),
                )
                ->get();

                $cont = 0;
                foreach ($conteo as $value) {
                    $cont += intval($value->cantidad);
                }

                
                $labels = "[";
                $data_url = "[";
                foreach ($conteo as $value) {
                    $labels .= "'$value->titulo',";
                    $data_url .= "'$value->cantidad',";
                }
                $labels .= "]";
                $data_url .= "]";

            //Importar imagen 
            // $img_url = "https://quickchart.io/chart?c={type:'doughnut',data:{labels:$labels,datasets:[{data:$data_url}]},options:{plugins:{doughnutlabel:{labels:[{text:'$cont',font:{size:20}},{text:'total'}]}}}}";
            // $content = file_get_contents($img_url);

            // file_put_contents("./documentosPSI/graph/grafico.jpg", $content);

            $data = [
                'consulta' => $consulta,
                'consulta2' => $consulta2,
                'conteo' => $conteo,
                'total' => $cont,
                'fecha_hoy' => Carbon::now()->format('d-m-Y'),
            ];

            $pdf = PDF::loadView('pdf_view', $data)
                ->setPaper('a4', 'landscape');

            return view('pdf_view')->with($data);
            // return $consulta;
            // return $pdf->stream('report.pdf');
        } else {
            return redirect('/home');
        }
    }

    public function download_pdf2(Request $request){
        $user = Auth()->user();
        if ($user->havePermission('make.reportes')) {

            $r = $request->all();

            $edad = explode(",", $r['edades']);
            $conducta = explode(",", $r['conductas_id']);
            $genero = explode(",", $r['generos']);
            $grupo = explode(",", $r['grupos_id']);

            $consulta = DB::table(DB::raw('tipo_comportamientos tc'))
                ->leftjoin(DB::raw('comportamientos c'), 'c.tipo_comportamiento_id', '=', 'tc.id')
                ->leftjoin(DB::raw('actividades ac'), 'ac.comportamiento_id', '=', 'c.id')
                ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                ->where(DB::raw('tc.deleted_at'), '=', NULL)
                ->where(DB::raw('c.deleted_at'), '=', NULL)
                ->whereBetween(DB::raw('c.fecha'), [$r['fecha_i'], $r['fecha_f']])
                ->whereBetween(DB::raw('e.edad'), [$edad[0], $edad[1]])
                ->whereIn(DB::raw('tc.id'), $conducta)
                ->whereIn(DB::raw('e.sexo'), $genero)
                ->whereIn(DB::raw('e.grupo_id'), $grupo)
                ->select(
                    DB::raw('c.id'),
                    DB::raw('c.fecha'),
                    DB::raw('tc.titulo'),
                    DB::raw('c.titulo  AS casos'),
                    DB::raw('e.edad'),
                    DB::raw('e.sexo'),
                    DB::raw('CONCAT(g.grado, "-", g.curso) as curso'),
                    DB::raw('c.descripcion  AS caracteristicas'),
                    DB::raw('ac.estado'),
                    DB::raw('ac.titulo AS estrategia')
                )
                ->groupBy(
                    DB::raw('c.id'),
                    DB::raw('c.fecha'),
                    DB::raw('tc.titulo'),
                    DB::raw('ac.estado'),
                    DB::raw('e.edad'),
                    DB::raw('e.sexo'),
                    DB::raw('c.descripcion'),
                    DB::raw('ac.titulo'),
                    DB::raw('c.titulo')
                )
                ->get();

                $consulta2 = DB::table(DB::raw('tipo_comportamientos tc'))
                ->leftjoin(DB::raw('comportamientos c'), 'c.tipo_comportamiento_id', '=', 'tc.id')
                ->leftjoin(DB::raw('actividades ac'), 'ac.comportamiento_id', '=', 'c.id')
                ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                ->where(DB::raw('tc.deleted_at'), '=', NULL)
                ->where(DB::raw('c.deleted_at'), '=', NULL)
                ->whereBetween(DB::raw('c.fecha'), [$r['fecha_i'], $r['fecha_f']])
                ->whereBetween(DB::raw('e.edad'), [$edad[0], $edad[1]])
                ->whereIn(DB::raw('tc.id'), $conducta)
                ->whereIn(DB::raw('e.sexo'), $genero)
                ->whereIn(DB::raw('e.grupo_id'), $grupo)
                ->selectRaw("tc.titulo,
                    SUM(CASE WHEN e.sexo = 'M' THEN 1 ELSE 0 END) AS Masculino,
                    SUM(CASE when e.sexo = 'F' THEN 1 ELSE 0 END) AS Femenino,
                    COUNT(e.sexo) AS total
                ")
                ->groupBy(
                    DB::raw('tc.titulo'),
                )
                ->get();
            
            return $consulta2;
        } else {
            return redirect('/home');
        }
    }

    public function import_xlsx (Request $request) {
        \File::deleteDirectory('./documentosPSI/xlxs');

        $url_multimedia = $request->archivos != 0 ? '' : null;

            for ($i = 0; $i < $request->archivos; $i++) {
                if (is_numeric($i)) {
                    if ($request->file("file$i")) {
                        $path = Storage::disk('public')->put('documentosPSI/xlxs', $request->file("file$i"));
                        $url_multimedia .= 'XLSX./' . $path;
                    }
                }
            }
            
        return $url_multimedia;
    }

    /**
     * Display a listing of the comportamiento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $user = Auth()->user();
        if ($user->havePermission('show.comportamientos')) {
            $this->comportamientoRepository->pushCriteria(new RequestCriteria($request));
            $comportamientos = $this->comportamientoRepository->all();

            return view('comportamientos.index', compact('comportamientos'));
        } else {
            return redirect('/home');
        }

        // ->with('comportamientos', $comportamientos);
    }

    public function getComportamientos()
    {
        $user = Auth()->user();
        $rol = $user->tieneRol();
        $queryUsers = DB::table('role_user')
            ->select('role_user.*')
            ->where('role_user.user_id', '=', Auth()->user()->id)
            ->limit(1)
            ->get();

        $datos = [];

        if (count($queryUsers) != 0) {
            if ($queryUsers[0]->role_id == 1) {

                $comportamientos = DB::table(DB::raw('comportamientos c'))->where(DB::raw('c.deleted_at'), '=', NULL)
                    ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                    ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
                    ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                    ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
                    ->leftjoin(DB::raw('tipo_comportamientos tc'), 'c.tipo_comportamiento_id', '=', 'tc.id')
                    ->leftjoin(DB::raw('actividades ac'), 'ac.comportamiento_id', '=', 'c.id')
                    ->where(DB::raw('c.deleted_at', '!=', 'date()'))
                    ->select(
                        'c.id',
                        DB::raw('tc.titulo as titulo_tc'),
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
                        'e.created_at',
                        DB::raw('ac.id as id_actividad'),
                        DB::raw('ac.deleted_at as estado_actividad')
                    )->get();
            } else if ($queryUsers[0]->role_id == 2) {
                $comportamientos = DB::table(DB::raw('comportamientos c'))->where(DB::raw('c.deleted_at'), '=', NULL)
                    ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                    ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
                    ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                    ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
                    ->leftjoin(DB::raw('actividades ac'), 'ac.comportamiento_id', '=', 'c.id')
                    ->leftjoin(DB::raw('tipo_comportamientos tc'), 'c.tipo_comportamiento_id', '=', 'tc.id')
                    ->where(DB::raw('e.correo'), '=', Auth()->user()->email)
                    ->select(
                        'c.id',
                        'c.titulo',
                        'c.descripcion',
                        'c.fecha',
                        // 'c.emisor',
                        // 'e.nombres',
                        // 'e.apellidos',
                        // DB::raw('a.nombres as nombre_acudiente'),
                        // DB::raw('a.apellidos as apellido_acudiente'),
                        'g.grado',
                        'g.curso',
                        // 'c.multimedia',
                        // 'c.emisor',
                        'e.created_at',
                        DB::raw('ac.id as id_actividad'),
                        DB::raw('ac.deleted_at as estado_actividad')
                    )->get();
            } else if ($queryUsers[0]->role_id == 3) {
                $comportamientos = DB::table(DB::raw('comportamientos c'))->where(DB::raw('c.deleted_at'), '=', NULL)
                    ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                    ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
                    ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                    ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
                    ->leftjoin(DB::raw('actividades ac'), 'ac.comportamiento_id', '=', 'c.id')
                    ->leftjoin(DB::raw('tipo_comportamientos tc'), 'c.tipo_comportamiento_id', '=', 'tc.id')
                    ->where(DB::raw('c.deleted_at', '!=', 'date()'))
                    // ->where(DB::raw('c.emisor'), '=', auth()->user())
                    ->select(
                        'c.id',
                        'c.titulo',
                        'c.descripcion',
                        'c.fecha',
                        DB::raw('c.emisor as emis0r'),
                        'e.nombres',
                        'e.apellidos',
                        DB::raw('a.nombres as nombre_acudiente'),
                        DB::raw('a.apellidos as apellido_acudiente'),
                        'g.grado',
                        'g.curso',
                        'c.multimedia',
                        'e.created_at',
                        DB::raw('ac.id as id_actividad'),
                        DB::raw('ac.deleted_at as estado_actividad')
                    )->get();
            } else if ($queryUsers[0]->role_id == 4) {
                $comportamientos = DB::table(DB::raw('comportamientos c'))
                    ->where(DB::raw('c.deleted_at'), '=', NULL)
                    ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                    ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
                    ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                    ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
                    ->leftjoin(DB::raw('actividades ac'), 'ac.comportamiento_id', '=', 'c.id')
                    ->leftjoin(DB::raw('tipo_comportamientos tc'), 'c.tipo_comportamiento_id', '=', 'tc.id')
                    ->where(DB::raw('c.deleted_at', '!=', 'date()'))
                    ->where(DB::raw('a.correo'), '=', $user->email)
                    ->select(
                        'c.id',
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
                        // 'c.emisor',
                        'a.correo',
                        'e.created_at',
                        DB::raw('ac.id as id_actividad'),
                        DB::raw('ac.deleted_at as estado_actividad')
                    )->get();
            } else {
                $comportamientos = DB::table(DB::raw('comportamientos c'))->where(DB::raw('c.deleted_at'), '=', NULL)
                    ->join(DB::raw('estudiantes e'), 'c.estudiante_id', '=', 'e.id')
                    ->join(DB::raw('acudientes a'), 'e.acudiente_id', '=', 'a.id')
                    ->join(DB::raw('grupos g'), 'e.grupo_id', '=', 'g.id')
                    ->join(DB::raw('docentes d'), 'g.docente_id', '=', 'd.id')
                    ->leftjoin(DB::raw('actividades ac'), 'ac.comportamiento_id', '=', 'c.id')
                    ->leftjoin(DB::raw('tipo_comportamientos tc'), 'c.tipo_comportamiento_id', '=', 'tc.id')
                    ->where(DB::raw('c.deleted_at', '!=', 'date()'))
                    ->select(
                        'c.id',
                        'c.titulo',
                        'c.descripcion',
                        DB::raw('tc.titulo as titulo_tc'),
                        'c.fecha',
                        'c.emisor',
                        'e.nombres',
                        'e.apellidos',
                        DB::raw('a.nombres as nombre_acudiente'),
                        DB::raw('a.apellidos as apellido_acudiente'),
                        'g.grado',
                        'g.curso',
                        'c.multimedia',
                        'e.created_at',
                        DB::raw('ac.id as id_actividad'),
                        DB::raw('ac.deleted_at as estado_actividad')
                    )->get();
            }
        }

        //Permisos que tiene el usuario
        $permisos = [];

        if ($user->havePermission('edit.comportamientos')) {
            array_push($permisos, "edit.comportamientos");
        }

        if ($user->havePermission('delete.comportamientos')) {
            array_push($permisos, "delete.comportamientos");
        }

        if ($user->havePermission('create.actividades')) {
            array_push($permisos, "create.actividades");
        }
        if ($user->havePermission('tipos.comportamientos')) {
            array_push($permisos, "tipos.comportamientos");
        }

        $datos = [
            'comportamientos' => $comportamientos,
            'rol' => $rol,
            'permisos' => $permisos,
        ];
        return response()->json($datos);
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
                if (count($array) != 0) {
                    foreach ($array as $a) {
                        $data[] = $a->id;
                    }

                    $contador = DB::table(DB::raw('comportamientos c'))
                        ->select(DB::raw('c.id'))
                        ->where(DB::raw('c.deleted_at'), '=', NULL)
                        ->whereNotIn(DB::raw('c.id'), $data)
                        ->get();
                    return response()->json($contador);
                } else {
                    $contador = [];
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

                if (count($array) != 0) {

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
                } else {
                    $contador = [];
                    return response()->json($contador);
                }
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
            } else {
                $array = DB::table(DB::raw('comportamientos co'))
                    ->where(DB::raw('co.deleted_at'), '=', NULL)
                    ->select(DB::raw('co.id'))
                    ->join(DB::raw('actividades a'), 'co.id', '=', 'a.comportamiento_id')
                    ->where(DB::raw('a.deleted_at'), '=', NULL)
                    ->groupBy(DB::raw('co.id'))
                    ->get();
                if (count($array) != 0) {
                    foreach ($array as $a) {
                        $data[] = $a->id;
                    }

                    $contador = DB::table(DB::raw('comportamientos c'))
                        ->select(DB::raw('c.id'))
                        ->where(DB::raw('c.deleted_at'), '=', NULL)
                        ->whereNotIn(DB::raw('c.id'), $data)
                        ->get();
                    return response()->json($contador);
                } else {
                    $contador = [];
                    return response()->json($contador);
                }
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

            for ($i = 0; $i < $request->archivos; $i++) {
                if (is_numeric($i)) {
                    if ($request->file("file$i")) {
                        $path = Storage::disk('public')->put('documentosPSI', $request->file("file$i"));
                        $url_multimedia .= 'PSIAPP./' . $path;
                    }
                }
            }

            comportamiento::where('id', $request->id)->update([
                'estudiante_id' => $request->estudiante_id,
                'tipo_comportamiento_id' => $request['tipo_comportamiento_id'] == 'null' ? null : $request['tipo_comportamiento_id'],
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'fecha' => $request->fecha,
                'multimedia'  => $url_multimedia,
                // 'emisor'  => $request->emisor,
            ]);
            return response()->json(['status' => 'Avances updated successfully.']);
        } else {
            $url_multimedia = $request->archivos != 0 ? '' : null;

            for ($i = 0; $i < $request->archivos; $i++) {
                if (is_numeric($i)) {
                    if ($request->file("file$i")) {
                        $path = Storage::disk('public')->put('documentosPSI', $request->file("file$i"));
                        $url_multimedia .= 'PSIAPP./' . $path;
                    }
                }
            }


            $emisor = auth()->user();

            // Descomentar
            $comportamiento = comportamiento::create([
                'estudiante_id' => $request['estudiante_id'],
                'tipo_comportamiento_id' => $request['tipo_comportamiento_id'] == 'null' ? null : $request['tipo_comportamiento_id'],
                'titulo' => $request['titulo'],
                'descripcion' => $request['descripcion'],
                'fecha' => $request['fecha'],
                'multimedia'   => $url_multimedia,
                'emisor'   => $emisor,
            ]);


            // //Notificacion via sms
            // $nexmo = app('Nexmo\Client');
            // $nexmo->message()->send([
            //     'to'   => '573177765722',
            //     'from' => '573177765722',
            //     'text' => 'Hola'. $est->nombres . ', Tienes una nueva actividad: ' . $request->titulo .' fecha:'. $request->fecha
            // ]);



            //Descomentar
            $rol_users = Role::with('users')->where('name', 'Psicoorientador')
                ->each(function (Role $role_user) use ($comportamiento) {
                    foreach ($role_user->users as $u) {
                        $u->notify(new NuevoComportamiento($comportamiento));
                    }
                });

            $psi = DB::table(DB::raw('psicologos psi'))->where(DB::raw('psi.deleted_at'), '=', null)
                ->select(DB::raw('psi.nombres'), DB::raw('psi.telefono'))
                ->get();

            // foreach($psi as $item){
            //     // Notificacion via sms
            //     $nexmo = app('Nexmo\Client');
            //     $nexmo->message()->send([
            //         'to'   => '57'.$item->telefono,
            //         'from' => '57'.$item->telefono,
            //         'text' => 'Hola '. $item->nombres . ', Hay un nuevo comportamiento registrado: ' . $comportamiento->titulo .' Descripcion:'. $comportamiento->descripcion
            //     ]);
            // }


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