<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatecomportamientoRequest;
use App\Http\Requests\UpdatecomportamientoRequest;
use App\Repositories\comportamientoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
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

    /**
     * Display the specified comportamiento.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $comportamiento = $this->comportamientoRepository->findWithoutFail($id);

        if (empty($comportamiento)) {
            Flash::error('Comportamiento not found');

            return redirect(route('comportamientos.index'));
        }

        return view('comportamientos.show')->with('comportamiento', $comportamiento);
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
