/////////////////////////////////////// Image Preloader ///////////////////////////////////////


jQuery(function () {
	jQuery('.preload').hide();
});

var i = 0;
var int=0;
jQuery(window).bind("load", function() {
	var int = setInterval("doThis(i)",100);
});

function doThis() {
	var images = jQuery('.preload').length;
	if (i >= images) {
		clearInterval(int);
	}
	jQuery('.preload:hidden').eq(0).fadeIn(400);
	i++;
}
	

/////////////////////////////////////// Window Loaded ///////////////////////////////////////


jQuery(window).load(function(){

	"use strict";
	

	/////////////////////////////////////// Navigation Menu Positioning ///////////////////////////////////////


	gpNavPos();

	jQuery(window).resize(function() {
		gpNavPos();
	});
	
	function gpNavPos() {	
		jQuery("#nav > ul > li").each(function() {
			var navPos = jQuery(this).offset();
			if(navPos.left + 240 > jQuery(window).width()+document.body.scrollLeft-240) {
				jQuery(this).addClass("left-nav");
			} else {
				jQuery(this).removeClass("left-nav");
			}
		});	
	}	
	
			
});


/////////////////////////////////////// Document Ready ///////////////////////////////////////


jQuery(document).ready(function(){

	"use strict";


	/////////////////////////////////////// Mobile Navigation Menu ///////////////////////////////////////


	jQuery("<option />", {"selected": "selected", "value": "", "text": navigationText}).prependTo("#nav select");
        	
	jQuery("#nav select").change(function() {
		window.location = jQuery(this).find("option:selected").val();
	});
	

	/////////////////////////////////////// Dropdown Menu Symbols ///////////////////////////////////////

	
	jQuery("#nav > .menu > li").each(function() {
		if(jQuery(this).find("ul").length > 0) {			
			jQuery("<span/>").html("&#9660;").appendTo(jQuery(this).children(":first"));	
		}
	});

	jQuery("#nav > .menu > li > ul > li").each(function() {
		if(jQuery(this).find("ul").length > 0) {	
			jQuery("<span/>").html("&#9654;").appendTo(jQuery(this).children(":first"));	
		}
	});
	
	
	/////////////////////////////////////// Lightbox ///////////////////////////////////////


	jQuery("div.gallery-item .gallery-icon a").prepend('<span class="hover-image"></span>');
	jQuery("div.gallery-item .gallery-icon a").attr("rel", "prettyPhoto[gallery]");

	jQuery("a[rel^='prettyPhoto']").prettyPhoto({
		theme: 'pp_default',
		deeplinking: false,
		social_tools: ''
	});


	/////////////////////////////////////// Image Hover ///////////////////////////////////////


	jQuery(document).ready(function(){

		jQuery('.hover-image, .hover-video').css({'opacity':'0'});
		jQuery("a[rel^='prettyPhoto']").hover(
			function() {
				jQuery(this).find('.hover-image, .hover-video').stop().fadeTo(750, 1);
				jQuery(this).find("img").stop().fadeTo(750, 0.5);
			},
			function() {
				jQuery(this).find('.hover-image, .hover-video').stop().fadeTo(750, 0);
				jQuery(this).find("img").stop().fadeTo(750, 1);
			})

	});


	/////////////////////////////////////// Back To Top ///////////////////////////////////////


	jQuery(".back-to-top").click(function() {
		jQuery("html, body").animate({ scrollTop: 0 }, 'slow');
	});


	/////////////////////////////////////// Accordion ///////////////////////////////////////


	jQuery(".accordion").accordion({ header: "h3.accordion-title" });
	jQuery("h3.accordion-title").toggle(function(){
		jQuery(this).addClass("active");
		}, function () {
		jQuery(this).removeClass("active");
	});


	/////////////////////////////////////// Tabs ///////////////////////////////////////


	jQuery(".sc-tabs").tabs({
		fx: {
			height:'toggle',
			duration:'fast'
		}
	});


	/////////////////////////////////////// Toggle Content ///////////////////////////////////////


	jQuery(".toggle-box").hide(); 
	jQuery(".toggle").toggle(function(){
		jQuery(this).addClass("toggle-active");
		}, function () {
		jQuery(this).removeClass("toggle-active");
	});
	jQuery(".toggle").click(function(){
		jQuery(this).next(".toggle-box").slideToggle();
	});


	/////////////////////////////////////// Contact Form ///////////////////////////////////////

	
	jQuery('#contact-form').submit(function() {

		jQuery('.contact-error').remove();
		var hasError = false;
		jQuery('.requiredFieldContact').each(function() {
			if(jQuery.trim(jQuery(this).val()) == '') {
				jQuery(this).addClass('input-error');
				hasError = true;
			} else if(jQuery(this).hasClass('email')) {
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				if(!emailReg.test(jQuery.trim(jQuery(this).val()))) {
					jQuery(this).addClass('input-error');
					hasError = true;
				}
			}
		});

	});
			
	jQuery('#contact-form .contact-submit').click(function() {
		jQuery('.loader').css({display:"block"});
		});


	/////////////////////////////////////// Prevent Empty Search - Thomas Scholz http://toscho.de ///////////////////////////////////////


	(function($) {
		$.fn.preventEmptySubmit = function(options) {
			var settings = {
				inputselector: "#searchbar",
				msg          : emptySearchText
			};
			if (options) {
				$.extend(settings, options);
			}
			this.submit(function() {
				var s = $(this).find(settings.inputselector);
				if(!s.val()) {
					alert(settings.msg);
					s.focus();
					return false;
				}
				return true;
			});
			return this;
		};
	})(jQuery);

	jQuery('#searchform').preventEmptySubmit();
		
		
});