

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
            @php $x = 0;
              $kri = $subKriterias->where('kriteria_id','=',$valk->id);
            @endphp
            @foreach($kri as $ksub)
                <tr>
                    <!--menampilkan nama kriteria (paling kiri)-->
                    <td><strong>{!! $ksub->nama_sub_kriteria !!}</strong></td>
                    <!--di sini menampilkan nilai-->
                    <td>{!! round($vdat["mValue"][$x], 4) !!}</td>
                    <td>{!! round($vdat["bobotLokal"][$x], 4) !!}</td>
                    <td>{!! round($vdat["bobotVektor"][$x], 4) !!}</td>
                    <td>{!! round($vdat["Wperw"][$x], 4) !!}</td>
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
              $countSub = $kri->count();
                $sumWpw = array_sum($vdat["Wperw"]);
                $lamb = $sumWpw/$countSub;
                $ci = (($sumWpw/$countSub)-$countSub)/($countSub-1 > 0 ? $countSub-1 : 1);
                $ri = ri($countSub);
              @endphp
                <td>{!! round($lamb, 4) !!}</td>
                <td>{!! round($ci, 4) !!}</td>
                <td>{!! $ri !!}</td>
                <td>{!! $cr = round($ri >0 ?$ci/$ri : 0, 4) !!}</td>
                <td>{!! $cr < 1 ? "<strong>Terpenuhi</strong>" : "<strong>Tidak Terpenuhi</strong>" !!}</td>
            </tr>
        </table>
    </div>
</div>
