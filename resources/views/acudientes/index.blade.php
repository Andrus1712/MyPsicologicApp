@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="assets/DataTables/DataTables-1.10.22/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<section class="content-header">
    <h1 class="pull-left">Acudientes</h1>
    @if (Auth()->user()->havePermission('create.acudientes'))
    <h1 class="pull-right">
        <a class="btn btn-success pull-right" style="margin-top: -10px;margin-bottom: 5px" id="add-acudiente"><i
                class="fa fa-plus"></i> Agregar</a>
    </h1>
    @endif
    @include('acudientes.create')
</section>
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>

    <div class="box box-primary">
        <div class="box-body">
            @include('acudientes.table')
        </div>
    </div>


    <div class="text-center">

    </div>
</div>
@include('layouts.scripts')
<script src="js/acudientes/main.js"></script>
@endsection