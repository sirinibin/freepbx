var ZuluC = UCPMC.extend({
	init: function(){
    var self = this;
    self.thistable = null;
	},
	display: function(event) {
    var os = navigator.platform;
    var isFirefox = typeof InstallTrigger !== 'undefined';
    var isChrome = !!window.chrome && !!window.chrome.webstore;
    var title = '';
    var url = '';
    switch (os) {
      case 'MacIntel':
          title = _("Mac App (Intel)");
          url = macurl;
      break;
      case 'Linux i686':
         title = _("Linux App (Coming Soon)");
         url = linuxurl;
      break;
      case 'Win64':
        title = _("Windows App (x86_64)");
        url = winurl;
      break;
      default:
        title = _("Sorry we don't appear to have an app for your platform");
        url = salesurl;
      break;
    }
    $("#dlbutton").html('<a href="'+url+'" class="btn btn-default btn-block" target="_blank">'+title+'</a>');
    if(isChrome){
      $("#pluginbutton").html('<a href="'+chromeurl+'" class="btn btn-default btn-block" target="_blank">'+_("Chrome Plugin")+'</a>');
    }
    if(isFirefox){
      $("#pluginbutton").html('<a href="'+ffurl+'" class="btn btn-default btn-block" target="_blank">'+_("Firefox Plugin")+'</a>');
    }
  }
});
