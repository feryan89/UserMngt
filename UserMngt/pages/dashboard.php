<?php
error_reporting(E_ALL ^ E_NOTICE);
@include "./config/config.inc.php";

$result = mysqli_query($con,"SELECT * FROM users");
$users = mysqli_num_rows($result);

$result = mysqli_query($con,"SELECT * FROM users WHERE status = 'Actived'");
$active = mysqli_num_rows($result);

$result = mysqli_query($con,"SELECT * FROM users WHERE status = 'Inactive'");
$inactive = mysqli_num_rows($result);
?>
<div class="row">	                   
	<div class="col-lg-3 dash-widget" style="padding-bottom: 20px;">
        <div class="label-primary" style="padding: 5px; border-radius: 6px;">
            <button class="btn btn-primary btn-lg btn-block disabled" role="button" style="padding: 2px;">
                <div class="fa fa-users fa-3x"></div>
				<div style="padding:2px;"><?php echo "$users"; ?></div>
                <div class="icon-label">Total Users</div>
            </button>
        </div>
    </div>	                    
	<div class="col-lg-3 dash-widget" style="padding-bottom: 20px;">
          <div class="label-primary" style="padding: 5px; border-radius: 6px;">
            <button class="btn btn-info btn-lg btn-block disabled" role="button" style="padding: 2px;">
            <div class="fa fa-user fa-3x"></div>
			<div style="padding:2px;"><?php echo "$active"; ?></div>
            <div class="icon-label">Active Users</div>
          </div>
        </div>                   
	<div class="col-lg-3 dash-widget" style="padding-bottom: 20px;">
        <div class="label-primary" style="padding: 5px; border-radius: 6px;">
            <button class="btn btn-danger btn-lg btn-block disabled" role="button" style="padding: 2px;">
                <div class="fa fa-user-times fa-3x"></div>
				<div style="padding:2px;"><?php echo "$inactive"; ?></div>
                <div class="icon-label">Inactive Users</div>
            </button>
        </div>
    </div>               
	<div class="col-xs-12 col-sm-9">
		<div class="chat-panel panel panel-success">			
            <div class="chat_area">
				<ul class="list-unstyled">
					<!-- Chat Logs -->
				</ul>
			</div><!--chat_area-->
			<div class="message_write">
				<div class="input-group">
					<input id="usermsg" name="usermsg" type="text" class="form-control" placeholder="Type your message here .." value="">
					<span class="input-group-btn">							
						<input name="submitmsg" id="submitmsg" type="submit" class="btn btn-warning" value="Send">
					</span>
				</div>
			</div>
			<div class="row">
				<div class="pull-left" style="padding-left: 30px; padding-bottom: 20px">
					<a href="#" OnClick="FunctionClearChatz()">
						<button type="button" class="btn btn-primary">Clear Chatz <i class="fa fa-trash-o "></i></button>
					</a>
				</div>
			</div>
		</div>
	</div>	                   
	<div class="col-xs-12 col-sm-3">
		<div class="panel panel-info">
			<div class="panel-heading">
				More Info
			</div>
			<div class="panel-body">
				Please note that some functions are disabled in this demo. Use <b>admin</b> // <b>admin</b> to access the admin section :)
			</div>
		</div>	                       
		<div class="panel panel-warning">
			<div class="panel-heading">
				Buy This Application!
			</div>
			<div class="panel-body">				
				<B>User Management & chatz</B> is now available on <b><a href="https://codecanyon.net/item/user-management-chatz/19912249" target="_BLANK">CodeCanyon</a></b>
			</div>
		</div>
	</div>	                   
</div>
<script type="text/javascript" src="./JQuery/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
//If user submits the form
$("#submitmsg").click(function(){
    var clientmsg = $("#usermsg").val();
	if (clientmsg !== "") {	
		$.post("./Ajax/post.php", 
		{text: clientmsg},
        function(data,status){            
			$(".list-unstyled").html(data);
        });             
		$("#usermsg").attr("value", "");
		$("#usermsg").val("");
	}
    return false;	
});

$(document).keypress(function(e) {
    if(e.which == 13) {
        $("#submitmsg").trigger("click");
    }
});

setInterval(loadLog, 1000);

function loadLog(){
	$.post("./Ajax/post.php", 
	{text: ""},
    function(data,status){            
		$(".list-unstyled").html(data);
    });
}
function FunctionClearChatz() {
    var r = confirm("Are You Sure?");
    if (r == true) {
        $.get("./Ajax/clearchatz.php", function(data, status){
			// alert("Data: " + data + "\nStatus: " + status);
			document.location='./page.php?page=dashboard';
		});
    }
}
</script>