jQuery(function() {

    jQuery(document).ready(function($){

        $('.likes_log_table').flexigrid({
            url: userSettings.url + 'wp-content/plugins/bbpress-like-button/json_logs.php',
            dataType: 'json',
            colModel:[
                {display: $('#flex_col_caption_2').html(), name:'user_id', sortable: false, sortorder: 'asc', width: 100},
                {display: $('#flex_col_caption_3').html(), name:'post_id', sortable:false, width: 300},
                {display: $('#flex_col_caption_4').html(), name:'link', sortable:false, width: 100}
            ],
            sortorder: 'desc',
            usepager: true,
            useRp: true,
            rp: 1000,
            showTableToggleBtn: true,
            singleSelect: true,
            width: 700,
            height: 200
        });
        
        function delete_like(com, grid){
            var data = {
                action: 'delete_like',
                id: $('.trSelected td:first-child div').text()
            };
            $.post(ajaxurl, data, function(response){
                $('.likes_log_table').flexReload();
            });
        }
        
        $("span.who_liked[title]").tooltip({
            position: 'center right'
        });
        
    });


});