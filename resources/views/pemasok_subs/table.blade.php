<table class="table table-responsive" id="pemasokSubs-table">
    <thead>
        <tr>
            <th>Pemasok1 Id</th>
        <th>Nilai</th>
        <th>Pemasok2 Id</th>
        <th>Kriteria Id</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($pemasokSubs as $pemasokSub)
        <tr>
            <td>{!! $pemasokSub->pemasok1_id !!}</td>
            <td>{!! $pemasokSub->nilai !!}</td>
            <td>{!! $pemasokSub->pemasok2_id !!}</td>
            <td>{!! $pemasokSub->kriteria_id !!}</td>
            <td>
                {!! Form::open(['route' => ['pemasokSubs.destroy', $pemasokSub->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('pemasokSubs.show', [$pemasokSub->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('pemasokSubs.edit', [$pemasokSub->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>