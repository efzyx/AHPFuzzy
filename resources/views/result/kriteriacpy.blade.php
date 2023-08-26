
@php
  $GLOBALS['bobotKriteriaList'] = [];
  $GLOBALS['bobotSubKriteriaList'] = [];
  $GLOBALS['bobotPemasokList'] = [];
@endphp
@extends('layouts.app')
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Hasil Perbandingan</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">

                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                    <ul class="nav nav-tabs center-block" role="tablist">
                      <li role="presentation" class="active"><a href="#ahp" aria-controls="ahp" role="tab" data-toggle="tab"><b>AHP</b></a></li>
                      <li role="presentation" class=""><a href="#fuzzy" aria-controls="fuzzy" role="tab" data-toggle="tab"><b>FUZZY</b></a></li>
                      <li role="presentation" class=""><a href="#hasil" aria-controls="hasil" role="tab" data-toggle="tab"><b>HASIL</b></a></li>
                    </ul>
                    </div>
                    <div class="col-md-4"></div>
                  </div>

                  <div class="tab-content">
                      <div role="tab-panel" class="tab-pane active" id="ahp">
                            <ul class="nav nav-tabs" role="tab-list">
                              <li role="presentation" class="active"><a href="#kriteria" aria-controls="kriteria" role="tab" data-toggle="tab"><b>Kriteria</b></a></li>
                              <li role="presentation" class=""><a href="#sub_kriteria" aria-controls="sub_kriteria" role="tab" data-toggle="tab"><b>Sub Kriteria</b></a></li>
                              <li role="presentation" class=""><a href="#pemasok" aria-controls="pemasok" role="tab" data-toggle="tab"><b>Pemasok</b></a></li>
                            </ul>

                          <!-- Tab panes -->
                          <div class="tab-content">

                              <div role="tabpanel" class="tab-pane active" id="kriteria">
                                <h1 class="pull-right">
                                   <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('gAhpKri') !!}">Generate</a>
                                </h1>
                                @php
                                $arr = null;

                                 @endphp
                                @foreach ($data as $key => $value)
                                  @php
                                    $d = unserialize($value->data);
                                    $dt = $d['dataKriteria'];
                                    //var_dump(json_encode($d));
                                    echo "<br>";
                                    $arr[] = $d;
                                    //dd($data);

                                  @endphp
                                @endforeach
                                @foreach ($arr as $kdata => $vdata)
                                    <h4>Hasil Perbandingan oleh <strong>{!! $experts[$vdata['expert_id']] !!}</strong></h4>
                                    @include('result.kriteria_table')
                                @endforeach
                              </div>

                              <div role="tabpanel" class="tab-pane" id="sub_kriteria">
                                <h1 class="pull-right">
                                   <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('gAhpSub') !!}">Generate</a>
                                </h1>
                                @if ($data != null)
                                  @foreach ($kriterias as $key => $valk)
                                    @php
                                      $subss = $hasilAhpSub->where('kriteria_id','=', $valk->id);
                                      $arr = null;
                                    @endphp
                                        @foreach ( $subss as $key => $valuess)
                                          @php

                                            $d = unserialize($valuess->data);
                                            $dt = $d['dataKriteria'];
                                            //var_dump(json_encode($d));
                                            // echo "<br>";
                                            $arr[] = $d;
                                            //dd($data);

                                          @endphp
                                        @endforeach
                                        @php
                                          // dd($arr);
                                          $ho = 1
                                        @endphp

                                        @foreach ($arr as $kdat => $vdat)
                                          <h4>Hasil Sub Kriteria dari <strong>{!! $valk->nama_kriteria !!}</strong></h4>
                                          <h3>Expert {!! $ho++ !!}</h3>
                                          @include('result.sub_kriteria_table')
                                          @php
                                          @endphp
                                        @endforeach

                                      @endforeach
                                @endif

                              </div>

                              <div role="tabpanel" class="tab-pane" id="pemasok">
                                <h1 class="pull-right">
                                   <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('gAhpPem') !!}">Generate</a>
                                </h1>
                                @if ($hasilPemasok != null)
                                @foreach ($kriterias as $kraa => $vakra)
                                  @php
                                  $pms = $hasilPemasok->where('kriteria_id','=', $vakra->id);
                                  $pmssk = $subKriterias->where('kriteria_id','=', $vakra->id);
                                  @endphp
                                  @foreach ($pmssk as $kss => $ss)
                                    @php
                                    // dd($ss);
                                      $pmss = $pms->where('sub_kriteria_id','=',$ss->id);
                                      // dd($pmss);
                                      $arr = null;
                                    @endphp
                                    @foreach ($pmss as $kpp => $vpp)
                                      @php
                                        $d = unserialize($vpp->data);
                                        $dt = $d['dataPemasok'];
                                        $arr[] = $d;
                                        //dd($data);

                                      @endphp
                                    @endforeach
                                    @php
                                      // dd($arr);
                                      $longS = null;
                                      $longE = null;
                                    @endphp
                                    @if($arr != null)
                                    @foreach ($arr as $key => $value)
                                      <h4>Hasil Perbandingan <strong>{!! $subKriterias->find($value['sub_kriteria_id'])->nama_sub_kriteria !!}</strong> oleh <strong>{!! $expert->find($value['expert_id'])->nama !!}</strong></h4>
                                      @include('result.pemasok_table')
                                    @endforeach
                                    @endif
                                  @endforeach
                                @endforeach
                                @endif
                              </div>
                          </div>
                      </div>

                  <div role="tab-panel" class="tab-pane" id="fuzzy">
                    <ul class="nav nav-tabs" role="tab-list">
                      <li role="presentation" class="active"><a href="#kriteriafuz" aria-controls="kriteriafuz" role="tab" data-toggle="tab"><b>Kriteria</b></a></li>
                      <li role="presentation" class=""><a href="#sub_kriteriafuz" aria-controls="sub_kriteriafuz" role="tab" data-toggle="tab"><b>Sub Kriteria</b></a></li>
                      <li role="presentation" class=""><a href="#pemasokfuz" aria-controls="pemasokfuz" role="tab" data-toggle="tab"><b>Pemasok</b></a></li>
                    </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">

                      <div role="tabpanel" class="tab-pane active" id="kriteriafuz">
                        <h1 class="pull-right">
                           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('gFuzKri') !!}">Generate</a>
                        </h1>
                        @if ($hasilFuzzyKriteria != null)
                          <h4>Rekap Bobot Akhir Kriteria</h4>
                          @php $arr = null;  @endphp
                          @foreach ($hasilFuzzyKriteria as $key => $value)
                            @php
                              $d = unserialize($value->data);
                              // dd($d);
                              $dt = $d['vektor'];
                              $arr[] = $d;
                              //dd($data);
                              // $bobotKriteriaList = array()
                            @endphp
                          @endforeach
                              @include('result.f_kriteria_table')
                        @endif

                      </div>

                      <div role="tabpanel" class="tab-pane" id="sub_kriteriafuz">
                        <h1 class="pull-right">
                           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('gFuzSub') !!}">Generate</a>
                        </h1>
                        @if ($hasilFuzzySub != null)
                          @php
                            $numb = 0;
                            // $bobotSubKriteriaList = [];
                          @endphp
                            @foreach ($kriterias as $key => $v)
                              @php
                              $arrh = null;
                              $hfs = $hasilFuzzySub->where('kriteria_id','=', $v->id);
                              @endphp
                              @foreach ($hfs as $key => $value)
                                @php
                                  $d = unserialize($value->data);
                                  // dd($d);
                                  $dt = $d['vektor'];
                                  $arrh[] = $d;
                                  // dd($data);

                                @endphp
                              @endforeach
                              @php
                                // dd($arrh);
                              @endphp
                              <h4>Hasil Perbandingan Sub Kriteria dari <strong>{!! $v->nama_kriteria !!}</strong></h4>
                                @include('result.f_sub_kriteria_table')
                                @php
                                  $numb += 1;
                                  // dd($arr);
                                @endphp
                            @endforeach
                        @endif

                      </div>

                      <div role="tabpanel" class="tab-pane" id="pemasokfuz">
                        <h1 class="pull-right">
                           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('gFuzPem') !!}">Generate</a>
                        </h1>
                        @if ($hasilFuzzyPemasok != null)
                          @php
                          foreach ($hasilFuzzyPemasok as $key => $value) {
                            dd(unserialize($value->data));
                          }
                            // dd($arrP)
                            // $bobotPemasokList = [];
                            $mari = null;
                            foreach ($expert as $l => $m) {
                              $oke = $hasilFuzzyPemasok->where('expert_id','=', $m->id);
                              foreach ($kriterias as $o => $q) {
                                $yuk = $oke->where('kriteria_id', '=', $q->id);
                                $ker = $subKriterias->where('kriteria_id', '=', $q->id);
                                foreach ($ker as $kex => $vax) {
                                  $mari[$m->id][$q->id][$vax->id] = $yuk->where('sub_kriteria_id','=',$vax->id)->first();
                                }

                              }
                            }

                          @endphp

                        @foreach ($kriterias as $kkris => $vakris)
                          <h3><strong>{!! $vakris->nama_kriteria !!}</strong></h3>
                          @include('result.f_pemasok_table')
                        @endforeach
                        @endif

                      </div>
                  </div>
                  </div>

                  <div role="tab-panel" class="tab-pane" id="hasil">
                    @if (count($GLOBALS['bobotKriteriaList']) > 0 && count($GLOBALS['bobotSubKriteriaList'])>0 && count($GLOBALS['bobotPemasokList'])>0)
                      @include('result.hasil_table')
                    @endif
                  </div>
                </div>

            </div>
        </div>
    </div>
@endsection
