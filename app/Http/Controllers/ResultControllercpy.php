<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Models\Expert;
use App\Models\KriteriaKriteria;
use App\ExpertKriteriaComparison;
use App\Models\SubKriteriaSubKriteria;
use App\Models\SubKriteria;
use App\ExpertSubComparison;
use App\FuzzyKriteria;
use App\FuzzySub;
use App\Models\Pemasok;
use App\Models\PemasokSub;
use App\PemasokSubResult;
use App\PemasokSubFuzzyResult;
use Charts;
use Flash;

class ResultController extends Controller
{

    public function index(){
        // $a = $this->storeResult();
        // $b = $this->storeSubComparison();
        // $c = $this->storePemasok();
        // $d = $this->storeFuzzySub();
        // $e = $this->storeFuzzyKri();
        // $f = $this->storeFuzPemasok();
        // dd([$a,$b,$c]);
        $expertKriteriaComparison = ExpertKriteriaComparison::all();
        $experts = Expert::all()->pluck('nama','id');
        $kPluck = Kriteria::all()->pluck('nama_kriteria', 'id');
        $sPluck = SubKriteria::all()->pluck('nama_sub_kriteria', 'id');
        $pPluck = Pemasok::pluck('nama_pemasok', 'id');
        $expert = Expert::all();
        $kriterias = Kriteria::all();
        $countKri = $kriterias->count();
        $subKriterias = SubKriteria::all();
        //$data = unserialize($expertKriteriaComparison->data);
        // dd($expertKriteriaComparison);
        // $s = null;
        // foreach ($expertKriteriaComparison as $key => $value) {
        //   $s = unserialize($value->data);
        //   dd($s);
        // }
        // dd($s);
        $expertSubComparison = ExpertSubComparison::all();
        $fuzzyKriteria = FuzzyKriteria::all();
        $fuzzySub = FuzzySub::all();
        $pemasokSubResult = PemasokSubResult::all();
        $pemasokSubFuzzyResult = PemasokSubFuzzyResult::all();
        // dd(unserialize($pemasokSubFuzzyResult[0]->data));
        $pemasoks = Pemasok::all();
        $exp = new Expert();
        $chart = Charts::create('bar','highcharts')->dimensions(1000,700);
        // $a = $expertSubComparison->where('kriteria_id','=', 6)->first();
        // dd(unserialize($a->data));



        return view('result.kriteria')->with('data', $expertKriteriaComparison)
                ->with('experts', $experts)->with('kriterias', $kriterias)->with('expert', $expert)->with('countKri', $countKri)
                ->with('hasilFuzzyKriteria', $fuzzyKriteria)
                ->with('hasilAhpSub', $expertSubComparison)
                ->with('hasilFuzzySub', $fuzzySub)
                ->with('hasilPemasok', $pemasokSubResult)
                ->with('hasilFuzzyPemasok', $pemasokSubFuzzyResult)
                ->with('subKriterias', $subKriterias)
                ->with('pemasoks', $pemasoks)
                ->with('exp', $exp)
                ->with('chart', $chart);
    }


    public function gAhpKri(){
      if($this->storeResult()){
        Flash::success('Berhasil generate hasil!');

        return \App::make('redirect')->back();
      }
    }

    public function gAhpSub(){
      if($this->storeSubComparison()){
        Flash::success('Berhasil generate hasil!');

        return \App::make('redirect')->back();
      }
    }

    public function gAhpPem(){
      if($this->storePemasok()){
        Flash::success('Berhasil generate hasil!');

        return \App::make('redirect')->back();
      }
    }

    public function gFuzKri(){
      if($this->storeFuzzyKri()){
        Flash::success('Berhasil generate hasil!');

        return \App::make('redirect')->back();
      }
    }

    public function gFuzSub(){
      if($this->storeFuzzySub()){
        Flash::success('Berhasil generate hasil!');

        return \App::make('redirect')->back();
      }
    }

    public function gFuzPem(){
      if($this->storeFuzPemasok()){
        Flash::success('Berhasil generate hasil!');

        return \App::make('redirect')->back();
      }
    }
    public function storeResult(){
      $hasil = false;
      ExpertKriteriaComparison::truncate();
      $kriterias = Kriteria::all();
      $experts    = Expert::all();
      $kriteriaKriteria = KriteriaKriteria::all();

      $dataKriteria = null;
      //$nExpert = 0;
      foreach ($experts as $e) {
        $kk = $kriteriaKriteria->where('expert_id', '=', $e->id);
          foreach ($kriterias as $k1) {
            foreach ($kriterias as $k2) {
              $found1 = $kriteriaKriteria->where('kriteria1_id', '=', $k1->id)->where('kriteria2_id', '=', $k2->id)
              ->where('expert_id', '=', $e->id)->first();
              $found2 = $kriteriaKriteria->where('kriteria1_id', '=', $k2->id)->where('kriteria2_id', '=', $k1->id)
              ->where('expert_id', '=', $e->id)->first();
              //var_dump($found1->count());
              //dd($found1);
              if($found1 != null){
                $dataKriteria[$e->id][$k1->id][] = $found1['nilai'];
              }elseif($found1 == null && $found2 != null){
                $dataKriteria[$e->id][$k1->id][] = 1/$found2['nilai'];
              }else{
                $dataKriteria[$e->id][$k1->id][] = 1;
              }
            }
        }
        //$nExpert++;
      }
      //dd($dataKriteria);
      foreach ($dataKriteria as $kdK => $dK) {
        //dd($kriterias);
        //dd($dataKriteria);
        $mValue = null; //nilai M
        $tList = null; //nilai Total
        //dd($dataKriteria);

        $n = 0;
        foreach ($dK as $key => $value) {
          $mValue[] = pow(array_product($value),(1/count($dK)));
          $mTotal = 0;
          foreach ($dK as $k => $v) {
            $mTotal += $dK[$k][$n];
          }
          $n++;
          $tList[] = $mTotal;
        }
        //nilai M total
        $mTotal = pow(array_product($tList), 1/count($dK));

        //menghitung nilai bobot lokal
        $bobotLokal = null;
        foreach ($mValue as $key => $value) {
          # code...
          $bobotLokal[] = $value/$mTotal;
        }
        //dd($bobotLokal);
        //menghitung nilai vektor bobot
        $vektorBobotList = null;
        foreach ($dK  as $key => $value) {
          $vektorBobot = 0;
          //dd($vb);
          //dd($value);
          foreach ($value as $k => $v) {
              $vektorBobot += $v * $bobotLokal[$k];
              //var_dump($v);
              //var_dump($vektorBobot);
            }
          $vektorBobotList[] = $vektorBobot;
        }

        //dd($vektorBobotList);
        //menghitung nilai W/w
        $Wperw = null;
        foreach ($vektorBobotList as $key => $value) {
          $Wperw[] = $value / $bobotLokal[$key];
        }

        $data = [
          "dataKriteria" => $dK,
          "mValue" => $mValue,
          "tList" => $tList,
          "mTotal"  => $mTotal,
          "bobotLokal" => $bobotLokal,
          "bobotVektor"  => $vektorBobotList,
          "Wperw" => $Wperw,
          "expert_id" => $kdK
        ];
        //dd(serialize($data));
        $store = new ExpertKriteriaComparison();
        $store->data = serialize($data);
        $hasil = $store->save();
        if(!$hasil){
          return false;
        }
      }
      return $hasil;
    }


    public function storeSubComparison(){
      $hasil = false;
      ExpertSubComparison::truncate();
      $kriterias = Kriteria::all();
      $subKriterias = SubKriteria::all();
      $experts    = Expert::all();
      $subKriteriaSubKriterias = SubKriteriaSubKriteria::all();

      $dataKriteria = null;
      foreach ($kriterias as $key => $value) {
        # code...
        foreach ($experts as $e) {
          $kk = $subKriteriaSubKriterias->where('expert_id', '=', $e->id)->where('kriteria_id', '=', $value->id);
          $subK = $subKriterias->where('kriteria_id', '=', $value->id);
            foreach ($subK as $k1) {
              foreach ($subK as $k2) {
                $found1 = $subKriteriaSubKriterias->where('sub_kriteria1_id', '=', $k1->id)->where('sub_kriteria2_id', '=', $k2->id)
                ->where('expert_id', '=', $e->id)->first();
                $found2 = $subKriteriaSubKriterias->where('sub_kriteria1_id', '=', $k2->id)->where('sub_kriteria2_id', '=', $k1->id)
                ->where('expert_id', '=', $e->id)->first();
                if($found1 != null){
                  $dataKriteria[$value->id][$e->id][$k1->id][] = $found1['nilai'];
                }elseif($found1 == null && $found2 != null){
                  $dataKriteria[$value->id][$e->id][$k1->id][] = 1/$found2['nilai'];
                }else{
                  $dataKriteria[$value->id][$e->id][$k1->id][] = 1;
                }
              }
          }
        }
      }
      // dd($dataKriteria);
      foreach ($dataKriteria as $Kkey => $dKs) {
        # code...
        foreach ($dKs as $dKkey => $dKvalue) {
          # code...
          $mValue = null; //nilai M
          $tList = null; //nilai Total

          $n = 0;
          foreach ($dKvalue as $key => $value) {
            $mValue[] = pow(array_product($value),(1/count($dKvalue)));
            $mTotal = 0;
            foreach ($dKvalue as $k => $v) {
              $mTotal += $dKvalue[$k][$n];
            }
            $n++;
            $tList[] = $mTotal;
          }
          $mTotal = pow(array_product($tList), 1/count($dKvalue));

          //menghitung nilai bobot lokal
          $bobotLokal = null;
          foreach ($mValue as $key => $value) {
            # code...
            $bobotLokal[] = $value/$mTotal;
          }
          //dd($bobotLokal);
          //menghitung nilai vektor bobot
          $vektorBobotList = null;
          foreach ($dKvalue  as $key => $value) {
            $vektorBobot = 0;
            //var_dump($vb);
            //dd($value);
            foreach ($value as $k => $v) {
                $vektorBobot += $v * $bobotLokal[$k];
                //var_dump($v);
                //var_dump($vektorBobot);
              }
            $vektorBobotList[] = $vektorBobot;
          }

          //dd($vektorBobotList);
          //menghitung nilai W/w
          $Wperw = null;
          foreach ($vektorBobotList as $key => $value) {
            $Wperw[] = $value / $bobotLokal[$key];
          }

          $data = [
            "dataKriteria" => $dKvalue,
            "mValue" => $mValue,
            "tList" => $tList,
            "mTotal"  => $mTotal,
            "bobotLokal" => $bobotLokal,
            "bobotVektor"  => $vektorBobotList,
            "Wperw" => $Wperw
          ];

          $store = new ExpertSubComparison();
          $store->data = serialize($data);
          $store->kriteria_id = $Kkey;
          $hasil = $store->save();
          if(!$hasil){
            return false;
          }
        }

      }
      // $a = ExpertSubComparison::all();
      // $b = [];
      // foreach ($a as $key => $value) {
      //   # code...
      //   $b[] = [unserialize($value->data), $value->kriteria_id];
      // }
      //dd($b);
      return $hasil;
    }


    public function storeFuzzyKri(){
        $hasil = false;
        FuzzyKriteria::truncate();
        $kriterias = Kriteria::all();
        $experts    = Expert::all();
        $kriteriaKriteria = KriteriaKriteria::all();

        $dataKriteria = null;
        foreach ($experts as $e) {
          $kk = $kriteriaKriteria->where('expert_id', '=', $e->id);
            foreach ($kriterias as $k1) {
              foreach ($kriterias as $k2) {
                $found1 = $kriteriaKriteria->where('kriteria1_id', '=', $k1->id)->where('kriteria2_id', '=', $k2->id)
                ->where('expert_id', '=', $e->id)->first();
                $found2 = $kriteriaKriteria->where('kriteria1_id', '=', $k2->id)->where('kriteria2_id', '=', $k1->id)
                ->where('expert_id', '=', $e->id)->first();
                //var_dump($found1->count());
                //dd($found1);
                if($found1 != null){
                    $val = $found1['nilai'];
                    if($val <= 1){
                      $bilang = 1/$val;
                      $dataKriteria[$e->id][$k1->id][] = [1/($bilang+2), 1/$bilang, 1/($bilang-2>0?$bilang-2:1)];
                    }else{
                      $dataKriteria[$e->id][$k1->id][] = [$val-2 >= 0? $val-2 : 1, $val, $val+2];
                    }

                }elseif($found1 == null && $found2 != null){
                    $val = $found2['nilai'];
                    //var_dump($val);
                    $nil = 1/$val;
                    if ($nil > 1 ) {
                        $dataKriteria[$e->id][$k1->id][] = [$nil-2 >= 0? $nil-2 : 1, $nil, $nil+2];
                    }else {
                        $dataKriteria[$e->id][$k1->id][] = [1/($val+2), 1/$val, 1/($val-2>0?$val-2:1)];
                    }

                }else{
                    $dataKriteria[$e->id][$k1->id][] = [1,1,1];
                }

              }
          }
        }

        // dd($dataKriteria);
        $ha = [];
        foreach ($dataKriteria as $key => $value) {
          $sifu = [];
          foreach ($value as $k => $v) {
            $l =0;
            $m = 0;
            $u = 0;
            foreach ($v as $kunci => $nilai) {
              $l += $nilai[0];
              $m +=$nilai[1];
              $u +=$nilai[2];
            }
            $sifu[] = [$l, $m, $u];
          //  echo json_encode($sifu);
          }
          // $sum = array_sum($sifu[0]);
          $tl=0;
          $tm=0;
          $tu=0;

          foreach ($sifu as $ks => $vs) {
            $tl += $vs[0];
            $tm += $vs[1];
            $tu += $vs[2];
          }

          // dd($tl);
          $sifuArray = [$tl, $tm, $tu];
          $Si = [];
          foreach ($sifu as $key => $value) {
            $Si[] = [$value[0]/ $tu, $value[1]/$tm, $value[2]/$tl];
          }
          // var_dump(json_encode($Si));
          // echo "<br>";
          // echo "<br>";
          $sintesis = ["jumlah"=>$sifu, "total"=>$sifuArray, "si"=>$Si];
          // dd($sifu);
          $vektoArray = [];
          foreach ($Si as $key => $value) {
            $vektor = [];
            foreach ($Si as $k => $v) {
              if($key!=$k){
                if ($value[1]>=$v[1]) {
                  $vektor[] = 1;
                }elseif ($v[0]>=$value[2]) {
                  $vektor[] = 0;
                }else{
                  $vektor[]=($v[0]-$value[2])/(($value[1]-$value[2])-($v[1]-$v[0]));
                }
              }
            }
            $vektoArray[] = $vektor;
          }
          // dd($vektoArray);
          // $ha[] = $Si;
          $data = ["sisntesis" => $sintesis, "vektor"=>$vektoArray];
          // $ha[] = $data;
          $objek = new FuzzyKriteria();
          $objek->data = serialize($data);
          $hasil = $objek->save();
          if(!$hasil){
            return false;
          }

        }

        // dd($ha);
        return $hasil;
    }

    public function storeFuzzySub(){
     $hasil = false;
     FuzzySub::truncate();
     $kriterias = Kriteria::all();
     $subKriterias = SubKriteria::all();
     $experts    = Expert::all();
     $subKriteriaSubKriterias = SubKriteriaSubKriteria::all();

     $dataKriteria = null;
     foreach ($kriterias as $key => $value) {
       # code...
       foreach ($experts as $e) {
         $kk = $subKriteriaSubKriterias->where('expert_id', '=', $e->id)->where('kriteria_id', '=', $value->id);
         $subK = $subKriterias->where('kriteria_id', '=', $value->id);
           foreach ($subK as $k1) {
             foreach ($subK as $k2) {
               $found1 = $kk->where('sub_kriteria1_id', '=', $k1->id)->where('sub_kriteria2_id', '=', $k2->id)->first();
               $found2 = $kk->where('sub_kriteria1_id', '=', $k2->id)->where('sub_kriteria2_id', '=', $k1->id)->first();
              //  var_dump($found1);
              //  var_dump($found2);
               if($found1 != null){
                   $val = $found1['nilai'];
                    // var_dump($val);
                   if($val < 1){
                     $bilang = 1/$val;
                     $dataKriteria[$value->id][$e->id][$k1->id][] = [1/($bilang+2), 1/$bilang, 1/($bilang-2>0?$bilang-2:1)];

                   }else{
                     $dataKriteria[$value->id][$e->id][$k1->id][] = [$val-2 >= 0? $val-2 : 1, $val, $val+2];

                   }

               }elseif($found1 == null && $found2 != null){
                   $val = $found2['nilai'];
                   //var_dump($val);
                   $nil = 1/$val;
                   if ($nil > 1 ) {
                       $dataKriteria[$value->id][$e->id][$k1->id][] = [$nil-2 >= 0? round($nil-2) : 1, round($nil), round($nil+2)];
                   }else {
                       $dataKriteria[$value->id][$e->id][$k1->id][] = [1/($val+2), 1/$val, 1/($val-2>0?$val-2:1)];
                   }

               }else{
                   $dataKriteria[$value->id][$e->id][$k1->id][] = [1,1,1];
               }
             }
         }
       }
     }
    //  dd($dataKriteria);
    $la=[];
     foreach ($dataKriteria as $kKri => $dKri) {
       # code...
       foreach ($dKri as $key => $value) {
         $sifu = [];
         foreach ($value as $k => $v) {
           $l =0;
           $m = 0;
           $u = 0;
           foreach ($v as $kunci => $nilai) {
             $l += $nilai[0];
             $m +=$nilai[1];
             $u +=$nilai[2];
           }
           $sifu[] = [$l, $m, $u];
         //  echo json_encode($sifu);
         }
         // $sum = array_sum($sifu[0]);
         $tl=0;
         $tm=0;
         $tu=0;

         foreach ($sifu as $ks => $vs) {
           $tl += $vs[0];
           $tm += $vs[1];
           $tu += $vs[2];
         }

        //  dd($tu);
         $sifuArray = [$tl, $tm, $tu];
        //  dd($sifu);
         $Si = [];
         foreach ($sifu as $key => $value) {
           $Si[] = [$value[0]/ $tu, $value[1]/$tm, $value[2]/$tl];
         }
        //  dd($Si);
         $sintesis = ["jumlah"=>$sifu, "total"=>$sifuArray, "si"=>$Si];
        //  dd($sintesis);
         // dd($sintesis);
         $vektoArray = [];
         foreach ($Si as $key => $value) {
           # code...
           $vektor = [];
           foreach ($Si as $k => $v) {
             # code...
             if($key!=$k){
               if ($value[1]>=$v[1]) {
                 # code...
                 $vektor[] = 1;
               }elseif ($v[0]>=$value[2]) {
                 # code...
                 $vektor[] = 0;
               }else{
                 $vektor[]=($v[0]-$value[2])/(($value[1]-$value[2])-($v[1]-$v[0]));
               }
             }
           }
           $vektoArray[] = $vektor;
         }
         $la[] = $Si;
        //  dd($Si);
        //  dd($vektoArray);
         $data = ["sisntesis" => $sintesis, "vektor"=>$vektoArray];
         $ha[] = $data;
         $objek = new FuzzySub();
         $objek->data = serialize($data);
         $objek->kriteria_id = $kKri;
         $hasil = $objek->save();
         if(!$hasil){
           return false;
         }
       }
     }
    //  dd($la);
     return $hasil;
   }

    public function storePemasok(){
      $hasil = false;
      $ka = [];
      PemasokSubResult::truncate();
      $kriterias = Kriteria::all();
      $pemasoks = Pemasok::all();
      $experts    = Expert::all();
      $pemasokSubs = PemasokSub::orderBy('expert_id','ASC')->orderBy('kriteria_id','ASC')->orderBy('sub_kriteria_id','ASC')->orderBy('pemasok1_id','ASC')->get();
      $subKriterias = SubKriteria::all();

      $dataKriteria = null;
      foreach ($experts as $e) {
        $kk = $pemasokSubs->where('expert_id', '=', $e->id);
        foreach ($kriterias as $kkri => $kvalue) {
          $kkr = $kk->where('kriteria_id','=',$kvalue->id);
          $sss = $subKriterias->where('kriteria_id','=', $kvalue->id);
          foreach ($sss as $subkey => $subvalue) {
            $kks = $kkr->where('sub_kriteria_id','=', $subvalue->id);
              foreach ($pemasoks as $k1) {
                foreach ($pemasoks as $k2) {
                  $found1 = $kks->where('pemasok1_id', '=', $k1->id)->where('pemasok2_id', '=', $k2->id)->first();
                  $found2 = $kks->where('pemasok1_id', '=', $k2->id)->where('pemasok2_id', '=', $k1->id)->first();
                  //var_dump($found1->count());
                  //dd($found1);
                  if($found1 != null){
                    $dataKriteria[$e->id][$kvalue->id][$subvalue->id][$k1->id][] = $found1['nilai'];
                  }elseif($found1 == null && $found2 != null){
                    $dataKriteria[$e->id][$kvalue->id][$subvalue->id][$k1->id][] = 1/$found2['nilai'];
                  }else{
                    $dataKriteria[$e->id][$kvalue->id][$subvalue->id][$k1->id][] = 1;
                  }
                }
            }
          }
        }
      }
      // dd($dataKriteria[7]);
      // dd($dataKriteria[7][2]);
      foreach ($dataKriteria as $kdK => $dK) {
        foreach ($dK as $dKkey => $dKvalue) {
          foreach ($dKvalue as $DKkey => $DKvalue) {
            $mValue = null; //nilai M
            $tList = null; //nilai Total
            //dd($dataKriteria);

            $n = 0;
            foreach ($DKvalue as $key => $value) {
              $mValue[] = pow(array_product($value),(1/count($DKvalue)));
              $mTotal = 0;
              foreach ($DKvalue as $k => $v) {
                $mTotal += $DKvalue[$k][$n];
              }
              $n++;
              $tList[] = $mTotal;
            }
            //nilai M total
            // dd($mValue);
            $mTotal = pow(array_product($tList), 1/count($DKvalue));
            $ka[] = $mTotal;
            //menghitung nilai bobot lokal
            $bobotLokal = null;
            foreach ($mValue as $key => $value) {
              # code...
              $bobotLokal[] = $value/$mTotal;
            }
            // dd($bobotLokal);
            //menghitung nilai vektor bobot
            $vektorBobotList = null;
            foreach ($DKvalue  as $key => $value) {
              $vektorBobot = 0;
              //dd($vb);
              //dd($value);
              foreach ($value as $k => $v) {
                  $vektorBobot += $v * $bobotLokal[$k];
                  //var_dump($v);
                  //var_dump($vektorBobot);
                }
              $vektorBobotList[] = $vektorBobot;
            }

            //dd($vektorBobotList);
            //menghitung nilai W/w
            $Wperw = null;
            foreach ($vektorBobotList as $key => $value) {
              $Wperw[] = $value / $bobotLokal[$key];
            }

            $data = [
              "dataPemasok" => $dK,
              "mValue" => $mValue,
              "tList" => $tList,
              "mTotal"  => $mTotal,
              "bobotLokal" => $bobotLokal,
              "bobotVektor"  => $vektorBobotList,
              "Wperw" => $Wperw,
              "expert_id" => $kdK,
              "kriteria_id" => $dKkey,
              "sub_kriteria_id" => $DKkey
            ];

            //dd(serialize($data));
            //dd(serialize($data));
            $store = new PemasokSubResult();
            $store->data = serialize($data);
            $store->expert_id = $kdK;
            $store->kriteria_id = $dKkey;
            $store->sub_kriteria_id = $DKkey;
            $hasil = $store->save();
            if(!$hasil) return false;
          }
        }
        //dd($kriterias);
        //dd($dataKriteria);

      }
      // dd($ka);
      return $hasil;
    }


    public function storeFuzPemasok(){
      $hasil = false;
      PemasokSubFuzzyResult::truncate();
      $kriterias = Kriteria::all();
      $pemasoks = Pemasok::all();
      $experts    = Expert::all();
      $pemasokSubs = PemasokSub::orderBy('expert_id','ASC')->orderBy('kriteria_id','ASC')->orderBy('sub_kriteria_id','ASC')->orderBy('pemasok1_id','ASC')->get();
      $subKriterias = SubKriteria::all();

      $dataKriteria = null;
      //$nExpert = 0;
      set_time_limit(0);

        foreach ($subKriterias as $subkey => $subvalue) {
            $kks = $pemasokSubs->where('sub_kriteria_id','=', $subvalue->id);
          foreach ($experts as $e) {
            $kk = $kks->where('expert_id', '=', $e->id);
            foreach ($pemasoks as $kpm => $vpm) {
              foreach ($pemasoks as $k1) {
                foreach ($pemasoks as $k2) {
                  $found1 = $kks->where('pemasok1_id', '=', $k1->id)->where('pemasok2_id', '=', $k2->id)->first();
                  $found2 = $kks->where('pemasok1_id', '=', $k2->id)->where('pemasok2_id', '=', $k1->id)->first();
                  //var_dump($found1->count());
                  //dd($found1);
                  if($found1 != null){
                      $val = $found1['nilai'];
                      if($val >= 1){
                        $dataKriteria[$subvalue->id][$e->id][$kpm][$k1->id][] = [$val-2 >= 0? $val-2 : 1, $val, $val+2];
                      }else{
                        $bilang = 1/$val;
                        $dataKriteria[$subvalue->id][$e->id][$kpm][$k1->id][] = [1/($bilang+2), 1/$bilang, 1/($bilang-2>0?$bilang-2:1)];
                      }

                  }elseif($found1 == null && $found2 != null){
                      $val = $found2['nilai'];
                      //var_dump($val);
                      $nil = 1/$val;
                      if ($nil > 1 ) {
                          $dataKriteria[$subvalue->id][$e->id][$kpm][$k1->id][] = [$nil-2 >= 0? $nil-2 : 1, $nil, $nil+2];
                      }else {
                          $dataKriteria[$subvalue->id][$kpm][$e->id][$k1->id][] = [1/($val+2), 1/$val, 1/($val-2>0?$val-2:1)];
                      }

                  }else{
                      $dataKriteria[$subvalue->id][$e->id][$kpm][$k1->id][] = [1,1,1];
                  }
                }
            }
            }

          }
        }
      dd($dataKriteria[20]);
      // dd($dataKriteria[7][1][23]);
      $aaaa = [];
      foreach ($dataKriteria as $keydata => $value) {
          foreach ($value as $keyvv => $valuevv) {
            $sifu = [];
            foreach ($valuevv as $k => $v) {
              $l =0;
              $m = 0;
              $u = 0;
              foreach ($v as $kunci => $nilai) {
                $l += $nilai[0];
                $m +=$nilai[1];
                $u +=$nilai[2];
              }
              $sifu[] = [$l, $m, $u];
              // dd($sifu);
            //  echo json_encode($sifu);
            }
            // $sum = array_sum($sifu[0]);
            $tl=0;
            $tm=0;
            $tu=0;

            foreach ($sifu as $ks => $vs) {
              $tl += $vs[0];
              $tm += $vs[1];
              $tu += $vs[2];
            }

            //dd($tu);
            $sifuArray = [$tl, $tm, $tu];
            // dd($sifuArray);
            //var_dump(json_encode($sifu));
            $Si = [];
            foreach ($sifu as $key => $vfu) {
              $Si[] = [$vfu[0]/ $tu, $vfu[1]/$tm, $vfu[2]/$tl];
            }
            // dd($sifuArray);
            $sintesis = ["jumlah"=>$sifu, "total"=>$sifuArray, "si"=>$Si];
            // dd($sintesis);
            $vektoArray = [];
            foreach ($Si as $key => $vfu) {
              $vektor = [];
              foreach ($Si as $k => $v) {
                if($key!=$k){
                  if ($vfu[1]>=$v[1]) {
                    $vektor[] = 1;
                  }elseif ($v[0]>=$vfu[2]) {
                    $vektor[] = 0;
                  }else{
                    $vektor[]=($v[0]-$vfu[2])/(($vfu[1]-$vfu[2])-($v[1]-$v[0]));
                  }
                }
              }
              $vektoArray[] = $vektor;
            }
            $aaaa[]=$vektoArray;
            // dd($vektoArray);
            $data = ["sisntesis" => $sintesis, "vektor"=>$vektoArray];
            $objek = new PemasokSubFuzzyResult();
            $objek->data = serialize($data);
            $objek->expert_id = $keyvv;
            $objek->sub_kriteria_id = $keydata;
            $hasil = $objek->save();
            // dd($keydata);
            if(!$hasil) return false;

          }

        }
        dd($aaaa);
        return $hasil;

    }

}
