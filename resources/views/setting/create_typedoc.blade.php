@section('sub-content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Agregar Documento</h3>
            </div>
            <div class="box-body">
                <form class="form-horizontal" id="frm_add_doc">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Identificador</label>
                                <div class="col-md-10">
                                    <input type="text" name="id_doc" id="id_doc_input" class="form-control input-sm text-uppercase" placeholder="Abreviatura del Documento, DEBE SER UNICO Y DIFERENTE DE LOS YA REGISTRADOS">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Documento</label>
                                <div class="col-md-10">
                                    <input type="text" name="dsc_doc" id="dsc_doc_input" class="form-control input-sm text-uppercase" placeholder="Nombre del Documento">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-10" style="text-align: center;">
                                    <button type="submit" id="btnSubmitTdoc" class="btn btn-primary">Agregar y Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped" id="table_type_docs">
                                <tr>
                                    <th>#</th>
                                    <th>Abrv.</th>
                                    <th>Nombre del Documento</th>
                                    <th>Mostrar</th>
                                </tr>
                                @foreach($list_docs as $kd=>$tdoc)
                                    <tr data-id="{{ $tdoc->ttypDoc }}">
                                        <td>{{ $kd + 1 }}</td>
                                        <td>{{ $tdoc->ttypDoc }}</td>
                                        <td>{{ $tdoc->ttypDesc }}</td>
                                        <td>
                                            @if($tdoc->ttypShow)
                                                <a href="javascript:void(0)" class="changeState" data-state="{{ $tdoc->ttypShow }}" data-id="{{ $tdoc->ttypDoc }}">Ocultar</a>
                                            @else
                                                <a href="javascript:void(0)" class="changeState" data-state="{{ $tdoc->ttypShow }}" data-id="{{ $tdoc->ttypDoc }}"><spam style="color: red;">Mostrar</spam></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{!! Form::open(['route' => ['delete_tdoc',':DOC_ID'], 'method' => 'POST', 'id' => 'frm_delete_tdoc']) !!}
{!! Form::close() !!}

<script>
$(document).ready(function(){

    $('#btnSubmitTdoc').click(function(e){
        e.preventDefault();
        $.post('settings/new_tdoc',$('#frm_add_doc').serialize(), function(response){
            bootbox.alert('Nuevo tipo de documento registado correctamente');

            var output = '<tr><td>Nuevo</td><td>' + response.typeId + '</td><td>' + response.dsc + '</td><td><a href="javascript:void(0)" class="btn-delete">Eliminar</a></td></tr>';

            $('#table_type_docs tr:first').after(output);
        }).fail(function(error){
            bootbox.alert(error);
        });
    });

    $('.btn-delete').click(function(e){
        e.preventDefault();

        var row = $(this).parents('tr');
        var id = row.data('id');
        var form = $('#frm_delete_tdoc');
        var url = form.attr('action').replace(':DOC_ID', id);
        var data = form.serialize();

        $.post(url, data, function(response){
            row.fadeOut();
            bootbox.alert(response.message);
        }).fail(function(){
            bootbox.alert('Hubo un error, el tipo de documento no fue eliminado');
        });
    });

    $('.changeState').click(function(e){
        e.preventDefault();

        var state= $(this).data('state');
        var id = $(this).data('id');
        
        $.get('settings/updt_statetipodoc',{state: state, id:id},function(response){
            change_to_submenu('settings/add_doc');
            bootbox.alert(response.message);
        }).fail(function(e){
            bootbox.alert('Hubo un error, no se pudo actualizar el estado del tipo de documento'); 
        });

    });

});
</script>

@endsection