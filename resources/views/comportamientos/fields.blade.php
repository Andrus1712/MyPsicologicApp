<!-- Tipo Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tipo_id', 'Tipo Id:') !!}
    {!! Form::select('tipo_id', $tipo_comportamientoItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Estudiante Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estudiante_id', 'Estudiante Id:') !!}
    {!! Form::select('estudiante_id', $estudianteItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Descripcion Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::textarea('descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Titulo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('titulo', 'Titulo:') !!}
    {!! Form::text('titulo', null, ['class' => 'form-control']) !!}
</div>

<!-- Fecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha', 'Fecha:') !!}
    {!! Form::date('fecha', null, ['class' => 'form-control','id'=>'fecha']) !!}
</div>

@section('scripts')
    <script type="text/javascript">
        $('#fecha').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: false
        })
    </script>
@endsection

<!-- Emisor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('emisor', 'Emisor:') !!}
    {!! Form::text('emisor', null, ['class' => 'form-control']) !!}
</div>

<!-- Multimedia Field -->
<div class="form-group col-sm-6">
    {!! Form::label('multimedia', 'Multimedia:') !!}
    {!! Form::file('multimedia') !!}
</div>
<div class="clearfix"></div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('comportamientos.index') }}" class="btn btn-default">Cancel</a>
</div>
