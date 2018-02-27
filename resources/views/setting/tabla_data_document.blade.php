<meta name="csrf-token" content="{{ csrf_token() }}" />
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#document" aria-controls="document" role="tab" data-toggle="tab">Datos del documento</a></li>
    <li role="presentation"><a href="#expedient" aria-controls="expedient" role="tab" data-toggle="tab">Proceso Documentario</a></li>
    <li role="presentation"><a href="#historial" aria-controls="historial" role="tab" data-toggle="tab">Historial de Derivación</a></li>
</ul>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="document">
        <table class="table">
            <thead>
            <tr>
                <th colspan="11">DATOS DEL DOCUMENTO</th>
            </tr>
            <tr>
                <th>Nro</th>
                <th>Campo</th>
                <th>Valor</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01</td>
                    <td>Codigos del Documento</td>
                    <td>
                        <b>CUD:</b>{{ $documento[0]->tdocId }} - 
                        <b>CODIGO:</b>{{ $documento[0]->tdocCod }} - 
                        <b>CPD:</b>{{ $documento[0]->tdocExp }} 
                        <p>*CUD: Código Único del Documento, CPD: Código del Proceso Documentario</p>
                    </td>
                </tr>
                <tr>
                    <td>02</td>
                    <td>Remitente</td>
                    <td>
                        <table>
                            <tr>
                                <th>Dependencia</th>
                                <td>:</td>
                                <td>{{ $documento[0]->tdocDependencia }} - {{ $documento[0]->dependencia }}</td>
                            </tr>
                            <tr>
                                <th>Proyecto</th>
                                <td>:</td>
                                <td>{{ $documento[0]->tdocProject }} - {{ $documento[0]->proyecto }}</td>
                            </tr>
                            <tr>
                                <th>Cargo Remitente</th>
                                <td>:</td>
                                <td>{{ $documento[0]->tdocJobSender }}</td>
                            </tr>
                            <tr>
                                <th>Nombre Remitente</th>
                                <td>:</td>
                                <td>{{ $documento[0]->tdocSender }}</td>
                            </tr>
                            <tr>
                                <th>Cod. Remitente</th>
                                <td>:</td>
                                <td>{{ $documento[0]->tdocDni }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>03</td>
                    <td>Documento</td>
                    <td>
                        <table>
                            <tr>
                                <th>Tipo</th>
                                <td>:</td>
                                <td>{{ $documento[0]->tdocType }} - {{ $documento[0]->tipodoc }}</td>
                            </tr>
                            <tr>
                                <th>Número</th>
                                <td>:</td>
                                <td>{{ $documento[0]->tdocNumber }}</td>
                            </tr>
                            <tr>
                                <th>Registro</th>
                                <td>:</td>
                                <td>{{ $documento[0]->tdocRegistro }}</td>
                            </tr>
                            <tr>
                                <th>Fecha Ingreso</th>
                                <td>:</td>
                                <td>{{ $documento[0]->tdocDate }}</td>
                            </tr>
                            <tr>
                                <th>Folio</th>
                                <td>:</td>
                                <td>{{ $documento[0]->tdocFolio }}</td>
                            </tr>
                            <tr>
                                <th>Asunto</th>
                                <td>:</td>
                                <td>{{ $documento[0]->tdocSubject }}</td>
                            </tr>
                            <tr>
                                <th>Detalle u Obs</th>
                                <td>:</td>
                                <td>{{ $documento[0]->tdocDetail }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>04</td>
                    <td>Estado tramite del documento</td>
                    <td>
                        <b>Acción: </b>{{ $documento[0]->tdocAccion }} - 
                        <b>Estado Doc: </b>{{ $documento[0]->tdocStatus }}
                    </td>
                </tr>
                <tr>
                    <td>05</td>
                    <td>Doc al que hace Referencia</td>
                    <td>
                        <b>CUD de Referencia: </b>{{ $documento[0]->tdocRef }}
                    </td>
                </tr>
                <tr>
                    <td>06</td>
                    <td>Archivo digital</td>
                    <td>
                        <b>Nombre del archivo: </b>{{ $documento[0]->tdocFileName }} <br>
                        <b>Ubicación del archivo: </b> {{ $documento[0]->tdocPathFile }}
                    </td>
                </tr>
                <tr>
                    <td>07</td>
                    <td>Usuario registrador</td>
                    <td>
                        {{ $documento[0]->tdocRegisterBy }}
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
    <div role="tabpanel" class="tab-pane" id="expedient">
        <table class="table">
            <thead>
            <tr>
                <th colspan="11">DATOS DEL PROCESO DOCUMENTARIO</th>
            </tr>
            <tr>
                <th>Nro</th>
                <th>Campo</th>
                <th>Valor</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01</td>
                    <td>Codigos del Proceso</td>
                    <td>
                        <b>CPD: </b>{{ $expediente[0]->tarcId }}
                        <b>CODIGO: </b>{{ $expediente[0]->tarcExp }}
                    </td>
                </tr>
                <tr>
                    <td>02</td>
                    <td>Título</td>
                    <td>
                        {{ $expediente[0]->tarcTitulo }}
                    </td>
                </tr>
                <tr>
                    <td>03</td>
                    <td>Fecha de Origen</td>
                    <td>
                        {{ $expediente[0]->tarcDatePres }}
                    </td>
                </tr>
                <tr>
                    <td>04</td>
                    <td>Estado</td>
                    <td>
                        {{ $expediente[0]->tarcStatus }}
                    </td>
                </tr>
                <tr>
                    <td>05</td>
                    <td>Proyecto</td>
                    <td>
                        {{ $expediente[0]->tarcAsoc }} : {{ $expediente[0]->proyecto }}
                    </td>
                </tr>
                <tr>
                    <td>06</td>
                    <td>Carpeta del Proceso</td>
                    <td>
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>CUD</th><th>Registro</th><th>Asunto</th><th>Ref</th>
                                </tr>
                            </thead>
                            <tbody>
                        @foreach($carpetaExp as $i=>$c)
                            <tr>
                                <td>{{ $c->tdocId }}</td>
                                <td>{{ $c->tdocRegistro }}</td>
                                <td>{{ $c->tdocSubject }}</td>
                                <td>{{ $c->tdocRef }}</td>
                            </tr>
                        @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div role="tabpanel" class="tab-pane" id="historial">
        <table class="table">
            <thead>
            <tr>
                <th colspan="11">HISTORIAL DE DERIVACION DEL DOCUMENTO</th>
            </tr>
            <tr>
                <th>Nro</th>
                <th>Campo</th>
                <th>Valor</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01</td>
                    <td>Codigos del Historial</td>
                    <td>
                        <b>ID Historial: </b>{{ $historialDoc[0]->thisId }}
                        <b> del CUD: </b>{{ $historialDoc[0]->thisDoc }}
                    </td>
                </tr>
                <tr>
                    <td>02</td>
                    <td>Destino derivación</td>
                    <td>
                        {{ $historialDoc[0]->thisDepT }} : {{ $historialDoc[0]->destinatario }}
                    </td>
                </tr>
                <tr>
                    <td>03</td>
                    <td>Estado de Registro - Fecha</td>
                    <td>
                        <b>Estado: </b> {{ $historialDoc[0]->thisFlagR==1?'Registrado':'' }} <br>
                        <b>Fecha: </b> {{ $historialDoc[0]->thisDateTimeR }}
                    </td>
                </tr>
                <tr>
                    <td>04</td>
                    <td>Estado de Derivación - Fecha - Detalle</td>
                    <td>
                        <b>Estado: </b>{{ $historialDoc[0]->thisFlagD==1?'Derivado':'No derivado' }} <br>
                        <b>Fecha: </b>{{ $historialDoc[0]->thisDateTimeD }} <br> 
                        <b>Detalle: </b>{{ $historialDoc[0]->thisDscD }}
                    </td>
                </tr>
                <tr>
                    <td>05</td>
                    <td>Estado de Atención - Fecha - Detalle</td>
                    <td>
                        <b>Estado: </b>{{ $historialDoc[0]->thisFlagA==1?'Atendido':'' }} <br>
                        <b>Fecha: </b>{{ $historialDoc[0]->thisDateTimeA }} <br>
                        <b>Detalle: </b>{{ $historialDoc[0]->thisDscA }}
                    </td>
                </tr>
                <tr>
                    <td>06</td>
                    <td>Referencia Id Historial</td>
                    <td>
                        {{ $historialDoc[0]->thisIdRef }}
                    </td>
                </tr>
                <tr>
                    <td>07</td>
                    <td colspan="2">Carpeta Historial</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>ID Historial</th>
                                    <th>CUD</th>
                                    <th>Proceso</th>
                                    <th>Registrado</th>
                                    <th>Derivado</th>
                                    <th>Atendido</th>
                                    <th>Hist Referencia</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($carpetaExp as $i=>$c)
                                <tr>
                                    <td>{{ $c->thisId }}</td>
                                    <td>{{ $c->tdocId }}</td>
                                    <td>{{ $c->tdocExp }}</td>
                                    <td>{{ $c->thisDateTimeR }}</td>
                                    <td>{{ $c->thisDateTimeD }} - {{ $c->thisDscD }}</td>
                                    <td>{{ $c->thisDateTimeA }} - {{ $c->thisDscA }}</td>
                                    <td>{{ $c->thisIdRef }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<td>
</td>

<script>
$(function(){

    var token = $('meta[name="csrf-token"]').attr('content');

    $('.fncEstado').editable({
        url: 'settings/updt_profile',
        params: {_token: token},
        source: [
              {value: 'A', text: 'Asignado'},
              {value: 'B', text: 'No Asignado'}
           ],
        success: function(response, newValue){
            if(!response.success) return "Error en el intento de cambiar el estado";

            console.log(newValue);

        }
    });
});
</script>