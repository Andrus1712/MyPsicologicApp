<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatepsicologoRequest;
use App\Http\Requests\UpdatepsicologoRequest;
use App\Repositories\psicologoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class psicologoController extends AppBaseController
{
    /** @var  psicologoRepository */
    private $psicologoRepository;

    public function __construct(psicologoRepository $psicologoRepo)
    {
        $this->psicologoRepository = $psicologoRepo;
    }

    /**
     * Display a listing of the psicologo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->psicologoRepository->pushCriteria(new RequestCriteria($request));
        $psicologos = $this->psicologoRepository->all();

        return view('psicologos.index')
            ->with('psicologos', $psicologos);
    }

    /**
     * Show the form for creating a new psicologo.
     *
     * @return Response
     */
    public function create()
    {
        return view('psicologos.create');
    }

    /**
     * Store a newly created psicologo in storage.
     *
     * @param CreatepsicologoRequest $request
     *
     * @return Response
     */
    public function store(CreatepsicologoRequest $request)
    {
        $input = $request->all();

        $psicologo = $this->psicologoRepository->create($input);

        Flash::success('Psicologo saved successfully.');

        return redirect(route('psicologos.index'));
    }

    /**
     * Display the specified psicologo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $psicologo = $this->psicologoRepository->findWithoutFail($id);

        if (empty($psicologo)) {
            Flash::error('Psicologo not found');

            return redirect(route('psicologos.index'));
        }

        return view('psicologos.show')->with('psicologo', $psicologo);
    }

    /**
     * Show the form for editing the specified psicologo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $psicologo = $this->psicologoRepository->findWithoutFail($id);

        if (empty($psicologo)) {
            Flash::error('Psicologo not found');

            return redirect(route('psicologos.index'));
        }

        return view('psicologos.edit')->with('psicologo', $psicologo);
    }

    /**
     * Update the specified psicologo in storage.
     *
     * @param  int              $id
     * @param UpdatepsicologoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepsicologoRequest $request)
    {
        $psicologo = $this->psicologoRepository->findWithoutFail($id);

        if (empty($psicologo)) {
            Flash::error('Psicologo not found');

            return redirect(route('psicologos.index'));
        }

        $psicologo = $this->psicologoRepository->update($request->all(), $id);

        Flash::success('Psicologo updated successfully.');

        return redirect(route('psicologos.index'));
    }

    /**
     * Remove the specified psicologo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $psicologo = $this->psicologoRepository->findWithoutFail($id);

        if (empty($psicologo)) {
            Flash::error('Psicologo not found');

            return redirect(route('psicologos.index'));
        }

        $this->psicologoRepository->delete($id);

        Flash::success('Psicologo deleted successfully.');

        return redirect(route('psicologos.index'));
    }
}
