@extends('layouts.app')

@section('content')

<section class="content-header">
    <h1 class="pull-left">Actividades</h1>
    <h1 class="pull-right">

        @can('Psicoorientador')
        <div class="row">
            <div class="col-md-6">
                <div class="btn-group" style="margin-bottom: 10px;">
                    <a class="btn bg-olive margin" style="margin-top: -10px;margin-bottom: 5px" id="add-actividades"><i
                            class="fa fa-plus"></i> Agregar Actividad</a>
                </div>

            </div>
            <div class="col-md-6">
                <div class="btn-group">
                    <a class="btn bg-info margin" style="margin-top: -10px;margin-bottom: 5px" id="reprogramar"><i
                            class="fa fa-clock"></i> Reprogramar cita</a>
                </div>

            </div>
        </div>
        @endcan

    </h1>
    @include('actividades.create')
</section>

<div class="content">

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>


    <div class="row">
        <div class="col-md-12">
            <div class="box box-default" style="border-top-color: #605ca8;">
                <div class="box-header with-border">
                    <h3 class="box-title">Tabla de actividades</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <div class="box-body">
                    @include('actividades.table')
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default" style="border-top-color: #605ca8;">
                <div class="box-header with-border">
                    <h3 class="box-title">Calendario de actividades</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <div class="box-body">
                    <div id="calendar" class="fc fc-unthemed fc-ltr"></div>
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