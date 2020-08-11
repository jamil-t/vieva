<?php

function upload_img($file,$path="",$img_name="",$allowed_types=array('jpg','jpeg','png','gif')){
	$type = @strtolower(end(explode('.',$file['img']['name']))); // partition before and after .
	if( in_array($type,$allowed_types) ){
		$rand = rand(1111,9999);
		$imgnew = ($img_name)?$img_name.".".$type:date("YmdHis").$rand.".".$type;
		if( move_uploaded_file($file['img']['tmp_name'],$path.$imgnew) ) // upload and save in dir folder
		{
			return $imgnew;
		} else {
			$_SESSION['sysErr']['img'] = "File ".$file['img']['name']." uploading Error";
		}
	} else {
		$allow = implode(', ',$allowed_types);
		$_SESSION['sysErr']['img'] = "Please only upload $allow files";
	}
	return false;
}
function resize($img,$path,$new_width="792",$upload_path=""){
	if(!$upload_path){
		$upload_path = $path;
	}
	$img_detail = getimagesize($path.$img);
	$width_orig = $img_detail[0];
	$height_orig = $img_detail[1];
	$mime = $img_detail['mime'];
	//ne size
	
	$new_height = 594;
	$im = imagecreatetruecolor($new_width,$new_height);
	
	if($mime=="image/jpeg"){
		echo $image = imagecreatefromjpeg($path.$img);
		imagecopyresampled($im, $image, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
		imagejpeg($im,$upload_path.$img);
	} else if($mime=="image/png"){
		$image = imagecreatefrompng($path.$img);
		imagealphablending($im, false);
		imagesavealpha($im, true);
		imagecopyresampled($im, $image, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
		imagepng($im,$upload_path.$img);
	} else if($mime=="image/gif"){
		$image = imagecreatefromgif($path.$img);
		$transparent = imagecolorallocatealpha($im, 0, 0, 0, 127);
		imagefill($im, 0, 0, $transparent);
		imagealphablending($im, true);
		imagecopyresampled($im, $image, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
		imagegif($im,$upload_path.$img);
	} else {
		return false;
	}
	//save memory
	imagedestroy($im);
}

function resize_and_crop($original_image_url, $thumb_image_url, $thumb_w, $thumb_h, $quality=100)
{
	$img_detail = getimagesize($original_image_url);
	$width_orig = $img_detail[0];
	$height_orig = $img_detail[1];
	$mime = $img_detail['mime'];
	//global $web_site_uploads;
	//age_url = $web_site_uploads.$thumb_image_url;
	//echo $original_image_url.$thumb_image_url,$thumb_w,$thumb_h;
    // ACQUIRE THE ORIGINAL IMAGE: http://php.net/manual/en/function.imagecreatefromjpeg.php

	if($mime=="image/jpeg"){
    	$original = imagecreatefromjpeg($original_image_url);
    }
    else if($mime=="image/png"){
    	$original = imagecreatefrompng($original_image_url);
    }

    
    if (!$original) return FALSE;

    // GET ORIGINAL IMAGE DIMENSIONS
    list($original_w, $original_h) = getimagesize($original_image_url);

    // RESIZE IMAGE AND PRESERVE PROPORTIONS
    $thumb_w_resize = $thumb_w;
    $thumb_h_resize = $thumb_h;
    if ($original_w > $original_h)
    {
        $thumb_h_ratio  = $thumb_h / $original_h;
        $thumb_w_resize = (int)round($original_w * $thumb_h_ratio);
    }
    else
    {
        $thumb_w_ratio  = $thumb_w / $original_w;
        $thumb_h_resize = (int)round($original_h * $thumb_w_ratio);
    }
    if ($thumb_w_resize < $thumb_w)
    {
        $thumb_h_ratio  = $thumb_w / $thumb_w_resize;
        $thumb_h_resize = (int)round($thumb_h * $thumb_h_ratio);
        $thumb_w_resize = $thumb_w;
    }

    // CREATE THE PROPORTIONAL IMAGE RESOURCE
    $thumb = imagecreatetruecolor($thumb_w_resize, $thumb_h_resize);
    if (!imagecopyresampled($thumb, $original, 0,0,0,0, $thumb_w_resize, $thumb_h_resize, $original_w, $original_h)) return FALSE;

    // ACTIVATE THIS TO STORE THE INTERMEDIATE IMAGE
    // imagejpeg($thumb, 'RAY_temp_' . $thumb_w_resize . 'x' . $thumb_h_resize . '.jpg', 100);

    // CREATE THE CENTERED CROPPED IMAGE TO THE SPECIFIED DIMENSIONS
    $final = imagecreatetruecolor($thumb_w, $thumb_h);

    $thumb_w_offset = 0;
    $thumb_h_offset = 0;
    if ($thumb_w < $thumb_w_resize)
    {
        $thumb_w_offset = (int)round(($thumb_w_resize - $thumb_w) / 2);
    }
    else
    {
        $thumb_h_offset = (int)round(($thumb_h_resize - $thumb_h) / 2);
    }

    if (!imagecopy($final, $thumb, 0,0, $thumb_w_offset, $thumb_h_offset, $thumb_w_resize, $thumb_h_resize)) return FALSE;

    // STORE THE FINAL IMAGE - WILL OVERWRITE $thumb_image_url
    if($mime=="image/jpeg"){
    	imagejpeg($final, $thumb_image_url, $quality);
    }
    else if($mime=="image/png"){
    	imagealphablending($final, false);
		imagesavealpha($final, true);
		imagecopyresampled($thumb, $original, 0,0,0,0, $thumb_w_resize, $thumb_h_resize, $original_w, $original_h);
    	imagepng($final, $thumb_image_url, $quality);
    }
    // if (!imagejpeg($final, $thumb_image_url, $quality)) return FALSE;
    return TRUE;
}
function convertImage($originalImage, $outputImage, $quality=100)
{
    // jpg, png, gif or bmp?
    $exploded = explode('.',$originalImage);
    $ext = $exploded[count($exploded) - 1]; 

    if (preg_match('/jpg|jpeg/i',$ext))
        $imageTmp=imagecreatefromjpeg($originalImage);
    else if (preg_match('/png/i',$ext))
        $imageTmp=imagecreatefrompng($originalImage);
    else if (preg_match('/gif/i',$ext))
        $imageTmp=imagecreatefromgif($originalImage);
    else if (preg_match('/bmp/i',$ext))
        $imageTmp=imagecreatefrombmp($originalImage);
    else
        return 0;

    // quality is a value from 0 (worst) to 100 (best)
    imagejpeg($imageTmp, $outputImage, $quality);
    imagedestroy($imageTmp);

    return 1;
}
function admin_login_check(){
	if($_SESSION['adminrecord']['id']>0){
		return true;
	} else {
		$_SESSION['err_msg'] = "Please login your account";
		header("location:login.php");
	}
}
function show_errors(){
	///echo "<pre>"; print_r($_SESSION['sysErr']); echo "</pre>";
	if(isset($_SESSION['sysErr'])){
		if(count($_SESSION['sysErr'])>0){
			foreach($_SESSION['sysErr'] as $k=>$v){
				if(!is_array($v)){
					echo '<div class="row"><div class="col-md-12 err_msg">'.$v.'</div></div>';
					unset($_SESSION['sysErr'][$k]);
				}
			}
		}
	}
}
function redirect($page){
	$url = makepage_url($page);
	echo '<script>window.location="'.$url.'";</script>';
}
function dates_duration($dated,$type='ago')
{
	$date1 = $dated;
	$date2 = date("Y-m-d H:i:s");
	$diff = strtotime($date2) - strtotime($date1);
	if($diff>=0 and $type=='remaining')
	{
		return 'Time finish';
	}
	$diff = abs($diff);
	
	$years   = floor($diff / (365*60*60*24));
	if($years>0)
	{
		return $years.' years '.$type;
	}
	$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	if($months>0)
	{
		return $months.' months '.$type;
	}
	$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	if($days>0)
	{
		return $days.' days '.$type;
	}
	$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
	if($hours>0)
	{
		return $hours.' hours '.$type;
	}
	$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
	if($minuts>0)
	{
		return $minuts.' minuts '.$type;
	}
	$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60));
	if($seconds>0)
	{
		return $seconds.' seconds '.$type;
	}
}

function show_price($price)
{
	global $cons_currency;
	return $cons_currency.$price;
}
function get_product_imgs($id,$limit='')
{
	global $tblproduct_images, $web_site_uploads;
	$imgs = array();
	$product_images = get_records($tblproduct_images,"product_id='".$id."' and trash='0'","main DESC",$limit);
	if(count($product_images)>0){
		foreach ($product_images as $v) {
			$imgs[] = $web_site_uploads.$v['img'];
		}
	}
	
	else {
		$imgs[] = $web_site_uploads."default_product.jpg";
	}
	return $imgs;
}
function get_upload_img($img)
{
	global $web_site_uploads;
	$img = ($img)?$img:"default_product.jpg";
	return $web_site_uploads.$img;
}
function get_user_img($img)
{
	global $web_site_uploads;
	$img = ($img)?$img:"user.jpg";
	return $web_site_uploads.$img;
}
function get_product_img($img)
{
	global $web_site_uploads;
	$img = ($img)?$img:"default_product.jpg";
	return $web_site_uploads.$img;
}
function get_product_featured($status=0)
{
	$status_arr = array('Simple','Featured');
	return $status_arr[$status];
}
function get_product_status($status=0)
{
	$status_arr = array('Pending','New','Used');
	return $status_arr[$status];
}
function get_category_status($status=0)
{
	$status_arr = array('Inactive','Active');
	return $status_arr[$status];
}
function get_store_status($status=0)
{
	$status_arr = array('Inactive','Active');
	return $status_arr[$status];
}
function get_user_status($status=0)
{
	$status_arr = array('Inactive','Active');
	return $status_arr[$status];
}

function update_date($date,$interval="0",$type="day")
{
	$sql = "SELECT DATE_ADD('".$date."', INTERVAL $interval $type) as newdate";
	$record = sql($sql);
	return $record[0]['newdate'];
}
function compare_dates($date1,$date2)
{
	$sql = "SELECT DATEDIFF( '".$date1."', '".$date2."' ) AS days";
	$record = sql($sql);
	return $record[0]['days'];
}
function dateFormat($date,$format='Y-m-d')
{
	if($date!="0000-00-00"){
		$date = date($format,strtotime($date));
		return $date;
	} else {
		return $date;
	}
}
function numberFormat($num)
{
	$dn=number_format($num, 2, '.', '');
	$num_d = number_format($dn, 2, '.', ',');
	
	return $num_d;
}
function pr($arr=array(),$exit=""){
	echo "<pre>";
	print_r($arr);
	echo "</pre>";
	if($exit){ exit; }
}

function enc_password($pass)
{
	global $salt;
	$newpass = "";
	if($pass)
	{
		$newpass = base64_encode($pass);
	}
	return $newpass;
}

function dec_password($pass)
{
	global $salt;
	$newpass = "";
	if($pass)
	{
		$newpass = base64_decode($pass);
	}
	return $newpass;
}

function getsettings($option)
{
	global $tblsettings;
	$where = "`option_name`='".$option."'";
	$setting = get_records($tblsettings,$where);
	if(count($setting)>0){
		return $setting[0]['value_name'];
	}
	return "";
}

function makepage_url($p="index",$query="")
{
	$p = ($p)?$p:"home";
	$url = $p.'.php';
	return $url.$query;
}
function getpage_url()
{
	$phpself = $_SERVER['REQUEST_URI'];
	$phpself = explode("/",$phpself);
	$ind = count($phpself)-1;
	$url = (count($phpself)>0)?$phpself[$ind]:'index.php';
	return $url;
}

function getpagename()
{
	$phpself = $_SERVER['PHP_SELF'];
	list($phpself) = explode(".php",$phpself);
	$phpself = explode("/",$phpself);
	$count = count($phpself)-1;
	return $phpself[$count];
}

function formspecialchars($var)
{
	$pattern = '/&(#)?[a-zA-Z0-9]{0,};/';
   
	if (is_array($var)) {    // If variable is an array
		$out = array();      // Set output as an array
		foreach ($var as $key => $v) {     
			$out[$key] = formspecialchars($v);         // Run formspecialchars on every element of the array and return the result. Also maintains the keys.
		}
	} else {
		$out = $var;
		while (preg_match($pattern,$out) > 0) {
			$out = htmlspecialchars_decode($out,ENT_QUOTES);      
		}                            
		$out = htmlspecialchars(stripslashes(trim($out)), ENT_QUOTES,'UTF-8',true);     // Trim the variable, strip all slashes, and encode it
	   
	}
   
	return $out;
}
///////////////////////////////////////////////////////////////
function sendmail($userid,$type,$confirmationLink="")
{
	global $tblusers,$tblemails;
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	$where = "id='".$userid."'";
	$user = get_records($tblusers,$where);
	if(count($user)>0){
		$user = $user[0];
		$name = $user['name'];
		$email = $user['email'];
		$pass = $user['pass'];
		
		$where = "type='".$type."'";
		$content = get_records($tblemails,$where);
		$content = $content[0];
		$adminName = $content['adminname'];
		$adminEmail = $content['adminemail'];
		$subject = $content['subject'];
		$body = $content['body'];
		
		$headersuser = $headers.'From: '.$adminName.' <'.$adminEmail.'>' . "\r\n";
		
		$message = str_replace("{{Name}}",$fname,$body);
		$message = str_replace("{{Email}}",$email,$message);
		$message = str_replace("{{Password}}",$pass,$message);
		$message = str_replace("{{ConfirmationLink}}",$confirmationLink,$message);
		$message = nl2br($message);
		
		$mailsent = @mail($email,$subject,$message,$headersuser);
	}
}

function generateCode($characters) 
{
	/* list all possible characters, similar looking characters and vowels have been removed */
	$possible = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
	$code = '';
	$i = 0;
	while ($i < $characters) 
	{ 
		$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
		$i++;
	}
	return $code;
}

function vpemail ($valoare)
{
	// Email
	if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $valoare) || empty($valoare))
	{
		return true;
	}
}

function showstring($val,$num="",$break="") ///Using this in SS
{
	$val = stripslashes($val);
	if($break)
	{
		$val = wordwrap($val,$num);
	}
	else if($num<strlen($val) and $num>0)
	{
		$val = substr($val,0,$num).".......";
	}
	else
	{
		$val = $val;
		$val = nl2br($val);
	}
	return $val;
}

function splitlimit($string, $length = 50, $ellipsis = '...')
{
   if (strlen($string) > $length)return substr($string, 0, $length) . ' ' . $ellipsis;
   else return $string;
}

function get_shop_title($gender,$brand,$user,$store_id)
{
	$shop_title ='';
	$list_shop_title ='';
	if ($brand>0)
    { 
      global $tblbrand;
      $brand_record = get_records($tblbrand,"id='".$brand."'","","","*","");
      $brand_name = $brand_record[0]["brand_name"];
      

      $brand_logo = 'https://itizen-production.s3.amazonaws.com/uploads/user/profile_image/445202/Steve_Madden.png';//$brand_record[0]["brand_logo"];
      $shop_title = '<div class="ShopAvatar">
          <div class="ShopAvatar-image js-lazy-load" data-img-title="'.$brand_name.'"><img src="'.$brand_logo.'" alt="'.$brand_name.'"></div>
          <h1 data-test="shop-name" class="ShopAvatar-title" data-test-page-header="">
            '.$brand_name.'
          </h1>
        </div>';
      
    }else if ($store_id>0){
    	global $tblstore;
    	$store_record = get_records($tblstore,"id='".$store_id."'","","","*","");
      	$store_name = $store_record[0]["title"];

      	$brand_logo = 'https://itizen-production.s3.amazonaws.com/uploads/user/profile_image/445202/Steve_Madden.png';//$brand_record[0]["brand_logo"];
      $shop_title = '<div class="ShopAvatar">
          <div class="ShopAvatar-image js-lazy-load" data-img-title="'.$store_name.'"><img src="'.$brand_logo.'" alt="'.$store_name.'"></div>
          <h1 data-test="shop-name" class="ShopAvatar-title" data-test-page-header="">
            '.$store_name.'
          </h1>
        </div>';
    }
    else if ($user>0)
    { 
      global $tblusers;
      $user= get_records($tblusers,"id='".$user."'","","","*","");
      $user_name = $user[0]['name'];
      $user_image= $user[0]['image'];
      $description = $user[0]['description'];

      $shop_title = '<div class="Container Shop Pos(r)">

  <div class="ShopAvatar">
      <div class="ShopAvatar-banner" data-test-default-banner=""></div>

      <div class="ShopAvatar-cta">
        <a class="Button Button--small Button--inline Button--icon Button--defaultBorder Button--round" data-test-message-user="" href="#">
  <img class="Button__Icon" src="assets/images/noun_paperplane_1576277_000000.svg" alt="Paper airplane">
  <span class="Button__Body">Send Message</span>
</a>
      </div>

    <div class="ShopAvatar-image js-lazy-load" data-img-src="" data-img-title="Heartthrob Chris 💙">
    <img src="https://itizen-production.s3.amazonaws.com/uploads/user/profile_image/231893/1577750169.159525" alt="Heartthrob Chris 💙"></div>

    <h1 data-test="shop-name" class="ShopAvatar-title">
      💙  '.$user_name.'  💙
    </h1>

  </div>

    <p data-test="shop-bio" class="Shop--bio">
      '.$description.'
    </p>

    <div class="Ta(c) xs-D(b) D(n) Mt(u1)">
      <a class="Button Button--small Button--inline Button--icon Button--defaultBorder Button--round" data-test-message-user="" href="#">
  <img class="Button__Icon" src="assets/images/noun_paperplane_1576277_000000.svg" alt="Paper airplane">
  <span class="Button__Body">Send Message</span>
</a>
    </div>
</div>';
// echo($shop_title);exit();
    }
    else if($gender=='5')
      $shop_title = 'Shop For Baby';
    else if($gender=='2')
      $shop_title = 'Shop For Mama';
	else if($gender=='3')
	  $shop_title = 'Shop For Girl';
	else if($gender=='4')
	  $shop_title = 'Shop For Boy';
    else
      $shop_title = 'Shop For All';

  	if ($brand!='' || $user!=''){

    	$list_shop_title = $shop_title;
  	}
    else
    	$list_shop_title = '<h1 class="Ta(c)">'.$shop_title.'</h1>';

	return $list_shop_title;
}

?>