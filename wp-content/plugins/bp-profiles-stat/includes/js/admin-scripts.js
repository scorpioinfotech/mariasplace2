jQuery('#bpps-admin').ready(function(){

    /*
    jQuery('#sticky').stickySidebar({
        speed: 200,
        padding: 40
    });
    */
    
    /**
     * Dashboard events
     */
    // checkbox handler
    jQuery('#bpps-admin .users_count input[name="display_hidden_users_count"]').click(function(){
        if(jQuery(this).attr('checked') == 'checked'){
            jQuery('#bpps-admin .users_count ul li.hide').css('display', 'block');
        }else{
            jQuery('#bpps-admin .users_count ul li.hide').css('display', 'none');
        }
    });

    // track "more" link click
    jQuery('#bpps-admin .users_bad a.more').click(function(e){
        e.preventDefault;

        // get params
        var type = jQuery(this).data('type');
        var page = 1;

        bpps_get_dash_users_list(type, page);
    });

    // paginating through selected results
    jQuery('#bpps-admin .generic .pagination-links a').live('click', function(e){
        e.preventDefault();

        var type = jQuery(this).parents().data('type');
        var page = parseInt(jQuery(this).text());
        
        // is NaN when clicked on an arrow
        if(isNaN(page)){
            var current = parseInt(jQuery('#bpps-admin .generic .pagination-links .current').text());
            if(jQuery(this).hasClass('next')){
                page = current + 1;
            }else if(jQuery(this).hasClass('prev')){
                page = current - 1;
            }
        }

        bpps_get_dash_users_list(type, page);
    });

    // process the ajax to get the users list
    function bpps_get_dash_users_list(type, page){
        var generic = jQuery('#bpps-admin .generic');
        
        generic.addClass('loading');

        // send ajax request
        jQuery.ajax({
            type: 'GET',
            url:  ajaxurl,
            data: {
                action: 'bpps_ajax',
                method: 'get_users',
                type:   type,
                page:   page
            },
            success: function(response){
                generic.html(response);
            },
            complete: function(){
                generic.removeClass('loading');
            }
        });
    }

    /**
     * PROFILES 
     */
    var bpps_admin_placeholder = jQuery("#bpps-admin #graph");
    
    // Ajax loading better display
    bpps_admin_placeholder.ajaxStart(function(){
        bpps_admin_placeholder.html('');
        jQuery(this).css('background', '');
        jQuery(this).addClass('loading');
    });
    bpps_admin_placeholder.ajaxComplete(function(){
        jQuery(this).removeClass('loading');
        jQuery(this).css('background', 'none');
    });
    
    // Datepicker for date range
    jQuery(".datepicker input[type='text']").datepicker({
        dateFormat: 'dd.mm.yy',
        maxDate: "+0D",
        changeMonth: true,
        changeYear: true
    });
    
    // Load graphs according to selected fields in a pie
    jQuery('#bpps-admin ul.groups ul.fields input[type="radio"]').click(function(e){
        var field_id = jQuery(this).val();
        
        jQuery('#bpps-admin ul.other input[type="radio"]').removeAttr('checked');
        
        jQuery.ajax({
            type: 'GET',
            url:  ajaxurl,
            data: {
                action: 'bpps_ajax',
                method: 'get_field_data',
                field_id: field_id
            },
            success: function(response){
                var data = jQuery.parseJSON(response);
                
                // inserting the label
                jQuery('.second_half .inside p.label').text(data.label);
                //bpps_admin_placeholder.css('background', 'none');
                jQuery.plot(bpps_admin_placeholder, data.users_data, {
                    series: {
                        pie: {
                            show: true,
                            combine: {
                                color: '#999',
                                threshold: 0.1
                            },
                            radius: 3/4,
                            label: {
                                show: true,
                                radius: 3/4,
                                formatter: function(label, series){
                                    return '<div class="pie_hover_label">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
                                },
                                background: {
                                    opacity: 0.5,
                                    color: '#000'
                                }
                            }
                        }
                    },
                    legend: {
                        show: false
                    }
                });
            }
        });
    });
    
    // Lines for other types of data
    jQuery('#bpps-admin ul.other input[type="radio"]').click(function(){
        bpps_load_other_stat(jQuery(this));
    });

    // Apply selected dates 
    jQuery('a#apply_date').click(function(e){
        e.preventDefault();
        var date = check_date_range();
        
        if(date !== false){
            // check for selected other input
            jQuery.each(jQuery('#bpps-admin ul.other input[type="radio"]'), function(i,v){
                if(jQuery(this).attr('checked') == 'checked'){
                    // init graph reload
                    bpps_load_other_stat(jQuery(this));
                }
            });
        }
        
        return false;
    });
    
    function bpps_load_other_stat(self){
        var activity = '';
        var data = self.val();
        var date = check_date_range();
        
        if(self.attr('name') == 'activity_action'){
            activity = data;
            data = 'activity_action';
            jQuery('#bpps-admin ul.other input[name="other_data"]').removeAttr('checked');
        }else{
            jQuery('#bpps-admin ul.other input[name="activity_action"]').removeAttr('checked');
        }

        jQuery('#bpps-admin ul.groups ul.fields input[type="radio"]').removeAttr('checked');
        jQuery('#bpps-admin .second_half p.label').text('');
        
        jQuery.ajax({
            type: 'GET',
            url:  ajaxurl,
            data: {
                action:     'bpps_ajax',
                method:     'get_other_data',
                type:       data,
                date:       date,
                activity:   activity
            },
            success: function(response){
                var data = jQuery.parseJSON(response);
                jQuery.plot(bpps_admin_placeholder, [data.fields_data], {
                    series: {
                        lines: {
                            show: true, 
                            fill: true
                        },
                        label: data.label
                    },
                    grid: {
                        show: true,
                        aboveData: true,
                        labelMargin: 5,
                        axisMargin: 5,
                        minBorderMargin: 5,
                        hoverable: true, 
                        clickable: true
                    },
                    xaxis: {
                        tickSize: 1
                    }
                });// end plot
            }
        });
    }
    
    function showTooltip(x, y, contents) {
        jQuery('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 20,
            padding: '2px',
            'background-color': '#000',
            color: '#fff',
            opacity: 0.50
        }).appendTo("body").fadeIn(200);
    }
    
    var previousPoint = null;
    bpps_admin_placeholder.bind("plothover", function (event, pos, item) {
        jQuery("#x").text(pos.x.toFixed(2));
        jQuery("#y").text(pos.y.toFixed(2));
        if (item) {
            if (previousPoint != item.dataIndex) {
                previousPoint  = item.dataIndex;
                
                jQuery("#tooltip").remove();
                var x = item.datapoint[0].toFixed(2),
                    y = item.datapoint[1].toFixed(2);
                
                showTooltip(item.pageX, item.pageY,
                            parseInt(y) + " user(s) from " + parseInt(x) + " to " + (parseInt(x) + parseInt(1)) + " hrs");
            }
        }else {
            jQuery("#tooltip").remove();
            previousPoint = null;            
        }
    });

    function check_date_range(){
        var date = false;
        if (jQuery('#date_range').attr('checked') == 'checked'){
            date = jQuery('input[name="date_from"]').val() + '-' + jQuery('input[name="date_to"]').val();
        }
        return date;
    }
    
    // Display activity actions
    jQuery('#bpps-admin a.by_type').click(function(e){
        e.preventDefault();
        jQuery(this).toggleClass('button');
        jQuery(this).toggleClass('button-primary');
        jQuery('#bpps-admin ul.other ul.actions').toggle();
    });
    
});