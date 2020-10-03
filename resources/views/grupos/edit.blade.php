@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Grupo
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($grupo, ['route' => ['grupos.update', $grupo->id], 'method' => 'patch']) !!}

                        @include('grupos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection