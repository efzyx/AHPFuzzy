<table class="table table-responsive" id="pemasoks-table">
  @if (!empty(count($pemasoks)))
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Pemasok</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
      @php
        $no = 1;
        // dd($pemasoks);
      @endphp
    @foreach($pemasoks as $pemasok)
        <tr>
            <td>{!! $no++ !!}</td>
            <td>{!! $pemasok->nama_pemasok !!}</td>
            <td>
                {!! Form::open(['route' => ['pemasoks.destroy', $pemasok->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('pemasoks.edit', [$pemasok->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
  @else
    Data Kosong
  @endif
</table>
