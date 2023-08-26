@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Kriteria Kriteria
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($kriteriaKriteria, ['route' => ['kriteriaKriterias.update', $kriteriaKriteria->id], 'method' => 'patch']) !!}

                        @include('kriteria_kriterias.fields')

                   {!! Form::close() !!}

                   <div class="form-group col-sm-12">
                     {!! Form::open(['route' => ['CreateKriteriaKriteria', $expert->id], 'method' => 'get']) !!}
                         {!! Form::button('Cancel', ['type' => 'submit', 'class' => 'btn btn-default']) !!}
                     {!! Form::close() !!}
                   </div>

               </div>
           </div>
       </div>
   </div>
@endsection
