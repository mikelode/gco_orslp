<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="navbar-nav">
        
        <li class="{{ Request::is('/') ? 'active' : null }}">
          <a href="{{ url('/') }}">
            <i class="icon-home"></i><span>Inicio</span>
          </a>
        </li>
        
        @if(Auth::user()->hasPermission(1))
        <li class="{{ Request::is('proyecto') ? 'active' : null }}"><a href="{{ url('proyecto') }}">
          <i class="icon-list-alt"></i><span>Proyecto</span>
        </a>
        </li>
        @endif

        <li class="dropdown {{ Request::is('presupuesto/*') || Request::is('presupuesto')  ? 'active' : null }}">
          <a href="javascript:;" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
            <i class="icon-list"></i><br>Presupuesto
          </a>
          <div class="dropdown-menu">
            @if(Auth::user()->hasPermission(5))
            <a class="dropdown-item" href="{{ url('presupuesto') }}">Presupuesto del Proyecto</a>
            @endif
            @if(Auth::user()->hasPermission(9))
            <a class="dropdown-item" href="{{ url('presupuesto/programacion') }}">Cronograma Calendarizado</a>
            @endif
            @if(Auth::user()->hasPermission(13))
            <a class="dropdown-item" href="{{ url('presupuesto/avance') }}">Avance de Metrados</a>
            @endif
          </div>
        </li>
        @if(Auth::user()->hasPermission(17))
        <li class="{{ Request::is('curvas') ? 'active' : null }}">
          <a href="{{ url('curvas') }}">
            <i class="icon-bar-chart"></i><span>Avance Físico</span>
          </a>
        </li>
        @endif
      </ul>
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>