<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li class="{{ Request::is('/') ? 'active' : null }}"><a href="{{ url('/') }}"><i class="icon-home"></i><span>Inicio</span> </a> </li>
        <li class="{{ Request::is('proyecto') ? 'active' : null }}"><a href="{{ url('proyecto') }}"><i class="icon-list-alt"></i><span>Obras</span> </a> </li>
        <li><a href="guidely.html"><i class="icon-facetime-video"></i><span>Presupuesto</span> </a></li>
        <li><a href="charts.html"><i class="icon-bar-chart"></i><span>Avance Físico</span> </a> </li>
        <li><a href="shortcodes.html"><i class="icon-money"></i><span>Avance Financiero</span> </a> </li>
        <!--<li class="dropdown"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-long-arrow-down"></i><span>Drops</span> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="icons.html">Icons</a></li>
            <li><a href="faq.html">FAQ</a></li>
            <li><a href="pricing.html">Pricing Plans</a></li>
            <li><a href="login.html">Login</a></li>
            <li><a href="signup.html">Signup</a></li>
            <li><a href="error.html">404</a></li>
          </ul>
        </li>-->
      </ul>
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>