<?php
	global $tdp_reports;
	
	require_once(dirname(__FILE__) . "/admin_header.php");
	
	//default view, report widgets
	if(empty($_REQUEST['report']))
	{				
		//wrapper
		?>
		<div id="dashboard-widgets-wrap">
			<div id="dashboard-widgets" class="metabox-holder tdp_reports-holder columns-2">	
		<?php
		
		//report widgets
		foreach($tdp_reports as $report => $title)
		{
		?>
		<div class="postbox-container">
               <div id="tdp_report_<?php echo $report; ?>" class="postbox tdp_clickable" onclick="location.href='<?php echo admin_url("admin.php?page=tdp-reports&report=" . $report);?>';">			
                    <h3 class="hndle"><span><?php echo $title; ?></span></h3>
                    <div class="inside">
                         <?php call_user_func("tdp_report_" . $report . "_widget"); ?>
                         <div style="margin-top:10px;border-top: 1px solid #ddd; padding-top: 10px; text-align:center;">
                              <a class="button button-primary" href="<?php echo admin_url("admin.php?page=tdp-reports&report=" . $report);?>"><?php _e('Details', 'tdp');?></a>
                         </div>
                    </div>
               </div>
		</div>
		<?php
		}
		
		//end wrapper
		?>
			</div>
		</div>
		<?php
	}
	else
	{
		//view a single report
		$report = $_REQUEST['report'];
		call_user_func("tdp_report_" . $report . "_page");
	}
	
	require_once(dirname(__FILE__) . "/admin_footer.php");
?>