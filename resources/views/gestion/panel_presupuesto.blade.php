@extends('../app')

@section('main-content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					Proyecto:
					<select id="pyName" name="npyName">
						@foreach($pys as $py)
							<option value="{{ $py->pryId }}">{{ $py->pryDenomination }}</option>
						@endforeach
					</select>
					<button class="btn btn-outline-success btn-sm">Mostrar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-1 pr-0">
			<div class="card border-success">
				<div class="card-body px-2">
					<button type="button" class="btn btn-sm btn-success btn-block" data-toggle="modal" data-target="#mdlImportFile">Importar</button>
					<button type="button" class="btn btn-sm btn-info btn-block" onclick="habilitar_edicion($(this),grid)" value="disable">Editar</button>
					<button type="button" class="btn btn-sm btn-danger btn-block">Eliminar</button>
				</div>
			</div>
		</div>
		<div class="col-md-11 pl-1">
			<div class="card">
				<div class="card-body">
					<table class="table table-sm action-table">
						<thead class="thead-dark">
							<tr>
								<th>Descripción</th>
								<th>Proporción</th>
								<th>Prespuesto</th>
							</tr>
						</thead>
						<tbody>
							@foreach($pto as $item)
							<tr>
								<td class="py-0">{{ $item->preItemGeneral }}</td>
								<td class="py-0">{{ ($item->preItemGeneralPrcnt * 100) . ' %' }}</td>
								<td class="py-0">{{ $item->preItemGeneralMount }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div id="myGrid" style="height:500px; font-family: arial; font-size: 8pt; box-sizing: content-box;"></div>
			<!--<div id="myGrid"></div>-->
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

<script>

$(document).ready(function(){

	$('#mdlImportFile').on('show.bs.modal', function(event) {
		var dataSelect = $('#pyName').select2('data');
		var pryText = dataSelect[0].text;
		var pryId = dataSelect[0].id;
		var modal = $(this);

		modal.find('.modal-body #impPry').val(pryText);
		modal.find('.modal-body #himpPry').val(pryId);
	});

	$('#pyName').select2({
		width: '70%'
	});
});
</script>

@endsection

@section('custom-scripts')
<script>


	var grid;
	var columns = [
		{id: "item", name: "Item", field: "parItem"},
		{id: "descripcion", name: "Descripción", field: "parDescription", width: 500, editor: Slick.Editors.LongText},
		{id: "metrado", name: "Metrado", field: "parMetered", editor: Slick.Editors.Text},
		{id: "unidad", name: "Und", field: "parUnit", editor: Slick.Editors.Text},
		{id: "precio", name: "P.Unit.", field: "parPrice", editor: Slick.Editors.Text},
		{id: "parcial", name: "Presupuesto", field: "parPartial", editor: Slick.Editors.Text}
	];

	var options = {
		editable: false,
		enableAddRow: true,
		enableCellNavigation: true,
		asyncEditorLoading: false,
		autoEdit: true
	};

	@if(count($pto) > 0)

		$(function(){

			cargar_presupuesto({{ $pto[0]->preProject }}, function(data){
				console.log(data);
				grid = new Slick.Grid("#myGrid", data.ptd, columns, options);
			});

		});
	@endif

</script>
@endsection