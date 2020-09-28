<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatedocenteRequest;
use App\Http\Requests\UpdatedocenteRequest;
use App\Repositories\docenteRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class docenteController extends AppBaseController
{
    /** @var  docenteRepository */
    private $docenteRepository;

    public function __construct(docenteRepository $docenteRepo)
    {
        $this->docenteRepository = $docenteRepo;
    }

    /**
     * Display a listing of the docente.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->docenteRepository->pushCriteria(new RequestCriteria($request));
        $docentes = $this->docenteRepository->all();

        return view('docentes.index')
            ->with('docentes', $docentes);
    }

    /**
     * Show the form for creating a new docente.
     *
     * @return Response
     */
    public function create()
    {
        return view('docentes.create');
    }

    /**
     * Store a newly created docente in storage.
     *
     * @param CreatedocenteRequest $request
     *
     * @return Response
     */
    public function store(CreatedocenteRequest $request)
    {
        $input = $request->all();

        $docente = $this->docenteRepository->create($input);

        Flash::success('Docente saved successfully.');

        return redirect(route('docentes.index'));
    }

    /**
     * Display the specified docente.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $docente = $this->docenteRepository->findWithoutFail($id);

        if (empty($docente)) {
            Flash::error('Docente not found');

            return redirect(route('docentes.index'));
        }

        return view('docentes.show')->with('docente', $docente);
    }

    /**
     * Show the form for editing the specified docente.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $docente = $this->docenteRepository->findWithoutFail($id);

        if (empty($docente)) {
            Flash::error('Docente not found');

            return redirect(route('docentes.index'));
        }

        return view('docentes.edit')->with('docente', $docente);
    }

    /**
     * Update the specified docente in storage.
     *
     * @param  int              $id
     * @param UpdatedocenteRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedocenteRequest $request)
    {
        $docente = $this->docenteRepository->findWithoutFail($id);

        if (empty($docente)) {
            Flash::error('Docente not found');

            return redirect(route('docentes.index'));
        }

        $docente = $this->docenteRepository->update($request->all(), $id);

        Flash::success('Docente updated successfully.');

        return redirect(route('docentes.index'));
    }

    /**
     * Remove the specified docente from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $docente = $this->docenteRepository->findWithoutFail($id);

        if (empty($docente)) {
            Flash::error('Docente not found');

            return redirect(route('docentes.index'));
        }

        $this->docenteRepository->delete($id);

        Flash::success('Docente deleted successfully.');

        return redirect(route('docentes.index'));
    }
}
