@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Perbandingan Kriteria <strong>{!! $expert->nama !!}</strong>
        </h1>
        <h1 class="pull-right">
          {!! Form::open(['route' => ['dKri', $expert->id], 'method' => 'delete']) !!}
          {!! Form::button('Delete All', ['type' => 'submit', 'class' => 'btn btn-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
          {!! Form::close() !!}
        </h1>
    </section>
    <div class="content">
      <div class="clearfix"></div>

      @include('flash::message')

      <div class="clearfix"></div>

        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
              <h1 class="pull-left">
                 <a class="btn btn-default pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('experts.index') !!}">Kembali</a>
              </h1>
              @if(!$full)
                <div class="row">

                    {!! Form::open(['route' => 'kriteriaKriterias.store']) !!}

                        @include('kriteria_kriterias.fields')

                    {!! Form::close() !!}
                </div>
                    @else

                    <div class="clearfix"></div>

                    Perbandingan sudah selesai!

                    <div class="clearfix"></div>

                    @endif
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
              @if (!empty(count($kriteriaKriterias)))
                @include('kriteria_kriterias.table')
              @else
                Data Kosong
              @endif
            </div>
        </div>
    </div>
@endsection
