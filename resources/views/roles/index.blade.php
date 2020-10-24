@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1 class="pull-left">Roles</h1>

    @if (Auth()->user()->havePermission('create.roles'))
    <h1 class="pull-right">
        <a class="btn btn-success pull-right" style="margin-top: -10px;margin-bottom: 5px" id="add-roles"><i
                class="fa fa-plus"></i> Agregar</a>
    </h1>
    @endif
    @include('roles.create')
</section>
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="table">
                        <table class="table table-bordered table-hover" id="roles-table">

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="text-center">

    </div>
</div>
@include('layouts.scripts')
<script src="js/roles/main.js"></script>
@endsection