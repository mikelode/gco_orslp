@extends('../app')

@section('main-content')

<div class="container">
	<div class="row">
		<div class="span12">
			<div class="widget wdg-box">
				<div class="widget-header">
					<button class="btn btn-success">Nuevo Proyecto</button>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="span12">
			<div class="widget widget-table action-table">
				<div class="widget-header">
					<i class="icon-th-list"></i>
					<h3>Proyectos</h3>
				</div>
				<div class="widget-content">
					<table class="table table-striped table-bordered tbl">
						<thead>
							<tr>
								<th>SNIP/CU</th>
								<th>Nombre</th>
								<th>Modalidad de Ejecución</th>
								<th>Ejecutor</th>
								<th>Equipo Profesional</th>
								<th>Acción</th>
							</tr>
						</thead>
						<tbody>
							@foreach($pys as $py)
							<tr>
								<td>{{ $py->prySnip.'/'.$py->pryUnifiedCode }}</td>
								<td>{{ $py->pryDenomination }}</td>
								<td>{{ $py->pryExeMode }}</td>
								<td>{{ $py->ejecutor[0]->ejeBusiName }}</td>
								<td>
									@foreach($tms as $tm)
										@if($tm->prfUejecutora == $py->ejecutor[0]->ejeId)
											{{ $tm->prfJob.': '.$tm->individualData->perFullName  }} <br>
										@endif
									@endforeach
								</td>
								<td class="td-action">
									<a href="javascript:;" class="btn btn-small btn-info">
										<i class="btn-icon-only icon-pencil"></i>
									</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection