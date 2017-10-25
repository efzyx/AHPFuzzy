
@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Sub Kriteria Sub Kriteria
        </h1>
        <h1 class="pull-right">
          {!! Form::open(['route' => ['dSub', $kriteria->id], 'method' => 'delete']) !!}
          {!! Form::button('Delete All', ['type' => 'submit', 'class' => 'btn btn-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
          {!! Form::close() !!}
        </h1>
    </section>
    <div class="content">
      <div class="clearfix"></div>

      @include('flash::message')
      @php
        //dd($expert);
      @endphp
      <div class="clearfix"></div>
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

          @if($fullExpert)

              <div class="clearfix"></div>
              Semua Expert sudah mengisi perbandingan sub kriteria pada <b>{!! $kriteria->nama_kriteria!!}</b>!
              <div class="clearfix"></div>
          @else
            <div class="box-body">
              <br>
              {!! Form::open(['route' => ['kriterias.SubKriterias.create', $kriteria->id], 'method' => 'get']) !!}
                  {!! Form::button('Kembali', ['type' => 'submit', 'class' => 'btn btn-default']) !!}
              {!! Form::close() !!}
              <br>
                <div class="row">
                    {!! Form::open(['route' => 'subKriteriaSubKriterias.store']) !!}

                        @include('sub_kriteria_sub_kriterias.fields')

                    {!! Form::close() !!}
                </div>
            </div>
          @endif
        </div>
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
              @if (!empty(count($subKriteriaSubKriterias)))
                @include('sub_kriteria_sub_kriterias.table')
              @else
                Data Kosong.
              @endif

            </div>
        </div>
    </div>
@endsection
