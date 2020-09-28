<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateacudienteRequest;
use App\Http\Requests\UpdateacudienteRequest;
use App\Repositories\acudienteRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class acudienteController extends AppBaseController
{
    /** @var  acudienteRepository */
    private $acudienteRepository;

    public function __construct(acudienteRepository $acudienteRepo)
    {
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
        $this->acudienteRepository->pushCriteria(new RequestCriteria($request));
        $acudientes = $this->acudienteRepository->all();

        return view('acudientes.index')
            ->with('acudientes', $acudientes);
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
