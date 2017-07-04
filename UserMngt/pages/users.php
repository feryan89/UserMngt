<?php
error_reporting(E_ALL ^ E_NOTICE);
@include "./config/config.inc.php";
$action = "./Ajax/useractions.php";
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
			url: "./Ajax/useractions.php?act=add", // Url to which the request is send
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

function FunctionDelete(id) {
    var r = confirm("Are You Sure?");
    if (r == true) {
        $.get("./Ajax/useractions.php?act=del&id=" + id, function(data, status){
			// alert("Data: " + data + "\nStatus: " + status);
			document.location='./page.php?page=users';
		});
    }
}
</script>
<div class="container">
	<div class="row">
		<div class="pull-right" style="padding-bottom: 20px">
			<a data-toggle="modal" data-target="#usuario" href="#" class="btn btn-primary">Create User <i class="fa fa-plus"></i></a>
		</div>
	</div>
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Users</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
            </div>
			<?php  include './pages/pagging.php'; ?>
            <table class="table">
                <thead>
                    <tr class="filters">
						<th><strong>Picture</strong></th>
                        <th><input type="text" class="form-control" placeholder="#" size="2"></th>
                        <th><input type="text" class="form-control" placeholder="First Name"></th>
                        <th><input type="text" class="form-control" placeholder="Last Name"></th>
                        <th><input type="text" class="form-control" placeholder="Username"></th>
						<th><select class="form-control" id="sel1"><option selected>Actived</option><option>Inactive</option></select></th>
						<th><strong>Actions</strong></th>
                    </tr>
                </thead>
                <tbody>
					<?php								
					$SQLshow = mysqli_query($con,"SELECT id,
											username,
											firstname,
											lastname,	
											status,
											picture
											FROM users
											ORDER BY id ASC limit $offset, $dataperPage");
					$noUrut = 1;
					while($row = mysqli_fetch_array($SQLshow)){
					?>
                    <tr>
						<td><img src="./profile/<?php echo $row[picture]; ?>" style="height:150px;" class="img-rounded img-responsive" draggable="false"></td>
                        <td><?php echo $row[id]; ?></td>
                        <td><?php echo $row[firstname]; ?></td>
                        <td><?php echo $row[lastname]; ?></td>
                        <td><?php echo $row[username]; ?></td>
						<?php  
						if ($row[status]=="Actived") {
							echo "<td><span class=\"label label-primary\">$row[status]</span></td>";
						} else {
							echo "<td><span class=\"label label-danger\">$row[status]</span></td>";
						}
						?>
						<td>
							<center>
								<a href="./page.php?page=showuser&id=<?php echo $row[id]; ?>">
									<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-eye-open"></span></button>
								</a>								
								<a href="#" OnClick="FunctionDelete(<?php echo $row[id]; ?>)">
									<button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-trash"></span></button>
								</a>
							</center>
						</td>
                    </tr>
					<?php 
					$noUrut++;
					} 
					?>
                </tbody>
            </table>
			<nav class="pull-right">
				<ul class="pagination">
					<?php include './pages/view_page.php';?>
				</ul>
			</nav>
        </div>
		<div class="fade modal" id="usuario">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h2 class="modal-title" id="myModalLabel">Create User</h2>						
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
											<input id="username" name="username" class="form-control" placeholder="Username" type="text" value="" required="">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="password">Password</label>
									<div class="col-md-5">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-lock"></i></span>
											<input id="password" name="password" type="password" class="form-control input-md" value="" required="">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="firstname">Firstname</label>
									<div class="col-md-5">
										<div class="input-group">
											<input id="firstname" name="firstname" class="form-control" placeholder="Firstname" type="text" value="" required="">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="lastname">Lastname</label>
									<div class="col-md-5">
										<div class="input-group">
											<input id="lastname" name="lastname" class="form-control" placeholder="Lastname" type="text" value="" required="">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="status">Status</label>
									<div class="col-md-5">
										<div class="input-group">
											<label class="radio-inline"><input type="radio" name="optradio" value="Actived" checked>Active</label>
											<label class="radio-inline"><input type="radio" name="optradio" value="Inactive">Inactive</label>										
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="picture">Picture</label>
									<div class="col-md-5">
										<div class="input-group">
											<div id="image_preview"><img id="previewing" src="./profile/no-image.png" /></div>
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
											<input id="department" name="department" class="form-control" placeholder="department" type="text" value="">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="hiredate">Hire Date</label>
									<div class="col-md-5">
										<div class="input-group">											
											<input class="form-control" type="date" name="hiredate" id="hiredate" value="">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="birthdate">Birth Date</label>
									<div class="col-md-5">
										<div class="input-group">											
											<input class="form-control" type="date" name="birthdate" id="birthdate" value="">
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
											<textarea class="form-control" rows="5" id="address" name="address"></textarea>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-4 control-label" for="email">e-mail</label>
									<div class="col-md-5">
										<div class="input-group">
											<input id="email" name="email" class="form-control" placeholder="Email" type="email" value="">
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
											<input id="phone" name="phone" class="form-control" placeholder="Phone Number" type="text" value="">
										</div>
									</div>
								</div>
								<!-- File Button -->
								<div class="form-group col-lg-3 col-offset-6 pull-right">
									<button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i>Save</button>
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
<script type="text/javascript">
/*
Please consider that the JS part isn't production ready at all, I just code it to show the concept of merging filters and titles together !
*/
$(document).ready(function(){
    $('.filterable .btn-filter').click(function(){
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input,select'),
        $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    $('.filterable .filters input').keyup(function(e){
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }
    });
	
	$("#sel1").change(function(){
		// alert($(this).val());
		// $("#text1").val($(this).val());
		var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }
	});
});
</script>