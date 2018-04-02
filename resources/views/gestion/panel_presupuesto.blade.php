@extends('../app')

@section('main-content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card border-info mb-2">
				<div class="card-header">
					<div class="card-title mb-0 font-weight-bold">
						<i class="fas fa-list"></i> Módulo de Presupuesto de Obra
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-11">
							<div class="form-group row mb-0">
								<label class="col-sm-2 col-form-label font-weight-bold pt-1">ELEGIR PROYECTO</label>
								<div class="col-sm-10">
									<select id="pyName" name="npyName">
										<option value="NA">-- Seleccione un proyecto --</option>
										@foreach($pys as $py)
											<option value="{{ $py->pryId }}">{{ $py->pryDenomination }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="col-sm-1">
							<button class="btn btn-outline-success btn-sm" id="btnVerPresupuesto" onclick="mostrar_presupuesto($('#pyName').val(),'{{ url('ver/presupuesto') }}')">Mostrar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row" id="form-content">
		
	</div>
</div>

<script>

$(document).ready(function(){

	$('#pyName').select2({
		width: '100%'
	})
});
</script>

@endsection