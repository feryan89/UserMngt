<?php
session_start();
if($_SESSION['username'] == '' ){
	echo "<script>window.alert('you must login first!');</script>";
	die();
}
?>