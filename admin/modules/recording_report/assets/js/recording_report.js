var lastyear;
var lastmonth;
var lastday;
$('input').click(function() {
	var val = $(this).val();
	//determine if hidden or not and display correctly
	if ($('#year'+val).length > 0) {
		$('#year'+val).show();
	} else if ($('#month'+val).length > 0) {
		$('#month'+val).show();
	}
});

$('#checkall').click(function() {
	$('input[type=checkbox]').attr('checked', true);
});

$('#uncheckall').click(function() {
	$('input[type=checkbox]').attr('checked', false);
});
$('#gotolatest').on('click',function(e){
		e.preventDefault();
		$('#year option[value="'+lastyear+'"]').prop('selected', true);
		$('#year').trigger('change');
		$('#month').one('ajaxcomplete',function(){
			$('#month option[value="'+lastmonth+'"]').prop('selected', true);
			$('#month').trigger('change');
		});
});

$(function() {
	//bindPlayers();
	$('#greetings').on("post-body.bs.table", function () {
		bindPlayers();
	});
	$('#voicemails').on("post-body.bs.table", function () {
		bindPlayers();
	});
});
$(document).on('click','.delREC',function(e){
	e.preventDefault();
	var curRow = $(this).closest('tr');
	var year = $(this).data('year');
	var month = $(this).data('month');
	var day = $(this).data('day');
	var file = $(this).data('file');
	var url = 'config.php?display=recording_report&action=delete&year='+year+'&month='+month+'&day='+day+'&file='+file;
	$.get(url,function(){
		fpbxToast(_("File Deleted"));
		curRow.remove();
	});
});

function linkFormatter(val,row){
  var html = '<a href="config.php?display=recording_report&view=playback&year='+row['year']+'&month='+row['month']+'&day='+row['day']+'&file='+row['file']+'" target="_blank"><i class="fa fa-download"></i></a>';
  html += '&nbsp;&nbsp;<a href="#" class="delAction delREC" data-year="'+row['year']+'" data-month="'+row['month']+'" data-day="'+row['day']+'" data-file="'+row['file']+'"]><i class="fa fa-trash"></i></a>';
	return html;
}
function dateFormatter(val, row){
	return moment.unix(val).tz(timeZone).format("MM/DD/YYYY hh:mm:ss A (Z)")
}

function durationFormatter(val, row){
	return row.duration;
}
function playFormatter(val,row){
	return '<div id="jquery_jplayer_'+row.id+'" class="jp-jplayer" data-container="#jp_container_'+row.id+'" data-year="'+row.year+'" data-month="'+row.month+'" data-day="'+row.day+'" data-file="'+row.file+'"></div><div id="jp_container_'+row.id+'" data-player="jquery_jplayer_'+row.id+'" class="jp-audio-freepbx" role="application" aria-label="media player">'+
		'<div class="jp-type-single">'+
			'<div class="jp-gui jp-interface">'+
				'<div class="jp-controls">'+
					'<i class="fa fa-play jp-play"></i>'+
					'<i class="fa fa-undo jp-restart"></i>'+
				'</div>'+
				'<div class="jp-progress">'+
					'<div class="jp-seek-bar progress">'+
						'<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>'+
						'<div class="progress-bar progress-bar-striped active" style="width: 100%;"></div>'+
						'<div class="jp-play-bar progress-bar"></div>'+
						'<div class="jp-play-bar">'+
							'<div class="jp-ball"></div>'+
						'</div>'+
						'<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>'+
					'</div>'+
				'</div>'+
				'<div class="jp-volume-controls">'+
					'<i class="fa fa-volume-up jp-mute"></i>'+
					'<i class="fa fa-volume-off jp-unmute"></i>'+
				'</div>'+
			'</div>'+
			'<div class="jp-no-solution">'+
				'<span>Update Required</span>'+
				sprintf(_("You are missing support for playback in this browser. To fully support HTML5 browser playback you will need to install programs that can not be distributed with the PBX. If you'd like to install the binaries needed for these conversions click <a href='%s'>here</a>"),"http://wiki.freepbx.org/display/FOP/Installing+Media+Conversion+Libraries")+
			'</div>'+
		'</div>'+
	'</div>';
}
$(function() {
	$.get( "ajax.php?module=recording_report&command=getyears", function( data ) {
		var i = 0;
		for(var key in data){

			$('#year').append($('<option>',{
				value: data[key],
				text: data[key]
			})
			);
			lastyear = data[key];
			$('#year').trigger('ajaxcomplete');
			i++
		}
		if(i > 0){
			$('#gotolatest').attr('disabled',false);
		}
		});

	$('#year').on('change',function(){
	  var year = $('#year').val();
		$.get("ajax.php?module=recording_report&command=getmonths", {year:year}, function( data ) {
			for(var key in data){
				$('#month').append($('<option>',{
					value: data[key],
					text: data[key]
				})
				);
				lastmonth = data[key];
				$('#month').trigger('ajaxcomplete');

			}
		});
	  if(year.length < 0){
	    $('#month').addClass('hidden');
	    $('#month option:gt(0)').remove();
	  }else{
	    $('#month option:gt(0)').remove();
	    $("#month").removeClass('hidden');
	  }
	});
	$('#month').on('change',function(){
	  var year = $('#year').val();
	  var month = $('#month').val();
		$('#day option:gt(0)').remove();
		$.get("ajax.php?module=recording_report&command=getdays", {year:year,month:month}, function( data ) {
			for(var key in data){
				$('#day').append($('<option>',{
					value: data[key],
					text: data[key]
				})
				);
				lastday = data[key];
				$('#day').trigger('ajaxcomplete');
			}
		});
	  if(month == ''){
	    $('#day').addClass('hidden');
	    $('#day option:gt(0)').remove();
	  }else{
	    //$('#day option:gt(0)').remove();
	    $("#day").removeClass('hidden');
			$('#recordtable').bootstrapTable('refresh',{url: 'ajax.php?module=recording_report&command=listfiles&year='+year+'&month='+month});
	  }
	});

	$('#day').on('change',function(){
	  var year = $('#year').val();
	  var month = $('#month').val();
	  var day = $('#day').val();

		$('#recordtable').bootstrapTable('refresh',{url: 'ajax.php?module=recording_report&command=listfiles&year='+year+'&month='+month+'&day='+day});
	});

		$('#recordtable').on("post-body.bs.table", function () {
			bindPlayers();
		});
});
function bindPlayers() {
	$(".jp-jplayer").each(function() {
		var container = $(this).data("container"),
				player = $(this),
				file = $(this).data("file"),
				year = $(this).data("year"),
				month = $(this).data("month"),
				day = $(this).data("day");
		$(this).jPlayer({
			ready: function() {
				$(container + " .jp-play").click(function() {
					if(!player.data("jPlayer").status.srcSet) {
						$(container).addClass("jp-state-loading");
						$.ajax({
							type: 'POST',
							url: "ajax.php",
							data: {module: "recording_report", command: "gethtml5", file: file, year: year, month: month, day: day},
							dataType: 'json',
							timeout: 30000,
							success: function(data) {
								if(data.status) {
									player.on($.jPlayer.event.error, function(event) {
										$(container).removeClass("jp-state-loading");
										console.log(event);
									});
									player.one($.jPlayer.event.canplay, function(event) {
										$(container).removeClass("jp-state-loading");
										player.jPlayer("play");
									});
									player.jPlayer( "setMedia", data.files);
								} else {
									alert(data.message);
									$(container).removeClass("jp-state-loading");
								}
							}
						});
					}
				});
				var $this = this;
				$(container).find(".jp-restart").click(function() {
					if($($this).data("jPlayer").status.paused) {
						$($this).jPlayer("pause",0);
					} else {
						$($this).jPlayer("play",0);
					}
				});
			},
			timeupdate: function(event) {
				$(container).find(".jp-ball").css("left",event.jPlayer.status.currentPercentAbsolute + "%");
			},
			ended: function(event) {
				$(container).find(".jp-ball").css("left","0%");
			},
			swfPath: "/js",
			supplied: supportedHTML5,
			cssSelectorAncestor: container,
			wmode: "window",
			useStateClassSkin: true,
			autoBlur: false,
			keyEnabled: true,
			remainingDuration: true,
			toggleDuration: true
		});
		$(this).on($.jPlayer.event.play, function(event) {
			$(this).jPlayer("pauseOthers");
		});
	});

	var acontainer = null;
	$('.jp-play-bar').mousedown(function (e) {
		acontainer = $(this).parents(".jp-audio-freepbx");
		updatebar(e.pageX);
	});
	$(document).mouseup(function (e) {
		if (acontainer) {
			updatebar(e.pageX);
			acontainer = null;
		}
	});
	$(document).mousemove(function (e) {
		if (acontainer) {
			updatebar(e.pageX);
		}
	});

	//update Progress Bar control
	var updatebar = function (x) {
		var player = $("#" + acontainer.data("player")),
				progress = acontainer.find('.jp-progress'),
				maxduration = player.data("jPlayer").status.duration,
				position = x - progress.offset().left,
				percentage = 100 * position / progress.width();

		//Check within range
		if (percentage > 100) {
			percentage = 100;
		}
		if (percentage < 0) {
			percentage = 0;
		}

		player.jPlayer("playHead", percentage);

		//Update progress bar and video currenttime
		acontainer.find('.jp-ball').css('left', percentage+'%');
		acontainer.find('.jp-play-bar').css('width', percentage + '%');
		player.jPlayer.currentTime = maxduration * percentage / 100;
	};
}
