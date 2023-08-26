<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateKriteriaKriteriaRequest;
use App\Http\Requests\UpdateKriteriaKriteriaRequest;
use App\Repositories\KriteriaKriteriaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Kriteria;
use App\Models\KriteriaKriteria;
use App\Models\Expert;
use App\ExpertKriteriaComparison;
use App\Models\SubKriteriaSubKriteria;
use App\Models\SubKriteria;
use App\ExpertSubComparison;

class KriteriaKriteriaController extends AppBaseController
{
    /** @var  KriteriaKriteriaRepository */
    private $kriteriaKriteriaRepository;

    public function __construct(KriteriaKriteriaRepository $kriteriaKriteriaRepo)
    {
        $this->kriteriaKriteriaRepository = $kriteriaKriteriaRepo;
    }

    /**
     * Display a listing of the KriteriaKriteria.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->kriteriaKriteriaRepository->pushCriteria(new RequestCriteria($request));
        $kriteriaKriterias = $this->kriteriaKriteriaRepository->all();

        return view('kriteria_kriterias.index')
            ->with('kriteriaKriterias', $kriteriaKriterias);
    }

    /**
     * Show the form for creating a new KriteriaKriteria.
     *
     * @return Response
     */


    public function create($id)
    {
        $expert = Expert::find($id);
        $kriterias = Kriteria::all();
        $k = Kriteria::all()->pluck('nama_kriteria', 'id');
        $kriteria1 = null;
        $kriteriaKriterias = KriteriaKriteria::all()->where('expert_id', '=', $id);
        $kriteria2 = null;
        $ketemu = false;
        $full = countTable($kriterias->count()) == $kriteriaKriterias->count() ? true : false;
        foreach ($kriterias as $k1) {
          $count = $kriteriaKriterias->where('kriteria1_id', '=', "$k1->id")->count() + $kriteriaKriterias->where('kriteria2_id', '=', "$k1->id")->count();
          if($count < $kriterias->count()){
            foreach ($kriterias as $k2) {
                $ada1 = $kriteriaKriterias->where('kriteria1_id', '=', "$k1->id")->where('kriteria2_id', '=', "$k2->id")->count();
                $ada2 = $kriteriaKriterias->where('kriteria1_id', '=', "$k2->id")->where('kriteria2_id', '=', "$k1->id")->count();

                if($ada1 == 0 && $ada2 == 0 && $k1 != $k2){
                  $kriteria1 = $k1;
                  $kriteria2 = $k2;
                  $ketemu = true;
                  break;
                }
            }
          }
          if($ketemu==true) break;
        }
        $experts = Expert::all();
        $kriteriaKriteriaz = KriteriaKriteria::all();
        $dataKriteria = null;
        foreach ($experts as $e) {
            foreach ($kriterias as $k1) {
                foreach ($kriterias as $k2) {
                    $found1 = $kriteriaKriteriaz->where('kriteria1_id', '=', $k1->id)->where('kriteria2_id', '=', $k2->id)->where('expert_id', '=', $e->id)->first();
                    $found2 = $kriteriaKriteriaz->where('kriteria1_id', '=', $k2->id)->where('kriteria2_id', '=', $k1->id)->where('expert_id', '=', $e->id)->first();

                    if($found1 != null){
                        $dataKriteria[$e->id][$k1->id][] = $found1['nilai'];
                    }elseif($found1 == null && $found2 != null){
                        $dataKriteria[$e->id][$k1->id][] = 1/$found2['nilai'];
                    }else{
                        $dataKriteria[$e->id][$k1->id][] = 1;
                    }
                }
            }
        }
        return view('kriteria_kriterias.create')->with('expert', $expert)
                    ->with('kriteria1', $kriteria1)->with('kriteria2', $kriteria2)
                    ->with('full', $full)->with('kriteriaKriterias', $kriteriaKriterias)
                    ->with('kriterias', $k)->with('kriteriaz', $kriterias)->with('dataKriteria', $dataKriteria)
                    ->with('experts', $experts)->with('kriteriaKriteriaz', $kriteriaKriteriaz);
    }

    /**
     * Store a newly created KriteriaKriteria in storage.
     *
     * @param CreateKriteriaKriteriaRequest $request
     *
     * @return Response
     */
    public function store(CreateKriteriaKriteriaRequest $request)
    {
        $input = $request->all();
        //dd($input['kriteria1_id']);
        $expert_id = $input['expert_id'];
        $kriteriaKriteria = $this->kriteriaKriteriaRepository->create($input);
        $KriteriaKriterias = KriteriaKriteria::where('expert_id', '=', $expert_id);
        $kriterias = Kriteria::all();
        $count = $KriteriaKriterias->where('kriteria1_id', '=', $input['kriteria1_id'])->count() + $KriteriaKriterias->where('kriteria2_id', '=', $input['kriteria2_id'])->count();
        $req = json_decode("{'id': $expert_id }");
        if($count < countTable($kriterias->count())){
          Flash::success('Kriteria Kriteria saved successfully.');
          return redirect(route('CreateKriteriaKriteria', ['id' => $expert_id]));
        }else{
          Flash::success('Kriteria Kriteria saved successfully.');
          return redirect(route('experts.index'));
        }
    }

    /**
     * Display the specified KriteriaKriteria.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $kriteriaKriteria = $this->kriteriaKriteriaRepository->findWithoutFail($id);

        if (empty($kriteriaKriteria)) {
            Flash::error('Kriteria Kriteria not found');

            return redirect(route('kriteriaKriterias.index'));
        }

        return view('kriteria_kriterias.show')->with('kriteriaKriteria', $kriteriaKriteria);
    }

    /**
     * Show the form for editing the specified KriteriaKriteria.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $kriteriaKriteria = $this->kriteriaKriteriaRepository->findWithoutFail($id);
        $kriteria1 = Kriteria::find($kriteriaKriteria->kriteria1_id);
        $kriteria2 = Kriteria::find($kriteriaKriteria->kriteria2_id);
        $expert = Expert::find($kriteriaKriteria->expert_id);

        if (empty($kriteriaKriteria)) {
            Flash::error('Kriteria Kriteria not found');

            return redirect(route('kriteriaKriterias.index'));
        }

        return view('kriteria_kriterias.edit')->with('kriteriaKriteria', $kriteriaKriteria)
        ->with('kriteria1', $kriteria1)
        ->with('kriteria2', $kriteria2)
        ->with('expert', $expert);
    }

    /**
     * Update the specified KriteriaKriteria in storage.
     *
     * @param  int              $id
     * @param UpdateKriteriaKriteriaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateKriteriaKriteriaRequest $request)
    {
        $kriteriaKriteria = $this->kriteriaKriteriaRepository->findWithoutFail($id);

        if (empty($kriteriaKriteria)) {
            Flash::error('Kriteria Kriteria not found');

            return redirect(route('kriteriaKriterias.index'));
        }
        $kId = $kriteriaKriteria->expert_id;
        $kriteriaKriteria = $this->kriteriaKriteriaRepository->update($request->all(), $id);

        Flash::success('Kriteria Kriteria updated successfully.');

        return redirect(route('kriteriaKriterias.create', [$id => $kId]));
    }

    public function destroyAllByExpertId($id){
      $kriteriaKriteria = KriteriaKriteria::where('expert_id','=',$id);
      if (empty(count($kriteriaKriteria->get()))) {
          Flash::error('Kriteria Kriteria not found');

          return \App::make('redirect')->back();
      }

      $kriteriaKriteria->delete();

      Flash::success('Kriteria Kriteria deleted successfully.');

      return \App::make('redirect')->back();
    }
}
