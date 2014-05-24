jQuery(document).ready(function () {
    "use strict";

    jQuery('ul.sf-menu').superfish({
        delay: 1000, // one second delay on mouseout
        animation: {
            opacity: 'show',
            height: 'show'
        }, // fade-in and slide-down animation
        speed: 'fast', // faster animation speed
        autoArrows: false // disable generation of arrow mark-up
    });

    jQuery('.flexslider').flexslider({
        prevText: "<span class='icon-angle-left'></span>", //String: Set the text for the "previous" directionNav item
        nextText: "<span class='icon-angle-right'></span>",
    });

    jQuery('#navigation-wrapper > nav > div > ul > li.menu-item-has-children > a').append('<i class="icon-angle-down"></i>');
    jQuery('#navigation-wrapper > nav > div > ul > li.menu-item-has-children > ul.sub-menu > li.menu-item-has-children > a').append('<i class="icon-angle-right"></i>');
    
    jQuery('input[type=button].add-image').addClass('button small black');
    jQuery(".type_list div.one_third:nth-child(3n)").addClass("last");
    jQuery(".wrapper").fitVids();
    jQuery('.follow-link a, #mail-submit').addClass('dp-button medium no-shadow');
    jQuery('.latest-blog .blog-item:last-child').addClass('last');
    jQuery('p.form-submit input[type=submit]').addClass('button');
    jQuery('.mfp-img').addClass('animated flipInX');
    jQuery('.widget_categories ul li').hover(
        function () {
            jQuery(this).children('ul').css({
                display: "block"
            }).fadeIn('slow');
        },
        function () {
            //hide its submenu
            jQuery(this).children('ul').css({
                display: "none"
            }).fadeOut('slow');
        }
    );
    jQuery.fn.center = function () {
        this.css("position", "fixed");
        this.css("top", (jQuery(window).height() / 2) - (this.outerHeight() / 2));
        this.css("left", (jQuery(window).width() / 2) - (this.outerWidth() / 2) + 200);
        return this;
    }
    jQuery('body.home #ajax-map-loader #floatingCirclesG').center();
    jQuery(window).resize(function () {
        jQuery('body.home #ajax-map-loader #floatingCirclesG').center();
    });

    jQuery('select#main_cat').change(function () {
        jQuery('#wpas-tax_listings_categories.wpas-generic-field').show();
    });
    jQuery('select#main_loc').change(function () {
        jQuery('#wpas-tax_listings_location.wpas-generic-field').show();
    });
    jQuery('#open-search, #open-claim').magnificPopup({
        type: 'inline',
        src: '#search-popup', // CSS selector of an element on page that should be used as a popup
        midClick: true,
        callbacks: {
            open: function () {

                jQuery('#wpas-tax_listings_categories').append('<div id="status_loader"></div>');
                jQuery('#wpas-tax_listings_location').append('<div id="status_loader2"></div>');

                // Will fire when this exact popup is opened
                // this - is Magnific Popup object
                /* 
                 * Ajax Request to get cats
                 */
                jQuery(function () {
                    jQuery('#main_cat').change(function () {
                        jQuery('#status_loader').show();
                        var jQuerymainCat = jQuery('#main_cat').val();
                        // call ajax
                        jQuery("#tax_listings_categories").empty();
                        jQuery.ajax({
                            url: popup_url + "/wp-admin/admin-ajax.php",
                            type: 'POST',
                            data: 'action=tdp_search_ajax_call&main_catid=' + jQuerymainCat,
                            success: function (results) {
                                //  alert(results);
                                jQuery('#status_loader').hide();

                                jQuery('#tax_listings_categories')
                                    .find('option')
                                    .remove()
                                    .end();

                                jQuery("#tax_listings_categories").removeAttr("disabled");
                                jQuery("#tax_listings_categories").append(results);
                            }
                        });
                    });
                });

                /* 
                 * Ajax Request to get cats
                 */
                jQuery(function () {
                    jQuery('#main_loc').change(function () {
                        jQuery('#status_loader2').show();
                        var jQuerymainLoc = jQuery('#main_loc').val();
                        // call ajax
                        jQuery("#tax_listings_location").empty();
                        jQuery.ajax({
                            url: popup_url + "/wp-admin/admin-ajax.php",
                            type: 'POST',
                            data: 'action=tdp_search_ajax_call2&main_catid2=' + jQuerymainLoc,
                            success: function (results) {
                                //  alert(results);
                                jQuery('#status_loader2').hide();

                                jQuery('#tax_listings_location')
                                    .find('option')
                                    .remove()
                                    .end();

                                jQuery("#tax_listings_location").removeAttr("disabled");
                                jQuery("#tax_listings_location").append(results);
                            }
                        });
                    });
                });

            },
            close: function () {
                // Will fire when popup is closed
            }
            // e.t.c.
        }
    });
    jQuery('.gallery').each(function () { // the containers for all your galleries should have the class gallery
        jQuery(this).magnificPopup({
            delegate: 'a', // the container for each your gallery items
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    });
    jQuery('.slides').each(function () { // the containers for all your galleries should have the class gallery
        jQuery(this).magnificPopup({
            delegate: 'a', // the container for each your gallery items
            type: 'image',
            gallery: {
                enabled: true
            },
            removalDelay: 500, //delay removal by X to allow out-animation
            callbacks: {
                beforeOpen: function () {
                    // just a hack that adds mfp-anim class to markup 
                    this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure animated bounceInDown');
                    //this.st.mainClass = this.st.el.attr('data-effect');
                }

            },
            closeOnContentClick: true,
        });
    });
    jQuery('#wpas-tax_listings_categories').append('<div id="status_loader"></div>');
    jQuery('#wpas-tax_listings_location').append('<div id="status_loader2"></div>');

    jQuery("#contactform, #fcontactform").validate();

    jQuery("#submitform").validate();

    jQuery('#wp-advanced-search input, #side-navigation input, #front-login input, #routeForm input, #loginform input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });

    jQuery('#content-container .acf-tab-group').append('<div class="submit-border"></div>');

    jQuery('#wpas-tax_post_tag').after('<div class="clear"></div>');

    jQuery("a#fav-nonlogged").click(function () {
        jQuery('#fav-logged-message').show("scale", 500);
    });

    jQuery(function () {
        jQuery("#side-navigation").tabs();
    });

    //  Responsive layout, resizing the items
    jQuery('#foo4').carouFredSel({
        responsive: true,
        width: '100%',
        scroll: 1,
        items: {
            width: 400,
            //  height: '30%',  //  optionally resize item-height
            visible: {
                min: 4,
                max: 20
            }
        }
    });
    jQuery('#listing_gallery').carouFredSel({
        responsive: true,
        width: '100%',
        scroll: 1,
        items: {
            width: 400,
            //  height: '30%',  //  optionally resize item-height
            visible: {
                min: 3,
                max: 20
            }
        }
    });
    jQuery('#layout-changer a').on('click', function(){
        jQuery('a.current').removeClass('current');
        jQuery(this).addClass('current');
    });
});
jQuery(window).bind("load resize", function () {
    var windowWidth = jQuery(window).width();
    var RowWidth = jQuery("body").find(".span12").eq(1).width();
    /**
     * Out of the box content blocks functionality
     */
    var outoftheboxMargin = "-" + (windowWidth - RowWidth) / 2 + "px";
    if (!jQuery(".sidebar-enabled")[0]) { // do nothing if sidebar enabled (element with .sidebar-enabled exists)
        jQuery(".out-box").each(function () {
            jQuery(this).css({
                "margin-left": outoftheboxMargin,
                "margin-right": outoftheboxMargin
            });
        });
    }
});
