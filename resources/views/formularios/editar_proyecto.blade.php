<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5><i class="fas fa-briefcase"></i> Edición de los Datos del Proyecto</h5>
			</div>
			<div class="card-body">
				<ul class="nav nav-tabs" role="tablist" id="myTab">
					<li class="nav-item">
						<a class="nav-link active" id="gd-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">
							Datos Generales
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="ps-tab" data-toggle="tab" href="#seleccion" role="tab" aria-controls="seleccion" aria-selected="false">
							Proceso de Selección
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="ed-tab" data-toggle="tab" href="#ejecucion" role="tab" aria-controls="ejecucion" aria-selected="false">
							Datos de la Ejecución
						</a>
					</li>
					{{--  <li class="nav-item">
						<a class="nav-link" id="eqd-tab" data-toggle="tab" href="#profesionales" role="tab" aria-controls="profesionales" aria-selected="false">
							Equipo Profesional
						</a>
					</li>  --}}
				</ul>
				<div class="tab-content" id="tabContent">
					<div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="gd-tab">
						<div class="card" style="border-top:none">
							<div class="card-body">
								<form id="frmEditProject" action="editar/pry">
									{{ csrf_field() }}
									<input type="hidden" name="npyId" value="{{ $proyecto->pryId }}">
									<input type="hidden" name="nejId" value="{{ $ejecutor[0]->ejeId }}">
									<fieldset>
										<div class="row">
											<label class="col-sm-4 col-form-label"></label>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label caption-label">Nombre del proyecto</label>
											<div class="col-sm-10">
												<textarea name="npyDenom" class="form-control form-control-sm"> {{ $proyecto->pryDenomination }} </textarea>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label caption-label">Nombre corto del proy</label>
											<div class="col-sm-10">
												<input name="npyShortdenom" type="text" class="form-control form-control-sm" value="{{ $proyecto->pryShortDenomination }}">
											</div>
										</div>
										<div class="row">
											<div class="col">
												<div class="form-group row">
													<label class="col-sm-4 col-form-label pt-0 caption-label">Código SNIP</label>
													<div class="col-sm-8">
														<input name="npySnip" type="text" class="form-control form-control-sm" value="{{ $proyecto->prySnip }}">
													</div>
												</div>
											</div>
											<div class="col">
												<div class="form-group row">
													<label class="col-sm-4 col-form-label pt-0 caption-label">Código Unificado</label>
													<div class="col-sm-8">
														<input name="npyCu" type="text" class="form-control form-control-sm" value="{{ $proyecto->pryUnifiedCode }}">
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col">
												<div class="form-group row">
													<label class="col-sm-4 col-form-label pt-0 caption-label">Resolución aprobación</label>
													<div class="col-sm-8">
														<input name="npyResol" type="text" class="form-control form-control-sm" value="{{ $proyecto->pryViabilityResolution }}">
													</div>
												</div>
											</div>
											<div class="col">
												<div class="form-group row">
													<label class="col-sm-4 col-form-label pt-0 caption-label">Fecha de resolución</label>
													<div class="col-sm-8">
														<input name="npyDateresol" type="date" class="form-control form-control-sm" value="{{ $proyecto->pryDateResolution }}">
													</div>
												</div>
											</div>
										</div>
									</fieldset>
								</form>
							</div>
							<div class="card-footer">
								<div class="float-right">
									<button class="btn btn-success btn-sm" onclick="actualizar_proyecto($('#frmEditProject'), event, 'dtaPrj')">Guardar Cambios</button>
									<a href="{{ url('proyecto') }}" class="btn btn-secondary btn-sm">Cancelar</a>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="seleccion" role="tabpanel" aria-labelledby="ps-tab">
						<div class="card" style="boder-top:none">
							<div class="card-body">
								<form id="frmEditProcess" action="editar/prc" enctype="multipart/form-data">
									{{ csrf_field() }}
									<input type="hidden" name="snpyId" id="pyId" value="{{ $proyecto->pryId }}">
									<input type="hidden" name="nslId" value="{{ $seleccion[0]->pslId }}">
									<fieldset>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label pt-0 caption-label">Proyecto</label>
											<div class="col-sm-5">
												<input class="form-control-plaintext" type="text" id="pyNameStored" value="{{ $proyecto->pryDenomination }}" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label pt-0 caption-label">Nomenclatura</label>
											<div class="col-sm-5">
												<input class="form-control form-control-sm" type="text" name="npcNom" id="pcNom" value="{{ $seleccion[0]->pslNomenclatura }}">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label pt-0 caption-label">Identificador</label>
											<div class="col-sm-5">
												<input class="form-control form-control-sm" type="text" name="npcSeace" id="pcSeace" value="{{ $seleccion[0]->pslIdentify }}">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label pt-0 caption-label">Documento</label>
											@if($seleccion[0]->pslPathFile == '')
												<div class="col-sm-5">
													<input class="form-control form-control-sm" type="file" name="npcFileSeace" id="pcFileSeace">
													<progress class="form-control form-control-sm" value="0"></progress>
												</div>
											@else
												<div class="col-sm-2">
													<a href="{{ url('/storage/' . $seleccion[0]->pslPathFile) }}" target="_blank">
														Ver <img src="{{ asset('/img/pdf-file_16.png') }}">
													</a>
												</div>
												<div class="col-sm-5">
													<input class="form-control form-control-sm" type="file" name="npcFileSeace" id="pcFileSeace">
													<progress class="form-control form-control-sm" value="0"></progress>
												</div>
											@endif
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label pt-0 caption-label">Postores</label>
											<div class="col-sm-1">
												<button type="button" class="btn btn-outline-primary btn-sm" onclick="agregar_fila($('#tblPostorSelection'))"><i class="fas fa-plus"></i> Añadir Postor</button> 
											</div>
										</div>
										<div class="form-group">
											<table class="table table-sm" id="tblPostorSelection">
												<thead>
													<tr>
														<th width='6%'>ID</th>
														<th width='12%'>RUC</th>
														<th width='30%'>Denominación o Razón Social</th>
														<th width='20%'>Representante Legal</th>
														<th width='20%'>Dirección</th>
														<th width='10%'>Condición</th>
														<th width='2%'></th>
													</tr>
												</thead>
												<tbody>
													<tr class="tr_clone" style="display: none;">
														<td>
															<input type="number" class="form-control-plaintext psIdPrs" name="npsIdPrs[]" readonly>
														</td>
														<td>
															<input type="number" class="form-control form-control-sm psRuc">
														</td>
														<td>
															<input type="text" class="form-control-plaintext psRazonSocial" readonly>
														</td>
														<td>
															<input type="text" class="form-control-plaintext psRepLegal" readonly>
														</td>
														<td>
															<input type="text" class="form-control-plaintext psAddress" readonly>
														</td>
														<td>
															<select name="npsCondition[]" class="form-control form-control-sm psCondition">
																<option value="NA">-- Elegir --</option>
																@foreach($condicion as $c)
																<option value="{{ $c->pscId }}">{{ $c->pscDescription }}</option>
																@endforeach
															</select>
														</td>
														<th>
															<a href="javascript:void(0)" onclick="eliminar_fila(this)" class="text-danger">
																<img src="{{ asset('img/trash_16.gif') }}" alt="Quitar fila">
															</a>
														</th>
													</tr>
													@foreach($postor as $i => $pos)
													<tr>
														<input type="hidden" class="psId" value="{{ $pos->pstId }}">
														<td>
															<input type="number" class="form-control-plaintext psIdPrs" value="{{ $pos->pstJpersona }}" readonly>
														</td>
														<td>
															<input type="text" class="form-control form-control-sm psRuc" value="{{ $pos->individualData->prjRegistNumber }}">
														</td>
														<td>
															<input type="text" class="form-control-plaintext psRazonSocial" value="{{ $pos->individualData->prjBusiName }}" readonly>
														</td>
														<td>
															<input type="text" class="form-control-plaintext psRepLegal" value="{{ $pos->individualData->prjLegalRepName . ' ' . $pos->individualData->prjLegalRepPaterno . ' ' . $pos->individualData->prjLegalRepMaterno }}" readonly>
														</td>
														<td>
															<input type="text" class="form-control-plaintext psAddress" value="{{ $pos->individualData->prjEaddress . ' ' . $pos->individualData->prjPaddress }}" readonly>
														</td>
														<td>
															<select name="npsCondition" id="psCondition" class="form-control form-control-sm">
																<option value="Buena PRO" {{ $pos->pstCondition == 1 ? 'selected' : '' }} >Buena PRO</option>
																<option value="Elegible"  {{ $pos->pstCondition == 2 ? 'selected' : '' }}>Elegible</option>
																<option value="No Cumple"  {{ $pos->pstCondition == 3 ? 'selected' : '' }}>No cumple</option>
															</select>
														</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</fieldset>
								</form>
							</div>
							<div class="card-footer">
								<div class="float-right">
									<button class="btn btn-success btn-sm" onclick="actualizar_proyecto($('#frmEditProcess')[0], event, 'dtaPrc')">Guardar Cambios</button>
									<a href="{{ url('proyecto') }}" class="btn btn-secondary btn-sm">Cancelar</a>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="ejecucion" role="tabpanel" aria-labelledby="ed-tab">
						<div class="card" style="border-top:none">
							<div class="card-body">
								<form id="frmEditExecution" action="editar/exec">
									{{ csrf_field() }}
									<input type="hidden" name="henpyId" id="epyId" value="{{ $proyecto->pryId }}">
									<input type="hidden" name="henejeId" value="{{ $ejecutor[0]->ejeId }}">
									<fieldset>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label pt-0 caption-label">Proyecto</label>
											<div class="col-sm-5">
												<input class="form-control-plaintext" type="text" id="epyNameStored" value="{{ $proyecto->pryDenomination }}" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label pt-0 caption-label">Modalidad ejecución</label>
											<div class="col-sm-3">
												<select name="nejeMod" class="form-control form-control-sm">
													<option value="NA" {{ $ejecutor[0]->ejeMode=='NA'?'selected':'' }}>-- Seleccione un opción--</option>
													<option value="AD" {{ $ejecutor[0]->ejeMode=='AD'?'selected':'' }}> Administración directa </option>
													<option value="AI" {{ $ejecutor[0]->ejeMode=='AI'?'selected':'' }}> Por contrata </option>
												</select>
											</div>
											<label class="col-sm-2 col-form-label pt-0 caption-label">Sistema contratación</label>
											<div class="col-sm-3">
												<select name="nejeContract" class="form-control form-control-sm">
													<option value="NA" {{ $ejecutor[0]->ejeSisContract=='NA'?'selected':'' }}>-- Seleccione un opción--</option>
													<option value="PU" {{ $ejecutor[0]->ejeSisContract=='PU'?'selected':'' }}> Precios unitarios </option>
													<option value="SA" {{ $ejecutor[0]->ejeSisContract=='SA'?'selected':'' }}> Suma alzada </option>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label pt-0 caption-label">Monto del contrato</label>
											<div class="col-sm-3">
												<input type="text" class="form-control form-control-sm" name="nejeMountContract" id="txtMountCt" placeholder="Monto Inc. IGV" value="{{ $ejecutor[0]->ejeMountContract }}">
											</div>
											<label class="col-sm-2 col-form-label pt-0 caption-label">Monto del valor ref.</label>
											<div class="col-sm-3">
												<input type="text" class="form-control form-control-sm" name="nejeMountRefValue" id="txtMountVr" placeholder="Monto Inc. IGV" value="{{ $ejecutor[0]->ejeMountRefValue }}">
											</div>
											<div class="col-sm-2">
												<input type="text" class="form-control form-control-sm" name="nejeRelFactor" id="txtRelFac" placeholder="F.R." readonly value="{{ $ejecutor[0]->ejeRelationFactor }}">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label caption-label">Contratista ejecutor</label>
											@if(!is_null($contratista))
												<div class="col-sm-9 pr-0">
													<input name="nejDenom" type="text" class="form-control-plaintext" placeholder="NOMBRE O DENOMINACION" value="{{ $contratista->individualData->prjBusiName }}" readonly>
												</div>
												<div class="col pl-0">
													<input name="nejSigla" type="text" class="form-control-plaintext" placeholder="SIGLAS" value="{{ $contratista->individualData->prjAcronym }}" readonly>
												</div>
											@endif
										</div>
										<div class="row">
											<div class="col">
												<div class="form-group row">
													<label class="col-sm-6 col-form-label caption-label">Fecha convenio</label>
													<div class="col-sm-6">
														<input name="nejeDateAgree" type="date" class="form-control form-control-sm" value="{{ $ejecutor[0]->ejeDateAgree }}">
													</div>
												</div>
											</div>
											<div class="col">
												<div class="form-group row">
													<label class="col-sm-4 col-form-label caption-label">Plazo (meses)</label>
													<div class="col-sm-8 pl-0">
														<input name="nejeMonthTerm" type="number" class="form-control form-control-sm" value="{{ $ejecutor[0]->ejeMonthTerm }}">
													</div>
												</div>
											</div>
											<div class="col">
												<div class="form-group row">
													<label class="col-sm-4 col-form-label caption-label">Plazo (días)</label>
													<div class="col-sm-8 pl-0">
														<input name="nejeDaysTerm" type="number" class="form-control form-control-sm" value="{{ $ejecutor[0]->ejeDaysTerm }}">
													</div>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col">
												<div class="form-group row">
													<label class="col-sm-4 col-form-label pt-0 caption-label">Fecha de Inicio Contractual</label>
													<div class="col-sm-8">
														<input name="nejeStartDate" type="date" class="form-control form-control-sm" value="{{ $ejecutor[0]->ejeStartDateExe }}">
													</div>
												</div>
											</div>
											<div class="col">
												<div class="form-group row">
													<label class="col-sm-4 col-form-label pt-0 caption-label">Fecha de Término Contractual</label>
													<div class="col-sm-8 pl-0">
														<input name="nejeEndDate" type="date" class="form-control form-control-sm" value="{{ $ejecutor[0]->ejeEndDateExe }}">
													</div>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-md-12">
												<button type="button" class="btn btn-outline-primary btn-sm" onclick="agregar_fila($('#tblProfessionalTeam'))">
													Añadir Profesional<span class="fas fa-plus ml-1"></span>
												</button>
											</div>
										</div>
										<div class="form-group row">
											<table class="table table-condensed" id="tblProfessionalTeam">
												<thead>
													<tr>
														<th width='6%'>ID</th>
														<th width='14%'>DNI</th>
														<th width='40%'>Profesional</th>
														<th width='30%'>Cargo</th>
														<th width='10%'>Habilitado</th>
													</tr>
												</thead>
												<tbody>
													<tr class="tr_clone" style="display: none;">
														<td>
															<input type="number" class="form-control-plaintext prfId" name="nteamId[]" readonly>
														</td>
														<td>
															<input type="number" class="form-control form-control-sm prfDni">
														</td>
														<td>
															<input type="text" class="form-control-plaintext prfFullName" readonly>
														</td>
														<td>
															<select name="nteamJob[]" class="form-control form-control-sm">
																<option value="NA">-- Cargo --</option>
																<option value="RESIDENTE"> Residente </option>
																<option value="SUPERVISOR"> Supervisor </option>
																<option value="INSPECTOR"> Inspector </option>
																<option value="ASISTENTE ADMINISTRATIVO"> Asistente Administrativo </option>
																<option value="ASISTENTE TECNICO"> Asistente Técnico </option>
																<option value="OTRO"> Otro </option>
															</select>
														</td>
														<td>
															<a href="javascript:void(0)" onclick="eliminar_fila(this)" class="text-danger">
																	<img src="{{ asset('img/trash_16.gif') }}" alt="Quitar fila">
															</a>
														</td>
													</tr>
													@foreach($equipo as $prof)
													<tr>
														<td>
															<input type="text" class="form-control-plaintext" value="{{ $prof->prfId }}" readonly>
														</td>
														<td>
															<input type="hidden" value="{{ $prof->prfPerson }}">
															<input type="text" class="form-control-plaintext" value="{{ $prof->individualData->perDni }}" readonly>
														</td>
														<td>
															<input type="text" readonly class="form-control-plaintext" value="{{ $prof->individualData->perFullName }}">
														</td>
														<td>
															<a href="#" id="prfJob" data-type="select" data-title="Cambiar cargo" data-pk="{{ $prof->prfId }}" class="editJob">{{ $prof->prfJob }}</a>
														</td>
														<td>
															@if($prof->prfDisable)
																<a href="#" id="prfDisable" data-type="select" data-title="Cambiar Estado" data-pk="{{ $prof->prfId }}" data-value="B" class="editStatus">Deshabilitado</a>
															@else
																<a href="#" id="prfDisable" data-type="select" data-title="Cambiar Estado" data-pk="{{ $prof->prfId }}" data-value="A" class="editStatus">Habilitado</a>
															@endif
														</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</fieldset>
								</form>
							</div>
							<div class="card-footer">
								<div class="float-right">
									<button class="btn btn-success btn-sm" onclick="actualizar_proyecto($('#frmEditExecution'), event, 'dtaExe')">Guardar Cambios</button>
									<a href="{{ url('proyecto') }}" class="btn btn-secondary btn-sm">Cancelar</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('.modal').on('hidden.bs.modal', function(){
	    $(this).find('form')[0].reset();
	});

	$('table#tblProfessionalTeam').on('click', '.ibtnDel', function(event) {
		event.preventDefault();
		$(this).closest('tr').remove();
	});

	var token = $('#frmEditProject').find('input[name="_token"]').val();

	$('.editStatus').editable({
		url: 'edit/statusteam',
		params: {_token: token},
        source: [
              {value: 'A', text: 'Habilitado'},
              {value: 'B', text: 'Deshabilitdo'}
           ],
        success: function(response, newValue){
            if(!response.success) return "Error en el intento de cambiar el estado";
            console.log(newValue);
        }
	});

	$('.editJob').editable({
		url: 'edit/jobteam',
		params: {_token: token},
        source: [
              {value: 'RESIDENTE', text: 'Residente'},
              {value: 'SUPERVISOR', text: 'Supervisor'},
              {value: 'INSPECTOR', text: 'Inspector'},
              {value: 'ASISTENTE ADMINISTRATIVO', text: 'Asistente administrativo'},
              {value: 'ASISTENTE TECNICO', text: 'Asistente técnico'},
              {value: 'OTRO', text: 'Otro'}
           ],
        success: function(response, newValue){
        	alert(response.msg);
            if(!response.success) return "Error en el intento de cambiar el estado";
            console.log(newValue);
        }
	});

	$('.psRuc').on('keypress', function(evt){

	if(evt.which == 13){
		
		var row = $(this).closest('tr');
		var key = $(this).val();
		var url = '{{ url('mostrar/jrd') }}' + '/' + key;

		$.get(url, function(data){
			
			if(data != null || data != ''){
				row.find('input.psIdPrs').val(data.prjId);
				row.find('input.psRazonSocial').val(data.prjBusiName);
				row.find('input.psRepLegal').val(data.prjLegalRepName + ' ' + data.prjLegalRepPaterno + ' ' + data.prjLegalRepMaterno);
				row.find('input.psAddress').val(data.prjEaddress + ' - ' + data.prjPaddress);
			}
			else{
				row.find('input.psIdPrs').val('');
				row.find('input.psRazonSocial').val('');
				row.find('input.psRepLegal').val('');
				row.find('input.psAddress').val('');
			}
		});

	}

	});

	$('.prfDni').on('keypress', function(evt){

	if(evt.which == 13){

		var row = $(this).closest('tr');
		var key = $(this).val();
		var url = '{{ url('mostrar/ntr') }}' + '/' + key;

		$.get(url, function(data){

			if(data !== null || data != ''){
				row.find('input.prfId').val(data.perId);
				row.find('input.prfFullName').val(data.perFullName);
			}
			else{
				row.find('input.prfId').val('')
				row.find('input.prfFullName').val('');
			}

		});

	}

	});

	$('#txtMountCt').on('change', function(evt) {
		evt.preventDefault();
		var val1 = $(this).val();
		var val2 = $('#txtMountVr').val();

		if(val1 == 0 || isNaN(val1) || $.trim(val1) == '')
			return;

		if(val2 == 0 || isNaN(val2) || $.trim(val2) == '')
			return;

		var fr = numeral(val1/val2).format('0,0.00000');
		$('#txtRelFac').val(fr);
	});

	$('#txtMountVr').on('change', function(evt) {
		evt.preventDefault();
		var val2 = $(this).val();
		var val1 = $('#txtMountCt').val();

		if(val1 == 0 || isNaN(val1) || $.trim(val1) == '')
			return;

		if(val2 == 0 || isNaN(val2) || $.trim(val2) == '')
			return;

		var fr = numeral(val1/val2).format('0,0.00000');
		$('#txtRelFac').val(fr);
	});

</script>