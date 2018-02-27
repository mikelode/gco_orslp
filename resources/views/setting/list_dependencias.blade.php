@section('sub-content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Lista de Dependencias</h3>
                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#depenModal">Agregar Dependencia</a>
            </div>
            <div class="box-body no-padding">
                <div class="table-responsive mailbox-messages" style="height: auto;">
                    <table class="table table-hover table-striped table-responsive" id="tblDependencia">
                        <tr>
                            <th>#</th>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Nombre Corto</th>
                        </tr>
                        @foreach($list_depen as $key=>$u)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    {{ $u->depId }}
                                </td>
                                <td>
                                    <a href="#" data-pk={{ $u->depId }} data-type="textarea" data-name="name" class="fldEditar" style="white-space: normal;">
                                    {{ $u->depDsc }}
                                    </a>
                                </td>
                                <td>
                                    <a href="#" data-pk={{ $u->depId }} data-type="textarea" data-name="shortname" class="fldEditar" style="white-space: normal;">
                                    {{ $u->depDscC }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="depenModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Registrar Dependencia: <b></b> </h4>
            </div>
            <form class="form-horizontal" id="frm_add_depen" name="addFrm">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-xs-4 control-label">Nombre</label>
                        <div class="col-xs-6">
                            <input type="text" name="ndpName" id="input" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label">Nombre Corto</label>
                        <div class="col-xs-6">
                            <input type="text" name="ndpShortName" id="input" class="form-control">
                        </div>
                    </div>
                </div>
            </form>
            <div class="box-footer">
                <button type="button" id="btnAddDepen" class="btn btn-primary pull-right">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
$(function(){

    var token = $('meta[name="csrf-token"]').attr('content');

    $('#depenModal').on('show.bs.modal');

    $('#btnAddDepen').click(function(e){
        e.preventDefault();
        var data = $('#frm_add_depen').serialize();
        var url = 'settings/new_depen';

        $.post(url, data, function(response){

            if(response.msgId == '200'){
                $('#tblDependencia tr:last').after('<tr><td>#</td><td>'+response.newDep.depId+'</td><td>'+response.newDep.depDsc+'</td><td>'+response.newDep.depDscC+'</td></tr>');
                alert(response.msg);
            }
            else{
                alert(response.msg);
            }
            $('#depenModal').modal('hide');
        });
    })

    $('.fldEditar').editable({
        url: 'settings/updt_depen',
        params: {_token: token},
        success: function(response, newValue){
            if(!response.success) return "Error en el intento de cambiar el estado";
        }
    });
    
});
</script>
@endsection