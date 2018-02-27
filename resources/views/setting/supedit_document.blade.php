<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <form id="frmSupeditDoc" role="form" action="setting/super_edicion">
                    {!! csrf_field() !!}
                    <div class="col-md-6">
                        <div class="form-group frm-group-custom">
                            <label class="control-label lbl-custom">CUD:</label>
                            <input type="text" name="ndocId" id="docId" class="form-control frm-control-custom">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group frm-group-custom">
                            <label for="docTipo" class="control-label lbl-custom">Registro del Documento:</label>
                            <input type="text" name="ndocReg" id="docReg" class="form-control frm-control-custom">
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-body no-padding">
                <div class="table-responsive mailbox-messages" style="height: auto;">
                    <div id="fullDataDocument">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#document" aria-controls="document" role="tab" data-toggle="tab">Datos del documento</a></li>
                            <li role="presentation"><a href="#expedient" aria-controls="expedient" role="tab" data-toggle="tab">Proceso Documentario</a></li>
                            <li role="presentation"><a href="#historial" aria-controls="historial" role="tab" data-toggle="tab">Historial de Derivación</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="document">
                                
                            </div>
                            <div role="tabpanel" class="tab-pane" id="expedient">
                                
                            </div>
                            <div role="tabpanel" class="tab-pane" id="historial">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(function(){

    var token = $('meta[name="csrf-token"]').attr('content');

    $('#docId').keypress(function(ev) {
        if(ev.which == 13)
        {
            ev.preventDefault();
            if($.trim($('#docId').val()) == '') return;

            $.post('doc/fulldata', {doc: $.trim($('#docId').val()), _token: token, campo: 'id'}, function(data) {
                $('#fullDataDocument').html(data);
            });
        }
    });

    $('#docReg').keypress(function(ev) {
        if(ev.which == 13)
        {
            ev.preventDefault();
            if($.trim($('#docReg').val()) == '') return;

            $.post('doc/fulldata', {reg: $.trim($('#docReg').val()), _token: token, campo: 'reg'}, function(data) {
                $('#fullDataDocument').html(data);
            });
        }
    });

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
