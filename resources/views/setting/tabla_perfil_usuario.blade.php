<meta name="csrf-token" content="{{ csrf_token() }}" />
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
});
</script>