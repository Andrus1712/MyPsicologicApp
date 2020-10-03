<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateavancesRequest;
use App\Http\Requests\UpdateavancesRequest;
use App\Repositories\avancesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class avancesController extends AppBaseController
{
    /** @var  avancesRepository */
    private $avancesRepository;

    public function __construct(avancesRepository $avancesRepo)
    {
        $this->avancesRepository = $avancesRepo;
    }

    /**
     * Display a listing of the avances.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->avancesRepository->pushCriteria(new RequestCriteria($request));
        $avances = $this->avancesRepository->all();

        return view('avances.index')
            ->with('avances', $avances);
    }

    /**
     * Show the form for creating a new avances.
     *
     * @return Response
     */
    public function create()
    {
        return view('avances.create');
    }

    /**
     * Store a newly created avances in storage.
     *
     * @param CreateavancesRequest $request
     *
     * @return Response
     */
    public function store(CreateavancesRequest $request)
    {
        $input = $request->all();

        $avances = $this->avancesRepository->create($input);

        Flash::success('Avances saved successfully.');

        return redirect(route('avances.index'));
    }

    /**
     * Display the specified avances.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $avances = $this->avancesRepository->findWithoutFail($id);

        if (empty($avances)) {
            Flash::error('Avances not found');

            return redirect(route('avances.index'));
        }

        return view('avances.show')->with('avances', $avances);
    }

    /**
     * Show the form for editing the specified avances.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $avances = $this->avancesRepository->findWithoutFail($id);

        if (empty($avances)) {
            Flash::error('Avances not found');

            return redirect(route('avances.index'));
        }

        return view('avances.edit')->with('avances', $avances);
    }

    /**
     * Update the specified avances in storage.
     *
     * @param  int              $id
     * @param UpdateavancesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateavancesRequest $request)
    {
        $avances = $this->avancesRepository->findWithoutFail($id);

        if (empty($avances)) {
            Flash::error('Avances not found');

            return redirect(route('avances.index'));
        }

        $avances = $this->avancesRepository->update($request->all(), $id);

        Flash::success('Avances updated successfully.');

        return redirect(route('avances.index'));
    }

    /**
     * Remove the specified avances from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $avances = $this->avancesRepository->findWithoutFail($id);

        if (empty($avances)) {
            Flash::error('Avances not found');

            return redirect(route('avances.index'));
        }

        $this->avancesRepository->delete($id);

        Flash::success('Avances deleted successfully.');

        return redirect(route('avances.index'));
    }
}
