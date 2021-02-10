@if (Auth()->user()->havePermission('show.actividades'))
<li class="{{ Request::is('home*') ? 'active' : '' }}">
    <a href="/home"><i class="fa fa-home"></i><span>Inicio</span></a>
</li>
@endif

<li class="header">General</li>

@if (Auth()->user()->havePermission('show.cursos'))
    <li class="{{ Request::is('grupos*') ? 'active' : '' }}">
        <a href="{{ route('grupos.index') }}"><i class="fa fa-school"></i><span>Cursos</span></a>
    </li>
@endif

@if (Auth()->user()->havePermission('show.estudiantes') ||
    Auth()->user()->havePermission('show.docentes') ||
    Auth()->user()->havePermission('show.acudientes') ||
    Auth()->user()->havePermission('show.psicologos'))

    <li class="treeview " style="height: auto;">
        <a href="#">
            <i class="fa fa-user"></i> <span> Usuarios</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>

        <ul class="treeview-menu" style="display: none;">

            @if (Auth()->user()->havePermission('show.estudiantes'))
                <li class="{{ Request::is('estudiantes*') ? 'active' : '' }}">
                    <a href="{{ route('estudiantes.index') }}"><i class="fa fa-chalkboard-teacher"></i>Estudiantes</a>
                </li>
            @endif

            @if (Auth()->user()->havePermission('show.docentes'))
                <li class="{{ Request::is('docentes*') ? 'active' : '' }}">
                    <a href="{{ route('docentes.index') }}"><i class="fa fa-chalkboard-teacher"></i>Docentes</a>
                </li>
            @endif

            @if (Auth()->user()->havePermission('show.acudientes'))
                <li class="{{ Request::is('acudientes*') ? 'active' : '' }}">
                    <a href="{{ route('acudientes.index') }}"><i class="fa fa-user-friends"></i>Acudientes</a>
                </li>
            @endif

            @if (Auth()->user()->havePermission('show.psicologos'))
                <li class="{{ Request::is('piscologos*') ? 'active' : '' }}">
                    <a href="{{ route('psicologos.index') }}"><i class="fa fa-user-md"></i>Psicoorientador</a>
                </li>
            @endif


        </ul>

    </li>
@endif

@if (Auth()->user()->havePermission('show.user'))
    <li class="{{ Request::is('usuarios*') ? 'active' : '' }}">
        <a href="{{ route('usuarios.index') }}"><i class="fa fa-users"></i><span>Gestionar Usuarios</span></a>
    </li>
@endif

@if (Auth()->user()->havePermission('show.roles'))
    <li class="{{ Request::is('roles*') ? 'active' : '' }}">
        <a href="{{ route('roles.index') }}"><i class="fa fa-users-cog"></i><span>Configuracion Roles</span></a>
    </li>
@endif

@if (Auth()->user()->havePermission('show.comportamientos') ||
    Auth()->user()->havePermission('tipos.comportamientos') ||
    Auth()->user()->havePermission('show.actividades') ||
    Auth()->user()->havePermission('show.avances') ||
    Auth()->user()->havePermission('show.avances') ||
    Auth()->user()->havePermission('modulo.seguimiento'))
    <li class="header">Modulo de Seguimiento</li>
@endif

@if (Auth()->user()->havePermission('show.comportamientos'))
    <li class="{{ Request::is('comportamientos*') ? 'active' : '' }}">
        <a href="{{ route('comportamientos.index') }}"><i class="fa fa-book"></i>
            <span>Comportamientos</span>
            <span class="label label-warning hide" id="numbercomportaiment">
                <span class=""></span>
            </span>

        </a>
    </li>
@endif

@if (Auth()->user()->havePermission('tipos.comportamientos'))
    <li class="{{ Request::is('tipoComportamientos*') ? 'active' : '' }}">
        <a href="{{ route('tipoComportamientos.index') }}"><i class="fa fa-book-open"></i><span>Tipo
                Comportamientos</span></a>
    </li>
@endif

@if (Auth()->user()->havePermission('show.actividades'))
    <li class="{{ Request::is('actividades*') ? 'active' : '' }}">
        <a href="{{ route('actividades.index') }}"><i class="fa fa-calendar-check"></i>
            <span>Actividades</span>
            <span class="label label-warning hide" id="numberactivities">
                <span class=""></span>
            </span>
        </a>
    </li>
@endif

@if (Auth()->user()->havePermission('show.avances'))
    <li class="{{ Request::is('avances*') ? 'active' : '' }}">
        <a href="{{ route('avances.index') }}"><i class="fa fa-list-ol"></i><span>Seguimientos</span></a>
    </li>
@endif

{{-- @if (Auth()
        ->user()
        ->havePermission('modulo.seguimiento'))
    <li class="{{ Request::is('modeloSeguimientos*') ? 'active' : '' }}">
        <a href="{{ route('modeloSeguimientos.index') }}"><i class="fa fa-chart-pie"></i><span>Modelo
                Registro</span></a>
    </li>
@endif --}}
