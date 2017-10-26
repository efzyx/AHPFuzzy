<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateKriteriaRequest;
use App\Http\Requests\UpdateKriteriaRequest;
use App\Repositories\KriteriaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\KriteriaKriteria;
use App\Models\SubKriteriaSubKriteria;
use App\Models\SubKriteria;
use App\Models\PemasokSub;
use App\ExpertKriteriaComparison;
use App\ExpertSubComparison;
use App\FuzzyKriteria;
use App\FuzzySub;
use App\PemasokSubFuzzyResult;
use App\PemasokSubResult;

class KriteriaController extends AppBaseController
{
    /** @var  KriteriaRepository */
    private $kriteriaRepository;

    public function __construct(KriteriaRepository $kriteriaRepo)
    {
        $this->kriteriaRepository = $kriteriaRepo;
    }

    /**
     * Display a listing of the Kriteria.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->kriteriaRepository->pushCriteria(new RequestCriteria($request));
        $kriterias = $this->kriteriaRepository->all();

        return view('kriterias.index')
            ->with('kriterias', $kriterias);
    }

    /**
     * Show the form for creating a new Kriteria.
     *
     * @return Response
     */
    public function create()
    {
        return view('kriterias.create');
    }

    /**
     * Store a newly created Kriteria in storage.
     *
     * @param CreateKriteriaRequest $request
     *
     * @return Response
     */
    public function store(CreateKriteriaRequest $request)
    {
        $input = $request->all();

        $kriteria = $this->kriteriaRepository->create($input);

        Flash::success('Kriteria saved successfully.');

        return redirect(route('kriterias.index'));
    }

    /**
     * Display the specified Kriteria.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $kriteria = $this->kriteriaRepository->findWithoutFail($id);

        if (empty($kriteria)) {
            Flash::error('Kriteria not found');

            return redirect(route('kriterias.index'));
        }

        return view('kriterias.show')->with('kriteria', $kriteria);
    }

    /**
     * Show the form for editing the specified Kriteria.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $kriteria = $this->kriteriaRepository->findWithoutFail($id);

        if (empty($kriteria)) {
            Flash::error('Kriteria not found');

            return redirect(route('kriterias.index'));
        }

        return view('kriterias.edit')->with('kriteria', $kriteria);
    }

    /**
     * Update the specified Kriteria in storage.
     *
     * @param  int              $id
     * @param UpdateKriteriaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateKriteriaRequest $request)
    {
        $kriteria = $this->kriteriaRepository->findWithoutFail($id);

        if (empty($kriteria)) {
            Flash::error('Kriteria not found');

            return redirect(route('kriterias.index'));
        }

        $kriteria = $this->kriteriaRepository->update($request->all(), $id);

        Flash::success('Kriteria updated successfully.');

        return redirect(route('kriterias.index'));
    }

    /**
     * Remove the specified Kriteria from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $kriteria = $this->kriteriaRepository->findWithoutFail($id);

        if (empty($kriteria)) {
            Flash::error('Kriteria not found');

            return redirect(route('kriterias.index'));
        }

        $kriteriaKriteria1 = KriteriaKriteria::where('kriteria1_id', '=', $id);
        $kriteriaKriteria2 = KriteriaKriteria::where('kriteria2_id', '=', $id);
        // dd($kriteriaKriteria);
        $kriteriaKriteria1->delete();
        $kriteriaKriteria2->delete();
        $subKriterias = SubKriteria::all()->where('kriteria_id','=',$id);
        foreach ($subKriterias as $key => $sub) {
          SubKriteriaSubKriteria::where('sub_kriteria1_id','=', $sub->id)->delete();
          SubKriteriaSubKriteria::where('sub_kriteria2_id','=', $sub->id)->delete();
        }
        SubKriteria::where('kriteria_id','=', $id)->delete();
        PemasokSub::where('kriteria_id', '=', $id)->delete();
        ExpertKriteriaComparison::truncate();
        ExpertSubComparison::truncate();
        FuzzyKriteria::truncate();
        FuzzySub::truncate();
        PemasokSubFuzzyResult::truncate();
        PemasokSubResult::truncate();
        $this->kriteriaRepository->delete($id);

        Flash::success('Kriteria deleted successfully.');

        return redirect(route('kriterias.index'));
    }
}
