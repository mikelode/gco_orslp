@extends('../app')

@section('main-content')

<div class="container">
	<div class="row">
		<div class="widget widget-table action-table">
			<div class="widget-header">
				<i class="icon-th-list"></i>
				<h3>Proyectos</h3>
			</div>
			<div class="widget-content">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>SNIP/CU</th>
							<th>Nombre</th>
							<th>Modalidad de Ejecución</th>
							<th>Ejecutor</th>
						</tr>
					</thead>
					<tbody>
						@foreach($pys as $py)
						<tr>
							<td>{{ $py->prySnip.'/'.$py->pryUnifiedCode }}</td>
							<td>{{ $py->pryDenomination }}</td>
							<td>{{ $py->pryExeMode }}</td>
							<td>{{ $py->ejecutor[0]->ejeBusiName }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection