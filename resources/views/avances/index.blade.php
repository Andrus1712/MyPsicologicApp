@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Avances</h1>
        <h1 class="pull-right">
            <a class="btn btn-success pull-right" style="margin-top: -10px;margin-bottom: 5px" id="add-avance"><i class="fa fa-plus"></i> Agregar</a>
        </h1>
        @include('avances.create')
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('avances.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>

    @include('layouts.scripts')
    <script src="js/avances/main.js"></script>
@endsection

