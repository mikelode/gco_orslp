function goto_menu(path)
{
	$.get(path, function(data) {
		$('#content').html(data);
	});
}