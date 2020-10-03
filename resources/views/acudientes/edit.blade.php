@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Acudientes
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($acudientes, ['route' => ['acudientes.update', $acudientes->id], 'method' => 'patch']) !!}

                        @include('acudientes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection