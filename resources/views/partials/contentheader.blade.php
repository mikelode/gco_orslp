<div id="loading-screen" style="display:none">
  <img src="{{ asset('img/gear.svg') }}">
</div>
<nav class="navbar navbar-expand navbar-dark" style="background-color: #00ba8b;">
  <div class="container">
    <a class="navbar-brand h3" href="{{ url('/') }}">SISTEMA DE GESTIÓN Y CONTROL DE AVANCE DE OBRAS</a>
    <ul class="navbar-nav my-2 my-lg-0">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
          <i class="oi oi-cog"></i>
          Cuenta
        </a>
        @if(Auth::user()->hasPermission(18) || Auth::user()->tusRole == 'admin' || Auth::user()->tusId == 1)
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ url('configuracion') }}">
            Configurar Sistema
          </a>
        </div>
        @endif
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
          <i class="oi oi-person"></i>
          {{ Auth::user()->tusNames }}
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Perfil</a>
          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
            Salir
          </a>
          <a class="dropdown-item" href="#">F.A.Q.</a>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
        </form>
      </li>
    </ul>
  </div>
</nav>