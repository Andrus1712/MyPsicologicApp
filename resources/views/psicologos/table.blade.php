<div class="table-responsive">
    <table class="table" id="psicologos-table">
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
        @foreach($psicologos as $psicologo)
            <tr>
                <td>{{ $psicologo->tipoIdentificacion }}</td>
            <td>{{ $psicologo->identificacion }}</td>
            <td>{{ $psicologo->nombres }}</td>
            <td>{{ $psicologo->apellidos }}</td>
            <td>{{ $psicologo->correo }}</td>
            <td>{{ $psicologo->fechaNacimiento }}</td>
            <td>{{ $psicologo->telefono }}</td>
            <td>{{ $psicologo->sexo }}</td>
                <td>
                    {!! Form::open(['route' => ['psicologos.destroy', $psicologo->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('psicologos.show', [$psicologo->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('psicologos.edit', [$psicologo->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
