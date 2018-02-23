<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="title-graph">
							AVANCE PORCENTUAL ACUMULADO <br> PROGRAMADO VS EJECUTADO
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div id="curve-s" style="position: relative; height: 400px;"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="caption">
							PERIODOS DE VALORIZACIÓN
						</div>
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
				<table class="table table-bordered table-sm action-table">
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
	
	var line_chart = Morris.Line({
		element: 'curve-s',
		data: [<?php echo $data ?>],
		xkey: 'periodo',
		xLabelAngle: 45,
		ykeys: ['programado','ejecutado'],
		postUnits: '%',
		labels: ['Cantidad Programada','Cantidad Ejecutada'],
		lineColors: ['#36A2EB','#FF6384'],
		lineWidth: [1.5,1.5],
		fillOpacity: 0.5,
		hideHover: 'auto'
	});

</script>