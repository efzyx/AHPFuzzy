<!-- Pemasok1 Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('pemasok1_id', 'Pemasok 2:') !!}
    {!! Form::text('', $pemasok1->nama_pemasok, ['class' => 'form-control', 'disabled']) !!}
    {!! Form::hidden('pemasok1_id', $pemasok1->id) !!}
</div>

<!-- Nilai Field -->
<div class="form-group col-sm-3">
    {!! Form::label('nilai', 'Nilai:') !!}
    {!! Form::text('nilai', null, ['class' => 'form-control', 'autofocus']) !!}
</div>

<!-- Pemasok2 Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('pemasok2_id', 'Pemasok 2:') !!}
    {!! Form::text('', $pemasok2->nama_pemasok, ['class' => 'form-control', 'disabled']) !!}
    {!! Form::hidden('pemasok2_id', $pemasok2->id) !!}
</div>

    {!! Form::hidden('kriteria_id', $subKriteria->kriteria_id) !!}

    {!! Form::hidden('expert_id', $expert->id) !!}

    {!! Form::hidden('sub_kriteria_id', $subKriteria->id)!!}

<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>
