var testdid = '';
var tested = false;
$("#regexp-test-btn").click(function() {
	var did = prompt(_("Please enter an inbound DID"), testdid);
	if (did !== null) {
		testdid = did;
		$("#regexp-test").removeClass("hidden");
		$("#regexp-test pre").html(_("Loading..."));
		$.post( "ajax.php", {module: "sangomacrm", command: "driver", subcommand: "testregexp", regexp: $("#regexp").val(), preregexp: $("#preregexp").val(), number: did}, function( data ) {
			if(data.status) {
				$("#regexp-test pre").html(data.data);
			}
		});
	} else {
		$("#regexp-test").addClass("hidden");
	}
});
$("#genkey").click(function(e) {
	e.preventDefault();
	e.stopPropagation();
	var t = $(this).text();
	$(this).text(_("Generating..."));
	$(this).prop("disabled",true);
	$.post("ajax.php",{module: "sangomacrm", command: "driver", subcommand: "gensshkeys"}, function(data) {
		if(data.status) {
			$("#pkey").val(data.public);
		} else {
			alert(data.message);
		}
		$("#genkey").text(t);
		$("#genkey").prop("disabled",false);
	});
});

$("input[name=recording_storage]").click(function() {
	if($("input[name=recording_storage]:checked").val() == "crm") {
		$(".crm-storage").removeClass("hidden");
	} else {
		$(".crm-storage").addClass("hidden");
	}
});

$("#testsshkey").click(function(e) {
	e.preventDefault();
	e.stopPropagation();
	var t = $(this).text();
	$(this).text(_("Testing..."));
	$(this).prop("disabled",true);
	$.post("ajax.php",{module: "sangomacrm", command: "driver", subcommand: "testsshkeys", username: $("#sshusername").val(), storage: $("#sshstorage").val()}, function(data) {
		if(data.status) {
			alert("Success!");
			tested = true;
		} else {
			alert(data.message);
		}
		$("#testsshkey").text(t);
		$("#testsshkey").prop("disabled",false);
	});
});

$('#url').blur(function(){
	if($('#url').length){
		var deferred = $.ajax({
  				dataType: "json",
  				url: 'ajax.php?module=sangomacrm&command=checkurl',
  				data: {url:$('#url').val()},
			});
			deferred.done(function(data){
				if(data.length === 0){
					$('#submit').prop('disabled', false);
					return true;
				}else{
					$('#submit').prop('disabled', true);
					data.forEach(
						function(mess){
							fpbxToast(mess);
						}
					);
				}
			});
		};
});

$(".fpbx-submit").submit(function() {
	if($("input[name=recording_storage]:checked").val() == "crm" && !tested) {
		alert(_("Please test the SSH connection by hitting 'Test Connection' before submitting this page"));
		$("#testsshkey").focus();
		return false;
	}
});
$( document ).ready(function() {
	if($('#url').length){
		if($('#url').val().length === 0){
			$('#submit').prop('disabled', true);
		}
	}
});
