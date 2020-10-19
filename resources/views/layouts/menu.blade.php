<li class="{{ Request::is('home*') ? 'active' : '' }}">
    <a href="/home"><i class="fa fa-home"></i><span>Home</span></a>
</li>

{{-- <li class="treeview">
    <a href="#">
        <i class="fa fa-users"></i>
        <span>Grestion de usuarios</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('estudiantes*') ? 'active' : '' }}">
<a href="{{ route('estudiantes.index') }}"><i class="fa fa-user"></i><span>Estudiantes</span></a>
</li>
<li class="{{ Request::is('docentes*') ? 'active' : '' }}">
    <a href="{{ route('docentes.index') }}"><i class="fa fa-user"></i><span>Docentes</span></a>
</li>
<li class="{{ Request::is('acudientes*') ? 'active' : '' }}">
    <a href="{{ route('acudientes.index') }}"><i class="fa fa-user"></i><span>Acudientes</span></a>
</li>
<li class="{{ Request::is('psicologos*') ? 'active' : '' }}">
    <a href="{{ route('psicologos.index') }}"><i class="fa fa-user-md"></i><span>Psicologos</span></a>
</li>
</ul>
</li> --}}

{{-- <li class="treeview">
    <a href="#">
        <i class="fa fa-cubes"></i>
        <span>Grestion de datos</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ Request::is('comportamientos*') ? 'active' : '' }}">
<a href="{{ route('comportamientos.index') }}"><i class="fa fa-book"></i><span>Comportamientos</span></a>
</li>

<li class="{{ Request::is('tipoComportamientos*') ? 'active' : '' }}">
    <a href="{{ route('tipoComportamientos.index') }}"><i class="fa fa-book-open"></i><span>Tipo
            Comportamientos</span></a>
</li>

<li class="{{ Request::is('actividades*') ? 'active' : '' }}">
    <a href="{{ route('actividades.index') }}"><i class="fa fa-calendar-check"></i><span>Actividades</span></a>
</li>

<li class="{{ Request::is('avances*') ? 'active' : '' }}">
    <a href="{{ route('avances.index') }}"><i class="fa fa-list-ol"></i><span>Avances</span></a>
</li>

</ul>
</li> --}}

<li class="header">Modulo Intitucional</li>
<li class="{{ Request::is('grupos*') ? 'active' : '' }}">
    <a href="{{ route('grupos.index') }}"><i class="fa fa-school"></i><span>Cursos</span></a>
</li>

@can('Psicoorientador')
<li class="treeview">
    <a href="#">
        <i class="fa fa-archive"></i>
        <span>Gestion de usuarios</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">

        <li class="{{ Request::is('estudiantes*') ? 'active' : '' }}">
            <a href="{{ route('estudiantes.index') }}"><i class="fa fa-user-graduate"></i><span>Estudiantes</span></a>
        </li>
        <li class="{{ Request::is('docentes*') ? 'active' : '' }}">
            <a href="{{ route('docentes.index') }}"><i class="fa fa-chalkboard-teacher"></i><span>Docentes</span></a>
        </li>
        <li class="{{ Request::is('acudientes*') ? 'active' : '' }}">
            <a href="{{ route('acudientes.index') }}"><i class="fa fa-user-friends"></i><span>Acudientes</span></a>
        </li>
        <li class="{{ Request::is('psicologos*') ? 'active' : '' }}">
            <a href="{{ route('psicologos.index') }}"><i class="fa fa-user-md"></i><span>Psicoorientador</span></a>
        </li>

        <li class="{{ Request::is('usuarios*') ? 'active' : '' }}">
            <a href="{{ route('usuarios.index') }}"><i class="fa fa-users-cog"></i><span>Roles</span></a>
        </li>

    </ul>
</li>
@endcan


<li class="header">Modulo de Seguimiento</li>

<li class="{{ Request::is('comportamientos*') ? 'active' : '' }}">
    <a href="{{ route('comportamientos.index') }}"><i class="fa fa-book"></i>
        <span>Comportamientos</span>
        <span class="label label-warning hide" id="numbercomportaiment">
            <span class=""></span>
        </span>
        
    </a>
</li>

@can('Psicoorientador')
<li class="{{ Request::is('tipoComportamientos*') ? 'active' : '' }}">
    <a href="{{ route('tipoComportamientos.index') }}"><i class="fa fa-book-open"></i><span>Tipo
            Comportamientos</span></a>
</li>
@endcan

<li class="{{ Request::is('actividades*') ? 'active' : '' }}">
    <a href="{{ route('actividades.index') }}"><i class="fa fa-calendar-check"></i>
        <span>Actividades</span>
        <span class="label label-warning hide" id="numberactivities">
            <span class=""></span>
        </span>
    </a>
</li>

@can('Psicoorientador')
<li class="{{ Request::is('avances*') ? 'active' : '' }}">
    <a href="{{ route('avances.index') }}"><i class="fa fa-list-ol"></i><span>Seguimientos</span></a>
</li>
@endcan

@can('Psicoorientador')
<li class="{{ Request::is('modeloSeguimientos*') ? 'active' : '' }}">
    <a href="{{ route('modeloSeguimientos.index') }}"><i class="fa fa-chart-pie"></i><span>Modelo Registro</span></a>
</li>
@endcan


{{-- <li class="header">Reportes</li>
<li class="{{ Request::is('reporte_avanzado*') ? 'active' : '' }}">
<a href="#"><i class="fa fa-file-text-o"></i><span>Reportes avanzados</span></a>
</li> --}}

{{-- <li class="header">Gestion de usuarios</li> --}}




{{-- <li class="{{ Request::is('estudiantes*') ? 'active' : '' }}">
<a href="{{ route('estudiantes.index') }}"><i class="fa fa-user"></i><span>Estudiantes</span></a>
</li>

<li class="{{ Request::is('docentes*') ? 'active' : '' }}">
    <a href="{{ route('docentes.index') }}"><i class="fa fa-user"></i><span>Docentes</span></a>
</li>

<li class="{{ Request::is('acudientes*') ? 'active' : '' }}">
    <a href="{{ route('acudientes.index') }}"><i class="fa fa-user"></i><span>Acudientes</span></a>
</li>

<li class="{{ Request::is('psicologos*') ? 'active' : '' }}">
    <a href="{{ route('psicologos.index') }}"><i class="fa fa-user-md"></i><span>Psicologos</span></a>
</li> --}}