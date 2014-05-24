jQuery(document).ready(function($){
	
	/* ------------------------------------------------------------------------ */
	/* Accordion */
	/* ------------------------------------------------------------------------ */
	
	$('.accordion').each(function(){
	    var acc = $(this).attr("rel") * 2;
	    $(this).find('.accordion-inner:nth-child(' + acc + ')').show();
	     $(this).find('.accordion-inner:nth-child(' + acc + ')').prev().addClass("active");
	});
	
	$('.accordion .accordion-title').click(function() {
	    if($(this).next().is(':hidden')) {
	        $(this).parent().find('.accordion-title').removeClass('active').next().slideUp(200);
	        $(this).toggleClass('active').next().slideDown(200);
	    }
	    return false;
	});
	
	/* ------------------------------------------------------------------------ */
	/* Alert Messages */
	/* ------------------------------------------------------------------------ */
	
	$(".alert-message .close").click(function(){
		$(this).parent().animate({'opacity' : '0'}, 300).slideUp(300);
		return false;
	});
	
	/* ------------------------------------------------------------------------ */
	/* Skillbar */
	/* ------------------------------------------------------------------------ */
	
	$('.skillbar').each(function(){
	    dataperc = $(this).attr('data-perc'),
	    $(this).find('.skill-percentage').animate({ "width" : dataperc + "%"}, dataperc*20);
	});
	
	/* ------------------------------------------------------------------------ */
	/* Tabs */
	/* ------------------------------------------------------------------------ */
	
	$('div.tabset').tabset();
	
	//Tabs
		$("dl.mds-tabs-wrapperr").mTabs({
			speed:400,
			easing:"",
			effect:"fade",
			mEvent:"click"
		});
	
	/* ------------------------------------------------------------------------ */
	/* Toggle */
	/* ------------------------------------------------------------------------ */
	
	if( $(".toggle .toggle-title").hasClass('active') ){
		$(".toggle .toggle-title.active").closest('.toggle').find('.toggle-inner').show();
	}
	
	$(".toggle .toggle-title").click(function(){
		if( $(this).hasClass('active') ){
			$(this).removeClass("active").closest('.toggle').find('.toggle-inner').slideUp(200);
		}
		else{
			$(this).addClass("active").closest('.toggle').find('.toggle-inner').slideDown(200);
		}
	});

/* EOF document.ready */
});

/* Tabset Function ---------------------------------- */
(function ($) {
$.fn.tabset = function () {
    var $tabsets = $(this);
    $tabsets.each(function (i) {
        var $tabs = $('li.tab a', this);
        $tabs.click(function (e) {
            var $this = $(this);
                panels = $.map($tabs, function (val, i) {
                    return $(val).attr('href');
                });
            $(panels.join(',')).hide();
            $tabs.removeClass('selected');
            $this.addClass('selected').blur();
            $($this.attr('href')).show();
            e.preventDefault();
            return false;
        }).first().triggerHandler('click');
    });
};
})(jQuery);


(function($)
{
    $.fn.mTabs = function(options){
		var defaults = 
        {
		   effect:"fade", /* effect of tab "slide" or fade*/
		   speed:500, /* speed of animation, default is 500 milisecond*/
		   easing:"",
		   mEvent:"click"
        };
		var options = $.extend(defaults, options);
		
		return this.each(function(){
			var opts = options,
			obj = $(this),
			tab = $("> dt",obj),
			tabFirst = $("> dt:first-child",obj),
			tabContent = $("> dd",obj);
			tabContent.hide();
			
			$('dt:first',obj).addClass("active").next().show().addClass("active");
			obj.css({height:$('dt:first',obj).next().outerHeight() + tab.outerHeight()});
			tabContent.css({top:tab.outerHeight()-1,left:0});
			
			tab.bind(opts.mEvent, function() {

				 lastCenter=map.getCenter();

				google.maps.event.trigger(map, 'resize');

				map.setCenter(lastCenter);

				if( $(this).next().is(":hidden") ) {
				$(this).parent().animate({height:$(this).next().outerHeight() + tab.outerHeight()});
				tab.removeClass("active");}
				
				if(opts.effect == "slide")
				{
					tabContent.removeClass("active").slideUp(opts.speed / 2 ,opts.easing); 
					$(this).addClass("active").next().slideDown(opts.speed,opts.easing).addClass("active"); 
					
				}
				else if(opts.effect == "fade"){
					tabContent.removeClass("active").fadeOut(opts.speed / 2,opts.easing); 
					$(this).addClass("active").next().fadeIn(opts.speed,opts.easing).addClass("active");
				}
				return false;
			});	
			
			$(window).bind('resize',function(){
				$('.mds-tabs-wrapper').each(function(index, element) {
                    $(this).css({height:$('> dt.active',this).outerHeight() + $('> dd.active',this).outerHeight()});
                });
			});
        	
		});
	}
})(jQuery);

/* ------------------------------------------------------------------------ */
/* EOF */
/* ------------------------------------------------------------------------ */