@extends('../app')

@section('main-content')

<div class="container">
	<div class="row">
		<div class="span12">
			<div class="widget wdg-box">
				<div class="widget-content">
					<div class="row">
						<div class="span7">
							Proyecto:
							<select id="pyName" name="npyName">
								@foreach($pys as $py)
									<option value="{{ $py->pryId }}">{{ $py->pryDenomination }}</option>
								@endforeach
							</select>
							<button class="btn btn-success">Buscar</button>
						</div>
						<div class="span5"></div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="span12">
			<div class="widget widget-table action-table">
				<div class="widget-header">
					<i class="icon-th-list"></i>
					<h3>Presupuesto</h3>
				</div>
				<div class="widget-content">
					<table class="table table-striped table-bordered tbl">
						<thead>
							<tr>
								<th>Nro</th>
								<th>item</th>
								<th>Descripcion</th>
								<th>Unidad</th>
								<th>Metrado</th>
								<th>Precio</th>
								<th>Parcial</th>
							</tr>
						</thead>
						<tbody class="tbl-pres">
							@foreach($pto as $i=>$pt)

								<tr @if($pt->preMetered == 0) class="lvl-{{ $pt->preLevel }}" @endif>
									<td>{{ $i + 1 }}</td>
									<td>{{ $pt->preItem }}</td>
									<td>{{ $pt->preDescription }}</td>
									<td>{{ $pt->preUnit }}</td>
									<td>{{ $pt->preMetered }}</td>
									<td>{{ $pt->prePrice }}</td>
									<td>{{ $pt->prePartial }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$('#pyName').select2({
		width: '70%'
	});
});
</script>

@endsection