<?php
error_reporting(E_ALL ^ E_NOTICE);
@include "../config/config.inc.php";
@include "../session_member.php";
session_start();
date_default_timezone_set('Australia/Victoria');

$id = $_SESSION['id'];
$text = $_POST['text'];
$text = strip_tags($text, '<img>');
$time = date("g:i A");

if (!empty($text)) {
	mysqli_query($con,"INSERT INTO chatz (`id`, `userID`, `text`, `time`) VALUES (NULL, '$id', '$text', '$time')");
}
				
$SQLshow = mysqli_query($con, "SELECT b.picture,
									a.text,
									a.time								
									FROM chatz a
									JOIN users b
									WHERE a.userID = b.id ORDER BY a.id");
$noUrut = 1;
while($row = mysqli_fetch_array($SQLshow)){
echo "<li class=\"left clearfix\">
		<span class=\"chat-img1 pull-left\">
			<img src=\"./profile/".$row[picture]."\" alt=\"User Avatar\" class=\"img-circle\">
		</span>
		<div class=\"chat-body1 clearfix\">
			<p>".$row[text]."</p>
			<div class=\"chat_time pull-right\">".$row[time]."</div>
		</div>
	</li>";
} 
mysqli_close($con);
?>