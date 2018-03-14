@extends('../app')

@section('main-content')

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card border-info mb-2">
				<div class="card-header">
					<h5 class="float-left"><i class="icon-th-list mr-2"></i>Cronograma de Ejecución Calendarizado</h5>
				</div>
				<div class="card-body">
					<div class="form-group row">
						<label class="col-form-label col-md-1">Proyecto:</label>
						<div class="col-md-7">
							<select id="pyName" name="npyName">
								<option value="NA"> -- Seleccione un proyecto -- </option>
								@foreach($pys as $py)
									<option value="{{ $py->pryId }}">{{ $py->pryDenomination }}</option>
								@endforeach
							</select>
						</div>
						<label class="col-form-label col-md-1">Presup.</label>
						<div class="col-md-2">
							<select id="ptoName" name="ptoName" class="form-control form-control-sm"></select>
						</div>
						<div class="col-md-1">
							<button class="btn btn-outline-success btn-sm" id="btnVerPresupuesto" onclick="mostrar_cronograma($('#pyName').val(),$('#ptoName').val(),'{{ url('ver/programacion/0') }}')">Mostrar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row" id="content-programacion">
		
		
	</div>
</div>

<script>

$(document).ready(function(){

	$('#pyName').select2({
		width: '100%'
	});

	$('#pyName').change(function(evt) {

		if(this.value == 'NA'){
			return;
		}

		$.get('{{ url('list/presupuesto') }}', { pyId: this.value }, function(data) {
			$('#ptoName').html(data.optionHtml);
		});
	});
});
</script>

@endsection

@section('custom-scripts')
<script>

</script>
@endsection