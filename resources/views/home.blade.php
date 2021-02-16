@extends('layouts.app')

@section('content')
    <style>
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 360px;
            max-width: 800px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #EBEBEB;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }

    </style>

    <section class="content">

        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3 id="act-total"></h3>

                        <p>Actividades totales</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-calendar"></i>
                    </div>
                    <a href="/actividades" class="small-box-footer">Más <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 id="act-cumplidas"><sup style="font-size: 20px"></sup></h3>

                        <p>Actividades cumplidas</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-checkbox"></i>
                    </div>
                    <a href="/actividades" class="small-box-footer">Más <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3 id="act-espera"></h3>

                        <p>Actividades en espera</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-alarm-clock"></i>
                    </div>
                    <a href="/actividades" class="small-box-footer">Más <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3 id="act-incumplidas"></h3>

                        <p>Actividades incumplidas</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-android-alert"></i>
                    </div>
                    <a href="/actividades" class="small-box-footer">Más <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>


        @if (Auth()->user()->havePermission('show.comportamientos'))
        <div class="row">
            <div id="calendario_id" class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3>Calendario de actividades</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <div class="box-body">
                        <div id="calendar_home"></div>
                    </div>
                </div>
            </div>
            <div id="grafico_id" class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header">
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <div class="box-body">
                        <figure class="highcharts-figure">
                            <div id="container"></div>
                            <p class="highcharts-description">
                                Esta gráfica muestra los comportamientos ingresados al sistema clasificados por meses. 
                            </p>
                        </figure>
                    </div>
                </div>
            </div>
        </div>    
        @else
        <div class="row">
            <div id="calendario_id" class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3>Calendario de actividades</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <div class="box-body">
                        <div id="calendar_home"></div>
                    </div>
                </div>
            </div>
        @endif



        <div class="modal fade" id="modal-home" tabindex="-1" role="basic" data-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-avances" tabindex="-1" role="basic" data-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                </div>
            </div>
        </div>

    </section>
    @include('layouts.scripts')
    <script src="js/home/main.js"></script>

@endsection
