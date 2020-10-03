<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateactividadesRequest;
use App\Http\Requests\UpdateactividadesRequest;
use App\Repositories\actividadesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class actividadesController extends AppBaseController
{
    /** @var  actividadesRepository */
    private $actividadesRepository;

    public function __construct(actividadesRepository $actividadesRepo)
    {
        $this->actividadesRepository = $actividadesRepo;
    }

    /**
     * Display a listing of the actividades.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->actividadesRepository->pushCriteria(new RequestCriteria($request));
        $actividades = $this->actividadesRepository->all();

        return view('actividades.index')
            ->with('actividades', $actividades);
    }

    /**
     * Show the form for creating a new actividades.
     *
     * @return Response
     */
    public function create()
    {
        return view('actividades.create');
    }

    /**
     * Store a newly created actividades in storage.
     *
     * @param CreateactividadesRequest $request
     *
     * @return Response
     */
    public function store(CreateactividadesRequest $request)
    {
        $input = $request->all();

        $actividades = $this->actividadesRepository->create($input);

        Flash::success('Actividades saved successfully.');

        return redirect(route('actividades.index'));
    }

    /**
     * Display the specified actividades.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $actividades = $this->actividadesRepository->findWithoutFail($id);

        if (empty($actividades)) {
            Flash::error('Actividades not found');

            return redirect(route('actividades.index'));
        }

        return view('actividades.show')->with('actividades', $actividades);
    }

    /**
     * Show the form for editing the specified actividades.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $actividades = $this->actividadesRepository->findWithoutFail($id);

        if (empty($actividades)) {
            Flash::error('Actividades not found');

            return redirect(route('actividades.index'));
        }

        return view('actividades.edit')->with('actividades', $actividades);
    }

    /**
     * Update the specified actividades in storage.
     *
     * @param  int              $id
     * @param UpdateactividadesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateactividadesRequest $request)
    {
        $actividades = $this->actividadesRepository->findWithoutFail($id);

        if (empty($actividades)) {
            Flash::error('Actividades not found');

            return redirect(route('actividades.index'));
        }

        $actividades = $this->actividadesRepository->update($request->all(), $id);

        Flash::success('Actividades updated successfully.');

        return redirect(route('actividades.index'));
    }

    /**
     * Remove the specified actividades from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $actividades = $this->actividadesRepository->findWithoutFail($id);

        if (empty($actividades)) {
            Flash::error('Actividades not found');

            return redirect(route('actividades.index'));
        }

        $this->actividadesRepository->delete($id);

        Flash::success('Actividades deleted successfully.');

        return redirect(route('actividades.index'));
    }
}
