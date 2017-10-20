$(document).ready(function() {
	// Has an update happened?
	window.updated = false;

	// Get status when our modal is shown..
	$("#updatemodal").on("show.bs.modal", function() { get_status(); });

	// When the modal is closed, reload the page if stuff has happened.
	$("#updatemodal").on("hide.bs.modal", function() { if (window.updated) { window.location.href = window.location.href; } });

	// An upgrade button was clicked
	$("button.upgrade").click(function(e) {
		var v = $(e.target).data('version');
		console.log("Asked to upgrade to version "+v);
		do_upgrade(v);
	});

	// Show old updates
	$("#showold").click(function() {
		// Hide the alert and show the older ones
		$("#older").slideUp();
		$("#olderupdates").slideDown();
	});

	// Someone clicked on an 'Update' button
	$("#warningmodal").on("show.bs.modal", function(e) { 
		var rel = $(e.relatedTarget);
		$("#doupdate").data("version", rel.data("version"));
	});

	// Actually trigger the update!
	$("#doupdate").click(function() {
		do_upgrade($("#doupdate").data("version"));
	});

});

function get_status() {
	$.ajax({
		url: window.ajaxurl,
		data: { module: 'sysadmin', command: 'getupdatestatus' },
		success: function(msg) {
			// Only refresh if the modal is still visible
			if ($(".modal-body:visible", "#updatemodal").length) {
				window.reloadlog = window.setTimeout(function() { get_status() }, 1000);
			}
			if (msg.islocked) {
				window.updated = true;
				var h = '<p><strong>Update currently in progress! Please wait until complete.</strong></p><ul>';
			} else {
				var h = '<p>No update currently running. You may close this window.</p><ul>';
			}
			$.each(msg.data, function(i, x) {
				h += "<li>"+x+"</li>";
			});
			h += "</ul>";
			$(".modal-body", "#updatemodal").html(h);
		},
	});
}


function do_upgrade(v) {
	$.ajax({
		url: window.ajaxurl,
		data: { module: 'sysadmin', command: 'doupgrade', version: v },
		success: function(msg, status){ $("#warningmodal").modal('hide'); $("#updatemodal").modal(); },
	});
}
