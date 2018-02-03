function goto_menu(path)
{
	$.get(path, function(data) {
		$('#content').html(data);
	});
}

function nuevo_proyecto()
{
	$.get('nuevo/pry', function(data) {
		$('#container-panel').html(data);
	});
}

function editar_proyecto(id)
{
	$.get('editar/pry',{pyId: id},function(data) {
		$('#container-panel').html(data);
	});
}

function check_persona(element, event)
{
	if(event.which == 13)
	{
		$.get('check/person', {dni:element.value}, function(data) {
			alert(data.msg);
			if(data.msgId == 1){
				$('#prsNames').val(data.persona.perNames);
				$('#prsPaterno').val(data.persona.perPaterno);
				$('#prsMaterno').val(data.persona.perMaterno);
				$('#prsOcup').val(data.persona.perOcupation);
				$('#prsBirthday').val(data.persona.perBirthday);
				$('#prsEmail').val(data.persona.perEmail);
				$('#prsPhone').val(data.persona.perPhone1);
			}
			else{
				$('#prsNames').val('');
				$('#prsPaterno').val('');
				$('#prsMaterno').val('');
				$('#prsOcup').val('');
				$('#prsBithday').val('');
				$('#prsEmail').val('');
				$('#prsPhone').val('');
			}
		});
	}
}

function append_profesional(form)
{
	var data = form.serialize();
	var url = form.prop('action');

	$.post(url, data, function(response) {
		if(response.msgId == '200'){
			var newRow = $('<tr>');
			var cols = '';

			cols += '<td width="10%"><input name="nteamId[]" type="hidden" value="' + response.persona.perId +'"><input type="text" class="form-control form-control-sm" value="' + response.persona.perDni +'" readonly></td>';
			cols += '<td width="20%"><select name="nteamJob[]" class="form-control form-control-sm"><option value="NA">-- Cargo --</option><option value="RESIDENTE"> Residente </option><option value="SUPERVISOR"> Supervisor </option><option value="INSPECTOR"> Inspector </option><option value="ASISTENTE ADMINISTRATIVO"> Asistente Administrativo </option><option value="ASISTENTE TECNICO"> Asistente Técnico </option><option value="OTRO"> Otro </option></select></td>';
			cols += '<td width="60%"><input type="text" readonly class="form-control-plaintext" value="' + response.persona.perFullName + '"></td>';
			cols += '<td width="10%"><button type="button" class="ibtnDel btn btn-sm btn-danger">Quitar</button></td>';

			newRow.append(cols);
			$('table#tblProfessionalTeam').append(newRow);
		}
		else{
			alert(response.msg);
		}
	});
}

function registrar_proyecto(form, event)
{
	event.preventDefault();
	var data = form.serialize();
	var url = form.prop('action');

	$.post(url, data, function(response){
		alert(response.msg);
		if(response.msgId == '200'){
			window.location = response.url;
		}
	});
}

function actualizar_proyecto(form, event)
{
	event.preventDefault();
	var data = form.serialize();
	var url = form.prop('action');

	$.post(url, data, function(response){
		alert(response.msg);
		if(response.msgId == '200'){
			editar_proyecto(response.pyId);
		}
	});
}

function saludo()
{
	alert('HOLAAA');
}