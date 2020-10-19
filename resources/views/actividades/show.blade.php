@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Actividades
    </h1>
</section>
<div class="content">
    <div class="box box-primary">
        <div class="box-body">
            <div class="row" style="padding-left: 20px">
                @foreach ($actividades as $item)

                @if (isset($item->nombre_estudiante) || isset($item->nombre_acudiente))
                <div class="col-md-6">
                    <div class="box box-widget">
                        <div class="box-header">
                            <h3 class="box-title">Informacion de la actividad</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Estado</label>
                                @if ($item->estado == 0)
                                <p>En espera</p>
                                @elseif ($item->estado == 1)
                                <p>Cumplido</p>
                                @else
                                <p>Incumplido</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Fecha</label>
                                <p>{{$item->fecha}}</p>
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <p>{{$item->descripcion}}</p>
                            </div>
                        </div>
                    </div>


                    <div class="box box-widget">
                        <div class="box-header with-border">
                            <h3 class="box-title">Datos del Comportamiento</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Titulo de comportamiento</label>
                                <p>{{$item->titulo_comportamiento}}</p>
                            </div>
                            <div class="form-group">
                                <label>Descripcion</label>
                                <p>{{$item->descripcion_comportamiento}}</p>
                            </div>
                            <div class="form-group">
                                <label>Tipo de comportamiento</label>
                                <p>{{$item->titulo_tipo_comportamiento}}</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="box box-widget">
                        <div class="box-header with-border">
                            <h3 class="box-title">Datos del Estudiante</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Estudiante</label>
                                <p>{{$item->nombre_estudiante}} {{$item->apellido_estudiante}}</p>
                            </div>
                            <div class="form-group">
                                <label>teléfono</label>
                                <p>{{$item->telefono_estudiante}}</p>
                            </div>
                            <div class="form-group">
                                <label>Correo</label>
                                <p>{{$item->correo_estudiante}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="box box-widget">
                        <div class="box-header with-border">
                            <h3 class="box-title">Datos del Acudiente</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Acudiente</label>
                                <p>{{$item->nombre_acudiente}} {{$item->apellido_acudiente}}</p>
                            </div>
                            <div class="form-group">
                                <label>teléfono</label>
                                <p>{{$item->telefono_acudiente}}</p>
                            </div>
                            <div class="form-group">
                                <label>Correo</label>
                                <p>{{$item->correo_acudiente}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="col-md-6">
                    <div class="box box-widget">
                        <div class="box-header">
                            <h3 class="box-title">Informacion de la actividad</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Estado</label>
                                @if ($item->estado == 0)
                                <p>En espera</p>
                                @elseif ($item->estado == 1)
                                <p>Cumplido</p>
                                @else
                                <p>Incumplido</p>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Fecha</label>
                                <p>{{$item->fecha}}</p>
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <p>{{$item->descripcion}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box box-widget">
                        <div class="box-header with-border">
                            <h3 class="box-title">Datos del Comportamiento</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label>Titulo de comportamiento</label>
                                <p>{{$item->titulo_comportamiento}}</p>
                            </div>
                            <div class="form-group">
                                <label>Descripcion</label>
                                <p>{{$item->descripcion_comportamiento}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @endforeach
            </div>
            <a href="{{ route('actividades.index') }}" class="btn btn-default">Back</a>
        </div>
    </div>
</div>
@include('layouts.scripts')
@endsection