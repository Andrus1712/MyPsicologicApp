<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatedocentesRequest;
use App\Http\Requests\UpdatedocentesRequest;
use App\Repositories\docentesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class docentesController extends AppBaseController
{
    /** @var  docentesRepository */
    private $docentesRepository;

    public function __construct(docentesRepository $docentesRepo)
    {
        $this->docentesRepository = $docentesRepo;
    }

    /**
     * Display a listing of the docentes.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->docentesRepository->pushCriteria(new RequestCriteria($request));
        $docentes = $this->docentesRepository->all();

        return view('docentes.index')
            ->with('docentes', $docentes);
    }

    /**
     * Show the form for creating a new docentes.
     *
     * @return Response
     */
    public function create()
    {
        return view('docentes.create');
    }

    /**
     * Store a newly created docentes in storage.
     *
     * @param CreatedocentesRequest $request
     *
     * @return Response
     */
    public function store(CreatedocentesRequest $request)
    {
        $input = $request->all();

        $docentes = $this->docentesRepository->create($input);

        Flash::success('Docentes saved successfully.');

        return redirect(route('docentes.index'));
    }

    /**
     * Display the specified docentes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $docentes = $this->docentesRepository->findWithoutFail($id);

        if (empty($docentes)) {
            Flash::error('Docentes not found');

            return redirect(route('docentes.index'));
        }

        return view('docentes.show')->with('docentes', $docentes);
    }

    /**
     * Show the form for editing the specified docentes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $docentes = $this->docentesRepository->findWithoutFail($id);

        if (empty($docentes)) {
            Flash::error('Docentes not found');

            return redirect(route('docentes.index'));
        }

        return view('docentes.edit')->with('docentes', $docentes);
    }

    /**
     * Update the specified docentes in storage.
     *
     * @param  int              $id
     * @param UpdatedocentesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedocentesRequest $request)
    {
        $docentes = $this->docentesRepository->findWithoutFail($id);

        if (empty($docentes)) {
            Flash::error('Docentes not found');

            return redirect(route('docentes.index'));
        }

        $docentes = $this->docentesRepository->update($request->all(), $id);

        Flash::success('Docentes updated successfully.');

        return redirect(route('docentes.index'));
    }

    /**
     * Remove the specified docentes from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $docentes = $this->docentesRepository->findWithoutFail($id);

        if (empty($docentes)) {
            Flash::error('Docentes not found');

            return redirect(route('docentes.index'));
        }

        $this->docentesRepository->delete($id);

        Flash::success('Docentes deleted successfully.');

        return redirect(route('docentes.index'));
    }
}
