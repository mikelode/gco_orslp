<div class="row">
	<div class="col-md-12">
		<div class="widget">
			<div class="widget-header">
				<i class="icon-briefcase"></i>
				<h3>Edición de los Datos del Proyecto</h3>
			</div>
			<div class="widget-content">
				<form id="frmEditProject" action="editar/pry">
					{{ csrf_field() }}
					<input type="hidden" name="npyId" value="{{ $proyecto->pryId }}">
					<input type="hidden" name="nejId" value="{{ $ejecutor->ejeId }}">
					<fieldset>
						<div class="row">
							<label class="col-sm-4 col-form-label text-info font-weight-bold">DATOS GENERALES</label>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Nombre del proyecto</label>
							<div class="col-sm-10">
								<textarea name="npyDenom" class="form-control form-control-sm"> {{ $proyecto->pryDenomination }} </textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Nombre corto del proy</label>
							<div class="col-sm-10">
								<input name="npyShortdenom" type="text" class="form-control form-control-sm" value="{{ $proyecto->pryShortDenomination }}">
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label pt-0">Código SNIP</label>
									<div class="col-sm-8">
										<input name="npySnip" type="text" class="form-control form-control-sm" value="{{ $proyecto->prySnip }}">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label pt-0">Código Unificado</label>
									<div class="col-sm-8">
										<input name="npyCu" type="text" class="form-control form-control-sm" value="{{ $proyecto->pryUnifiedCode }}">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label pt-0">Resolución aprobación</label>
									<div class="col-sm-8">
										<input name="npyResol" type="text" class="form-control form-control-sm" value="{{ $proyecto->pryViabilityResolution }}">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label pt-0">Fecha de resolución</label>
									<div class="col-sm-8">
										<input name="npyDateresol" type="date" class="form-control form-control-sm" value="{{ $proyecto->pryDateResolution }}">
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label pt-0">Modalidad ejecución</label>
							<div class="col-sm-10">
								<select name="npyMod" class="form-control form-control-sm">
									<option value="NA" {{ $proyecto->pryExeMode=='NA'?'selected':'' }}>-- Seleccione un opción--</option>
									<option value="AD" {{ $proyecto->pryExeMode=='AD'?'selected':'' }}> Administración directa </option>
									<option value="AI" {{ $proyecto->pryExeMode=='AI'?'selected':'' }}> Administración indirecta o contrata </option>
								</select>
							</div>
						</div>
					</fieldset>
					<fieldset>
						<div class="row">
							<label class="col-sm-4 col-form-label text-info font-weight-bold">DATOS DE LA EJECUCIÓN</label>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Contratista ejecutor</label>
							<div class="col-sm-9 px-0">
								<input name="nejDenom" type="text" class="form-control form-control-sm" placeholder="NOMBRE O DENOMINACION" value="{{ $ejecutor->ejeBusiName }}">
							</div>
							<div class="col pl-0">
								<input name="nejSigla" type="text" class="form-control form-control-sm" placeholder="SIGLAS" value="{{ $ejecutor->ejeAcronym }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Tipo persona</label>
							<div class="col-sm-3 pl-0">
								<select name="nejPers" class="form-control form-control-sm">
									<option value="NA" {{ $ejecutor->ejePersonType=='NA'?'selected':'' }}>-- Seleccione un opción--</option>
									<option value="PN" {{ $ejecutor->ejePersonType=='PN'?'selected':'' }}> Persona Natural </option>
									<option value="PJ" {{ $ejecutor->ejePersonType=='PJ'?'selected':'' }}> Persona Jurídica </option>
								</select>
							</div>
							<div class="col-sm-4">
								<select name="nejTipodoc" class="form-control form-control-sm">
									<option value="NA" {{ $ejecutor->ejeRegistType=='NA'?'selected':'' }}>-- Tipo de documento --</option>
									<option value="DNI" {{ $ejecutor->ejeRegistType=='DNI'?'selected':'' }}> Documento Nacional de Identidad </option>
									<option value="RUC" {{ $ejecutor->ejeRegistType=='RUC'?'selected':'' }}> Registro Único del Contribuyente </option>
								</select>
							</div>
							<div class="col-sm-3">
								<input name="nejNumdoc" type="number" class="form-control form-control-sm" value="{{ $ejecutor->ejeRegistNumber }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label ">Representante legal</label>
							<div class="col-sm-2 pl-0">
								<input name="nejRepdni" type="text" class="form-control form-control-sm" placeholder="DNI" value="{{ $ejecutor->ejeLegalRepDni }}">
							</div>
							<div class="col-sm-3 pl-0">
								<input name="nejRepname" type="text" class="form-control form-control-sm" placeholder="NOMBRES" value="{{ $ejecutor->ejeLegalRepName }}">
							</div>
							<div class="col-sm-3 pl-0">
								<input name="nejReppat" type="text" class="form-control form-control-sm" placeholder="APELLIDO PATERNO" value="{{ $ejecutor->ejeLegalRepPaterno }}">
							</div>
							<div class="col-sm-2 pl-0">
								<input name="nejRepmat" type="text" class="form-control form-control-sm" placeholder="APELLIDO MATERNO" value="{{ $ejecutor->ejeLegalRepMaterno }}">
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-6 col-form-label pt-0">Fecha convenio</label>
									<div class="col-sm-6 pl-0">
										<input name="npyDateAgree" type="date" class="form-control form-control-sm" value="{{ $proyecto->pryDateAgree }}">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Plazo (meses)</label>
									<div class="col-sm-8 pl-0">
										<input name="npyMonthTerm" type="number" class="form-control form-control-sm" value="{{ $proyecto->pryMonthTerm }}">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Plazo (días)</label>
									<div class="col-sm-8 pl-0">
										<input name="npyDaysTerm" type="number" class="form-control form-control-sm" value="{{ $proyecto->pryDaysTerm }}">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label pt-0">Fecha de Inicio</label>
									<div class="col-sm-8 pl-0">
										<input name="npyStartDate" type="date" class="form-control form-control-sm" value="{{ $proyecto->pryStartDateExe }}">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label pt-0">Fecha de Término Inicial</label>
									<div class="col-sm-8 pl-0">
										<input name="npyEndDate" type="date" class="form-control form-control-sm" value="{{ $proyecto->pryEndDateExe }}">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="col-form-label text-info font-weight-bold mx-3">Equipo profesional</label>
							<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#mdlPersona">
								Agregar<span class="oi oi-plus ml-1"></span>
							</button>
						</div>
						<div class="form-group row">
							<table class="table table-condensed" id="tblProfessionalTeam">
								<tbody>
									@foreach($equipo as $prof)
									<tr>
										<td width="10%">
											<input type="hidden" value="{{ $prof->prfPerson }}">
											<input type="text" class="form-control form-control-sm" value="{{ $prof->individualData->perDni }}" readonly>
										</td>
										<td width="20%">
											<a href="#" id="prfJob" data-type="select" data-title="Cambiar cargo" data-pk="{{ $prof->prfId }}" class="editJob">{{ $prof->prfJob }}</a>
										</td>
										<td width="60%">
											<input type="text" readonly class="form-control-plaintext" value="{{ $prof->individualData->perFullName }}">
										</td>
										<td width="10%">
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
					<fieldset>
						<button class="btn btn-success" onclick="actualizar_proyecto($('#frmEditProject'), event)">Guardar Cambios</button>
						<a href="{{ url('proyecto') }}" class="btn btn-secondary">Salir</a>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="mdlPersona" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title">Agregar Persona</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="frmAppendPersona" action="nuevo/prs">
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

</script>