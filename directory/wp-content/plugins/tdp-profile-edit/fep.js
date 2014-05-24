
if($ == undefined){
	$ = jQuery;
}

jQuery(document).ready(function(){

	jQuery('#pass1').simplePassMeter({
	  'showOnValue': true,
	  'Container': '#pass-strength-result'
	});
	
	jQuery('#pass-strength-result').hide();
	
});