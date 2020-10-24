@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1 class="pull-left">Usuarios</h1>
    
    @if (Auth()->user()->havePermission('create.user'))
    <h1 class="pull-right">
        <a class="btn btn-success pull-right" style="margin-top: -10px;margin-bottom: 5px" id="add-user"><i
                class="fa fa-plus"></i> Agregar</a>
    </h1>
    @endif
    @include('usuarios.create')
</section>
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    @include('usuarios.table')
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">

    </div>
</div>
@include('layouts.scripts')
<script src="js/usuarios/main.js"></script>
@endsection