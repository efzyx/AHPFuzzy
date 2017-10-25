<!-- Expert Id Field -->
<div class="form-group col-sm-12">
    <h3>Input Perbandingan Sub Kriteria oleh <b>{!! $expert->nama !!}</b> </h3>
    {!! Form::hidden('expert_id', $expert->id) !!}
</div>
<!-- Sub Kriteria1 Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('sub_kriteria1_id', 'Sub Kriteria1 Id:') !!}
    {!! Form::text('', $subKriteria1->nama_sub_kriteria, ['class' => 'form-control', 'disabled']) !!}
    {!! Form::hidden('sub_kriteria1_id', $subKriteria1->id) !!}
</div>

<!-- Nilai Field -->
<div class="form-group col-sm-3">
    {!! Form::label('nilai', 'Nilai:') !!}
    {!! Form::text('nilai', null, ['class' => 'form-control', 'autofocus']) !!}
</div>

<!-- Sub Kriteria2 Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('sub_kriteria2_id', 'Sub Kriteria2 Id:') !!}
    {!! Form::text('', $subKriteria2->nama_sub_kriteria, ['class' => 'form-control', 'disabled']) !!}
    {!! Form::hidden('sub_kriteria2_id', $subKriteria2->id) !!}
</div>


{!! Form::hidden('kriteria_id', $kriteria->id) !!}


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>
