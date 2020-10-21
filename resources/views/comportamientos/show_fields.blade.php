{{-- <!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $comportamiento[0]->id }}</p>
</div> --}}

<!-- Tipo Id Field -->
{{-- <div class="form-group">
    {!! Form::label('tipo_id', 'Tipo Id:') !!}
    @foreach ($comportamiento as $item)

    <p>{{ $item->titulo }}</p>
@endforeach
</div> --}}

{{-- <!-- Estudiante Id Field -->
<div class="form-group">
    {!! Form::label('estudiante_id', 'Estudiante Id:') !!}
    <p>{{ $comportamiento->estudiante_id }}</p>
</div>

<!-- Descripcion Field -->
<div class="form-group">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    <p>{{ $comportamiento->descripcion }}</p>
</div>

<!-- Titulo Field -->
<div class="form-group">
    {!! Form::label('titulo', 'Titulo:') !!}
    <p>{{ $comportamiento->titulo }}</p>
</div>

<!-- Fecha Field -->
<div class="form-group">
    {!! Form::label('fecha', 'Fecha:') !!}
    <p>{{ $comportamiento->fecha }}</p>
</div>

<!-- Emisor Field -->
<div class="form-group">
    {!! Form::label('emisor', 'Emisor:') !!}
    <p>{{ $comportamiento->emisor }}</p>
</div>

<!-- Multimedia Field -->
<div class="form-group">
    {!! Form::label('multimedia', 'Multimedia:') !!}
    <p>{{ $comportamiento->multimedia }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $comportamiento->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $comportamiento->updated_at }}</p>
</div> --}}

@foreach ($comportamiento as $item)
<div class="row">

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('titulo', 'Titulo:') !!}
            <p>{{ $item->titulo }}</p>
        </div>
        <div class="form-group">
            {!! Form::label('descripcion', 'Descripcion:') !!}
            <p>{{ $item->descripcion }}</p>
        </div>

        <div class="form-group">
            {!! Form::label('fecha', 'Fecha:') !!}
            <p>{{ $item->fecha }}</p>
        </div>

        <div class="form-group">
            {!! Form::label('emisor', 'Emisor:') !!}
            <p>{{ json_decode($item->emisor)->email }}</p>
        </div>

    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('estudiante', 'Estudiante:') !!}
            <p>{{ $item->nombres }} {{ $item->apellidos }}</p>
        </div>

        <div class="form-group">
            {!! Form::label('grupo', 'Grupo:') !!}
            <p>{{ $item->grado }} {{ $item->curso }}</p>
        </div>

        <div class="form-group">
            {!! Form::label('acudiente', 'Acudiente:') !!}
            <p>{{ $item->nombre_acudiente }} {{ $item->apellido_acudiente }}</p>
        </div>

        <div class="form-group">
            {!! Form::label('multimedia', 'Multimedia:') !!}
            @if ($item->multimedia != null)

            <div>
                <input id="ruta_archivo" type="hidden" name="" value="{{ $item->multimedia }}">
                <a class="btn btn-default" id="showfile">
                    <i class="fa fa-file"></i>
                </a>
            </div>
            @else
            <p>Sin Archivos</p>
            @endif
        </div>

    </div>
</div>

@endforeach

