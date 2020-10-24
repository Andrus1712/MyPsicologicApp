@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1 class="pull-left">Estudiantes</h1>

    @if (Auth()->user()->havePermission('create.estudiantes'))

    <h1 class="pull-right">
        <a class="btn btn-success pull-right" style="margin-top: -10px;margin-bottom: 5px" id="add-estudiante"><i
                class="fa fa-plus"></i> Agregar</a>
    </h1>
    @endif
    @include('estudiantes.create')
</section>
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-body">
            @include('estudiantes.table')
        </div>
    </div>
    <div class="text-center">

    </div>
</div>

@include('layouts.scripts')
<script src="js/estudiantes/main.js"></script>
@endsection