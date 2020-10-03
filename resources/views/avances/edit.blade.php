@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Avances
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($avances, ['route' => ['avances.update', $avances->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('avances.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection