<?php
error_reporting(E_ALL ^ E_NOTICE);
@include "../config/config.inc.php";
@include "../session_member.php";

$act = $_GET['act'];
$id = $_GET['id'];

// Sanitize $_GET parameters to avoid XSS and other attacks
if(strpos(strtolower($id), 'union') || strpos(strtolower($id), 'select') || strpos(strtolower($id), '/*') || strpos(strtolower($id), '*/')) {
   echo "<div class=\"alert alert-warning col-lg-3 col-offset-6 centered col-centered\">
  <strong>Warning!</strong> SQL injection attempt detected.</div>";
   die;
}

if(isset($_FILES["file"]["type"])) {
	$validextensions = array("jpeg", "jpg", "png");
	$temporary = explode(".", $_FILES["file"]["name"]);
	$file_extension = end($temporary);
	if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
	) && ($_FILES["file"]["size"] < 1000000) // Approx. 1gb files can be uploaded.
	&& in_array($file_extension, $validextensions)) {
		if ($_FILES["file"]["error"] > 0) {
			echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
		} else {
			if (file_exists("../profile/" . $_FILES["file"]["name"])) {
				echo "<strong>Warning!</strong> ".$_FILES["file"]["name"]." <b>already exists.</b>.";
			} else {
				$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
				$targetPath = "../profile/".$_FILES['file']['name']; // Target path where file is to be stored
				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
				echo "<strong>Success!</strong> Image Uploaded Successfully...!!";
				// echo "<br/><b>File Name:</b> " . $_FILES["file"]["name"] . "<br>";
				// echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
				// echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
				// echo "<b>Temp file:</b> " . $_FILES["file"]["tmp_name"] . "<br>";
				$filename = $_FILES["file"]["name"];
			}
		}		
	} else {
		 echo "<strong>Warning!</strong> Invalid file Size or Type.";
		$filename = "no-image.png";
	}
}

if ($act=='del'){
	mysqli_query($con,"DELETE FROM users WHERE id='$id'");
	mysqli_close($con);
	echo "<script language='javascript'>alert('Data Deleted.');</script>";
}

if ($act=='add'){
	// make sure the username is unique
	$query = mysqli_query($con,"SELECT * FROM users WHERE username = '$_POST[username]'");
	$match = mysqli_num_rows($query);
	$r     = mysqli_fetch_array($query);
	mysqli_close($con);
	if ($match > 0){
		echo "<script language='javascript'>alert('This Username user has already been taken, Please choose another.');document.location='./page.php?page=users';</script>";
		exit();
	}
	mysqli_query($con,"INSERT INTO users (`id`, 
									`username`, 
									`password`, 
									`firstname`, 
									`lastname`, 
									`status`, 
									`picture`, 
									`department`, 
									`hiredate`, 
									`birthdate`, 
									`gender`, 
									`address`, 
									`email`, 
									`phone`)
							VALUES(NULL,
								   '$_POST[username]',
								   '$_POST[password]',
								   '$_POST[firstname]',
								   '$_POST[lastname]',
								   '$_POST[optradio]',
								   '$filename',
								   '$_POST[department]',
								   '$_POST[hiredate]',
								   '$_POST[birthdate]',
								   '$_POST[gender]',
								   '$_POST[address]',
								   '$_POST[email]',
								   '$_POST[phone]')");
	mysqli_close($con);
	echo "<script language='javascript'>alert('Data Added.');document.location='./page.php?page=users';</script>";
}

if ($act=='update'){
	mysqli_query($con,"UPDATE `users` SET `username` = '$_POST[username]',
										`password` = '$_POST[password]',
										`firstname` = '$_POST[firstname]',
										`lastname` = '$_POST[lastname]',
										`status` = '$_POST[optradio]',
										`picture` = '$filename',
										`department` = '$_POST[department]',
										`hiredate` = '$_POST[hiredate]',
										`birthdate` = '$_POST[birthdate]',
										`gender` = '$_POST[gender]',
										`address` = '$_POST[address]',
										`email` = '$_POST[email]',
										`phone` = '$_POST[phone]'
									WHERE id='$_POST[id]'");
	mysqli_close($con);
	echo "<script language='javascript'>alert('Data Updated.');document.location='./page.php?page=users';</script>";
}
?>
