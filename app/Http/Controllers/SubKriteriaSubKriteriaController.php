<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubKriteriaSubKriteriaRequest;
use App\Http\Requests\UpdateSubKriteriaSubKriteriaRequest;
use App\Repositories\SubKriteriaSubKriteriaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Expert;
use App\Models\Kriteria;
use App\Models\SubKriteriaSubKriteria;
use App\Models\SubKriteria;

class SubKriteriaSubKriteriaController extends AppBaseController
{
    /** @var  SubKriteriaSubKriteriaRepository */
    private $subKriteriaSubKriteriaRepository;

    public function __construct(SubKriteriaSubKriteriaRepository $subKriteriaSubKriteriaRepo)
    {
        $this->subKriteriaSubKriteriaRepository = $subKriteriaSubKriteriaRepo;
    }

    /**
     * Display a listing of the SubKriteriaSubKriteria.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->subKriteriaSubKriteriaRepository->pushCriteria(new RequestCriteria($request));
        $subKriteriaSubKriterias = $this->subKriteriaSubKriteriaRepository->all();

        return view('sub_kriteria_sub_kriterias.index')
            ->with('subKriteriaSubKriterias', $subKriteriaSubKriterias);
    }

    /**
     * Show the form for creating a new SubKriteriaSubKriteria.
     *
     * @return Response
     */
    public function create($id)
    {
      $subKriterias = SubKriteria::all()->where('kriteria_id', '=', $id);
      $sKs = SubKriteria::all()->where('kriteria_id', '=', $id)->pluck('nama_sub_kriteria','id');
      $kriteria = Kriteria::find($id);
      $allSS = SubKriteriaSubKriteria::all()->where('kriteria_id', '=', $id);
      $expert = Expert::all();
      $e = Expert::all()->pluck('nama', 'id');
      $selectedExpert = null;
      foreach ($expert as $ex) {
        $subKriteriasCount = countTable($subKriterias->count());
        $expertInSS = $allSS->where('expert_id', '=', $ex->id);
        if($expertInSS->count() < $subKriteriasCount){
          $selectedExpert = $ex;
          break;
        }
      }
      if($selectedExpert == null){
        return view('sub_kriteria_sub_kriterias.create')->with('fullExpert', true)->with('kriteria', $kriteria)
                ->with('subKriterias', $sKs)->with('subKriteriaSubKriterias', $allSS)
                ->with('expert', $e);
      }
      $subKriteriaSubKriterias = SubKriteriaSubKriteria::all()->where('expert_id', '=', $selectedExpert->id);
      $subKriteria1 = null;
      $subKriteria2 = null;
      $ketemu = false;
      $full = countTable($subKriterias->count()) == $subKriteriaSubKriterias->count() ? true : false;
      $count = 0;
      foreach ($subKriterias as $k1) {

        $count = $subKriteriaSubKriterias->where('sub_kriteria1_id', '=', $k1->id)->count() + $subKriteriaSubKriterias->where('sub_kriteria2_id', '=', $k1->id)->count();
        if($count < $subKriterias->count()){
          foreach ($subKriterias as $k2) {
              $ada1 = $subKriteriaSubKriterias->where('sub_kriteria1_id', '=', "$k1->id")->where('sub_kriteria2_id', '=', "$k2->id")->count();
              $ada2 = $subKriteriaSubKriterias->where('sub_kriteria1_id', '=', "$k2->id")->where('sub_kriteria2_id', '=', "$k1->id")->count();
              if($ada1 == 0 && $ada2 == 0 && $k1 != $k2){
                $subKriteria1 = $k1;
                $subKriteria2 = $k2;
                $ketemu = true;
                break;
              }
          }
        }

        if($ketemu==true) break;
      }
      return view('sub_kriteria_sub_kriterias.create')
                  ->with('subKriteria1', $subKriteria1)->with('subKriteria2', $subKriteria2)
                  ->with('full', $full)->with('expert', $selectedExpert)
                  ->with('fullExpert', false)->with('kriteria',$kriteria)
                  ->with('subKriteriaSubKriterias', $allSS)
                  ->with('subKriterias', $sKs)
                  ->with('experts', $e);
    }

    /**
     * Store a newly created SubKriteriaSubKriteria in storage.
     *
     * @param CreateSubKriteriaSubKriteriaRequest $request
     *
     * @return Response
     */
    public function store(CreateSubKriteriaSubKriteriaRequest $request)
    {
        $input = $request->all();

        $subKriteriaSubKriteria = $this->subKriteriaSubKriteriaRepository->create($input);

        Flash::success('Sub Kriteria Sub Kriteria saved successfully.');

        return redirect()->back();
    }

    /**
     * Display the specified SubKriteriaSubKriteria.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $subKriteriaSubKriteria = $this->subKriteriaSubKriteriaRepository->findWithoutFail($id);

        if (empty($subKriteriaSubKriteria)) {
            Flash::error('Sub Kriteria Sub Kriteria not found');

            return redirect(route('subKriteriaSubKriterias.index'));
        }

        return view('sub_kriteria_sub_kriterias.show')->with('subKriteriaSubKriteria', $subKriteriaSubKriteria);
    }

    /**
     * Show the form for editing the specified SubKriteriaSubKriteria.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $subKriteriaSubKriteria = $this->subKriteriaSubKriteriaRepository->findWithoutFail($id);
        $expert = Expert::find($subKriteriaSubKriteria->expert_id);
        $subKriteria1 = SubKriteria::find($subKriteriaSubKriteria->sub_kriteria1_id);
        $subKriteria2 = SubKriteria::find($subKriteriaSubKriteria->sub_kriteria2_id);
        $kriteria   = Kriteria::find($subKriteriaSubKriteria->kriteria_id);
        if (empty($subKriteriaSubKriteria)) {
            Flash::error('Sub Kriteria Sub Kriteria not found');

            return redirect(route('subKriteriaSubKriterias.index'));
        }

        return view('sub_kriteria_sub_kriterias.edit')->with('subKriteriaSubKriteria', $subKriteriaSubKriteria)
            ->with('expert', $expert)
            ->with('subKriteria1', $subKriteria1)
            ->with('subKriteria2', $subKriteria2)
            ->with('kriteria', $kriteria);
    }

    /**
     * Update the specified SubKriteriaSubKriteria in storage.
     *
     * @param  int              $id
     * @param UpdateSubKriteriaSubKriteriaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSubKriteriaSubKriteriaRequest $request)
    {
        $subKriteriaSubKriteria = $this->subKriteriaSubKriteriaRepository->findWithoutFail($id);

        if (empty($subKriteriaSubKriteria)) {
            Flash::error('Sub Kriteria Sub Kriteria not found');

            return redirect(route('kriterias.subKriteriaSubKriterias.create',[$id => $sId]));
        }
        $sId = $subKriteriaSubKriteria->kriteria_id;
        $subKriteriaSubKriteria = $this->subKriteriaSubKriteriaRepository->update($request->all(), $id);

        Flash::success('Sub Kriteria Sub Kriteria updated successfully.');

        return redirect(route('kriterias.subKriteriaSubKriterias.create',[$id => $sId]));
    }


    public function destroyAllByKriteriaId($kriteria_id){
      $subKriteriaSubKriteria = SubKriteriaSubKriteria::where('kriteria_id','=',$kriteria_id);
      if (empty(count($subKriteriaSubKriteria->get()))) {
          Flash::error('Sub Kriteria Sub Kriteria not found');

          return redirect()->back();
      }

      $subKriteriaSubKriteria->delete();

      Flash::success('Sub Kriteria Sub Kriteria deleted successfully.');

      return redirect()->back();
    }
}
