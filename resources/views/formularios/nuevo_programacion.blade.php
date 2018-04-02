<div class="col-md-10 pr-0">
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header py-0">
									Plazo de Ejecución
								</div>
								<div class="card-body py-0">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group row mb-0">
												<label class="col-md-5 col-form-label">Meses</label>
												<div class="col-md-7">
													<input type="text" class="form-control-plaintext" id="pyMesesPlazo" name="npyMesesPlazo" value="{{ $eje[0]->ejeMonthTerm }} meses" readonly>
												</div>
											</div>
											<div class="form-group row mb-0">
												<label class="col-md-5 col-form-label">Días</label>
												<div class="col-md-7">
													<input type="text" class="form-control-plaintext" id="pyDiasPlazo" name="npyDiasPlazo" value="{{ $eje[0]->ejeDaysTerm }} días" readonly>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group row mb-0">
												<label class="col-md-5 col-form-label">Inicio de Obra</label>
												<div class="col-md-7">
													<input type="date" class="form-control-plaintext" id="pyFechaInicio" name="npyFechaInicio" value="{{ is_null($eje[0]->ejeStartDate)?null:Carbon\Carbon::parse($eje[0]->ejeStartDate)->format('Y-m-d') }}" readonly>
												</div>
											</div>
											<div class="form-group row mb-0">
												<label class="col-md-5 col-form-label">Término de Obra</label>
												<div class="col-md-7">
													<input type="date" class="form-control-plaintext" id="pyFechaFinal" name="npyFechaFinal" value="{{ is_null($eje[0]->ejeEndDate)?null:Carbon\Carbon::parse($eje[0]->ejeEndDate)->format('Y-m-d') }}" readonly>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Monto Base</label>
												<div class="col-md-7">
													<select class="form-control form-control-sm mt-2" id="pyResumenPto">
														<option value="NA">-- Seleccionar --</option>
														@foreach($resumen[0]->items as $pto)
														<option value="{{ $pto->iprId.'-'.$pto->iprCodeItem }}">{{ $pto->iprItemGeneral }}</option>
														@endforeach()
														<option value="OBM"> OTRO </option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-5 col-form-label">Soles</label>
												<div class="col-md-7">
													<input type="text" readonly id="ptoResumenMonto" class="form-control-plaintext">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="widget mt-3">
								<div class="widget-header">
									<i class="icon-briefcase"></i>
									<h3>Datos del Cronograma Calendarizado</h3>
								</div>
								<div class="widget-content p-0">
									<form action="{{ url('programacion/nuevo') }}" id="frmNewSchedule">
										{{ csrf_field() }}
										<input type="hidden" name="hnpyResumenPto" id="pyInputRsmnPto">
										<input type="hidden" name="hnpyId" id="pyId" value="{{ $pry->pryId }}">
										<input type="hidden" name="hnprId" id="prId" value="{{ $resumen[0]->preId }}">
										<table class="table table-bordered table-sm action-table">
											<thead>
												<tr>
													<th width="20" rowspan="2">Valorización</th>
													<th colspan="2">Periodo</th>
													<th rowspan="2">Monto</th>
													<th rowspan="2">% Avance</th>
													<th rowspan="2">% Acumulado</th>
												</tr>
												<tr>
													<th>Inicial</th>
													<th>Final</th>
												</tr>
											</thead>
											<tbody>
												@foreach($cronograma as $i => $item)
													@if($item['fechai'] != null && $item['fechaf'] != null)
													<tr id="{{ 'val'.($i+1) }}">
														<td><input type="number" name="nvalNumber[]" readonly class="form-control-plaintext" value="{{ $item['val'] }}"></td>
														<td><input type="date" name="nvalPeriodi[]" class="form-control-plaintext" value="{{ $item['fechai']->format('Y-m-d') }}"></td>
														<td><input type="date" name="nvalPeriodf[]" class="form-control-plaintext" value="{{ $item['fechaf']->format('Y-m-d') }}"></td>
														<td><input type="text" name="nvalMount[]" class="form-control-plaintext valMount"></td>
														<td><input type="text" name="nvalPrcnt[]" class="form-control-plaintext valPrcnt"></td>
														<td><input type="text" name="nvalAggrt[]" class="form-control-plaintext valAggrt"></td>
													</tr>
													@else
													<tr id="{{ 'val'.($i+1) }}">
														<td colspan="2"><input type="text" name="" readonly class="form-control-plaintext" value="{{ $item['val'] }}"></td>
														<td><input type="text" class="form-control-plaintext" name="nvalTotal" id="valTotal" value="0"></td>
														<td colspan="2"></td>
													</tr>
													@endif
												@endforeach
											</tbody>
										</table>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-2 pl-1">
	<div class="card border-success">
		<div class="card-header py-1"><b>Operaciones</b></div>
		<div class="card-body px-2">
			@if(Auth::user()->hasPermission(10))
			<button type="button" class="btn btn-sm btn-success btn-block" onclick="registrar_cronograma($('#frmNewSchedule'))">Registrar</button>
			@endif
		</div>
	</div>
</div>

<script type="text/javascript">

	var prevmount;

	$('.valMount').focus(function(evt) {

		if($('#pyResumenPto').val() == 'NA'){
			alert('Seleccione primero el monto base, a partir del cual se calculará el cronograma');
			$(this).blur();
			return;
		}


		if(this.value == '')
			val_prevmount = 0;
		else
			val_prevmount = numeral(this.value).value();

	}).change(function(evt) {

		var row = $(this).closest('tr');
		var prevrow = row.prev('tr');
		var nextrow = row.next('tr');

		var val_mount = numeral(this.value).value();

		if(val_mount == '' || val_mount == null || isNaN(val_mount))
			return;

		var pto_base = numeral($('#ptoResumenMonto').val()).value();
		var pto_total = numeral($('#valTotal').val()).value();
		var val_prcnt = val_mount / pto_base;
		var new_total = pto_total - val_prevmount + val_mount;

		//console.log('Pto_toal: ' + pto_total + ' prevmount: ' + val_prevmount + ' mount:' + val_mount + ' new_Total:' + new_total);

		if(new_total > pto_base){
			alert('Se ha superado el monto total base, revise los montos ingresados para cada periodo');
			return;
		}

		$(row).find('.valPrcnt').val(numeral(val_prcnt).format('0.00%'));

		new_total = 0;
		$('input.valMount').each(function(index, el) {
			valor = ($(el).val()).replace(/[^\d\.]/g,'');
			if(valor == '' || valor == null || isNaN(valor)){
				valor = 0;
			}

			new_total = new_total + parseFloat(valor);
		});

		$('#valTotal').val(numeral(new_total).format('0,0.00'));

		if(prevrow.length == 0){
			val_prevAggrt = 0;
		}
		else{
			val_prevAggrt = numeral(prevrow.find('input.valAggrt').val()).value();
		}
		val_aggrt = val_prevAggrt + val_prcnt;

		$(row).find('.valAggrt').val(numeral(val_aggrt).format('0.00%'));

		if(nextrow.length == 0){
			return;
		}
		else{
			val_nextAggr = $(nextrow).find('input.valAggrt').val();
			if(val_nextAggr == '')
				return;
			else{
				//console.log('refrescando fila: ' + nextrow.prop('id'));
				$(nextrow).find('input.valMount').trigger('focus');
				$(nextrow).find('input.valMount').trigger('change');
			}
		}
	});

	$('#pyResumenPto').change(function(evt) {

		$('#pyInputRsmnPto').val(this.value);

		if(this.value == 'OBM'){
			$('#ptoResumenMonto').attr('readonly', false).focus();
			return;
		}

		$.get('{{ url('monto/presupuesto') }}',{ itemId: this.value }, function(data) {			
			$('#ptoResumenMonto').val(numeral(data).format('0,0.00'));
		});
	});

</script>