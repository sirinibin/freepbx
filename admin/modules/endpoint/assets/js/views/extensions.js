$(document).ready(function() {
	$('#dialog-form').hide();
	$(document).on('change', '.ext', function(){
		if($(this).val() == 'Custom'){
			$( "#dialog-form" ).dialog({
				autoOpen: false,
				height: 300,
				width: 350,
				modal: true
			});
			$( "#dialog-form" ).dialog( "open" );
			$('#record').html('<input type="hidden" size="20" name="cRecord" id="cRecord" value="' + $(this).attr('id') + '" />');
		}

		getVpnClients($(this).val());
	});
	$('#send-button').click(function(){
		// validate
		$('.error').hide();
		var cExt = $("input#cExt").val();
		if (cExt == ""){
			$("label#cExt_error").show();
			$("input#cExt").focus();
			return false;
		}
		var cSecret = $("input#cSecret").val();
		if (cSecret == ""){
			$("label#cSecret_error").show();
			$("input#cSecret").focus();
			return false;
		}
		var cLabel = $("input#cLabel").val();
		var record = $("input#cRecord").val();
		var cDestination = $("input#cDestination").val();
		var cSipPort = $("input#cSipPort").val();

		var dataString = 'display=endpoint&view=save_custom&cExt=' + cExt + '&cSecret=' + cSecret + '&cLabel=' + cLabel + '&cDestination=' + cDestination + '&cSipPort=' + cSipPort;
		$.ajax({
			type: "POST",
			url: "config.php",
			data: dataString,
			success: function(data) {
				$('#dialog-form').html("<div id='message'></div>");
				$('#message').html("<h2>Extension Added.</h2>")
				var select = document.getElementById(record);
				select.options[select.options.length] = new Option(cExt + ' ' + cLabel, cExt + ' ' + cLabel, '', '1');
				$('#dialog-form').dialog('close');
			}
		});
		return false;

	});

	$(document).on('change', '.content select', function() {
        var name = $(this).attr('name');
        chk = name.split('[');
        exist = chk[0].split('_');
        exist = exist[1];
        chk = chk[1].split(']');
        chk = chk[0];
        if(exist == 'exist'){
            $("input[name='select_exist[" + chk +"]']").attr('checked', true);
        }
        name = name.substring(5,name.length);
        var ext_list = '';
        var mod_list = '';
        if($(this).val() == 'Aastra'){
            $.each(aastra, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(aastraModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
		if($(this).val() == 'Algo'){
            $.each(algo, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(algoModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
		if($(this).val() == 'AND'){
            $.each(and, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(andModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
		if($(this).val() == 'And'){
            $.each(and, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(andModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
		if($(this).val() == 'Audiocodes'){
            $.each(audiocodes, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(audiocodesModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
        if($(this).val() == 'Cisco'){
            $.each(cisco, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(ciscoModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
        if($(this).val() == 'Cortelco'){
            $.each(cortelco, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(cortelcoModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
        if($(this).val() == 'Cyberdata'){
            $.each(cyberdata, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(cyberdataModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
        if($(this).val() == 'Digium'){
            $.each(digium, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(digiumModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
        if($(this).val() == 'Grandstream'){
            $.each(grandstream, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(grandstreamModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
		if($(this).val() == 'Htek'){
            $.each(htek, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(htekModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
		if($(this).val() == 'Incom'){
            $.each(incom, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(incomModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
		if($(this).val() == 'Konftel'){
            $.each(konftel, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(konftelModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
        if($(this).val() == 'Mitel'){
            $.each(mitel, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(mitelModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
        if($(this).val() == 'Mocet'){
            $.each(mocet, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(mocetModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
        if($(this).val() == 'Obihai'){
            $.each(obihai, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(obihaiModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
        if($(this).val() == 'Panasonic'){
            $.each(panasonic, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(panasonicModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
        if($(this).val() == 'Phoenix'){
            $.each(phoenix, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(phoenixModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
        if($(this).val() == 'Polycom'){
            $.each(polycom, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(polycomModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
        if($(this).val() == 'Sangoma'){
            $.each(sangoma, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(sangomaModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
        if($(this).val() == 'Snom'){
            $.each(snom, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(snomModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
        if($(this).val() == 'Uniden'){
            $.each(uniden, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(unidenModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
        if($(this).val() == 'Vtech'){
            $.each(vtech, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(vtechModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
        if($(this).val() == 'Xorcom'){
            $.each(xorcom, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(xorcomModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }
        if($(this).val() == 'Yealink'){
            $.each(yealink, function(key, value){
                ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
            });
            $.each(yealinkModels, function(key, value){
                mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
            });
        }

        $("[name='template" + name+"']").find('option')
                                        .remove()
                                        .end()
                                        .append(ext_list);
        $("[name='brand_model" + name+"']").find('option')
                                     .remove()
                                     .end()
                                     .append(mod_list);

    });

	$(document).on('click', '.all', function(event) {
		if ($(event.target).is(":checkbox")) {
			return true;
		}
		var checkbox = $(this).find("input[type=checkbox]");
		checkbox.prop("checked", !checkbox[0].checked);
		return false;
	});

	//make cell checkable for select box
    $('#check_All').click(function(){
        $('.select').trigger('click');
    });

	$(document).on('click', '#use_selected', function(event) {
		var formId = $(this).data('form');
		var form = $('form');

		if (formId !== 'undefined') {
			form = $('form#'+formId);
		}

		$.ajax({
        	    type: "POST",
        	    url: window.location.href,
        	    data: form.serialize(),
       		    success: function(data) {
                	window.location.reload(true);
            	    }
        	});
        	return false;
    	});

	$(document).on('click', '.editExt', function(e) {
		$.get(endpointBaseAjaxUrl + '&command=extEdit&vals=' + $(this).attr('data.vals'), function(data) {
			var page = data.message;

			$("#editExt").html("");
			$("#editExt").append(page);
			
			var $dialog = $('#editExt').dialog({
				autoOpen: false,
				modal: true,
				height: 700,
				width: 750,
				title: "Edit Extension"
			});
			$dialog.dialog('open');

			getVpnClients($('.ext').val());
			return false;
		});
	});

	$(document).on('click', '.rebootSangoma', function(e) {
		e.preventDefault();
		$.get(endpointBaseAjaxUrl + '&command=rebootSangoma&ext=' + $(this).attr('data.ext'), function(data) {
			var page = data.message;
			return false;
		});
	});
	$(document).on('click', '.syncSangoma', function(e) {
		e.preventDefault();
	    $.get(endpointBaseAjaxUrl + '&command=syncSangoma&ext=' + $(this).attr('data.ext'), function(data) {
			var page = data.message;
			return false;
		});
	});
});

var newCount = 1;

function addExtension(ext, brands, aastra, algo, and, audiocodes, cisco, cortelco, cyberdata, digium, grandstream, htek, incom, konftel, mitel, mocet, obihai, panasonic, phoenix, polycom, sangoma, snom, uniden, vtech, xorcom, yealink) {
    $('#epbulk').removeClass('hidden');
    var trCount = $('tr').length;
    var clonedRow = $("tr:last");
    var extensions = $('table#extensions').html();

    var ext_list = '<tr><td><input type="checkbox" name="select[' + newCount + ']" checked></td><td><select name="ext[' + newCount + ']" id="ext[' + newCount + ']" class="ext" >';
    $.each(ext, function(key, value) {
	    ext_list = ext_list + '<option value="' + key + '">' + key + ' ' + value + '</option>';
    });

    ext_list = ext_list + '</select>';
    ext_list = ext_list + '<br /><select name="acct[' + newCount + ']" id="acct[' + newCount + ']" class="acct" >';
    ext_list = ext_list + '<option value="">Select Account</option>';
    for (i = 1; i <= 8; i++) {
        ext_list = ext_list + '<option value="account' + i + '">Account ' + i + '</option>';
    }
    ext_list = ext_list + '</select>';

    ext_list = ext_list + '</td><td><select name="brand[' + newCount + ']" id="brand_' + newCount + '" ><option>Select Brand</option>';
    $.each(brands, function(key, value){
        ext_list = ext_list + '<option value="' + key + '">' + value + '</option>';
    });
    ext_list = ext_list + '</select><br /><input name="mac[' + newCount + ']" id="mac_' + newCount + '" value="" size="15" placeholder="MAC Address"></td><td><select name="template[' + newCount + ']" id="template_' + newCount + '"><option value="0"> Select Template</option></select><br /><select name="brand_model[' + newCount + ']" id="brand_model_' + newCount + '"><option value="0"> Select Model</option></select></td><td></td><td></td>';

    $("table#extensions").append(ext_list);

    newCount += 1;
}

function displayImport(){
    $('#extensions').hide();
    $('#import').show();
}

function displayAdvanced(ext){
    $('.' + ext).toggle();
}
function styleRow(row, idx){
  color = row._data.color;
  var retclass = 'success';
  if(color == '#C69C6D;'){
    retclass = 'warning';
  }
  return {'classes':retclass};

}
$(document).on('change', 'input[name^="btSelect"]', function(){
  if($("input[name='btSelectItem']:checked").length > 0){
    $('#epbulk').removeClass('hidden');
    var html = '';
    $("input[name='btSelectItem']:checked").each(function(){
      var ext = $(this).closest('tr').data('ext');
      html += '<input type="hidden" name="select_exist['+ext+']" value="on">';
    });
    $("#select_exist").html(html);
  }else{
    $('#epbulk').addClass('hidden');
    $("#select_exist").html('');

  }
});

function getVpnClients(extension) {

	clientlist = $('.vpnclient');

	clientlist.empty();

	$.ajax({
		url: "/admin/ajax.php",
		data: {
			module: 'endpoint',
			command: 'getVpnClients',
			extension: extension,
		},
		type: "GET",
		dataType: "json",
 		success: function(data) {
			clients = JSON.parse(data.message);
			console.log(clients);
			$.each(clients, function(id, client) {
				clientlist.append('<option value="' + client['key'] + '"' + (client['key'] == data.selected ? " selected" : "") + '>' + client["description"] + '</option>');
			});
		}
	});

	clientlist.append('<option value="">None</option>');

	return false;
}
