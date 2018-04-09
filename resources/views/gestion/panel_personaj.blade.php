@extends('../app')

@section('main-content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2">
                            Persona Jurídica
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control form-control-sm" name="" id="">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-success btn-sm">Buscar</button>
                        </div>
                        <div class="col-md-1">
                            @if(Auth::user()->hasPermission(22))
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#mdlContract">
                                Añadir<span class="fas fa-plus ml-1"></span>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nro</th>
                                    <th>Tipo Doc</th>
                                    <th>Número Doc</th>
                                    <th>Denominacón o Razón Social</th>
                                    <th>Rep.Legal Doc.</th>
                                    <th>Rep.Legal Nombres</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contrat as $i => $con)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $con->prjRegistType }}</td>
                                    <td>{{ $con->prjRegistNumber }}</td>
                                    <td>{{ $con->prjBusiName }}</td>
                                    <td>{{ $con->prjLegalRepDni }}</td>
                                    <td>{{ $con->prjLegalRepName . ' ' . $con->prjLegalRepPaterno . ' ' . $con->prjLegalRepMaterno }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdlContract" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Agregar Persona Jurídica</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmAppendJuridica" action="{{ url('nuevo/jrd') }}">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Número Doc.</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control form-control-sm" name="nprjNumdoc" id="prjNumdoc">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tipo Doc.</label>
                        <div class="col-sm-9">
                            <select name="nprjTipodoc" class="form-control form-control-sm">
                                <option value="NA">-- Tipo de documento--</option>
                                <option value="DNI"> Documento Nacional de Identidad </option>
                                <option value="RUC"> Registro Único del Contribuyente </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Contratista</label>
                        <div class="col-sm-9">
                            <textarea name="nprjDenom" class="form-control form-control-sm" placeholder="DENOMINACION O RAZON SOCIAL"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Siglas</label>
                        <div class="col-sm-9">
                            <input name="nprjSigla" type="text" class="form-control form-control-sm" placeholder="SIGLAS">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-12 col-form-label">Representante Legal</label>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">DNI</label>
                        <div class="col-sm-9">
                            <input name="nprjRepdni" type="text" class="form-control form-control-sm" placeholder="DNI">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nombres</label>
                        <div class="col-sm-9">
                            <input name="nprjRepname" type="text" class="form-control form-control-sm" placeholder="NOMBRES">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Ap. Paterno</label>
                        <div class="col-sm-9">
                            <input name="nprjReppat" type="text" class="form-control form-control-sm" placeholder="APELLIDO PATERNO">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Ap. Materno</label>
                        <div class="col-sm-9">
                            <input name="nprjRepmat" type="text" class="form-control form-control-sm" placeholder="APELLIDO MATERNO">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Dirección Electrónica</label>
                        <div class="col-sm-9">
                            <input name="nprjEdir" type="text" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Dirección Física</label>
                        <div class="col-sm-9">
                            <input name="nprjFdir" type="text" class="form-control form-control-sm">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="append_profesional($('#frmAppendJuridica'))">Agregar</button>
            </div>
        </div>
    </div>
</div>

@endsection