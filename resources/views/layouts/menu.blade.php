<li class="{{ Request::is('home*') ? 'active' : '' }}">
    <a href="/home"><i class="fa fa-home"></i><span>Home</span></a>
</li>

<li class="header">Gestion de datos</li>

<li class="{{ Request::is('comportamientos*') ? 'active' : '' }}">
    <a href="{{ route('comportamientos.index') }}"><i class="fa fa-comments-o"></i><span>Comportamientos</span></a>
</li>

<li class="{{ Request::is('tipoComportamientos*') ? 'active' : '' }}">
    <a href="{{ route('tipoComportamientos.index') }}"><i class="fa fa-database"></i><span>Tipo
            Comportamientos</span></a>
</li>

<li class="{{ Request::is('actividades*') ? 'active' : '' }}">
    <a href="{{ route('actividades.index') }}"><i class="fa fa-list-alt"></i><span>Actividades</span></a>
</li>

<li class="{{ Request::is('avances*') ? 'active' : '' }}">
    <a href="{{ route('avances.index') }}"><i class="fa fa-list-ol"></i><span>Avances</span></a>
</li>

<li class="header">Reportes</li>
<li class="{{ Request::is('reporte_avanzado*') ? 'active' : '' }}">
    <a href="#"><i class="fa fa-file-text-o"></i><span>Reportes avanzados</span></a>
</li>

<li class="header">Gestion de usuarios</li>

{{-- <li class="treeview">
    <a href="#">
        <i class="fa fa-laptop"></i>
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

<li class="{{ Request::is('grupos*') ? 'active' : '' }}">
    <a href="{{ route('grupos.index') }}"><i class="fa fa-users"></i><span>Cursos</span></a>
</li>

<li class="{{ Request::is('roles*') ? 'active' : '' }}">
    <a href="{{ route('roles.index') }}"><i class="fa fa-edit"></i><span>Roles</span></a>
</li>