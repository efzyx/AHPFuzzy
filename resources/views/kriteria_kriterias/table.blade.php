<table class="table table-responsive" id="kriteriaKriterias-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Kriteria 1</th>
            <th>Nilai</th>
            <th>Kriteria 2</th>

            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php $num = 1 ?>
    @foreach($kriteriaKriterias as $kriteriaKriteria)
        <tr>
            <td>{!! $num++ !!}</td>
            <td>{!!$kriterias[$kriteriaKriteria->kriteria1_id] !!}</td>
            <td>{!! $kriteriaKriteria->nilai !!}</td>
            <td>{!! $kriterias[$kriteriaKriteria->kriteria2_id] !!}</td>
            <td>
                <div class='btn-group'>

                    <a href="{!! route('kriteriaKriterias.edit', [$kriteriaKriteria->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<hr>
<h4>Matriks</h4>
<div class="clearfix"></div>
<div class="box box-primary">
    <div class="box-body">
        <table class="table table-responsive" id="kriteriaKriterias-table">
            <thead style="font-weight: bold">
                <tr>
                    <td></td>
                    @foreach($kriteriaz as $kriteria)
                        <td>{!! $kriteria['nama_kriteria'] !!}</td>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($kriteriaz as $kriteria)
                    <tr>
                        <!--menampilkan nama kriteria (paling kiri)-->
                        <td><strong>{!! $kriteria['nama_kriteria'] !!}</strong></td>
                        <!--di sini menampilkan nilai-->
                        <?php $x = 0; ?>
                        @foreach($kriteriaz as $k)
                            <td>{{ round($dataKriteria[$expert->id][$kriteria->id][$x], 3) }}</td>
                            <?php $x = $x + 1; ?>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
