<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="navbar-nav">
        
        <li class="{{ Request::is('/') ? 'active' : null }}">
          <a href="{{ url('/') }}">
            <i class="fas fa-home"></i><span>Inicio</span>
          </a>
        </li>
        
        @if(Auth::user()->hasPermission(1))
        <li class="{{ Request::is('proyecto') ? 'active' : null }}"><a href="{{ url('proyecto') }}">
          <i class="fas fa-suitcase"></i><span>Proyecto</span>
        </a>
        </li>
        @endif

        <li class="dropdown {{ Request::is('presupuesto/*') || Request::is('presupuesto')  ? 'active' : null }}">
          <a href="javascript:;" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
            <i class="fas fa-code-branch"></i><br>Gestión de Obra
          </a>
          <div class="dropdown-menu">
            @if(Auth::user()->hasPermission(5))
            <a class="dropdown-item" href="{{ url('presupuesto') }}">
              <i class="fas fa-credit-card fa-sm"></i> Presupuesto de Obra
            </a>
            @endif
            @if(Auth::user()->hasPermission(9))
            <a class="dropdown-item" href="{{ url('presupuesto/programacion') }}">
              <i class="fas fa-calendar-alt fa-sm"></i> Programación de Obra
            </a>
            @endif
            @if(Auth::user()->hasPermission(13))
            <a class="dropdown-item" href="{{ url('presupuesto/avance') }}">
              <i class="fas fa-tasks fa-sm"></i> Valorizacion de Obra
            </a>
            @endif
          </div>
        </li>
        @if(Auth::user()->hasPermission(17))
        <li class="{{ Request::is('curvas') ? 'active' : null }}">
          <a href="{{ url('curvas') }}">
            <i class="fas fa-chart-line"></i><span>Avance Físico</span>
          </a>
        </li>
        @endif
        <li class="dropdown {{ Request::is('tablas/*') || Request::is('tablas')  ? 'active' : null }}">
          <a href="javascript:;" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
            <i class="fas fa-address-book"></i><br>Registro de Personas
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ url('tablas/npersona') }}">
              <i class="fas fa-male fa-sm"></i> Persona Natural
            </a>
            <a class="dropdown-item" href="{{ url('tablas/jpersona') }}">
              <i class="fas fa-users fa-sm"></i> Persona Jurídica
            </a>
          </div>
        </li>
      </ul>
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>