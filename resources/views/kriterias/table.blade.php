<table class="table table-responsive" id="kriterias-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Kriteria</th>
            <th></th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php $num = 1 ?>
    @foreach($kriterias as $kriteria)
        <tr>
            <td>{!! $num++ !!}</td>
            <td>{!! $kriteria->nama_kriteria !!}</td>
            <td>
            {!! Form::open(['route' => ['kriterias.SubKriterias.create', $kriteria->id], 'method' => 'get']) !!}
                {!! Form::button('Sub Kriteria', ['type' => 'submit', 'class' => 'btn btn-primary btn-xs']) !!}
            {!! Form::close() !!}
            </td>

            <td>
                {!! Form::open(['route' => ['kriterias.destroy', $kriteria->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('kriterias.edit', [$kriteria->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
