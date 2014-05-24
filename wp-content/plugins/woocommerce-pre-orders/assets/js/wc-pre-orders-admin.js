jQuery(document).ready(function ($) {

	"use strict";

	var $actionEmailMessage = $('textarea[name=wc_pre_orders_action_email_message]');

	// get the proper datetime field (either on the edit product page or the pre-orders > actions tab
	if ($('input[name=_wc_pre_orders_availability_datetime]').length) {
		var $dateTimeField = $('input[name=_wc_pre_orders_availability_datetime]');
	} else if ($('input[name=wc_pre_orders_action_new_availability_date]').length) {
		var $dateTimeField = $('input[name=wc_pre_orders_action_new_availability_date]');
	}

	// Add Pre-Order DateTimePicker (see http://trentrichardson.com/examples/timepicker/)
	if (typeof($dateTimeField)!=='undefined') {

		$dateTimeField.datetimepicker({
			dateFormat: "yy-mm-dd",
			numberOfMonths: 1,
			showOn: "button",
			buttonImage: wc_pre_orders_params.calendar_image,
			buttonImageOnly: true
		});
	}

	// hide email notification message textarea when "send email notification" is disabled
	if ($actionEmailMessage.length) {
		$('input[name=wc_pre_orders_action_enable_email_notification]').change(function() {
			if (! $(this).is(':checked')) {
				$actionEmailMessage.closest('tr').hide();
			} else {
				$actionEmailMessage.closest('tr').show();
			}
		}).change();
	}
});
