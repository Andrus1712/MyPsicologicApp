<div class="table-responsive">
    <table class="table" id="acudientes-table">
        <thead>
            <tr>
                <th>Tipo identificacion</th>
        <th>Identificacion</th>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>Fechanacimiento</th>
        <th>Correo</th>
        <th>Direccion</th>
        <th>Telefono</th>
        <th>Sexo</th>
        <th>Photo</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($acudientes as $acudiente)
            <tr>
                <td>{{ $acudiente->tipoIdentificacion }}</td>
            <td>{{ $acudiente->identificacion }}</td>
            <td>{{ $acudiente->nombres }}</td>
            <td>{{ $acudiente->apellidos }}</td>
            <td>{{ $acudiente->fechaNacimiento }}</td>
            <td>{{ $acudiente->correo }}</td>
            <td>{{ $acudiente->direccion }}</td>
            <td>{{ $acudiente->telefono }}</td>
            <td>{{ $acudiente->sexo }}</td>
            <td>{{ $acudiente->photo }}</td>
                <td>
                    {!! Form::open(['route' => ['acudientes.destroy', $acudiente->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('acudientes.show', [$acudiente->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('acudientes.edit', [$acudiente->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
