<li class="active treeview menu-open">
    <a href="#">
      <i class="fa fa-user"></i><span>Gestion de usuarios</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu sidebar-menu">
        <li class="{{ Request::is('acudientes*') ? 'active' : '' }}">
            <a href="{{ route('acudientes.index') }}"><i class=""></i><span>Acudiente</span></a>
        </li>

        <li class="{{ Request::is('estudiantes*') ? 'active' : '' }}">
            <a href="{{ route('estudiantes.index') }}"><i class=""></i><span>Estudiante</span></a>
        </li>

        <li class="{{ Request::is('docentes*') ? 'active' : '' }}">
            <a href="{{ route('docentes.index') }}"><i class=""></i><span>Docente</span></a>
        </li>

        <li class="{{ Request::is('psicologos*') ? 'active' : '' }}">
            <a href="{{ route('psicologos.index') }}"><i class=""></i><span>Psicologo</span></a>
        </li>
    </ul>
  </li>

