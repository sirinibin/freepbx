$(document).ready(function() {
   //used for ajax call to eliminate excessive input variables
    $('#submit').click(function(event) {
        event.preventDefault();
        var dat = JSON.stringify($('#snom').serializeArray());
        var url = $('#snom').attr('action') + '&template=' + $('#template_name').val();
        alert('Please wait until page reloads.');
        $.ajax({
			type: "POST",
			url: url,
			data: {'data': dat},
			success: function(data,textStatus,jqXHR) {
				location.href=url;
			},
			error:function(xhr, textStatus, errorThrown){
				alert('fail');
			}
        });
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
});