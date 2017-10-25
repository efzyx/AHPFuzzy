@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Pemasok Sub
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($pemasokSub, ['route' => ['pemasokSubs.update', $pemasokSub->id], 'method' => 'patch']) !!}

                        @include('pemasok_subs.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection