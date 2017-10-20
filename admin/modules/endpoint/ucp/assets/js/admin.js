/*
$(document).ready(function() {
	//for admin view on extension mapping
	$(".saveAdmin").click(function(event) {
		event.preventDefault();
		event.stopPropagation();

		var e = document.getElementById("taskAdmin");
		var task = e.options[e.selectedIndex].value;
		var data = $('.saveAdminForm').serialize();

		//save not needed, because we always save, option is just for looks
		data = (task == "rebuild") ? data + "&rebuild=1":data;
		data = (task == "restart") ? data + "&rebuild=1&restart=1":data;
		data = (task == "reset") ? data + "&reset=1":data;

		$.post( endpointBaseAjaxUrl + "&quietmode=1&command=savesettings", data, function( data ) {
			if (data.status) {
				location.reload(true);
				return true;
			} else {
				location.reload(true);
				return false;
			}
		});
	});

	//uncheck all boxes for keytypes
	$(document).on('change', '.keyType', function() {
		var box = $(this).attr('name');
		$('.keyType').prop("checked", false);
		$('#' + box).prop("checked", true);
	});
	//uncheck all boxes for horizontal states
	$(document).on('change', '.hkeyType', function() {
		var box = $(this).attr('name');
		$('.hkeyType').prop("checked", false);
		$('#' + box).prop("checked", true);
	});

	//show/hide boxes for horizontal states
	$(document).on('change', '.hkeyType', function() {
		var box = $(this).attr('name');
		$('.hideHorSoftKeys').hide();
		$('.' + box).show();
	});

	//show/hide boxes for algo 8128 mode selection
	$(document).on('change', '.mode', function() {
		$('.modeNotify').hide();
		$('.modeMessage').hide();
		$('.modeRing').hide();
		var box = $(this).attr('id');
		$('.' + box).show();
		//console.log($(this).attr('id'));
	});

		$(document).on('change', '.type', function() {
		var name = $(this).prop('name');
		var length = name.length;
		name = name.substr(0, length - 4);

		if($("#" + name + 'acct').val() == ''){
			$("#" + name + 'acct').val('account1')
		} else {
			if($(this).find("option:selected").text() == 'Blank'){
				$("#" + name + 'acct').val('');
				$("#" + name + 'label').val('');
				$("#" + name + 'value').val('');
			}
		}


		switch($(this).find("option:selected").text()){
			//line keys first
			case 'Line':
				$("." + name + 'value').hide();
				$("." + name + 'valueFill').show();
				$("." + name + 'label').hide();
				$("." + name + 'labelFill').show();
				$("#" + name + 'xml').hide();
				break;

			//now xml-api
			case 'XML-API':
				$("#" + name + 'xml').show();
				$("." + name + 'value').show();
				$("#" + name + 'value').hide();
				$("." + name + 'valueFill').hide();
				$("." + name + 'label').show();
				$("." + name + 'labelFill').hide();
				break;

			//now park
			case 'Call Park':
				$("#" + name + 'park').show();
				$("#" + name + 'xml').hide();
				$("." + name + 'value').hide();
				$("#" + name + 'value').hide();
				$("." + name + 'valueFill').hide();
				$("." + name + 'label').show();
				$("." + name + 'labelFill').hide();
				break;

			case 'Voicemail':
			case 'Intercom':
			case 'DND':
			case 'Record':
				$("#" + name + 'park').hide();
				$("#" + name + 'xml').hide();
				$("." + name + 'value').hide();
				$("#" + name + 'value').hide();
				$("." + name + 'valueFill').show();
				$("#" + name + 'label').val($(this).find("option:selected").text());
				$("." + name + 'labelFill').hide();
				break;

			default:
				$("#" + name + 'xml').hide();
				$("#" + name + 'value').show();
				$("." + name + 'value').show();
				$("." + name + 'valueFill').hide();
				$("." + name + 'label').show();
				$("." + name + 'labelFill').hide();
				$("#" + name + 'park').hide();
				break;
		}
	});
	$(document).on('change', '.xmlDropDown', function() {
		var name = $(this).prop('name');
		var length = name.length;
		name = name.substr(0, length - 3);
		var txt = $(this).find("option:selected").text();
		var lTxt = txt.length;
		txt = txt.substr(5, lTxt);
		switch($(this).find("option:selected").text()){
			case 'REST-Apps':
			case 'REST-Call Flow':
			case 'REST-Call Forward':
			case 'REST-Conference':
			case 'REST-Contacts':
			case 'REST-DND':
			case 'REST-Follow Me':
			case 'REST-Login':
			case 'REST-Parking':
			case 'REST-Presence':
			case 'REST-Queues':
			case 'REST-Queue Agent':
			case 'REST-Time Conditions':
			case 'REST-Transfer VM':
			case 'REST-Voicemail':
				$("#" + name + 'label').val(txt);
				break;

			default:
				break;
		}
	});

	//for hor states
	$(document).on('change', '.horDropDown', function() {
		var name = $(this).prop('name');
		var length = name.length;
		name = name.substr(0, length - 5);
		var txt = $(this).find("option:selected").text();
		var lTxt = txt.length;
		console.log(name);
		switch($(this).find("option:selected").text()){
			case 'REST-Apps':
			case 'REST-Call Flow':
			case 'REST-Call Forward':
			case 'REST-Conference':
			case 'REST-Contacts':
			case 'REST-DND':
			case 'REST-Follow Me':
			case 'REST-Login':
			case 'REST-Parking':
			case 'REST-Presence':
			case 'REST-Queues':
			case 'REST-Queue Agent':
			case 'REST-Time Conditions':
			case 'REST-Transfer VM':
			case 'REST-Voicemail':
				txt = txt.substr(5, lTxt);
				$("#" + name + 'label').val(txt);
				break;

			default:
				$("#" + name + 'label').val(txt);
				break;
		}
	});
});
*/
