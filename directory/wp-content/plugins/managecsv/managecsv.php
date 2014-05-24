<?php
/*
Plugin Name: Manage CSV Files Plugin
Description: This plugin is to manage Csv Files uploaded to site . 
Version: 2.1
Author: Prashant kapila.
Author URI: prashantkapila@gmail.com
*/
add_action('admin_menu', 'CSV');
// Table creation code start here
register_activation_hook(__FILE__,'table_csv1_install');

    
function table_csv1_install () {
   global $wpdb;

   $table_name = $wpdb->prefix ."CSV";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      
      $sql = "CREATE TABLE " . $table_name . " (
	  id int(11) NOT NULL AUTO_INCREMENT,
	  slide_name VARCHAR(255) NOT NULL,
	  slide_file_name varchar(255) NOT NULL ,
	  slide_file_desc varchar(255) NOT NULL ,
	  added_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
	  status BOOLEAN NOT NULL ,
	  PRIMARY KEY id (id)
	);";
	
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

	
   }
}
// Table creation code end here

function CSV() {
if (current_user_can('level_10'))
 	{ 
	add_options_page('Manage CSV Uploaded Files', __('Manage CSV Uploaded Files'), 0,  __FILE__, 'csv1');
	}
}

////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////
function csv1()
{

   global $wpdb;
   		$wpu = $_GET['wpu'];
		switch($wpu) {
			case 'add':
				add_csv();
			break;
			case 'add_query':
				add_query_csv();
			break;
			
			case 'status':
				update_status_slider();
			break;
			case 'delete':
				delete_slider();
			break; 
			default:
				showslider_adminside();
			break;
		}
      }
	  ?>
<?php
/*function showslider_clientside()
{
global $wpdb;
$table_name = $wpdb->prefix ."CSV";
$query = "select * from $table_name where status = '1' order by added_on desc ";
$row_count = $wpdb->get_results($query);
$row = $wpdb->get_results($query);
	   if(!empty($row))
       {
	 	 								
	 		foreach($row as $data)
	   		{   
			?>
            <div class="slide">
            <img src="<?php bloginfo('url'); ?>/wp-content/plugins/managecsv/csv/<?php echo $data->slide_file_name; ?>" style="width:300px; height:253px;" />
        	</div>
            <?php
			}
		}
}*/
?>
<?php function showslider_adminside($msg="")
{

global $wpdb;
$message = $msg ;
if($_GET['msg'] != "")
{
	$message = $_GET['msg'];
}
//results per page;
$resultsno = 10;
$table_name = $wpdb->prefix ."CSV";
$query = "select * from $table_name order by added_on desc ";
$row_count = $wpdb->get_results($query);
// pagination code //
	$page = $_REQUEST['page_num']; 
	if ($_REQUEST["page_num"]) { $page  = $_REQUEST["page_num"]; } else { $page=1; };
	$start_from = ($page-1) * $resultsno; 
	$query.=" LIMIT $start_from, $resultsno";
	
$row = $wpdb->get_results($query);
$res_count = sizeof($row_count);
?>
<table border="0" align="center" cellpadding="10" cellspacing="10" style="width:800px;margin-left:20px; border:solid 1px #999999; margin-top:50px;">
   <tr>
	 <td colspan="3"><b> <?php echo __('Manage CSV Files '); ?> </b> </td> 
	 <td align="right"><a href="options-general.php?page=<?php echo dirname(plugin_basename(__FILE__)); ?>/managecsv.php&wpu=add"><b>Add New</b></a></td>
      </tr>
	 <tr><td colspan="4">&nbsp;</td></tr>  
	 <?php if($message!="") { ?>    
	 <tr>
		 <td colspan="4"><b> <?php echo $message ; ?> </b> </td> 
	 </tr>
	 <tr><td colspan="4">&nbsp;</td></tr>  
	 <?php }    
	  if(!empty($row))
      {
	 ?>
	 <tr>
	 	<td> <b>Slider Image</b> </td>
		<td> <b>Status</b> </td>
		<td> <b>Option</b> </td>
	 </tr>
	 <?php
	 								
	 foreach($row as $data)
	   {   ?>
	 <tr>
	 	<td><?php echo $data->slide_file_name; ?></td>
		<td ><?php if($data->status == 1) { echo "Published |"." <a href='?page=".dirname(plugin_basename(__FILE__))."/managecsv.php&wpu=status&set=unpublish&id=".$data->id."'>Unpublish</a>"; } else { echo "Unpublished |"." <a href='?page=".dirname(plugin_basename(__FILE__))."/managecsv.php&wpu=status&set=publish&id=".$data->id."'>Publish</a>"; } ?></td>
		<td><a href="options-general.php?page=<?php echo dirname(plugin_basename(__FILE__)); ?>/managecsv.php&amp;wpu=delete&amp;id=<?php echo 

$data->id ;?>">Delete</a>
  </td>
	</tr>
	<?php
														
	    }
		?>
	<tr><td height="10"></td></tr>
	<tr>
		<td colspan="4" align="center">
		<?php 	
				
                       $total_rows = ceil($res_count / $resultsno); 
 
                     for ($i=1; $i<=$total_rows; $i++) {
			         if($page == $i)
			           {
				          echo "<b style='color:#999999;'>[".$i."] </b>";
			           }
                         else
			           {
				          ?><a href="options-general.php?page=<?php echo dirname(plugin_basename(__FILE__)); 

?>/managecsv.php&amp;page_num=<?php echo $i; ?>" style="text-decoration:none;" >[<?php echo $i; ?>]</a>
		<?php 
				        }
                }?>
		</td>
	</tr>
	<?php
	  }
	  else
	  {
	?>
	<!--  <tr>
	 	<td colspan="4" align="center"> <b>No Records Found.</b> </td>
		
	 </tr>-->
	<?php
	  }
	?>
	       
</table>
<?php
}
function add_query_csv(){

global $wpdb;

		$slider_title = $_POST['slide_title'];
		$slider_desc = $_POST['slide_desc'];
		$slider_file_name = $_FILES['slider_file']['name'];
		$table_name = $wpdb->prefix ."CSV";
        //check file type 
		if($_FILES['slider_file']['type'] == "text/plain" || $_FILES['slider_file']['type'] == "application/octet-stream")
		{
		
	
				$target = "../wp-content/plugins/managecsv/csv/".$slider_file_name ;
				
				if(move_uploaded_file($_FILES['slider_file']['tmp_name'],$target))
				{
					if (($handle = fopen($target, "r")) !== FALSE) {

						while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
						/*[0] => CompanyName
							[1] => Address
							[2] => City
							[3] => State
							[4] => Zip
							[5] => County
							[6] => Gender
							[7] => PhoneNumber
							[8] => FaxNumber
							[9] => CompanyContact
							[10] => CompanyContactTitle
							[11] => WebSite
							[12] => TotalEmployees
							[13] => AnnualSales
							[14] => Industry
							[15] => SIC_Code
							[16] => SIC_Code_Description
							[17] => GenericCompanyEmailAddress*/
						$num = count($data);
						$defaults = array(
						  'post_title'    		  => $data[0],
						  'post_status'           => 'publish', 
						  'post_type'             => 'listing',
						 );
						$post_id = wp_insert_post( $defaults );
						$address = $data[1].', '.$data[2].', '.$data[3].', '.$data[5].', '.$data[4];
							$Address = urlencode($address);
							  $request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$Address."&sensor=true";
							  $xml = simplexml_load_file($request_url) or die("url not loading");
							  $status = $xml->status;
							  if ($status=="OK") {
								  $Lat = $xml->result->geometry->location->lat;
								  $Lon = $xml->result->geometry->location->lng;
								  $LatLng = "$Lat,$Lon";
							  }
						
						$select_table_name = $wpdb->prefix ."term_taxonomy";	  						
						$select = "SELECT term_taxonomy_id FROM ".$select_table_name." WHERE term_id =$data[15]" ;
						$row = $wpdb->get_results($select);
						
						if(!empty($row)){
							 foreach($row as $newdata){
							 	$term_tax 	= $newdata->term_taxonomy_id;
								$table_name = $wpdb->prefix ."term_relationships";	  
								$insert 	=  "INSERT INTO ".$table_name." (object_id, term_taxonomy_id,term_order ) VALUES ('".$post_id."','".$term_tax."','0')";
								$wpdb->query($insert);
							 }
						}
						
						$table_term 		= $wpdb->prefix ."terms";	  		
						$table_term_tax 	= $wpdb->prefix ."term_taxonomy";				
						
					$select = "SELECT ". $table_term_tax .".term_taxonomy_id FROM ".$table_term." JOIN ".$table_term_tax." ON ".$table_term.".term_id = ".$table_term_tax.".term_id AND ".$table_term_tax.".taxonomy = 'listings_location' AND ".$table_term.".name = '$data[14]'";				
						
						$value = $wpdb->get_results($select);
						
						if(!empty($value)){
							 foreach($value as $new_data){
							 	$term_tax 	= $new_data->term_taxonomy_id;
								$table_name = $wpdb->prefix ."term_relationships";	  
								$insert 	=  "INSERT INTO ".$table_name." (object_id, term_taxonomy_id,term_order ) VALUES ('".$post_id."','".$term_tax."','0')";
								$wpdb->query($insert);
							 }
						}
						
						add_post_meta( $post_id, 'location', $address.'|'.$LatLng); 
						add_post_meta( $post_id, '_location', 'field_51dd6e7c52b8a' ); 
						add_post_meta( $post_id, 'telephone', $data[7] ); 
						add_post_meta( $post_id, 'mobile_phone_number', $data[8] ); 
						add_post_meta( $post_id, 'website', $data[11] ); 
						}
						$msg =  "<p><strong>"."Added successfully "."</strong></p>";

				}
				else
				{
					$msg = "Error: File was not uploaded.";
				}
		}
		else
		{
			$msg = "Error: File was not an image";
		}
		Showslider_adminside($msg) ;
}
}
function add_csv()
{
?>
  <table border="0" cellpadding="10" cellspacing="10" align="center" style="width:800px;margin-left:20px; border:solid 1px #999999; 

margin-top:50px;">
     <tr>
	 <td colspan="3"><b> <?php echo __('Add File'); ?> </b> </td> 
	    <td align="right"><a href="options-general.php?page=<?php echo dirname(plugin_basename(__FILE__)); ?>/managecsv.php"><b>< Go Back</b></a></td>
      </tr> 
     <tr><td colspan="4">&nbsp;</td></tr>  
	 <?php if($message!="") { ?>    
	 <tr>
	 <td colspan="4"><b> <?php echo $message ; ?> </b> </td> 
	
	 </tr>
	 <tr><td colspan="4">&nbsp;</td></tr>  
	 <?php } ?>
	 <form method="post" action="options-general.php?page=<?php echo dirname(plugin_basename(__FILE__)); ?>/managecsv.php&amp;wpu=add_query" enctype="multipart/form-data" name="form1" id="form1">
	<!-- <tr>
	 	<td colspan="2" align="right" width="30%">Slide Title</td>
		<td colspan="2" align="left"><input type="text" name="slide_title" style="width:195px;" /></td>
	 </tr>
	 <tr>
	 	<td colspan="2" align="right" width="30%">Slide Description</td>
		<td colspan="2" align="left"><input type="text" name="slide_desc" style="width:195px;" /></td>
	 </tr>-->
	 <tr>
	 	<td colspan="2" align="right">Select CSV Listing File</td>
		<td colspan="2" align="left"><input type="file" name="slider_file" style="width:192px; background-color: #FFFFFF;
    border-color: #DFDFDF;" />
		</td>
	 </tr>
	 <tr>
	 	<td colspan="4" align="center"><input type="submit" name="submit" value="Submit" /></td>
	 </tr>
	 </form>
	
	       
</table>
<?php
}

function delete_slider() //function is used to delete records
{
   global $wpdb;
   $id=$_GET['id'];
   
   
  $table_name = $wpdb->prefix ."CSV";
  $row = $wpdb->get_results("select * from $table_name where id = '$id'");
  foreach($row as $data)
  {
  		$file_name = $data->song_file_name; 
  }
  $full_path = "../wp-content/plugins/managecsv/csv/".$file_name;
  if(file_exists($full_path))
				{
					unlink($full_path);
				}
  if($wpdb->query("DELETE FROM $table_name WHERE id = '$id'"))
    {
    $msg = "<p><strong>".__('Record deleted successfully')."</strong></p>" ;
	showslider_adminside($msg) ;
    }	
  
  else 
  {
  echo  "<p><strong>".__('There is an error in deleting record. Please check the data.')."</strong></p>" ;
  showslider_adminside($msg) ;
     
  }
 
}

function update_status_slider() //function is used to update record status
{
   global $wpdb;
   $table_name = $wpdb->prefix ."CSV";
   
   $query="select * from $table_name where status = 1";
   $affected_query = mysql_query($query);
   $total_rows = mysql_affected_rows();
   //echo $total_rows ;
  
   $id=$_GET['id'];
   if($_GET['set'] == "publish")
   {
   		$status = 1;
   }
   else
   {
   		$status = 0;
   }
   if($total_rows < 5 || $status=='0'  )
 {
 	
 	 if($wpdb->query("update $table_name set status = '$status' WHERE id = $id"))
    {
    $msg = "<p><strong>".__('Record updated successfully')."</strong></p>" ;
	showslider_adminside($msg) ;
    }	
 }
  	else 
  {
  
  $msg =  "<p><strong>".__('There is an error in Updating record. Please check the Published items should not increse then 5 Items.')."</strong></p>" ;
  showslider_adminside($msg) ;
     
  }
 
}
?>