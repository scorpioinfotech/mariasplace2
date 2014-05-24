<?php if(!session_id()) @session_start();
ob_start();

// look up for the path
require_once('config.php');
require_once('qqFileUploader.php');

/** Allow for cross-domain requests (from the frontend). */
send_origin_headers();

if ( !current_user_can('upload_files') )
	wp_die( __( 'You do not have permission to upload files.' ) );

$max_upload = (int)(ini_get('upload_max_filesize'));
$max_post = (int)(ini_get('post_max_size'));
$memory_limit = (int)(ini_get('memory_limit'));
$upload_mb = min($max_upload, $max_post, $memory_limit);

$wp_upload_dir = wp_upload_dir();

$upload_path = $wp_upload_dir['path'];

$uploader = new qqFileUploader();

// Specify the list of valid extensions, ex. array("jpeg", "xml", "bmp")
$uploader->allowedExtensions = array();

// Specify max file size in bytes.
$uploader->sizeLimit = ($upload_mb * 1024 * 1024);

// Specify the input name set in the javascript.
$uploader->inputName = 'qqfile';

// If you want to use resume feature for uploader, specify the folder to save parts.
$uploader->chunksFolder = 'chunks';

$res = $uploader->handleUpload($upload_path);

// To return a name used for uploaded file you can use the following line.
$filename = $uploader->getUploadName();

$file = $upload_path . '/' . $filename;

// Set correct file permissions
$stat = stat( dirname( $file ));
$perms = $stat['mode'] & 0000666;
@ chmod( $file, $perms );

$wp_filetype = wp_check_filetype(basename($filename), null );

$attachment = array(
	'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ), 
	'post_mime_type' => $wp_filetype['type'],
	'post_title' => preg_replace('/\.[^.]+$/', '', basename( $filename )),
	'post_content' => '',
	'post_status' => 'inherit'
);

$attach_id = wp_insert_attachment( $attachment, $file );
// you must first include the image.php file
// for the function wp_generate_attachment_metadata() to work
require_once(ABSPATH . 'wp-admin/includes/image.php');
$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
wp_update_attachment_metadata( $attach_id, $attach_data );

$result = array(
	'attachment' => $attachment,
	'attach_id' => $attach_id,
	'attach_data' => $attach_data
);

header('Content-type: application/json');
echo json_encode($result);
?>