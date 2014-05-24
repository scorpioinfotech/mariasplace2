<?php
/*
	TDp Report
	Title: Sales
	Slug: sales
	
	For each report, add a line like:
	global $tdp_reports;
	$tdp_reports['slug'] = 'Title';
	
	For each report, also write two functions:
	* tdp_report_{slug}_widget()   to show up on the report homepage.
	* tdp_report_{slug}_page()     to show up when users click on the report page widget.
*/
global $tdp_reports;
$gateway_environment = tdp_getOption("gateway_environment");
if($gateway_environment == "sandbox")
	$tdp_reports['sales'] = __('Sales and Revenue (Testing/Sandbox)', 'tdp');
else
	$tdp_reports['sales'] = __('Sales and Revenue', 'tdp');

//queue Google Visualization JS on report page
function tdp_report_sales_init()
{
	if(is_admin() && isset($_REQUEST['report']) && $_REQUEST['report'] == "sales" && isset($_REQUEST['page']) && $_REQUEST['page'] == "tdp-reports")
	{
		wp_enqueue_script("jsapi", "https://www.google.com/jsapi");
	}
}
add_action("init", "tdp_report_sales_init");
	
//widget
function tdp_report_sales_widget()
{
	global $wpdb, $tdp_currency_symbol;
	$visits = get_option("tdp_visits", array("today"=>0, "thisday"=>date("Y-m-d"), "alltime"=>0, "month"=>0, "thismonth"=>date("n")));
	$views = get_option("tdp_views", array("today"=>0, "thisday"=>date("Y-m-d"), "alltime"=>0, "month"=>0, "thismonth"=>date("n")));
	$logins = get_option("tdp_logins", array("today"=>0, "thisday"=>date("Y-m-d"), "alltime"=>0, "month"=>0, "thismonth"=>date("n")));
?>
<style>
	#tdp_report_sales div {text-align: center;}
	#tdp_report_sales em {display: block; font-style: normal; font-size: 2em; margin: 5px;}	
</style>
<span id="#tdp_report_sales">
	<div style="width: 25%; float: left;">	
		<label>All Time</label>
		<em><?php echo $tdp_currency_symbol . number_format(tdp_getRevenue("all time"), 2);?></em>		
	</div>
	<div style="width: 25%; float: left;">	
		<label>This Year</label>
		<em><?php echo $tdp_currency_symbol . number_format(tdp_getRevenue("this year"), 2);?></em>		
	</div>
	<div style="width: 25%; float: left;">	
		<label>This Month</label>
		<em><?php echo $tdp_currency_symbol . number_format(tdp_getRevenue("this month"), 2);?></em>		
	</div>
	<div style="width: 25%; float: left;">
		<label>Today</label>
		<em><?php echo $tdp_currency_symbol . number_format(tdp_getRevenue("today"), 2);?></em>		
	</div>	
	<div class="clear"></div>
</span>
<?php
}

function tdp_report_sales_page()
{
	global $wpdb, $tdp_currency_symbol;
	
	//get values from form
	if(isset($_REQUEST['type']))
		$type = sanitize_text_field($_REQUEST['type']);
	else
		$type = "revenue";
	
	if($type == "sales")
		$type_function = "COUNT";
	else
		$type_function = "SUM";
	
	if(isset($_REQUEST['period']))
		$period = sanitize_text_field($_REQUEST['period']);
	else
		$period = "daily";
		
	if(isset($_REQUEST['month']))
		$month = intval($_REQUEST['month']);
	else
		$month = date("n");
	
	$thisyear = date("Y");
	if(isset($_REQUEST['year']))
		$year = intval($_REQUEST['year']);
	else
		$year = $thisyear;
		
	if(isset($_REQUEST['level']))
		$l = intval($_REQUEST['level']);
	else
		$l = "";
	
	//calculate start date and how to group dates returned from DB
	if($period == "daily")
	{
		$startdate = $year . '-' . substr("0" . $month, strlen($month) - 1, 2) . '-01';		
		$enddate = $year . '-' . substr("0" . $month, strlen($month) - 1, 2) . '-31';		
		$date_function = 'DAY';
	}
	elseif($period == "monthly")
	{
		$startdate = $year . '-01-01';
		$enddate = strval(intval($year)+1) . '-01-01';
		$date_function = 'MONTH';
	}
	else
	{
		$startdate = '1960-01-01';	//all time
		$date_function = 'YEAR';
	}
	
	//testing or live data
	$gateway_environment = tdp_getOption("gateway_environment");
	
	//get data
	$sqlQuery = "SELECT $date_function(timestamp) as date, $type_function(total) as value FROM $wpdb->tdp_membership_orders WHERE timestamp >= '" . $startdate . "' AND status NOT IN('refunded', 'review', 'token') AND gateway_environment = '" . esc_sql($gateway_environment) . "' ";
	
	if(!empty($enddate))
		$sqlQuery .= "AND timestamp < '" . $enddate . "' ";
	
	if(!empty($l))
		$sqlQuery .= "AND membership_id IN(" . $l . ") ";
	
	$sqlQuery .= " GROUP BY date ORDER BY date ";
		
	$dates = $wpdb->get_results($sqlQuery);		
		
	//fill in blanks in dates
	$cols = array();				
	if($period == "daily")
	{
		$lastday = date("t", $startdate);
	
		for($i = 1; $i <= $lastday; $i++)
		{
			$cols[$i] = 0;
			foreach($dates as $date)
			{
				if($date->date == $i)
					$cols[$i] = $date->value;
			}
		}
	}
	elseif($period == "monthly")
	{		
		for($i = 1; $i < 13; $i++)
		{
			$cols[$i] = 0;
			foreach($dates as $date)
			{
				if($date->date == $i)
					$cols[$i] = $date->value;
			}
		}
	}
	else //annual
	{
		//get min and max years
		$min = 9999;
		$max = 0;
		foreach($dates as $date)
		{
			$min = min($min, $date->date);
			$max = max($max, $date->date);
		}
		
		for($i = $min; $i <= $max; $i++)
		{
			foreach($dates as $date)
			{
				if($date->date == $i)
					$cols[$i] = $date->value;
			}
		}
	}	
	?>
	<form id="posts-filter" method="get" action="">		
	<h2>
		<?php _e('Sales and Revenue', 'tdp');?>
	</h2>
	
	<ul class="subsubsub">
		<li>
			<?php _ex('Show', 'Dropdown label, e.g. Show Daily Revenue for January', 'tdp')?>
			<select id="period" name="period">
				<option value="daily" <?php selected($period, "daily");?>><?php _e('Daily', 'tdp');?></option>
				<option value="monthly" <?php selected($period, "monthly");?>><?php _e('Monthly', 'tdp');?></option>
				<option value="annual" <?php selected($period, "annual");?>><?php _e('Annual', 'tdp');?></option>
			</select>
			<select name="type">
				<option value="revenue" <?php selected($type, "revenue");?>><?php _e('Revenue', 'tdp');?></option>
				<option value="sales" <?php selected($type, "sales");?>><?php _e('Sales', 'tdp');?></option>
			</select>
			<span id="for"><?php _ex('for', 'Dropdown label, e.g. Show Daily Revenue for January', 'tdp')?></span>
			<select id="month" name="month">
				<?php for($i = 1; $i < 13; $i++) { ?>
					<option value="<?php echo $i;?>" <?php selected($month, $i);?>><?php echo date("F", mktime(0, 0, 0, $i));?></option>
				<?php } ?>
			</select>
			<select id="year" name="year">
				<?php for($i = $thisyear; $i > 2007; $i--) { ?>
					<option value="<?php echo $i;?>" <?php selected($year, $i);?>><?php echo $i;?></option>
				<?php } ?>
			</select>
			<span id="for"><?php _ex('for', 'Dropdown label, e.g. Show Daily Revenue for January', 'tdp')?></span>
			<select name="level">
				<option value="" <?php if(!$l) { ?>selected="selected"<?php } ?>><?php _e('All Levels', 'tdp');?></option>
				<?php
					$levels = $wpdb->get_results("SELECT id, name FROM $wpdb->tdp_membership_levels ORDER BY name");
					foreach($levels as $level)
					{
				?>
					<option value="<?php echo $level->id?>" <?php if($l == $level->id) { ?>selected="selected"<?php } ?>><?php echo $level->name?></option>
				<?php
					}
				?>
			</select>
			
			<input type="hidden" name="page" value="tdp-reports" />		
			<input type="hidden" name="report" value="sales" />	
			<input type="submit" value="<?php _ex('Generate Report', 'Submit button value.', 'tdp');?>" />
		</li>
	</ul>
	
	<div id="chart_div" style="clear: both; width: 100%; height: 500px;"></div>				
	
	<script>
		//update month/year when period dropdown is changed
		jQuery(document).ready(function() {
			jQuery('#period').change(function() {
				tdp_ShowMonthOrYear();
			});
		});
		
		function tdp_ShowMonthOrYear()
		{
			var period = jQuery('#period').val();
			if(period == 'daily')
			{
				jQuery('#for').show();
				jQuery('#month').show();
				jQuery('#year').show();
			}
			else if(period == 'monthly')
			{
				jQuery('#for').show();
				jQuery('#month').hide();
				jQuery('#year').show();
			}
			else
			{
				jQuery('#for').hide();
				jQuery('#month').hide();
				jQuery('#year').hide();
			}
		}
		
		tdp_ShowMonthOrYear();
		
		//draw the chart
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(drawChart);
		function drawChart() {			
			
			var data = google.visualization.arrayToDataTable([
			  ['<?php echo $date_function;?>', '<?php echo ucwords($type);?>'],
			  <?php foreach($cols as $date => $value) { ?>
				['<?php if($period == "monthly") echo date("M", mktime(0,0,0,$date)); else echo $date;?>', <?php echo $value;?>],
			  <?php } ?>
			]);

			var options = {			 
			  colors: ['#51a351', '#387038'],
			  hAxis: {title: '<?php echo $date_function;?>', titleTextStyle: {color: 'black'}, maxAlternation: 1},
			  vAxis: {color: 'green', titleTextStyle: {color: '#51a351'}},			  
			};
			
			var formatter = new google.visualization.NumberFormat({prefix: '<?php echo html_entity_decode($tdp_currency_symbol);?>'});
			formatter.format(data, 1);

			var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		}
	</script>
	
	</form>
	<?php
}

/*
	Other code required for your reports. This file is loaded every time WP loads with TDp enabled.
*/

//get sales
function tdp_getSales($period, $levels = NULL)
{
	//check for a transient
	$cache = get_transient("tdp_report_sales");
	if(!empty($cache) && !empty($cache[$period]) && !empty($cache[$period][$levels]))
		return $cache[$period][$levels];
		
	//a sale is an order with status NOT IN('refunded', 'review', 'token')
	if($period == "today")
		$startdate = date("Y-m-d");
	elseif($period == "this month")
		$startdate = date("Y-m") . "-01";
	elseif($period == "this year")
		$startdate = date("Y") . "-01-01";
	else
		$startdate = "";
	
	$gateway_environment = tdp_getOption("gateway_environment");
	
	//build query
	global $wpdb;
	$sqlQuery = "SELECT COUNT(*) FROM $wpdb->tdp_membership_orders WHERE status NOT IN('refunded', 'review', 'token') AND timestamp >= '" . $startdate . "' AND gateway_environment = '" . esc_sql($gateway_environment) . "' ";
	
	//restrict by level
	if(!empty($levels))
		$sqlQuery .= "AND membership_id IN(" . $levels . ") ";
	
	$sales = $wpdb->get_var($sqlQuery);
	
	//save in cache
	if(!empty($cache) && !empty($cache[$period]))
		$cache[$period][$levels] = $sales;
	elseif(!empty($cache))
		$cache[$period] = array($levels => $sales);
	else
		$cache = array($period => array($levels => $sales));
	
	set_transient("tdp_report_sales", $cache, 3600*24);
	
	return $sales;
}

//get revenue
function tdp_getRevenue($period, $levels = NULL)
{
	//check for a transient
	$cache = get_transient("tdp_report_revenue");
	if(!empty($cache) && !empty($cache[$period]) && !empty($cache[$period][$levels]))
		return $cache[$period][$levels];	
		
	//a sale is an order with status NOT IN('refunded', 'review', 'token')
	if($period == "today")
		$startdate = date("Y-m-d");
	elseif($period == "this month")
		$startdate = date("Y-m") . "-01";
	elseif($period == "this year")
		$startdate = date("Y") . "-01-01";
	else
		$startdate = "";
	
	$gateway_environment = tdp_getOption("gateway_environment");
	
	//build query
	global $wpdb;
	$sqlQuery = "SELECT SUM(total) FROM $wpdb->tdp_membership_orders WHERE status NOT IN('refunded', 'review', 'token') AND timestamp >= '" . $startdate . "' AND gateway_environment = '" . esc_sql($gateway_environment) . "' ";
	
	//restrict by level
	if(!empty($levels))
		$sqlQuery .= "AND membership_id IN(" . $levels . ") ";
		
	$revenue = $wpdb->get_var($sqlQuery);
	
	//save in cache
	if(!empty($cache) && !empty($cache[$period]))
		$cache[$period][$levels] = $revenue;
	elseif(!empty($cache))
		$cache[$period] = array($levels => $revenue);
	else
		$cache = array($period => array($levels => $revenue));
	
	set_transient("tdp_report_revenue", $cache, 3600*24);
	
	return $revenue;
}

//delete transients when an order goes through
function tdp_report_sales_delete_transients()
{
	delete_transient("tdp_report_sales");
	delete_transient("tdp_report_revenue");
}
add_action("tdp_after_checkout", "tdp_report_sales_delete_transients");
add_action("tdp_updated_order", "tdp_report_sales_delete_transients");
