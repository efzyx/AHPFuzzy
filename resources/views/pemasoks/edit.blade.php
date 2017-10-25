@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Pemasok
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($pemasok, ['route' => ['pemasoks.update', $pemasok->id], 'method' => 'patch']) !!}

                        @include('pemasoks.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection