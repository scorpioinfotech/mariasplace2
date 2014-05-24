/* global redux_change, wp */

jQuery(document).ready(function () {

    jQuery('.redux-contact_info-remove').live('click', function () {
        redux_change(jQuery(this));
        jQuery(this).parent().siblings().find('input[type="text"]').val('');
        jQuery(this).parent().siblings().find('textarea').val('');
        jQuery(this).parent().siblings().find('input[type="hidden"]').val('');

        var contactInfoCount = jQuery(this).parents('.redux-container-contact_info:first').find('.redux-contact_info-accordion-group').length;

        if (contactInfoCount > 1) {
            jQuery(this).parents('.redux-contact_info-accordion-group:first').slideUp('medium', function () {
                jQuery(this).remove();
            });
        } else {
            jQuery(this).parents('.redux-contact_info-accordion-group:first').find('.remove-image').click();
            jQuery(this).parents('.redux-container-contact_info:first').find('.redux-contact_info-accordion-group:last').find('.redux-contact_info-header').text("New Slide");
        }
    });

    jQuery('.redux-contact_info-add').click(function () {


        var oldSlide = jQuery(this).prev().find('.redux-contact_info-accordion-group:last');
        oldSlide.find('select').select2('destroy');

        var newSlide = oldSlide.clone(true);

        //oldSlide.find('select').select2();

        var contactInfoCount = jQuery(newSlide).find('input[type="text"]').attr("name").match(/[0-9]+(?!.*[0-9])/);
        var contactInfoCount1 = contactInfoCount*1 + 1;

        jQuery(newSlide).find('input[type="text"],  input[type="hidden"], textarea, select').each(function(){

            if(typeof jQuery(this).attr("name") !== 'undefined') {
                jQuery(this).attr("name", jQuery(this).attr("name").replace(/[0-9]+(?!.*[0-9])/, contactInfoCount1) );
            }

            if(typeof jQuery(this).attr("id") !== 'undefined') {
                jQuery(this).attr("id", jQuery(this).attr("id").replace(/[0-9]+(?!.*[0-9])/, contactInfoCount1) );
            }
            jQuery(this).val('');
            if (jQuery(this).hasClass('contact_info-sort')){
                jQuery(this).val(contactInfoCount1);
            }
        });

        newSlide.find('input[type="checkbox"]').removeAttr('checked');

        newSlide.find('h3').text('').append('<span class="redux-contact_info-header">New Contact Info</span><span class="ui-accordion-header-icon ui-icon ui-icon-plus"></span>');
        jQuery(this).prev().append(newSlide);

        //newSlide.find('select').select2();
        jQuery.redux.select3();
    });

    jQuery('.contact_info-title').keyup(function(event) {
        var newTitle = event.target.value;
        jQuery(this).parents().eq(3).find('.redux-contact_info-header').text(newTitle);
    });

    jQuery(function () {
        jQuery(".redux-contact_info-accordion")
            .accordion({
                header: "> div > fieldset > h3",
                collapsible: true,
                active: false,
                heightStyle: "content",
                icons: { "header": "ui-icon-plus", "activeHeader": "ui-icon-minus" }
            })
            .sortable({
                axis: "y",
                handle: "h3",
                connectWith: ".redux-contact_info-accordion",
                start: function(e, ui) {
                    ui.placeholder.height(ui.item.height());
                    ui.placeholder.width(ui.item.width());
                },
                placeholder: "ui-state-highlight",
                stop: function (event, ui) {
                    // IE doesn't register the blur when sorting
                    // so trigger focusout handlers to remove .ui-state-focus
                    ui.item.children("h3").triggerHandler("focusout");
                    var inputs = jQuery('input.contact_info-sort');
                    inputs.each(function(idx) {
                        jQuery(this).val(idx);
                    });
                }
            });
    });




});