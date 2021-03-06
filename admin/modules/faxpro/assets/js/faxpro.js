$(document).ready(function(){
	//ensure form can handle file uploads
	$('#edit').attr('enctype', 'multipart/form-data');
	$("#coverpage_preview").click(function(e) {
		var tmp = $("#coverpage_preview").text();
		$("#coverpage_preview").text(_("Generating..."));
		$("#coverpage_preview").prop("disabled",true);
		$("#edit").ajaxSubmit({success: function(responseText, statusText, xhr, $form){
			$("#coverpage_preview").text(tmp);
			$('#coversheetpreview').modal('show');
			$("#coverpage_preview").prop("disabled",false);
		}});
		e.preventDefault();
	});
	$('#coversheetpreview').on('show.bs.modal', function () {
		$('#coversheetpreview .modal-body').css('overflow-y', 'auto');
		$('#coversheetpreview .modal-body').css('height', $(window).height() * 0.65);
	});
});

//jQuery Input Limiter plugin 1.1.1 by http://rustyjeans.com/jquery-plugins/input-limiter/
(function($){$.fn.inputlimiter=function(options){var opts=$.extend({},$.fn.inputlimiter.defaults,options);if(opts.boxAttach&&!$('#'+opts.boxId).length){$('<div/>').appendTo("body").attr({id: opts.boxId,'class': opts.boxClass}).css({'position': 'absolute'}).hide();if($.fn.bgiframe)$('#'+opts.boxId).bgiframe();}$(this).each(function(i){$(this).keyup(function(e){if($(this).val().length>opts.limit)$(this).val($(this).val().substring(0,opts.limit));if(opts.boxAttach){$('#'+opts.boxId).css({'width': $(this).outerWidth()-($('#'+opts.boxId).outerWidth()-$('#'+opts.boxId).width())+'px','left': $(this).offset().left+'px','top':($(this).offset().top+$(this).outerHeight())-1+'px','z-index': 2000});}var charsRemaining=opts.limit-$(this).val().length;var remText=opts.remTextFilter(opts,charsRemaining);var limitText=opts.limitTextFilter(opts);if(opts.limitTextShow){$('#'+opts.boxId).html(remText+' '+limitText);var textWidth=$("<span/>").appendTo("body").attr({id: '19cc9195583bfae1fad88e19d443be7a','class': opts.boxClass}).html(remText+' '+limitText).innerWidth();$("#19cc9195583bfae1fad88e19d443be7a").remove();if(textWidth>$('#'+opts.boxId).innerWidth()){$('#'+opts.boxId).html(remText+'<br/>'+limitText);}$('#'+opts.boxId).show();}else $('#'+opts.boxId).html(remText).show();});$(this).keypress(function(e){if((!e.keyCode||(e.keyCode>46&&e.keyCode<90))&&$(this).val().length>=opts.limit)return false;});$(this).blur(function(){if(opts.boxAttach){$('#'+opts.boxId).fadeOut('fast');}else if(opts.remTextHideOnBlur){var limitText=opts.limitText;limitText=limitText.replace(/\%n/g,opts.limit);limitText=limitText.replace(/\%s/g,(opts.limit==1?'':'s'));$('#'+opts.boxId).html(limitText);}});});};$.fn.inputlimiter.remtextfilter=function(opts,charsRemaining){var remText=opts.remText;remText=remText.replace(/\%n/g,charsRemaining);remText=remText.replace(/\%s/g,(charsRemaining==1?'':'s'));return remText;};$.fn.inputlimiter.limittextfilter=function(opts){var limitText=opts.limitText;limitText=limitText.replace(/\%n/g,opts.limit);limitText=limitText.replace(/\%s/g,(opts.limit==1?'':'s'));return limitText;};$.fn.inputlimiter.defaults={limit: 255,boxAttach: true,boxId: 'limiterBox',boxClass: 'limiterBox',remText: '%n character%s remaining.',remTextFilter: $.fn.inputlimiter.remtextfilter,remTextHideOnBlur: true,limitTextShow: true,limitText: 'Field limited to%n character%s.',limitTextFilter: $.fn.inputlimiter.limittextfilter};})(jQuery);
