function configureLoadingScreen(screen){
	$(document)
		.ajaxStart(function() {
			screen.fadeIn();
		})
		.ajaxStop(function() {
			screen.fadeOut();
		});
}

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

function eliminar_proyecto(form)
{
	var url = form.prop('action');
	var data = form.serialize();

	$.post(url, data, function(response) {
		alert(response.msg);
		if(response.msgId == '200'){
			window.location = response.url;
		}
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

function registrar_presupuesto(form)
{
	var url = form.prop('action');
	var data = form.serialize();

	$.post(url, data, function(response) {
		alert(response.msg);
		if(response.msgId == '200')
			mostrar_presupuesto(response.pyId, response.url);
	});
}

function mostrar_presupuesto(py,url)
{
	var pyId = py;

	if(pyId == 'NA'){
		alert('Debe seleccionar el proyecto para ver su presupuesto');
		return;
	}

	$.get(url, { pyId: pyId}, function(data) {
		$('#form-content').html(data);
	});
}

function editar_presupuesto(btn, form)
{
	var action = btn[0].value;

	if(action == 'editar'){
		$('.preEdit').prop('readonly', false);
		btn[0].value = 'cancelar';
		btn.text('Cancelar Edición');
		btn.attr('class', 'btn btn-sm btn-warning btn-block');
		$('#btnUpdateBudget').show();
	}
	else if(action == 'cancelar'){
		$('.preEdit').prop('readonly', true);
		btn[0].value = 'editar';
		btn.text('Editar Presupuesto');
		btn.attr('class', 'btn btn-sm btn-primary btn-block');
		$('#btnUpdateBudget').hide();
	}
}

function actualizar_presupuesto(form)
{
	var url = form.prop('action');
	var data = form.serialize();

	$.post(url, data, function(response) {
		alert(response.msg)

		if(response.msgId == '200')
			mostrar_presupuesto(response.pyId, response.url);
	});
}

function cargar_presupuesto(id, callback)
{
	$.ajax({
		'url': 'list/partidas',
		'type': 'GET',
		'data': {pyId: id},
		'success': callback
	});
}

function cargar_presupuesto1(id)
{
	var partidas = [];

	$.get('list/partidas', {pyId: id}, function(data) {

		$.each(data.pto, function(i, val) {
			 partidas[i] = [val.preId,val.preLevel];
		});
	});

	return partidas;
}

function importar_partidas(form)
{
	var frmData = new FormData(form);

	$.ajax({
        type: 'post',
        url: 'importar/partidas',
        data: frmData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response){
            alert(response.msg);
            $('#mdlImportFile').modal('hide');
            if(response.msgId == 200){
            	mostrar_presupuesto(response.pyId, response.url);
            }
        },
        xhr: function(){
            var myXhr = $.ajaxSettings.xhr();
            if(myXhr.upload){
                myXhr.upload.addEventListener('progress', function(ev){
                    if(ev.lengthComputable){
                        $('progress').attr({
                            value: ev.loaded,
                            max: ev.total,
                        });
                    }
                }, false);
            }
            return myXhr;
        },
    });
}

function habilitar_edicion(btn, grid)
{
	alert(btn.text());
	if(btn[0].value === 'enable'){
		grid.setOptions({editable: false});
		btn[0].value = 'disable'
		btn.text('Editar Partidas');
		btn.attr('class', 'btn btn-sm btn-info btn-block');
	}
	else if(btn[0].value === 'disable'){
		grid.setOptions({editable: true});
		btn[0].value = 'enable';
		btn.text('Cancelar');
		btn.attr('class', 'btn btn-sm btn-warning btn-block');
	}
}

function mostrar_avance(pyId, avId, url)
{
	if(pyId == 'NA' || avId == null || avId == 'NA'){
		alert('Llene los campos anteriores');
		return;
	}
	if(avId == 'CP'){
		alert('Seleccione el periodo de avance que desea desplegar');
		return;
	}

	$.get(url,{pyId: pyId, avId: avId}, function(data) {
		$('#content-progress').html(data);
	});
}

function registrar_avance(form)
{
	var data = form.serialize();
	var url = form.prop('action');

	$.post(url, data, function(response) {

		alert(response.msg);
		if(response.msgId == '200')
			window.location = response.url;
	});
}

function CreateAddlHeaderRow(grid,columns) {
    var $preHeaderPanel = $(grid.getPreHeaderPanel())
        .empty()
        .addClass("slick-header-columns")
        .css('left','-1000px')
        .width(grid.getHeadersWidth());
    $preHeaderPanel.parent().addClass("slick-header");
    var headerColumnWidthDiff = grid.getHeaderColumnWidthDiff();
    var m, header, lastColumnGroup = '', widthTotal = 0;
    
    for (var i = 0; i < columns.length; i++) {
     	m = columns[i];
      	if (lastColumnGroup === m.columnGroup && i>0) {
        	widthTotal += m.width;
        	header.width(widthTotal - headerColumnWidthDiff)
      	} else {
          	widthTotal = m.width;
          	header = $("<div class='ui-state-default slick-header-column' />")
            .html("<span class='slick-column-name'>" + (m.columnGroup || '') + "</span>")
            .width(m.width - headerColumnWidthDiff)
            .appendTo($preHeaderPanel);
      	}
      	lastColumnGroup = m.columnGroup;
    }
}

function updateDirectCost(rowDc, cellMount, gridToUpdate, gridSource, dataSource, dataTarget)
{
	var columnId = gridSource.getColumns()[cellMount].field;
	var total = 0;
	var i = dataSource.length;

	while(i--){
		total += (parseFloat(dataSource[i][columnId]) || 0);
	}
	for(var i=0; i<=5; i++){
		switch(i){
			case 0:
				dataTarget[rowDc]['avrMountCv'] = total;
				break;
			case 1:
				dataTarget[rowDc + 1]['avrMountCv'] = Math.round((parseFloat(dataTarget[rowDc + 1]['preItemGeneralPrcnt']) * total) * 100 ) / 100;
				break;
			case 2:
				dataTarget[rowDc + 2]['avrMountCv'] = Math.round((parseFloat(dataTarget[rowDc + 2]['preItemGeneralPrcnt']) * total) * 100 ) / 100;
				break;
			case 3:
				dataTarget[rowDc + 3]['avrMountCv'] = Math.round((parseFloat(dataTarget[rowDc]['avrMountCv']) + parseFloat(dataTarget[rowDc + 1]['avrMountCv']) + parseFloat(dataTarget[rowDc + 2]['avrMountCv']) ) * 100 ) / 100;
				break;
			case 4:
				dataTarget[rowDc + 4]['avrMountCv'] = Math.round((parseFloat(dataTarget[rowDc + 4]['preItemGeneralPrcnt']) * parseFloat(dataTarget[rowDc + 3]['avrMountCv'])) * 100 ) / 100;
				break;
			case 5:
				dataTarget[rowDc + 5]['avrMountCv'] = Math.round((parseFloat(dataTarget[rowDc + 3]['avrMountCv']) + parseFloat(dataTarget[rowDc + 4]['avrMountCv'])) * 100 ) / 100;
				break;
		}

		dataTarget[rowDc + i]['avrPercentCv'] = Math.round((parseFloat(dataTarget[rowDc + i]['avrMountCv']) / parseFloat(dataTarget[rowDc + i]['preItemGeneralMount'])) * 10000) / 100;
		dataTarget[rowDc + i]['avrMountCa'] = Math.round((parseFloat(dataTarget[rowDc + i]['avrMountCv']) + parseFloat(dataTarget[rowDc + i]['avrMountBa'])) * 100 ) / 100;
		dataTarget[rowDc + i]['avrPercentCa'] = Math.round((parseFloat(dataTarget[rowDc + i]['avrMountCa']) / parseFloat(dataTarget[rowDc + i]['preItemGeneralMount'])) * 10000) / 100;
		dataTarget[rowDc + i]['avrMountBv'] = Math.round((parseFloat(dataTarget[rowDc + i]['preItemGeneralMount']) - parseFloat(dataTarget[rowDc + i]['avrMountCa'])) * 100 ) / 100;
		dataTarget[rowDc + i]['avrPercentBv'] = 100 - parseFloat(dataTarget[rowDc + i]['avrPercentCa']);

		gridToUpdate.invalidateRow(rowDc + i);
	}

	gridToUpdate.render();
}

function guardar_avance(gridDetail, gridResume, form, close)
{
	if(close == 1){
		var ok = confirm("Una vez dado por finalizado el registro ya no podrá editarlo. \n ¿Está seguro seguro de continuar con esta operación?");
		if(!ok){
			return;
		}
	}

	var url = form.prop('action') + '/' + close;
	form.find("input[name='dataGridDetail']").val(JSON.stringify(gridDetail.getData()));
	form.find("input[name='dataGridResume']").val(JSON.stringify(gridResume.getData()));
	var data = form.serialize();

	$.post(url, data, function(response) {
		alert(response.msg);
		if(response.msgId == '200')
			window.location = response.url;
	});
}

function check_cien(celda){
	
	var sum = 0;
	celda.each(function() {
		valor = numeral(this.value).value();
	 	if(!isNaN(valor) && this.value.length != 0){
	 		sum += parseFloat(this.value);
	 	}
	});

	total = numeral(sum).format('0,0.00');
	sum = numeral(total).value();
	
	return sum;
}

function mostrar_cronograma(py,url)
{
	var pyId = py;

	if(pyId == 'NA'){
		alert('Debe seleccionar el proyecto para ver su presupuesto');
		return;
	}

	$.get(url, { pyId: pyId}, function(data) {
		$('#content-programacion').html(data);
	});
}

function registrar_cronograma(form)
{
	var url = form.prop('action');
	var data = form.serialize();

	$.post(url, data, function(response) {
		alert(response.msg);
		if(response.msgId == '200')
			window.location = response.url;
	});
}

function editar_cronograma(btn, form)
{
	var action = btn[0].value;

	if(action == 'editar'){
		$('.cronoedit').prop('readonly', false);
		btn[0].value = 'cancelar';
		btn.text('Cancelar Edición');
		btn.attr('class', 'btn btn-sm btn-warning btn-block');
		$('#btnEditSchedule').show();
		$('#btnAddPeriod').show();
	}
	else if(action == 'cancelar'){
		mostrar_cronograma(form.find('#pyId').val(),'../ver/programacion/0');
		/*$('.cronoedit').prop('readonly', true);
		btn[0].value = 'editar';
		btn.text('Editar Cronograma');
		btn.attr('class', 'btn btn-sm btn-info btn-block');
		$('#btnEditSchedule').hide();
		$('#btnAddPeriod').hide();*/
	}
}

function agregar_periodo(table)
{
	var lastRow = table.find('tbody tr:last').attr('id');
	var lastNumber = lastRow.split('-')[1];
	var newNumber = parseInt(lastNumber) + 1;

	var rowHtml = '<tr id="val-' + newNumber + '">';
	rowHtml += '<td><input type="hidden" name="hnvalId[]" value="0"><input type="number" name="nvalNumber[]" class="form-control-plaintext" readonly value="' + newNumber + '"></td>';
	rowHtml += '<td><input type="date" name="nvalPeriod[]" class="form-control-plaintext cronoedit"></td>';
	rowHtml += '<td><input type="text" name="nvalMount[]" class="form-control-plaintext valMount cronoedit"></td>';
	rowHtml += '<td><input type="text" name="nvalPrcnt[]" class="form-control-plaintext valPrcnt cronoedit"></td>';
	rowHtml += '<td><input type="text" name="nvalAggrt[]" class="form-control-plaintext valAggrt cronoedit"></td>';
	rowHtml += '<td><textarea class="textarea-cell" name="nvalNote[]" rows="1" cols="10"></textarea></td>';
	rowHtml += '<td><a href="javascript:void(0)" onclick="eliminar_fila(this)" class="text-danger">(-) Quitar</a></td>';
	rowHtml += '</tr>';

	table.find('tbody tr:last').after(rowHtml);
}

function eliminar_fila(btn)
{
	var erow = $(btn).closest('tr');
	var erowId = $(btn).closest('tr').attr('id');
	var table = $(btn).closest('table');
	var lrowId =  $(table).find('tbody tr:last').attr('id')

	if(erowId == lrowId){
		erow.remove();
	}
	else{
		alert('La eliminación debe empezar de la última fila');
	}
}

function actualizar_cronograma(form)
{
	var url = form.prop('action');
	var data = form.serialize();

	$.post(url, data, function(response) {
		alert(response.msg)
		if(response.msgId == '200'){
			mostrar_cronograma(response.pyId, response.url);
		}

	});
}

function change_to_submenu(path)
{
    $.get(path, function(data){
        $('#sub-content').html(data);
    });
}