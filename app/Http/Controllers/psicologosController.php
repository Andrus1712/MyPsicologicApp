<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatepsicologosRequest;
use App\Http\Requests\UpdatepsicologosRequest;
use App\Repositories\psicologosRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class psicologosController extends AppBaseController
{
    /** @var  psicologosRepository */
    private $psicologosRepository;

    public function __construct(psicologosRepository $psicologosRepo)
    {
        $this->psicologosRepository = $psicologosRepo;
    }

    /**
     * Display a listing of the psicologos.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->psicologosRepository->pushCriteria(new RequestCriteria($request));
        $psicologos = $this->psicologosRepository->all();

        return view('psicologos.index')
            ->with('psicologos', $psicologos);
    }

    /**
     * Show the form for creating a new psicologos.
     *
     * @return Response
     */
    public function create()
    {
        return view('psicologos.create');
    }

    /**
     * Store a newly created psicologos in storage.
     *
     * @param CreatepsicologosRequest $request
     *
     * @return Response
     */
    public function store(CreatepsicologosRequest $request)
    {
        $input = $request->all();

        $psicologos = $this->psicologosRepository->create($input);

        Flash::success('Psicologos saved successfully.');

        return redirect(route('psicologos.index'));
    }

    /**
     * Display the specified psicologos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $psicologos = $this->psicologosRepository->findWithoutFail($id);

        if (empty($psicologos)) {
            Flash::error('Psicologos not found');

            return redirect(route('psicologos.index'));
        }

        return view('psicologos.show')->with('psicologos', $psicologos);
    }

    /**
     * Show the form for editing the specified psicologos.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $psicologos = $this->psicologosRepository->findWithoutFail($id);

        if (empty($psicologos)) {
            Flash::error('Psicologos not found');

            return redirect(route('psicologos.index'));
        }

        return view('psicologos.edit')->with('psicologos', $psicologos);
    }

    /**
     * Update the specified psicologos in storage.
     *
     * @param  int              $id
     * @param UpdatepsicologosRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepsicologosRequest $request)
    {
        $psicologos = $this->psicologosRepository->findWithoutFail($id);

        if (empty($psicologos)) {
            Flash::error('Psicologos not found');

            return redirect(route('psicologos.index'));
        }

        $psicologos = $this->psicologosRepository->update($request->all(), $id);

        Flash::success('Psicologos updated successfully.');

        return redirect(route('psicologos.index'));
    }

    /**
     * Remove the specified psicologos from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $psicologos = $this->psicologosRepository->findWithoutFail($id);

        if (empty($psicologos)) {
            Flash::error('Psicologos not found');

            return redirect(route('psicologos.index'));
        }

        $this->psicologosRepository->delete($id);

        Flash::success('Psicologos deleted successfully.');

        return redirect(route('psicologos.index'));
    }
}
