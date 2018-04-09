<div class="col-md-12">
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-10">
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
													<input type="text" class="form-control-plaintext" id="pyMesesPlazo" name="npyMesesPlazo" value="{{ $eje[0]->ejeMonthTerm }} meses" readonly>
												</div>
											</div>
											<div class="form-group row mb-0">
												<label class="col-sm-5 col-form-label">Días</label>
												<div class="col-sm-7">
													<input type="text" class="form-control-plaintext" id="pyDiasPlazo" name="npyDiasPlazo" value="{{ $eje[0]->ejeDaysTerm }} días" readonly>
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group row mb-0">
												<label class="col-sm-5 col-form-label">Inicio de Obra</label>
												<div class="col-sm-7">
													<input type="date" class="form-control-plaintext" id="pyFechaInicio" name="npyFechaInicio" value="{{ is_null($eje[0]->ejeStartDate) ? null : Carbon\Carbon::parse($eje[0]->ejeStartDate)->format('Y-m-d') }}" readonly>
												</div>
											</div>
											<div class="form-group row mb-0">
												<label class="col-sm-5 col-form-label">Término de Obra</label>
												<div class="col-sm-7">
													<input type="date" class="form-control-plaintext" id="pyFechaFinal" name="npyFechaFinal" value="{{ is_null($eje[0]->ejeEndDate) ? null : Carbon\Carbon::parse($eje[0]->ejeEndDate)->format('Y-m-d') }}" readonly>
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group row">
												<label class="col-sm-5 col-form-label">Monto Base</label>
												<div class="col-sm-7">
													<select class="form-control form-control-sm mt-2" id="pyResumenPto">
														<option value="NA">-- Seleccionar --</option>
														<?php $rsmMount = 0; ?>
														@foreach($resumen as $pto)
															@if($pto->iprId == $pry->pryBaseBudget)
															<option value="{{ $pto->iprId.'-'.$pto->iprCodeItem }}" selected>{{ $pto->iprItemGeneral }}</option>
															<?php $rsmMount = $pto->iprItemGeneralMount; ?>
															@else
															<option value="{{ $pto->iprId.'-'.$pto->iprCodeItem }}">{{ $pto->iprItemGeneral }}</option>
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
						<div class="col-md-2 pl-1">
							<div class="card border-success">
								<div class="card-header py-1"><b>Operaciones</b></div>
								<div class="card-body px-2">
									@if(Auth::user()->hasPermission(11))
									<button type="button" id="btnActionEdit" class="btn btn-sm btn-info btn-block" onclick="editar_cronograma($(this),$('#frmUpdateSchedule'))" value="editar">Editar Cronograma</button>
									@endif
									@if(Auth::user()->hasPermission(12))
									<button type="button" id="btnActionDelete" class="btn btn-sm btn-danger btn-block">Eliminar</button>
									@endif
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card mt-3">
								<div class="card-header">
									<p style="display: inline;"><i class="fas fa-calendar"></i> Datos del Cronograma Calendarizado</p>
									<div class="float-right">
										<button type="button" class="btn btn-secondary btn-sm mr-2 mb-1" id="btnAddPeriod" style="display: none;" onclick="agregar_periodo($('#tblSchedule'))">Agregar Periodo</button>
										<button type="button" class="btn btn-info btn-sm mr-2 mb-1" id="btnEditSchedule" style="display: none;" onclick="actualizar_cronograma($('#frmUpdateSchedule'))">Guardar
										</button>
									</div>
								</div>
								<div class="card-body p-0">
									<form action="{{ url('actualizar/programacion') }}" id="frmUpdateSchedule">
										{{ csrf_field() }}
										<input type="hidden" name="hnpyId" id="pyId" value="{{ $pry->pryId }}">
										<input type="hidden" name="hnptId" id="ptId" value="{{ $resumen[0]->iprBudget }}">
										<table class="table table-bordered table-sm action-table" id="tblSchedule">
											<thead>
												<tr>
													<th width="5%" rowspan="2">Val</th>
													<th colspan="2">Periodo</th>
													<th width="7%" rowspan="2">Monto</th>
													<th width="5%" rowspan="2">% Avance</th>
													<th width="5%" rowspan="2">% Acum</th>
													<th rowspan="2">Nota</th>
													<th rowspan="2"><img src="{{ asset('/img/fileattach_24.png') }}"></th>
													<th colspan="3">Estado de Obra</th>
												</tr>
												<tr>
													<th>Inicial</th>
													<th>Final</th>
													<th>Valoriz</th>
													<th>Ejecución</th>
													<th>Pago</th>
												</tr>
											</thead>
											<tbody id="cuerpo">
												<?php $total = 0; ?>
												@foreach($cronograma as $i => $item)
													<tr id="{{ 'val-'.$item->prgNumberVal }}" data-key="{{ $item->prgId }}">
														<td>
															<input type="hidden" name="hnvalId[]" value="{{ $item->prgId }}">
															<input type="number" name="nvalNumber[]" readonly class="form-control-plaintext" value="{{ $item->prgNumberVal }}">
														</td>
														<td>
															<input type="date" name="nvalPeriodi[]" readonly class="form-control-plaintext {{ $item->prgClosed ? '' : 'cronoedit' }}" value="{{ $item->prgStartPeriod }}" >
														</td>
														<td>
															<input type="date" name="nvalPeriodf[]" readonly class="form-control-plaintext {{ $item->prgClosed ? '' : 'cronoedit' }}" value="{{ $item->prgEndPeriod }}" >
														</td>
														<td>
															<input type="text" name="nvalMount[]" readonly class="form-control-plaintext valMount {{ $item->prgClosed ? '' : 'cronoedit' }}" value="{{ number_format($item->prgMount,2,'.',',') }}">
														</td>
														<td>
															<input type="text" name="nvalPrcnt[]" readonly class="form-control-plaintext valPrcnt {{ $item->prgClosed ? '' : 'cronoedit' }}" value="{{ number_format($item->prgPercent * 100,2,'.','') . '%' }}">
														</td>
														<td>
															<input type="text" name="nvalAggrt[]" readonly class="form-control-plaintext valAggrt {{ $item->prgClosed ? '' : 'cronoedit' }}" value="{{ number_format($item->prgAggregate * 100,2,'.','') . '%' }}">
														</td>
														<td>
															<textarea name="nvalNote[]" readonly="readonly" class="textarea-cell {{ $item->prgClosed ? '' : 'cronoedit' }}" rows="1" cols="10">{{ $item->prgEditNote }}</textarea>
														</td>
														<td>
															@if(\Storage::disk('public')->exists($item->prgPathFile))
															<a href="{{ url('/storage/' . $item->prgPathFile) }}" target="_blank" title="Ver archivo">
																<img src="{{ asset('/img/pdf-file_16.png') }}">
															</a>
																@if(Auth::user()->hasPermission(23))
																<a href="#" data-toggle="modal" data-target="#mdlAttachFile" class="btnAttachFile" title="Cambiar archivo">
																	<img src="{{ asset('/img/refresh_16.png') }}">
																</a>
																@endif
															@else
																@if(Auth::user()->hasPermission(23))
																<a href="#" data-toggle="modal" data-target="#mdlAttachFile" class="btnAttachFile" title="Adjuntar archivo">
																	<img src="{{ asset('/img/upload_file_20.png') }}">
																</a>
																@endif
															@endif
														</td>
														<td>
															@if($item->prgClosed)
															<span class="badge badge-success" style="font-size: .7rem">Concluida</span>
															@else
															Pendiente
															@endif
														</td>
														<td>
															@if(Auth::user()->hasPermission(24))
																@if($item->prgStatus == '')
																<a href="#" data-type="select" data-title="Cambiar Estado" data-pk="{{ $item->prgId }}" data-value="" class="statusExec">No Asignado</a>
																@else
																<a href="#" data-type="select" data-title="Cambiar Estado" data-pk="{{ $item->prgId }}" data-value="{{ $item->prgStatus }}" class="statusExec">
																	@if($item->prgStatus == 'Adelantado')
																	<span class="badge badge-info" style="font-size:.7rem">{{ $item->prgStatus }}</span>
																	@elseif($item->prgStatus == 'Normal')
																	<span class="badge badge-success" style="font-size:.7rem">{{ $item->prgStatus }}</span>
																	@elseif($item->prgStatus == 'Atrazado')
																	<span class="badge badge-warning" style="font-size:.7rem">{{ $item->prgStatus }}</span>
																	@elseif($item->prgStatus == 'Suspendido')
																	<span class="badge badge-secondary" style="font-size:.7rem">{{ $item->prgStatus }}</span>
																	@endif
																</a>
																@endif
															@else
																@if($item->prgStatus == '')
																No Asignado
																@else
																	@if($item->prgStatus == 'Adelantado')
																	<span class="badge badge-info" style="font-size:.7rem">{{ $item->prgStatus }}</span>
																	@elseif($item->prgStatus == 'Normal')
																	<span class="badge badge-success" style="font-size:.7rem">{{ $item->prgStatus }}</span>
																	@elseif($item->prgStatus == 'Atrazado')
																	<span class="badge badge-warning" style="font-size:.7rem">{{ $item->prgStatus }}</span>
																	@elseif($item->prgStatus == 'Suspendido')
																	<span class="badge badge-secondary" style="font-size:.7rem">{{ $item->prgStatus }}</span>
																	@endif
																@endif
															@endif
														</td>
														<td>
															@if(Auth::user()->hasPermission(25))
																@if($item->prgPaid)
																<a href="#" data-type="select" data-title="Cambiar Estado" data-pk="{{ $item->prgId }}" data-value="A" class="statusPaid">
																	<span class="badge badge-success" style="font-size: .7rem">SI</span>
																</a>
																@else
																<a href="#" data-type="select" data-title="Cambiar Estado" data-pk="{{ $item->prgId }}" data-value="B" class="statusPaid">
																	<span class="badge badge-warning" style="font-size: .7rem">NO</span>
																</a>
																@endif
															@else
																@if($item->prgPaid)
																<span class="badge badge-success" style="font-size: .7rem">SI</span>
																@else
																<span class="badge badge-warning" style="font-size: .7rem">NO</span>
																@endif
															@endif
														</td>
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
													<td colspan="8"></td>
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
<div class="modal fade" id="mdlAttachFile" tabindex="-1" role="dialog" aria-labelledby="attachModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				ADJUNTAR DOCUMENTO SUSTENTATORIO
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="frmAttachFile" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="hnatchAction" id="hatchAction">
					<div class="form-group">
						<label>Proyecto: </label>
						<textarea class="form-control-plaintext form-control-sm" id="atchPry" name="natchPry" readonly></textarea>
						<input type="hidden" id="hatchPry" name="hnatchPry">
					</div>
					<div class="form-group">
						<label>Periodo: </label>
						<input type="text" readonly class="form-control form-control-sm" id="atchPrg" name="natchPrg">
						<input type="hidden" id="hatchPrg" name="hnatchPrg">
					</div>
					<div class="form-group">
						<label>Seleccionar Archivo</label>
						<input type="file" class="form-control-file" id="atchFile" name="natchFile">
						<progress class="form-control" value="0"></progress>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="adjuntar_archivo_prg($('#frmAttachFile')[0])">Subir documento</button>
        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$('#mdlAttachFile').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		var action = button.data('action');
		var prId = button.closest('tr').attr('data-key');
		var prNro = button.closest('tr').attr('id');
		var dataSelect = $('#pyName').select2('data');
		var pryText = dataSelect[0].text;
		var pryId = dataSelect[0].id;
		var modal = $(this);

		modal.find('.modal-body #atchPry').val(pryText);
		modal.find('.modal-body #hatchPry').val(pryId);
		modal.find('.modal-body #atchPrg').val('Número - ' + prNro.split('-')[1]);
		modal.find('.modal-body #hatchPrg').val(prId);
	});

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

		if(val_mount == '' || val_mount == null || isNaN(val_mount)){
			val_mount = 0;
		}

		var pto_base = numeral($('#ptoResumenMonto').val()).value();
		var pto_total = numeral($('#valTotal').val()).value();
		var val_prcnt = val_mount / pto_base;
		var new_total = pto_total - val_prevmount + val_mount;

		//console.log('Pto_total: ' + pto_total + ' prevmount: ' + val_prevmount + ' mount:' + val_mount + ' new_Total:' + new_total);

		if(new_total > pto_base){
			alert('Se ha superado el monto total base, revise los montos ingresados para cada periodo');
			return;
		}
		$(row).find('.valPrcnt').val(numeral(val_prcnt).format('0.00%'));

		new_total = 0;
		$('input.valMount').each(function(index, el) {
			valor = ($(el).val()).replace(/[^\d\.]/g,'');
			console.log(valor);
			if(valor == '' || valor == null || isNaN(valor)){
				valor = 0;
			}

			new_total = new_total + parseFloat(valor);
		});

		console.log('TEST:' + new_total);

		$('#valTotal').val(numeral(new_total).format('0,0.00'));
		

		if(prevrow.length == 0){
			val_prevAggrt = 0;
		}
		else{
			val_prevAggrt = numeral(prevrow.find('input.valAggrt').val()).value();
		}
		//console.log('prevaggrt:' + val_prevAggrt + ' prcnt:' + val_prcnt);
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
		$.get('{{ url('monto/presupuesto') }}',{ ptoId: this.value }, function(data) {			
			$('#ptoResumenMonto').val(numeral(data).format('0,0.00'));
		});
	});

	$('.statusPaid').editable({
		url: '../edit/statuspaid',
		params: { _token: $('#frmUpdateSchedule').find("input[name='_token']").val() },
		source: [
              {value: 'A', text: 'SI'},
              {value: 'B', text: 'NO'}
           ],
        success: function(response, newValue){
            if(!response.success) alert("Error en el intento de cambiar el estado");
        }
	});

	$('.statusExec').editable({
		url: '../edit/statusexec',
		params: { _token: $('#frmUpdateSchedule').find("input[name='_token']").val() },
		source: [
			{value: '', text: 'No asignado'},
			{value: 'Normal', text: 'Normal'},
			{value: 'Suspendido', text: 'Suspendido'},
			{value: 'Adelantado', text: 'Adelantado'},
			{value: 'Atrazado', text: 'Atrazado'}
		],
	});

</script>