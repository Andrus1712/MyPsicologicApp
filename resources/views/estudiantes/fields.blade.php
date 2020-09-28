<!-- Tipoidentificacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tipoIdentificacion', 'Tipoidentificacion:') !!}
    {!! Form::select('tipoIdentificacion', ['TI' => 'TI', 'CC' => 'CC', 'RC' => 'RC', 'CE' => 'CE', 'PA' => 'PA'], null, ['class' => 'form-control']) !!}
</div>

<!-- Identificacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('identificacion', 'Identificacion:') !!}
    {!! Form::text('identificacion', null, ['class' => 'form-control']) !!}
</div>

<!-- Nombres Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombres', 'Nombres:') !!}
    {!! Form::text('nombres', null, ['class' => 'form-control']) !!}
</div>

<!-- Apellidos Field -->
<div class="form-group col-sm-6">
    {!! Form::label('apellidos', 'Apellidos:') !!}
    {!! Form::text('apellidos', null, ['class' => 'form-control']) !!}
</div>

<!-- Correo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('correo', 'Correo:') !!}
    {!! Form::email('correo', null, ['class' => 'form-control']) !!}
</div>

<!-- Fechanacimiento Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fechaNacimiento', 'Fechanacimiento:') !!}
    {!! Form::date('fechaNacimiento', null, ['class' => 'form-control','id'=>'fechaNacimiento']) !!}
</div>


<!-- Grado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('grado', 'Grado:') !!}
    {!! Form::text('grado', null, ['class' => 'form-control']) !!}
</div>

<!-- Telefono Field -->
<div class="form-group col-sm-6">
    {!! Form::label('telefono', 'Telefono:') !!}
    {!! Form::text('telefono', null, ['class' => 'form-control']) !!}
</div>

<!-- Sexo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sexo', 'Sexo:') !!}
    {!! Form::select('sexo', ['Masculino' => 'Masculino', 'Femenino' => 'Femenino', 'Otro' => 'Otro'], null, ['class' => 'form-control']) !!}
</div>

<!-- Actaaprobacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('actaAprobacion', 'Acta de aprobacion:') !!}
    {!! Form::file('actaAprobacion') !!}
</div>
<div class="clearfix"></div>

<!-- Acudiente Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('acudiente_name', 'Nombre del acudiente:') !!}
    {!! Form::select('acudiente_name', $acudienteItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('estudiantes.index') }}" class="btn btn-default">Cancel</a>
</div>
