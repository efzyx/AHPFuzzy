<!-- Nama Kriteria Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nama_kriteria', 'Nama Kriteria:') !!}
    {!! Form::text('nama_kriteria', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('kriterias.index') !!}" class="btn btn-default">Cancel</a>
</div>
