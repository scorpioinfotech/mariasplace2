<?php
//-----------------------------create database connection---------------------------
set_include_path('/home/azohub/public_html/directory/');
include("wp-config.php");
include("wp-admin/includes/taxonomy.php");
 set_time_limit(0);
global $wpdb;
$inc 	=	mysql_fetch_assoc(mysql_query("SELECT id FROM complete_id"));
$start	=	0;
	if(!empty($inc)){
		$start	=	$inc['id'];
	}
$result 	=	mysql_query("SELECT * FROM complete ORDER BY ID ASC LIMIT $start,100");
while ($row = mysql_fetch_assoc($result)) {

//-----------------------------------default variables------------------------------------//


		$row_address					=	addslashes($row['Address']);
		$row_city					=	$row['City'];	
		$row_state					=	$row['State'];
		$row_county					=	$row['County'];
		$row_zip					=	$row['Zip'];
		$row_company					=	addslashes($row['CompanyName']);
		$row_listing_cat_name				=	addslashes($row['subcategory']); //listing category name
		$row_listing_cat				=	addslashes($row['subcategory_id']); //listing category
		$row_desc					=	addslashes($row['SIC_Code_Description']); 
		$row_industry					=	addslashes($row['Industry']); //listing location
		$row_phone					=	$row['PhoneNumber'];
		$row_fax					=	$row['FaxNumber'];
		$row_web					=	addslashes($row['WebSite']);
		$row_sic					=	$row['SIC_Code'];
		$row_gender					=	$row['Gender'];
		$row_comp_cont					=	addslashes($row['CompanyContact']);
		$row_comp_title					=	addslashes($row['CompanyContactTitle']);
		$row_total_emp					=	$row['TotalEmployees'];
		$row_sales					=	$row['AnnualSales'];
		$row_comp_email					=	$row['GenericCompanyEmailAddress'];

//----------------------create geocode from google api----------------------------------------//

						
							$addr 			= $row_address.', '.$row_city.', '.$row_state.', '.$row_zip;
							$checked_addr	= preg_replace('/[^\p{L}\p{N}\s]/u', '', $addr);
							$request_url 	= "http://maps.googleapis.com/maps/api/geocode/xml?address=".$checked_addr."&sensor=true";
							$xml 			= simplexml_load_file($request_url) or die("url not loading");
							$status 		= $xml->status;
							  if ($status=="OK") {
								  $Lat 		= $xml->result->geometry->location->lat;
								  $Lon 		= $xml->result->geometry->location->lng;
								  $LatLng 	= "$Lat,$Lon";
							  }
							 
//----------------------insert post-----------------------------------------------------------//							


						$defaults = array(
						  'post_title'    		  => $row_company,
						  'post_status'           => 'publish', 
						  'post_type'             => 'listing',
						 );
						 
						$post_id = wp_insert_post( $defaults );



//----------------------Check for listing category----------------------------------------//



						$table_term 			= $wpdb->prefix ."terms";	  		
						$table_term_tax 		= $wpdb->prefix ."term_taxonomy";				
												
						$check_cat 				= "SELECT ". $table_term_tax .".term_taxonomy_id FROM ".$table_term." JOIN ".$table_term_tax." ON ".$table_term.".term_id = ".$table_term_tax.".term_id AND ".$table_term_tax.".taxonomy = 'listings_categories' AND ".$table_term.".term_id = '".$row_listing_cat."'";
					
						$return_check_cat 	= $wpdb->get_results($check_cat);
						if(empty($return_check_cat)){
						
								$cat_name 		= $row_listing_cat_name;
								$cat_defaults 	= array(  'cat_name' => $cat_name,  'category_description' => $cat_name,  'category_nicename' => '',  'category_parent' => '',  'taxonomy' => 'listings_categories' );
						
								// Create the listings categories
								$my_cat_id = wp_insert_category($cat_defaults); 
						}
						
						$table_term 		= $wpdb->prefix ."terms";	  		
						$table_term_tax 	= $wpdb->prefix ."term_taxonomy";				
						
						$check_cat 			= "SELECT ". $table_term_tax .".term_taxonomy_id FROM ".$table_term." JOIN ".$table_term_tax." ON ".$table_term.".term_id = ".$table_term_tax.".term_id AND ".$table_term_tax.".taxonomy = 'listings_categories' AND ".$table_term.".term_id = '".$row_listing_cat."'";
						$r_check_cat 		= $wpdb->get_results($check_cat);
						
						if(!empty($r_check_cat)){
							 foreach($r_check_cat as $newdata){
							 	$term_tax 	= $newdata->term_taxonomy_id;
								$table_name = $wpdb->prefix ."term_relationships";	  
								$insert 	=  "INSERT INTO ".$table_name." (object_id, term_taxonomy_id,term_order ) VALUES ('".$post_id."','".$term_tax."','0')";
								$wpdb->query($insert);
							 }
						}
						
						
						
//----------------------Check for listing location----------------------------------------//		


						$table_term 		= $wpdb->prefix ."terms";	  		
						$table_term_tax 	= $wpdb->prefix ."term_taxonomy";	
									
						
						$check_cat 			= "SELECT ". $table_term_tax .".term_taxonomy_id FROM ".$table_term." JOIN ".$table_term_tax." ON ".$table_term.".term_id = ".$table_term_tax.".term_id AND ".$table_term_tax.".taxonomy = 'listings_location' AND ".$table_term.".name = '".$row_industry."'";
					
						$return_check_cat = $wpdb->get_results($check_cat);
						if(empty($return_check_cat)){
								$location_name = $row_industry;
								$cat_defaults = array(  'cat_name' => $location_name,  'category_description' => $location_name,  'category_nicename' => '',  'category_parent' => '',  'taxonomy' => 'listings_location' );
						
								// Create the listings categories
								$my_cat_id = wp_insert_category($cat_defaults); 
						}
						
						
						$table_term 		= $wpdb->prefix ."terms";	  		
						$table_term_tax 	= $wpdb->prefix ."term_taxonomy";				
						
						$select 			= "SELECT ". $table_term_tax .".term_taxonomy_id FROM ".$table_term." JOIN ".$table_term_tax." ON ".$table_term.".term_id = ".$table_term_tax.".term_id AND ".$table_term_tax.".taxonomy = 'listings_location' AND ".$table_term.".name = '".$row_industry."'";		
						
						$value = $wpdb->get_results($select);
						
						if(!empty($value)){
							 foreach($value as $new_data){
							 	$term_tax 	= $new_data->term_taxonomy_id;
								$table_name = $wpdb->prefix ."term_relationships";	  
								$insert 	=  "INSERT INTO ".$table_name." (object_id, term_taxonomy_id,term_order ) VALUES ('".$post_id."','".$term_tax."','0')";
								$wpdb->query($insert);
							 }
						}
						
						
						
//----------------------insert data into post meta----------------------------------------//

						add_post_meta( $post_id, 'location', $addr.'|'.$LatLng); 
						add_post_meta( $post_id, '_location', 'field_51dd6e7c52b8a' ); 
						add_post_meta( $post_id, 'telephone', $row_phone ); 
						add_post_meta( $post_id, 'mobile_phone_number', $row_fax ); 
						add_post_meta( $post_id, 'website', $row_web ); 
						add_post_meta( $post_id, 'city', $row_city ); 						
						add_post_meta( $post_id, 'sic_code',  $row_sic ); 						
						add_post_meta( $post_id, 'gender', $row_gender ); 						
						add_post_meta( $post_id, 'company_contact', $row_comp_cont ); 						
						add_post_meta( $post_id, 'company_title', $row_comp_title ); 						
						add_post_meta( $post_id, 'total_emp', $row_total_emp ); 						
						add_post_meta( $post_id, 'annual_sales', $row_sales ); 						
						add_post_meta( $post_id, 'company_email', $row_comp_email ); 	
						
						add_post_meta( $post_id, 'tdp_select_listing_category', $row_listing_cat); 
						add_post_meta( $post_id, '_tdp_select_listing_category', 'field_522f34f7bdc18' ); 
						
						//////////////////////////////////////////////////////////////////////////////////
						add_post_meta( $post_id, 'listing_is_featured', '0'); 
						add_post_meta( $post_id, '_listing_is_featured', 'field_522cbbdbdf1fe' ); 
						add_post_meta( $post_id, 'override_generated_address', ''); 
						add_post_meta( $post_id, '_override_generated_address', 'field_52fe599f74423' ); 
						add_post_meta( $post_id, 'listing_title', ''); 
						add_post_meta( $post_id, '_listing_title', 'field_522f30035c85b' ); 
						add_post_meta( $post_id, 'listing_tags', ''); 
						add_post_meta( $post_id, '_listing_tags', 'field_522f30035c81i' ); 
						add_post_meta( $post_id, 'tdp_select_listing_category', '523'); 
						add_post_meta( $post_id, '_tdp_select_listing_category', 'field_522f34f7bdc18' ); 
						add_post_meta( $post_id, 'testing_the_editor_field', ''); 
						add_post_meta( $post_id, '_testing_the_editor_field', 'field_5230848453094' ); 
						add_post_meta( $post_id, 'tdp_select_listing_location_area', '583'); 
						add_post_meta( $post_id, '_tdp_select_listing_location_area', 'field_522f34f7cccc' ); 
						add_post_meta( $post_id, 'coordinates_override', ''); 
						add_post_meta( $post_id, '_coordinates_override', 'field_51dd70a46b63c' ); 
						add_post_meta( $post_id, '_telephone', 'field_51dd70a46b630'); 
						add_post_meta( $post_id, '_mobile_phone_number', 'field_51dd70eb6b631' ); 
						add_post_meta( $post_id, '_website', 'field_51dd716b6b634'); 
						add_post_meta( $post_id, 'facebook', '' ); 
						add_post_meta( $post_id, '_facebook', 'field_fb'); 
						add_post_meta( $post_id, 'twitter', '' ); 
						add_post_meta( $post_id, '_twitter', 'field_twitter' ); 
						add_post_meta( $post_id, 'gplus', ''); 
						add_post_meta( $post_id, '_gplus', 'field_gplus' ); 						
						add_post_meta( $post_id, 'instagram', '' ); 
						add_post_meta( $post_id, '_instagram', 'field_instagram'); 
						add_post_meta( $post_id, 'foursquare', '' ); 
						add_post_meta( $post_id, '_foursquare', 'field_foursquare' ); 
						add_post_meta( $post_id, 'custom_fields_builder', '0'); 
						add_post_meta( $post_id, '_custom_fields_builder', 'field_522cbda8dd790' ); 
						add_post_meta( $post_id, 'monday', '' ); 
						add_post_meta( $post_id, '_monday', 'field_51dd71c96b636'); 
						add_post_meta( $post_id, 'tuesday', '' ); 						
						add_post_meta( $post_id, '_tuesday', 'field_51dd72036b637' ); 
						add_post_meta( $post_id, 'wednesday', ''); 
						add_post_meta( $post_id, '_wednesday', 'field_51dd720b6b638' ); 	
						add_post_meta( $post_id, 'thursday', '' ); 
						add_post_meta( $post_id, '_thursday', 'field_51dd72236b639'); 
						add_post_meta( $post_id, 'friday', '' ); 								
						add_post_meta( $post_id, '_friday', 'field_51dd722a6b63a' ); 
						add_post_meta( $post_id, 'saturday', ''); 
						add_post_meta( $post_id, '_saturday', 'field_51dd72316b63b' ); 	
						add_post_meta( $post_id, 'sunday', '' ); 
						add_post_meta( $post_id, '_sunday', 'field_51dd72376b63c'); 
						add_post_meta( $post_id, 'featured_image', '' ); 								
						add_post_meta( $post_id, '_featured_image', 'field_523174a834225' ); 
						add_post_meta( $post_id, 'listing_image_2', ''); 
						add_post_meta( $post_id, '_listing_image_2', 'field_listing_image2' );					
						add_post_meta( $post_id, 'listing_image_3', '' );		
						add_post_meta( $post_id, '_listing_image_3', 'field_listing_image3' ); 
						add_post_meta( $post_id, 'listing_image_4', ''); 
						add_post_meta( $post_id, '_listing_image_4', 'field_listing_image4' );
						add_post_meta( $post_id, 'listing_image_5', '' );	
						add_post_meta( $post_id, '_listing_image_5', 'field_listing_image5' ); 
						add_post_meta( $post_id, 'insert_video', 'novideo'); 
						add_post_meta( $post_id, '_insert_video', 'field_isvideo' );	

//-----------------------check query------------------------------------------------------------	
	
		$chk = mysql_fetch_array(mysql_query("SELECT * FROM complete_id"));
		if(empty($chk)){
			mysql_query("INSERT INTO complete_id (id) VALUES ('".$row['id']."')");
		}else{
			mysql_query("UPDATE complete_id SET id = '".$row['id']."'");
		}
	$end = 	$row['id'];
	}
	
$to 		        = 'hardeepscorpio@gmail.com';
$subject 	        = date('m/d/Y')." MariasPlace Cron Report";
$date 			= date('m/d/Y h:i:s a', time());
$headers 		= 'From: MariasPlace.com <ryan@mariasplace.com>' . "\r\n\\";
$start_query 	= mysql_query("SELECT * FROM complete where id = ".$start."");
	while ($start_val = mysql_fetch_assoc($start_query)) {
			$listingname 	= $start_val['CompanyName'];
			$City 			= $start_val['City'];
			$State 			= $start_val['State'];
}
$end_query 	= mysql_query("SELECT * FROM complete where id = ".$end."");
	while ($end_val = mysql_fetch_assoc($end_query)) {
			$end_listingname 	= $end_val['CompanyName'];
			$end_City 			= $end_val['City'];
			$end_State 			= $end_val['State'];

}
$message 	='<div  style="width:800px; margin:0 auto;">
  <div  style="float:left;background:-moz-linear-gradient(center top, #EEEEEE 0%, #FFFFFF 100%);border:1px solid #cccccc; width:90%;
background:-webkit-linear-gradient(center top, #EEEEEE 0%, #FFFFFF 100%);background:-o-linear-gradient(center top, #EEEEEE 0%, #FFFFFF 100%);">
  <div class="time" style="float: right;font-size: 13px;padding-top:10px;padding-left:10px;
    width: 40%;">
      <p style="padding:0;margin:0;">['.$date.' - '.$_SERVER['SERVER_ADDR'].']</p>
    </div>
<h1 style=" color: #000000; font-size: 15px;
    font-weight: bold;
    margin: 0;
    padding: 10px 0 10px 10px;
    text-transform: uppercase;">Directory Listings Added </h1>
       <div  style=" float: left;width: 10%;">
       <h4 style="margin: 0;padding-bottom: 10px;padding-left: 10px; color:#333333; font-weight:bold; font-size:13px; ">FROM</h4>
      <div style="margin: 0;padding-bottom: 10px;padding-left: 10px; color:#333333; font-weight:normal; font-size:13px; width:40%;">ID</div>
      <div  style="margin: 0;padding-bottom: 10px;padding-left: 10px; color:#333333; font-weight:normal; font-size:13px;width:40%;">Name</div>
      <div style="margin: 0;padding-bottom: 10px;padding-left: 10px; color:#333333; font-weight:normal; font-size:13px;width:40%;">City</div>
      <div  style="margin: 0;padding-bottom: 10px;padding-left: 10px; color:#333333; font-weight:normal; font-size:13px;width:40%;">State</div>
    </div>
    <div  style="float:left; width:40%; font-size:13px; margin-top:26px; color:#333333;">
	  <div  style="float:right; width:100%; padding-bottom:10px;">'.$start.'</div>
	  <div  style="float:right;width:100%;padding-bottom:10px;">'.$listingname.'</div>
	  <div  style="float:right;width:100%;padding-bottom:10px;">'.$City.'</div>
	  <div  style="float:right;width:100%;padding-bottom:10px;">'.$State.'</div>
  </div>
  <div  style=" float: left;width: 10%;">
      <h4 style="margin: 0;padding-bottom: 10px;padding-left: 10px; color:#333333; font-weight:bold; font-size:13px; ">TO</h4>
      <div style="margin: 0;padding-bottom: 10px;padding-left: 10px; color:#333333; font-weight:normal; font-size:13px; width:40%;">ID</div>
      <div style="margin: 0;padding-bottom: 10px;padding-left: 10px; color:#333333; font-weight:normal; font-size:13px;width:40%;">Name</div>
      <div style="margin: 0;padding-bottom: 10px;padding-left: 10px; color:#333333; font-weight:normal; font-size:13px;width:40%;">City</div>
      <div  style="margin: 0;padding-bottom: 10px;padding-left: 10px; color:#333333; font-weight:normal; font-size:13px;width:40%;">State</div>
    </div>
    <div  style="float:right; width:40%; font-size:13px; margin-top:26px; color:#333333;">
  <div  style="float:right; width:100%; padding-bottom:10px;">'.$end.'</div>
  <div  style="float:right;width:100%;padding-bottom:10px;">'.$end_listingname.'</div>
  <div  style="float:right;width:100%;padding-bottom:10px;">'.$end_City.'</div>
  <div  style="float:right;width:100%;padding-bottom:10px;">'.$end_State.'</div></div>
  
    <div class="clear" style="clear:both;"></div>
    <p style=" border-top: 1px dotted;margin: 0;padding: 5px 0;text-align: center; font-size:13px">Geocoding complete</p>
  </div>
 </div>';

wp_mail( $to, $subject, $message,  $headers);