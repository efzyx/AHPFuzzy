

<div class="clearfix"></div>
<div class="box box-primary">
    <div class="box-body">
        <table class="table table-responsive" id="Kriteria-table">
            <thead style="font-weight: bold">
            <tr>
                <td></td>
                @foreach($expert as $e)
                  <td>{!! $e->nama !!}</td>
                @endforeach
                <td>Total</td>
                <td>Bobot Akhir</td>
            </tr>
            </thead>
            <tbody>
            @php
            $x = 0;
            $tot = [];
            $totot = 0;
            $tArr = [];
            @endphp
            @foreach($kriterias as $kriteria)

                <tr class="row-data">
                    <!--menampilkan nama kriteria (paling kiri)-->
                    <td><strong>{!! $kriteria['nama_kriteria'] !!}</strong></td>
                    @php

                    @endphp
                    <!--di sini menampilkan nilai-->
                    @foreach ($arr as $key => $value)
                      <td>{!! round(min($value["vektor"][$x]), 3) !!}</td>
                      @php
                        $tot[$x][$key] =  min($value["vektor"][$x]);
                      @endphp
                    @endforeach
                    <td>{!! $t = round(array_sum($tot[$x]),3) !!}</td>
                    @php
                      $x += 1;
                      $tArr[] = $t;
                      $totot += $t;
                    @endphp
                </tr>
            @endforeach
            @foreach ($tArr as $key => $value)
              <div class="TA" style="display: none">
                {!! $value !!}
              </div>
            @endforeach
            </tbody>
            <tfoot>
              <tr id="total">
                <th colspan="{!! $expert->count()+1 !!}">Total</th>
                <th>{!! $totot !!}</th>
              </tr>
            </tfoot>
            @php
              foreach ($kriterias as $kkk => $vkk) {
                $GLOBALS['bobotKriteriaList'][$vkk->id] = $tArr[$kkk]/array_sum($tArr);
              }
              // var_dump($bobotKriteriaList)
            @endphp
        </table>
    </div>
</div>

  <script type="text/javascript">
    var rd = document.getElementsByClassName('row-data');
    var tArr = {!! json_encode($tArr) !!}
    var totalA = 0;
    var total = {!! array_sum($tArr) !!}
    for (var r in rd) {
      if (rd.hasOwnProperty(r)) {
        bar = rd[r];
        var newEl = document.createElement("td");
        newEl.setAttribute("id", "kri-"+r)
        var isi = (tArr[r]/total);
        newEl.innerHTML = isi.toPrecision(3);
        bar.appendChild(newEl);
        totalA += isi;
      }
    }
    var tro = document.getElementById('total');
    var newEl = document.createElement('th');
    newEl.innerHTML = totalA;
    tro.appendChild(newEl)

  </script>
