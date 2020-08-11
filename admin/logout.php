<?php
session_start();
$_SESSION['adminrecord'] = "";
session_destroy();
header("location: login.php");
?>