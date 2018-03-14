<form id="frmCreatePrestacion" action="{{ url('store/prestacion') }}">
	{{ csrf_field() }}
	<input type="hidden" name="hnpryId" value="{{ $pto->preProject }}">
	<div class="card">
		<div class="card-body py-2">
			<div class="form-group row">
				<label class="col-md-4 col-form-label">Tipo de Prestación</label>
				<div class="col-md-8">
					<select class="form-control form-control-sm" name="nptoTipo">
						@foreach($ptoTipo as $tipo)
						<option value="{{ $tipo->tprId }}">{{ $tipo->tprDescription }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-4 col-form-label">Denominación</label>
				<div class="col-md-8">
					<input type="text" name="nptoDescPrest" class="form-control form-control-sm" placeholder="Nombre del adicional/deductivo">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-3 col-form-label">Detalle</label>
				<div class="col-md-9">
					<textarea class="form-control form-control-sm" name="nptoNote"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<table class="table table-sm">
						<thead>
							<tr>
								<th width="10%">Code</th>
								<th width="40%">Descripción</th>
								<th width="20%">%</th>
								<th width="30%">Monto</th>
							</tr>
						</thead>
						<tbody>
							@foreach($items as $i => $item)
							<tr>
								<td>
									<input type="hidden" name="hniprOrder[]" value="{{ $item->iprOrder }}">
									<input type="text" name="niprCode[]" readonly class="form-control-plaintext" value="{{ $item->iprCodeItem }}">
								</td>
								<td>
									<input type="text" name="niprGnrl[]" readonly class="form-control-plaintext" value="{{ $item->iprItemGeneral }}">
								</td>
								<td>
									<input type="text" name="niprPrcnt[]" class="form-control-plaintext" value="{{ $item->iprItemGeneralPrcnt }}">
								</td>
								<td>
									<input type="text" name="niprMountPrest[]" class="form-control form-control-sm">
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</form>