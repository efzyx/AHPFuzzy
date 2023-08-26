<!-- Nama Pemasok Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nama_pemasok', 'Nama Pemasok:') !!}
    {!! Form::text('nama_pemasok', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('pemasoks.index') !!}" class="btn btn-default">Cancel</a>
</div>
