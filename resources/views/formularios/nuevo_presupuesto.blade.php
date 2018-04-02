<div class="col-md-10 pr-0">
	<div class="card">
		<div class="card-header py-1">
			<b> Presupuesto Resumen </b>
			<div class="float-right">
				<button type="button" class="btn btn-primary btn-sm" id="btnAddItemBudget" onclick="agregar_fila($('#tblSummaryBudget'))"><i class="fas fa-plus"></i> Añadir Item</button>
			</div>
		</div>
		<div class="card-body">
			<form id="frmRegisterBudget" action="{{ url('nuevo/presupuesto') }}">
				{{ csrf_field() }}
				<input type="hidden" name="hnpyId" value="{{ $pry->pryId }}">
				<table class="table table-sm" id="tblSummaryBudget">
					<thead class="thead-dark">
						<tr>
							<th>Descripción</th>
							<th>Proporción</th>
							<th>Presupuesto</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr class="tr_clone" style="display: none;">
							<td>
								<select class="form-control form-control-sm slcItemBudget" name="nptoItemGral[]">
									<option>-- Elegir --</option>
									@foreach($listPto as $item)
									<option data-code="{{ $item->lprCodeItem }}" value="{{ $item->lprId }}">{{ $item->lprDescriptionItem }}</option>
									@endforeach
								</select>
							</td>
							<td>
								<div class="input-group input-group-sm valGrpPrcnt" style="display: none;">
									<input type="text" class="form-control valPrcnt" name="nptoItemPercent[]">
									<div class="input-group-append">
										<span class="input-group-text">%</span>
									</div>
								</div>
							</td>
							<td class="colMounts">
								<div class="input-group input-group-sm valGrpMount" style="display: none;">
									<input type="text" class="form-control valMount" name="nptoItemMount[]">
									<div class="input-group-append">
										<span class="input-group-text">S/</span>
									</div>
								</div>
							</td>
							<td>
								<a href="javascript:void(0)" onclick="eliminar_fila(this)" class="text-danger">(-) Quitar</a>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>
</div>
<div class="col-md-2 pl-1">
	<div class="card">
		<div class="card-header py-1"><b>Operaciones</b></div>
		<div class="card-body px-2">
			@if(Auth::user()->hasPermission(6))
			<button type="button" class="btn btn-sm btn-success btn-block" onclick="registrar_presupuesto($('#frmRegisterBudget'))">
				<i class="fas fa-save mr-2"></i>Registrar
			</button>
			@endif
		</div>
	</div>
</div>

<script type="text/javascript">

	$('.slcItemBudget').change(function(evt) {
		evt.preventDefault();
		var item = $(this).find(':selected').data('code');
		var tr = $(this).closest('tr');

		tr.attr('id', item);

		if( item == 'CD' || item == 'ST' || item == 'PT'){
			tr.find('td div.valGrpPrcnt').hide();
			tr.find('td div.valGrpMount').show();
			var iTr = tr.index();

			if(item == 'ST'){
				var st = 0;
				var tdElements = $('#tblSummaryBudget tbody').find('tr td.colMounts:gt(0):lt(' + (iTr - 1) + ')');

				tdElements.each(function(index, el) {
					st = st + numeral($(el).find('input.valMount').val()).value();
				});

				tr.find('input.valMount').val(numeral(st).format('0,0.00'));
			}
			if(item == 'PT'){
				var pt = 0;
				var istartRow = $('tr#ST').index();

				var tdElements = $('#tblSummaryBudget tbody').find('tr td.colMounts:gt(' + (istartRow - 1) + '):lt(' + (iTr - istartRow) + ')');
				console.log(tdElements);
				tdElements.each(function(index, el) {
					pt = pt + numeral($(el).find('input.valMount').val()).value();
				});
				console.log(pt);
				tr.find('input.valMount').val(numeral(pt).format('0,0.00'));
			}
		}
		else{
			tr.find('td div.valGrpPrcnt').show();
			tr.find('td div.valGrpMount').show();

			if(item == 'IGV'){
				var mountSt = numeral($('tr#ST').find('input.valMount').val()).value();
				tr.find('input.valPrcnt').val(18);
				tr.find('input.valMount').val(numeral(mountSt * 0.18).format('0,0.00'));
			}
		}
	});

	$('.valMount').change(function(evt) {
		evt.preventDefault();
		var mount = numeral($.trim($(this).val())).value();
		var row = $(this).closest('tr');

		var cdInput = $('tr#CD').find('td input.valMount');
		var cdVal = numeral(cdInput.val()).value();

		if(cdVal == ''){
			alert('Primero debe establecer el monto del Costo Directo');
			return;
		}
		else{
			row.find('td div.valGrpPrcnt input.valPrcnt').val(numeral((mount / cdVal) * 100).format('0,0.00000'));
		}

	});
	/*
	$('.valPrcnt').change(function(evt) {
		evt.preventDefault();
		var prcnt = $.trim($(this).val());
		var row = $(this).closest('tr');

		var cdInput = $('tr#CD').find('td input.valMount');
		var cdVal = cdInput.val();

		if(cdVal == ''){
			alert('Primero debe establecer el monto del Costo Directo');
			return;
		}
		else{
			row.find('td div.valGrpMount input.valMount').val(numeral(cdVal * (prcnt/100)).format('0,0.00'));
		}

	});*/

</script>