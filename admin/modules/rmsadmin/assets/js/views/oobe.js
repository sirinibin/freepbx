$(document).ready(function() {
	$('button.fpbx-buy').click(function(e) {
		console.log('OOBE buy button pushed!')
		ga('send', 'event', 'RMSAdmin', 'rmadmin_buy_oobe', 'OOBE buy button pressed for RMS');
	});

	$('#rmsadmin_oobe_skip').click(function(e) {
		e.preventDefault();
		e.stopPropagation();
		console.log('OOBE skip button pushed!')
		var text = $(this).text();
		$(this).prop('disabled', true);
		$(this).text(('...'));
		$.ajax({
			url: window.FreePBX.ajaxurl,
			data: {command: 'SkipOobe', module: 'rmsadmin'},
			success: function(resp) {
				if (!resp.status) {
					alert("Failed to skip oobe, try again?");
					$(this).text(text);
					$(this).prop('disabled', false);
					return;
				}
				ga('send', 'event', 'RMSAdmin', 'rmadmin_skip_oobe', 'Skipped OOBE for RMS');
				window.location.href = window.location.href.replace("#", ""); // Remove '#' if it exists
			}
		});
	});
});
