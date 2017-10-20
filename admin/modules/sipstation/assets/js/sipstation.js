$(function() {
	function getCookie(name) {
		var cookie;
		try {
			cookie = $.cookie(name);
		} catch (e) {
			cookie = Cookies.get(name);
		}

		return cookie;
	}
	function setCookie(name, data) {
		try {
			$.cookie(name, data);
		} catch (e) {
			Cookies.set(name, data);
		}
	}

	sipstationCookie = getCookie('sipstation');
	sipstationToggle = sipstationCookie !== undefined ? $.parseJSON(sipstationCookie) : {};
	if(!$.isEmptyObject(sipstationToggle)) {
		$.each(sipstationToggle, function( section, state ) {
			if(!state) {
				$('.'+section).hide()
				$(this).removeClass('toggle-minus').addClass('toggle-plus');
			}
		});
	}

	//The lowestElement option is the most reliable way of determining the page height.
	//However, it does have a performance impact in older versions of IE.
	//In one screen refresh (16ms) Chrome 34 can calculate the position of around 10,000 html nodes, whereas IE 8 can calculate approximately 50.
	//It is recommend to fallback to max or grow in IE10 and below.
	if (navigator.userAgent.indexOf('MSIE') !== -1 || navigator.appVersion.indexOf('Trident/') > 0) {
		iFrameResize({
			log                     : false,                  // Enable console logging
			heightCalculationMethod : 'max'
		});
	} else {
		iFrameResize({
			log                     : false,                  // Enable console logging
			heightCalculationMethod : 'lowestElement'
		});
	}

});

function getextinfo(ext,did) {
	var dat = {};
	dat.type = "getextinfo";
	dat.ext = ext;
	$.post("config.php?module=sipstation&quietmode=1&file=ajax.html.php&handler=file&restrictmods=core/dashboard&skip_astman=0", dat,
		function(data){
			if(data.status) {
				if(data.outboundcid != '') {
					if($("#setcid-"+did+" option[value='"+data.outboundcid+"']").length > 0) {
						$('#setcid-'+did).val(data.outboundcid);
					} else {
						$('#setcid-'+did).val('unchanged');
					}
				} else {
					$('#setcid-'+did).val('none');
				}

				if(data.emergency_cid != '') {
					if($("#selectecid-"+did+" option[value='"+data.emergency_cid+"']").length > 0) {
						$('#selectecid-'+did).val(data.emergency_cid);
					} else {
						$('#selectecid-'+did).val('unchanged');
					}
				} else {
					$('#selectecid-'+did).val('none');
				}
			}
		},
	"json");
}

$(document).on('click', '.sstrialtab', function(e) {
	$('#free_trial_dialog').remove();
	var body = $("#ssfreetrial");
	$.post("config.php?module=sipstation&quietmode=1&file=ajax.html.php&handler=file&restrictmods=core/dashboard&skip_astman=0",
		{
			type: "freetrial",
			session: (typeof(ssSession) === "object") ? ssSession.get() : ""
		},
		function(data){
			if(data.status) {
				body.html(data.status_message);
			}
		},
	"json");
});


$('.sipstation-section').click(function() {
	var section = $(this).attr('id');
	if($('.'+section).is(":visible")) {
		$('.'+section).hide()
		$(this).removeClass('toggle-minus').addClass('toggle-plus');
		//set cookie of hidden section
		sipstationToggle = $.parseJSON(getCookie('sipstationToggle')) || {};
		sipstationToggle[section] = false;
		setCookie('sipstationToggle', JSON.stringify(sipstationToggle));
	} else {
		$('.'+section).show()
		$(this).removeClass('toggle-plus').addClass('toggle-minus');
		//set cookie of hidden section
		sipstationToggle = $.parseJSON(getCookie('sipstationToggle')) || {};
		if (sipstationToggle.hasOwnProperty(section)){
			sipstationToggle[section] = true;
			setCookie('sipstationToggle', JSON.stringify(sipstationToggle));
		}
	}
});

$('#cancel_freetrial').click(function() {
	var cancel = confirm("Are you sure you want to cancel your Free Trial Account?");
	if (cancel !== true) {
		return false;
	}
	return true;
});

//refresh the page on a successful apply changes
$(document).on( "fpbx_reload", function( event, data ) {
	if (data.complete && typeof(data.errors.data) === "object" && !data.errors.data.status) {
		location.href = "config.php?display=sipstation"
	}
});

$("#ssdids").on("post-body.bs.table", function () {
	bind_did_table();
	bind_dests_double_selects();
});
function updateE911(did,name,address1,address2,city,state,zip,master,_callback){
	$.getJSON( "ajax.php", {module:'sipstation',name:name,did:did,address1:address1,address2:address2,city:city,state:state,zip:zip,master,command:'updateE911'}, function( data ) {
		_callback(data);
	});
}
function updateCID(did,cid,ecid,_callback){
	$.getJSON( "ajax.php", {module:'sipstation',did:did,cid:cid,ecid:ecid,command:'updateCID'}, function( data ) {
		_callback(data);
	});
}
function updateFailover(did,dest,num,_callback){
	$.getJSON( "ajax.php", {module:'sipstation',did:did,dest:dest,num:num,command:'updateFailover'}, function( data ) {
		_callback(data);
	});
}
function updateDest(did,dest,_callback){
	$.getJSON( "ajax.php", {module:'sipstation',did:did,dest:dest,command:'updateDest'}, function( data ) {
		_callback(data);
	});
}
function clearFailover(_callback){
	$.getJSON( "ajax.php", {module:'sipstation',command:'clearFailover'}, function( data ) {
		_callback(data);
	});
}

$(document).ready(function(){
	if (typeof Sipstation !== "undefined" && typeof Sipstation.trunk_groups !== "undefined" ) {
    $('.trunkgroup').removeClass('hidden');
	}
});
