$(document).ready(function() {

        $('#extensions_allowed').sortable({
                connectWith: '.extensions',
                update: extensionroutes_fixsize,
        }).disableSelection();

        $('#extensions_blocked').sortable({
                connectWith: '.extensions',
                update: extensionroutes_fixsize,
        }).disableSelection();

	$('form').submit(function() {
		var form=$(this);
		$('#extensions_allowed>li').each(function() {
			form.append('<input type="hidden" name="extensions_allowed[]" value="'+$(this).data('extension')+'">');
		});
		$('#extensions_blocked>li').each(function() {
			form.append('<input type="hidden" name="extensions_blocked[]" value="'+$(this).data('extension')+'">');
		});
	});

	// Always runs LAST.
	$(document).delegate('.guielToggle', 'click', function() {
		extensionroutes_fixsize();
	});
});

function extensionroutes_fixsize() {
	var height = 0;
	$(".sortable").height('auto').each(function() {
		height = $(this).height() > height ? $(this).height() : height;
	}).height(height);
}
