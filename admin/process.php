<?php
include('../config/config.php');
unset($_SESSION['sysErr']);
unset($_SESSION['sysData']);
$flg = false;
$p = $_GET['p'];//get page reference to execute the related condition

if($p == "addeditblog")
{
	foreach ($_POST as $k => $v )
	{
		if(is_array($v)){
			$v = implode(",",$v);
			$$k = $v;
		} else {
			$$k = addslashes($v);
		}
		$_SESSION['sysData'][$k] = $v;
	}
 	$enc_id = $id;
	if($id){
		$id = dec_password($id);
	}  
	$files_arr = array();
	$files_arr['img']['name'] = $_FILES['img']['name'];
	$files_arr['img']['tmp_name'] = $_FILES['img']['tmp_name'];
	$files_arr['img']['size'] = $_FILES['img']['size'];
	
	$imgname = "";
	$img_name = upload_img($files_arr,$dir_site_uploads,$imgname);

	if( $id > 0 )
	{
		$data = array();
		
		$data['title'] = $title;
		$data['name'] = $name;
		$data['email'] = $email;
		$data['tags'] = $tags;
		$data['description'] = $description;
		$data['created_date'] = $created_date;
		$data['img'] = $img_name;
		$data['status'] = $status;
		$condition = array();
		$condition['id'] = $id;
		$result = update_record($tblblog,$data,$condition);
		if($result)
		{
			$_SESSION['sysErr']['msg'] = "Record updated successfully";
		}
	}
	else
	{

		$data = array();
		$data['title'] = $title;
		$data['name'] = $name;
		$data['email'] = $email;
		$data['tags'] = $tags;
		$data['description'] = $description;
		$data['created_date'] = $created_date;
		$data['img'] = $img_name;
		$data['status'] = $status;
		$id = insert_record($tblblog,$data,"");
		if($id>0)
		{
			$_SESSION['sysErr']['msg'] = "Record added successfully";
		}
	}
	
	header("location:index.php?p=blog");
	exit;
}


if($p == "delblog")
{
	$id = dec_password($_GET['id']);
	$id = (int)$id;
	$data = array();
	$data['trash'] = '1';
	$condition = array();
	$condition['id'] = $id;
	$result = update_record($tblblog,$data,$condition);
	if($result){
		$_SESSION['sysErr']['msg'] = "Record deleted successfully";
	}
	header("location:index.php?p=blog");
	exit;
}

if($p == "addeditcoments")
{
	foreach ($_POST as $k => $v )
	{
		if(is_array($v)){
			$v = implode(",",$v);
			$$k = $v;
		} else {
			$$k = addslashes($v);
		}
		$_SESSION['sysData'][$k] = $v;
	}
 	$enc_id = $id;
	if($id){
		$id = dec_password($id);
	}  
	if( $id > 0 )
	{
		$data = array();
		
		$data['title'] = $title;
		$data['name'] = $name;
		$data['description'] = $description;
		$data['status'] = $status;
		$condition = array();
		$condition['id'] = $id;
		$result = update_record($tblcoments,$data,$condition);
		if($result)
		{
			$_SESSION['sysErr']['msg'] = "Record updated successfully";
		}
	}
	else
	{

		$data = array();
		$data['title'] = $title;
		$data['name'] = $name;
		$data['description'] = $description;
		$data['status'] = $status;
		$id = insert_record($tblcoments,$data,"");
		if($id>0)
		{
			$_SESSION['sysErr']['msg'] = "Record added successfully";
		}
	}
	
	header("location:index.php?p=coments");
	exit;
}


if($p == "delcoments")
{
	$id = dec_password($_GET['id']);
	$id = (int)$id;
	$data = array();
	$data['trash'] = '1';
	$condition = array();
	$condition['id'] = $id;
	$result = update_record($tblcoments,$data,$condition);
	if($result){
		$_SESSION['sysErr']['msg'] = "Record deleted successfully";
	}
	header("location:index.php?p=coments");
	exit;
}


if($p == "addeditservices")
{
	foreach ($_POST as $k => $v )
	{
		if(is_array($v)){
			$v = implode(",",$v);
			$$k = $v;
		} else {
			$$k = addslashes($v);
		}
		$_SESSION['sysData'][$k] = $v;
	}
 	$enc_id = $id;
	if($id){
		$id = dec_password($id);
	}  
	if(isset($_FILES['img']['name'])){
		$files_arr = array();
		$files_arr['img']['name'] = $_FILES['img']['name'];
		$files_arr['img']['tmp_name'] = $_FILES['img']['tmp_name'];
		$files_arr['img']['size'] = $_FILES['img']['size'];
		
		$imgname = "";
		$img_name = upload_img($files_arr,$dir_site_uploads,$imgname);
	}

	if( $id > 0 )
	{
		$data = array();
		
		$data['title'] = $title;
		$data['description'] = $description;
		if($img_name!=""){
			$data['img'] = $img_name;
		}
		$data['status'] = $status;
		$condition = array();
		$condition['id'] = $id;
		$result = update_record($tblservices,$data,$condition);
		if($result)
		{
			$_SESSION['sysErr']['msg'] = "Record updated successfully";
		}
	}
	else
	{

		$data = array();
		$data['title'] = $title;
		$data['description'] = $description;
		$data['img'] = $img_name;
		$data['status'] = $status;
		$id = insert_record($tblservices,$data,"");
		if($id>0)
		{
			$_SESSION['sysErr']['msg'] = "Record added successfully";
		}
	}
	
	header("location:index.php?p=services");
	exit;
}


if($p == "delservices")
{
	$id = dec_password($_GET['id']);
	$id = (int)$id;
	$data = array();
	$data['trash'] = '1';
	$condition = array();
	$condition['id'] = $id;
	$result = update_record($tblservices,$data,$condition);
	if($result){
		$_SESSION['sysErr']['msg'] = "Record deleted successfully";
	}
	header("location:index.php?p=services");
	exit;
}

if($p == "addeditteam")
{
	foreach ($_POST as $k => $v )
	{
		if(is_array($v)){
			$v = implode(",",$v);
			$$k = $v;
		} else {
			$$k = addslashes($v);
		}
		$_SESSION['sysData'][$k] = $v;
	}
 	$enc_id = $id;
	if($id){
		$id = dec_password($id);
	}  
	$files_arr = array();
	$files_arr['img']['name'] = $_FILES['img']['name'];
	$files_arr['img']['tmp_name'] = $_FILES['img']['tmp_name'];
	$files_arr['img']['size'] = $_FILES['img']['size'];
	
	$imgname = "";
	$img_name = upload_img($files_arr,$dir_site_uploads,$imgname);
	resize($img_name,$dir_site_uploads);
	convertImage($dir_site_uploads.$img_name,$dir_site_uploads.$img_name);
	resize_and_crop($dir_site_uploads.$img_name,$dir_site_uploads.'thumb_'.$img_name,375,260);

	if( $id > 0 )
	{
		$data = array();
		
		$data['profession'] = $profession;
		$data['name'] = $name;
		$data['email'] = $email;
		$data['description'] = $description;
		$data['img'] = $img_name;
		$data['status'] = $status;
		$condition = array();
		$condition['id'] = $id;
		$result = update_record($tblteam,$data,$condition);
		if($result)
		{
			$_SESSION['sysErr']['msg'] = "Record updated successfully";
		}
	}
	else
	{

		$data = array();
		$data['profession'] = $profession;
		$data['name'] = $name;
		$data['email'] = $email;
		$data['description'] = $description;
		$data['img'] = $img_name;
		$data['status'] = $status;
		$id = insert_record($tblteam,$data,"");
		if($id>0)
		{
			$_SESSION['sysErr']['msg'] = "Record added successfully";
		}
	}
	
	header("location:index.php?p=team");
	exit;
}


if($p == "delbteam")
{
	$id = dec_password($_GET['id']);
	$id = (int)$id;
	$data = array();
	$data['trash'] = '1';
	$condition = array();
	$condition['id'] = $id;
	$result = update_record($tblteam,$data,$condition);
	if($result){
		$_SESSION['sysErr']['msg'] = "Record deleted successfully";
	}
	header("location:index.php?p=team");
	exit;
}

if($p == "addeditsetting")
{
	foreach ($_POST as $k => $v )
	{
		$$k = addslashes(htmlspecialchars($v));
		$_SESSION['sysData'][$k] = $v;
	}
	$enc_id = $id;
	if($id){
		$id = dec_password($id);
	}
	$flg = false;
	
	if(!$value_name)
	{
		$_SESSION['sysErr']['value_name'] = "Please Enter Value";
		$flg = true;
	}
	if($flg)
	{
		header("location:index.php?p=addeditsetting&id=".$enc_id);exit;
	}
	if( $id > 0 )
	{
		$data = array();
		$data['option_name'] = $option_name;
		$data['value_name'] = $value_name;
		$condition = array();
		$condition['id'] = $id;
		$result = update_record($tblsettings,$data,$condition);
		if($result)
		{
			$_SESSION['sysErr']['msg'] = "Record updated successfully";
		}
	}
	else
	{
		$data = array();
		$data['option_name'] = $option_name;
		$data['value_name'] = $value_name;
		$id = insert_record($tblsettings,$data);
		if($id>0)
		{
			$_SESSION['sysErr']['msg'] = "Record added successfully";
		}
	}
	
	header("location:index.php?p=setting");
	exit;
} 
if($p == "delcontact")
{
	$id = dec_password($_GET['id']);
	$id = (int)$id;
	$data = array();
	$data['trash'] = '1';
	$condition = array();
	$condition['id'] = $id;
	$result = update_record($tblcontact,$data,$condition);
	if($result){
		$_SESSION['sysErr']['msg'] = "Record deleted successfully";
	}
	header("location:index.php?p=contact");
	exit;
}
?>