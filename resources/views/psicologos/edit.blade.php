@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Psicologo
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($psicologo, ['route' => ['psicologos.update', $psicologo->id], 'method' => 'patch']) !!}

                        @include('psicologos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection