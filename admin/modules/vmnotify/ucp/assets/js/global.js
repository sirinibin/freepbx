var VmnotifyC = UCPMC.extend({
	init: function(){
	},
	settingsDisplay: function() {
    $('#module-Vmnotify textarea').change(function() {
      $(this).blur(function() {
        UCP.Modules.Vmnotify.saveSettings({key: $(this).prop('name'), value: $(this).val()});
        $(this).off('blur');
      });
    });
    $('#module-Vmnotify input[type="checkbox"]').change(function() {
      UCP.Modules.Vmnotify.saveSettings({key: $(this).prop('name'), value: $(this).is(':checked')});
    });
	},
	settingsHide: function() {
	},
  saveSettings: function(data) {
  data.ext = ext;
  $.post( "index.php?quietmode=1&module=vmnotify&command=settings", data, function( data ) {
    $('#module-Vmnotify .message').text(data.message).addClass('alert-'+data.alert).fadeIn('fast', function() {
      $(this).delay(5000).fadeOut('fast', function() {
        $('.masonry-container').packery();
      });
    });
    $('.masonry-container').packery();
  });
}
});
