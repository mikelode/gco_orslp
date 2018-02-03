@extends('../app')

@section('main-content')

<div class="container" id="container-panel">
	<div class="row">
		<div class="col-md-12">
			<div class="card border-success mb-3">
				<div class="card-header">
					<h5 class="float-left"><i class="icon-th-list mr-2"></i>Proyectos</h5>
					<div class="float-right">
						<button class="btn btn-success" onclick="nuevo_proyecto()">Nuevo Proyecto</button>
					</div>
				</div>
				<div class="card-body">
					<div class="card">
						<table class="table table-sm table-hover action-table">
							<thead class="thead-dark">
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
									<td class="td-actions">
										<a href="javascript:editar_proyecto('{{ $py->pryId }}');" class="btn btn-sm btn-outline-primary">
											<i class="icon-pencil"></i>
										</a>
										<a href="javascript:;" class="btn btn-sm btn-outline-danger">
											<i class="icon-minus"></i>
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
	<div class="row">
		<div class="col-md-12">
			
		</div>
	</div>
</div>

@endsection