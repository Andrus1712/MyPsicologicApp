{{-- <!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $actividades->id }}</p>
</div>

<!-- Titulo Field -->
<div class="form-group">
    {!! Form::label('titulo', 'Titulo:') !!}
    <p>{{ $actividades->titulo }}</p>
</div>

<!-- Fecha Field -->
<div class="form-group">
    {!! Form::label('fecha', 'Fecha:') !!}
    <p>{{ $actividades->fecha }}</p>
</div>

<!-- Descripcion Field -->
<div class="form-group">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    <p>{{ $actividades->descripcion }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $actividades->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $actividades->updated_at }}</p>
</div> --}}

@foreach ($actividades as $item)

@if (isset($item->nombre_estudiante))


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