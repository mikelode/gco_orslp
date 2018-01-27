<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset('/img/usuario.png')}}" class="img-circle" alt="MDV" />
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->tusNames }}</p><br>
                <!-- Status -->
                <a href="javascript:void(0)" id="btn_connect_chat" data-id="{{ Auth::user()->tusId }}" data-nick="{{ Auth::user()->tusNames }}" data-dep="{{ Auth::user()->workplace->depDsc }}"><i class="fa fa-circle text-success"></i>Conectado</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <div class="sidebar-form">
            <div class="input-group">
                <input type="text" id="period_sys" class="form-control" value="{{ \Session::get('periodo') }}" style="text-align: center;" readonly="readonly" />
              <span class="input-group-btn">
                <div name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-calendar"></i></div>
              </span>
            </div>
        </div>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MENU</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active treeview"><a href="{{ url('/') }}"><i class='fa fa-home'></i> <span>Inicio</span></a></li>

            @if(Auth::user()->can(5))
            <li><a href="javascript:void(0)" onclick="change_menu_register('doc/register')"><i class='glyphicon glyphicon-book'></i> <span>Gestión de Documentos</span></a></li>
            @endif
            @if(Auth::user()->can(7))
            <li><a href="javascript:void(0)" onclick="change_menu_to('doc/menu')"><i class='glyphicon glyphicon-inbox'></i> <span>Bandeja de Documentos</span></a></li>
            @endif
            @if(Auth::user()->can(9))
            <li><a href="javascript:void(0)" onclick="change_menu_to('doc/reports')"><i class='glyphicon glyphicon-stats'></i> <span>Reportes</span></a></li>
            @endif
            @if(Auth::user()->can(12))
            <li><a href="javascript:void(0)" onclick="change_menu_to('settings')"><i class='glyphicon glyphicon-cog'></i> <span>Configuración</span></a></li>
            @endif
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
