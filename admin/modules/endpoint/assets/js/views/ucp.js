$(document).ready(function() {
	$("a.info").each(function() {
		$(this).after("<span class=\"help\"><i class=\"fa fa-question-circle\"></i><span>" + $(this).find("span").html() + "</span></span>");
		$(this).find("span").remove();
		$(this).replaceWith($(this).html());
	});

	$(document).on("mouseenter", '.help', function() {
		side = "left";
		if(typeof fpbx != 'undefined'){
			side = fpbx.conf.text_dir == "lrt" ? "left" : "right";
		}
		var pos = $(this).offset(), offset = (200 - pos.side) + "px";
		//left = left > 0 ? left : 0;
		$(this).find("span").css(side, offset).stop(true, true).delay(500).animate({ opacity: "show" }, 750);
	}).on("mouseleave", '.help', function(){
		$(this).find("span").stop(true, true).animate({opacity: "hide"}, "fast");
	});
});
