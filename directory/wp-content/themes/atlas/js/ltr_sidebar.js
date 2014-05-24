jQuery(document).ready(function() {
        "use strict";

/*
     * Navigation toggle handle - shows hides navigation with smooth effect
     * 
     * 
     */
    
    jQuery(".toggle-activator").click(function(e) {
        var $header_navigation_wrap = jQuery("#home-sidebar");
        var $content_outer_wrap = jQuery("#home-outer-wrap");
        
        var speed = 500;
        
        //handle classic or fixed menu on the left side
        if( $header_navigation_wrap.hasClass("header-left") && jQuery(window).width() >= 768 ) {  
            
            if( $header_navigation_wrap.hasClass("is-collapsed-header") ) { // if header naviagation is collapsed show it
                jQuery(window).trigger('is_navigation_about_to_open');
                $header_navigation_wrap.stop().animate({"left" : "0px"}, speed, function() {
                    $header_navigation_wrap.removeClass("is-collapsed-header");
                });
                
                jQuery('.toggle-activator').removeClass('hello-im-hidden');
                jQuery('.toggle-button').removeClass('animated pulse');

                $content_outer_wrap.stop().animate({"margin-left" : "400px"}, speed, function() {
                    $header_navigation_wrap.removeClass("is-navigation-hidden");
                    jQuery(window).trigger('is_navigation_toggled');
                });
            
            } else { // otherwise hide it
                jQuery(window).trigger('is_navigation_about_to_close');
                $header_navigation_wrap.stop().animate({"left" : "-400px"}, speed, function() {
                    $header_navigation_wrap.addClass("is-collapsed-header");
                    //jQuery(window).trigger('is_navigation_toggled');
                });
                
                jQuery('.toggle-activator').addClass('hello-im-hidden');
                jQuery('.toggle-button').addClass('animated pulse');

                $content_outer_wrap.stop().animate({"margin-left" : "10px"}, speed, function() {
                    $header_navigation_wrap.addClass("is-navigation-hidden");
                    jQuery(window).trigger('is_navigation_toggled');
                });

            }
        
        }
    });

});