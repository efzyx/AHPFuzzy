

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
            @foreach($pemasoks as $pem)
                <tr>
                    <!--menampilkan nama kriteria (paling kiri)-->
                    <td><strong>{!! $pem->nama_pemasok!!}</strong></td>
                    <!--di sini menampilkan nilai-->
                    <td>{!! round($value["mValue"][$x], 4) !!}</td>
                    <td>{!! round($value["bobotLokal"][$x], 4) !!}</td>
                    <td>{!! round($value["bobotVektor"][$x], 4) !!}</td>
                    <td>{!! round($value["Wperw"][$x], 4) !!}</td>
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
                $sumWpw = array_sum($value["Wperw"]);
                $lamb = $sumWpw/$pemasoks->count();
                $ci = (($sumWpw/$pemasoks->count())-$pemasoks->count())/($pemasoks->count()-1);
                $ri = ri($pemasoks->count());
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
