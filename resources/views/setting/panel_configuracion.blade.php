@extends('../app')

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card card-solid">
                <div class="card-header with-border">
                    <h5 class="card-title">Opciones</h5>
                </div>
                <div class="card-body">
                    <div class="nav flex-column nav-pills" aria-orientation='vertical'>
                        <a class="nav-link" data-toggle='pill' role='tab' href="javascript:void(0)" onclick="change_to_submenu('settings/new_user')"><i class="fa fa-user-plus"></i>Nuevo Usuario</a>
                        <a class="nav-link" data-toggle='pill' role='tab' href="javascript:void(0)" onclick="change_to_submenu('settings/list_users')"><i class="fa fa-users"></i>Relación de Usuarios</a>
                        <!--<a class="nav-link" data-toggle='pill' role='tab' href="javascript:void(0)" onclick="change_to_submenu('settings/add_doc')"><i class="fa fa-file-pdf-o"></i>Crear Tipos de Documento</a>
                        <a class="nav-link" data-toggle='pill' role='tab' href="javascript:void(0)" onclick="change_to_submenu('settings/list_proy')"><i class="fa  fa-university"></i>Listar Proyectos</a>
                        <a class="nav-link" data-toggle='pill' role='tab' href="javascript:void(0)" onclick="change_to_submenu('settings/list_depen')"><i class="fa  fa-sitemap"></i>Listar Dependencias</a>
                        <a class="nav-link" data-toggle='pill' role='tab' href="javascript:void(0)" onclick="change_to_submenu('settings/super_edicion')"><i class="fa  fa-database"></i>Super Edición</a>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div id="sub-content">

            </div>
        </div>
    </div>
</div>
@endsection