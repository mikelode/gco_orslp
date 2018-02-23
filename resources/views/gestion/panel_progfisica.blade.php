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
					<div class="row">
						<div class="col-md-2">
							<label class="col-form-label font-weight-bold pt-1">ELEGIR PROYECTO</label>
						</div>
						<div class="col-md-9">
							<select id="pyName" name="npyName">
								<option value="NA"> -- Seleccione un proyecto -- </option>
								@foreach($pys as $py)
									<option value="{{ $py->pryId }}">{{ $py->pryDenomination }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-1">
							<button class="btn btn-outline-success btn-sm" id="btnVerPresupuesto" onclick="mostrar_cronograma($('#pyName').val(),'{{ url('ver/programacion/0') }}')">Mostrar</button>
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

	/*$('#pyName').change(function(evt) {

		if(this.value == 'NA'){
			$('#btnActionSuccess').attr('disabled','disabled').html('Crear');
			return;
		}

		$.get('{{ url('check/programacion') }}', { pyId: this.value }, function(response) {
			
			if(response == 0){
				$('#btnActionSuccess').removeAttr('disabled').html('Crear');
			}
			else{
				$('#btnActionSuccess').removeAttr('disabled').html('Mostrar');
			}
		});
	});*/
/*
	$('#btnActionSuccess').click(function(evt) {
		evt.preventDefault();

		var action = $(this).html();

		if(action == 'Crear'){

			$.get('{{ url('programacion/nuevo') }}', { pyId: $('#pyName').val() }, function(data) {
				
				$('#content-programacion').html(data);

			});

		}
		else{

		}
	});*/
});
</script>

@endsection

@section('custom-scripts')
<script>

</script>
@endsection