function is_downloaded(id){
	if( rh_downloaded.length > 0 ){
		for( var a=0; a<rh_downloaded.length ; a++ ){
			if( id==rh_downloaded[a] ){
				return true;
			}
		}
	}
	return false;
}

function rh_in_array(needle,haystack){
	if( haystack.length > 0 ){
		for (var i in haystack) {
			if( needle==haystack[i] ){
				return true;
			}		
		}
	}
	return false;
}

function get_bundles(){
	jQuery('#install-message').empty().append('<div class="row-message"><span>Requesting downloadable content list, please wait...</span></div>');
	jQuery('#installing').fadeIn();
		
	var args = {
		action:'rh_get_bundles_'+rh_download_panel_id
	};

	if( rh_bundles.length>0 ){
		tmp = [];
		jQuery.each(rh_bundles,function(i,o){
			tmp[tmp.length]={
				id: o.id,
				type: o.type,
				name: o.name,
				recent: o.recent,
				description: o.description,
				url: o.url,
				version: o.version,
				status: o.status,
				downloaded: is_downloaded(o.id),
				addon_path: o.addon_path,
				image: o.image
			};
		});
		jQuery('#installing').hide();
		populate_bundles(tmp);
		return;
	}
	
	jQuery.ajax({
		type: 'POST',
		url: ajaxurl,
		data: args,
		success: function(data){
			jQuery('#installing').hide();
			if(data.R=='OK'){
				rh_bundles = [];
				jQuery.each(data.BUNDLES,function(i,o){
					rh_bundles[rh_bundles.length]={
						id: o.id,
						type: o.type,
						name: o.name,
						recent: o.recent,
						description: o.description,
						url: o.url,
						version: o.version,
						status: o.status,
						downloaded: is_downloaded(o.id),
						addon_path: o.addon_path,
						image: o.image
					};
				
					data.BUNDLES[i].downloaded = is_downloaded(o.id);
				});		
				populate_bundles(data.BUNDLES);
			}else if(data.R=='ERR'){
				jQuery('#messages').removeClass('updated').addClass('error').html(data.MSG);
			}else{
			
			}	
		},
		error: function(jqXHR, textStatus, errorThrown){
			jQuery('#installing').hide();
			jQuery('#messages').removeClass('updated').addClass('error').html('Service not available please try again later. Error status: '+textStatus+', and error message: '+errorThrown);
		},
		dataType: 'json'
	});		
}

var populating_bundle = false;
function populate_bundles(bundles){
	if(bundles.length>0 && !populating_bundle){
		jQuery(document).ready(function($){		
			populating_bundle = true;
			$('#bundles').isotope('remove', $('#bundles .pop-dlc-item') ).isotope('reLayout');
			var filtered_bundle = [];
			//--
			if(rh_filter=='new'){
				$.each(bundles,function(i,o){
					if( o.recent==1 ){
						filtered_bundle[ filtered_bundle.length ] = o;
					}
				});
			}else if(rh_filter=='downloaded' && rh_downloaded.length>0){
				$.each(bundles,function(i,o){
					if( is_downloaded(o.id) ){
					//if( rh_downloaded.in_array(o.id) ){
						filtered_bundle[ filtered_bundle.length ] = o;
					}
				});
			}else{
				filtered_bundle = bundles;
			}
			add_bundle(filtered_bundle);
		});
	}
}

function add_bundle(bundles){
	if(bundles.length>0){
		jQuery(document).ready(function($){
			o=bundles.shift();

			var retina = typeof window.devicePixelRatio!='undefined' && window.devicePixelRatio > 1;
			var src = o.image;
			if(retina){
				arr = o.image.split('.');
				if(arr.length>=2){
					arr[arr.length-2] = arr[arr.length-2] + '@2x';		
					src = arr.join('.');
				}			
			}
			
			template = $('#pop-dlc-item-template .pop-dlc-item').clone();
			template
				.attr('id', 'pop-dlc-item-' + o.id )
				.addClass( (o.downloaded?'dlc-downloaded':'dlc-not-downloaded') )
				.addClass( (o.recent=='1'?'dlc-recent':'dlc-not-recent') )
				.find('.pop-dlc-name').html(o.name).end()
				.find('.pop-dlc-version').html(o.version).end()
				.find('.pop-dlc-description').html(o.description).end()
				.find('.pop-dlc-filesize').html(readablizeBytes(o.filesize)).end()
				.find('.pop-dlc-image')
					.attr('href',o.url)
					.end()
				.find('.pop-dlc-image img')
					.attr('src',src)
					.end()
				.find('.btn-visit-site')
					.attr('href',o.url)
					.end()
				.find('.btn-download')
					.attr('rel',o.id)
					.on('click',function(e){download_bundle(e);})
					.end()
				.find('.dlc-addon-control')
					.data('addon_path',o.addon_path)
					.end()
				//.appendTo('#bundles')
			;

			if(o.image==null || o.image==''){
				template.find('.pop-dlc-image').hide();
			}
		
			if(o.addon_path!=null && o.addon_path!=''){
				template.addClass('dlc-addon');	
			}
		
			if(o.addon_path==null || $.inArray(o.addon_path,rh_installed_addons)==-1 ){
				template.find('.dlc-addon-control').hide();
			}else{			
				if( $.inArray(o.addon_path,rh_active_addons)>-1 ){			
					template
						.find('.dlc-addon-control .enable-addon')
						.addClass('btn-success')
						.addClass('active')
						.end()
						.find('.dlc-addon-control .disable-addon')
						.removeClass('btn-danger')
						.removeClass('active')
						.end()
					;	
				}else{
					template
						.find('.dlc-addon-control .enable-addon')
						.removeClass('btn-success')
						.removeClass('active')
						.end()
						.find('.dlc-addon-control .disable-addon')
						.addClass('btn-danger')
						.addClass('active')
						.end()
					;				
				}
				
				template.find('.dlc-addon-control .enable-addon')
					.attr('id','btn_enable_addon_' + o.id)	
					.on('click',function(e){
						el_id = $(this).attr('id');
						plugin = $(this).parent().data('addon_path');
						dlc_activate_addon( plugin, el_id, true );
					})
				;
				template.find('.dlc-addon-control .disable-addon')
					.attr('id','btn_disable_addon_' + o.id)	
					.on('click',function(e){
						el_id = $(this).attr('id');
						plugin = $(this).parent().data('addon_path');
						dlc_activate_addon( plugin, el_id, false );
					})
				;
			}
			
			$('#bundles').isotope('insert', template);
			
			add_bundle(bundles);
		});
	}else{
		populating_bundle = false;
	}		
}

function download_bundle(e){
	jQuery(document).ready(function($){
		$('#install-message').empty().append('<div class="row-message"><span>Downloading content...</span></div>');
		$('#installing').fadeIn();
		var id = jQuery(e.target).attr('rel');
		var args = {
			action:'rh_download_bundle_'+rh_download_panel_id,
			id:id
		};
		
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: args,
			success: function(data){			
				$('#installing').hide();			
				if(data.R=='OK'){
					if( !is_downloaded(id) ){
						rh_downloaded[rh_downloaded.length]=id;
					}
					$('#messages').removeClass('error').addClass('updated').html(data.MSG);
					
					window.location.reload();
				}else if(data.R=='ERR'){
					$('#messages').removeClass('updated').addClass('error').html(data.MSG);
				}else{
					$('#messages').removeClass('updated').addClass('error').html('Invalid ajax response, please try again.');	
				}
			},
			error: function(jqXHR, textStatus, errorThrown){
				$('#installing').hide();
				$('#messages').removeClass('updated').addClass('error').html('Operation returned error status: '+textStatus+', and error message: '+errorThrown);
			},
			dataType: 'json'
		});	
	});	
}

function readablizeBytes(bytes){
	if(bytes==null||bytes=='')return'0 bytes';
	try{
	    var s = ['bytes', 'kb', 'MB', 'GB', 'TB', 'PB'];
	    var e = Math.floor(Math.log(bytes)/Math.log(1024));
	    return (bytes/Math.pow(1024, Math.floor(e))).toFixed(2)+" "+s[e];	
	}catch(e){}
	return '';
}

function dlc_activate_addon( plugin, el_id, activate ){
	jQuery(document).ready(function($){
		var args = {
			action:'dlc_activate_addon_'+rh_download_panel_id,
			plugin: plugin,
			activate: activate ? 1 : 0,
			el_id: el_id
		}

		$.post( ajaxurl, args, function(data){
			if(data.R=='OK'){
				if( activate ){
					$('#'+el_id).parent().find('.btn.enable-addon')
						.addClass('btn-success')
					;
					$('#'+el_id).parent().find('.btn.disable-addon')
						.removeClass('btn-danger')
					;
				}else{
					$('#'+el_id).parent().find('.btn.enable-addon')
						.removeClass('btn-success')
					;
					$('#'+el_id).parent().find('.btn.disable-addon')
						.addClass('btn-danger')
					;	
				}
				window.location.reload();
				return;
			}else if(data.R=='ERR'){
				alert(data.MSG);
			}else{
				alert('Error saving, reload page and try again.');
			}
			$('#'+el_id).parent().find('.btn.active').removeClass('active');
		}, 'json');		
	});
}