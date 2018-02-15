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
					<button type="button" class="btn btn-sm btn-success btn-block" onclick="guardar_avance(grid, footGrid, $('#frmStoreProgress'))">Guardar</button>
					<button type="button" class="btn btn-sm btn-secondary btn-block">Finalizar</button>
					<button type="button" class="btn btn-sm btn-info btn-block" onclick="habilitar_edicion($(this),grid)" value="disable">Editar</button>
					<button type="button" class="btn btn-sm btn-danger btn-block">Eliminar</button>
				</div>
			</div>
		</div>
		<div class="col-md-11 pl-1">
			<div id="footBudgetGrid" style="height:220px; font-family: arial; font-size: 8pt; box-sizing: content-box;"></div><br>
			<div id="myGrid" style="height:500px; font-family: arial; font-size: 8pt; box-sizing: content-box;"></div>
			<!--<div id="myGrid"></div>-->
		</div>
	</div>
	<form action="{{ url('almacenar/avance') }}" id="frmStoreProgress">
		{{ csrf_field() }}
		<input type="hidden" name="dataGridDetail" value="">
		<input type="hidden" name="dataGridResume" value="">
		<input type="hidden" id="dataProject" name="npyId" value="">
		<input type="hidden" id="dataProgress" name="nbpId" value="">
	</form>
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
		else{
			$('#dataProgress').val(this.value);
		}

	});

	$('#pyName').change(function(ev) {

		if(this.value == 'NA'){
			$('#avSelect').html('');
			return;
		}

		$('#dataProject').val(this.value);

		$.get('{{ url('list/avance') }}',{pyId: this.value}, function(data) {
			
			$('#avSelect').html(data.optionHtml);

		});

	});

});
</script>

@endsection

@section('custom-scripts')
<script>

	var grid, footGrid;

	$('#btnVerAvance').click(function(ev) {
		ev.preventDefault();

		avance_partidas($('#pyName'),$('#avSelect'),$('#frmDetailProgress'), function(data){

			var columns = [
				{id: "id", name: "Id", field: "parId", width: 30},
				{id: "item", name: "Item", field: "parItem", width: 70},
				{id: "descripcion", name: "Descripción", field: "parDescription", width: 400},
				{id: "metrado", name: "Metrado", field: "parMetered", width: 50},
				{id: "unidad", name: "Und", field: "parUnit", width: 30},
				{id: "precio", name: "P.Unit.", field: "parPrice", width: 50},
				{id: "parcial", name: "Presupuesto", field: "parPartial", width: 80},
				{id: "metrado_ba", name: "METRADO", field: "avcMeteredBa", width: 50, columnGroup: "ACUMULADO ANTERIOR"},
				{id: "monto_ba", name: "MONTO", field: "avcMountBa", width: 50, columnGroup: "ACUMULADO ANTERIOR"},
				{id: "porcentaje_ba", name: "%", field: "avcPercentBa", width: 50, columnGroup: "ACUMULADO ANTERIOR"},
				{id: "metrado_cv", name: "METRADO", field: "avcMeteredCv", width: 50, editor: Slick.Editors.Text, columnGroup: "VALORIZACIÓN PRESENTE"},
				{id: "monto_cv", name: "MONTO", field: "avcMountCv", width: 50, columnGroup: "VALORIZACIÓN PRESENTE"},
				{id: "porcentaje_cv", name: "%", field: "avcPercentCv", width: 50, columnGroup: "VALORIZACIÓN PRESENTE"},
				{id: "metrado_ca", name: "METRADO", field: "avcMeteredCa", width: 50, columnGroup: "ACUMULADO ACTUAL"},
				{id: "monto_ca", name: "MONTO", field: "avcMountCa", width: 50, columnGroup: "ACUMULADO ACTUAL"},
				{id: "porcentaje_ca", name: "%", field: "avcPercentCa", width: 50, columnGroup: "ACUMULADO ACTUAL"},
				{id: "metrado_bv", name: "METRADO", field: "avcMeteredBv", width: 50, columnGroup: "SALDO POR VALORIZAR"},
				{id: "monto_bv", name: "MONTO", field: "avcMountBv", width: 50, columnGroup: "SALDO POR VALORIZAR"},
				{id: "porcentaje_bv", name: "%", field: "avcPercentBv", width: 50, columnGroup: "SALDO POR VALORIZAR"}
			];

			var columnsFoot = [
				{id: "id", name: "Id", field: "aprId", width: 30},
				{id: "descripcion", name: "Descripción", field: "preItemGeneral", width: 150},
				{id: "proporcion", name: "Proporción %", field: "preItemGeneralPrcnt", width: 100},
				{id: "monto", name: "Monto", field: "preItemGeneralMount", width: 100},
				{id: "vacio_ba", name: "METRADO", field: "avrMetradoBa", width: 80, columnGroup: "ACUMULADO ANTERIOR"},
				{id: "rmonto_ba", name: "MONTO", field: "avrMountBa", width: 80, columnGroup: "ACUMULADO ANTERIOR"},
				{id: "rporcentaje_ba", name: "%", field: "avrPercentBa", width: 80. , columnGroup: "ACUMULADO ANTERIOR"},
				{id: "vacio_cv", name: "METRADO", field: "avrMetradoCv", width: 80. , columnGroup: "VALORIZACIÓN PRESENTE"},
				{id: "rmonto_cv", name: "MONTO", field: "avrMountCv", width: 80. , columnGroup: "VALORIZACIÓN PRESENTE"},
				{id: "rporcentaje_cv", name: "%", field: "avrPercentCv", width: 80. , columnGroup: "VALORIZACIÓN PRESENTE"},
				{id: "vacio_ca", name: "METRADO", field: "avrMetradoCa", width: 80. , columnGroup: "ACUMULADO ACTUAL"},
				{id: "rmonto_ca", name: "MONTO", field: "avrMountCa", width: 80. , columnGroup: "ACUMULADO ACTUAL"},
				{id: "rporcentaje_ca", name: "%", field: "avrPercentCa", width: 80. , columnGroup: "ACUMULADO ACTUAL"},
				{id: "vacio_bv", name: "METRADO", field: "avrMetradoBv", width: 80. , columnGroup: "SALDO POR VALORIZAR"},
				{id: "rmonto_bv", name: "MONTO", field: "avrMountBv", width: 80. , columnGroup: "SALDO POR VALORIZAR"},
				{id: "rporcentaje_bv", name: "%", field: "avrPercentBv", width: 80. , columnGroup: "SALDO POR VALORIZAR"}
			];

			var options = {
				editable: true,
				asyncEditorLoading: false,
				autoEdit: true,
				enableCellNavigation: true,
			    enableColumnReorder: false,
			    createPreHeaderPanel: true,
			    showPreHeaderPanel: true,
			    preHeaderPanelHeight: 23,
			    explicitInitialization: true
			};

			grid = new Slick.Grid("#myGrid", data.avd, columns, options);
			footGrid = new Slick.Grid('#footBudgetGrid', data.rsmn, columnsFoot, options);

			grid.init();
		    grid.onColumnsResized.subscribe(function (e, args) {
		     	CreateAddlHeaderRow(grid, columns);
		    });
		    CreateAddlHeaderRow(grid,columns);

		    footGrid.init();
		    footGrid.onColumnsResized.subscribe(function (e, args) {
		     	CreateAddlHeaderRow(footGrid, columnsFoot);
		    });
			CreateAddlHeaderRow(footGrid,columnsFoot);

			grid.onCellChange.subscribe(function(e, args){

				grid.invalidateRow(args.row);

				args.item.avcMountCv = Math.round(parseFloat(args.item.avcMeteredCv) * parseFloat(args.item.parPrice) * 100 ) / 100;
				args.item.avcPercentCv = Math.round((parseFloat(args.item.avcMountCv) / parseFloat(args.item.parPartial)) * 10000) / 100;
				args.item.avcMeteredCa = Math.round((parseFloat(args.item.avcMeteredBa) + parseFloat(args.item.avcMeteredCv)) * 100 ) / 100;
				args.item.avcMountCa = Math.round((parseFloat(args.item.avcMountBa) + parseFloat(args.item.avcMountCv)) * 100 ) / 100;
				args.item.avcPercentCa = Math.round((parseFloat(args.item.avcMountCa) / parseFloat(args.item.parPartial)) * 10000) / 100;
				args.item.avcMeteredBv = Math.round((parseFloat(args.item.parMetered) - parseFloat(args.item.avcMeteredCa)) * 100 ) / 100;
				args.item.avcMountBv = Math.round((parseFloat(args.item.parPartial) - parseFloat(args.item.avcMountCa)) * 100 ) / 100;
				args.item.avcPercentBv = 100 - parseFloat(args.item.avcPercentCa);

				grid.render();

				updateDirectCost(0, args.cell + 1, footGrid, grid, data.avd, data.rsmn);
			});

			footGrid.onCellChange.subscribe(function(e, args){

				alert('cambiando');

			});

		});

	});

</script>
@endsection