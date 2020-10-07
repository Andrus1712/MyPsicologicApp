<!-- Fecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha', 'Fecha:') !!}
    {!! Form::date('fecha', null, ['class' => 'form-control','id'=>'fecha']) !!}
</div>



<!-- Nombre Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
</div>

<!-- Estamento Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estamento', 'Estamento:') !!}
    {!! Form::select('estamento', ['aa', 'parra chacon'], null, ['class' => 'form-control']) !!}
</div>

<!-- Medio Comunicacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('medio_comunicacion', 'Medio Comunicacion:') !!}
    {!! Form::select('medio_comunicacion', [''], null, ['class' => 'form-control']) !!}
</div>

<!-- Clasificacion Caso Presentado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('clasificacion_caso_presentado', 'Clasificacion Caso Presentado:') !!}
    {!! Form::select('clasificacion_caso_presentado', [''], null, ['class' => 'form-control']) !!}
</div>

<!-- Descripcion Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::textarea('descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Remitido Field -->
<div class="form-group col-sm-6">
    {!! Form::label('remitido', 'Remitido:') !!}
    {!! Form::text('remitido', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::select('estado', [''], null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('modeloSeguimientos.index') }}" class="btn btn-default">Cancel</a>
</div>
