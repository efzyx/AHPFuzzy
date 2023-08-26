@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Sub Kriteria Form for {!! $kriteria->nama_kriteria !!}
        </h1>
    </section>
    <div class="content">
      <div class="clearfix"></div>

      @include('flash::message')
      <h1 class="pull-right">
        {!! Form::open(['route' => ['CreateSubKriteriaSubKriteria', $kriteria->id], 'method' => 'get']) !!}
            {!! Form::button('Perbandingan Sub Kriteria', ['type' => 'submit', 'class' => 'btn btn-primary pull-right']) !!}
        {!! Form::close() !!}
         </h1>
      <div class="clearfix"></div>
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'subKriterias.store']) !!}

                        @include('sub_kriterias.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <section class="content-header">
            <h1>
                Sub Kriteria Lists for {!! $kriteria->nama_kriteria !!}
            </h1>
        </section>
        <div class="box box-primary">
            <div class="box-body">
              @if (count($subKriterias)>0)
                <table class="table table-responsive" id="subKriterias-table">
                    <thead>
                        <tr>
                            <th>#</th>
                        <th>Nama Sub Kriteria</th>
                            <th colspan="3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                      $no = 1;
                    @endphp
                    @foreach($subKriterias as $subKriteria)
                        <tr>
                            <td>{!! $no++ !!}</td>
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
              @else
                  <div class="clearfix">Empty</div>
              @endif
            </div>
            <div class="clearfix"></div>
            <div class="form-group col-sm-12">
              <a href="{!! route('kriterias.index') !!}" class="btn btn-default">Back</a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
@endsection
