@extends('../app')

@section('main-content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card border-info mb-2">
				<div class="card-header py-1">
					<div class="card-title mb-0 font-weight-bold">
						<i class="fas fa-list"></i> Módulo de Valorizaciónes de Obra:	
					</div>
				</div>
				<div class="card-body py-2">
					<form action="{{ url('detallado/avance') }}" id="frmDetailProgress">
						{{ csrf_field() }}
						<div class="form-group row mb-0">
							<label class="col-md-1">Proyecto: </label>
							<div class="col-md-4">
								<select id="pyName" name="npyName">
									<option value="NA">-- Seleccione un Proyecto --</option>
									@foreach($pys as $py)
										<option value="{{ $py->pryId }}">{{ $py->pryDenomination }}</option>
									@endforeach
								</select>
							</div>
							<label class="col-md-1">Presupuesto: </label>
							<div class="col-md-2">
								<select id="ptSelect" name="nptSelect" class="form-control form-control-sm"></select>
							</div>
							<label class="col-md-1">Valorización: </label>
							<div class="col-md-2">
								<select id="avSelect" name="navSelect" class="form-control form-control-sm">
								</select>
							</div>
							<div class="col-md-1">
								<button type="button" class="btn btn-sm btn-outline-success" onclick="mostrar_avance($('#pyName').val(),$('#avSelect').val(),'{{ url('ver/avance') }}')">Ver Avance</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="row" id="content-progress">
		
	</div>
	<form action="{{ url('almacenar/avance') }}" id="frmStoreProgress">
		{{ csrf_field() }}
		<input type="hidden" name="dataGridDetail" value="">
		<input type="hidden" name="dataGridResume" value="">
		<input type="hidden" id="dataProject" name="npyId" value="">
		<input type="hidden" id="dataBudget" name="nptId" value="">
		<input type="hidden" id="dataProgress" name="nbpId" value="">
	</form>
</div>
<div class="modal fade" id="mdlFormProgress" tabindex="-1" role="dialog" aria-labelledby="importarModal" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				Registro de Nueva Valorización
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="content-frm">
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="registrar_avance($('#frmCreateProgress'))">Registrar</button>
        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script>

$(document).ready(function(){

	$('#mdlFormProgress').on('show.bs.modal', function(event) {

		var py = $('#pyName').val();
		var pt = $('#ptSelect').val();
		var modal = $(this);

		$.get('{{ url('avance/nuevo') }}',{pyId: py, ptId: pt}, function(data) {
			
			modal.find('.modal-body #content-frm').html(data);

		});
	});

	$('#pyName').select2({
		width: '100%'
	});

	$('#avSelect').change(function(event) {

		if(this.value == 'CP'){

			if($('#pyName').val() == 'NA'){
				alert('Primero debe seleccionar el proyecto al cual se registrará su avance');
				this.value = 'NA';
				return;
			}

			$('#mdlFormProgress').modal('show');
		}
		else{
			$('#dataProgress').val(this.value);
		}

	});

	$('#pyName').change(function(ev) {

		if(this.value == 'NA'){
			$('#ptSelect').html('');
			$('#avSelect').html('');
			return;
		}

		$('#dataProject').val(this.value);

		$.get('{{ url('list/presupuesto') }}', {pyId: this.value}, function(data){
			$('#ptSelect').html(data.optionHtml);
		})
	});

	$('#ptSelect').change(function(evt) {
		
		if(this.value == 'NA'){
			$('#avSelect').html('');
			return;
		}

		$('#dataBudget').val(this.value);

		$.get('{{ url('list/avance') }}',{ptId: this.value}, function(data) {
			
			$('#avSelect').html(data.optionHtml);

		});

	});

});
</script>

@endsection