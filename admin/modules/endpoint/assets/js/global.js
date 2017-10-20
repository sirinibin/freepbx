//validation functions
function validatePass(passInfo){
  if (passInfo.field.val() === undefined) {
    return;
  }
  if (passInfo) {
    //it's NOT valid
    if (passInfo.field.val().length > 0) {
      if(passInfo.field.val().length <6){
        passInfo.field.addClass("globalError");
        passInfo.error.text(passInfo.name + " Password MUST be at least 6 characters");
        passInfo.error.addClass("globalError");
        return false;
      } else { //it's valid
        passInfo.field.removeClass("globalError");
        passInfo.error.text(" ");
        passInfo.error.removeClass("globalError");
        return true;
      }
    }
  }
}

$(document).ready(function() {
  //global vars
	var form = $("#global");
	var admin = [];
	var user = [];
	admin.field = $("#admin_password");
	admin.name = 'Admin';
	admin.error = $('#adminPass');
	user.field = $("#user_password");
	user.name = 'User';
	user.error = $('#userPass');

	//On blur
	// Define an object in the global scope (i.e. the window object)
	admin.field.blur(validatePass(admin));
	user.field.blur(validatePass(user));
	//On key press
	admin.field.keyup(validatePass(admin));
	user.field.keyup(validatePass(user));
	//On Submitting
	form.submit(function(){
		if(validatePass(admin) && validatePass(user)){
			return true;
		} else {
			return false;
		}
	});
	
	//display key types
	$(document).on('change', '.keyType', function() {
		var name = $(this).prop('name');
		var length = name.length;
		name = name.substr(8, length);
		$(".hideKeys").hide();
		$("#" + name).show();
	});

});

//Below is to handle sortable on our ajax calls.
var EndpointSortable;

EndpointSortable = void 0;

EndpointSortable = function() {
  var hidden, result;
  hidden = void 0;
  result = void 0;
  if ($("ul.sortable").length <= 0) {
    return true;
  }
  $("ul.sortable").sortable({
    update: function(event, ui) {
      var test;
      test = void 0;
      var result = [];

      //Can't use sortable('toArray') here
      $(this).find('li').each(function(i, el){
          result.push($(el).attr('id'));
      });
      
      test = result[0].split("_"[0]);
      //model_keytype_order
      hidden = test[0] + "_" + test[1] + "_order";
      
      $("input[name=" + hidden + "]").val(result);

    }
  });
};

$( document ).ajaxComplete(function() {
  EndpointSortable();
});

if(typeof fpbx == 'undefined'){
	  var endpointBaseAjaxUrl = '/admin/ajax.php?module=endpoint';
} else if ((fpbx.length > 0) && parseInt(fpbx.conf.ver) > 2.11) {
	var endpointBaseAjaxUrl = '/admin/ajax.php?module=endpoint';
} else {
	var endpointBaseAjaxUrl = '/admin/ajax.php?module=endpoint&quitemode=1&handler=file&file=ajax.php';
}



