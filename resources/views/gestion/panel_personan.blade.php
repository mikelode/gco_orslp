@extends('../app')

@section('main-content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2">
                            Persona Natural
                        </div>
                        <div class="col-md-7">
                            <input type="text" class="form-control form-control-sm" name="" id="">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-success btn-sm">Buscar</button>
                        </div>
                        <div class="col-md-1">
                            @if(Auth::user()->hasPermission(21))
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#mdlPersona">
                                Añadir Persona<span class="fas fa-plus ml-1"></span>
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
                                    <th>Dni</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($personas as $i => $per)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $per->perDni }}</td>
                                    <td>{{ $per->perFullName }}</td>
                                    <td>{{ $per->perEmail }}</td>
                                    <td>{{ $per->perPhone1 . ' - ' . $per->perPhone2 }}</td>
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

<div class="modal fade" id="mdlPersona" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Agregar Persona Natural</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmAppendPersona" action="{{ url('nuevo/prs') }}">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">DNI</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control form-control-sm" name="nprsDni" id="prsDni" onkeypress="check_persona(this, event)">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nombres</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" name="nprsNames" id="prsNames">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Ap. Paterno</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" name="nprsPaterno" id="prsPaterno">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Ap. Materno</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" name="nprsMaterno" id="prsMaterno">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Ocupación</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" name="nprsOcup" placeholder="Abreviatura" id="prsOcup">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label pt-0">Fecha Nacimiento</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control form-control-sm" name="nprsBirthday" id="prsBirthday">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Correo</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control form-control-sm" name="nprsEmail" id="prsEmail">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Teléfono</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm" name="nprsPhone" id="prsPhone">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="append_profesional($('#frmAppendPersona'))">Agregar</button>
            </div>
        </div>
    </div>
</div>

@endsection