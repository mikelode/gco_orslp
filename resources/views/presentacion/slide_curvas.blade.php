<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<a href="{{ url('export/sheet') . '?pyId=' . $cronograma[0]->prgProject }}" target="_blank" class="btn btn-success" id="btnMakeTemplate">Exportar Resultado a Excel</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<!--<div id="curve-s" style="position: relative; height: 400px;"></div>-->
						<canvas id="curve-s" width="400" height="200"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<!--<table id="dataCronograma" class="table table-bordered table-sm action-table">-->
				<table id="dataCronograma" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th rowspan="2">N° Valorización</th>
							<th rowspan="2">Periodo</th>
							<th colspan="3">Programado</th>
							<th colspan="3">Ejecutado</th>
						</tr>
						<tr>
							<th>Monto S/</th>
							<th>% Avance</th>
							<th>% Acumulado</th>
							<th>Monto S/</th>
							<th>% Avance</th>
							<th>% Acumulado</th>
						</tr>
					</thead>
					<tbody>
						@foreach($cronograma as $crono)
						<tr>
							<td>{{ $crono->prgNumberVal }}</td>
							<td>{{ $crono->prgPeriodo }}</td>
							<td class="amount">{{ number_format($crono->prgMount,2,'.',',') }}</td>
							<td class="amount">{{ number_format($crono->prgPercent * 100,2,'.',',') }}</td>
							<td class="amount">{{ number_format($crono->prgAggregate * 100,2,'.',',') }}</td>
							<td class="amount">{{ number_format($crono->prgMountExec,2,'.',',') }}</td>
							<td class="amount">{{ number_format($crono->prgPercentExec * 100,2,'.',',') }}</td>
							<td class="amount">{{ number_format($crono->prgAggregateExec * 100,2,'.',',') }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$('#dataCronograma').DataTable({
		'paging': false,
		'ordering': false,
		'info': false,
		'searching': false,
		dom: 'Bfrtip',
        buttons: [
            {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o"></i> Copiar',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o"></i> Excel',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o"></i> Csv',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i> Pdf',
                titleAttr: 'PDF'
            },{
            	extend:    'print',
            	text:      '<i class="fa fa-print"></i> Imprimir',
                titleAttr: 'Print'
            }
        ]
	});

	var ctx = $('#curve-s');
	var myChart = new Chart(ctx, {
	    type: 'line',
	    data: {!! $chartData !!},
	    options: {
	    	responsive: true,
	    	title: {
	            display: true,
	            text: "AVANCE PORCENTUAL ACUMULADO PROGRAMADO VS EJECUTADO"
	        },
	        tooltips:{
	        	mode: 'index',
	        	intersect: false,
	        },
	        hover:{
	        	mode: 'nearest',
	        	intersect: true,
	        },
	        scales: {
	        	xAxes: [{
	        		display: true,
	        		scaleLabel: {
	        			display: true,
	        			labelString: 'Periodo',
	        		}
	        	}],
	            yAxes: [{
	            	display: true,
	            	scaleLabel: {
	            		display: true,
	            		labelString: 'Porcentaje de Ejecución',
	            	}
	            }]
	        },
	        legend: {
	            display: true,
	            labels: {
	                fontColor: 'rgb(255, 99, 132)'
	            }
	        }
	    }
	});

	Chart.defaults.line.spanGaps = true;
	/*var line_chart = Morris.Line({
		element: 'curve-s',
		data: [<php echo $data ?>],
		xkey: 'periodo',
		xLabelAngle: 45,
		ykeys: ['programado','ejecutado'],
		postUnits: '%',
		labels: ['Cantidad Programada','Cantidad Ejecutada'],
		lineColors: ['#36A2EB','#FF6384'],
		lineWidth: [1.5,1.5],
		fillOpacity: 0.5,
		hideHover: 'auto'
	});*/

	$('#btnMake').click(function(evt) {
		evt.preventDefault();

		$.get('{{ url('export/sheet') }}', { pyId : $('#pyName').val() } , function(data) {

			

		});
	});

</script>