<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="form-group row">
    <label class="col-md-3 col-form-label">Acceso al Proyecto</label>
    <div class="col-md-6">
        <select id="pyName" name="npyName[]" multiple>
            <option value="NA">-- Seleccione uno o varios --</option>
            <option value="0" {{ $user_projects[0] == 0 ? 'selected' : '' }}> -- Todos los Proyectos -- </option>
            @foreach($projects as $py)
                <option value="{{ $py->pryId }}" {{ in_array($py->pryId, $user_projects) ? 'selected' : '' }}>
                    {{ $py->pryShortDenomination }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <button type="button" class="btn btn-success btn-small">Actualizar Acceso</button>
    </div>
</div>
<table class="table table-sm">
    <thead>
    <tr>
        <th colspan="11">DOCUMENTOS</th>
    </tr>
    <tr>
        <th>Id</th>
        <th>Modulo</th>
        <th>Función</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody>
        @foreach($funciones as $i => $f)
            <tr>
                <td>{{ $f->tsysId }}</td>
                <td>{{ $f->tsysModulo }}</td>
                <td>{{ $f->tsysDescF }}</td>
                <td>
                    @if(in_array($f->tsysId, $idProfile->toArray()))
                        <a href="#" data-type="select" class="fncEstado" data-title="Estado de asignación de la función" data-pk="{{ $f->tsysId }}" data-value="A" data-name="{{ $idUser }}">Asignado</a>
                    @else
                        <a href="#" data-type="select" class="fncEstado" data-title="Estado de asignación de la función" data-pk="{{ $f->tsysId }}" data-value="B" data-name="{{ $idUser }}">No asignado</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
$(function(){

    var token = $('meta[name="csrf-token"]').attr('content');

    $('.fncEstado').editable({
        url: 'settings/updt_profile',
        params: {_token: token},
        source: [
              {value: 'A', text: 'Asignado'},
              {value: 'B', text: 'No Asignado'}
           ],
        success: function(response, newValue){
            if(!response.success) return "Error en el intento de cambiar el estado";
            console.log(newValue);
        }
    });

    $('#pyName').select2({
        width: '100%'
    });
});
</script>