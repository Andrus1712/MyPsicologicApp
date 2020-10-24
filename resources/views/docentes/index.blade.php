@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1 class="pull-left">Docentes</h1>

    @if (Auth()->user()->havePermission('create.docentes'))

    <h1 class="pull-right">
        <a class="btn btn-success pull-right" style="margin-top: -10px;margin-bottom: 5px" id="add-docentes"><i
                class="fa fa-plus"></i> Agregar</a>
    </h1>
    @endif
    @include('docentes.create')
</section>
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-body">
            @include('docentes.table')
        </div>
    </div>
    <div class="text-center">

    </div>
</div>

@include('layouts.scripts')
<script src="js/docentes/main.js"></script>
@endsection