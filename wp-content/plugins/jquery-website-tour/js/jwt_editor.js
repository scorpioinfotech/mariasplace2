function load_attachments(o){
	o=typeof(o)=='undefined'?{}:o;
	jQuery(document).ready(function($) {
		if( $(o.sel).find('input.modified, textarea.modified, select.modified').length==0 ){
			load_uploaded_attachments(o);
		}else{
			$('.tab-status').addClass('tab-status-loading');		
			$(o.sel).find('input.modified, textarea.modified, select.modified').each(function(i,inp){
				var args = {
					action: o.save_action,
					post_id: post_id,
					name: $(inp).attr('name'),
					value: $(inp).val()
				};
				$.post(ajaxurl,args,function(data){
					if(data.R=='OK'){
						load_uploaded_attachments(o);
					}else{
						alert('There was an error saving your changes.');
					}
					//$('.tab-status').removeClass('tab-status-loading');
				},'json');
			});		
		}		
	});
}

function load_uploaded_attachments(o){
	jQuery(document).ready(function($) {
		var data = {
			action: o.load_action,
			post_id: post_id,
			used:0
		};

		$(o.sel).load(ajaxurl,data,function(responseText){
			if(responseText==''){
				$(this).html('<p></p>');
				return;
			}
			
			$('.meta-tabs').tabs();
	
			$(this).sortable({
				revert:true,
				handle:'.ui-tabs-nav',
				placeholder:'ui-state-highlight',
				forcePlaceholderSize:true,
				update: function(event,ui){save_sorting(event,ui);}
			});
			
			$('.ico-close').click(function(){
				if(!confirm('Do you want to delete this slide?'))return;
				$('#jwt-settings-'+$(this).attr('rel')).fadeOut();
				$.post(ajaxurl,{'post_id':'','attach_id':$(this).attr('rel'),'action':jwt_settings.delete_action},function(data){
					if(data.R=='OK'){
						load_attachments();
					}else if(data.R=='ERR'){
						alert(data.MSG);
						return true;
					}else{
						alert('Unknown error');
						return true;
					}
				},'json');
			});
			
			$(this).find('input, textarea, select').change(function(){
				$(this).addClass('modified');
			});
			
			if($('.jwt-colorpicker').length>0){				
				$('.jwt-colorpicker').ColorPicker({
					onSubmit: function(hsb, hex, rgb, el) {
						$(el).val(hex).trigger('change');
						$(el).ColorPickerHide();
					},
					onBeforeShow: function () {
						$(this).ColorPickerSetColor(this.value);
					}
				})
				.bind('keyup', function(e){
					$(this).ColorPickerSetColor(this.value);
					 if (e.keyCode == 27) { $(this).ColorPickerHide(); }
				});					
			}		
			
			if( $(':range').length>0 ){
				$(':range')
					.rangeinput()
					.change(function(e,v){
						$(this).addClass('modified');
					});
			}
			
			if('undefined'!=typeof(o.attach_id)){
				$('.left-tool-cont').scrollTo('#jwt-settings-'+o.attach_id,{duration:500,easing:'easeOutQuad'});
			}
		});
	});
}

function save_sorting(event,ui){
	jQuery(document).ready(function($) {
		if( $('.settings-cont').length>0 ){
			$('.tab-status').addClass('tab-status-loading');
			var ids = [];
			$('.settings-cont').each(function(i,o){
				ids[ ids.length ] = $(this).attr('rel');
			});
			
			var args = {
				action: jwt_settings.save_order_action,
				post_id: post_id,
				'ids[]': ids
			};
			$.post(ajaxurl,args,function(data){
				if(data.R=='OK'){
					
				}else if(data.R=='ERR'){
					load_attachments();
					alert(data.MSG);
					return true;
				}else{
					load_attachments();
					alert('Unknown error');
					return true;
				}
				$('.tab-status').removeClass('tab-status-loading');
			},'json');			
		}
	});
}

(function($) {
	$.fn.helper_browser = function(options){
		var settings = $.extend({},$.fn.helper_browser.defaults,options);		
		
		function helper_open(helper){
			$('body').addClass('showing-helper');
			
			$('body, html').css('height', $(window).height() );
			$('#wpadminbar').fadeOut();
			$(helper).show();
		}
		
		function helper_close(helper){
			$('body').removeClass('showing-helper');
			$('#wpadminbar').fadeIn();
			$(helper).hide();
		}
			
		return this.each(function() {
			var helper = this;
			var frame = $(helper).find('.helper-frame');
			if(settings.sync_fields.length>0){
				$(settings.sync_fields).each(function(i,o){
					if(o.length==2){
						$(helper).find('[name='+o[1]+']').attr('rel',o[0]).addClass('sync-field').val($('[name='+o[0]+']').val());
					}
				});
			}
			
			$(helper).height( $(document).height() );
			
			$(this).find('.btn_close').unbind('click').click(function(){
				helper_close(helper);
			});
			
			$(this).find('.btn_accept').unbind('click').click(function(){
				$(helper).find('.sync-field').each(function(i,o){
					var sync_field = $(o).attr('rel');
					$('[name='+sync_field+']').val( $(o).val() ); 
				});
				load_attachments(jwt_settings);
				helper_close(helper);
			});
			
			$(this).find('.btn_go').unbind('click').click(function(){
				$(helper).find('.helper-status').addClass('helper-status-loading').html('Please wait, page is loading...');
				$(frame).attr('src', $(helper).find('.helper-url').val() );
			});			
			
			if( ''==$(helper).find('.helper-url').val() ){
				$(helper).find('.helper-url').val(settings.start_url);
			}
			
			$(frame).load(function(){
				if( $(frame).contents().find('#admin_jwt_request_uri').length>0 ){
					$('.helper-tour-uri').val($(frame).contents().find('#admin_jwt_request_uri').val());
				}

				$(frame).contents().unbind('click').click(function(e){			
					if( $(e.target).hasClass('tour-button') ){
						$(helper).find('.helper-status').addClass('helper-status-loading').html('Adding a new slide...');
						$('.tab-status').addClass('tab-status-loading');
						var args = {
							action: jwt_settings.add_action,
							post_id: post_id,
							selector: $(e.target).attr('rel'),
							position: $(e.target).attr('tip_position')
						};
						$.post(ajaxurl,args,function(data){
							if(data.R=='OK'){
								jwt_settings.attach_id = data.ID;
								load_attachments(jwt_settings);
								$(helper).find('.helper-status').removeClass('helper-status-loading').html('New slide added.');
							}else if(data.R=='ERR'){
								$('.tab-status').removeClass('tab-status-loading');
								$(helper).find('.helper-status').removeClass('helper-status-loading').html('Error adding slide. '+data.MSG);
							}else{
								$('.tab-status').removeClass('tab-status-loading');
								$(helper).find('.helper-status').removeClass('helper-status-loading').html('Invalid api response, please reload the page.');
							}
						},'json');	
					}	
				});
				
				$(frame).contents().find('.tour-button').live('click',function(){
					
				});		
						
				if(settings.start_frame_url != window.frames.helper_frame.location.href){
					$('.helper-url').val( window.frames.helper_frame.location.href );
				}

				$(frame).contents().find('*').hover(function(e){
					$(frame).contents().find('*').removeClass('helper-hovered');
					$(e.target).addClass('helper-hovered');	
					
					if(false===jwt_change_selector){
						window.frames.helper_frame.admin_displayTooltip({'skin':$('#skin').val(),'elem':e.target,scrolltop:false,autotip:true});
					}
				},function(e){
					$(e.target).removeClass('helper-hovered');				
				});				
				
				$(frame).contents().find('*').unbind('click').click(function(e){
					if(false!=jwt_change_selector){
						$('#'+jwt_change_selector).val( $(e.target).get_unique_selector() ).trigger('change');
						$('.change-selector[rel='+jwt_change_selector+']').trigger('click');
						e.stopImmediatePropagation();
						return false;
					}
				});
				
				$(helper).find('.helper-status').removeClass('helper-status-loading').html('Page loaded.');
						
				$(helper).helper_frame_resize();	
				
				if('undefined'!=typeof(window.frames.helper_frame.endTour)){
					window.frames.helper_frame.endTour();
				}
			});
			
			$(frame).attr('src',settings.start_frame_url);
				
			helper_open(helper);
			$('html, body').animate({scrollTop:0}, 'slow');
		});
	};
	
	$.fn.helper_browser.defaults = {
		start_url:'',
		sync_fields: []
	};
	
	$.fn.helper_browser.close = function(){
		$('body').removeClass('showing-helper');
		return this;
	}
	
	$.fn.helper_frame_resize = function(){
		return this.each(function() {
			var h = $(this).find('.helper-frame').contents().find('html').height()+30
			var lh = h + $(this).find('.helper-top').height();
			var document_h = $(document).height()+$(this).find('.helper-top').height();
			lh = lh<document_h?document_h:lh;
			
			$(this).find('.helper-frame').height( lh );
			if(lh>$(this).find('.left-tool-cont').height()){
				//$(this).find('.left-tool-cont').height( lh );
			}			
		});
	}	
})(jQuery);	

function get_el_id(el){
	return jQuery(el).attr('id')?'#'+jQuery(el).attr('id'):'';
}

function get_el_class(el){
	var sel = '';
	var classes = jQuery(el).attr('class').split(' ');
	if(classes.length>0){
		jQuery.each(classes,function(i,val){
			if(val.replace(' ','')!='')
			sel = sel+'.'+val;
		})
	}
	return sel;
}

function select_section(e,id){
	jQuery(document).ready(function($) {
		var sel = '';
		$.each(['BODY','HTML'],function(i,val){
			if(e.target.nodeName==val){
				sel = val;
				return false;							
			}	
		});
		if(sel){
			$('#bg_selector').val(sel).change();
			change_background(e,id,sel);
			return true;
		}
		
		sel = $(e.target).attr('id');
		if(sel){
			$('#bg_selector').val('#'+sel).change();
			change_background(e,id,'#'+sel);
			return true;
		}
		
		sel = get_el_class(e.target);
		if(sel){
			$('#bg_selector').val(sel).change();
			change_background(e,id,sel);
			return true;
		}
		
		var p_sel = get_el_id($(e.target).parent())?get_el_id($(e.target).parent()):get_el_class($(e.target).parent());
		if(p_sel){
			sel = p_sel+' '+e.target.nodeName;
			$('#bg_selector').val(sel).change();
			change_background(e,id,'#branding img');
			return true;
		}
		
		$('#bg_selector').val('').change();
	});
}