@section('sub-content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Lista de Proyectos</h3>
                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#asocModal">Agregar Proyecto</a>
            </div>
            <div class="box-body no-padding">
                <div class="table-responsive mailbox-messages" style="height: auto;">
                    <table class="table table-hover table-striped table-responsive" id="tblProyecto">
                        <tr>
                            <th>#</th>
                            <th>Año</th>
                            <th>Nombre</th>
                            <th>Nombre Corto</th>
                            <th>Código Unificado</th>
                        </tr>
                        @foreach($list_proy as $key=>$u)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <a href="#" data-pk={{ $u->tpyId }} data-type="textarea" data-name="anio" class="fldEditar" style="white-space: normal;">
                                    {{ $u->tpyAnio }}
                                    </a>
                                </td>
                                <td>
                                    <a href="#" data-pk={{ $u->tpyId }} data-type="textarea" data-name="name" class="fldEditar" style="white-space: normal;">
                                    {{ $u->tpyName }}
                                    </a>
                                </td>
                                <td>
                                    <a href="#" data-pk={{ $u->tpyId }} data-type="textarea" data-name="shortname" class="fldEditar" style="white-space: normal;">
                                    {{ $u->tpyShortName }}
                                    </a>
                                </td>
                                <td>
                                    <a href="#" data-pk={{ $u->tpyId }} data-type="textarea" data-name="coduni" class="fldEditar" style="white-space: normal;">
                                    {{ $u->tpyCU }}
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

<div class="modal fade" id="asocModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Registrar Proyecto: <b></b> </h4>
            </div>
            <form class="form-horizontal" id="frm_add_proy" name="addFrm">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-xs-4 control-label">Año</label>
                        <div class="col-xs-6">
                            <input type="number" name="npyAnio" id="input" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label">Nombre</label>
                        <div class="col-xs-6">
                            <input type="text" name="npyName" id="input" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label">Nombre Corto</label>
                        <div class="col-xs-6">
                            <input type="text" name="npyShortName" id="input" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-4 control-label">Código Unificado</label>
                        <div class="col-xs-6">
                            <input type="text" name="npyCu" id="input" class="form-control">
                        </div>
                    </div>
                </div>
            </form>
            <div class="box-footer">
                <button type="button" id="btnAddProy" class="btn btn-primary pull-right">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
$(function(){

    var token = $('meta[name="csrf-token"]').attr('content');

    $('#asocModal').on('show.bs.modal');

    $('#btnAddProy').click(function(e){
        e.preventDefault();
        var data = $('#frm_add_proy').serialize();
        var url = 'settings/new_proy';

        $.post(url, data, function(response){

            if(response.msgId == '200'){
                $('#tblProyecto tr:last').after('<tr><td>#</td><td>'+response.proy.tpyAnio+'</td><td>'+response.proy.tpyName+'</td><td>'+response.proy.tpyShortName+'</td><td>'+response.proy.tpyCU+'</td></tr>');
                alert(response.msg);
            }
            else{
                alert(response.msg);
            }
            $('#asocModal').modal('hide');
        });
    })

    $('.fldEditar').editable({
        title: 'Ingrese el dato',
        rows: 5,
        emptytext: 'Vacío',
        url: 'settings/updt_proy',
        params: {_token: token},
        success: function(response, newValue){
            if(!response.success) return "Error en el intento de cambiar el estado";
        }
    });



    
});
</script>
@endsection