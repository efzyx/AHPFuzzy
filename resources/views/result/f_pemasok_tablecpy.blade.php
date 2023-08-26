@php
  $hmmk = $subKriterias->where('kriteria_id','=', $vakris->id);
@endphp
@foreach ($hmmk as $ksub => $vasub)
  <h4>{!! $vasub->nama_sub_kriteria !!}</h4>
  <div class="clearfix"></div>
  <div class="box box-primary">
      <div class="box-body">
          <table class="table table-responsive" id= "{!! $vasub->id !!}">
              <thead style="font-weight: bold">
              <tr>@php
                // dd($arrP);
              @endphp
                  <td></td>
                  @foreach($pemasoks as $e)
                    <td>{!! $e->nama_pemasok !!}</td>
                  @endforeach
                  <th rowspan="4">Total</th>
              </tr>
              </thead>
              <tbody>
                @php
                  $asa = [];
                @endphp
                @foreach ($expert as $kper => $vaper)
                      @php
                      try {

                        $isi = $mari[$vaper->id][$vakris->id][$vasub->id]->data;
                        $isi = unserialize($isi);
                        $asa[] = $isi['vektor'];
                        // dd($asa);
                      } catch (Exception $e) {

                      }
                      @endphp

                @endforeach
                @php
                  // dd($asa);
                  $k = 0;
                  $ttR = [];
                @endphp
                @if(count($asa)>0)
                @foreach ($expert as $kel => $valu)
                  <tr class="tr-pem">
                    <th>{!! $valu->nama !!}</th>
                    @php

                    @endphp
                  @foreach ($pemasoks as $lp => $vala)
                    <?php
                      $ttR[$k][] = min($asa[$k][$lp]); ?>
                    <td class="data-{!! $kel !!}">{!! round(min($asa[$k][$lp]),3) !!}</td>
                  @endforeach

                  @php
                    $k++;
                  @endphp
                  </tr>

                @endforeach
              @endif
          </tbody>
          <tfoot>
            <tr id="tr-tot">
              <th>Total</th>
              @php
                $totalsemuah =[];
              @endphp
              @foreach ($pemasoks as $ko => $v)
                @php
                  $pj = 0;

                foreach ($expert as $kp => $vp){
                  $pj += $ttR[$kp][$ko];

                }
                @endphp
                <th class="total-data">{!! round($pj,3) !!}</th>
                @php
                  $totalsemuah[] = $pj;
                @endphp
              @endforeach
              @php
                $ts = array_sum($totalsemuah);
              @endphp
              <th>{!! round($ts,3) !!}</th>
            </tr>
            <tr>
              <th>Bobot Akhir</th>

              @php
                $tb =0 ;
                $la = 0;
                foreach ($pemasoks as $ksok => $vasok) {
                  $GLOBALS['bobotPemasokList'][$vasub->id][$la] = $totalsemuah[$la]/array_sum($totalsemuah);
                  $la++;
                }
                // dd($bobotPemasokList);
              @endphp
                @foreach ($totalsemuah as $ksem => $vsem)
                  @php
                    $tb += $vsem/$ts
                  @endphp
                  <th id="bobot-pemasok-{!! $vakris->id !!}-{!! $vasub->id !!}-{!! $ksem !!}">{!! round($vsem/$ts,3) !!}</th>
                @endforeach
                <th>{!! round($tb,3) !!}</th>
            </tr>
          </tfoot>
          </table>
      </div>
  </div>

@endforeach
