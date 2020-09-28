<div class="table-responsive">
    <table class="table" id="docentes-table">
        <thead>
            <tr>
                <th>Tipoidentificacion</th>
        <th>Identificacion</th>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>Correo</th>
        <th>Fechanacimiento</th>
        <th>Telefono</th>
        <th>Sexo</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($docentes as $docente)
            <tr>
                <td>{{ $docente->tipoIdentificacion }}</td>
            <td>{{ $docente->identificacion }}</td>
            <td>{{ $docente->nombres }}</td>
            <td>{{ $docente->apellidos }}</td>
            <td>{{ $docente->correo }}</td>
            <td>{{ $docente->fechaNacimiento }}</td>
            <td>{{ $docente->telefono }}</td>
            <td>{{ $docente->sexo }}</td>
                <td>
                    {!! Form::open(['route' => ['docentes.destroy', $docente->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('docentes.show', [$docente->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('docentes.edit', [$docente->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
