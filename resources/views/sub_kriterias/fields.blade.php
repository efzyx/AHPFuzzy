
    {!! Form::hidden('kriteria_id', $kriteria->id )!!}

<!-- Nama Sub Kriteria Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nama_sub_kriteria', 'Nama Sub Kriteria:') !!}
    {!! Form::text('nama_sub_kriteria', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>
