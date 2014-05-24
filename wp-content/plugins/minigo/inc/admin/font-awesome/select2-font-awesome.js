// (function() {
//     'use strict';
//
//     $('.select2-container.font-awesome-icons').
// })()

/* global redux_change */
(function($){
    "use strict";

    $.redux = $.redux || {};

    $(document).ready(function () {
         $.redux.select3();
    });

    $('.redux-groups-add').click(function () {
        setTimeout(function() {$.redux.select3();}, 500);
    });

    $.redux.select3 = function() {
        $('select.redux-select-item').each(function() {
            var select = $(this);
            if(!select.hasClass('font-awesome-icons')) {
                return;
            }

            var default_params = {
                width: 'resolve',
                triggerChange: true,
                allowClear: true
            };

            if ( select.siblings('.select2_params').size() > 0 ) {
                var select2_params = select.siblings('.select2_params').val();
                select2_params = JSON.parse( select2_params );
                default_params = $.extend({}, default_params, select2_params);
            }

            if ( select.hasClass('font-awesome-icons') ) {
                default_params = $.extend({}, {formatResult: addIconToSelect, formatSelection: addIconToSelect, escapeMarkup: function(m) { return m; } }, default_params);
            }
            select.select2(default_params);
            if (select.hasClass('select2-sortable')) {
                default_params = {};
                default_params.bindOrder = 'sortableStop';
                default_params.sortableOptions = { placeholder : 'ui-state-highlight' };
                select.select2Sortable(default_params);
            }

            select.on("change", function() {
                redux_change($($(this)));
                $(this).select2SortableOrder();
            });

        });
    };

    function addIconToSelect(icon) {
        if ( icon.hasOwnProperty( 'id' ) ) {
            return "<i class='fa " + icon.id + "'></i>" + "&nbsp;&nbsp;" + icon.id.toUpperCase();
        }
    }
})(jQuery);