<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $grupo->id }}</p>
</div>

<!-- Nombre Field -->
<div class="form-group">
    {!! Form::label('nombre', 'Nombre:') !!}
    <p>{{ $grupo->nombre }}</p>
</div>

<!-- Curso Field -->
<div class="form-group">
    {!! Form::label('curso', 'Curso:') !!}
    <p>{{ $grupo->curso }}</p>
</div>

<!-- Docente Id Field -->
<div class="form-group">
    {!! Form::label('docente_id', 'Docente Id:') !!}
    <p>{{ $grupo->docente_id }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $grupo->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $grupo->updated_at }}</p>
</div>

