function base64_decode (data) {
  var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
  var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
    ac = 0,
    dec = "",
    tmp_arr = [];

  if (!data) {
    return data;
  }

  data += '';

  do { // unpack four hexets into three octets using index points in b64
    h1 = b64.indexOf(data.charAt(i++));
    h2 = b64.indexOf(data.charAt(i++));
    h3 = b64.indexOf(data.charAt(i++));
    h4 = b64.indexOf(data.charAt(i++));

    bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;

    o1 = bits >> 16 & 0xff;
    o2 = bits >> 8 & 0xff;
    o3 = bits & 0xff;

    if (h3 == 64) {
      tmp_arr[ac++] = String.fromCharCode(o1);
    } else if (h4 == 64) {
      tmp_arr[ac++] = String.fromCharCode(o1, o2);
    } else {
      tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
    }
  } while (i < data.length);

  dec = tmp_arr.join('');

  return dec;
}

function rawurldecode (str) {
    return decodeURIComponent((str + '').replace(/%(?![\da-f]{2})/gi, function () {
        // PHP tolerates poorly formed escape sequences
        return '%25';
    }));
}

jQuery(document).ready(function($){
	var galleries = $('.ilightbox_gallery'),
		jetpackGalleries = $('.tiled-gallery'),
		nextGenGalleries = $('.ngg-galleryoverview');
		
	if(galleries.length){
		galleries.each(function(){
			var t = $(this),
			kid = $('a[source]', t),
			options = t.data("options") && eval("(" + t.data("options") + ")") || {};
			kid.iLightBox(options);
		});
	}

	if(jetpackGalleries.length && ILIGHTBOX.jetPack){
		jetpackGalleries.each(function(){
			var t = $(this),
			kid = $('a', t),
			options = ILIGHTBOX.options && eval("(" + rawurldecode(ILIGHTBOX.options) + ")") || {};
			options.attr = 'source';

			kid.each(function(i){
				var $this = $(this),
					$img = $('img', $this),
					origFile = $img.data('orig-file');

				$this.attr('source', origFile);
			});

			kid.iLightBox(options);
		});
	}

	if(nextGenGalleries.length && ILIGHTBOX.nextGEN){
		nextGenGalleries.each(function(){
			var t = $(this),
			kid = $('.ngg-gallery-thumbnail a', t),
			options = ILIGHTBOX.options && eval("(" + rawurldecode(ILIGHTBOX.options) + ")") || {};

			kid.each(function(i){
				var $this = $(this);

				$this[0].onclick = null;
			});

			kid.iLightBox(options);
		});
	}

	$(document).on('click', '.ilightbox_inline_gallery', function(){
		var t = $(this),
		slides = t.data("slides") && eval("(" + rawurldecode(base64_decode(t.data("slides"))) + ")") || [];
		options = t.data("options") && eval("(" + rawurldecode(base64_decode(t.data("options"))) + ")") || {};
		$.iLightBox(slides, options);
	});
});
