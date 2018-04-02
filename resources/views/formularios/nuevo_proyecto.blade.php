<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5 style="display: inline"><i class="fas fa-briefcase"></i> Datos del Nuevo Proyecto</h5>
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
								<form id="frmRegisterProject" action="nuevo/pry">
									{{ csrf_field() }}
									<fieldset>
										<div class="row">
											<label class="col-sm-4 col-form-label"></label>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label caption-label">Nombre del proyecto</label>
											<div class="col-sm-10">
												<textarea name="npyDenom" class="form-control form-control-sm"></textarea>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label caption-label">Nombre corto del proy</label>
											<div class="col-sm-10">
												<input name="npyShortdenom" type="text" class="form-control form-control-sm">
											</div>
										</div>
										<div class="row">
											<div class="col">
												<div class="form-group row">
													<label class="col-sm-4 col-form-label pt-0 caption-label">Código SNIP</label>
													<div class="col-sm-8">
														<input name="npySnip" type="text" class="form-control form-control-sm">
													</div>
												</div>
											</div>
											<div class="col">
												<div class="form-group row">
													<label class="col-sm-4 col-form-label pt-0 caption-label">Código Unificado</label>
													<div class="col-sm-8">
														<input name="npyCu" type="text" class="form-control form-control-sm">
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col">
												<div class="form-group row">
													<label class="col-sm-4 col-form-label pt-0 caption-label">Resolución aprobación</label>
													<div class="col-sm-8">
														<input name="npyResol" type="text" class="form-control form-control-sm">
													</div>
												</div>
											</div>
											<div class="col">
												<div class="form-group row">
													<label class="col-sm-4 col-form-label pt-0 caption-label">Fecha de resolución</label>
													<div class="col-sm-8">
														<input name="npyDateresol" type="date" class="form-control form-control-sm">
													</div>
												</div>
											</div>
										</div>
									</fieldset>
								</form>
							</div>
							<div class="card-footer">
								<div class="float-right">
									<button class="btn btn-success btn-sm" onclick="registrar_proyecto($('#frmRegisterProject'), event, 'dtaPrj')">Guardar y Continuar</button>
									<a href="{{ url('proyecto') }}" class="btn btn-secondary btn-sm">Cancelar</a>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="seleccion" role="tabpanel" aria-labelledby="ps-tab">
						<div class="card" style="boder-top:none">
							<div class="card-body">
								<form id="frmRegisterProcess" action="nuevo/prc" enctype="multipart/form-data">
									{{ csrf_field() }}
									<input type="hidden" name="hnpyId" id="pyId">
									<fieldset>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label pt-0 caption-label">Proyecto</label>
											<div class="col-sm-5">
												<input class="form-control-plaintext" type="text" id="pyNameStored" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label pt-0 caption-label">Nomenclatura</label>
											<div class="col-sm-5">
												<input class="form-control form-control-sm" type="text" name="npcNom" id="pcNom">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label pt-0 caption-label">Identificador</label>
											<div class="col-sm-5">
												<input class="form-control form-control-sm" type="text" name="npcSeace" id="pcSeace">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label pt-0 caption-label">Documento</label>
											<div class="col-sm-5">
												<input class="form-control form-control-sm" type="file" name="npcFileSeace" id="pcFileSeace">
												<progress class="form-control form-control-sm" value="0"></progress>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label pt-0 caption-label">Postores</label>
											<div class="col-sm-1">
												<button type="button" class="btn btn-primary btn-sm" onclick="agregar_fila($('#tblPostorSelection'))"><i class="fas fa-plus"></i> Añadir Postor</button>
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
															<input type="number" class="form-control-plaintext psId" name="npsId[]" readonly>
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
												</tbody>
											</table>
										</div>
									</fieldset>
								</form>
							</div>
							<div class="card-footer">
								<div class="float-right">
									<button class="btn btn-success btn-sm" onclick="registrar_proyecto($('#frmRegisterProcess')[0], event, 'dtaPrc')">Guardar y Continuar</button>
									<a href="{{ url('proyecto') }}" class="btn btn-secondary btn-sm">Cancelar</a>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="ejecucion" role="tabpanel" aria-labelledby="ed-tab">
						<div class="card" style="border-top:none">
							<div class="card-body">
								<form id="frmRegisterExecution" action="nuevo/exec">
									{{ csrf_field() }}
									<input type="hidden" name="henpyId" id="epyId">
									<fieldset>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label pt-0 caption-label">Proyecto</label>
											<div class="col-sm-5">
												<input class="form-control-plaintext" type="text" id="epyNameStored" readonly>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label pt-0 caption-label">Modalidad ejecución</label>
											<div class="col-sm-3">
												<select name="nejeMod" class="form-control form-control-sm">
													<option value="NA">-- Seleccione un opción--</option>
													<option value="AD"> Administración directa </option>
													<option value="AI"> Por contrata </option>
												</select>
											</div>
											<label class="col-sm-2 col-form-label pt-0 caption-label">Sistema contratación</label>
											<div class="col-sm-3">
												<select name="nejeContract" class="form-control form-control-sm">
													<option value="NA">-- Seleccione un opción--</option>
													<option value="PU"> Precios unitarios </option>
													<option value="SA"> Suma alzada </option>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label pt-0 caption-label">Monto del contrato</label>
											<div class="col-sm-3">
												<input type="text" class="form-control form-control-sm" name="nejeMountContract" id="txtMountCt" placeholder="Monto Inc. IGV">
											</div>
											<label class="col-sm-2 col-form-label pt-0 caption-label">Monto del valor ref.</label>
											<div class="col-sm-3">
												<input type="text" class="form-control form-control-sm" name="nejeMountRefValue" id="txtMountVr" placeholder="Monto Inc. IGV">
											</div>
											<div class="col-sm-2">
												<input type="text" class="form-control form-control-sm" name="nejeRelFactor" id="txtRelFac" placeholder="F.R." readonly>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label caption-label">Contratista ejecutor</label>
											<div class="col-sm-9 pr-0" id="divContratista">
												
											</div>
										</div>
										<div class="form-group row">
											<div class="col">
												<div class="form-group row">
													<label class="col-sm-6 col-form-label caption-label">Fecha convenio</label>
													<div class="col-sm-6">
														<input name="nejeDateAgree" type="date" class="form-control form-control-sm">
													</div>
												</div>
											</div>
											<div class="col">
												<div class="form-group row">
													<label class="col-sm-4 col-form-label caption-label">Plazo (meses)</label>
													<div class="col-sm-8 pl-0">
														<input name="nejeMonthTerm" type="number" class="form-control form-control-sm">
													</div>
												</div>
											</div>
											<div class="col">
												<div class="form-group row">
													<label class="col-sm-4 col-form-label caption-label">Plazo (días)</label>
													<div class="col-sm-8 pl-0">
														<input name="nejeDaysTerm" type="number" class="form-control form-control-sm">
													</div>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col">
												<div class="form-group row">
													<label class="col-sm-4 col-form-label pt-0 caption-label">Fecha de Inicio Contractual</label>
													<div class="col-sm-8">
														<input name="nejeStartDate" type="date" class="form-control form-control-sm">
													</div>
												</div>
											</div>
											<div class="col">
												<div class="form-group row">
													<label class="col-sm-4 col-form-label pt-0 caption-label">Fecha de Término Contractual</label>
													<div class="col-sm-8 pl-0">
														<input name="nejeEndDate" type="date" class="form-control form-control-sm">
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
														<th>ID</th>
														<th>DNI</th>
														<th>Profesional</th>
														<th>Cargo</th>
														<th></th>
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
												</tbody>
											</table>
										</div>
									</fieldset>
								</form>
							</div>
							<div class="card-footer">
								<div class="float-right">
									<button class="btn btn-success btn-sm" onclick="registrar_proyecto($('#frmRegisterExecution'), event, 'dtaExe')">Guardar y Terminar</button>
									<a href="{{ url('proyecto') }}" class="btn btn-secondary btn-sm">Cancelar</a>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="profesionales" role="tabpanel" aria-labelledby="eqd-tab">
						<div class="card" style="border-top:none">
							<div class="card-body">
								<fieldset>
									
								</fieldset>
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

	$('.psRuc').on('keypress', function(evt){

		if(evt.which == 13){
			
			var row = $(this).closest('tr');
			var key = $(this).val();
			var url = '{{ url('mostrar/jrd') }}' + '/' + key;

			$.get(url, function(data){
				
				if(data != null || data != ''){
					row.find('input.psId').val(data.prjId);
					row.find('input.psRazonSocial').val(data.prjBusiName);
					row.find('input.psRepLegal').val(data.prjLegalRepName + ' ' + data.prjLegalRepPaterno + ' ' + data.prjLegalRepMaterno);
					row.find('input.psAddress').val(data.prjEaddress + ' - ' + data.prjPaddress);
				}
				else{
					row.find('input.psId').val('');
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

</script>