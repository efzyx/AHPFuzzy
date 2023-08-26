@extends('layouts.app')

@section('content')
    <section class="content-header">
      @if($selectedKri != null && $selectedSub !=null)
        <h1>
            Input perbandingan untuk <strong>{!! $selectedSub->nama_sub_kriteria !!} ({!! $selectedKri->nama_kriteria !!})</strong> oleh <strong>{!! $expert->nama !!}</strong>
        </h1>
      @endif
      <h1 class="pull-right">
        {!! Form::open(['route' => ['dPSub', $expert->id], 'method' => 'delete']) !!}
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
                <div class="row">
                  @if($pemasok1 != null && $pemasok2 != null)
                    {!! Form::open(['route' => 'pemasokSubs.store']) !!}

                        @include('pemasok_subs.fields')

                    {!! Form::close() !!}
                  @else
                    <strong>Perbandingan sudah terpenuhi!</strong>
                  @endif
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="box box-primary">
                <div class="box-body">
                        @include('pemasok_subs.table2')
                </div>
            </div>
        </div>
    </div>
@endsection
