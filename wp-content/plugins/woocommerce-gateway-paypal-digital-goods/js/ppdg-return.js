jQuery(document).ready(function($){
	var timeoutMessage;
	timeoutMessage = window.setTimeout(function () {
		$("#message").text(ppdg.msgWaiting);
	}, 7000);
	$.ajax({
		url:  ppdg.ajaxUrl,
		data: 'action=ppdg_do_express_checkout&' + ppdg.queryString,
		success: function(response) {
			try {
				var success = $.parseJSON(response);
				$('#message').text(ppdg.msgComplete);
				if (window!=top) {
					top.location.replace(decodeURI(success.redirect));
				} else {
					window.location = decodeURI(success.redirect);
				}
			} catch(err) {
				if (response.indexOf('woocommerce_error') == -1 && response.indexOf('woocommerce_message') == -1) {
					response = '<div class=\"woocommerce_error\">' + response + '</div>';
				}
				if ($('form.checkout').length > 0) {
					$('form.checkout').prepend(response);
					$('html, body').animate({
					    scrollTop: ($('form.checkout').offset().top - 100)
					}, 1000);
				} else {
					window.clearTimeout(timeoutMessage);
					$('#message').html(response).css({
						'font-style': 'normal',
						'color': '#CC0000',
					});
					$('#message').siblings('img').hide();
				}
			}
		},
		dataType: 'html'
	});
});
