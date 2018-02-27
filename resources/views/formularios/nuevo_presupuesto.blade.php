<div class="col-md-10 pr-0">
	<div class="card">
		<div class="card-header py-1"><b> Presupuesto Resumen </b></div>
		<div class="card-body">
			<form id="frmRegisterBudget" action="{{ url('nuevo/presupuesto') }}">
				{{ csrf_field() }}
				<input type="hidden" name="hnpyId" value="{{ $pry->pryId }}">
				<table class="table table-sm">
					<thead class="thead-dark">
						<tr>
							<th>Descripción</th>
							<th>Proporción</th>
							<th>Presupuesto</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<input type="text" name="nptoItemGral[]" class="form-control-plaintext" readonly value="COSTO DIRECTO">
								<input type="hidden" name="nptoCodeItem[]" value="CD">
								<input type="hidden" name="nptoOrder[]" value="1">
							</td>
							<td>
								<input type="hidden" name="nptoItemPercent[]">
							</td>
							<td>
								<div class="input-group input-group-sm">
									<input type="text" class="form-control" name="nptoItemMount[]">
									<div class="input-group-append">
										<span class="input-group-text">S/</span>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="nptoItemGral[]" class="form-control-plaintext" readonly value="GASTOS GENERALES">
								<input type="hidden" name="nptoCodeItem[]" value="GG">
								<input type="hidden" name="nptoOrder[]" value="2">
							</td>
							<td>
								<div class="input-group input-group-sm">
									<input type="text" class="form-control" name="nptoItemPercent[]">
									<div class="input-group-append">
										<span class="input-group-text">%</span>
									</div>
								</div>
							</td>
							<td>
								<div class="input-group input-group-sm">
									<input type="text" class="form-control" name="nptoItemMount[]">
									<div class="input-group-append">
										<span class="input-group-text">S/</span>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="nptoItemGral[]" class="form-control-plaintext" readonly value="UTILIDAD">
								<input type="hidden" name="nptoCodeItem[]" value="U">
								<input type="hidden" name="nptoOrder[]" value="3">
							</td>
							<td>
								<div class="input-group input-group-sm">
									<input type="text" class="form-control" name="nptoItemPercent[]">
									<div class="input-group-append">
										<span class="input-group-text">%</span>
									</div>
								</div>
							</td>
							<td>
								<div class="input-group input-group-sm">
									<input type="text" class="form-control" name="nptoItemMount[]">
									<div class="input-group-append">
										<span class="input-group-text">S/</span>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="nptoItemGral[]" class="form-control-plaintext" readonly value="SUBTOTAL GENERAL">
								<input type="hidden" name="nptoCodeItem[]" value="ST">
								<input type="hidden" name="nptoOrder[]" value="4">
							</td>
							<td>
								<input type="hidden" name="nptoItemPercent[]">
							</td>
							<td>
								<div class="input-group input-group-sm">
									<input type="text" class="form-control" name="nptoItemMount[]">
									<div class="input-group-append">
										<span class="input-group-text">S/</span>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="nptoItemGral[]" class="form-control-plaintext" readonly value="IGV">
								<input type="hidden" name="nptoCodeItem[]" value="IGV">
								<input type="hidden" name="nptoOrder[]" value="5">
							</td>
							<td>
								<div class="input-group input-group-sm">
									<input type="text" class="form-control" name="nptoItemPercent[]">
									<div class="input-group-append">
										<span class="input-group-text">%</span>
									</div>
								</div>
							</td>
							<td>
								<div class="input-group input-group-sm">
									<input type="text" class="form-control" name="nptoItemMount[]">
									<div class="input-group-append">
										<span class="input-group-text">S/</span>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="nptoItemGral[]" class="form-control-plaintext" readonly value="PRESUPUESTO TOTAL">
								<input type="hidden" name="nptoCodeItem[]" value="PT">
								<input type="hidden" name="nptoOrder[]" value="6">
							</td>
							<td>
								<input type="hidden" name="nptoItemPercent[]">
							</td>
							<td>
								<div class="input-group input-group-sm">
									<input type="text" class="form-control" name="nptoItemMount[]">
									<div class="input-group-append">
										<span class="input-group-text">S/</span>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</div>
</div>
<div class="col-md-2 pl-1">
	<div class="card">
		<div class="card-header py-1"><b>Operaciones</b></div>
		<div class="card-body px-2">
			@if(Auth::user()->hasPermission(6))
			<button type="button" class="btn btn-sm btn-success btn-block" onclick="registrar_presupuesto($('#frmRegisterBudget'))">
				<i class="icon-save mr-3"></i>Registrar
			</button>
			@endif
		</div>
	</div>
</div>