$(document).ready(function() {
    $("#edit").dialog({  //create dialog, but keep it closed
        autoOpen: false,
        height: 600,
        width: 800,
        modal: true
    });

    $('.edit').click(function(e) {
			e.preventDefault();

			$.get(endpointBaseAjaxUrl + '&command=basefileEdit&template=' + $(this).attr('data.template') + '&model=' + $(this).attr('data.model') + '&brand=' + $(this).attr('data.brand') + '&oid=' + $(this).attr('data.oid') + '&id=' + $(this).attr('data.id'), function(data) {
				page = data['message'];
				var $dialog = $('#edit')
						 .html(page)
						 .dialog({
							 autoOpen: false,
							 modal: true,
							 height: 600,
							 width: 800,
							 title: ""
						 });
					$dialog.dialog('open');
					return false;
			});
		});

	//for save/rebuild/restart/reboot
	$(".saveBasefile").click(function(event) {
		event.preventDefault();
		event.stopPropagation();

		var e = document.getElementById("taskBasefile");
		var task = e.options[e.selectedIndex].value;
		var data = $('.basefileInfo').serialize();

		data = (task == "rebuild") ? data + "&rebuild=1":data;
		data = (task == "restart") ? data + "&rebuild=1&restart=1":data;
		data = (task == "reset") ? data + "&reset=1":data;

		$.post( endpointBaseAjaxUrl + "&quietmode=1&command=savebasefile", data, function( data ) {
			if (data.status) {
				location = location.href;
				return true;
			} else {
				location = location.href;
				return false;
			}
		});
	});
	
});
