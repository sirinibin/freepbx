var _install_completed = false;
var _interval;
$(document).ready(function() {
	_interval = setInterval(function() {
		if (_install_completed) {
			clearInterval(_interval);
			location.replace(location.href);
		}
		$.ajax({
			url: window.FreePBX.ajaxurl,
			data: {command: 'GetInstallProgress', module: 'rmsadmin'},
			success: function(data) {
				if (typeof data.message !== "undefined") {
					if (data.message == -1) {
						// it failed, but completed, so let the backend
						// take care of displaying an error
						_install_completed = true;
					} else {
						$('#install-progress-bar').css('width', data.message + '%');
						$('#install-progress-bar').html(data.message + '%');
						if (data.message == 100) {
							_install_completed = true;
						}
					}
				}
			}
		});
	}, 1000);
});
