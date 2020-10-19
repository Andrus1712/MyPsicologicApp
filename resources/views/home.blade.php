@extends('layouts.app')

@section('content')

<section class="content">

    <div class="row">
        <div class="col-md-12">
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
    </div>

    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3 id="act-total"></h3>

                    <p>Actividades Totales</p>
                </div>
                <div class="icon">
                    <i class="ion ion-android-calendar"></i>
                </div>
                <a href="/actividades" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
                <a href="/actividades" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
                <a href="/actividades" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
                <a href="/actividades" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>

    <div class="modal fade" id="modal-home" tabindex="-1" role="basic" data-backdrop="static"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">            
            </div>
        </div>
    </div>


</section>
@include('layouts.scripts')
<script src="js/home/main.js"></script>

@endsection