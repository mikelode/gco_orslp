@section('sub-content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Registrar Afiliado de Asociación</h3>
            </div>
            <form class="form-horizontal" id="frm_reg_afil">
                {!! csrf_field() !!}
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Cargo de la persona</label>
                        <div class="col-md-10">
                            <select class="form-control imput-sm" name="cargo_afil">
                                @@foreach ($cargo as $c)
                                    <option value="{{ $c->tcgId }}">{{ $c->tcgDesc }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Documento</label>
                        <div class="col-md-10">
                            <input type="text" name="dni_afil" id="dni_afil_input" class="form-control input-sm" placeholder="DNI del Afiliado">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Nombres</label>
                        <div class="col-md-10">
                            <input type="text" name="name_afil" id="name_afil_input" class="form-control input-sm text-uppercase" placeholder="Nombres">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Apellido Paterno</label>
                        <div class="col-md-10">
                            <input type="text" name="patern_afil" id="patern_afil_input" class="form-control input-sm text-uppercase" placeholder="Apellido Paterno">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Apellido Materno</label>
                        <div class="col-md-10">
                            <input type="text" name="matern_afil" id="matern_afil_input" class="form-control input-sm text-uppercase" placeholder="Apellido Materno">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Celular</label>
                        <div class="col-md-10">
                            <input type="number" name="celular_afil" id="celular_afil_input" class="form-control input-sm text-uppercase" placeholder="Número de celular">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Correo electrónico</label>
                        <div class="col-md-10">
                            <input type="email" name="email_afil" id="email_afil_input" class="form-control input-sm text-uppercase" placeholder="Correo @ electronico">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Asociación</label>
                        <div class="col-md-10">
                            <select class="form-control input-sm" name="asociacion_afil">
                                @foreach($asociacion as $aso)
                                    <option value="{{ $aso->tasId }}">{{ $aso->tasOrganizacion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" id="btnSubmitAfil" class="btn btn-primary pull-right">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(function(){
    $('#btnSubmitAfil').click(function(e){
        e.preventDefault();
        $.post('settings/new_afil',$('#frm_reg_afil').serialize(), function(response){
            change_to_submenu('settings/new_afil');
            bootbox.alert(response);
        }).fail(function(result, textStatus, xhr){
            var errors = result.responseJSON;
            bootbox.alert('Error: <br> Revise los campos ingresados. <br> Código: ' + xhr);
        });
    });
});
</script>

@endsection