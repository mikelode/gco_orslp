@section('sub-content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-success">
            <div class="card-header">
                <h5 class="card-title">Lista de Usuarios</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-striped">
                        <tr>
                            <th>ID</th>
                            <th>DNI</th>
                            <th>Nombre Completo</th>
                            <th>Accion</th>
                            <th>Estado</th>
                            <th>Contraseña</th>
                        </tr>
                        @foreach($list_users as $key=>$u)
                            <tr>
                                <td>{{  $u->tusId }}</td>
                                <td>{{ $u->tusDni }}</td>
                                <td>{{ $u->tusFullName}}</td>
                                <td id="{{ $u->tusId }}">
                                    <a href="#" class="btnEdit" data-toggle="modal" data-target="#ueditModal" data-id="{{ $u->tusId }}" data-nmb="{{ $u->tusFullName }}">Editar</a>
                                </td>
                                <td>
                                    @if($u->tusState)
                                    <a href="javascript:void(0)" class="changeState" data-state="{{ $u->tusState }}" data-dni="{{ $u->tusId }}">Desactivar</a>
                                    @else
                                    <a href="javascript:void(0)" class="changeState" data-state="{{ $u->tusState }}" data-dni="{{ $u->tusId }}">Activar</a>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm resetPass" data-id="{{ $u->tusId }}" data-dni="{{ $u->tusDni }}">Resetear</button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ueditModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Perfil de Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frm_update_profile" name="updateFrm">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <input type="hidden" id="kyUser" name="kyUser">
                    <div id="profileTable">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(function(){
    $('#ueditModal').on('show.bs.modal',function(e){
        var btn = $(e.relatedTarget);
        var id = btn.data('id');
        var nmb = btn.data('nmb');
        var modal = $(this);

        $.get('getProfile/' + id, function(resp){
            
            modal.find('.modal-header b').text(id + ' ' + nmb);
            modal.find('.modal-body #kyUser').val(id);
            modal.find('.modal-body #profileTable').html(resp);
        });
    });

    $('.changeState').click(function(e){
        e.preventDefault();
        var state= $(this).data('state')?0:1;
        var dni = $(this).data('dni');
        var msg = state?'ACTIVAR':'DESACTIVAR';

        var ok = confirm('¿Esta seguro de ' + msg + ' al Usuario: ' + dni + '?');

        if(ok)
        {
            $.get('settings/updt_state',{active: state, id: dni},function(response){
                change_to_submenu('settings/list_users');
                alert(response);
            });
        }

    });

    $('.resetPass').click(function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var dni = $(this).data('dni');
        var ok = confirm('¿Esta seguro de resetear la contraseña del Usuario: ' + dni + '? \nLa nueva constraseña sera él número de DNI del usuario')

        if(ok)
        {
            $.get('settings/reset_pass',{idUser: id}, function(response){
                change_to_submenu('settings/list_users');
                alert(response);
            });
        }
    });
});
</script>
@endsection