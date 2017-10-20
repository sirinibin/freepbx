var _interval;

function client_ctl(button, ev, reqop) {
	ev.preventDefault();
	ev.stopPropagation();
	var text = $(button).text();
	$.ajax({
		url: window.FreePBX.ajaxurl,
		data: {command: 'ClientCtl', module: 'rmsadmin', operation: reqop},
		success: function(resp) {
			if (!resp.status) {
				alert("Failed to perform operation, may be try again?");
				return;
			}
			$(button).prop('disabled', true);
			$(button).text(reqop + (' in progress ...'));
			_interval = setInterval(function() {
				$.ajax({
					url: window.FreePBX.ajaxurl,
					data: {command: 'GetClientCtlStatus', module: 'rmsadmin'},
					success: function(resp) {
						if (!resp.status) {
							clearInterval(_interval);
							location.replace(location.href);
						}
					},
					error: function(resp) {
						alert("Failed to perform operation, may be try again?");
						$(button).prop('disabled', false);
						$(button).text(text);
					}
				});
			}, 1000);
		}
	});
}

$(document).ready(function() {
	$('#stop_button').click(function(e) {
		client_ctl(this, e, "stop");
	});
	$('#start_button').click(function(e) {
		client_ctl(this, e, "start");
	});
	$('#top_start_button').click(function(e) {
		client_ctl(this, e, "start");
	});
	$('#restart_button').click(function(e) {
		client_ctl(this, e, "restart");
	});
});
