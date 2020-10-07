<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createmodelo_seguimientoRequest;
use App\Http\Requests\Updatemodelo_seguimientoRequest;
use App\Repositories\modelo_seguimientoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class modelo_seguimientoController extends AppBaseController
{
    /** @var  modelo_seguimientoRepository */
    private $modeloSeguimientoRepository;

    public function __construct(modelo_seguimientoRepository $modeloSeguimientoRepo)
    {
        $this->modeloSeguimientoRepository = $modeloSeguimientoRepo;
    }

    /**
     * Display a listing of the modelo_seguimiento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->modeloSeguimientoRepository->pushCriteria(new RequestCriteria($request));
        $modeloSeguimientos = $this->modeloSeguimientoRepository->all();

        return view('modelo_seguimientos.index')
            ->with('modeloSeguimientos', $modeloSeguimientos);
    }

    /**
     * Show the form for creating a new modelo_seguimiento.
     *
     * @return Response
     */
    public function create()
    {
        return view('modelo_seguimientos.create');
    }

    /**
     * Store a newly created modelo_seguimiento in storage.
     *
     * @param Createmodelo_seguimientoRequest $request
     *
     * @return Response
     */
    public function store(Createmodelo_seguimientoRequest $request)
    {
        $input = $request->all();

        $modeloSeguimiento = $this->modeloSeguimientoRepository->create($input);

        Flash::success('Modelo Seguimiento saved successfully.');

        return redirect(route('modeloSeguimientos.index'));
    }

    /**
     * Display the specified modelo_seguimiento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $modeloSeguimiento = $this->modeloSeguimientoRepository->findWithoutFail($id);

        if (empty($modeloSeguimiento)) {
            Flash::error('Modelo Seguimiento not found');

            return redirect(route('modeloSeguimientos.index'));
        }

        return view('modelo_seguimientos.show')->with('modeloSeguimiento', $modeloSeguimiento);
    }

    /**
     * Show the form for editing the specified modelo_seguimiento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $modeloSeguimiento = $this->modeloSeguimientoRepository->findWithoutFail($id);

        if (empty($modeloSeguimiento)) {
            Flash::error('Modelo Seguimiento not found');

            return redirect(route('modeloSeguimientos.index'));
        }

        return view('modelo_seguimientos.edit')->with('modeloSeguimiento', $modeloSeguimiento);
    }

    /**
     * Update the specified modelo_seguimiento in storage.
     *
     * @param  int              $id
     * @param Updatemodelo_seguimientoRequest $request
     *
     * @return Response
     */
    public function update($id, Updatemodelo_seguimientoRequest $request)
    {
        $modeloSeguimiento = $this->modeloSeguimientoRepository->findWithoutFail($id);

        if (empty($modeloSeguimiento)) {
            Flash::error('Modelo Seguimiento not found');

            return redirect(route('modeloSeguimientos.index'));
        }

        $modeloSeguimiento = $this->modeloSeguimientoRepository->update($request->all(), $id);

        Flash::success('Modelo Seguimiento updated successfully.');

        return redirect(route('modeloSeguimientos.index'));
    }

    /**
     * Remove the specified modelo_seguimiento from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $modeloSeguimiento = $this->modeloSeguimientoRepository->findWithoutFail($id);

        if (empty($modeloSeguimiento)) {
            Flash::error('Modelo Seguimiento not found');

            return redirect(route('modeloSeguimientos.index'));
        }

        $this->modeloSeguimientoRepository->delete($id);

        Flash::success('Modelo Seguimiento deleted successfully.');

        return redirect(route('modeloSeguimientos.index'));
    }
}
