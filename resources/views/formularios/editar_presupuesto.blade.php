<div class="col-md-10 pr-0">
	<div class="card">
		<div class="card-header py-1"><b> Presupuesto Resumen </b></div>
		<div class="card-body">
			<form id="frmUpdateBudget" action="{{ url('actualizar/presupuesto') }}">
				{{ csrf_field() }}
				<input type="hidden" name="hnpyId" value="{{ $pry->pryId }}">
				<table class="table table-sm">
					<thead class="thead-dark">
						<tr>
							<th>Descripción</th>
							<th>Proporción</th>
							<th>Presupuesto</th>
						</tr>
					</thead>
					<tbody>
						@foreach($pto as $item)
						<tr>
							<td>
								<input type="hidden" name="nptoId[]" value="{{ $item->preId }}">
								<input type="text" name="nptoItemGral[]" class="form-control-plaintext" readonly value="{{ $item->preItemGeneral }}" readonly>
								<input type="hidden" name="nptoCodeItem[]" value="{{ $item->preCodeItem }}">
								<input type="hidden" name="nptoOrder[]" value="{{ $item->preOrder }}">
							</td>
							@if($item->preCodeItem == 'CD' || $item->preCodeItem == 'ST' || $item->preCodeItem == 'PT')
							<td>
								<input type="hidden" name="nptoItemPercent[]">
							</td>
							@else
							<td>
								<div class="input-group input-group-sm">
									<input type="text" class="form-control percentage preEdit" name="nptoItemPercent[]" value="{{ $item->preItemGeneralPrcnt }}" readonly>
									<div class="input-group-append">
										<span class="input-group-text">%</span>
									</div>
								</div>
							</td>
							@endif
							<td>
								<div class="input-group input-group-sm">
									<input type="text" class="form-control amount preEdit" name="nptoItemMount[]" value="{{ number_format($item->preItemGeneralMount,2,'.',',') }}" readonly>
									<div class="input-group-append">
										<span class="input-group-text">S/</span>
									</div>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@if(Auth::user()->hasPermission(7))
				<button type="button" class="btn btn-sm btn-success float-right" style="display: none;" id="btnUpdateBudget" onclick="actualizar_presupuesto($('#frmUpdateBudget'))">Guardar Cambios</button>
				@endif
			</form>
		</div>
		<div class="card-header">
			<b>Partidas Presupuestarias</b>
			@if(Auth::user()->hasPermission(7))
				@if($ptd->isEmpty())
				<div class="float-right">
					<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-action="new" data-target="#mdlImportFile">Importar</button>
				</div>
				@else
				<div class="float-right">
					<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-action="clear" data-target="#mdlImportFile">Limpiar e Importar</button>
				</div>
				@endif
			@endif
		</div>
		<div class="card-body">
			<div id="myGrid" style="height:500px; font-family: arial; font-size: 8pt; box-sizing: content-box;"></div>
		</div>
	</div>
	
</div>
<div class="col-md-2 pl-1">
	<div class="card">
		<div class="card-header py-1"><b>Operaciones</b></div>
		<div class="card-body px-2">
			@if(Auth::user()->hasPermission(7))
			<button type="button" class="btn btn-sm btn-primary btn-block" onclick="editar_presupuesto($(this),$('#frmUpdateBudget'))" value="editar">Editar Presupuesto</button>
			<button type="button" class="btn btn-sm btn-info btn-block" onclick="habilitar_edicion($(this),grid)" value="disable">Editar Partidas</button>
			@endif
			@if(Auth::user()->hasPermission(8))
			<button type="button" class="btn btn-sm btn-danger btn-block">Eliminar</button>
			@endif
		</div>
	</div>
</div>

<div class="modal fade" id="mdlImportFile" tabindex="-1" role="dialog" aria-labelledby="importarModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				Importar Excel del Presupuesto
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="frmImportBudget" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="hidden" name="hnimpAction" id="himpAction">
					<div class="form-group">
						<label>Proyecto: </label>
						<textarea class="form-control-plaintext input-sm" id="impPry" name="nimpPry" readonly></textarea>
						<input type="hidden" id="himpPry" name="hnimpPry">
					</div>
					<div class="form-group">
						<label>Seleccionar Archivo Excel del Presupuesto</label>
						<input type="file" class="form-control-file" id="impFile" name="nimpFile">
						<progress class="form-control" value="0"></progress>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="importar_partidas($('#frmImportBudget')[0])">Cargar archivo</button>
        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#mdlImportFile').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		var dataSelect = $('#pyName').select2('data');
		var pryText = dataSelect[0].text;
		var pryId = dataSelect[0].id;
		var action = button.data('action');
		var modal = $(this);

		modal.find('.modal-body #impPry').val(pryText);
		modal.find('.modal-body #himpPry').val(pryId);
		modal.find('.modal-body #himpAction').val(action);
	});

	var grid;
	var columns = [
		{id: "item", name: "Item", field: "parItem"},
		{id: "descripcion", name: "Descripción", field: "parDescription", width: 500, editor: Slick.Editors.LongText},
		{id: "metrado", name: "Metrado", field: "parMetered", editor: Slick.Editors.Text, formatter: Slick.Formatters.Miles},
		{id: "unidad", name: "Und", field: "parUnit", editor: Slick.Editors.Text},
		{id: "precio", name: "P.Unit.", field: "parPrice", editor: Slick.Editors.Text, formatter: Slick.Formatters.Miles},
		{id: "parcial", name: "Presupuesto", field: "parPartial", editor: Slick.Editors.Text, formatter: Slick.Formatters.Miles}
	];

	var options = {
		editable: false,
		enableAddRow: true,
		enableCellNavigation: true,
		asyncEditorLoading: false,
		autoEdit: true
	};

	@if(!$ptd->isEmpty())

		$(function(){

			cargar_presupuesto({{ $pto[0]->preProject }}, function(data){
				grid = new Slick.Grid("#myGrid", data.ptd, columns, options);

				grid.onCellChange.subscribe(function(e,args){
					console.log(e);
					console.log(args);
									
					$.get('actualizar/partida', args.item, function(response) {
						if(response.msgId == '500'){
							alert(response.msg);
						}
					});

					grid.invalidateRow(args.row);
					grid.render();

				});
			});
		});
	@endif

</script>

@section('custom-scripts')
<script>

</script>
@endsection