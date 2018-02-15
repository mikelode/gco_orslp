@extends('../app')

@section('main-content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<form action="{{ url('detallado/avance') }}" id="frmDetailProgress">
						{{ csrf_field() }}
						<div class="form-group row mb-0">
							<label class="col-md-1">Proyecto: </label>
							<div class="col-md-7">
								<select id="pyName" name="npyName">
									<option value="NA">-- Seleccione un Proyecto --</option>
									@foreach($pys as $py)
										<option value="{{ $py->pryId }}">{{ $py->pryDenomination }}</option>
									@endforeach
								</select>
							</div>
							<label class="col-md-1">Avance: </label>
							<div class="col-md-2">
								<select id="avSelect" name="navSelect" class="form-control form-control-sm">
								</select>
							</div>
							<div class="col-md-1">
								<button type="button" class="btn btn-sm btn-outline-success" id="btnVerAvance">Ver Avance</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-1 pr-0">
			<div class="card border-success">
				<div class="card-body px-2">
					<button type="button" class="btn btn-sm btn-success btn-block">Guardar</button>
					<button type="button" class="btn btn-sm btn-secondary btn-block">Finalizar</button>
					<button type="button" class="btn btn-sm btn-info btn-block" onclick="habilitar_edicion($(this),grid)" value="disable">Editar</button>
					<button type="button" class="btn btn-sm btn-danger btn-block">Eliminar</button>
				</div>
			</div>
		</div>
		<div class="col-md-11 pl-1">
			<!--<div id="myGrid" style="height:500px; font-family: arial; font-size: 8pt; box-sizing: content-box;"></div>-->
			<div id="footBudgetGrid"></div><br>
			<div id="myGrid"></div>
		</div>
	</div>
</div>
<div class="modal fade" id="mdlFormProgress" tabindex="-1" role="dialog" aria-labelledby="importarModal" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				Registrar datos generales del avance
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="font-size: 10px">
				<div id="content-frm">
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="registrar_avance($('#frmCreateProgress'))">Crear Avance</button>
        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script>

$(document).ready(function(){

	$('#mdlFormProgress').on('show.bs.modal', function(event) {

		var py = $('#pyName').val();
		var modal = $(this);

		$.get('{{ url('avance/nuevo') }}',{pyId: py}, function(data) {
			
			modal.find('.modal-body #content-frm').html(data);

		});
	});

	$('#pyName').select2({
		width: '100%'
	});

	$('#avSelect').change(function(event) {

		if(this.value == 'CP'){

			if($('#pyName').val() == 'NA'){
				alert('Primero debe seleccionar el proyecto al cual se registrará su avance');
				this.value = 'NA';
				return;
			}

			$('#mdlFormProgress').modal('show');
		}

	});

	$('#pyName').change(function(ev) {

		if(this.value == 'NA'){
			$('#avSelect').html('');
			return;
		}


		$.get('{{ url('list/avance') }}',{pyId: this.value}, function(data) {
			
			$('#avSelect').html(data.optionHtml);

		});

	});

	$('#btnVerAvance').click(function(ev) {
		ev.preventDefault();

		//armar_cabecera($('#footBudgetGrid'));

		avance_partidas($('#pyName'),$('#avSelect'),$('#frmDetailProgress'), function(data){

			contentFooter = new Array();
			content = new Array();

			$.each(data.avd, function(i, part) {

				avcMeteredCa = '=(H' + (i+1) + '+' + 'K' + (i+1) + ')';
				avcMeteredBv = '=(D' + (i+1) + '-' + 'N' + (i+1) + ')';
				avcMountCv = '=ROUND((F' + (i+1) + '*' + 'K' + (i+1) + ')*100)/100';
				avcMountCa = '=(I' + (i+1) + '+' + 'L' + (i+1) + ')';
				avcMountBv = '=(G' + (i+1) + '-' + 'O' + (i+1) + ')';
				avcPercentCv = '=ROUND((L' + (i+1) + '/' + 'G' + (i+1) + ')*10000)/100';
				avcPercentCa = '=ROUND((O' + (i+1) + '/' + 'G' + (i+1) + ')*10000)/100';
				avcPercentBv = '=100 - P' + (i+1);

				 content.push([part.avcId+'-'+part.avcPartidaId,part.parItem,part.parDescription,part.parMetered,part.parUnit,part.parPrice,part.parPartial,part.avcMeteredBa,part.avcMountBa,part.avcPercentBa,part.avcMeteredCv,avcMountCv,avcPercentCv,avcMeteredCa,avcMountCa,avcPercentCa,avcMeteredBv,avcMountBv,avcPercentBv]);

				 
			});

			$.each(data.pto, function(i, val) {
				 contentFooter.push(['','',val.preItemGeneral,'',val.preItemGeneralPrcnt,'',val.preItemGeneralMount,'']);
			});

			colTitulo = ['id','Item','Descripción','Metrado','Und','P.Unit.','Presupuesto','METRADO','MONTO','%','METRADO','MONTO','%','METRADO','MONTO','%','METRADO','MONTO','%'];
			colAncho = [1,70,200,50,50,50,70,60,50,50];
			colConfig = [
				{type: 'text', readOnly: true},
				{type: 'text', readOnly: true},
				{type: 'text', readOnly: true},
				{type: 'numeric', readOnly: true},
				{type: 'text', readOnly: true},
				{type: 'numeric', readOnly: true},
				{type: 'numeric', readOnly: true },
				{type: 'numeric', readOnly: true},
				{type: 'numeric', readOnly: true},
				{type: 'numeric', readOnly: true},
				{type: 'numeric'},
				{type: 'numeric'},
				{type: 'numeric'},
				{type: 'numeric', readOnly: true},
				{type: 'numeric', readOnly: true},
				{type: 'numeric', readOnly: true},
				{type: 'numeric', readOnly: true},
				{type: 'numeric', readOnly: true},
				{type: 'numeric', readOnly: true}
			];
			colTextPosition = ['','left','left','','','right','right'];

			var update = function(obj, cell, val){
				console.log(obj);
				console.log(cell);
				console.log(val);
				/*var cellname = $(obj).jexcel('getColumnNameFromId',$(cell).prop('id'));
				var cellval = $(obj).jexcel('getValue',cell);
				var currentCell = $(cell).prop('id');
				console.log(cell + ' - ' + currentCell);
				var rowNumber = parseInt((currentCell.split('-'))[1]) + 1;*/

				
				var cellIdValue = $(obj).jexcel('getIdFromColumnName','L4');
				console.log(cellIdValue);
				var cellMountValue = $(obj).find('td#' + cellIdValue).text();
				console.log(cellMountValue);
				
				//var colName = $(obj).jexcel('getColumnNameFromTitleHeader','Metrado');

				//var cellMetrado = $(obj).jexcel('getValue',colName + rowNumber);
			}
			

			$('#footBudgetGrid').jexcel({ 
				data: contentFooter,
				colHeaders: colTitulo,
				colWidths: colAncho,
				columns: colConfig,
				colAlignments: colTextPosition,
			});


			$('#myGrid').jexcel({ 
				data: content,
				colHeaders: colTitulo,
				colWidths: colAncho,
				columns: colConfig,
				colAlignments: colTextPosition,
				onafterchange: update
			});

			$('#myGrid').find('thead').before('<thead class="jexcel_label"><tr><td class="jexcel_label" width="30"></td><td></td><td width="70"></td><td width="200"></td><td width="50"></td><td width="50"></td><td width="50"></td><td width="60"></td><td colspan="3" align="center" width="160">ACUMULADO ANTERIOR</td><td colspan="3" align="center" width="160">VALORIZACIÓN PRESENTE</td><td colspan="3" align="center" width="160">ACUMULADO ACTUAL</td><td colspan="3" align="center" width="160">SALDO POR VALORIZAR</td></tr></thead>');

			$('#footBudgetGrid').find('thead').before('<thead class="jexcel_label"><tr><td class="jexcel_label" width="30"></td><td></td><td width="70"></td><td width="200"></td><td width="50"></td><td width="50"></td><td width="50"></td><td width="60"></td><td colspan="3" align="center" width="160">ACUMULADO ANTERIOR</td><td colspan="3" align="center" width="160">VALORIZACIÓN PRESENTE</td><td colspan="3" align="center" width="160">ACUMULADO ACTUAL</td><td colspan="3" align="center" width="160">SALDO POR VALORIZAR</td></tr></thead>');

			/*$('#myGrid').jexcel('updateSettings', {
			    cells: function (cell, col, row) {
			        if (col > 4) {
			            value = $('#myGrid').jexcel('getValue', $(cell));
			            val = numeral($(cell).text()).format('0,0.00');
			            $(cell).html('' + val);
			        }
			    }
			});*/

		});

	});

});
</script>

@endsection

@section('custom-scripts')
<script>


</script>
@endsection