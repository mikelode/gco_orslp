<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="navbar-nav">
        <li class="{{ Request::is('/') ? 'active' : null }}"><a href="{{ url('/') }}"><i class="icon-home"></i><span>Inicio</span> </a> </li>
        <li class="{{ Request::is('proyecto') ? 'active' : null }}"><a href="{{ url('proyecto') }}"><i class="icon-list-alt"></i><span>Proyecto</span> </a> </li>
        <li class="dropdown {{ Request::is('presupuesto/*') || Request::is('presupuesto')  ? 'active' : null }}">
          <a href="javascript:;" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
            <i class="icon-list"></i><br>Presupuesto
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ url('presupuesto') }}">Presupuesto del Proyecto</a>
            <a class="dropdown-item" href="{{ url('presupuesto/programacion') }}">Cronograma Calendarizado</a>
            <a class="dropdown-item" href="{{ url('presupuesto/avance') }}">Avance de Metrados</a>
          </div>
        </li>
        <li class="{{ Request::is('curvas') ? 'active' : null }}"><a href="{{ url('curvas') }}"><i class="icon-bar-chart"></i><span>Avance Físico</span> </a> </li>
        <!--<li><a href="shortcodes.html"><i class="icon-money"></i><span>Avance Financiero</span> </a> </li>-->
      </ul>
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>