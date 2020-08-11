<?php
session_start();
///error_reporting(0);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

$dir_root = $_SERVER['DOCUMENT_ROOT'];
$web_root = "http://".$_SERVER['HTTP_HOST']."/";

$root_folder = "vieva/";
$tblprefix = "vieva_";

$web_site = $web_root.$root_folder;
$dir_site = $dir_root."/".$root_folder;

// Stripe API configuration  
define('STRIPE_API_KEY', 'sk_test_Yau9gWwuHAEq5bCA6W9Jbath0078hZRZQn'); 
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_im8q7ocgFKpJJLwmyg62zaDf00ouq43DUR');
$currency = "USD"; 
if($web_site == "http://localhost/".$root_folder)
{
	$web_live = "no";
	
	$db_servername = "localhost";
	$db_username = "root";
	$db_password = "";
	$db_database = "vieva";
	
	$fckpath_php = $web_site."FCKeditor/fckeditor.php";
	$fckpath = $dir_site."FCKeditor/";
} else {
	$web_live = "yes";
	$dir_root = $_SERVER['DOCUMENT_ROOT']."/demos/";
	$web_root = "http://".$_SERVER['HTTP_HOST']."/demos/";
	
	$web_site = $web_root.$root_folder;
	$dir_site = $dir_root."".$root_folder;
	
	$db_servername = 'ask2know13177.ipagemysql.com';
	$db_username = 'u_softbuildedemo';
	$db_password = 'T44_deses';
	$db_database = 'db_softbuild_demo';
}
// Create connection
$conn = mysqli_connect($db_servername, $db_username, $db_password, $db_database);
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$salt = "helsdfasdladfasdfsad4565554564werwerewrwefdsfsdfo";

$web_site_common = $web_site."common/";
$dir_site_common = $dir_site."common/";

$web_site_uploads = $web_site."uploads/";
$dir_site_uploads = $dir_site."uploads/";

$includefiles = $dir_site_common."includefiles.php";
include($includefiles); 
?>