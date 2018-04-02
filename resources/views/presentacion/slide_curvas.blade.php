<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<a href="{{ url('export/sheet') . '?pyId=' . $cronograma[0]->prgProject . '&prId=' . $cronograma[0]->prgBudget }}" target="_blank" class="btn btn-success" id="btnMakeTemplate">Exportar Resultado a Excel</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<!--<div id="curve-s" style="position: relative; height: 400px;"></div>-->
						<div id="curve-s" width="400" height="200"></div>
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
							<th rowspan="2">% Val <br> Ejec/Prog</th>
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
							<?php 
								if($crono->prgAggregate == 0.0)
									$performance = '0.0';
								else
									$performance = $crono->prgAggregateExec/$crono->prgAggregate; 
							?>
							@if($performance <= 0.8)
							<td class="text-danger font-weight-bold">
								<img src="{{ asset('/img/danger_16.png') }}">  {{ number_format(($performance) * 100,2,'.','') }}
							</td>
							@elseif($performance > 0.8 && $performance <= 0.9)
							<td class="text-warning font-weight-bold">
								<img src="{{ asset('/img/warning_16.png') }}"> {{ number_format(($performance) * 100,2,'.','') }} 
							</td>
							@elseif($performance > 0.9 && $performance <= 1)
							<td class="text-info font-weight-bold">
								<img src="{{ asset('/img/info_16.png') }}"> {{ number_format(($performance) * 100,2,'.','') }} 
							</td>
							@elseif($performance > 1)
							<td class="text-success font-weight-bold">
								<img src="{{ asset('/img/success_16.png') }}"> {{ number_format(($performance) * 100,2,'.','') }} 
							</td>
							@endif
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

	Highcharts.chart('curve-s',{
		chart:{
			type: 'line'
		},
		title:{
			text: 'AVANCE PORCENTUAL ACUMULADO PROGRAMADO VS EJECUTADO'
		},
		subtitle:{
			text: 'ORSyLP'
		},
		xAxis:{
			categories: {!! $labels !!}
		},
		yAxis:{
			title:{
				text: 'Porcentaje de Ejecución'
			}
		},
		plotOptions:{
			line:{
				dataLabels:{
					enabled: true
				},
				enableMouseTracking: true
			}
		},
		series: {!! $chartData !!}
	});

	/*

	var ctx = $('#curve-s');
	var myChart = new Chart(ctx, {
	    type: 'line',
	    data: {! $chartData !!},
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

	*/

	$('#btnMake').click(function(evt) {
		evt.preventDefault();

		$.get('{{ url('export/sheet') }}', { pyId : $('#pyName').val() } , function(data) {

			

		});
	});

</script>