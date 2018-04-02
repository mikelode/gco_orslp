@extends('../app')

@section('main-content')

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-11">
							<div class="form-group row mb-0">
								<label class="col-md-1 col-form-label">Proyecto</label>
								<div class="col-md-8">
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
							</div>
						</div>
						<div class="col-sm-1">
							<button class="btn btn-outline-success btn-sm" id="btnDesplegarCurva">Mostrar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" id="scheduleInfo">
			
		</div>
	</div>
</div>

<script>

$(document).ready(function(){

	$('#pyName').select2({
		width: '100%'
	});

	$('#btnDesplegarCurva').click(function(evt) {
		evt.preventDefault();

		$.get('{{ url('curvas/desplegar/1') }}', { pyId : $('#pyName').val(), prId : $('#ptoName').val() } , function(data) {

			$('#scheduleInfo').html(data);

		});
	});

	$('#pyName').change(function(event) {
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