<?php
error_reporting(E_ALL ^ E_NOTICE);
@include "./config/config.inc.php";

$id = $_GET['id'];
// Sanitize $_GET parameters to avoid XSS and other attacks
if(strpos(strtolower($id), 'union') || strpos(strtolower($id), 'select') || strpos(strtolower($id), '/*') || strpos(strtolower($id), '*/')) {
   echo "<div class=\"alert alert-warning col-lg-3 col-offset-6 centered col-centered\">
  <strong>Warning!</strong> SQL injection attempt detected.</div>";
   die;
}

$action   = "./Ajax/useractions.php";
$data	= "SELECT * FROM users WHERE id='$id'";
$result	= mysqli_query($con,$data);
$row	= mysqli_fetch_array($result);
?>
<script type="text/javascript" src="./JQuery/jquery-3.1.1.min.js"></script>
<script>
$(document).ready(function (e) {
	$('#message').hide();
	$("#myForm").on('submit',(function(e) {
		e.preventDefault();
		$("#message").show();
		$("#message").empty();		
		$.ajax({
			url: "./Ajax/useractions.php?act=update", // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data)   // A function to be called if request succeeds
		{
			// $('#loading').hide();
			$("#message").html(data);
		}
	});
}));

// Function to preview image after validation
$(function() {
	$("#file").change(function() {
		$("#message").empty(); // To remove the previous error message
		var file = this.files[0];
		var imagefile = file.type;
		var match= ["image/jpeg","image/png","image/jpg"];
		if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
		{
			$('#previewing').attr('src','./images/no-image.png');
			$("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
			return false;
		}
		else
		{
			var reader = new FileReader();
			reader.onload = imageIsLoaded;
			reader.readAsDataURL(this.files[0]);
		}
	});
});
function imageIsLoaded(e) {
	$("#file").css("color","green");
		$('#image_preview').css("display", "block");
		$('#previewing').attr('src', e.target.result);
		$('#previewing').attr('width', '250px');
		$('#previewing').attr('height', '230px');
	};
});
</script>
<div style="padding-top:100px;" class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $row[firstname];?>&nbsp;<?php echo $row[lastname];?></h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="./profile/<?php echo $row[picture];?>" class="img-thumbnail img-responsive"></div>
				<div class=" col-md-9 col-lg-9 "> 
					<table class="table table-user-information">
						<tbody>
							<tr>
								<td>Department:</td>
								<td><?php echo $row[department];?></td>
							</tr>
							<tr>
								<td>Hire date:</td>
								<td><?php echo $row[hiredate];?></td>
							</tr>
							<tr>
								<td>Date of Birth</td>
								<td><?php echo $row[birthdate];?></td>
							</tr>
							<tr>
								<td>Gender</td>
								<td><?php echo $row[gender];?></td>
							</tr>
							<tr>
								<td>Home Address</td>
								<td><?php echo $row[address];?></td>
							</tr>
							<tr>
								<td>Email</td>
								<td><a href="<?php echo $row[email];?>"><?php echo $row[email];?></a></td>
							</tr>
								<td>Phone Number</td>
								<td><?php echo $row[phone];?>(Mobile)</td>
							</tr>                     
						</tbody>
					</table>									
				</div>
			</div>
		</div>
		<div class="panel-footer" style="height:50px;">			
			<span class="pull-right">
				<a data-toggle="modal" data-target="#usuario" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
				<a href="./page.php?page=users" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
			</span>
		</div>		
		<div class="fade modal" id="usuario">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h2 class="modal-title" id="myModalLabel">Update User</h2>						
					</div>
					<div class="modal-body">
						<div class="alert alert-info" id="message"></div>
						<form class="form-horizontal" method="post" id="myForm" name="myForm" onsubmit="return validateForm()" enctype="multipart/form-data" action="">
							<fieldset>
								<!-- Form Name -->
								<!-- Prepended text-->							
								<div class="form-group">
									<label class="col-md-4 control-label" for="username">Username</label>
									<div class="col-md-5">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-user"></i></span>
											<input type="hidden" id="id" name="id" class="form-control" value="<?php echo $row[id];?>">
											<input type="hidden" id="username" name="username" class="form-control" placeholder="Username" value="<?php echo $row[username];?>">
											<input id="showuser" name="showuser" class="form-control" placeholder="Username" type="text" value="<?php echo $row[username];?>" disabled>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="password">Password</label>
									<div class="col-md-5">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-lock"></i></span>
											<input id="password" name="password" type="password" class="form-control input-md" value="<?php echo $row[password];?>" required="">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="firstname">Firstname</label>
									<div class="col-md-5">
										<div class="input-group">
											<input id="firstname" name="firstname" class="form-control" placeholder="Firstname" type="text" value="<?php echo $row[firstname];?>" required="">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="lastname">Lastname</label>
									<div class="col-md-5">
										<div class="input-group">
											<input id="lastname" name="lastname" class="form-control" placeholder="Lastname" type="text" value="<?php echo $row[lastname];?>" required="">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="status">Status</label>
									<div class="col-md-5">
										<?php 
										if ($row[status]=="Actived") {
											echo "<div class=\"input-group\">
												<label class=\"radio-inline\"><input type=\"radio\" name=\"optradio\" value=\"Actived\" checked>Active</label>
												<label class=\"radio-inline\"><input type=\"radio\" name=\"optradio\" value=\"Inactive\">Inactive</label>										
											</div>";
										} else {
											echo "<div class=\"input-group\">
												<label class=\"radio-inline\"><input type=\"radio\" name=\"optradio\" value=\"Actived\">Active</label>
												<label class=\"radio-inline\"><input type=\"radio\" name=\"optradio\" value=\"Inactive\" checked>Inactive</label>										
											</div>";
										}
										?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="picture">Picture</label>
									<div class="col-md-5">
										<div class="input-group">																													
											<?php
											if ($row[picture]=="no-image.png") {
												echo "<div id=\"image_preview\"><img id=\"previewing\" src=\"./profile/no-image.png\"/></div>";
											} else {
												echo "<div id=\"image_preview\"><img id=\"previewing\" src=\"./profile/".$row[picture]."\" height=\"200px\"></div>";
											}
											?>	
											<hr id="line">
											<div id="selectImage">
												<label>Select Your Image</label><br/>
												<input type="file" name="file" id="file"/>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="department">Department</label>
									<div class="col-md-5">
										<div class="input-group">
											<input id="department" name="department" class="form-control" placeholder="department" type="text" value="<?php echo $row[department];?>">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="hiredate">Hire Date</label>
									<div class="col-md-5">
										<div class="input-group">											
											<input class="form-control" type="date" name="hiredate" id="hiredate" value="<?php echo $row[hiredate];?>">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="birthdate">Birth Date</label>
									<div class="col-md-5">
										<div class="input-group">											
											<input class="form-control" type="date" name="birthdate" id="birthdate" value="<?php echo $row[birthdate];?>">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="gender">Gender</label>
									<div class="col-md-5">
										<div class="input-group">
											<select class="form-control" id="gender" name="gender">
												<option selected>male</option>
												<option>female</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="address">Address</label>
									<div class="col-md-5">
										<div class="input-group">
											<textarea class="form-control" rows="5" id="address" name="address"><?php echo $row[address];?></textarea>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="email">e-mail</label>
									<div class="col-md-5">
										<div class="input-group">
											<input id="email" name="email" class="form-control" placeholder="Email" type="email" value="<?php echo $row[email];?>">
											<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
										</div>
									</div>
								</div>		
								<!-- Prepended text-->
								<div class="form-group">
									<label class="col-md-4 control-label" for="phone">Phone</label>
									<div class="col-md-5">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-user"></i></span>
											<input id="phone" name="phone" class="form-control" placeholder="Phone Number" type="text" value="<?php echo $row[phone];?>">
										</div>
									</div>
								</div>
								<!-- File Button -->
								<div class="form-group col-lg-3 col-offset-6 pull-right">
									<button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i>Update</button>
								</div>
								<!-- Button -->
								<?php 
								mysqli_close($con);
								?>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>