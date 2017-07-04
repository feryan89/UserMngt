<?php
error_reporting(E_ALL ^ E_NOTICE);
@include "../config/config.inc.php";
@include "../session_member.php";

mysqli_query($con,"TRUNCATE chatz");
mysqli_close($con);
echo "<script language='javascript'>alert('Data Cleared.');</script>";
?>