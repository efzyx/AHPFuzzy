@extends('layouts.app')
{!! dd($kriterias)!!}
@section('content')
    <section class="content-header">
        <h1 class="pull-left">Kriterias</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('kriterias.create') !!}">Add New</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
              <table class="table table-responsive" id="kriterias-table">
                  <thead>
                      <tr>
                          <th>Nama Kriteria</th>
                          <th></th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>
                  @foreach($kriterias as $kriteria)
                      <tr>
                          <td>{!! $kriteria->nama_kriteria !!}</td>
                          <td>
                          {!! Form::open(['route' => ['CreateSubKriteriaSubKriteria', [$expert->id, $kriteria->id]], 'method' => 'get']) !!}
                              {!! Form::button('Input Perbandingan', ['type' => 'submit', 'class' => 'btn btn-primary btn-xs']) !!}
                          {!! Form::close() !!}
                          </td>
                      </tr>
                  @endforeach
                  </tbody>
              </table>

            </div>
        </div>
    </div>
@endsection
