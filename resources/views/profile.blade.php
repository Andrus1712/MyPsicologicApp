@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1 class="pull-left">Profile</h1>
</section>


<div class="content">
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="../img/perfil.png"
                        alt="User profile picture">
                    {{-- <img src="../img/perfil.png" style="background-color: #fff;" class="img-circle" alt="User Image" /> --}}

                    <h3 class="profile-username text-center">{{$datos['nombre']}}</h3>

                    <p class="text-muted text-center">
                        @foreach ($datos['rol'] as $rol)
                        {{$rol}}
                        @endforeach
                    </p>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <div class="clearfix"></div>

            <!-- About Me Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">About Me</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <strong><i class="fa fa-book margin-r-5"></i> Descripcion</strong>

                    <p class="text-muted">
                        @foreach ($datos['descripcion'] as $des)
                        {{$des}}
                        @endforeach
                    </p>

                    <hr>

                    <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                    <p class="text-muted">
                        @foreach ($datos['direccion'] as $dir)
                        {{$dir}}
                        @endforeach
                    </p>

                    <hr>

                    <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

                    <p>
                        <span class="label label-danger">UI Design</span>
                        <span class="label label-success">Coding</span>
                        <span class="label label-info">Javascript</span>
                        <span class="label label-warning">PHP</span>
                        <span class="label label-primary">Node.js</span>
                    </p>

                    <hr>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-body">
                    
                    @if (count(Auth::user()->notifications)>0)
                        <li class="header">Notificaciones</li>
                    
                        <li>
                        @foreach (Auth::user()->notifications as $key => $notification)
                        <!-- inner menu: contains the actual data -->
                        <ul class="menu">
                            <li>
                                <a href="/actividades/{{$notification->data['id']}}">
                                    <i class="mr-3 pull-left fa fa-calendar text-red"></i>
                                   {{ $notification->data['titulo'] }}
        
                                    <small class="ml-3 pull-right">{{ $notification->created_at->diffForHumans() }}</small>
                                </a>
                            </li>
                        </ul>

                    
                    <!-- ------------------------------------ -->
                    @endforeach
                    @else
                    <p class="header">Sin Notificaciones</p>
                    @endif
                    </li>
                    
                    
                </div>
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
    </div>

</div>
@include('layouts.scripts')
@endsection