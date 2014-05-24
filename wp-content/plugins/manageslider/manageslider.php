<?php
/*
Plugin Name: Home Page Image Slider Plugin
Plugin URI: http://scorpioinfotech.com
Description: This plugin is to manage slide uploads to site . 
Version: 2.1
Author: Prashant Kapila .
Author URI: prashant@scorpioinfotech.com 
*/
add_action('admin_menu', 'SliderUpload');
// Table creation code start here
register_activation_hook(__FILE__,'table_slider_upload_install');

    
function table_slider_upload_install () {
   global $wpdb;

   $table_name = $wpdb->prefix ."SliderUpload";
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

function SliderUpload() {
if (current_user_can('level_10'))
 	{ 
	add_options_page('Manage Slider', __('Maria Place Slider'), 0,  __FILE__, 'slider_upload');
	}
}

////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////
function slider_upload()
{

   global $wpdb;
   		$wpu = $_GET['wpu'];
		switch($wpu) {
			case 'add':
				add_slider();
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
		add_shortcode( 'slider-image' , 'showslider_clientside' ); 
		
 function showslider_clientside()
{
global $wpdb;
$table_name = $wpdb->prefix ."SliderUpload";
$query = "select * from $table_name where status = '1' order by added_on desc ";
$row_count = $wpdb->get_results($query);
$row = $wpdb->get_results($query);
	   if(!empty($row))
       {
	 	 	echo '<div class="slider"><div id="banner">';
	 		foreach($row as $data)
	   		{   
			?>
            <div class="oneByOne_item"><img src="<?php bloginfo('url'); ?>/wp-content/plugins/manageslider/slider/<?php echo $data->slide_file_name; ?>" /></div>
            <?php
			}
			echo"</div></div>";
		}
}
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
$table_name = $wpdb->prefix ."SliderUpload";
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
	 <td colspan="3"><b> <?php echo __('Manage Slider '); ?> </b> </td> 
	 <td align="right"><a href="?page=<?php echo dirname(plugin_basename(__FILE__)); ?>/manageslider.php&wpu=add"><b>Add New</b></a></td>
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
	 	<td><img src="../wp-content/plugins/manageslider/slider/<?php echo $data->slide_file_name; ?>" height="100" width="150" border="0"/></td>
		<td ><?php if($data->status == 1) { echo "Published |"." <a href='?page=".dirname(plugin_basename(__FILE__))."/manageslider.php&wpu=status&set=unpublish&id=".$data->id."'>Unpublish</a>"; } else { echo "Unpublished |"." <a href='?page=".dirname(plugin_basename(__FILE__))."/manageslider.php&wpu=status&set=publish&id=".$data->id."'>Publish</a>"; } ?></td>
		<td><a href="?page=<?php echo dirname(plugin_basename(__FILE__)); ?>/manageslider.php&wpu=delete&id=<?php echo 

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
				          ?><a href="?page=<?php echo dirname(plugin_basename(__FILE__)); 

?>/manageslider.php&page_num=<?php echo $i; ?>" style="text-decoration:none;" >[<?php echo $i; ?>]</a>
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
	  <tr>
	 	<td colspan="4" align="center"> <b>No Records Found.</b> </td>
		
	 </tr>
	<?php
	  }
	?>
	       
</table>
<?php
}


function add_slider()
{

global $wpdb;
if(isset($_POST['submit']))
{

		$slider_title = $_POST['slide_title'];
		$slider_desc = $_POST['slide_desc'];
		$slider_file_name = $_FILES['slider_file']['name'];
			
		$table_name = $wpdb->prefix ."SliderUpload";
        //check file type 
		if($_FILES['slider_file']['type'] == "image/jpeg" || $_FILES['slider_file']['type'] == "image/png" || $_FILES['slider_file']['type'] == "image/gif" || $_FILES['slider_file']['type'] == "image/jpg" || $_FILES['slider_file']['type'] == "image/bmp" || $_FILES['slider_file']['type'] == "image/JPEG" || $_FILES['slider_file']['type'] == "image/PNG" || $_FILES['slider_file']['type'] == "image/GIF" || $_FILES['slider_file']['type'] == "image/JPG" || $_FILES['slider_file']['type'] == "image/BMP" )
		{
			$get_old_files = "select * from $table_name where slide_file_name = '$slider_file_name'";
			
			$row_count = mysql_num_rows(mysql_query($get_old_files));
			
			if($row_count > 0)
			{
				$message = "Error: File already exist.";
			}
			else
			{
				$target = "../wp-content/plugins/manageslider/slider/".$slider_file_name ;
				
				if(move_uploaded_file($_FILES['slider_file']['tmp_name'],$target))
				{
					$insert =  "INSERT INTO ".$table_name." (slide_name, slide_file_name, status,slide_file_desc) VALUES ('".$slider_title."','".$slider_file_name."', '0','$slider_desc')";
					
					if($wpdb->query($insert)){
					$msg =  "<p><strong>"." New Slide Added successfully "."</strong></p>";
					Showslider_adminside($msg) ;
					
				}
				else
				{
					$message = "Error: File was not uploaded.";
				}
			}
		}}
		else
		{
			$message = "Error: File was not an image";
		}
}

?>
  <table border="0" cellpadding="10" cellspacing="10" align="center" style="width:800px;margin-left:20px; border:solid 1px #999999; 

margin-top:50px;">
     <tr>
	 <td colspan="3"><b> <?php echo __('Add Slider '); ?> </b> </td> 
	    <td align="right"><a href="?page=<?php echo dirname(plugin_basename(__FILE__)); ?>/manageslider.php"><b>< Go Back</b></a></td>
      </tr> 
     <tr><td colspan="4">&nbsp;</td></tr>  
	 <?php if($message!="") { ?>    
	 <tr>
	 <td colspan="4"><b> <?php echo $message ; ?> </b> </td> 
	
	 </tr>
	 <tr><td colspan="4">&nbsp;</td></tr>  
	 <?php } ?>
	 <form method="post" action="" enctype="multipart/form-data" name="form1" id="form1">
	 <tr>
	 	<td colspan="2" align="right" width="30%">Slide Title</td>
		<td colspan="2" align="left"><input type="text" name="slide_title" style="width:195px;" /></td>
	 </tr>
	 <tr>
	 	<td colspan="2" align="right" width="30%">Slide Description</td>
		<td colspan="2" align="left"><input type="text" name="slide_desc" style="width:195px;" /></td>
	 </tr>
	 <tr>
	 	<td colspan="2" align="right">Select File</td>
		<td colspan="2" align="left"><input type="file" name="slider_file" style="width:150px; background-color: #FFFFFF;
    border-color: #DFDFDF;" />
		</td>
	 </tr>
	 <tr>
	 	<td colspan="4" align="center"><input type="submit" name="submit" value="Submit" onclick="show_loading();" /></td>
	 </tr>
	 </form>
	
	       
</table>
<?php
}

function delete_slider() //function is used to delete records
{
   global $wpdb;
   $id=$_GET['id'];
   
   
  $table_name = $wpdb->prefix ."SliderUpload";
  $row = $wpdb->get_results("select * from $table_name where id = '$id'");
  foreach($row as $data)
  {
  		$file_name = $data->song_file_name; 
  }
  $full_path = "../wp-content/plugins/manageslider/slider/".$file_name;
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
   $table_name = $wpdb->prefix ."SliderUpload";
   
   $query="select * from $table_name where status = 1";
   //$affected_query = mysql_query($query);
   //$total_rows = mysql_affected_rows();
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
  // if($total_rows < 5 || $status=='0'  )
 //{
 	
 	 if($wpdb->query("update $table_name set status = '$status' WHERE id = $id"))
    {
		$msg = "<p><strong>".__('Record updated successfully')."</strong></p>" ;
		showslider_adminside($msg) ;
    }	
 //}
  	else 
  {
  
  $msg =  "<p><strong>".__('There is an error in Updating record. Please check the Published items should not increse then 5 Items.')."</strong></p>" ;
  showslider_adminside($msg) ;
     
  }
 
}
?>