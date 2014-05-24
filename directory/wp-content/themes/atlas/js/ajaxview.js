(function ($) {

    /** jQuery Document Ready */
    $(document).ready(function () {

        $("a.ajax-sort").click(function(){
            $(this).attr("clicked", "yes");
        });

        $('a.ajax-sort, #query-sort').bind('click change', function (e) {

            /** Prevent Default Behaviour */
            e.preventDefault();

            /** Get Query Parameters */
            var sort_query = $('#query-sort').val();

            //Determine if view sorting has been selected
            if ( $(this).attr('clicked') == 'yes' ) {
                
                var click = 'yes';
                var sorting_method = $(this).data('sort');
                var term_id = $(this).data('term-id');
                var taxonomy = $(this).data('taxonomy');
                var paged = $(this).data('paged');

            } else {
                
                var click = 'no';
                var sorting_method = $('a.ajax-sort:last-child').data('sort');
                var term_id = $('a.ajax-sort:last-child').data('term-id');
                var taxonomy = $('a.ajax-sort:last-child').data('taxonomy');
                var paged = $('a.ajax-sort:last-child').data('paged');

            }

            /** Ajax Call */
            $.ajax({

                cache: false,
                timeout: 8000,
                url: ajaxpath.admin_ajax,
                type: "POST",
                data: ({
                    action: 'theme_post_example',
                    sort: sorting_method,
                    term: term_id,
                    taxonomy: taxonomy,
                    paged: paged,
                    sort_query: sort_query,
                    clicked: click
                }),

                beforeSend: function () {
                    //$('#ajax-response').html('Loading');
                    $('#listings-wrapper').before('<div class="tax-loader"></div>');
                    $('#listings-wrapper .single-listing').remove();
                    $('#listings-wrapper .grid-column').remove();
                },

                success: function (data, textStatus, jqXHR) {

                    var $ajax_response = $(data);
                    $('.tax-loader').remove();
                    $('#listings-wrapper').html($ajax_response);
                    //$('#listings-wrapper').after(click);

                },

                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('The following error occured: ' + textStatus, errorThrown);
                },

                complete: function (jqXHR, textStatus) {}

            });

        });

    });

})(jQuery);