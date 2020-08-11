<?php
include("../config/config.php");

if(isset($_SESSION['adminrecord']) and $_SESSION['adminrecord']['id']>0){
	header("location:index.php");
}
if(isset($_POST['submit']))
{
	$email = $_POST['email'];
	$password = enc_password($_POST['password']);
	$where = "email='".$email."' and password='".$password."' and status='1'";
	$result = get_records($tbladmin,$where);
	if(count($result)>0)
	{ 
		$_SESSION['adminrecord'] = $result[0];
		header("location: index.php");		
	}
	else
	{
		$err_msg = "Invalid email or password !";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $cons_sitetitle;?></title>
<style>
#login_div {
    position:fixed;
    top: 50%;
    left: 50%;
    width:30em;
    margin-top: -9em; /*set to a negative number 1/2 of your height*/
    margin-left: -15em; /*set to a negative number 1/2 of your width*/
	padding:20px;
    border: 1px solid #ccc;
    background-color: #f3f3f3;
	text-align:center;
}
.form_flg { width:60%; height:30px; margin-bottom:20px; }
.err_msg { background-color:#EEE; color:#F00; line-height:30px; padding:10px; margin:5px; }
</style>
</head>

<body>
<form action="" method="post">
<div id="login_div">
	<h1>Login</h1>
    <?php
	if(isset($err_msg)){
		echo '<div class="err_msg">'.$err_msg.'</div>';
	}
	show_errors();
	?>
    <div><input type="email" class="form_flg" name="email" placeholder="Email" value="" /></div>
    <div><input type="password" class="form_flg" name="password" placeholder="password" value="" /></div>
    <div><input type="submit" name="submit" value="Submit" />
</div>
</form>
</body>
</html>
