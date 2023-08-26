

<div class="clearfix"></div>
<div class="box box-primary">
    <div class="box-body">
        <table class="table table-responsive" id="kriteriaKriterias-table">
            <thead style="font-weight: bold">
            <tr>
                <td></td>
                <td>M</td>
                <td>Bobot Lokal (w)</td>
                <td>Vektor Bobot (W) </td>
                <td>W/w</td>
            </tr>
            </thead>
            <tbody>
            @php $x = 0; @endphp
            @foreach($kriterias as $kriteria)
                <tr>
                    <!--menampilkan nama kriteria (paling kiri)-->
                    <td><strong>{!! $kriteria['nama_kriteria'] !!}</strong></td>
                    <!--di sini menampilkan nilai-->
                    <td>{!! round($vdata["mValue"][$x], 4) !!}</td>
                    <td>{!! round($vdata["bobotLokal"][$x], 4) !!}</td>
                    <td>{!! round($vdata["bobotVektor"][$x], 4) !!}</td>
                    <td>{!! round($vdata["Wperw"][$x], 4) !!}</td>
                    @php $x += 1; @endphp
                </tr>
            @endforeach
            </tbody>
        </table>
        <hr>
        <table class="table table-responsive">
            <thead>
                <th>&lambda; M</th>
                <th>CI</th>
                <th>RI</th>
                <th>CR</th>
                <th>Keterangan</th>
            </thead>
            <tr>
              @php
                $sumWpw = array_sum($vdata["Wperw"]);
                $lamb = $sumWpw/$countKri;
                $ci = (($sumWpw/$countKri)-$countKri)/($countKri-1);
                $ri = ri($countKri);
              @endphp
                <td>{!! round($lamb, 4) !!}</td>
                <td>{!! round($ci, 4) !!}</td>
                <td>{!! $ri !!}</td>
                <td>{!! $cr = round($ci/$ri, 4) !!}</td>
                <td>{!! $cr < 1 ? "<strong>Terpenuhi</strong>" : "<strong>Tidak Terpenuhi</strong>" !!}</td>
            </tr>
        </table>
    </div>
</div>
