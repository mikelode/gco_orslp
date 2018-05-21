<div class="col-md-10 pr-0">
	<div class="card">
		<div class="card-header py-1">
			<b> Presupuesto Resumen </b>
		</div>
		<div class="card-body">
			<form id="frmUpdateBudget" action="{{ url('actualizar/presupuesto') }}">
				{{ csrf_field() }}
				<input type="hidden" id="pyId" name="hnpyId" value="{{ $pry->pryId }}">
				<div class="table-responsive">
					<table class="table table-sm" id="tblSummaryBudget">
						<thead class="thead-dark">
							<tr>
								<th></th>
								<th>Presupuesto</th>
								@foreach($pto[0]->items as $item)
								<th>{{ $item->iprItemGeneral }}</th>
								@endforeach
								<th>Doc. Adj.</th>
							</tr>
							<tr>
								<th></th>
								<th>%</th>
								@foreach($pto[0]->items as $item)
									@if($item->iprCodeItem == 'CD' || $item->iprCodeItem == 'ST' || $item->iprCodeItem == 'PT')
										<th>
											<input type="hidden" name="nptoItemPercent[]">
										</th>
									@else
										<th>
											<div class="input-group input-group-sm">
												<input type="text" class="form-control percentage preEdit" name="nptoItemPercent[]" value="{{ $item->iprItemGeneralPrcnt }}" readonly>
												<div class="input-group-append">
													<span class="input-group-text">%</span>
												</div>
											</div>
										</th>
									@endif
								@endforeach
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($pto as $p)
							<tr id="{{ $p->preId }}">
								<td class="tdEdit">
									<a href="javascript:" class="btnUpdateBudget" onclick="actualizar_presupuesto(this)" style="display: none;">
										<img src="{{ asset('/img/guardar32.png') }}">
									</a>
								</td>
								<td>
									<input type="text" name="nptoItemGral[]" class="form-control-plaintext preEdit" readonly value="{{ $p->preName }}" readonly>
									<input type="hidden" id="ptoId" value="{{ $p->preId }}" name="hnptoId[]">
								</td>
								@foreach($p->items as $item)
									<td>
										<input type="text" class="form-control form-control-sm amount preEdit" name="nptoItemMount[]" value="{{ number_format($item->iprItemGeneralMount,2,'.',',') }}" readonly>
										<input type="hidden" name="nptoItemId[]" value="{{ $item->iprId }}">
										<input type="hidden" name="nptoItemCode[]" value="{{ $item->iprCodeItem }}">
										<input type="hidden" name="nptoItemOrder[]" value="{{ $item->iprOrder }}">
									</td>
								@endforeach
								<td>
									<!--<textarea class="form-control form-control-sm preEdit" name="nptoNote" readonly>{ $p->preNote }}</textarea>-->
									@if(\Storage::disk('public')->exists($p->prePathFile))
									<a href="{{ url('/storage/' . $p->prePathFile) }}" target="_blank" title="Ver archivo">
										<img src="{{ asset('/img/pdf-file_16.png') }}">
									</a>
									<a href="#" data-toggle="modal" data-target="#mdlAttachFile" class="btnAttachFile" title="Cambiar archivo">
										<img src="{{ asset('/img/refresh_16.png') }}">
									</a>
									@else
									<a href="#" data-toggle="modal" data-target="#mdlAttachFile" class="btnAttachFile" title="Adjuntar archivo">
										<img src="{{ asset('/img/upload_file_20.png') }}">
									</a>
									@endif
								</td>
							</tr>
							@endforeach
						</tbody>
						<tfoot>
							<tr>
								<th></th>
								<th>Total</th>
								@foreach($ptoFinal as $final)
									<th class="amount">{{ number_format($final,2,'.',',') }}</th>
								@endforeach
								<th></th>
							</tr>
						</tfoot>
					</table>
				</div>
				
				@if(Auth::user()->hasPermission(7))
				<div class="btn-group" role="group" style="display: none;" id="btnAddPrestBudget">
					<button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#mdlAddPrestacion">
						<i class="fas fa-plus"></i> Añadir Prestación
					</button>
				</div>
				@endif
			</form>
		</div>
		<div class="card-header">
			<div class="row">
				<div class="col-md-4">
					<b>Partidas Presupuestarias</b>
				</div>
				<div class="col-md-4">
					<div class="form-group row mb-0">
						<label class="col-form-label col-md-4">Presupuesto:</label>
						<div class="col-md-6">
							<select class="form-control form-control-sm" id="slcPartidasPto">
								@foreach($pto as $p)
								<option value="{{ $p->preId }}">{{ $p->itemDsc . ' - ' . $p->preName }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-2">
							<a id="btnExportPpto" data-base="{{ url('export/presupuesto'). '?pry=' . $pry->pryId }}" href="{{ url('export/presupuesto') . '?pry=' . $pry->pryId . '&pto=' . $pto[0]->preId }}">
								<img src="{{ asset('/img/xls_32.png') }}">
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					@if(Auth::user()->hasPermission(7))
						@if($ptd->isEmpty())
						<div class="float-right">
							<button type="button" class="btn btn-sm btn-primary" id="btnImportPart" data-toggle="modal" data-action="new" data-target="#mdlImportFile">Importar</button>
						</div>
						@else
						<div class="float-right">
							<button type="button" class="btn btn-sm btn-info" id="btnImportPart" data-toggle="modal" data-action="clear" data-target="#mdlImportFile">Limpiar e Importar</button>
						</div>
						@endif
					@endif
				</div>
			</div>
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
						<textarea class="form-control-plaintext form-control-sm" id="impPry" name="nimpPry" readonly></textarea>
						<input type="hidden" id="himpPry" name="hnimpPry">
					</div>
					<div class="form-group">
						<label>Presupuesto: </label>
						<select class="form-control form-control-sm" id="impPto" name="nimpPto">
							@foreach($pto as $p)
							<option value="{{ $p->preId }}">{{ $p->itemDsc . ' - ' . $p->preName }}</option>
							@endforeach
						</select>
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

<div class="modal fade" id="mdlAddPrestacion" tabindex="-1" role="dialog" aria-labelledy="prestacionModal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				Agregar Prestación al Presupuesto del Proyecto
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="content-frm">
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="registrar_prestacion($('#frmCreatePrestacion'))">Registrar</button>
        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
						<label>Presupuesto: </label>
						<select class="form-control form-control-sm" id="atchPto" name="natchPto">
							@foreach($pto as $p)
							<option value="{{ $p->preId }}">{{ $p->itemDsc . ' - ' . $p->preName }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Seleccionar Archivo</label>
						<input type="file" class="form-control-file" id="atchFile" name="natchFile">
						<progress class="form-control" value="0"></progress>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="adjuntar_archivo($('#frmAttachFile')[0])">Subir documento</button>
        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$('#mdlAddPrestacion').on('show.bs.modal', function(event){

		var ptoInit = $('#ptoId').val();
		var modal = $(this);

		$.get('{{ url('create/prestacion') }}', {ipto: ptoInit}, function(data){
			modal.find('.modal-body #content-frm').html(data);
		});

	});

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

	$('#mdlAttachFile').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget);
		var action = button.data('action');
		var ptId = button.closest('tr').attr('id');
		var dataSelect = $('#pyName').select2('data');
		var pryText = dataSelect[0].text;
		var pryId = dataSelect[0].id;
		var modal = $(this);

		modal.find('.modal-body #atchPry').val(pryText);
		modal.find('.modal-body #hatchPry').val(pryId);
		modal.find('.modal-body #atchPto').val(ptId);
	});

	$('#slcPartidasPto').change(function(event) {

		var base = $('#btnExportPpto').data('base');
		$('#btnExportPpto').attr('href',base + '&pto=' + this.value);
		
		cargar_presupuesto({{ $pto[0]->preProject }}, this.value, function(data){

			$('#myGrid').empty();
			
			if(data.ptd.length == 0){
				$('#btnImportPart').attr('data-action', 'new');
			}
			else{
				$('#btnImportPart').attr('data-action','clear');
			}

			var ptdData = data.ptd;

			if(ptdData.length == 0)
				return;

			ptdData.getItemMetadata = function(row){

				var lvl = ptdData[row].parLevel;
				var style = 'gridRowLvl-' + lvl;

				if(ptdData[row].parUnit == ''){
					return{
						cssClasses: style
					}
					return null;
				}
			}

			grid = new Slick.Grid("#myGrid", ptdData, columns, options);

			grid.onCellChange.subscribe(function(e,args){
								
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

			cargar_presupuesto({{ $pto[0]->preProject }}, {{ $pto[0]->preId }}, function(data){

				var ptdData = data.ptd;
				
				ptdData.getItemMetadata = function(row){
					
					var lvl = ptdData[row].parLevel;
					var style = 'gridRowLvl-' + lvl;

					if(ptdData[row].parUnit == ''){
						return{
							cssClasses: style
						}
						return null;
					}
				}

				grid = new Slick.Grid("#myGrid", ptdData, columns, options);

				grid.onCellChange.subscribe(function(e,args){
									
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