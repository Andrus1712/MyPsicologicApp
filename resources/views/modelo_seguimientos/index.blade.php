@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Modelo Seguimientos</h1>
        <h1 class="pull-right">
            <a class="btn btn-success pull-right" style="margin-top: -10px;margin-bottom: 5px" id="add-seguiento"><i
                    class="fa fa-plus"></i> Agregar</a>
        </h1>
        @include('modelo_seguimientos.create')
    </section>
    <div class="content">
        {{-- <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div> --}}

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        @include('modelo_seguimientos.table')
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">

                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Estados de los casos</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">

                            <div class="col-md-12">
                                <label>Fecha del registro: </label>
                                <div id="reportrange1"
                                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                            </div>

                        </div>

                        <h4 id="not-chart1"></h4>

                        <div id="chartEstamento"></div>

                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-6">

                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Clasificacion de los casos</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">

                        <div class="row">
                            <div class="col-md-12">
                                <label>Fecha del registro: </label>
                                <div id="reportrange2"
                                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                            </div>
                        </div>

                        <h4 id="not-chart2"></h4>

                        <div id="chartClasificacion"></div>

                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
    </div>

    @include('layouts.scripts')
    @include('layouts.datatables_js')
    <script src="js/modelo_seguimiento/main.js"></script>
@endsection
