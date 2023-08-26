<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePemasokRequest;
use App\Http\Requests\UpdatePemasokRequest;
use App\Repositories\PemasokRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\PemasokSub;

class PemasokController extends AppBaseController
{
    /** @var  PemasokRepository */
    private $pemasokRepository;

    public function __construct(PemasokRepository $pemasokRepo)
    {
        $this->pemasokRepository = $pemasokRepo;
    }

    /**
     * Display a listing of the Pemasok.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->pemasokRepository->pushCriteria(new RequestCriteria($request));
        $pemasoks = $this->pemasokRepository->all();

        return view('pemasoks.index')
            ->with('pemasoks', $pemasoks);
    }

    /**
     * Show the form for creating a new Pemasok.
     *
     * @return Response
     */
    public function create()
    {
        return view('pemasoks.create');
    }

    /**
     * Store a newly created Pemasok in storage.
     *
     * @param CreatePemasokRequest $request
     *
     * @return Response
     */
    public function store(CreatePemasokRequest $request)
    {
        $input = $request->all();

        $pemasok = $this->pemasokRepository->create($input);

        Flash::success('Pemasok saved successfully.');

        return redirect(route('pemasoks.index'));
    }

    /**
     * Display the specified Pemasok.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pemasok = $this->pemasokRepository->findWithoutFail($id);

        if (empty($pemasok)) {
            Flash::error('Pemasok not found');

            return redirect(route('pemasoks.index'));
        }

        return view('pemasoks.show')->with('pemasok', $pemasok);
    }

    /**
     * Show the form for editing the specified Pemasok.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pemasok = $this->pemasokRepository->findWithoutFail($id);

        if (empty($pemasok)) {
            Flash::error('Pemasok not found');

            return redirect(route('pemasoks.index'));
        }

        return view('pemasoks.edit')->with('pemasok', $pemasok);
    }

    /**
     * Update the specified Pemasok in storage.
     *
     * @param  int              $id
     * @param UpdatePemasokRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePemasokRequest $request)
    {
        $pemasok = $this->pemasokRepository->findWithoutFail($id);

        if (empty($pemasok)) {
            Flash::error('Pemasok not found');

            return redirect(route('pemasoks.index'));
        }

        $pemasok = $this->pemasokRepository->update($request->all(), $id);

        Flash::success('Pemasok updated successfully.');

        return redirect(route('pemasoks.index'));
    }

    /**
     * Remove the specified Pemasok from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pemasok = $this->pemasokRepository->findWithoutFail($id);
        if (empty($pemasok)) {
            Flash::error('Pemasok not found');

            return redirect(route('pemasoks.index'));
        }
        PemasokSub::where('pemasok1_id','=', $id)->delete();
        PemasokSub::where('pemasok2_id','=',$id)->delete();
        $this->pemasokRepository->delete($id);

        Flash::success('Pemasok deleted successfully.');

        return redirect(route('pemasoks.index'));
    }
}
