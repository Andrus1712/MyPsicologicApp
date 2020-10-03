@extends('layouts.app')

@section('content')

<section class="content-header">
    <h1 class="pull-left">Actividades</h1>
    <h1 class="pull-right">
        <a class="btn btn-success pull-right" style="margin-top: -10px;margin-bottom: 5px" id="add-actividades"><i
                class="fa fa-plus"></i> Agregar</a>
    </h1>
    @include('actividades.create')
</section>

<div class="content">

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>



    <div class="box box-default box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Tabla de actividades</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
            <!-- /.box-tools -->
        </div>
        <div class="box-body">
            @include('actividades.table')
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default box-solid">
                <div class="box-header">
                    <h3>Calendario de actividades</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <div class="box-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>


    <div class="clearfix"></div>

    <div class="text-center">

    </div>
</div>

@include('layouts.scripts')
<script src="js/actividades/main.js"></script>



@endsection