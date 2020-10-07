@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Modelo Seguimiento
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($modeloSeguimiento, ['route' => ['modeloSeguimientos.update', $modeloSeguimiento->id], 'method' => 'patch']) !!}

                        @include('modelo_seguimientos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection