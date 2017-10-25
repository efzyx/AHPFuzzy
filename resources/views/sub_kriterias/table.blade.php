<table class="table table-responsive" id="subKriterias-table">
    <thead>
        <tr>
            <th>Kriteria Id</th>
        <th>Nama Sub Kriteria</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($subKriterias as $subKriteria)
        <tr>
            <td>{!! $subKriteria->kriteria_id !!}</td>
            <td>{!! $subKriteria->nama_sub_kriteria !!}</td>
            <td>
                {!! Form::open(['route' => ['subKriterias.destroy', $subKriteria->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    
                    <a href="{!! route('subKriterias.edit', [$subKriteria->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
