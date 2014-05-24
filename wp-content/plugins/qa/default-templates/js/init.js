jQuery(function($) {

	function __(s) {
		return ( undefined === CLEDITOR_I18N[s] ) ? s : CLEDITOR_I18N[s];
	}

	// Add CLEditor if needed
	var $editor = $('#question-form, #answer-form').find('textarea');
	if ( $editor.length && $editor.cleditor) {
		$editor.cleditor({
			width: QA_L10N.content_width - 4,
			height: 200,
			controls: 'bold italic | image link unlink | bullets numbering style | outdent indent | undo redo | removeformat source',
			styles:
				[
				  [__("Paragraph"), "<p>"],
				  [__("Header 3"), "<h3>"],
				  [__("Header 4"), "<h4>"],
				  [__("Header 5"), "<h5>"]
				]
		});
	}

	// Add tags auto-suggest
	var $tags = $('#question-tags');
	if ( $tags.length ) {
		$tags.suggest(QA_L10N.ajaxurl + '?action=ajax-tag-search&tax=question_tag', {
			multiple     : true,
			resultsClass : 'qa-suggest-results',
			selectClass  : 'qa-suggest-over',
			matchClass   : 'qa-suggest-match'
		});
	}

	// Ajaxify voting
	$(document).delegate('.vote-up-on, .vote-up-off, .vote-down-on, .vote-down-off', 'click', function () {
    //alert(this.className);
	
		var
			$button = $(this),
			$form = $button.closest('form'),
			msg = $button.attr('data-msg');

		if ( msg ) {
			alert( QA_L10N['msg_' + msg] );
		} else {
		var classname = $(this).attr('class');
		//alert(classname);
		if(classname == 'vote-up-on'){
//alert('.vote-up-on');
 var parentid = $(this).closest('form').closest('.qa-voting-box').attr('id');
                               $('.'+parentid).removeClass("vote-up-on");
                              $('.'+parentid).addClass("vote-up-off");
$('.'+parentid).closest('.qa-voting-wrap').removeClass("qa-active");
}
else{
//alert('.vote-up-off');
 var parentid = $(this).closest('form').closest('.qa-voting-box').attr('id');
                               $('.'+parentid).removeClass("vote-up-off");
                              $('.'+parentid).addClass("vote-up-on");
$('.'+parentid).closest('.qa-voting-wrap').addClass("qa-active");
}

 /*if($(".qa-voting-box form input[type='submit']").hasClass("vote-up-on")) {
                             var parentid = $form.closest('.qa-voting-box').attr('id');

                              $('.'+parentid).addClass("vote-up-on");
                                }
                                else {
                               var parentid = $form.closest('.qa-voting-box').attr('id');
                               $('.'+parentid).addClass("vote-up-off");
                                  }
 */


			$.post(QA_L10N.ajaxurl, $form.serializeArray(), function(response) {
				$form.closest('.qa-voting-box').replaceWith(response);
                               
                              
                        });
		}

		return false;
	});

	// Ajaxify accepting
	$(document).delegate('input.vote-accepted-on, input.vote-accepted-off', 'click', function () {
		var $form = $(this).closest('form');

		$.post(QA_L10N.ajaxurl, $form.serializeArray(), function(response) {
			$('.vote-accepted-on').each(function() {
				$(this)
					.attr('class', 'vote-accepted-off')
					.closest('.qa-voting-box').find('[name="accept"]').val('on');
			});

			$form.replaceWith(response);
		});

		return false;
	});

	// Init user tabs
	if ( $('#qa-user-tabs-wrapper').length ) {
		var $userTabs = $('#qa-user-tabs').find('li a');
		var clickTab = function() {
			var $a = $(this);

			$userTabs.removeClass('youarehere');
			$a.addClass('youarehere');

			$('#qa-user-tabs-wrapper').children('div').addClass('ui-tabs-hide');
			$( $a.attr('href') ).removeClass('ui-tabs-hide');

			return false;
		}

		$userTabs
			.click(clickTab)
			.eq(0).click();
	}
});
