@section('htmlheader_title')
    Menu Principal
@endsection

@section('main-content')

<section class="content-header">
    <h1>
        CONFIGURACION
        <small>@yield('contentheader_description')</small>
    </h1>
</section>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cambiar Contraseña</h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" id="frm-updt-pass">
                            {!! csrf_field() !!}
                            <div class="row">
                                <input type="hidden" value="{{ Auth::user()->tusId }}" name="idUser">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Nueva contraseña</label>
                                        <div class="col-md-8">
                                            <input type="password" class="form-control" name="npassUser" id="npassUser">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Repita contraseña</label>
                                        <div class="col-md-8">
                                            <input type="password" class="form-control" name="rpassUser" id="rpassUser">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3" style="text-align: center;">
                                            <button class="btn btn-primary" id="btn-updt-pass">GUARDAR</button>
                                        </div>
                                        <div class="col-md-3" style="text-align: center;">
                                            <a href="{{ url('/') }}" class="btn btn-warning" id="btn-salir">SALIR</a>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){


        $('#btn-updt-pass').click(function(evt){

            evt.preventDefault();

            var npass = $('#npassUser').val();
            var rpass = $('#rpassUser').val();

            if(npass != rpass)
            {
                bootbox.alert('<h4>Las contraseñas ingresadas no coinciden <br> Vuelva a intentar</h4>');
                return;
            }

            var url = 'settings/updt_pass';
            var data = $('#frm-updt-pass').serialize();

            $.post(url, data, function(response){
                bootbox.alert('-' + response);
                $('#npassUser').val('');
                $('#rpassUser').val('');

            }).fail(function(e){
                bootbox.alert('<h4>Error al cambiar su contraseña.</h4>')
            });
        })

    });
</script>


@endsection