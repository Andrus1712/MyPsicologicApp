<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreategrupoRequest;
use App\Http\Requests\UpdategrupoRequest;
use App\Repositories\grupoRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class grupoController extends AppBaseController
{
    /** @var  grupoRepository */
    private $grupoRepository;

    public function __construct(grupoRepository $grupoRepo)
    {
        $this->grupoRepository = $grupoRepo;
    }

    /**
     * Display a listing of the grupo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->grupoRepository->pushCriteria(new RequestCriteria($request));
        $grupos = $this->grupoRepository->all();

        return view('grupos.index')
            ->with('grupos', $grupos);
    }

    /**
     * Show the form for creating a new grupo.
     *
     * @return Response
     */
    public function create()
    {
        return view('grupos.create');
    }

    /**
     * Store a newly created grupo in storage.
     *
     * @param CreategrupoRequest $request
     *
     * @return Response
     */
    public function store(CreategrupoRequest $request)
    {
        $input = $request->all();

        $grupo = $this->grupoRepository->create($input);

        Flash::success('Grupo saved successfully.');

        return redirect(route('grupos.index'));
    }

    /**
     * Display the specified grupo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $grupo = $this->grupoRepository->findWithoutFail($id);

        if (empty($grupo)) {
            Flash::error('Grupo not found');

            return redirect(route('grupos.index'));
        }

        return view('grupos.show')->with('grupo', $grupo);
    }

    /**
     * Show the form for editing the specified grupo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $grupo = $this->grupoRepository->findWithoutFail($id);

        if (empty($grupo)) {
            Flash::error('Grupo not found');

            return redirect(route('grupos.index'));
        }

        return view('grupos.edit')->with('grupo', $grupo);
    }

    /**
     * Update the specified grupo in storage.
     *
     * @param  int              $id
     * @param UpdategrupoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdategrupoRequest $request)
    {
        $grupo = $this->grupoRepository->findWithoutFail($id);

        if (empty($grupo)) {
            Flash::error('Grupo not found');

            return redirect(route('grupos.index'));
        }

        $grupo = $this->grupoRepository->update($request->all(), $id);

        Flash::success('Grupo updated successfully.');

        return redirect(route('grupos.index'));
    }

    /**
     * Remove the specified grupo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $grupo = $this->grupoRepository->findWithoutFail($id);

        if (empty($grupo)) {
            Flash::error('Grupo not found');

            return redirect(route('grupos.index'));
        }

        $this->grupoRepository->delete($id);

        Flash::success('Grupo deleted successfully.');

        return redirect(route('grupos.index'));
    }
}
