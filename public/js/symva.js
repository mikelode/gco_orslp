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
		$.get('../check/person', {dni:element.value}, function(data) {
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
		alert(response.msg);
		if(response.msgId == '200'){
			window.location = response.url;
		}
	});
}

/*function registrar_proyecto(form, event, campo)
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
}*/

function registrar_proyecto(form, event, campo)
{
	event.preventDefault();

	if(campo == 'dtaPrc'){

		var frmData = new FormData(form);
		$.ajax({
			type: 'post',
			url: 'nuevo/prc',
			data: frmData,
			cache: false,
			contentType: false,
			processData: false,
			success: function(response){
				alert(response.msg);
				if(response.msgId == 200){
					console.log(response);
					$('#epyId').val(response.proyecto.pryId);
					$('#epyNameStored').val(response.proyecto.pryDenomination);

					var slcPostores = document.createElement('select');
					slcPostores.className = "form-control form-control-sm";
					slcPostores.name = "nejePostor";
					$.each(response.postores, function(i, value){
						slcOpcion = document.createElement('option');
						slcOpcion.value = value.pstId;
						slcOpcion.text = value.individual_data.prjBusiName;
						slcPostores.add(slcOpcion);
					});

					document.getElementById('divContratista').appendChild(slcPostores);

					$('#ed-tab').tab('show');
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
	else{
		var url = form.prop('action');
		var data = form.serialize();

		$.post(url, data, function(response){
			alert(response.msg);
			if(response.msgId == '200'){
				if(campo == 'dtaPrj'){
					$('#pyId').val(response.proyecto.pryId);
					$('#pyNameStored').val(response.proyecto.pryDenomination);
					$('#ps-tab').tab('show');
				}
				else if(campo == 'dtaExe'){
					window.location = response.url;
				}
			}
		});
	}
}

function actualizar_proyecto(form, event, campo)
{
	event.preventDefault();

	if(campo == 'dtaPrc'){

		var frmData = new FormData(form);
		console.log(frmData);
		$.ajax({
			type: 'post',
			url: 'editar/prc',
			data: frmData,
			cache: false,
			contentType: false,
			processData: false,
			success: function(response){
				alert(response.msg);
				if(response.msgId == 200){
					editar_proyecto(response.pyId);
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
	else{
		var data = form.serialize();
		var url = form.prop('action');

		$.post(url, data, function(response){
			alert(response.msg);
			if(response.msgId == '200'){
				editar_proyecto(response.pyId);
			}
		});
	}
}

/* function actualizar_proyecto(form, event)
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
} */

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
		$('.btnUpdateBudget').show();
		$('#btnAddPrestBudget').show();
	}
	else if(action == 'cancelar'){
		$('.preEdit').prop('readonly', true);
		btn[0].value = 'editar';
		btn.text('Editar Presupuesto');
		btn.attr('class', 'btn btn-sm btn-primary btn-block');
		$('.btnUpdateBudget').hide();
		$('#btnAddPrestBudget').hide();
	}
}

function actualizar_presupuesto1(form) // descartado por el metodo de guardado de presupuesto por presupuesto row by row
{
	var url = form.prop('action');
	var data = form.serialize();

	$.post(url, data, function(response) {
		alert(response.msg)

		if(response.msgId == '200')
			mostrar_presupuesto(response.pyId, response.url);
	});
}

function actualizar_presupuesto(element)
{
	var data = {};
	var row = $(element).closest('tr');
	var token = $('#frmUpdateBudget').find('input[name="_token"]').get(0);

	var form = document.createElement('form');
	form.setAttribute('action','actualizar/presupuesto');

	row.find('input,textarea').each(function(i, el) {
		form.appendChild(el);
	});
	form.appendChild(token);

	var url = $(form).prop('action');
	var data = $(form).serialize();

	console.log(data);

	$.post(url, data, function(response) {
		alert(response.msg)
		if(response.msgId == '200')
			mostrar_presupuesto(response.pyId, response.url);
	});
}

function cargar_presupuesto(pyId, ptId, callback)
{
	$.ajax({
		'url': 'list/partidas',
		'type': 'GET',
		'data': {pyId: pyId, ptId: ptId},
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

function adjuntar_archivo_prg(form)
{
	var frmData = new FormData(form);

	$.ajax({
        type: 'post',
        url: '../documento/programacion',
        data: frmData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response){
            alert(response.msg);
            $('#mdlAttachFile').modal('hide');
            if(response.msgId == 200){
				mostrar_cronograma(response.pyId, response.ptId, response.url);
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

function adjuntar_archivo(form)
{
	var frmData = new FormData(form);

	$.ajax({
        type: 'post',
        url: 'documento/prestacion',
        data: frmData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response){
            alert(response.msg);
            $('#mdlAttachFile').modal('hide');
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

function habilitar_edicion_avance(btn, grid)
{
	console.log(btn.data('value'));
	if(btn.data('value') === 'enable'){
		grid.setOptions({editable: false});
		//btn.attr('data-value', 'disable');
		btn.data('value','disable');
		btn.find('img#imgCancel').hide();
		btn.find('img#imgEdit').show();
	}
	else if(btn.data('value') === 'disable'){
		grid.setOptions({editable: true});
		//btn.attr('data-value', 'enable');
		btn.data('value','enable');
		btn.find('img#imgCancel').show();
		btn.find('img#imgEdit').hide();
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
	var columnId = gridSource.getColumns()[cellMount].field; // get the mount field name
	var total = 0;
	var i = dataSource.length;
	var itemCode;
	var cd = gg = ggf = ggv = u = st = igv = 0;

	while(i--){
		total += (parseFloat(dataSource[i][columnId]) || 0);
	}
	
	for(var i=0; i<dataTarget.length; i++){

		var itemCode = dataTarget[i].avrCodeItem;

		switch(itemCode){
			case 'CD':
				dataTarget[i].avrMountCv = cd = total;
				break;
			case 'GG':
				dataTarget[i]['avrMountCv'] = gg = Math.round((parseFloat(dataTarget[i]['iprItemGeneralPrcnt'])/100 * total) * 100 ) / 100;
				break;
			case 'GGF':
				dataTarget[i]['avrMountCv'] = ggf = Math.round((parseFloat(dataTarget[i]['iprItemGeneralPrcnt'])/100 * total) * 100 ) / 100;
				break;
			case 'GGV':
				dataTarget[i]['avrMountCv'] = ggv = Math.round((parseFloat(dataTarget[i]['iprItemGeneralPrcnt'])/100 * total) * 100 ) / 100;
				break;
			case 'U':
				dataTarget[i]['avrMountCv'] = u = Math.round((parseFloat(dataTarget[i]['iprItemGeneralPrcnt'])/100 * total) * 100 ) / 100;
				break;
			case 'ST':
				//dataTarget[i]['avrMountCv'] = st = Math.round((parseFloat(dataTarget[rowDc]['avrMountCv']) + parseFloat(dataTarget[rowDc + 1]['avrMountCv']) + parseFloat(dataTarget[rowDc + 2]['avrMountCv']) ) * 100 ) / 100;
				dataTarget[i]['avrMountCv'] = st = Math.round((cd + gg + ggf + ggv + u) * 100 ) / 100;
				break;
			case 'IGV':
				//dataTarget[i]['avrMountCv'] = igv = Math.round((parseFloat(dataTarget[rowDc + 4]['preItemGeneralPrcnt']) * parseFloat(dataTarget[rowDc + 3]['avrMountCv'])) * 100 ) / 100;
				dataTarget[i]['avrMountCv'] = igv = Math.round((parseFloat(dataTarget[i]['iprItemGeneralPrcnt'])/100 * st) * 100 ) / 100;
				break;
			case 'PT':
				//dataTarget[i]['avrMountCv'] = Math.round((parseFloat(dataTarget[rowDc + 3]['avrMountCv']) + parseFloat(dataTarget[rowDc + 4]['avrMountCv'])) * 100 ) / 100;
				dataTarget[i]['avrMountCv'] = Math.round((st + igv) * 100 ) / 100;
				break;
			case 'STFR':
				dataTarget[i]['avrMountCv'] = st = Math.round(( st  * parseFloat(dataTarget[i]['iprItemGeneralPrcnt'])) * 100) / 100;
				break;
		}

		dataTarget[i]['avrPercentCv'] = Math.round((parseFloat(dataTarget[i]['avrMountCv']) / parseFloat(dataTarget[i]['iprItemGeneralMount'])) * 10000) / 100;

		var pavrMountCa = parseFloat(dataTarget[i]['pavrMountCa']);
		
		if(isNaN(pavrMountCa))
			pavrMountCa = 0;

		dataTarget[i]['avrMountCa'] = Math.round((parseFloat(dataTarget[i]['avrMountCv']) + pavrMountCa) * 100 ) / 100;
		dataTarget[i]['avrPercentCa'] = Math.round((parseFloat(dataTarget[i]['avrMountCa']) / parseFloat(dataTarget[i]['iprItemGeneralMount'])) * 10000) / 100;
		dataTarget[i]['avrMountBv'] = Math.round((parseFloat(dataTarget[i]['iprItemGeneralMount']) - parseFloat(dataTarget[i]['avrMountCa'])) * 100 ) / 100;
		dataTarget[i]['avrPercentBv'] = 100 - parseFloat(dataTarget[i]['avrPercentCa']);

		gridToUpdate.invalidateRow(i);
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
			mostrar_avance(response.pyId, response.apId, response.url); //window.location = response.url;
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

function mostrar_cronograma(py,pt,url)
{
	var pyId = py;

	if(pyId == 'NA'){
		alert('Debe seleccionar el proyecto para ver su presupuesto');
		return;
	}

	if(pt == 'NA'){
		alert('Debe seleccionar el presupuesto correspondiente para ingresar su cronograma');
		return;
	}

	$.get(url, { pyId: pyId, prId: pt}, function(data) {
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
		mostrar_cronograma(form.find('#pyId').val(),form.find('#ptId').val(),'../ver/programacion/0');
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
	rowHtml += '<td><input type="date" name="nvalPeriodi[]" class="form-control-plaintext cronoedit"></td>';
	rowHtml += '<td><input type="date" name="nvalPeriodf[]" class="form-control-plaintext cronoedit"></td>';
	rowHtml += '<td><input type="text" name="nvalMount[]" class="form-control-plaintext valMount cronoedit"></td>';
	rowHtml += '<td><input type="text" name="nvalPrcnt[]" class="form-control-plaintext valPrcnt cronoedit"></td>';
	rowHtml += '<td><input type="text" name="nvalAggrt[]" class="form-control-plaintext valAggrt cronoedit"></td>';
	rowHtml += '<td><textarea class="textarea-cell" name="nvalNote[]" rows="1" cols="10"></textarea></td>';
	rowHtml += '<td></td>'
	rowHtml += '<td><a href="javascript:void(0)" onclick="eliminar_fila(this)" class="text-danger">(-) Quitar</a></td>';
	rowHtml += '</tr>';

	table.find('tbody tr:last').after(rowHtml);
}

function agregar_fila(table)
{
	var firstRow = table.find('tbody tr:first');
	var newRow = firstRow.clone(true,true);
	var lastRow = table.find('tbody tr:last');
	lastRow.after(newRow.show());
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
			mostrar_cronograma(response.pyId, response.ptId, response.url);
		}

	});
}

function change_to_submenu(path)
{
    $.get(path, function(data){
        $('#sub-content').html(data);
    });
}

function registrar_prestacion(form)
{
	var url = form.prop('action');
	var data = form.serialize();

	$.post(url, data, function(response) {
		alert(response.msg);
		$('#mdlAddPrestacion').modal('hide');
		if(response.msgId == '200')
			mostrar_presupuesto(response.pyId, response.url);
	});
}