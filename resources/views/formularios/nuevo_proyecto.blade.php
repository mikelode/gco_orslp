<div class="row">
	<div class="col-md-12">
		<div class="widget">
			<div class="widget-header">
				<i class="icon-briefcase"></i>
				<h3>Datos del Proyecto</h3>
			</div>
			<div class="widget-content">
				<form id="frmRegisterProject" action="nuevo/pry">
					{{ csrf_field() }}
					<fieldset>
						<div class="row">
							<label class="col-sm-4 col-form-label text-info font-weight-bold">DATOS GENERALES</label>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Nombre del proyecto</label>
							<div class="col-sm-10">
								<textarea name="npyDenom" class="form-control form-control-sm"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Nombre corto del proy</label>
							<div class="col-sm-10">
								<input name="npyShortdenom" type="text" class="form-control form-control-sm">
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label pt-0">Código SNIP</label>
									<div class="col-sm-8">
										<input name="npySnip" type="text" class="form-control form-control-sm">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label pt-0">Código Unificado</label>
									<div class="col-sm-8">
										<input name="npyCu" type="text" class="form-control form-control-sm">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label pt-0">Resolución aprobación</label>
									<div class="col-sm-8">
										<input name="npyResol" type="text" class="form-control form-control-sm">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label pt-0">Fecha de resolución</label>
									<div class="col-sm-8">
										<input name="npyDateresol" type="date" class="form-control form-control-sm">
									</div>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label pt-0">Modalidad ejecución</label>
							<div class="col-sm-10">
								<select name="npyMod" class="form-control form-control-sm">
									<option value="NA">-- Seleccione un opción--</option>
									<option value="AD"> Administración directa </option>
									<option value="AI"> Administración indirecta o contrata </option>
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
								<input name="nejDenom" type="text" class="form-control form-control-sm" placeholder="NOMBRE O DENOMINACION">
							</div>
							<div class="col pl-0">
								<input name="nejSigla" type="text" class="form-control form-control-sm" placeholder="SIGLAS">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Tipo persona</label>
							<div class="col-sm-3 pl-0">
								<select name="nejPers" class="form-control form-control-sm">
									<option value="NA">-- Seleccione un opción--</option>
									<option value="PN"> Persona Natural </option>
									<option value="PJ"> Persona Jurídica </option>
								</select>
							</div>
							<div class="col-sm-4">
								<select name="nejTipodoc" class="form-control form-control-sm">
									<option value="NA">-- Tipo de documento--</option>
									<option value="DNI"> Documento Nacional de Identidad </option>
									<option value="RUC"> Registro Único del Contribuyente </option>
								</select>
							</div>
							<div class="col-sm-3">
								<input name="nejNumdoc" type="number" class="form-control form-control-sm" placeholder="Nro de documento">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label">Representante legal</label>
							<div class="col-sm-2 pl-0">
								<input name="nejRepdni" type="text" class="form-control form-control-sm" placeholder="DNI">
							</div>
							<div class="col-sm-3 pl-0">
								<input name="nejRepname" type="text" class="form-control form-control-sm" placeholder="NOMBRES">
							</div>
							<div class="col-sm-3 pl-0">
								<input name="nejReppat" type="text" class="form-control form-control-sm" placeholder="APELLIDO PATERNO">
							</div>
							<div class="col-sm-2 pl-0">
								<input name="nejRepmat" type="text" class="form-control form-control-sm" placeholder="APELLIDO MATERNO">
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-6 col-form-label">Fecha convenio</label>
									<div class="col-sm-6 pl-0">
										<input name="npyDateAgree" type="date" class="form-control form-control-sm">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Plazo (meses)</label>
									<div class="col-sm-8 pl-0">
										<input name="npyMonthTerm" type="number" class="form-control form-control-sm">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Plazo (días)</label>
									<div class="col-sm-8 pl-0">
										<input name="npyDaysTerm" type="number" class="form-control form-control-sm">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label pt-0">Fecha de Inicio</label>
									<div class="col-sm-8 pl-0">
										<input name="npyStartDate" type="date" class="form-control form-control-sm">
									</div>
								</div>
							</div>
							<div class="col">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label pt-0">Fecha de Término Inicial</label>
									<div class="col-sm-8 pl-0">
										<input name="npyEndDate" type="date" class="form-control form-control-sm">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="col-form-label text-info font-weight-bold mx-3">EQUIPO PROFESIONAL</label>
							<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#mdlPersona">
								Agregar<span class="oi oi-plus ml-1"></span>
							</button>
						</div>
						<div class="form-group row">
							<table class="table table-condensed" id="tblProfessionalTeam">
								<tbody>
								</tbody>
							</table>
						</div>
					</fieldset>
					<fieldset>
						<button class="btn btn-success" onclick="registrar_proyecto($('#frmRegisterProject'), event)">Guardar Cambios</button>
						<a href="{{ url('proyecto') }}" class="btn btn-secondary">Cancelar</a>
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

</script>