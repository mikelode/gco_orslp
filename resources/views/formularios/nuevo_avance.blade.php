<form id="frmCreateProgress" action="{{ url('avance/nuevo') }}">
	{{ csrf_field() }}
	<div class="row">
		<div class="col-md-5">
			<div class="form-group">
				<label">Equipo Profesional: </label>
					@foreach($prf as $p)
						@if($p->prfJob == 'RESIDENTE')
							<input type="text" class="form-control-plaintext form-control-sm" id="pyResidente" name="npyResidente" value="{{ $p->individualData->perFullName }}">
							<input type="hidden" name="hnpyResidente" value="{{ $p->individualData->perId }}">
						@elseif($p->prfJob == 'SUPERVISOR' || $p->prfJob == 'INSPECTOR')
							<input type="text" class="form-control-plaintext form-control-sm" id="pySupervisor" name="npySupervisor" value="{{ $p->individualData->perFullName }}">
							<input type="hidden" name="hnpySupervisor" value="{{ $p->individualData->perId }}">
						@else
							<input type="text" class="form-control-plaintext form-control-sm" value="{{ $p->individualData->perFullName }}">
						@endif
						<p>{{ $p->prfJob }}</p>
					@endforeach
			</div>
		</div>
		<dv class="col-md-7">
			<div class="form-group mb-1">
				<label>Ejecutor: </label>
					<input type="text" class="form-control-plaintext form-control-sm" id="pyEjecutor" name="npyEjecutor" value="{{ $exe->ejeBusiName }}">
					<input type="hidden" name="hnpyEjecutor" value="{{ $exe->ejeId }}">
			</div>
			<div class="form-group mb-1">
				<label>Proyecto: </label>
				<textarea class="form-control-plaintext form-control-sm" id="pyDenom" name="npyDenom" rows="3" readonly>{{ $pry->pryDenomination }}</textarea>
				<input type="hidden" name="hnpyId" value="{{ $pry->pryId }}">
			</div>
			<div class="form-group mb-1">
				<label>Presupuesto:</label>
				<input type="text" class="form-control-plaintext form-control-sm" id="avPto" name="navPto" value="{{ $pto->preType . ' - ' . $pto->preName }}">
				<input type="hidden" name="hnavPto" id="havPto" value="{{ $pto->preId }}">
			</div>
		</dv>
	</div>
	<div class="row">
		<div class="col-md-5">
			<div class="form-group row">
				<label class="col-md-4">Valorización Nro:</label>
				<div class="col-md-6">
					<select class="form-control form-control-sm" name="navNumber">
						@foreach($crn as $c)
						<option value="{{ $c->prgId }}">{{ $c->prgNumberVal.' -> '.$c->prgPeriodo }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4">Periodo</label>
				<div class="col-md-6">
					<select class="form-control form-control-sm" id="avPeriod" name="navPeriod">
						<option value="MENSUAL">Mensual</option>
						<option value="SEMANAL">Semanal</option>
						<option value="QUINCENAL">Quincenal</option>
						<option value="DIAS-CONTADOS">Días contados</option>
					</select>
				</div>
			</div> 
		</div>
		<div class="col-md-7">
			<div class="form-group row">
				<label class="col-md-3">Fecha Inicial</label>
				<div class="col-md-6">
					<input type="date" class="form-control form-control-sm" name="navStartDate">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-3">Fecha Final</label>
				<div class="col-md-6">
					<input type="date" class="form-control form-control-sm" name="navEndDate">
				</div>
			</div>
		</div>
	</div>
</form>