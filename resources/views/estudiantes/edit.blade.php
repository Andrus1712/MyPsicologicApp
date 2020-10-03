@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Estudiantes
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($estudiantes, ['route' => ['estudiantes.update', $estudiantes->id], 'method' => 'patch']) !!}

                        @include('estudiantes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection