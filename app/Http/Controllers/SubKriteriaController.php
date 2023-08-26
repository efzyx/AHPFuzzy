<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubKriteriaRequest;
use App\Http\Requests\UpdateSubKriteriaRequest;
use App\Repositories\SubKriteriaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\SubKriteriaSubKriteria;
use App\Models\PemasokSub;
use App\ExpertKriteriaComparison;
use App\ExpertSubComparison;
use App\FuzzyKriteria;
use App\FuzzySub;
use App\PemasokSubFuzzyResult;
use App\PemasokSubResult;

class SubKriteriaController extends AppBaseController
{
    /** @var  SubKriteriaRepository */
    private $subKriteriaRepository;

    public function __construct(SubKriteriaRepository $subKriteriaRepo)
    {
        $this->subKriteriaRepository = $subKriteriaRepo;
    }

    /**
     * Display a listing of the SubKriteria.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->subKriteriaRepository->pushCriteria(new RequestCriteria($request));
        $subKriterias = $this->subKriteriaRepository->all();

        return view('sub_kriterias.index')
            ->with('subKriterias', $subKriterias);
    }

    /**
     * Show the form for creating a new SubKriteria.
     *
     * @return Response
     */
    public function create($id)
    {

        $kriteria = Kriteria::find($id);
        $subKriterias = SubKriteria::all()->where('kriteria_id', '=', $id);
        return view('sub_kriterias.create')->with('kriteria', $kriteria)->with('subKriterias', $subKriterias);
    }

    /**
     * Store a newly created SubKriteria in storage.
     *
     * @param CreateSubKriteriaRequest $request
     *
     * @return Response
     */
    public function store(CreateSubKriteriaRequest $request)
    {
        $input = $request->all();
        $kriteria_id = $input['kriteria_id'];

        $subKriteria = $this->subKriteriaRepository->create($input);

        Flash::success('Sub Kriteria saved successfully.');
        return redirect(route('CreateSubKriteria', ['id' => $kriteria_id]));
    }

    /**
     * Display the specified SubKriteria.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $subKriteria = $this->subKriteriaRepository->findWithoutFail($id);
        $kriteria = Kriteria::find($subKriteria->kriteria_id);
        if (empty($subKriteria)) {
            Flash::error('Sub Kriteria not found');

            return redirect(route('subKriterias.index'));
        }

        return view('sub_kriterias.show')->with('subKriteria', $subKriteria)->with('kriteria', $kriteria);
    }

    /**
     * Show the form for editing the specified SubKriteria.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $subKriteria = $this->subKriteriaRepository->findWithoutFail($id);
        $kriteria = Kriteria::find($subKriteria->kriteria_id);

        if (empty($subKriteria)) {
            Flash::error('Sub Kriteria not found');

            return redirect(route('subKriterias.index'));
        }

        return view('sub_kriterias.edit')->with('subKriteria', $subKriteria)->with('kriteria', $kriteria);
    }

    /**
     * Update the specified SubKriteria in storage.
     *
     * @param  int              $id
     * @param UpdateSubKriteriaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSubKriteriaRequest $request)
    {
        $subKriteria = $this->subKriteriaRepository->findWithoutFail($id);
        $kriteria_id = $subKriteria->kriteria_id;

        if (empty($subKriteria)) {
            Flash::error('Sub Kriteria not found');

            return redirect(route('subKriterias.index'));
        }

        $subKriteria = $this->subKriteriaRepository->update($request->all(), $id);

        Flash::success('Sub Kriteria updated successfully.');

        return redirect(route('CreateSubKriteria', ['id' => $kriteria_id]));
    }

    /**
     * Remove the specified SubKriteria from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $subKriteria = $this->subKriteriaRepository->findWithoutFail($id);

        if (empty($subKriteria)) {
            Flash::error('Sub Kriteria not found');

            return \App::make('redirect')->back();
        }
        PemasokSub::where('sub_kriteria_id', '=', $id)->delete();
        SubKriteriaSubKriteria::where('sub_kriteria1_id', '=', $id)->delete();
        SubKriteriaSubKriteria::where('sub_kriteria2_id', '=', $id)->delete();
        ExpertKriteriaComparison::truncate();
        ExpertSubComparison::truncate();
        FuzzyKriteria::truncate();
        FuzzySub::truncate();
        PemasokSubFuzzyResult::truncate();
        PemasokSubResult::truncate();

        $this->subKriteriaRepository->delete($id);

        Flash::success('Sub Kriteria deleted successfully.');

        return redirect()->back();
    }
}
