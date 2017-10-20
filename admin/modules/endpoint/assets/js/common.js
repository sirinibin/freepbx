$(document).ready(function() {
	$("input[name='dest_option']").click(function() {
		if ($("input[name='dest_option']:checked").val() == 'internal') {
			$('#destination').val('__internal__');
			$('.destInternal').show();
			$('.destExternal').hide();
			$('.destCustom').hide();
		} else if ($("input[name='dest_option']:checked").val() == 'external') {
			$('#destination').val('__external__');
			$('.destInternal').hide();
			$('.destExternal').show();
			$('.destCustom').hide();
		} else if ($("input[name='dest_option']:checked").val() == 'custom') {
			$('#destination').val($('#orig_ip').val());
			$('.destInternal').hide();
			$('.destExternal').hide();
			$('.destCustom').show();
		}
	});

	$("input[name='pro_option']").click(function() {
		if ($("input[name='pro_option']:checked").val() == 'internal') {
			$('#ftpserver').val('__internalProvision__');
			$('.proInternal').show();
			$('.protocol').show();
			$('.proExternal').hide();
			$('.proCustom').hide();
		} else if ($("input[name='pro_option']:checked").val() == 'external') {
			$('#ftpserver').val('__externalProvision__');
			$('.proInternal').hide();
			$('.proExternal').show();
			$('.protocol').show();
			$('.proCustom').hide();
		} else if ($("input[name='pro_option']:checked").val() == 'custom') {
			$('#ftpserver').val($('#orig_ip').val());
			$('.proInternal').hide();
			$('.proExternal').hide();
			$('.proCustom').show();
			$('.protocol').hide();
		}
	});
  
// for hotline box
	$("input[name='hotline']").click(function() {
		if ($("input[name='hotline']:checked").val() == '1'){
			$('#hotline').show();
		} else if ($("input[name='hotline']:checked").val() == '0'){
			$('#hotline').hide();
		}
	})

// for ss image box
	$("input[name='focus']").click(function() {
		$('#ssImage').hide();
		$('#ssText').hide();
		if ($("input[name='focus']:checked").val() == '2'){
			$('#ssImage').show();
		}
		if ($("input[name='focus']:checked").val() == '0'){
			$('#ssText').show();
		}
	})

// for WIFI Settings box
	$("input[name='wEnable1']").click(function() {
		if ($("input[name='wEnable1']:checked").val() == '1'){
			$('#wifi').show();
		} else if ($("input[name='wEnable1']:checked").val() == '2'){
			$('#wifi').hide();
		}
	})

// watch for line key selection
	$(".buttonType").change(function(){
		if($(this).val() == "Line"){
			$('#' + $(this).attr('name') + 'NotLine').hide();
		} else {
			$('#' + $(this).attr('name') + 'NotLine').show();
		}
	})

	$("input[name='phonelabel_option']").click(function() {
		if ($("input[name='phonelabel_option']:checked").val() == '0') {
			$('#phoneLabel').val('');
			$('.phoneLabelCustom').hide();
		} else if ($("input[name='phonelabel_option']:checked").val() == '1') {
			$('#phoneLabel').val('__line1Name__');
			$('.phoneLabelCustom').hide();
		} else if ($("input[name='phonelabel_option']:checked").val() == '2') {
			$('#phoneLabel').val($('#orig_phonelabel_custom').val());
			$('.phoneLabelCustom').show();
		}
	});  
});
