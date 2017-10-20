$(function() {
    $( "#slot1" ).sortable({
        connectWith: '.firm',
        create: function(event, ui) {
            if($(this).children().length >= 1) {
                $(this).children().addClass('filled');
                $(this).addClass('dontDrop');
            }else {
                $(this).children().removeClass('filled');
            }
        },

        receive: function(event,ui) {
            if($(this).children().length >= 2) {
                $(ui.sender).sortable("cancel");
                $(this).children().addClass('filled');
                $(this).addClass('dontDrop');
            }else {
                $(this).children().removeClass('filled');
                $(this).removeClass('dontDrop');
            }
            update: endpoint_save_firmware_slot1()
        },
        remove: function(ui){
            if($(this).children().length >=0){
                $(this).children().removeClass('filled');
                $(this).removeClass('dontDrop');
            }
	    $('#slot1TA').html('');
            update: endpoint_save_firmware_slot1()
        }

    }).disableSelection();
    $( "#slot2" ).sortable({
        connectWith: '.firm',
        create: function(event, ui) {
            if($(this).children().length > 1) {
                $(this).children().addClass('filled');
                $(this).addClass('dontDrop');
            }else {
                $(this).children().removeClass('filled');
            }
        },
        receive: function(event,ui) {
            if($(this).children().length >= 2) {
                $(ui.sender).sortable("cancel");
                $(this).children().addClass('filled');
                $(this).addClass('dontDrop');
            }else {
                $(this).children().removeClass('filled');
            }
            update: endpoint_save_firmware_slot2()
        },
        remove: function(ui){
            if($(this).children().length >=0){
                $(this).children().removeClass('filled');
                $(this).removeClass('dontDrop');
            }
	    $('#slot2TA').html('');
            update: endpoint_save_firmware_slot2()
        }
    }).disableSelection();

    $('#available').sortable({
        connectWith: '.firm',
        remove: function(ui){
            if($(this).children().length >=0){
                $(this).children().removeClass('filled');
            }
        }
    }).disableSelection();
});


function endpoint_save_firmware_slot1() {
        $('form#firmware input[name^=available]').remove();
        // remove empty
	$('form#firmware input[name^=slot1]').remove();
        $('form#firmware ul#slot1 li').each(function(){
                field           = document.createElement('input');
                field.name      = 'slot1';
                field.type      = 'hidden';
		result = $(this).text();
		field.value = result;
	       	$('form#firmware').append(field);
                $('#slot1TA').html(firmDesc[result]);
        })

}
function endpoint_save_firmware_slot2() {
	$('form#firmware input[name^=available]').remove();
        // remove empty
	$('form#firmware input[name^=slot2]').remove();
        $('form#firmware ul#slot2 li').each(function(){
                field           = document.createElement('input');
                field.name      = 'slot2';
                field.type      = 'hidden';
		result = $(this).text();
		field.value = result;
                $('form#firmware').append(field);
                $('#slot2TA').html(firmDesc[result]);
        })
}
