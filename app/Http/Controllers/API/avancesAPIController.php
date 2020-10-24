<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateavancesAPIRequest;
use App\Http\Requests\API\UpdateavancesAPIRequest;
use App\Models\avances;
use App\Repositories\avancesRepository;
use Illuminate\Http\Request;
// use Request; 

use App\Http\Controllers\AppBaseController;
use App\Models\psicologo;
use App\Role;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class avancesController
 * @package App\Http\Controllers\API
 */

class avancesAPIController extends AppBaseController
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
     * GET|HEAD /avances
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $avances = DB::table(DB::raw('avances av'))->where(DB::raw('av.deleted_at', '=', 'NULL'))
            ->join(DB::raw('actividades ac'), 'av.actividad_id', '=', 'ac.id')
            ->join(DB::raw('comportamientos cp'), 'ac.comportamiento_id', '=', 'cp.id')
            ->join(DB::raw('tipo_comportamientos tc'), 'ac.tipo_comportamiento_id', '=', 'tc.id')
            ->join(DB::raw('estudiantes e'), 'cp.estudiante_id', '=', 'e.id')
            ->select(
                'av.id',
                DB::raw('av.descripcion as avance'),
                'av.fecha_avance',
                DB::raw('ac.id as id_actividad'),
                DB::raw('ac.estado as estado_actividad'),
                DB::raw('ac.titulo as titulo_actividad'),
                DB::raw('ac.descripcion as descripcion_actividad'),
                DB::raw('ac.fecha as fecha_actividad'),
                DB::raw('cp.titulo as comportamiento_registrado'),
                DB::raw('tc.titulo as titulo_tipo_comportamiento'),
                DB::raw('e.nombres as nombre_estudiante'),
                DB::raw('e.apellidos as apellido_estudiante'),
                'av.evidencias',
                'av.created_at'
            )
            ->get();

        return response()->json($avances);
    }

    /**
     * Store a newly created avances in storage.
     * POST /avances
     *
     * @param CreateavancesAPIRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        if (isset($request->id) && $request->method == 'update') {
            $url_evidencia = $request->archivos != 0 ? '' : $request->tempMultimedia;

            for ($i = 0; $i < $request->archivos; $i++) {
                if (is_numeric($i)) {
                    if ($request->file("file$i")) {
                        $path = Storage::disk('public')->put('documentosPSI', $request->file("file$i"));
                        $url_evidencia .= 'PSIAPP./' . $path;
                    }
                }
            }

            avances::where('id', $request->id)->update([
                'actividad_id' => $request->actividad_id,
                'descripcion' => $request->descripcion,
                'fecha_avance' => $request->fecha_avance,
                'evidencias'  => $url_evidencia,
            ]);
            return response()->json(['status' => 'Avances updated successfully.']);
        } else {

            $url_evidencia = $request->archivos != 0 ? '' : null;

            for ($i = 0; $i < $request->archivos; $i++) {

                if (is_numeric($i)) {

                    if ($request->file("file$i")) {
                        $path = Storage::disk('public')->put('documentosPSI', $request->file("file$i"));
                        $url_evidencia .= 'PSIAPP./' . $path;
                    }
                }
            }

            // $input = $request->all();

            $avances = avances::create([
                'actividad_id' => $request->actividad_id,
                'descripcion'  => $request->descripcion,
                'fecha_avance' => $request->fecha_avance,
                'evidencias'   => $url_evidencia,
            ]);

            $rol_users = Role::with('users')->where('name', 'Psicoorientador')
                ->each(function (Role $role_user) use ($avances) {
                    foreach ($role_user->users as $u) {

                        // $u->notify(new NuevoAvance($avances));
                        $psi = psicologo::where('correo', $u->email)->first();
                        //Notificacion via sms
                        // $nexmo = app('Nexmo\Client');
                        // $nexmo->message()->send([
                        //     'to'   => '57'.$psi->telefono,
                        //     'from' => '573177765722',
                        //     'text' => 'Hola '. $psi->nombres . ', Hay un nuevo comportamiento registrado: ' . $comportamiento->titulo .' Descripcion:'. $comportamiento->descripcion
                        // ]);
                    }
                });

            return response()->json(['status' => 'Avances saved successfully.']);
        }
    }

    /**
     * Display the specified avances.
     * GET|HEAD /avances/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var avances $avances */
        $avances = $this->avancesRepository->findWithoutFail($id);

        if (empty($avances)) {
            return $this->sendError('Avances not found');
        }

        return $this->sendResponse($avances->toArray(), 'Avances retrieved successfully');
    }

    /**
     * Update the specified avances in storage.
     * PUT/PATCH /avances/{id}
     *
     * @param  int $id
     * @param UpdateavancesAPIRequest $request
     *
     * @return Response
     */
    public function update(avances $avances, UpdateavancesAPIRequest $request)
    {
        if ($request->ajax()) {
            avances::find($request->id)->update(['descripcion' => 'dasdas']);
            return response()->json(['mensaje' => 'estado actualizado con exito']);
        }
        // dd($request->all());


        // if($request->file('evidencias')){
        //     $path = Storage::disk('public')->put('documentosPSI',$request->file('evidencias'));

        //     $url_evidencia = './'.$path;
        // }else{
        //     $url_evidencia = $request->evidencias;
        // }


        // $avances->where('id', $request->id)->update([
        //     'actividad_id'=> $request->actividad_id,
        //     'descripcion' => $request->descripcion,
        //     'fecha_avance'=> $request->fecha_avance,
        //     'evidencias'  => $url_evidencia,
        // ]);
        // return response()->json($avances->all());    
    }

    /**
     * Remove the specified avances from storage.
     * DELETE /avances/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var avances $avances */
        $avances = avances::find($id);

        $avances->delete();

        return response()->json(['status' => 'Actividades deleted successfully']);
    }
}
