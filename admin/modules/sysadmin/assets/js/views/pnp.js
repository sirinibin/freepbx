$('input[name="pnpconf"]').click(function(){
	console.log("clonk");
	if ($('input[name="pnpconf"]:checked').val() == 'auto') {
		console.log("slideup");
		$('#manualuridiv').slideUp();
	} else {
		console.log("slidedown");
		$('#manualuridiv').slideDown();
	}
});
