@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Tipo Comportamientos</h1>
        <h1 class="pull-right">
            <a class="btn btn-success pull-right" style="margin-top: -10px;margin-bottom: 5px" id="add-tipo_c"><i class="fa fa-plus"></i> Agregar</a>
        </h1>
        @include('tipo_comportamientos.create')
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('tipo_comportamientos.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
    
    @include('layouts.scripts')
    <script src="js/tipoComportamientos/main.js"></script>
@endsection


