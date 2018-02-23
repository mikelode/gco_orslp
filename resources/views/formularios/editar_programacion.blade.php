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
										<div class="col-sm-4">
											<div class="form-group row mb-0">
												<label class="col-sm-5 col-form-label">Meses</label>
												<div class="col-sm-7">
													<input type="text" class="form-control-plaintext" id="pyMesesPlazo" name="npyMesesPlazo" value="{{ $pry->pryMonthTerm }} meses" readonly>
												</div>
											</div>
											<div class="form-group row mb-0">
												<label class="col-sm-5 col-form-label">Días</label>
												<div class="col-sm-7">
													<input type="text" class="form-control-plaintext" id="pyDiasPlazo" name="npyDiasPlazo" value="{{ $pry->pryDaysTerm }} días" readonly>
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group row mb-0">
												<label class="col-sm-5 col-form-label">Inicio de Obra</label>
												<div class="col-sm-7">
													<input type="date" class="form-control-plaintext" id="pyFechaInicio" name="npyFechaInicio" value="{{ Carbon\Carbon::parse($pry->pryStartDateExe)->format('Y-m-d') }}" readonly>
												</div>
											</div>
											<div class="form-group row mb-0">
												<label class="col-sm-5 col-form-label">Término de Obra</label>
												<div class="col-sm-7">
													<input type="date" class="form-control-plaintext" id="pyFechaFinal" name="npyFechaFinal" value="{{ Carbon\Carbon::parse($pry->pryEndDateExe)->format('Y-m-d') }}" readonly>
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group row">
												<label class="col-sm-5 col-form-label">Monto Base</label>
												<div class="col-sm-7">
													<select class="mt-2" id="pyResumenPto">
														<option value="NA">-- Seleccionar --</option>
														<?php $rsmMount = 0; ?>
														@foreach($resumen as $pto)
															@if($pto->preId == $pry->pryBaseBudget)
															<option value="{{ $pto->preId.'-'.$pto->preCodeItem }}" selected>{{ $pto->preItemGeneral }}</option>
															<?php $rsmMount = $pto->preItemGeneralMount; ?>
															@else
															<option value="{{ $pto->preId.'-'.$pto->preCodeItem }}">{{ $pto->preItemGeneral }}</option>
															@endif
														@endforeach()
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-5 col-form-label">Soles</label>
												<div class="col-sm-7">
													<input type="text" readonly id="ptoResumenMonto" class="form-control-plaintext" value="{{ number_format($rsmMount,2,'.',',') }}">
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
									<div class="float-right">
										<button type="button" class="btn btn-secondary btn-sm mr-2 mb-1" id="btnAddPeriod" style="display: none;" onclick="agregar_periodo($('#tblSchedule'))">Agregar Periodo</button>
										<button type="button" class="btn btn-info btn-sm mr-2 mb-1" id="btnEditSchedule" style="display: none;" onclick="actualizar_cronograma($('#frmUpdateSchedule'))">Guardar Cambios</button>
									</div>
								</div>
								<div class="widget-content p-0">
									<form action="{{ url('actualizar/programacion') }}" id="frmUpdateSchedule">
										{{ csrf_field() }}
										<input type="hidden" name="hnpyId" id="pyId" value="{{ $pry->pryId }}">
										<table class="table table-bordered table-sm action-table" id="tblSchedule">
											<thead>
												<tr>
													<th width="20">Valorización</th>
													<th>Periodo</th>
													<th>Monto</th>
													<th>% Avance</th>
													<th>% Acumulado</th>
													<th>Nota</th>
													<th>Acción</th>
												</tr>
											</thead>
											<tbody id="cuerpo">
												<?php $total = 0; ?>
												@foreach($cronograma as $i => $item)
													<tr id="{{ 'val-'.$item->prgNumberVal }}">
														<td>
															<input type="hidden" name="hnvalId[]" value="{{ $item->prgId }}">
															<input type="number" name="nvalNumber[]" readonly class="form-control-plaintext" value="{{ $item->prgNumberVal }}">
														</td>
														<td>
															<input type="date" name="nvalPeriod[]" readonly class="form-control-plaintext cronoedit" value="{{ $item->prgPeriodo }}" >
														</td>
														<td>
															<input type="text" name="nvalMount[]" readonly class="form-control-plaintext valMount cronoedit" value="{{ number_format($item->prgMount,2,'.',',') }}">
														</td>
														<td>
															<input type="text" name="nvalPrcnt[]" readonly class="form-control-plaintext valPrcnt cronoedit" value="{{ ($item->prgPercent * 100) . '%' }}">
														</td>
														<td>
															<input type="text" name="nvalAggrt[]" readonly class="form-control-plaintext valAggrt cronoedit" value="{{ ($item->prgAggregate * 100) . '%' }}">
														</td>
														<td>
															<textarea name="nvalNote[]" readonly="readonly" class="textarea-cell cronoedit" rows="1" cols="10">{{ $item->prgEditNote }}</textarea>
														</td>
														<td></td>
													</tr>
													<?php $total = $total + $item->prgMount; ?>
												@endforeach
											</tbody>
											<tfoot>
												<tr>
													<td colspan="2">
														<input type="text" name="" readonly class="form-control-plaintext" value="TOTAL" >
													</td>
													<td>
														<input type="text" class="form-control-plaintext" name="nvalTotal" id="valTotal" value="{{ number_format($total,2,'.',',') }}">
													</td>
													<td colspan="4"></td>
												<tr>
											</tfoot>
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
			<button type="button" id="btnActionEdit" class="btn btn-sm btn-info btn-block" onclick="editar_cronograma($(this),$('#frmUpdateSchedule'))" value="editar">Editar Cronograma</button>
			<button type="button" id="btnActionDelete" class="btn btn-sm btn-danger btn-block">Eliminar</button>
		</div>
	</div>
</div>

<script type="text/javascript">

	$('#tblSchedule').on('focusin', '.valMount', function() {
		
		if($('#pyResumenPto').val() == 'NA'){
			alert('Seleccione primero el monto base, a partir del cual se calculará el cronograma');
			$(this).blur();
			return;
		}

		if(this.value == '')
			val_prevmount = 0;
		else
			val_prevmount = numeral(this.value).value();

	}).on('change', '.valMount', function(event) {
		
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

		console.log('Pto_toal: ' + pto_total + ' prevmount: ' + val_prevmount + ' mount:' + val_mount + ' new_Total:' + new_total);

		if(new_total > pto_base){
			alert('Se ha superado el monto total base, revise los montos ingresados para cada periodo');
			return;
		}

		$('#valTotal').val(numeral(new_total).format('0,0.00'));
		$(row).find('.valPrcnt').val(numeral(val_prcnt).format('0.00%'));

		if(prevrow.length == 0){
			val_prevAggrt = 0;
		}
		else{
			val_prevAggrt = numeral(prevrow.find('input.valAggrt').val()).value();
		}
		console.log('prevaggrt:' + val_prevAggrt + ' prcnt:' + val_prcnt);
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
				console.log('refrescando fila: ' + nextrow.prop('id'));
				$(nextrow).find('input.valMount').trigger('focus');
				$(nextrow).find('input.valMount').trigger('change');
			}
		}

	});

	$('#pyResumenPto').change(function(evt) {
		$.get('{{ url('monto/presupuesto') }}',{ ptoId: this.value }, function(data) {			
			$('#ptoResumenMonto').val(numeral(data).format('0,0.00'));
		});
	});

</script>