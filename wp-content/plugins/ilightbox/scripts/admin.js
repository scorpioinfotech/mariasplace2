jQuery(document).ready(function($){

	var DOC = $(document),
		notification = $('<div id="ilightbox_notification"></div>'),
		loader = $('<div id="ilightbox_preloader"><div><div></div></div></div>'),
		topBar = $('.ilightbox_topbar'),
		mainContainer = $('.right_side');
		
	function dialogue(content, title) {
		content = $('<div />', {
			'class': 'dialogue clearfix'
		}).append(content);
		
		$.iLightBox([
			{
				URL: content,
				type: "html",
				title: title || null
			}
		],
		{
			skin: 'metro-white ilightbox-dialogue',
			minScale: 1,
			innerToolbar: true,
			overlay: {
				blur: false,
				opacity: .6
			},
			controls: {
				toolbar: false,
				fullscreen: false
			},
			keyboard: {
				esc: false
			},
			callback: {
				// Hide the iLightBox when any buttons in the dialogue are clicked
				onRender: function(api) {
					$('.il-button', api.currentElement).click(function(){
						$('.il-button', api.currentElement).unbind('click');
						api.hide();
					});
				},
				
				onShow: function(api) {
					setTimeout(function() { $('.lightblue-button', api.currentElement).focus(); }, 50);
				}
			}
		});
	}

	// Our Alert method
	function Alert(message, title)
	{
		// Content will consist of the message and an ok button
		var message = $('<p />', { 'class': 'dialogue_message' }).html(message),
			ok = $('<a />', { 'tabindex':'0', 'class': 'il-button lightblue-button' }).html("<span>OK</span>").one('keyup',function(e){
				if(e.keyCode == 13) $(this).trigger('click');
			});

		dialogue( message.add(ok) , title);
	}

	// Our Prompt method
	function Prompt(question, title, initial, callback)
	{
		// Content will consist of a question elem and input, with ok/cancel buttons
		var message = $('<p />', {
			'class': 'dialogue_message'
		}).html(question),
		input = $('<input />', {
			'type': 'text',
			val: initial
		}),
		clear = $('<div />', {
			'class': 'clear'
		}),
		ok = $('<a />', {
			'tabindex':'0',
			'class': 'il-button lightblue-button'
		}).html("<span>OK</span>").one('click', function(){
			callback( input.val() );
		}).one('keyup', function(e){
			if(e.keyCode == 13) $(this).trigger('click');
		}),
		cancel = $('<a />', {
			'tabindex':'0',
			'class': 'il-button white-button'
		}).html("<span>Cancel</span>").one('click', function(){
			callback(null);
		});

		dialogue( message.add(input).add(clear).add(ok).add(cancel), title );
	}

	// Our Confirm method
	function Confirm(question, title, callback)
	{
		// Content will consist of the question and ok/cancel buttons
		var message = $('<p />', { 'class': 'dialogue_message' }).html(question),
		ok = $('<a />', { 
			'tabindex':'0',
			'class': 'il-button lightblue-button'
		}).html("<span>Yes</span>").one('click', function(){
			callback(true);
		}).one('keyup', function(e){
			if(e.keyCode == 13) $(this).trigger('click');
		}),
		cancel = $('<a />', { 
			'tabindex':'0',
			'class': 'il-button white-button'
		}).html("<span>No</span>").one('click', function(){
			callback(false);
		});

		dialogue( message.add(cancel).add(ok), title, function() { callback(false); } );
	}

	
	function binder(callback, info)
	{
		info = info || {};
		
		var form = $('<form />', {
			'class': 'ilightbox_bind_form'
		}),
		input = $('<input />').attr({
			'name': 'query',
			'value': info.query || null,
			'type': 'text',
			'class': 'ilightbox_bind_query',
			'placeholder': 'Write the CSS DOM Selector Query'
		}),
		events = $('<select />').attr({
			'name': 'event',
			'class': 'ilightbox_bind_event'
		}),
		returns = $('<select />').attr({
			'name': 'return',
			'class': 'ilightbox_bind_event'
		}),
		clear = $('<div />', {
			'class': 'clear'
		}),
		ok = $('<a />', {
			'tabindex':'0',
			'class': 'il-button lightblue-button'
		}).html("<span>OK</span>").one('click', function(){
			callback( form.serialize() );
		}).one('keyup', function(e){
			if(e.keyCode == 13) $(this).trigger('click');
		}),
		cancel = $('<a />', {
			'tabindex':'0',
			'class': 'il-button white-button'
		}).html("<span>Cancel</span>");
		
		var Events = ['click', 'dblclick', 'blur', 'change', 'error', 'focus', 'keydown', 'keypress', 'keyup', 'load', 'mousedown', 'mouseenter', 'mouseleave', 'mousemove', 'mouseout', 'mouseover', 'mouseup', 'resize', 'ready', 'select', 'scroll', 'submit', 'unload'];
		
		$.each(Events, function(key, val){
			events.append($('<option />', {
				val: val
			}).text(val.toUpperCase()).attr('selected', (info.event == val) ? true : false));
		});
		
		returns.append($('<option />', {
			val: ''
		}).text('None')).append($('<option />', {
			val: 'false'
		}).text('Return false').attr('selected', (info.return == 'false') ? true : false));
			
		console.log(info);
		
		dialogue( form.append(input).append('<div class="ilightbox_bind_description">For get more information about this option refer to <a href="http://api.jquery.com/category/selectors/" target="_blank">jQuery Selectors</a>.</div>').append(clear).append(events).append('<div class="ilightbox_bind_description">For get more information about this option refer to <a href="http://api.jquery.com/category/events/" target="_blank">jQuery Events</a>.</div>').append(clear).append(returns).add(ok).add(cancel), 'Attach this gallery to an event for the elements.' );
	}

	function showLoader(){
		loader.appendTo('body').fadeIn();
	}

	function hideLoader(){
		loader.fadeOut(function(){ loader.remove(); });
	}

	function showNotification(message){
		notification.html(message).appendTo('body').slideDown();
		setTimeout(function(){ notification.slideUp(function(){ notification.remove(); }); }, 5000);
	}

	function takeAction(data, func){
		data = 'action=ilightbox_actions&' + data;
		$.ajax({
			url: ILIGHTBOX.ajaxURL,
			data: data,
			dataType: "html",
			type: "POST",
			cache: false,
			success: function(response){
				res = jQuery.parseJSON(response);
					if(res.message) {
						var message = ($.isArray(res.message)) ? "" : res.message,
						title = (res.title) ? res.title : false;
						if($.isArray(res.message)) {
							if(res.message.length==1) message = res.message[0];
							else $.each(res.message, function(key, value){
								message += (key+1)+". " + res.message[key] + "<br />";
							});
						}
					}
					
					if(res.status != 200){
						if(res.message) Alert(message, title);
					}
					
					if(func) func.call(this, res);
			}, error: function(){
				hideLoader();
				Alert('Please try again.', 'Error!');
			}
		});
	}
	
	function loadPage(url, el){
		showLoader();
		mainContainer.load(url + ' .right_side > *', function(){
			hideLoader();
			topBar = $('.ilightbox_topbar');
		
			if(el.parents('.left_side').length >= 1) {
				var parent = el.parent();
				$('a', parent).removeClass('active');
				el.addClass('active');
			}
			$(window).trigger('load');
		});
	}
	
	
	var $_GET = URI(window.location.href).query(true),
	pageQuery = $_GET['page'],
	idQuery = $_GET['id'] || -1;
	if(typeof history.pushState == 'function') window.onpopstate = function(event){
		if (window.location.hash) return false;
		var el, state = event.state || { page: $_GET['page'], id: $_GET['id'] || -1, url: window.location.href },
			url = state.url,
			id = state.id,
			page = state.page;
		
		if(page == 'ilightbox_general') el = $('.left_side > div > div a').eq(0);
		else if(page == 'ilightbox_create') el = $('.left_side > div > div a').eq(1);
		else if(page == 'ilightbox_configurations') el = $('.left_side > div > div a').eq(2);
		else if(page == 'ilightbox_documentation') el = $('.left_side > div > div a').eq(3);

		if(page != pageQuery) {
			pageQuery = page,
			idQuery = id;
			
			loadPage(url, el);
		} else if(page == pageQuery && (id != idQuery)) {
			pageQuery = page,
			idQuery = id;
			
			loadPage(url, el);
		}
	};
	

	if (ILIGHTBOX.wpMedia) {
		var iLFrame, iLFrameSingle;
	}

	DOC.on('click', '.load_page, #wp-admin-bar-ilightbox_general a', function(){
		if(typeof history.pushState == 'function') {
			var el, t = $(this),
			mainurl = window.location.href.substr(0, window.location.href.indexOf('?')),
			url = t.prop('href'),
			$_GET = URI(url).query(true),
			id = $_GET['id'] || -1,
			page = $_GET['page'];

			if(page == 'ilightbox_general') el = $('.left_side > div > div a').eq(0);
			else if(page == 'ilightbox_create') el = $('.left_side > div > div a').eq(1);
			else if(page == 'ilightbox_configurations') el = $('.left_side > div > div a').eq(2);
			else if(page == 'ilightbox_documentation') el = $('.left_side > div > div a').eq(3);

			if(page != pageQuery) {
				pageQuery = page,
				idQuery = id;
				
				var stateObj = { page: page, id: id, url: url };
				history.pushState(stateObj, null, url);
				
				loadPage(url, el);
			} else if(page == pageQuery && (id != idQuery)) {
				pageQuery = page,
				idQuery = id;
				
				var stateObj = { page: page, id: id, url: url };
				history.pushState(stateObj, null, url);
				
				loadPage(url, el);
			}
			
			return false;
		}
	}).on('click', 'a[href^=#]', function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
        && location.hostname == this.hostname) {
            var hash = this.hash, target = $(hash);
            target = target.length && target
            || $('[name=' + hash.slice(1) +']');
            if (target.length) {
                var targetOffset = target.offset().top - 98;
                $('html, body').stop().animate({scrollTop: targetOffset}, 800, 'easeOutQuad');
				
				location.hash = hash.replace('#','');
				
                return false;
            }
        }
    }).on('submit', '.ajaxform', function(){
		var t = $(this),
		message = t.data('message'),
		form = rawurlencode(t.serialize()),
		data = "form=" + form;
		
		showLoader();
		takeAction(data, function(api){
			hideLoader();
			if(api.status == 200) {
				showNotification(api.message);
				
				if(t.hasClass('createGallery')){
					$('input[name="action"]', t).val('editGallery');
					$('input[name="gid"]', t).val(api.gid);
					$('a[role="submit"] span', t).text('Save Changes');
				}
			}
		});
		return false;
	}).on('click', '[role="submit"]', function(){
		var t = $(this),
			form = t.parents('form');
			
			if(form.length && !t.hasClass('disabled')) form.submit();
	}).on('click', '#ilightbox_admin_wrap .section h3.title', function(){
		var t = $(this),
		parent = t.parent();
		
		parent.toggleClass('collapsed');
		
		if(!parent.hasClass('collapsed')) {
			var targetOffset = parent.offset().top - 98;
			$('html, body').stop().animate({scrollTop: targetOffset}, 500);
		}
		
		if (document.createEvent ) {
			var ev = document.createEvent('HTMLEvents');
			ev.initEvent('resize', true, false);
			window.dispatchEvent(ev);
		} else { // Internet Explorer
			if(window.fireEvent) window.fireEvent('onresize');
		}
	}).on('click', '.insert_media', function(){
		var upDiv = $(this).parent('div'),
		upField = $('input[type="text"]', upDiv),
		thumbValue = $('input.thumbnail', upDiv.parent()),
		upThumb = $('img', upDiv),
		images = ".jpg,.jpeg,.jpe,.jfif,.png,.gif";
		window.formfield_media = '';
		
		if (ILIGHTBOX.wpMedia) {
			// Destroy the previous gallery frame.
			if ( iLFrameSingle )
				iLFrameSingle.dispose();

			// Store the current gallery frame.
			iLFrameSingle = wp.media({
				title : 'Insert Media',
				frame: 'select',
				multiple : false,
				library : { type : 'image,video'}
			});

			iLFrameSingle.on('select', function(){
				var media_attachment = iLFrameSingle.state().get('selection').first().toJSON();

				if(media_attachment.sizes) {
					var thumbnail = media_attachment.sizes.thumbnail.url;
					upThumb.attr('src',thumbnail).show();
					thumbValue.val(thumbnail);
				}
				else {
					upThumb.attr('src', null).hide();
					thumbValue.val('');
				}
				
				upField.val(media_attachment.url);
			});

			iLFrameSingle.open();
		}
		else {
			window.formfield_media = upField;
			var iLB = $.iLightBox([
				{
					url:'media-upload.php?post_id=0&amp;TB_iframe=true',
					type:'iframe',
					options: {
						width: 665,
						height: '95%'
					}
				}
			], {
				innerToolbar: true,
				controls: {
					fullscreen: false
				},
				skin: 'metro-black'
			});
			
			window.media_send_to_editor = window.send_to_editor;
			window.send_to_editor = function(html, f) {
				html = html.replace(/\[[\S\s]*?\]/gi,'');
				
				if (window.formfield_media != '') {
					var mediaurl = $(html).attr('href') || $(html).attr('src'),
						split = mediaurl.split('?attachment_id='),
						split2 = mediaurl.split('wp-content/uploads/'),
						data = (split[1]) ? '_action=getAttachmentUrl&id='+split[1] : '_action=getAttachmentUrl&path='+split2[1];
						
					takeAction(data, function(api){
						if(api.thumb) {
							upThumb.attr('src',api.thumb).show();
							thumbValue.val(api.thumb);
						}
						else {
							upThumb.attr('src', null).hide();
							thumbValue.val('');
						}
						
						if(api.url) window.formfield_media.val(api.url);
						window.formfield_media = '';
					
						iLB.close();
					});
				}
				else {
					window.media_send_to_editor(html);
				}
			}
		}
		return false;
	}).on('click', '#add_slide', function(){
		var slide = $('#slide'),
			slides = $('#slides'),
			clone = slide.clone().attr('id', null);
		
		clone.appendTo(slides);
		clone.fadeIn(500);
		
		var targetOffset = clone.offset().top - 98;
		$('html, body').stop().animate({scrollTop: targetOffset}, 500);
		
		orderSlides(true);
	}).on('click', '#multiple_upload', function(){
		if (ILIGHTBOX.wpMedia) {
			// Destroy the previous gallery frame.
			if ( iLFrame )
				iLFrame.dispose();

			// Store the current gallery frame.
			iLFrame = wp.media({
				title : 'Insert Media',
				frame: 'select',
				multiple : true,
				library : { type : 'image,video'}
			});

			iLFrame.on('select', function(){
				var media_attachments = iLFrame.state().get('selection').toJSON();

				$.each(media_attachments, function(i, val){
					var slide = $('#slide'),
						slides = $('#slides'),
						clone = slide.clone().attr('id', null);

					clone.appendTo(slides);
					var input = $('input', clone);
					
					input.eq(0).attr('value', val.url);
					if(typeof val.sizes != "undefined") {
						var thumbnail = val.sizes.thumbnail.url;
						input.eq(2).attr('value', thumbnail);
						$('.thumb img', clone).attr('src', thumbnail).show();
					}
					if(val.caption) {
						input.eq(3).attr('value', val.caption);
					}
					
					clone.fadeIn(500);
					orderSlides(true);
				});
			});

			iLFrame.open();
		} else {
			var uploader = $('.ilightbox_file_uploader');
			
			if(uploader.is(':visible')) uploader.hide();
			else uploader.show();
		}
	}).on('click', 'a.remove_slide', function(){
		var parent = $(this).parent();
		
		parent.css('overflow', 'hidden').animate({ height:0, opacity:0, marginBottom:-2 }, function(){
			parent.remove();
			orderSlides();
		});
	}).on('click', '.actions .remove, .actions .unbind', function(){
		var t = $(this),
			parent = t.parents('.ilightbox_gallery_item'),
			id = t.data('id'),
			title = (t.hasClass('remove')) ? "Remove?" : "Unbind?",
			message = (t.hasClass('remove')) ? "Are you sure you want to remove this gallery?" : "Are you sure you want to unbind this gallery?",
			data = (t.hasClass('remove')) ? '_action=removeGallery&id='+id : '_action=unbindGallery&id='+id;
		
		Confirm(message, title, function(res){
			if(res) {
				showLoader();
				takeAction(data, function(api){
					hideLoader();
					if(api.status == 200){
						parent.css('overflow', 'hidden').animate({ width:0, opacity:0, marginLeft:0, marginRight:0 }, function(){
							parent.remove();
						});
						showNotification(api.message);
					}
				});
			}
		});
	}).on('click', '.actions .bind', function(){
		var t = $(this),
			id = t.data('id');
		
		binder(function(data){
			data = '_action=bindGallery&id=' + id + '&' + data;
			showLoader();
			takeAction(data, function(api){
				hideLoader();
				if(api.status == 200) showNotification(api.message);
			});
		});
	}).on('click', '.actions .edit_bind', function(){
		var t = $(this),
			info = eval("(" + t.data('info') + ")");
		
		binder(function(data){
			data = '_action=rebindGallery&id=' + info.gid + '&bid=' + info.id + '&' + data;
			showLoader();
			takeAction(data, function(api){
				hideLoader();
				if(api.status == 200) showNotification(api.message);
			});
		}, info);
	}).on('click', '.actions .preview', function(){
		var t = $(this),
			id = t.data('id'),
			data = "_action=previewGallery&id="+id;
		
		showLoader();
		takeAction(data, function(api){
			hideLoader();
			if(api.status == 200) {
				var slides = api.slides && eval("(" + api.slides + ")") || [];
					options = api.options && eval("(" + api.options + ")") || {};
					
				$.iLightBox(slides, options);
			}
		});
	}).on('click', '.ilightbox_navbar a', function(){
		var t = $(this),
			tabs = $('.ilightbox_navbar a'),
			holder = $('.contents_holder:visible'),
			target = $(t.data('target'));
			
		if(!t.hasClass('active') && target.length) {
			tabs.removeClass('active');
			t.addClass('active');
			
			holder.stop().hide();
			target.stop().css({ position: 'relative', opacity:0, top: 40 }).show().animate({ opacity:1, top: 0 }, 350, 'easeOutCirc', function(){
				target.removeAttr('style').show();
			});
		}
	}).on('click', '#preview_gallery', function(){
		var t = $(this),
		form = t.parents('form'),
		formData = form.serializeObject();
		if(typeof formData.gid != 'undefined') delete formData.gid;
		formData._action = "previewGallery";
		
		var data = "form=" + rawurlencode($.param( formData ));
		
		showLoader();
		takeAction(data, function(api){
			hideLoader();
			if(api.status == 200) {
				var slides = api.slides && eval("(" + api.slides + ")") || [];
					options = api.options && eval("(" + api.options + ")") || {};
					
				$.iLightBox(slides, options);
			}
		});
	});
	
	function orderSlides(a) {
		var slides = $('#slides div.slide');
		
		if(a) {
			var t = slides.last(),
			index = slides.index(t),
			html = t.html().replace(/>__i__<+/g, '>' + (index+1) + '<').replace(/__i__+/g, index);
			
			t.html(html);
		} else slides.each(function(){
			var t = $(this),
			index = slides.index(t);
			
			$('*[pattern]', t).each(function(){
				var $t = $(this),
				pattern = $t.attr('pattern'),
				split = pattern.split('|'),
				str = split[0].replace(/_i_+/g, ($t.hasClass('slide_no')) ? index+1 : index),
				atts = split[1].split(',');
				
				$.each(atts, function(key, value){
					if(value == "html") $t.html(str);
					else $t.attr(value, str);
				});
			});
		});
	}
	
	$(window).load(function(){
		var t = $(this),
			topMenu = $('.left_side'),
			tW = topMenu.outerWidth(),
			tH = (topBar.length) ? topBar.outerHeight() : 0,
			tT = (topBar.length) ? topBar.offset().top : 0,
			wA = $('#wpadminbar'),
			wAH = wA.outerHeight() || 0,
			parent = topBar.parent(),
			loop = 0;
	
		function doScroll(){
			var sTop = t.scrollTop();
				
			if((sTop+wAH) >= (tT-20)) {
				if(loop == 0) {
					loop = 1;
					topBar.css({ top:wAH, width:tW, height:tH }).addClass('fixed');
					parent.css({ 'padding-top':tH+'px'});
				}
			}
			else {
				if(loop == 1){
					loop = 0;
					topBar.removeAttr('style').removeClass('fixed');
					parent.removeAttr('style');
				}
			}
		}
		
		$('#gallery_name').focus();
		
		t.resize(function(){
			loop = 0;
			topBar.removeAttr('style').removeClass('fixed');
			parent.removeAttr('style');
			
			tW = topMenu.outerWidth(),
			tH = (topBar.length) ? topBar.outerHeight() : 0,
			tT = (topBar.length) ? topBar.offset().top : 0;
			
			doScroll();
		});
	
		t.scroll(function(){
			doScroll();
		});
		
		t.trigger('scroll');
	});
	
	$('.ilightbox_ui_slider').livequery(function(){
		var t = $(this),
			data = t.data();
		if(!t.parents('#slide').length) {
			var m = parseFloat(t.data('max')) || 200,
			mi = parseFloat(t.data('min')) || 0,
			s = parseFloat(t.data('step')) || 1,
			input = $('input', t),
			value = input.val(),
			slider = $('.ilightbox_slider_cursor',t);

			if(input.hasClass('small')) slider.parent().css('width', '23%');
			else if(input.hasClass('medium')) slider.parent().css('width', '48%');
			
			slider.slider({
				range: 'min',
				value: value,
				min: mi,
				max: m,
				step: s,
				slide: function( event, ui ) {
					input.val( ui.value );
				}
			});
			
			input.keyup(function(){
				var v = input.val();
				slider.slider( "option", "value", v );
			});
		}
	});
	
	
	$('#ilightbox_styles, textarea.css').livequery(function(){
		var delay, t = $(this),
		editor = CodeMirror.fromTextArea(t[0], {lineNumbers: true, matchBrackets: true, mode:"text/css" });
		
		editor.on("change", function(instance, changeObj) {
			clearTimeout(delay);
			delay = setTimeout(function(){
				t.val(editor.getValue());
			}, 500);
		});
	});
	
	
	$('textarea.javascript').livequery(function(){
		var delay, t = $(this);
		if(!t.parents('#slide').length) {
			var editor = CodeMirror.fromTextArea(t[0], {
				lineNumbers: true,
				matchBrackets: true,
				mode: "application/json"
			});
		
			editor.on("change", function(instance, changeObj) {
				clearTimeout(delay);
				delay = setTimeout(function(){
					t.val(editor.getValue());
				}, 500);
			});
		}
	});
	
	
	$('textarea.html').livequery(function(){
		var delay, t = $(this);
		if(!t.parents('#slide').length) {
			var editor = CodeMirror.fromTextArea(t[0], {
				lineNumbers: true,
				matchBrackets: true,
				autoCloseTags: true,
				mode: {name: "htmlmixed", alignCDATA: true}
			});
		
			editor.on("change", function(instance, changeObj) {
				clearTimeout(delay);
				delay = setTimeout(function(){
					t.val(editor.getValue());
				}, 500);
			});
		}
	});
	
	
	$('textarea.php').livequery(function(){
		var delay, t = $(this);
		if(!t.parents('#slide').length) {
			var editor = CodeMirror.fromTextArea(t[0], {
				lineNumbers: true,
				matchBrackets: true,
				mode: "application/x-httpd-php"
			});
		
			editor.on("change", function(instance, changeObj) {
				clearTimeout(delay);
				delay = setTimeout(function(){
					t.val(editor.getValue());
				}, 500);
			});
		}
	});
	
	
	$("#slides").livequery(function(){
		var t = $(this);
		t.sortable({
			opacity: 0.6,
			items: 'div.slide',
			placeholder: "ilightbox-state-highlight",
			handle: '.dragger',
			revert: 150,
			tolerance: 'pointer',
			sort: function(event, ui) { 
				var w = ui.item.outerWidth();
				var h = ui.item.outerHeight();
				jQuery( ".ilightbox-state-highlight" ).css({'width':w+'px','height':h+'px'});
			},
			update: function(event, ui) {
				ui.item.removeAttr('style').show();
				orderSlides();
			}
		});
	});
	
	
	if(BrowserDetect.browser == 'Explorer' && BrowserDetect.version <= 9) $('input, textarea').livequery(function(){
		if(!$(this).parents('#slide').length) $(this).placeholder();
	});
	
	function uploader(){
		var t = $(this),
		parent = t.parent(),
		button = $('#select-files'),
		selector = $('#ilightbox_file_uploader_content', parent),
		preloader = $('.upload_loader', parent),
		loader = $('div', preloader),
		submitted = false,
		timeOut;
		
		t.fineUploader({
			button: button[0],
			maxConnections: 3,
			request: {
				endpoint: ILIGHTBOX.pluginURL + '/lib/upload.php'
			},
			validation: {
				allowedExtensions: [],
				sizeLimit: ILIGHTBOX.uploadLimit
			}
		}).on('submit', function(event, id, filename){
			preloader.show();
			selector.hide();
		}).on('complete', function(event, id, filename, responseJSON){
			timeOut = setTimeout(function(){
				preloader.hide();
				selector.show();
			}, 500);
			
			var slide = $('#slide'),
			slides = $('#slides'),
			clone = slide.clone().attr('id', null);
			
			clone.appendTo(slides);
			var input = $('input', clone);
			
			input.eq(0).attr('value', responseJSON.attachment.guid);
			if(typeof responseJSON.attach_data.sizes != "undefined") {
				var file = responseJSON.attachment.guid,
				thumbnail = (responseJSON.attachment.guid).replace(basename( file ), responseJSON.attach_data.sizes.thumbnail.file);
				input.eq(2).attr('value', thumbnail);
				$('.thumb img', clone).attr('src', thumbnail).show();
			}
			
			clone.fadeIn(500);
			
			orderSlides(true);
		}).on('progress', function(event, id, file, uploadedBytes, totalBytes){
			clearTimeout(timeOut);
			var percent = ((uploadedBytes/totalBytes)*100);
			loader.width(percent+'%');
		});
	}
	
	$('#ilightbox_uploader').livequery(uploader);
	
});


jQuery.extend( jQuery.easing,
{
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	}
});



//
// Use internal $.serializeArray to get list of form elements which is
// consistent with $.serialize
//
// From version 2.0.0, $.serializeObject will stop converting [name] values
// to camelCase format. This is *consistent* with other serialize methods:
//
//   - $.serialize
//   - $.serializeArray
//
// If you require camel casing, you can either download version 1.0.4 or map
// them yourself.
//
(function ($, window, undefined) {
	$.fn.serializeObject = function () {
		"use strict";

		var result = {};
		var extend = function (i, element) {
			var node = result[element.name];

	// If node with same name exists already, need to convert it to an array as it
	// is a multi-value field (i.e., checkboxes)

			if ('undefined' !== typeof node && node !== null) {
				if ($.isArray(node)) {
					node.push(element.value);
				} else {
					result[element.name] = [node, element.value];
				}
			} else {
				result[element.name] = element.value;
			}
		};

	// For each serialzable element, convert element names to camelCasing and
	// extend each of them to a JSON object

		$.each(this.serializeArray(), extend);
		return result;
	};
})(jQuery, this);

function basename (path, suffix) {
  var b = path.replace(/^.*[\/\\]/g, '');

  if (typeof(suffix) == 'string' && b.substr(b.length - suffix.length) == suffix) {
    b = b.substr(0, b.length - suffix.length);
  }

  return b;
}
	
//Browser Detection
var BrowserDetect={init:function(){this.browser=this.searchString(this.dataBrowser)||"An unknown browser";this.version=this.searchVersion(navigator.userAgent)||this.searchVersion(navigator.appVersion)||"an unknown version";this.OS=this.searchString(this.dataOS)||"an unknown OS"},searchString:function(b){for(var a=0;a<b.length;a++){var c=b[a].string,d=b[a].prop;this.versionSearchString=b[a].versionSearch||b[a].identity;if(c){if(-1!=c.indexOf(b[a].subString))return b[a].identity}else if(d)return b[a].identity}},
searchVersion:function(b){var a=b.indexOf(this.versionSearchString);if(-1!=a)return parseFloat(b.substring(a+this.versionSearchString.length+1))},dataBrowser:[{string:navigator.userAgent,subString:"Chrome",identity:"Chrome"},{string:navigator.userAgent,subString:"OmniWeb",versionSearch:"OmniWeb/",identity:"OmniWeb"},{string:navigator.vendor,subString:"Apple",identity:"Safari",versionSearch:"Version"},{prop:window.opera,identity:"Opera",versionSearch:"Version"},{string:navigator.vendor,subString:"iCab",
identity:"iCab"},{string:navigator.vendor,subString:"KDE",identity:"Konqueror"},{string:navigator.userAgent,subString:"Firefox",identity:"Firefox"},{string:navigator.vendor,subString:"Camino",identity:"Camino"},{string:navigator.userAgent,subString:"Netscape",identity:"Netscape"},{string:navigator.userAgent,subString:"MSIE",identity:"Explorer",versionSearch:"MSIE"},{string:navigator.userAgent,subString:"Gecko",identity:"Mozilla",versionSearch:"rv"},{string:navigator.userAgent,subString:"Mozilla",
identity:"Netscape",versionSearch:"Mozilla"}],dataOS:[{string:navigator.platform,subString:"Win",identity:"Windows"},{string:navigator.platform,subString:"Mac",identity:"Mac"},{string:navigator.userAgent,subString:"iPhone",identity:"iPhone/iPod"},{string:navigator.platform,subString:"Linux",identity:"Linux"}]};
BrowserDetect.init();

function rawurlencode (str) {
  str = (str + '').toString();

  // Tilde should be allowed unescaped in future versions of PHP (as reflected below), but if you want to reflect current
  // PHP behavior, you would need to add ".replace(/~/g, '%7E');" to the following.
  return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').
  replace(/\)/g, '%29').replace(/\*/g, '%2A');
}
	

/*! URI.js v1.8.3 http://medialize.github.com/URI.js/ */
/* build contains: URI.js */
(function(l,s){"object"===typeof exports?module.exports=s(require("./punycode"),require("./IPv6"),require("./SecondLevelDomains")):"function"===typeof define&&define.amd?define(["./punycode","./IPv6","./SecondLevelDomains"],s):l.URI=s(l.punycode,l.IPv6,l.SecondLevelDomains)})(this,function(l,s,r){function d(a,b){if(!(this instanceof d))return new d(a,b);void 0===a&&(a="undefined"!==typeof location?location.href+"":"");this.href(a);return void 0!==b?this.absoluteTo(b):this}function n(a){return a.replace(/([.*+?^=!:${}()|[\]\/\\])/g,
"\\$1")}function p(a){return"[object Array]"===String(Object.prototype.toString.call(a))}function u(a){return encodeURIComponent(a).replace(/[!'()*]/g,escape).replace(/\*/g,"%2A")}var f=d.prototype,t=Object.prototype.hasOwnProperty;d._parts=function(){return{protocol:null,username:null,password:null,hostname:null,urn:null,port:null,path:null,query:null,fragment:null,duplicateQueryParameters:d.duplicateQueryParameters}};d.duplicateQueryParameters=!1;d.protocol_expression=/^[a-z][a-z0-9-+-]*$/i;d.idn_expression=
/[^a-z0-9\.-]/i;d.punycode_expression=/(xn--)/i;d.ip4_expression=/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/;d.ip6_expression=/^\s*((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)){3}))|:)))(%.+)?\s*$/;
d.find_uri_expression=/\b((?:[a-z][\w-]+:(?:\/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'".,<>?\u00ab\u00bb\u201c\u201d\u2018\u2019]))/ig;d.defaultPorts={http:"80",https:"443",ftp:"21",gopher:"70",ws:"80",wss:"443"};d.invalid_hostname_characters=/[^a-zA-Z0-9\.-]/;d.encode=u;d.decode=decodeURIComponent;d.iso8859=function(){d.encode=escape;d.decode=unescape};d.unicode=function(){d.encode=
u;d.decode=decodeURIComponent};d.characters={pathname:{encode:{expression:/%(24|26|2B|2C|3B|3D|3A|40)/ig,map:{"%24":"$","%26":"&","%2B":"+","%2C":",","%3B":";","%3D":"=","%3A":":","%40":"@"}},decode:{expression:/[\/\?#]/g,map:{"/":"%2F","?":"%3F","#":"%23"}}},reserved:{encode:{expression:/%(21|23|24|26|27|28|29|2A|2B|2C|2F|3A|3B|3D|3F|40|5B|5D)/ig,map:{"%3A":":","%2F":"/","%3F":"?","%23":"#","%5B":"[","%5D":"]","%40":"@","%21":"!","%24":"$","%26":"&","%27":"'","%28":"(","%29":")","%2A":"*","%2B":"+",
"%2C":",","%3B":";","%3D":"="}}}};d.encodeQuery=function(a){return d.encode(a+"").replace(/%20/g,"+")};d.decodeQuery=function(a){return d.decode((a+"").replace(/\+/g,"%20"))};d.recodePath=function(a){a=(a+"").split("/");for(var b=0,c=a.length;b<c;b++)a[b]=d.encodePathSegment(d.decode(a[b]));return a.join("/")};d.decodePath=function(a){a=(a+"").split("/");for(var b=0,c=a.length;b<c;b++)a[b]=d.decodePathSegment(a[b]);return a.join("/")};var k={encode:"encode",decode:"decode"},j,q=function(a,b){return function(c){return d[b](c+
"").replace(d.characters[a][b].expression,function(c){return d.characters[a][b].map[c]})}};for(j in k)d[j+"PathSegment"]=q("pathname",k[j]);d.encodeReserved=q("reserved","encode");d.parse=function(a,b){var c;b||(b={});c=a.indexOf("#");-1<c&&(b.fragment=a.substring(c+1)||null,a=a.substring(0,c));c=a.indexOf("?");-1<c&&(b.query=a.substring(c+1)||null,a=a.substring(0,c));"//"===a.substring(0,2)?(b.protocol="",a=a.substring(2),a=d.parseAuthority(a,b)):(c=a.indexOf(":"),-1<c&&(b.protocol=a.substring(0,
c),b.protocol&&!b.protocol.match(d.protocol_expression)?b.protocol=void 0:"file"===b.protocol?a=a.substring(c+3):"//"===a.substring(c+1,c+3)?(a=a.substring(c+3),a=d.parseAuthority(a,b)):(a=a.substring(c+1),b.urn=!0)));b.path=a;return b};d.parseHost=function(a,b){var c=a.indexOf("/"),e;-1===c&&(c=a.length);"["===a[0]?(e=a.indexOf("]"),b.hostname=a.substring(1,e)||null,b.port=a.substring(e+2,c)||null):a.indexOf(":")!==a.lastIndexOf(":")?(b.hostname=a.substring(0,c)||null,b.port=null):(e=a.substring(0,
c).split(":"),b.hostname=e[0]||null,b.port=e[1]||null);b.hostname&&"/"!==a.substring(c)[0]&&(c++,a="/"+a);return a.substring(c)||"/"};d.parseAuthority=function(a,b){a=d.parseUserinfo(a,b);return d.parseHost(a,b)};d.parseUserinfo=function(a,b){var c=a.indexOf("@"),e=a.indexOf("/");-1<c&&(-1===e||c<e)?(e=a.substring(0,c).split(":"),b.username=e[0]?d.decode(e[0]):null,e.shift(),b.password=e[0]?d.decode(e.join(":")):null,a=a.substring(c+1)):(b.username=null,b.password=null);return a};d.parseQuery=function(a){if(!a)return{};
a=a.replace(/&+/g,"&").replace(/^\?*&*|&+$/g,"");if(!a)return{};var b={};a=a.split("&");for(var c=a.length,e,g,f=0;f<c;f++)e=a[f].split("="),g=d.decodeQuery(e.shift()),e=e.length?d.decodeQuery(e.join("=")):null,b[g]?("string"===typeof b[g]&&(b[g]=[b[g]]),b[g].push(e)):b[g]=e;return b};d.build=function(a){var b="";a.protocol&&(b+=a.protocol+":");if(!a.urn&&(b||a.hostname))b+="//";b+=d.buildAuthority(a)||"";"string"===typeof a.path&&("/"!==a.path[0]&&"string"===typeof a.hostname&&(b+="/"),b+=a.path);
"string"===typeof a.query&&a.query&&(b+="?"+a.query);"string"===typeof a.fragment&&a.fragment&&(b+="#"+a.fragment);return b};d.buildHost=function(a){var b="";if(a.hostname)d.ip6_expression.test(a.hostname)?b=a.port?b+("["+a.hostname+"]:"+a.port):b+a.hostname:(b+=a.hostname,a.port&&(b+=":"+a.port));else return"";return b};d.buildAuthority=function(a){return d.buildUserinfo(a)+d.buildHost(a)};d.buildUserinfo=function(a){var b="";a.username&&(b+=d.encode(a.username),a.password&&(b+=":"+d.encode(a.password)),
b+="@");return b};d.buildQuery=function(a,b){var c="",e,g,f,m;for(g in a)if(t.call(a,g)&&g)if(p(a[g])){e={};f=0;for(m=a[g].length;f<m;f++)void 0!==a[g][f]&&void 0===e[a[g][f]+""]&&(c+="&"+d.buildQueryParameter(g,a[g][f]),!0!==b&&(e[a[g][f]+""]=!0))}else void 0!==a[g]&&(c+="&"+d.buildQueryParameter(g,a[g]));return c.substring(1)};d.buildQueryParameter=function(a,b){return d.encodeQuery(a)+(null!==b?"="+d.encodeQuery(b):"")};d.addQuery=function(a,b,c){if("object"===typeof b)for(var e in b)t.call(b,
e)&&d.addQuery(a,e,b[e]);else if("string"===typeof b)void 0===a[b]?a[b]=c:("string"===typeof a[b]&&(a[b]=[a[b]]),p(c)||(c=[c]),a[b]=a[b].concat(c));else throw new TypeError("URI.addQuery() accepts an object, string as the name parameter");};d.removeQuery=function(a,b,c){var e;if(p(b)){c=0;for(e=b.length;c<e;c++)a[b[c]]=void 0}else if("object"===typeof b)for(e in b)t.call(b,e)&&d.removeQuery(a,e,b[e]);else if("string"===typeof b)if(void 0!==c)if(a[b]===c)a[b]=void 0;else{if(p(a[b])){e=a[b];var g={},
f,m;if(p(c)){f=0;for(m=c.length;f<m;f++)g[c[f]]=!0}else g[c]=!0;f=0;for(m=e.length;f<m;f++)void 0!==g[e[f]]&&(e.splice(f,1),m--,f--);a[b]=e}}else a[b]=void 0;else throw new TypeError("URI.addQuery() accepts an object, string as the first parameter");};d.commonPath=function(a,b){var c=Math.min(a.length,b.length),e;for(e=0;e<c;e++)if(a[e]!==b[e]){e--;break}if(1>e)return a[0]===b[0]&&"/"===a[0]?"/":"";"/"!==a[e]&&(e=a.substring(0,e).lastIndexOf("/"));return a.substring(0,e+1)};d.withinString=function(a,
b){return a.replace(d.find_uri_expression,b)};d.ensureValidHostname=function(a){if(a.match(d.invalid_hostname_characters)){if(!l)throw new TypeError("Hostname '"+a+"' contains characters other than [A-Z0-9.-] and Punycode.js is not available");if(l.toASCII(a).match(d.invalid_hostname_characters))throw new TypeError("Hostname '"+a+"' contains characters other than [A-Z0-9.-]");}};f.build=function(a){if(!0===a)this._deferred_build=!0;else if(void 0===a||this._deferred_build)this._string=d.build(this._parts),
this._deferred_build=!1;return this};f.clone=function(){return new d(this)};f.valueOf=f.toString=function(){return this.build(!1)._string};k={protocol:"protocol",username:"username",password:"password",hostname:"hostname",port:"port"};q=function(a){return function(b,c){if(void 0===b)return this._parts[a]||"";this._parts[a]=b;this.build(!c);return this}};for(j in k)f[j]=q(k[j]);k={query:"?",fragment:"#"};q=function(a,b){return function(c,e){if(void 0===c)return this._parts[a]||"";null!==c&&(c+="",
c[0]===b&&(c=c.substring(1)));this._parts[a]=c;this.build(!e);return this}};for(j in k)f[j]=q(j,k[j]);k={search:["?","query"],hash:["#","fragment"]};q=function(a,b){return function(c,e){var d=this[a](c,e);return"string"===typeof d&&d.length?b+d:d}};for(j in k)f[j]=q(k[j][1],k[j][0]);f.pathname=function(a,b){if(void 0===a||!0===a){var c=this._parts.path||(this._parts.urn?"":"/");return a?d.decodePath(c):c}this._parts.path=a?d.recodePath(a):"/";this.build(!b);return this};f.path=f.pathname;f.href=function(a,
b){var c;if(void 0===a)return this.toString();this._string="";this._parts=d._parts();var e=a instanceof d,g="object"===typeof a&&(a.hostname||a.path);!e&&(g&&"[object Object]"!==Object.prototype.toString.call(a))&&(a=a.toString());if("string"===typeof a)this._parts=d.parse(a,this._parts);else if(e||g)for(c in e=e?a._parts:a,e)t.call(this._parts,c)&&(this._parts[c]=e[c]);else throw new TypeError("invalid input");this.build(!b);return this};f.is=function(a){var b=!1,c=!1,e=!1,g=!1,f=!1,m=!1,j=!1,k=
!this._parts.urn;this._parts.hostname&&(k=!1,c=d.ip4_expression.test(this._parts.hostname),e=d.ip6_expression.test(this._parts.hostname),b=c||e,f=(g=!b)&&r&&r.has(this._parts.hostname),m=g&&d.idn_expression.test(this._parts.hostname),j=g&&d.punycode_expression.test(this._parts.hostname));switch(a.toLowerCase()){case "relative":return k;case "absolute":return!k;case "domain":case "name":return g;case "sld":return f;case "ip":return b;case "ip4":case "ipv4":case "inet4":return c;case "ip6":case "ipv6":case "inet6":return e;
case "idn":return m;case "url":return!this._parts.urn;case "urn":return!!this._parts.urn;case "punycode":return j}return null};var v=f.protocol,w=f.port,x=f.hostname;f.protocol=function(a,b){if(void 0!==a&&a&&(a=a.replace(/:(\/\/)?$/,""),a.match(/[^a-zA-z0-9\.+-]/)))throw new TypeError("Protocol '"+a+"' contains characters other than [A-Z0-9.+-]");return v.call(this,a,b)};f.scheme=f.protocol;f.port=function(a,b){if(this._parts.urn)return void 0===a?"":this;if(void 0!==a&&(0===a&&(a=null),a&&(a+="",
":"===a[0]&&(a=a.substring(1)),a.match(/[^0-9]/))))throw new TypeError("Port '"+a+"' contains characters other than [0-9]");return w.call(this,a,b)};f.hostname=function(a,b){if(this._parts.urn)return void 0===a?"":this;if(void 0!==a){var c={};d.parseHost(a,c);a=c.hostname}return x.call(this,a,b)};f.host=function(a,b){if(this._parts.urn)return void 0===a?"":this;if(void 0===a)return this._parts.hostname?d.buildHost(this._parts):"";d.parseHost(a,this._parts);this.build(!b);return this};f.authority=
function(a,b){if(this._parts.urn)return void 0===a?"":this;if(void 0===a)return this._parts.hostname?d.buildAuthority(this._parts):"";d.parseAuthority(a,this._parts);this.build(!b);return this};f.userinfo=function(a,b){if(this._parts.urn)return void 0===a?"":this;if(void 0===a){if(!this._parts.username)return"";var c=d.buildUserinfo(this._parts);return c.substring(0,c.length-1)}"@"!==a[a.length-1]&&(a+="@");d.parseUserinfo(a,this._parts);this.build(!b);return this};f.resource=function(a,b){var c;
if(void 0===a)return this.path()+this.search()+this.hash();c=d.parse(a);this._parts.path=c.path;this._parts.query=c.query;this._parts.fragment=c.fragment;this.build(!b);return this};f.subdomain=function(a,b){if(this._parts.urn)return void 0===a?"":this;if(void 0===a){if(!this._parts.hostname||this.is("IP"))return"";var c=this._parts.hostname.length-this.domain().length-1;return this._parts.hostname.substring(0,c)||""}c=this._parts.hostname.length-this.domain().length;c=this._parts.hostname.substring(0,
c);c=RegExp("^"+n(c));a&&"."!==a[a.length-1]&&(a+=".");a&&d.ensureValidHostname(a);this._parts.hostname=this._parts.hostname.replace(c,a);this.build(!b);return this};f.domain=function(a,b){if(this._parts.urn)return void 0===a?"":this;"boolean"===typeof a&&(b=a,a=void 0);if(void 0===a){if(!this._parts.hostname||this.is("IP"))return"";var c=this._parts.hostname.match(/\./g);if(c&&2>c.length)return this._parts.hostname;c=this._parts.hostname.length-this.tld(b).length-1;c=this._parts.hostname.lastIndexOf(".",
c-1)+1;return this._parts.hostname.substring(c)||""}if(!a)throw new TypeError("cannot set domain empty");d.ensureValidHostname(a);!this._parts.hostname||this.is("IP")?this._parts.hostname=a:(c=RegExp(n(this.domain())+"$"),this._parts.hostname=this._parts.hostname.replace(c,a));this.build(!b);return this};f.tld=function(a,b){if(this._parts.urn)return void 0===a?"":this;"boolean"===typeof a&&(b=a,a=void 0);if(void 0===a){if(!this._parts.hostname||this.is("IP"))return"";var c=this._parts.hostname.lastIndexOf("."),
c=this._parts.hostname.substring(c+1);return!0!==b&&r&&r.list[c.toLowerCase()]?r.get(this._parts.hostname)||c:c}if(a)if(a.match(/[^a-zA-Z0-9-]/))if(r&&r.is(a))c=RegExp(n(this.tld())+"$"),this._parts.hostname=this._parts.hostname.replace(c,a);else throw new TypeError("TLD '"+a+"' contains characters other than [A-Z0-9]");else{if(!this._parts.hostname||this.is("IP"))throw new ReferenceError("cannot set TLD on non-domain host");c=RegExp(n(this.tld())+"$");this._parts.hostname=this._parts.hostname.replace(c,
a)}else throw new TypeError("cannot set TLD empty");this.build(!b);return this};f.directory=function(a,b){if(this._parts.urn)return void 0===a?"":this;if(void 0===a||!0===a){if(!this._parts.path&&!this._parts.hostname)return"";if("/"===this._parts.path)return"/";var c=this._parts.path.length-this.filename().length-1,c=this._parts.path.substring(0,c)||(this._parts.hostname?"/":"");return a?d.decodePath(c):c}c=this._parts.path.length-this.filename().length;c=this._parts.path.substring(0,c);c=RegExp("^"+
n(c));this.is("relative")||(a||(a="/"),"/"!==a[0]&&(a="/"+a));a&&"/"!==a[a.length-1]&&(a+="/");a=d.recodePath(a);this._parts.path=this._parts.path.replace(c,a);this.build(!b);return this};f.filename=function(a,b){if(this._parts.urn)return void 0===a?"":this;if(void 0===a||!0===a){if(!this._parts.path||"/"===this._parts.path)return"";var c=this._parts.path.lastIndexOf("/"),c=this._parts.path.substring(c+1);return a?d.decodePathSegment(c):c}c=!1;"/"===a[0]&&(a=a.substring(1));a.match(/\.?\//)&&(c=!0);
var e=RegExp(n(this.filename())+"$");a=d.recodePath(a);this._parts.path=this._parts.path.replace(e,a);c?this.normalizePath(b):this.build(!b);return this};f.suffix=function(a,b){if(this._parts.urn)return void 0===a?"":this;if(void 0===a||!0===a){if(!this._parts.path||"/"===this._parts.path)return"";var c=this.filename(),e=c.lastIndexOf(".");if(-1===e)return"";c=c.substring(e+1);c=/^[a-z0-9%]+$/i.test(c)?c:"";return a?d.decodePathSegment(c):c}"."===a[0]&&(a=a.substring(1));if(c=this.suffix())e=a?RegExp(n(c)+
"$"):RegExp(n("."+c)+"$");else{if(!a)return this;this._parts.path+="."+d.recodePath(a)}e&&(a=d.recodePath(a),this._parts.path=this._parts.path.replace(e,a));this.build(!b);return this};f.segment=function(a,b,c){var d=this._parts.urn?":":"/",g=this.path(),f="/"===g.substring(0,1),g=g.split(d);"number"!==typeof a&&(c=b,b=a,a=void 0);if(void 0!==a&&"number"!==typeof a)throw Error("Bad segment '"+a+"', must be 0-based integer");f&&g.shift();0>a&&(a=Math.max(g.length+a,0));if(void 0===b)return void 0===
a?g:g[a];if(null===a||void 0===g[a])if(p(b))g=b;else{if(b||"string"===typeof b&&b.length)""===g[g.length-1]?g[g.length-1]=b:g.push(b)}else b||"string"===typeof b&&b.length?g[a]=b:g.splice(a,1);f&&g.unshift("");return this.path(g.join(d),c)};var y=f.query;f.query=function(a,b){return!0===a?d.parseQuery(this._parts.query):void 0!==a&&"string"!==typeof a?(this._parts.query=d.buildQuery(a,this._parts.duplicateQueryParameters),this.build(!b),this):y.call(this,a,b)};f.addQuery=function(a,b,c){var e=d.parseQuery(this._parts.query);
d.addQuery(e,a,void 0===b?null:b);this._parts.query=d.buildQuery(e,this._parts.duplicateQueryParameters);"string"!==typeof a&&(c=b);this.build(!c);return this};f.removeQuery=function(a,b,c){var e=d.parseQuery(this._parts.query);d.removeQuery(e,a,b);this._parts.query=d.buildQuery(e,this._parts.duplicateQueryParameters);"string"!==typeof a&&(c=b);this.build(!c);return this};f.addSearch=f.addQuery;f.removeSearch=f.removeQuery;f.normalize=function(){return this._parts.urn?this.normalizeProtocol(!1).normalizeQuery(!1).normalizeFragment(!1).build():
this.normalizeProtocol(!1).normalizeHostname(!1).normalizePort(!1).normalizePath(!1).normalizeQuery(!1).normalizeFragment(!1).build()};f.normalizeProtocol=function(a){"string"===typeof this._parts.protocol&&(this._parts.protocol=this._parts.protocol.toLowerCase(),this.build(!a));return this};f.normalizeHostname=function(a){this._parts.hostname&&(this.is("IDN")&&l?this._parts.hostname=l.toASCII(this._parts.hostname):this.is("IPv6")&&s&&(this._parts.hostname=s.best(this._parts.hostname)),this._parts.hostname=
this._parts.hostname.toLowerCase(),this.build(!a));return this};f.normalizePort=function(a){"string"===typeof this._parts.protocol&&this._parts.port===d.defaultPorts[this._parts.protocol]&&(this._parts.port=null,this.build(!a));return this};f.normalizePath=function(a){if(this._parts.urn||!this._parts.path||"/"===this._parts.path)return this;var b,c,e=this._parts.path,f,h;"/"!==e[0]&&("."===e[0]&&(c=e.substring(0,e.indexOf("/"))),b=!0,e="/"+e);for(e=e.replace(/(\/(\.\/)+)|\/{2,}/g,"/");;){f=e.indexOf("/../");
if(-1===f)break;else if(0===f){e=e.substring(3);break}h=e.substring(0,f).lastIndexOf("/");-1===h&&(h=f);e=e.substring(0,h)+e.substring(f+3)}b&&this.is("relative")&&(e=c?c+e:e.substring(1));e=d.recodePath(e);this._parts.path=e;this.build(!a);return this};f.normalizePathname=f.normalizePath;f.normalizeQuery=function(a){"string"===typeof this._parts.query&&(this._parts.query.length?this.query(d.parseQuery(this._parts.query)):this._parts.query=null,this.build(!a));return this};f.normalizeFragment=function(a){this._parts.fragment||
(this._parts.fragment=null,this.build(!a));return this};f.normalizeSearch=f.normalizeQuery;f.normalizeHash=f.normalizeFragment;f.iso8859=function(){var a=d.encode,b=d.decode;d.encode=escape;d.decode=decodeURIComponent;this.normalize();d.encode=a;d.decode=b;return this};f.unicode=function(){var a=d.encode,b=d.decode;d.encode=u;d.decode=unescape;this.normalize();d.encode=a;d.decode=b;return this};f.readable=function(){var a=this.clone();a.username("").password("").normalize();var b="";a._parts.protocol&&
(b+=a._parts.protocol+"://");a._parts.hostname&&(a.is("punycode")&&l?(b+=l.toUnicode(a._parts.hostname),a._parts.port&&(b+=":"+a._parts.port)):b+=a.host());a._parts.hostname&&(a._parts.path&&"/"!==a._parts.path[0])&&(b+="/");b+=a.path(!0);if(a._parts.query){for(var c="",e=0,f=a._parts.query.split("&"),h=f.length;e<h;e++){var j=(f[e]||"").split("="),c=c+("&"+d.decodeQuery(j[0]).replace(/&/g,"%26"));void 0!==j[1]&&(c+="="+d.decodeQuery(j[1]).replace(/&/g,"%26"))}b+="?"+c.substring(1)}return b+=a.hash()};
f.absoluteTo=function(a){var b=this.clone(),c=["protocol","username","password","hostname","port"],e,f;if(this._parts.urn)throw Error("URNs do not have any generally defined hierachical components");if(this._parts.hostname)return b;a instanceof d||(a=new d(a));e=0;for(f;f=c[e];e++)b._parts[f]=a._parts[f];c=["query","path"];e=0;for(f;f=c[e];e++)!b._parts[f]&&a._parts[f]&&(b._parts[f]=a._parts[f]);"/"!==b.path()[0]&&(a=a.directory(),b._parts.path=(a?a+"/":"")+b._parts.path,b.normalizePath());b.build();
return b};f.relativeTo=function(a){var b=this.clone(),c=["protocol","username","password","hostname","port"],e;if(this._parts.urn)throw Error("URNs do not have any generally defined hierachical components");a instanceof d||(a=new d(a));if("/"!==this.path()[0]||"/"!==a.path()[0])throw Error("Cannot calculate common path from non-relative URLs");e=d.commonPath(b.path(),a.path());if(!e||"/"===e)return b;for(var f=0,h;h=c[f];f++)b._parts[h]=null;a=a.directory();c=this.directory();if(a===c)return b._parts.path=
"./"+b.filename(),b.build();a.substring(e.length);c=c.substring(e.length);if(a+"/"===e)return c&&(c+="/"),b._parts.path="./"+c+b.filename(),b.build();c="../";e=RegExp("^"+n(e));for(a=a.replace(e,"/").match(/\//g).length-1;a--;)c+="../";b._parts.path=b._parts.path.replace(e,c);return b.build()};f.equals=function(a){var b=this.clone(),c=new d(a),e={},f={};a={};var h;b.normalize();c.normalize();if(b.toString()===c.toString())return!0;e=b.query();f=c.query();b.query("");c.query("");if(b.toString()!==
c.toString()||e.length!==f.length)return!1;e=d.parseQuery(e);f=d.parseQuery(f);for(h in e)if(t.call(e,h)){if(p(e[h])){if(!p(f[h])||e[h].length!==f[h].length)return!1;e[h].sort();f[h].sort();b=0;for(c=e[h].length;b<c;b++)if(e[h][b]!==f[h][b])return!1}else if(e[h]!==f[h])return!1;a[h]=!0}for(h in f)if(t.call(f,h)&&!a[h])return!1;return!0};f.duplicateQueryParameters=function(a){this._parts.duplicateQueryParameters=!!a;return this};return d});