@section('sub-content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-success">
            <div class="card-header">
                <h5 class="card-title">Registrar Nuevo Usuario</h5>
            </div>
            <form class="form-horizontal" id="frm_reg_user">
                {!! csrf_field() !!}
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Documento</label>
                        <div class="col-md-10">
                            <input type="text" name="dni_user" id="dni_user_input" class="form-control form-control-sm" placeholder="DNI del Usuario">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nombres</label>
                        <div class="col-md-10">
                            <input type="text" name="name_user" id="name_user_input" class="form-control form-control-sm text-uppercase" placeholder="Nombres">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Apellido Paterno</label>
                        <div class="col-md-10">
                            <input type="text" name="patern_user" id="patern_user_input" class="form-control form-control-sm text-uppercase" placeholder="Apellido Paterno">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Apellido Materno</label>
                        <div class="col-md-10">
                            <input type="text" name="matern_user" id="matern_user_input" class="form-control form-control-sm text-uppercase" placeholder="Apellido Materno">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Acceso al Proyecto</label>
                        <div class="col-md-10">
                            <select id="pyName" name="npyName[]" multiple>
                                <option value="0"> -- Todos los Proyectos -- </option>
                                @foreach($pys as $py)
                                    <option value="{{ $py->pryId }}">{{ $py->pryShortDenomination }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Cargo del usuario</label>
                        <div class="col-md-10">
                            <input type="text" name="job_user" id="job_user_input" class="form-control form-control-sm text-uppercase" placeholder="Cargo Laboral">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Correo Electrónico</label>
                        <div class="col-md-10">
                            <input type="text" name="email_user" id="email_user_input" class="form-control form-control-sm text-uppercase" placeholder="Correo Electrónico">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Teléfonos o Celular</label>
                        <div class="col-md-10">
                            <input type="text" name="phone_user" id="phone_user_input" class="form-control form-control-sm text-uppercase" placeholder="Número Telefónico">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" id="btnSubmitUser" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(function(){

    $('#pyName').select2({
        width: '100%'
    });

    $('#btnSubmitUser').click(function(e){
        e.preventDefault();
        $.post('settings/new_user',$('#frm_reg_user').serialize(), function(response){
            alert(response);
            $('#dni_user_input').val('');
            $('#name_user_input').val('');
            $('#patern_user_input').val('');
            $('#matern_user_input').val('');
        }).fail(function(result, textStatus, xhr){
            var errors = result.responseJSON;
            console.log(errors);
            alert('Error: Revise los campos ingresados. \nCódigo: ' + xhr);
        });
    });
});
</script>

@endsection