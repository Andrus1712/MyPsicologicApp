<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $acudientes->id }}</p>
</div>

<!-- Tipoidentificacion Field -->
<div class="form-group">
    {!! Form::label('tipoIdentificacion', 'Tipoidentificacion:') !!}
    <p>{{ $acudientes->tipoIdentificacion }}</p>
</div>

<!-- Identificacion Field -->
<div class="form-group">
    {!! Form::label('identificacion', 'Identificacion:') !!}
    <p>{{ $acudientes->identificacion }}</p>
</div>

<!-- Nombres Field -->
<div class="form-group">
    {!! Form::label('nombres', 'Nombres:') !!}
    <p>{{ $acudientes->nombres }}</p>
</div>

<!-- Apellidos Field -->
<div class="form-group">
    {!! Form::label('apellidos', 'Apellidos:') !!}
    <p>{{ $acudientes->apellidos }}</p>
</div>

<!-- Correo Field -->
<div class="form-group">
    {!! Form::label('correo', 'Correo:') !!}
    <p>{{ $acudientes->correo }}</p>
</div>

<!-- Fechanacimiento Field -->
<div class="form-group">
    {!! Form::label('fechaNacimiento', 'Fechanacimiento:') !!}
    <p>{{ $acudientes->fechaNacimiento }}</p>
</div>

<!-- Telefono Field -->
<div class="form-group">
    {!! Form::label('telefono', 'Telefono:') !!}
    <p>{{ $acudientes->telefono }}</p>
</div>

<!-- Direccion Field -->
<div class="form-group">
    {!! Form::label('direccion', 'Direccion:') !!}
    <p>{{ $acudientes->direccion }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $acudientes->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $acudientes->updated_at }}</p>
</div>

