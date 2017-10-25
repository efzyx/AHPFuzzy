<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePemasokSubRequest;
use App\Http\Requests\UpdatePemasokSubRequest;
use App\Repositories\PemasokSubRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\SubKriteria;
use App\Models\PemasokSub;
use App\Models\Kriteria;
use App\Models\Pemasok;
use App\Models\Expert;

class PemasokSubController extends AppBaseController
{
    /** @var  PemasokSubRepository */
    private $pemasokSubRepository;

    public function __construct(PemasokSubRepository $pemasokSubRepo)
    {
        $this->pemasokSubRepository = $pemasokSubRepo;
    }

    /**
     * Display a listing of the PemasokSub.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->pemasokSubRepository->pushCriteria(new RequestCriteria($request));
        $pemasokSubs = $this->pemasokSubRepository->all();
        $kriterias = Kriteria::pluck('nama_kriteria', 'id');
        $subKriterias = SubKriteria::pluck('nama_sub_kriteria', 'id');
        $experts = Expert::pluck('nama', 'id');

        return view('pemasok_subs.index')
            ->with('pemasokSubs', $pemasokSubs)
            ->with('kriterias', $kriterias)
            ->with('subKriterias', $subKriterias);
    }

    /**
     * Show the form for creating a new PemasokSub.
     *
     * @return Response
     */
    public function create($id)
    {
      $expert = Expert::find($id);
      $experts = Expert::all();
      $hit = 0;
      foreach ($experts as $key => $value) {
        $hit++;
        if($value->id == $id){
          break;
        }
      }
      // dd($hit);
      $ps = PemasokSub::where('expert_id','=',$id)->orderBy('kriteria_id','ASC')->orderBy('sub_kriteria_id','ASC')->orderBy('pemasok1_id','ASC')->get();
      $pemasoks = Pemasok::all();
      $subKriterias = SubKriteria::all();
      //dd($kriterias);
      $p = Pemasok::all()->pluck('nama_pemasok', 'id');
      //dd($k);
      $pemasok1 = null;
      $kriterias = Kriteria::all();
      $selectedKri = null;
      foreach ($kriterias as $kk => $vk) {
        $ck = PemasokSub::all()->where('kriteria_id','=', $vk->id)->count();
        $csub = SubKriteria::all()->where('kriteria_id','=',$vk->id)->count();
          // dd($csub);
        if($ck < countTable($pemasoks->count())*$csub* Expert::all()->count()){
          $selectedKri = $vk;
          break;
        }
      }
      $selectedSub = null;
      $hms = $subKriterias->where('kriteria_id','=',$selectedKri->id);
      // dd($hms);
      foreach ($hms as $key => $value) {
        $cSub = PemasokSub::all()->where('sub_kriteria_id', '=', $value->id)->where('expert_id','=',$id)->count();
        // dd($cSub);
        if($cSub  <= countTable($pemasoks->count()) * $hit){
          $selectedSub = $value;
          break;
        }
      }
      // dd($selectedSub);
      $pemasokSubs = PemasokSub::all()->where("expert_id",'=', $id);
      $pemasok2 = null;
      $ketemu = false;
      $full = countTable($pemasoks->count()) == $pemasokSubs->count() ? true : false;
      foreach ($pemasoks as $p1) {
        if($selectedKri==null || $selectedSub==null) break;
        $count = $pemasokSubs->where('pemasok1_id', '=', $p1->id)->where('kriteria_id', '=', $selectedKri->id)->where('sub_kriteria_id', '=', $selectedSub->id)->count() +
                  $pemasokSubs->where('pemasok2_id', '=', $p1->id)->where('kriteria_id', '=', $selectedKri->id)->where('sub_kriteria_id', '=', $selectedSub->id)->count();
        $countKri = $subKriterias->where('kriteria_id','=', $selectedKri->id);
                // var_dump($countKri->count());
        // dd($count);
        // if($count < $kriterias->count()*$countKri->count()){
          // dd($count);
          foreach ($pemasoks as $p2) {
              if($p1->id != $p2->id){
                // dd($selectedSub);
                $ada1 = $pemasokSubs->where('pemasok1_id', '=', "$p1->id")->where('pemasok2_id', '=', "$p2->id")->where('sub_kriteria_id', '=', $selectedSub->id)->count();
                $ada2 = $pemasokSubs->where('pemasok1_id', '=', "$p2->id")->where('pemasok2_id', '=', "$p1->id")->where('sub_kriteria_id', '=', $selectedSub->id)->count();
                if($ada1 == 0 && $ada2 == 0 ){
                  $pemasok1 = $p1;
                  $pemasok2 = $p2;
                  $ketemu = true;
                  break;
                }
              }
          }
        // }
        if($ketemu==true) break;
      }
      // dd($count);
      // dd($id);
      return view('pemasok_subs.create')->with('expert', $expert)
                  ->with('pemasok1', $pemasok1)->with('pemasok2', $pemasok2)
                  ->with('full', $full)->with('pemasokSubs', $pemasokSubs)
                  ->with('kriterias', $kriterias)->with('pemasoks', $pemasoks)
                  ->with('subKriteria', $selectedSub)->with('selectedSub', $selectedSub)
                  ->with('selectedKri', $selectedKri)->with('ps', $ps)
                  ->with('p', $p);
    }


    /**
     * Store a newly created PemasokSub in storage.
     *
     * @param CreatePemasokSubRequest $request
     *
     * @return Response
     */
    public function store(CreatePemasokSubRequest $request)
    {
        $input = $request->all();
        //dd($input);
        $pemasokSub = $this->pemasokSubRepository->create($input);

        Flash::success('Pemasok Sub saved successfully.');

        return \App::make('redirect')->back();
    }

    /**
     * Display the specified PemasokSub.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pemasokSub = $this->pemasokSubRepository->findWithoutFail($id);

        if (empty($pemasokSub)) {
            Flash::error('Pemasok Sub not found');

            return redirect(route('pemasokSubs.index'));
        }
        $pemasok1 = Pemasok::find($pemasokSub->pemasok1_id);
        $pemasok2 = Pemasok::find($pemasokSub->pemasok2_id);
        return view('pemasok_subs.show')->with('pemasokSub', $pemasokSub)
                  ->with('pemasok1',$pemasok1)
                  ->with('pemasok2',$pemasok2);
    }

    /**
     * Show the form for editing the specified PemasokSub.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pemasokSub = $this->pemasokSubRepository->findWithoutFail($id);

        if (empty($pemasokSub)) {
            Flash::error('Pemasok Sub not found');

            return redirect(route('pemasokSubs.index'));
        }
        $pemasok1 = Pemasok::find($pemasokSub->pemasok1_id);
        $pemasok2 = Pemasok::find($pemasokSub->pemasok2_id);
        $subKriteria = SubKriteria::find($pemasokSub->sub_kriteria_id);
        $expert = Expert::find($pemasokSub->expert_id);
        return view('pemasok_subs.edit')->with('pemasokSub', $pemasokSub)
                ->with('pemasok1',$pemasok1)
                ->with('pemasok2',$pemasok2)
                ->with('subKriteria', $subKriteria)
                ->with('expert', $expert);
    }

    /**
     * Update the specified PemasokSub in storage.
     *
     * @param  int              $id
     * @param UpdatePemasokSubRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePemasokSubRequest $request)
    {
        $pemasokSub = $this->pemasokSubRepository->findWithoutFail($id);

        if (empty($pemasokSub)) {
            Flash::error('Pemasok Sub not found');

            return redirect(route('pemasokSubs.index'));
        }
        $expert_id = $pemasokSub->expert_id;
        $pemasokSub = $this->pemasokSubRepository->update($request->all(), $id);

        Flash::success('Pemasok Sub updated successfully.');

        return redirect(route('experts.pemasokSubs.create', [$id=>$expert_id]));
    }

    public function destroyAllByExpertId($expert_id){
        $pemasokSub = PemasokSub::where('expert_id','=',$expert_id);

      if (empty(count($pemasokSub->get()))) {
          Flash::error('Pemasok Sub not found');

          return \App::make('redirect')->back();
      }

      $pemasokSub->delete();

      Flash::success('Pemasok Sub deleted successfully.');

      return \App::make('redirect')->back();
    }
}
