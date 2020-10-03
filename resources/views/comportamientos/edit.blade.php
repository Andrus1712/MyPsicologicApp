@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Comportamiento
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($comportamiento, ['route' => ['comportamientos.update', $comportamiento->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('comportamientos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection