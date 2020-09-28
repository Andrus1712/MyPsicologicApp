<div class="table-responsive">
    <table class="table" id="estudiantes-table">
        <thead>
            <tr>
                <th>Tipoidentificacion</th>
        <th>Identificacion</th>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>Correo</th>
        <th>Fechanacimiento</th>
        <th>Grado</th>
        <th>Telefono</th>
        <th>Sexo</th>
        <th>Actaaprobacion</th>
        <th>Acudiente Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($estudiantes as $estudiante)
            <tr>
                <td>{{ $estudiante->tipoIdentificacion }}</td>
            <td>{{ $estudiante->identificacion }}</td>
            <td>{{ $estudiante->nombres }}</td>
            <td>{{ $estudiante->apellidos }}</td>
            <td>{{ $estudiante->correo }}</td>
            <td>{{ $estudiante->fechaNacimiento }}</td>
            <td>{{ $estudiante->grado }}</td>
            <td>{{ $estudiante->telefono }}</td>
            <td>{{ $estudiante->sexo }}</td>
            <td>{{ $estudiante->actaAprobacion }}</td>
            <td>{{ $estudiante->acudiente_id }}</td>
                <td>
                    {!! Form::open(['route' => ['estudiantes.destroy', $estudiante->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('estudiantes.show', [$estudiante->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('estudiantes.edit', [$estudiante->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
