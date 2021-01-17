@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Comportamientos</h1>

        @if (auth()
            ->user()
            ->havePermission('create.comportamientos'))

            <h1 class="pull-right">
                <a class="btn btn-success pull-right" style="margin-top: -10px;margin-bottom: 5px"
                    id="add-comportamientos"><i class="fa fa-plus"></i> Agregar</a>
            </h1>
        @endif
        @include('comportamientos.create')
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Tabla de comportamientos</h3>
            </div>
            <div class="box-body">
                @include('comportamientos.table')
            </div>
        </div>

        @if (Auth()
            ->user()
            ->havePermission('make.reportes'))
            <a class="btn bg-red" id="make-reporte" target="_blank">
                Exportar a PDF <i class="fa fa-file-pdf"></i></a>
        @endif

        @if (Auth()->user()->hasRole('psi-user') || Auth()->user()->hasRole('admin-user'))
        <a class="btn bg-green" id="import-data" target="_blank">
            Importar datos <i class="fa fa-file-excel-o"></i></a>
        @endif
        {{-- <div class="text-center">
            <h2>Lorem</h2>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam architecto eaque quos, dolorum assumenda
                debitis, incidunt vero quod laudantium rem saepe dicta? Ut accusamus aspernatur quas architecto neque labore
                magnam.
            </p>
        </div> --}}
    </div>


    @include('layouts.scripts')
    <script src="js/comportamientos/main.js"></script>
@endsection
