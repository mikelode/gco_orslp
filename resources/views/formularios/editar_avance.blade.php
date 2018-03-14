<div class="col-md-12">
	<div class="row">
		<div class="col-md-10 pr-0">
			<div id="footBudgetGrid" style="height:220px; font-family: arial; font-size: 8pt; box-sizing: content-box;"></div>
		</div>
		<div class="col-md-2 pl-2">
			@if($valorizacion->prgClosed == false)
			<div class="card border-success">
				<div class="card-header py-1"><b>Operaciones</b></div>
				@if(Auth::user()->hasPermission(15))
				<div class="card-body px-2 py-1">		
					<button type="button" class="btn btn-sm btn-success btn-block" onclick="guardar_avance(grid, footGrid, $('#frmStoreProgress'), 0)">Guardar Avance</button>
					<button type="button" class="btn btn-sm btn-secondary btn-block" onclick="guardar_avance(grid, footGrid, $('#frmStoreProgress'), 1)">Finalizar Registro</button>
				</div>
				@endif
				<div class="card-footer">
					<div class="alert alert-warning mb-1 p-1">
						Valorización Nro: {{ $valorizacion->prgNumberVal }}
					</div>
					<div class="alert alert-info mb-1 p-1">
						Meta: {{ 'S/ ' . number_format($valorizacion->prgMount,2,'.',',') . ' - ' . $valorizacion->prgPercent * 100 . ' %' }}
					</div>
				</div>
			</div>
			@else
			<div class="card text-white bg-info">
				<div class="card-header py-1"><b>Operaciones</b></div>
				<div class="card-body px-2">		
					<h5 class="card-title">VALORIZACION COMPLETADA</h5>
					<p class="card-text">
						El registro del presente avance correspondiente al periodo seleccionado ha concluido.
					</p>
				</div>
			</div>
			@endif
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div id="myGrid" style="height:500px; font-family: arial; font-size: 8pt; box-sizing: content-box;"></div>
		</div>
	</div>
</div>

<script>

	var grid, footGrid;

	var columns = [
		//{id: "id", name: "Id", field: "parId", width: 30},
		{id: "item", name: "Item", field: "parItem", width: 70},
		{id: "descripcion", name: "Descripción", field: "parDescription", width: 400},
		{id: "metrado", name: "Metrado", field: "parMetered", width: 50, formatter: Slick.Formatters.Miles},
		{id: "unidad", name: "Und", field: "parUnit", width: 30},
		{id: "precio", name: "P.Unit.", field: "parPrice", width: 50, formatter: Slick.Formatters.Miles},
		{id: "parcial", name: "Presupuesto", field: "parPartial", width: 80, formatter: Slick.Formatters.Miles},
		{id: "metrado_ba", name: "METRADO", field: "avcMeteredBa", width: 50, columnGroup: "ACUMULADO ANTERIOR", formatter: Slick.Formatters.Miles},
		{id: "monto_ba", name: "MONTO", field: "avcMountBa", width: 80, columnGroup: "ACUMULADO ANTERIOR", formatter: Slick.Formatters.Miles},
		{id: "porcentaje_ba", name: "%", field: "avcPercentBa", width: 50, columnGroup: "ACUMULADO ANTERIOR"},
		{id: "metrado_cv", name: "METRADO", field: "avcMeteredCv", width: 50, editor: Slick.Editors.Text, columnGroup: "VALORIZACIÓN PRESENTE", formatter: Slick.Formatters.Miles, cssClass: 'basecolbudget'},
		{id: "monto_cv", name: "MONTO", field: "avcMountCv", width: 80, columnGroup: "VALORIZACIÓN PRESENTE", formatter: Slick.Formatters.Miles},
		{id: "porcentaje_cv", name: "%", field: "avcPercentCv", width: 50, columnGroup: "VALORIZACIÓN PRESENTE"},
		{id: "metrado_ca", name: "METRADO", field: "avcMeteredCa", width: 50, columnGroup: "ACUMULADO ACTUAL", formatter: Slick.Formatters.Miles},
		{id: "monto_ca", name: "MONTO", field: "avcMountCa", width: 80, columnGroup: "ACUMULADO ACTUAL", formatter: Slick.Formatters.Miles},
		{id: "porcentaje_ca", name: "%", field: "avcPercentCa", width: 50, columnGroup: "ACUMULADO ACTUAL"},
		{id: "metrado_bv", name: "METRADO", field: "avcMeteredBv", width: 50, columnGroup: "SALDO POR VALORIZAR", formatter: Slick.Formatters.Miles},
		{id: "monto_bv", name: "MONTO", field: "avcMountBv", width: 80, columnGroup: "SALDO POR VALORIZAR", formatter: Slick.Formatters.Miles},
		{id: "porcentaje_bv", name: "%", field: "avcPercentBv", width: 50, columnGroup: "SALDO POR VALORIZAR"}
	];

	var columnsFoot = [
		//{id: "id", name: "Id", field: "aprId", width: 30},
		{id: "descripcion", name: "Descripción", field: "iprItemGeneral", width: 150},
		{id: "proporcion", name: "Proporción %", field: "iprItemGeneralPrcnt", width: 100},
		{id: "monto", name: "Monto", field: "iprItemGeneralMount", width: 100, formatter: Slick.Formatters.Miles},
		{id: "vacio_ba", name: "METRADO", field: "avrMetradoBa", width: 50, columnGroup: "ACUMULADO ANTERIOR", formatter: Slick.Formatters.Miles},
		{id: "rmonto_ba", name: "MONTO", field: "avrMountBa", width: 80, columnGroup: "ACUMULADO ANTERIOR", formatter: Slick.Formatters.Miles},
		{id: "rporcentaje_ba", name: "%", field: "avrPercentBa", width: 80, columnGroup: "ACUMULADO ANTERIOR"},
		{id: "vacio_cv", name: "METRADO", field: "avrMetradoCv", width: 50, columnGroup: "VALORIZACIÓN PRESENTE", formatter: Slick.Formatters.Miles},
		{id: "rmonto_cv", name: "MONTO", field: "avrMountCv", width: 80, columnGroup: "VALORIZACIÓN PRESENTE", formatter: Slick.Formatters.Miles},
		{id: "rporcentaje_cv", name: "%", field: "avrPercentCv", width: 80, columnGroup: "VALORIZACIÓN PRESENTE"},
		{id: "vacio_ca", name: "METRADO", field: "avrMetradoCa", width: 50, columnGroup: "ACUMULADO ACTUAL", formatter: Slick.Formatters.Miles},
		{id: "rmonto_ca", name: "MONTO", field: "avrMountCa", width: 80, columnGroup: "ACUMULADO ACTUAL", formatter: Slick.Formatters.Miles},
		{id: "rporcentaje_ca", name: "%", field: "avrPercentCa", width: 80, columnGroup: "ACUMULADO ACTUAL"},
		{id: "vacio_bv", name: "METRADO", field: "avrMetradoBv", width: 50, columnGroup: "SALDO POR VALORIZAR", formatter: Slick.Formatters.Miles},
		{id: "rmonto_bv", name: "MONTO", field: "avrMountBv", width: 80, columnGroup: "SALDO POR VALORIZAR", formatter: Slick.Formatters.Miles},
		{id: "rporcentaje_bv", name: "%", field: "avrPercentBv", width: 80, columnGroup: "SALDO POR VALORIZAR"}
	];

	var options = {
		editable: {{ $valorizacion->prgClosed ? 'false' : 'true' }},
		asyncEditorLoading: false,
		autoEdit: false,
		enableCellNavigation: true,
	    enableColumnReorder: false,
	    createPreHeaderPanel: true,
	    showPreHeaderPanel: true,
	    preHeaderPanelHeight: 23,
	    explicitInitialization: true
	};

	var pluginOptions = {
	    //clipboardCommandHandler: function(editCommand){ undoRedoBuffer.queueAndExecuteCommand.call(undoRedoBuffer,editCommand); },
	    readOnlyMode : false,
	    includeHeaderWhenCopying : false,
	    newRowCreator: function(count) {
	      	for (var i = 0; i < count; i++) {
	       		var item = {
	       	  		id: "newRow_" + newRowIds++
	        	}
	        	grid.getData().addItem(item);
	      	}
	    }
	};

	data =  {!! $avd !!};

	data.getItemMetadata = function(row){
		if(data[row].parLevel == 1){
			return{
				cssClasses: 'gridRowLvlOne'
			}
			return null;
		}
	}

	grid = new Slick.Grid("#myGrid", data, columns, options);
	grid.setSelectionModel(new Slick.CellSelectionModel());
	grid.registerPlugin(new Slick.AutoTooltips());
	grid.getCanvasNode().focus();
	grid.registerPlugin(new Slick.CellExternalCopyManager(pluginOptions));

	footData = {!! $rsmn !!};
	
	footData.getItemMetadata = function(row){
		if(footData[row].iprId == '{{ $pry->pryBaseBudget }}'){
			return{
				cssClasses: 'baserowbudget'
			};
		}
		return null;
	}

	footGrid = new Slick.Grid('#footBudgetGrid', footData, columnsFoot, options);

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

		/*
			params1 => DC row
			params2 => column mount cv
			params3 => instance of grid with summary budget
			params4 => instance of grid with detail budget
			params5 => data of grid with detail budget
			params6 => data of grid with summary budget
		*/
		
		updateDirectCost(0, args.cell + 1, footGrid, grid, grid.getData(), footGrid.getData());
	});

	footGrid.onCellChange.subscribe(function(e, args){

		alert('cambiando');

	});

	//});

</script>