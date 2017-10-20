document.addEventListener('DOMContentLoaded', function(ev) {
	document.removeEventListener('DomContentLoaded', arguments.callees, false);
	$('.endpointBrand').click(function(){
		var name = $(this).prop('name');
		var idTemp = name.replace(/endpointBrand\[/, '');
		var id = idTemp.replace(/]/, '');

		var ext_list = '';
		var mod_list = '';

		var name = '.endpointBrand_' + id;

		if($(name).val() == 'Aastra'){
			$.each(aastra, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(aastraModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Algo'){
			$.each(algo, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(algoModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'AND'){
			$.each(and, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(andModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Audiocodes'){
			$.each(audiocodes, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(audiocodesModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Cisco'){
			$.each(cisco, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(ciscoModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Cortelco'){
			$.each(cortelco, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(cortelcoModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Cyberdata'){
			$.each(cyberdata, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(cyberdataModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Digium'){
			$.each(digium, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(digiumModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Grandstream'){
			$.each(grandstream, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(grandstreamModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Incom'){
			$.each(incom, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(incomModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Konftel'){
			$.each(konftel, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(konftelModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Mitel'){
			$.each(mitel, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(mitelModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Mocet'){
			$.each(mocet, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(mocetModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Obihai'){
			$.each(obihai, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(obihaiModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Panasonic'){
			$.each(panasonic, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(panasonicModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Phoenix'){
			$.each(phoenix, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(phoenixModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Polycom'){
			$.each(polycom, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(polycomModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Sangoma'){
			$.each(sangoma, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(sangomaModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Snom'){
			$.each(snom, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(snomModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}       
		if($(name).val() == 'Uniden'){
			$.each(uniden, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(unidenModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Vtech'){
			$.each(vtech, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(vtechModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		} 
		if($(name).val() == 'Xorcom'){
			$.each(xorcom, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(xorcomModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}
		if($(name).val() == 'Yealink'){
			$.each(yealink, function(key, value){
				ext_list = ext_list + '<option value="' + value + '">' + value + '</option>';
			});
			$.each(yealinkModels, function(key, value){
				mod_list = mod_list + '<option value="' + value + '">' + value + '</option>';
			});
		}

		$('.endpointTemplate_' + id).find('option')
																		.remove()
																		.end()
																		.append(ext_list);
		$('.endpointModel_' + id).find('option')
																 .remove()
																 .end()
																 .append(mod_list);
	});
});
function displayAdvanced(ext){
    if($("." + ext).css('display') != 'none'){
        $('.' + ext).hide();
    } else {
        $('.' + ext).show();
    }
    
}

