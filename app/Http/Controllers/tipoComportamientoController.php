<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatetipoComportamientoRequest;
use App\Http\Requests\UpdatetipoComportamientoRequest;
use App\Repositories\tipoComportamientoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class tipoComportamientoController extends AppBaseController
{
    /** @var  tipoComportamientoRepository */
    private $tipoComportamientoRepository;

    public function __construct(tipoComportamientoRepository $tipoComportamientoRepo)
    {
        $this->tipoComportamientoRepository = $tipoComportamientoRepo;
    }

    /**
     * Display a listing of the tipoComportamiento.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->tipoComportamientoRepository->pushCriteria(new RequestCriteria($request));
        $tipoComportamientos = $this->tipoComportamientoRepository->all();

        return view('tipo_comportamientos.index')
            ->with('tipoComportamientos', $tipoComportamientos);
    }

    /**
     * Show the form for creating a new tipoComportamiento.
     *
     * @return Response
     */
    public function create()
    {
        return view('tipo_comportamientos.create');
    }

    /**
     * Store a newly created tipoComportamiento in storage.
     *
     * @param CreatetipoComportamientoRequest $request
     *
     * @return Response
     */
    public function store(CreatetipoComportamientoRequest $request)
    {
        $input = $request->all();

        $tipoComportamiento = $this->tipoComportamientoRepository->create($input);

        Flash::success('Tipo Comportamiento saved successfully.');

        return redirect(route('tipoComportamientos.index'));
    }

    /**
     * Display the specified tipoComportamiento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $tipoComportamiento = $this->tipoComportamientoRepository->findWithoutFail($id);

        if (empty($tipoComportamiento)) {
            Flash::error('Tipo Comportamiento not found');

            return redirect(route('tipoComportamientos.index'));
        }

        return view('tipo_comportamientos.show')->with('tipoComportamiento', $tipoComportamiento);
    }

    /**
     * Show the form for editing the specified tipoComportamiento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tipoComportamiento = $this->tipoComportamientoRepository->findWithoutFail($id);

        if (empty($tipoComportamiento)) {
            Flash::error('Tipo Comportamiento not found');

            return redirect(route('tipoComportamientos.index'));
        }

        return view('tipo_comportamientos.edit')->with('tipoComportamiento', $tipoComportamiento);
    }

    /**
     * Update the specified tipoComportamiento in storage.
     *
     * @param  int              $id
     * @param UpdatetipoComportamientoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatetipoComportamientoRequest $request)
    {
        $tipoComportamiento = $this->tipoComportamientoRepository->findWithoutFail($id);

        if (empty($tipoComportamiento)) {
            Flash::error('Tipo Comportamiento not found');

            return redirect(route('tipoComportamientos.index'));
        }

        $tipoComportamiento = $this->tipoComportamientoRepository->update($request->all(), $id);

        Flash::success('Tipo Comportamiento updated successfully.');

        return redirect(route('tipoComportamientos.index'));
    }

    /**
     * Remove the specified tipoComportamiento from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $tipoComportamiento = $this->tipoComportamientoRepository->findWithoutFail($id);

        if (empty($tipoComportamiento)) {
            Flash::error('Tipo Comportamiento not found');

            return redirect(route('tipoComportamientos.index'));
        }

        $this->tipoComportamientoRepository->delete($id);

        Flash::success('Tipo Comportamiento deleted successfully.');

        return redirect(route('tipoComportamientos.index'));
    }
}
