<!-- Actividad Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('actividad_id', 'Actividad Id:') !!}
    {!! Form::select('actividad_id', $actividadeItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Comportamiento Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('comportamiento_id', 'Comportamiento Id:') !!}
    {!! Form::select('comportamiento_id', $comportamientoItems, null, ['class' => 'form-control']) !!}
</div>

<!-- Titulo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('titulo', 'Titulo:') !!}
    {!! Form::text('titulo', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::select('estado', ['Cumplido' => 'Cumplido', 'Incumplido' => 'Incumplido'], null, ['class' => 'form-control']) !!}
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

<!-- Documento Field -->
<div class="form-group col-sm-6">
    {!! Form::label('documento', 'Documento:') !!}
    {!! Form::file('documento') !!}
</div>
<div class="clearfix"></div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('avances.index') }}" class="btn btn-default">Cancel</a>
</div>
