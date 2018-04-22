<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-center"><span class="border border-secondary px-2">FICHA TÉCNICA DEL PROYECTO DE INVERSIÓN PÚBLICA</span></h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">PROYECTO: {{ $pry->pryDenomination }} </div>
                    <div class="card-body text-center">
                        Modalidad de Ejecución: {{ $eje[0]->ejeMode == 'AI' ? 'POR CONTRATA' : 'ADMINISTRACION DIRECTA' }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="accordion">
                    <div class="card">
                        <div class="card-header font-weight-bold" id="headContract">
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapseContract" aria-expanded="true" aria-controls="collapseContract">A.1. DEL CONTRATO</button>
                        </div>
                        <div id="collapseContract" class="collapse show" aria-labelledby="headContract" data-parent="#accordion">
                            <table class="table table-sm table-slide">
                                <tbody>
                                    <tr>
                                        <td>Sistema de Contratación</td>
                                        <td>{{ $eje[0]->ejeSisContract }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tipo de Selección</td>
                                        <td>{{ $psl[0]->pslNomenclatura }}</td>
                                    </tr>
                                    <tr>
                                        <td>Contratista</td>
                                        <td>{{ $pst[0]->individualData->prjBusiName . ' (' . $pst[0]->individualData->prjRegistNumber . ')' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Representante Legal</td>
                                        <td>{{ $pst[0]->individualData->prjLegalRepName . ' ' . $pst[0]->individualData->prjLegalRepPaterno . ' ' . $pst[0]->individualData->prjLegalRepMaterno . ' (' . $pst[0]->individualData->prjLegalRepDni . ')' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Monto del Contrato</td>
                                        <td>{{ $eje[0]->ejeMountContract }}</td>
                                    </tr>
                                    <tr>
                                        <td>Fecha de pago Adelanto Directo</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="headTeam">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTeam" aria-expanded="false" aria-controls="collapseTeam">A.2. EQUIPO TÉCNICO - ADMINISTRATIVO</button>
                        </div>
                        <div id="collapseTeam" class="collapse" aria-labelledby="headTeam" data-parent="#accordion">
                            <table class="table table-sm table-slide">
                                <tbody>
                                    @foreach($eqp as $prf)
                                    <tr>
                                        <td>{{ $prf->prfJob }}</td>
                                        <td>{{ $prf->individualData->perFullName }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                
                    <div class="card">
                        <div class="card-header" id="headPry">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsePry" aria-expanded="false" aria-controls="collapsePry">A.3. DATOS DEL PROYECTO</button>
                        </div>
                        <div id="collapsePry" class="collapse" aria-labelledby="headPry" data-parent="#accordion">
                            <table class="table table-sm table-slide">
                                <tbody>
                                    <tr>
                                        <td>Código SNIP</td>
                                        <td colspan="5">{{ $pry->prySnip }}</td>
                                    </tr>
                                    <tr>
                                        <td>Pto Aprobado Perfil Técnico S/.</td>
                                        <td colspan="5"></td>
                                    </tr>
                                    <tr>
                                        <td>Meta del año en curso</td>
                                        <td colspan="5">{{ $pry->pryDenomination }}</td>
                                    </tr>
                                    <tr>
                                        <td>Meta Física (resumen)</td>
                                        <td colspan="5"></td>
                                    </tr>
                                    <tr>
                                        <td>Ubicación</td>
                                        <td colspan="5"></td>
                                    </tr>
                                    <tr>
                                        <td>Localidad/Sector</td>
                                        <td></td>
                                        <td>Distrito</td>
                                        <td></td>
                                        <td>Provincia</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <table class="table table-sm">
                                                @foreach($pto as $p)
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Presupuesto</th>
                                                        <th>{{ $p->tprDescription . ' - ' . $p->preName }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Detalle</td>
                                                        <td>
                                                            <table class="table table-sm">
                                                                @foreach($p->items as $it)
                                                                <tr>
                                                                    <td>{{ $it->iprItemGeneral }}</td>
                                                                    <td>{{ $it->iprItemGeneralPrcnt == '' ? '' : number_format($it->iprItemGeneralPrcnt,2,'.',',') . '%' }}</td>
                                                                    <td>{{ number_format($it->iprItemGeneralMount,2,'.',',') }}</td>
                                                                </tr>
                                                                @endforeach
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                @endforeach
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Ppto Aprobado del Expediente Técnico: S/.</td>
                                        <td></td>
                                        <td colspan="2">Total ppto valorizado año anterior: S/.</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Presupuesto para Supervisión de Obra: S/.</td>
                                        <td></td>
                                        <td colspan="2">PIM asignado año AAAA: S/.</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Total Costo Directo: S/.</td>
                                        <td></td>
                                        <td colspan="2">Total PEA (Pers. Técnico, Administrativo y Obrero)</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Monto Contratado (FR 0.90%): S/.</td>
                                        <td></td>
                                        <td colspan="2">¿Necesita verificación de viabilidad?</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            
                    <div class="card">
                        <div class="card-header" id="headDocs">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseDocs" aria-expanded="false" aria-controls="collapseDocs">A.4. DOCUMENTACIÓN ADMINISTRATIVA</button>
                        </div>
                        <div id="collapseDocs" class="collapse" aria-labelledby="headDocs" data-parent="#accordion">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>DESCRIPCIÓN</th>
                                        <th>DOCUMENTO</th>
                                        <th>de FECHA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Aprobación Expediente Técnico</td>
                                        <td>{{ $pry->pryViabilityResolution }}</td>
                                        <td>{{ $pry->pryDateResolution }}</td>
                                    </tr>
                                    <tr>
                                        <td>Entrega de Terreno</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Aprobación Adicionales</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Conclusión de Obra</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            
                    <div class="card">
                        <div class="card-header" id="headProgress">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseProgress" aria-expanded="false" aria-controls="collapseProgress">A.5. AVANCE FÍSICO Y FINANCIEROS DE OBRA:</button>
                        </div>
                        <div id="collapseProgress" class="collapse" aria-labelledby="headProgress" data-parent="#accordion">
                            <div class="row">
                                <div class="col-md-2">Presupuesto con IGV</div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2">Presupuesto sin IGV</div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2">Ppto Adicionales</div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @foreach($pto as $p)
                                        @if($p->preType == 1)
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3">VALORIZACIONES</th>
                                                        <th rowspan="2">% AVANCE FÍSICO</th>
                                                        <th rowspan="2">NETO A PAGAR</th>
                                                        <th rowspan="2">SALDO FINANCIERO</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Nro</th>
                                                        <th>Correspondiente al mes</th>
                                                        <th>Monto valorizado S/.</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($p->programacion as $i=>$prg)
                                                    <tr>
                                                        <td>{{ $prg->prgNumberVal }}</td>
                                                        <td>{{ $prg->prgStartPeriod . ' - ' . $prg->prgEndPeriod }}</td>
                                                        <td>{{ $prg->prgMountExec }}</td>
                                                        <td>{{ $prg->prgAggregateExec }}</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2">Total</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        @endif
                                        @if($p->preType == 2)
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Nro</th>
                                                        <th>Valorizacion de adicionales</th>
                                                        <th>Monto valorizado S/.</th>
                                                        <th>% Avance físico</th>
                                                        <th>Neto a pagar</th>
                                                        <th>Saldo Financiero</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($p->programacion as $i=>$prg)
                                                    <tr>
                                                        <td>{{ $prg->prgNumberVal }}</td>
                                                        <td>{{ $prg->prgStartPeriod . ' - ' . $prgEndPeriod }}</td>
                                                        <td>{{ $prg->prgMountExec }}</td>
                                                        <td>{{ $prg->prgAggregateExec }}</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2">Total</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="card">
                        <div class="card-header" id="headPpto">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsePpto" aria-expanded="false" aria-controls="collapsePpto">A.6. MODIFICACIONES PRESUPUESTALES: (Aprobada(s) mediante resolución(es)</button>
                        </div>
                        <div id="collapsePpto" class="collapse" aria-labelledby="headPpto" data-parent="#accordion">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Monto del Contrato</th>
                                        <th>Ad. Mayores Metrados</th>
                                        <th>Ad. Partidas Nuevas</th>
                                        <th>Deductivos</th>
                                        <th>Deductivos Vinculantes</th>
                                        <th>Total Modif.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            
                    <div class="card">
                        <div class="card-header" id="headPlazo">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsePlazo" aria-expanded="false" aria-controls="collapsePlazo">A.7. PLAZO DE EJECUCIÓN SEGÚN CONTRATO</button>
                        </div>
                        <div id="collapsePlazo" class="collapse" aria-labelledby="headPlazo" data-parent="#accordion">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Días</th>
                                        <th>Fecha inicio</th>
                                        <th>Inicio plazo contractul</th>
                                        <th>Fecha conclusión</th>
                                        <th>EJECUTADO</th>
                                        <th>PARALIZADO</th>
                                        <th>AMPLIACIÓN</th>
                                        <th>TOTAL MODIF.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            
                    <div class="card">
                        <div class="card-header" id="headExtra">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseExtra" aria-expanded="false" aria-controls="collapseExtra">A.8. LIMITACIONES, RECOMENDACIONES y/o COMENTARIOS</button>
                        </div>
                        <div id="collapseExtra" class="collapse" aria-labelledby="headExtra" data-parent="#accordion">
                            Limitaciones
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>