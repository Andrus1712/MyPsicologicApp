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
                        <h3 class="box-title">Donut Chart</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <canvas id="pieChart" style="height: 255px; width: 510px;" height="255" width="510"></canvas>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-6">

                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Bar Chart</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="barChart" style="height: 230px; width: 510px;" height="230" width="510"></canvas>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
    </div>
    @include('layouts.scripts')
    <script src="js/modelo_seguimiento/main.js"></script>
@endsection
