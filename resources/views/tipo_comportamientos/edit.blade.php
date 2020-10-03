@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Tipo Comportamiento
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($tipoComportamiento, ['route' => ['tipoComportamientos.update', $tipoComportamiento->id], 'method' => 'patch']) !!}

                        @include('tipo_comportamientos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection