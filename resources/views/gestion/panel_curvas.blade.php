@extends('../app')

@section('main-content')

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-sm-11">
							<div class="form-group row mb-0">
								<label class="col-sm-1 col-form-label">Proyecto</label>
								<div class="col-sm-11">
									<select id="pyName" name="npyName">
										@foreach($pys as $py)
											<option value="{{ $py->pryId }}">{{ $py->pryDenomination }}</option>
										@endforeach
									</select>
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

		$.get('{{ url('curvas/desplegar/1') }}', { pyId : $('#pyName').val() } , function(data) {

			$('#scheduleInfo').html(data);

		});
	});

});
</script>

@endsection

@section('custom-scripts')
<script>


</script>
@endsection