jQuery(function($) {
    'use strict';

    var form;
    var fieldset = jQuery('.minigo_subscriber_list_form');
    var textarea = fieldset.find('textarea');
    var submit = fieldset.find('input[type="submit"]');

    setTimeout(function() {
        form = jQuery('<form action="' + window.location.href + '" method="post"></form>');
        fieldset.wrap(form);
        form = fieldset.parent();

        form.on('submit', function(e) {
            fieldset.find('textarea').attr('name', 'minigo_subscriber_list');
            form.off(e);
            form.submit();
        });
    }, 2000);
    textarea.off('change click submit');
    submit.off('click submit change');

    /* Footer buttons */
    $('#redux-footer').prepend('<div class="minigo-footer-buttons"></div>');
    $('.minigo-footer-buttons').append($('#redux-intro-text .button').clone());

    /* Top icons */
    $('#redux-header').append($('.premiothemes-logo').css('display', '')).append('<div class="nav-icons">' +
            '<a href="mailto:hello@premiothemes.com"><i class="fa fa-pencil-square-o"></i><span>E-mail Support</span></a>' +
            '<a href="http://themeforest.net/user/PremioThemes?ref=PremioThemes" target="_blank"><i class="fa fa-star"></i><span>ThemeForest Portfolio</span></a>' +
            '<div class="vr"></div>' +
            '<a href="https://www.facebook.com/PremioThemes" target="_blank"><i class="fa fa-facebook-square"></i><span>Facebook</span></a>' +
            '<a href="https://twitter.com/premiothemes" target="_blank"><i class="fa fa-twitter-square"></i><span>Twitter</span></a>' +
            '<a href="https://www.pinterest.com/premiothemes/" target="_blank"><i class="fa fa-pinterest"></i><span>Pinterest</span></a>' +
            '<div class="vr"></div>' +
      '</div>');

    /* Fix for wrong wp_editor height */
    $(window).on('load', function() {
        setTimeout(function() {
            var editors = $('.mceIframeContainer iframe');
            if(!editors.length) {
                return;
            }

            editors.each(function() {
                var el = $(this);

                if(el.css('height') !== '28px') {
                    return;
                }

                el.css('height', '300px').parents('.mceLayout').css('height', '');
            });
        }, 1000)
    });

});