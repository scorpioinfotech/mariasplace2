jQuery(document).ready( function($) {
    $('.tdp_fav-link').live('click', function() {
        dhis = $(this);
        tdp_fav_do_js( dhis, 1 );
        // for favorite post listing page
        if (dhis.hasClass('remove-parent')) {
            dhis.parent("td").parent("tr").fadeOut();
        }
        return false;
    });
});

function tdp_fav_do_js( dhis, doAjax ) {
    loadingImg = dhis.prev();
    loadingImg.show();
    beforeImg = dhis.prev().prev();
    beforeImg.hide();
    url = document.location.href.split('#')[0];
    params = dhis.attr('href').replace('?', '') + '&ajax=1';
    if ( doAjax ) {
        jQuery.get(url, params, function(data) {
                dhis.parent().html(data);
                if(typeof tdp_fav_after_ajax == 'function') {
                    tdp_fav_after_ajax( dhis ); // use this like a wp action.
                }
                loadingImg.hide();
            }
        );
    }
}
