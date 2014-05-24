var jwt_inited = false;
var jwt_tours=[];
var jwt_settings={};

function jwt_init(tours,settings){
	if(tours.length==0)
		return;
	jQuery(document).ready(function($){
		var init_index = false;
		var tour_id = 'undefined'==typeof(settings.tour_id)?get_linked_tour_id():settings.tour_id;
		var new_tours = [];
		$.each(tours,function(i,t){
			if( t.config.length==0 )return;
			$.each(t.config,function(j,c){				
				if($(c.name).length==0)return;
				t[j]=c;
				new_tours[i]=t;
			});
			if(tour_id==t.id){
				init_index=i;
			}			
		});
	
		jwt_tours = tours;
		settings.autostart = tour_id>0?1:settings.autostart;
		showControls(settings);
		if(!jwt_inited){
			$('#activatetour').live('click',startTour);
			$('#canceltour').live('click',endTour);
			$('#endtour').live('click',stopTour);
			$('#restarttour').live('click',restartTour);
			$('#nextstep').live('click',nextStep);
			$('#prevstep').live('click',prevStep);			
			jwt_inited = true;
		}
		if(false!==init_index){
			jwt_tour_init(init_index);
		}
	});
}

function get_linked_tour_id(){
	if(''!=location.hash){	
		var h = location.hash;
		var m = h.match(/^#tour-([0-9]+)$/);
		if(m.length==2){
			return m[1];
		}
	}
	return 0;
}

function jwt_tour_init(t){
	if('undefined'==typeof(jwt_tours[t])){
		return;
	}
	
	jQuery(document).ready(function($){		
		if( 1==jwt_tours[t].gotouri && $('#admin_jwt_request_uri').length>0 ){
			if( $('#admin_jwt_request_uri').val() != jwt_tours[t].tour_uri ){
				window.location.href = jwt_tours[t].tour_uri + '#tour-' + jwt_tours[t].id;
				return;
			} 
		}
	
		hideOverlay();
		if(jwt_settings.autoplay) clearTimeout(jwt_settings.showtime);
	
		var defaults = {
			config: [],
			autoplay: false,
			skin: 'default',
			showtime: null,
			step:0,
			total_steps:0,
			overlay:1
		};
		jwt_settings = $.extend({},defaults,jwt_tours[t]);
		jwt_settings.total_steps = jwt_settings.config.length;	
		startTour();
	});
}

function showControls(settings){
	if('undefined'!=typeof(settings.autostart)&&settings.autostart==0){console.log('Not showing because autostart=0');return};
	if('undefined'!=typeof(settings.controls)&&settings.controls==0){console.log('Not showing because controls=0');return};
	if( 1==jQuery.cookie('jwt_hide') && get_linked_tour_id()==0 ){console.log('Not showing because of cookie');return};
	jQuery(document).ready(function($){
		var defaults = {
			skin: 'default',
			intro: '',
			donotshow: 1,
			donotshow_label: 'Do not show this again.'
		};
		options = $.extend({},defaults,settings);
		
		if( $('#tourcontrols').length>0 ){
			$('#tourcontrols').remove();
		}
		
		var str  = '<div id="tourcontrols" class="tourcontrols '+options.skin+'">';
		if(''!=options.intro){
			str += '<div class="tour-intro">'+options.intro+'</div>';
		}
		$.each(jwt_tours,function(i,o){
			str += '<div class="tour-option"><a rel="'+i+'" href="javascript:jwt_tour_init('+i+');">'+o.title+'</a></div>';	
		});
		
		str += '<span class="tour-close" id="canceltour" title="Close"></span>';
		
		if( $('#admin_jwt_request_uri').length>0 && options.donotshow==1 && options.donotshow_label!=''){
			str += '<div class="tour-option-hide"><input type="checkbox" id="jwt_do_not_show" OnClick="javascript:jwt_do_not_show(this);" name="jwt_do_not_show" value="'+$('#admin_jwt_request_uri').val()+'" />&nbsp;'+options.donotshow_label+'</div>';	
		}
		
		str += '<div class="tour-nav">';
		str += '<div class="holder-button"><div id="endtour" class="tour-button" style="display:none;" title="Stop">&nbsp;</div></div>';	
		if(!jwt_settings.autoplay){
			str += '<div class="holder-button"><div class="tour-button" id="nextstep" style="display:none;" title="Next">&nbsp;</div></div>';
			str += '<div class="holder-button"><div class="tour-button" id="prevstep" style="display:none;" title="Previous">&nbsp;</div></div>';
		}
		str += '<div class="holder-button"><div id="restarttour" class="tour-button" style="display:none;" title="Restart">&nbsp;</div></div>';
		str += '</div>';
		
		str += '<div class="tour-clear"></div></div>';
		
		jQuery('BODY').append(str);
		jQuery('#tourcontrols').animate({'right':'30px'},500);
	});
}
		
function startTour(){
	jQuery(document).ready(function($){
		$('#activatetour').remove();
		$('#endtour,#restarttour').show();
		if((!jwt_settings.autoplay && jwt_settings.total_steps > 1)||jwt_settings.tour_link!='')
			$('#nextstep').show();
			
		showOverlay();
		nextStep();
	});	
}

function showOverlay(){
	if(jQuery('#tour_overlay').length==0){
		if(jwt_settings.overlay){
			jQuery('BODY').append('<div id="tour_overlay" class="tour-overlay"></div>');
		}
	}
}
				
function nextStep(){
	if(!jwt_settings.autoplay){
		if(jwt_settings.step > 0)
			jQuery('#prevstep').show();
		else
			jQuery('#prevstep').hide();
		if(jwt_settings.step == jwt_settings.total_steps-1){
			if( jwt_settings.tour_link=='' )
				jQuery('#nextstep').hide();
		}else{
			jQuery('#nextstep').show();
		}	
	}	
	if(jwt_settings.step >= jwt_settings.total_steps){
		//if last step then end tour	
		if( jwt_settings.tour_link!='' ){
			window.location.href = jwt_settings.tour_link;
		}else{
			stopTour();
		}
		return false;
	}
	++jwt_settings.step;
	showTooltip();
}
	
function prevStep(){
	if(!jwt_settings.autoplay){
		if(jwt_settings.step > 2)
			jQuery('#prevstep').show();
		else
			jQuery('#prevstep').hide();
		if(jwt_settings.step == jwt_settings.total_steps)
			jQuery('#nextstep').show();
	}		
	if(jwt_settings.step <= 1)
		return false;
	--jwt_settings.step;
	showTooltip();
}
				
function stopTour(){
	jwt_settings.step = 0;
	if(jwt_settings.autoplay) clearTimeout(jwt_settings.showtime);
	removeTooltip();
	hideOverlay();
	jQuery('#prevstep').hide();
	jQuery('#nextstep').hide();
	jQuery('#restarttour').hide();
	jQuery('#endtour').hide();
}
				
function endTour(){
	jwt_settings.step = 0;
	if(jwt_settings.autoplay) clearTimeout(jwt_settings.showtime);
	removeTooltip();
	hideControls();
	hideOverlay();
}
				
function restartTour(){
	jwt_settings.step = 0;
	if(jwt_settings.autoplay) clearTimeout(jwt_settings.showtime);
	showOverlay();
	nextStep();
}
			
function removeTooltip(){
	jQuery('#tour_tooltip').remove();
}
			
function hideControls(){
	jQuery('#tourcontrols').remove();
}
			
function hideOverlay(){
	jQuery('#tour_overlay').remove();
}			
	
	function showTooltip(){
		//remove current tooltip
		removeTooltip();
	
		var step_config		= jwt_settings.config[jwt_settings.step-1];
		var $elem			= jQuery(step_config.name);

		if( $elem.length==0 )return;
		
		if(jwt_settings.autoplay)
			jwt_settings.showtime	= setTimeout(nextStep,step_config.time);
		
		var bgcolor 		= step_config.bgcolor;
		var color	 		= step_config.color;
		var width			= step_config.width;
		var v_offset		= step_config.v_offset;
		var h_offset		= step_config.h_offset;
		
		var $tooltip		= jQuery('<div>',{
			id			: 'tour_tooltip',
			'class' 	: 'tour-tooltip '+jwt_settings.skin,
			//html		: '<p>'+step_config.text+'</p><span class="tour-tooltip_arrow"></span>'
			html		: '<div class="tour-tooltip-content">' + step_config.text + '</div><span class="tour-tooltip_arrow"></span>'
		}).css({
			'display'			: 'none'/*,
			'background-color'	: bgcolor,
			'color'				: color*/
		});
		
		if(width>0)
			$tooltip.width(width);
		//the css properties the tooltip should have
		var properties		= {};
		
		var tip_position 	= step_config.position;
		
		//append the tooltip but hide it
		jQuery('BODY').append($tooltip);
		
		//get some info of the element
		var e_w				= $elem.outerWidth();
		var e_h				= $elem.outerHeight();
		var e_l				= $elem.offset().left + parseInt(h_offset);
		var e_t				= $elem.offset().top + parseInt(v_offset);
	
		switch(tip_position){
			case 'TL'	:
				properties = {
					'left'	: e_l,
					'top'	: e_t + e_h + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_TL');
				break;
			case 'TR'	:
				properties = {
					'left'	: e_l + e_w - $tooltip.width() + 'px',
					'top'	: e_t + e_h + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_TR');
				break;
			case 'BL'	:
				properties = {
					'left'	: e_l + 'px',
					'top'	: e_t - $tooltip.height() + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_BL');
				break;
			case 'BR'	:
				properties = {
					'left'	: e_l + e_w - $tooltip.width() + 'px',
					'top'	: e_t - $tooltip.height() + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_BR');
				break;
			case 'LT'	:
				properties = {
					'left'	: e_l + e_w + 'px',
					'top'	: e_t + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_LT');
				break;
			case 'LB'	:
				properties = {
					'left'	: e_l + e_w + 'px',
					'top'	: e_t + e_h - $tooltip.height() + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_LB');
				break;
			case 'RT'	:
				properties = {
					'left'	: e_l - $tooltip.width() + 'px',
					'top'	: e_t + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_RT');
				break;
			case 'RB'	:
				properties = {
					'left'	: e_l - $tooltip.width() + 'px',
					'top'	: e_t + e_h - $tooltip.height() + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_RB');
				break;
			case 'T'	:
				properties = {
					'left'	: e_l + e_w/2 - $tooltip.width()/2 + 'px',
					'top'	: e_t + e_h + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_T');
				break;
			case 'R'	:
				properties = {
					'left'	: e_l - $tooltip.width() + 'px',
					'top'	: e_t + e_h/2 - $tooltip.height()/2 + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_R');
				break;
			case 'B'	:
				properties = {
					'left'	: e_l + e_w/2 - $tooltip.width()/2 + 'px',
					'top'	: e_t - $tooltip.height() + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_B');
				break;
			case 'L'	:
				properties = {
					'left'	: e_l + e_w  + 'px',
					'top'	: e_t + e_h/2 - $tooltip.height()/2 + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_L');
				break;
		}
		
		var w_t	= jQuery(window).scrollTop();
		var w_b = jQuery(window).scrollTop() + jQuery(window).height();
		//get the boundaries of the element + tooltip
		var b_t = parseFloat(properties.top,10);
		
		if(e_t < b_t)
			b_t = e_t;
		
		var b_b = parseFloat(properties.top,10) + $tooltip.height();
		if((e_t + e_h) > b_b)
			b_b = e_t + e_h;
			
		
		if((b_t < w_t || b_t > w_b) || (b_b < w_t || b_b > w_b)){
			jQuery('html, body').stop()
			.animate({scrollTop: b_t}, 500, 'easeInOutExpo', function(){
				//need to reset the timeout because of the animation delay
				if(jwt_settings.autoplay){
					clearTimeout(jwt_settings.showtime);
					jwt_settings.showtime = setTimeout(nextStep,step_config.time);
				}
				//show the new tooltip
				$tooltip.css(properties).fadeIn();
			});
		}
		else
		//show the new tooltip
			$tooltip.css(properties).fadeIn();
	}

(function($) {
	$.fn.get_unique_selector = function () {
	    if (this.length != 1) throw 'Requires one element.';
	    if( $(this).attr('id') ) return '#'+$(this).attr('id');
		var path, node = this;
	    while (node.length) {
	        var realNode = node[0], name = realNode.localName;
	        if (!name) break;
	        name = name.toLowerCase();
	
	        var parent = node.parent();
	
	        var siblings = parent.children(name);
	        if (siblings.length > 1) { 
	            name += ':eq(' + siblings.index(realNode) + ')';
	        }
	
	        path = name + (path ? '>' + path : '');
	        node = parent;
	    }
	    return path;
	};
})(jQuery);
	
function admin_displayTooltip(o){
	jQuery(document).ready(function($){
		admin_removeTooltip();
		
		var unique_selector = $(o.elem).get_unique_selector();
		
		var defaults = {
			'elem':null,
			'position':'TL',
			'bgcolor':'black',
			'color':'white',
			'content':'Click the + to add a tour slide at this position. You can modify the settings afterwards.<div class="add-button-cont"><input id="add-tour-button" rel="'+unique_selector+'" type="button" class="tour-button" value="Add Tour Slide" /></div><div class="tour-clear"></div>',
			'scrolltop':true,
			'autotip':false,
			'v_offset':0,
			'h_offset':0
		};
		
		settings = $.extend({},defaults,o);
		
		var $elem			= $(o.elem);		
		var tip_position 	= settings.position;
		var skin = 'undefined'==o.skin||o.skin==''?'blue':o.skin;
		
		var $tooltip		= $('<div>',{
			id			: 'tour_tooltip',
			'class' 	: 'tour-tooltip '+skin,
			html		: '<div class="tour-tooltip-content">' + settings.content+'</div><span class="tour-tooltip_arrow"></span>'
		}).css({
			'display'			: 'none'/*,
			'background-color'	: settings.bgcolor,
			'color'				: settings.color*/
		});		
		
		var width			= settings.width;
		if(width>0)
			$tooltip.width(width);		
		//the css properties the tooltip should have
		var properties		= {};

		//append the tooltip but hide it
		$('BODY').append($tooltip);
		//get some info of the element
		var e_w				= $elem.outerWidth();
		var e_h				= $elem.outerHeight();
		var e_l				= $elem.offset().left + parseInt(settings.h_offset);
		var e_t				= $elem.offset().top + parseInt(settings.v_offset);

		var f_h = $(window).height();
		var f_w = $(window).width();
		if(settings.autotip){
			if(e_t>(f_h/2)){
				if(e_l>(f_w/2)){
					tip_position='BR';
				}else{
					tip_position='BL';
				}
			}else{
				if(e_l>(f_w/2)){
					tip_position='TR';
				}else{
					tip_position='TL';
				}			
			}
		}		
		
		$($tooltip).find('#add-tour-button').attr('tip_position',tip_position);
		
		switch(tip_position){
			case 'TL'	:
				properties = {
					'left'	: e_l,
					'top'	: e_t + e_h + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_TL');
				break;
			case 'TR'	:
				properties = {
					'left'	: e_l + e_w - $tooltip.width() + 'px',
					'top'	: e_t + e_h + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_TR');
				break;
			case 'BL'	:
				properties = {
					'left'	: e_l + 'px',
					'top'	: e_t - $tooltip.height() + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_BL');
				break;
			case 'BR'	:
				properties = {
					'left'	: e_l + e_w - $tooltip.width() + 'px',
					'top'	: e_t - $tooltip.height() + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_BR');
				break;
			case 'LT'	:
				properties = {
					'left'	: e_l + e_w + 'px',
					'top'	: e_t + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_LT');
				break;
			case 'LB'	:
				properties = {
					'left'	: e_l + e_w + 'px',
					'top'	: e_t + e_h - $tooltip.height() + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_LB');
				break;
			case 'RT'	:
				properties = {
					'left'	: e_l - $tooltip.width() + 'px',
					'top'	: e_t + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_RT');
				break;
			case 'RB'	:
				properties = {
					'left'	: e_l - $tooltip.width() + 'px',
					'top'	: e_t + e_h - $tooltip.height() + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_RB');
				break;
			case 'T'	:
				properties = {
					'left'	: e_l + e_w/2 - $tooltip.width()/2 + 'px',
					'top'	: e_t + e_h + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_T');
				break;
			case 'R'	:
				properties = {
					'left'	: e_l - $tooltip.width() + 'px',
					'top'	: e_t + e_h/2 - $tooltip.height()/2 + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_R');
				break;
			case 'B'	:
				properties = {
					'left'	: e_l + e_w/2 - $tooltip.width()/2 + 'px',
					'top'	: e_t - $tooltip.height() + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_B');
				break;
			case 'L'	:
				properties = {
					'left'	: e_l + e_w  + 'px',
					'top'	: e_t + e_h/2 - $tooltip.height()/2 + 'px'
				};
				$tooltip.find('span.tour-tooltip_arrow').addClass('tour-tooltip_arrow_L');
				break;
		}
		
		var w_t	= $(window.parent).scrollTop();
		var w_b = $(window.parent).scrollTop() + $(window.parent).height();
		//get the boundaries of the element + tooltip
		var b_t = parseFloat(properties.top,10);

		if(e_t < b_t)
			b_t = e_t;
		
		var b_b = parseFloat(properties.top,10) + $tooltip.height();
		if((e_t + e_h) > b_b)
			b_b = e_t + e_h;
			
		if((settings.scrolltop)&&((b_t < w_t || b_t > w_b) || (b_b < w_t || b_b > w_b))){
			$(window.parent.document).find('html, body')
			.stop()
			.animate({scrollTop: b_t}, 500, 'easeInOutExpo', function(){
				$tooltip.css(properties).show();
			});
		}
		else
		//show the new tooltip
			$tooltip.css(properties).show();		
	});
}

function admin_removeTooltip(){
	jQuery('#tour_tooltip').remove();
}

function jwt_do_not_show(o){
	jwt_hide = jQuery.cookie('jwt_hide');
	if(jQuery(o).is(':checked')){
		jQuery.cookie('jwt_hide',1,{path:'/',expires:366});
	}else{
		jQuery.cookie('jwt_hide',0,{path:'/',expires:366});
	}
}