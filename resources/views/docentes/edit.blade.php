@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Docentes
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($docentes, ['route' => ['docentes.update', $docentes->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('docentes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection