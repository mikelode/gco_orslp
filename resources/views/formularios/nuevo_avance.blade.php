<form id="frmCreateProgress" action="{{ url('avance/nuevo') }}">
	{{ csrf_field() }}
	<div class="form-group row mb-1">
		<label class="col-form-label col-md-3 caption-label">Equipo Profesional: </label>
		<div class="col-md-9">
			@foreach($prf as $p)
				<p class="mb-0">
					@if($p->prfJob == 'RESIDENTE')
						<input type="text" class="form-control-plaintext form-control-sm" id="pyResidente" name="npyResidente" value="{{ $p->prfJob . ': ' . $p->individualData->perFullName }}" readonly>
						<input type="hidden" name="hnpyResidente" value="{{ $p->individualData->perId }}">
					@elseif($p->prfJob == 'SUPERVISOR' || $p->prfJob == 'INSPECTOR')
						<input type="text" class="form-control-plaintext form-control-sm" id="pySupervisor" name="npySupervisor" value="{{ $p->prfJob . ': ' . $p->individualData->perFullName }}" readonly>
						<input type="hidden" name="hnpySupervisor" value="{{ $p->individualData->perId }}">
					@else
						<input type="text" class="form-control-plaintext form-control-sm" value="{{ $p->prfJob . ': ' . $p->individualData->perFullName }}" readonly>
					@endif
				</p>
			@endforeach
		</div>
	</div>
	<div class="form-group row mb-1">
		<label class="col-form-label col-md-3 caption-label">Ejecutor: </label>
		<div class="col-md-9">
			<input type="text" class="form-control-plaintext form-control-sm" id="pyEjecutor" name="npyEjecutor" value="{{ $pst->individualData->prjBusiName }}" readonly>
			<input type="hidden" name="hnpyEjecutor" value="{{ $exe->ejeId }}">
		</div>
	</div>
	<div class="form-group row mb-1">
		<label class="col-form-label col-md-3 caption-label">Proyecto: </label>
		<div class="col-md-9">
			<div class="form-control-plaintext form-control-sm" id="pyDenom">{{ $pry->pryDenomination }}</div>
			<input type="hidden" name="hnpyId" value="{{ $pry->pryId }}">
		</div>
	</div>
	<div class="form-group row mb-1">
		<label class="col-form-label col-md-3 caption-label">Presupuesto:</label>
		<div class="col-md-9">
			<input type="text" class="form-control-plaintext form-control-sm" id="avPto" name="navPto" value="{{ $pto->preName }}" readonly>
			<input type="hidden" name="hnavPto" id="havPto" value="{{ $pto->preId }}">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-form-label col-md-3 caption-label">Valorización Nro:</label>
		<div class="col-md-9">
			<select class="form-control form-control-sm" name="navNumber">
				@foreach($crn as $c)
				<option value="{{ $c->prgId }}">{{ $c->prgNumberVal.' : de '.$c->prgStartPeriod . ' al ' . $c->prgEndPeriod }}</option>
				@endforeach
			</select>
		</div>
	</div>
</form>