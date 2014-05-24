jQuery.log = function(message){
  var $logger = jQuery("#logger");
  jQuerylogger.html(jQuerylogger.html() + "\n * " + message );
}
