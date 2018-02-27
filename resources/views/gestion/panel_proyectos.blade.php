@extends('../app')

@section('main-content')

<div class="container" id="container-panel">
	<div class="row">
		<div class="col-md-12">
			<div class="card border-success mb-3">
				<div class="card-header">
					<h5 class="float-left"><i class="icon-th-list mr-2"></i>Proyectos</h5>
					@if(Auth::user()->hasPermission(2))
					<div class="float-right">
						<button class="btn btn-success btn-sm" onclick="nuevo_proyecto()">Nuevo Proyecto</button>
					</div>
					@endif
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
										@if(Auth::user()->hasPermission(3))
										<a href="javascript:editar_proyecto('{{ $py->pryId }}');" class="btn btn-sm btn-outline-primary">
											<i class="icon-pencil"></i>
										</a>
										@endif
										@if(Auth::user()->hasPermission(4))
										<button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#mdlRemoveProject" data-proyid='{{ $py->pryId }}' data-proyname='{{ $py->pryDenomination }}'>
											<i class="icon-minus"></i>
										</button>
										@endif
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
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="mdlRemoveProject" aria-labelledby="mdlRemoveProjectLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Eliminar Proyecto</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="frmRemoveProject" action="{{ url('eliminar/pry') }}">
					{{ csrf_field() }}
					<div class="form-group">
						<label>¿Está seguro de eliminar el proyecto?</label>
						<textarea readonly class="form-control-plaintext" id="pyName" name="npyName"></textarea>
						<input type="hidden" id="pyIdentify" name="npyIdentify">
					</div>
					<div class="form-group">
						<label>Detalle o nota de la eliminación</label>
						<textarea class="form-control form-control-sm" name="pyDetailRemove"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" onclick="eliminar_proyecto($('#frmRemoveProject'))">Eliminar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	
$(document).ready(function() {
	
	$('#mdlRemoveProject').on('show.bs.modal', function(evt) {
		var btn = $(evt.relatedTarget);
		var pyId = btn.data('proyid');
		var pyNm = btn.data('proyname');
		var modal = $(this);
		modal.find('.modal-body textarea#pyName').html(pyNm);
		modal.find('.modal-body input#pyIdentify').val(pyId);
	});

});

</script>

@endsection