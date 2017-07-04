<?php
error_reporting(E_ALL ^ E_NOTICE);
@include "./config/config.inc.php";
@include "./session_member.php";

// Sanitize $_GET parameters to avoid XSS and other attacks
$AVAILABLE_PAGES = array('dashboard', 'users', 'showuser', 'deleuser');
$AVAILABLE_PAGES = array_fill_keys($AVAILABLE_PAGES, 1);

$page = $_GET['page'];
if (!$AVAILABLE_PAGES[$page]) {
   header("HTTP/1.0 404 Not Found");
   die('Page not found.');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>:: Admin Panel ::</title>
<link href="./bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<style>
body {
    background-color: #dedede;
}

.col-centered{
    float: none;
    margin: 0 auto;
}

.topbar {
	background: #2A3F54;
	border-color: #2A3F54;
	border-radius: 0px;
}

.topbar .navbar-header a {
	color: #ffffff;
}

.wrapper {
    padding-left: 0px;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

.sidebar {
    z-index: 1000;
    position: fixed;
    top: 50px;
    left: -50px;
    width: 50px;
    height: 100%;
    overflow-y: auto;
    background: #2A3F54;
	color: #ffffff;
	-webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

.main {
	width: 100%;
    position: relative;
    padding-bottom:20px;
}

.wrapper.toggled {
	padding-left: 50px;
}

.wrapper.toggled .sidebar {
	left: 0;
}

/* Sidebar Styles */

.sidebar-nav {
    position: absolute;
    top: 52px;
    width: 50px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.sidebar-nav li {
    line-height: 40px;
}

.sidebar-nav li a {
    display: block;
    text-decoration: none;
    color: #e8e8e8;
    padding: 0;
    text-align:center;
}

.sidebar-nav li a:hover, .sidebar-nav li.active a {
    text-decoration: none;
    color: #fff;
    background: #fff;
    background: rgba(255,255,255,0.2);
}

.sidebar-nav li a:active,
.sidebar-nav li a:focus {
    text-decoration: none;
}

.sidebar-nav li span, .subbar li span {
	display : none;
}

.nav-tabs>li>a {
    color: #fff;
    text-decoration: none;
    background-color: #272b30;
}
nav.subbar {
	position: relative;
	width: 100%;
	border-radius: 0px;
	background: #fff;
	margin: 50px 0 -50px 0;
	padding: 10px 0 0 0;
	z-index: 2;
}
nav.subbar > ul.nav.nav-tabs {
	padding: 0 5px;
}

nav.subbar > ul.nav.nav-tabs > li.active > a {
    background: #dedede;
    border-top: 1px solid #a6a6a6;
    border-left: 1px solid #a6a6a6;
    border-right: 1px solid #a6a6a6;
    border-radius: 0px;
}

.content {
    margin-top: 70px;
    padding: 0 30px;
}

@media(min-width:768px){
	.subbar li span {
		display: inline;
	}
}

@media(min-width:992px) {
    .wrapper {
    	padding-left: 50px;
    }

    .sidebar {
    	left: 0;
    	width: 50px;
	}

	.wrapper.toggled {
		padding-left: 200px;
	}

	.wrapper.toggled .sidebar, .wrapper.toggled .sidebar-nav {
		width: 200px;
	}
	
	.wrapper.toggled .sidebar-nav li a {
		text-align: left;
		padding: 0 0 0 10px;
	}

	.wrapper.toggled .sidebar-nav li span {
		display: inline;
	}

}

.navbar-btn {
    background: none;
    border: none;
    height: 35px;
    min-width: 35px;
    color: #fff;
}
.navbar-text {
  margin-top: 14px;
  margin-bottom: 14px;
}
@media (min-width: 768px) {
  .navbar-text {
    float: left;
    margin-left: 15px;
    margin-right: 15px;
  }
}

// CSS for users page
.filterable {
    margin-top: 15px;
}
.filterable .panel-heading .pull-right {
    margin-top: -20px;
}
.filterable .filters input[disabled]{
    background-color: transparent;
    border: none;
    cursor: auto;
    box-shadow: none;
    padding: 0;
    height: auto;
}
.filterable .filters select[disabled]{
    background-color: transparent;
    border: none;
    cursor: auto;
    box-shadow: none;
    padding: 0;
    height: auto;
}
.filterable .filters input[disabled]::-webkit-input-placeholder {
    color: #333;
}
.filterable .filters input[disabled]::-moz-placeholder {
    color: #333;
}
.filterable .filters input[disabled]:-ms-input-placeholder {
    color: #333;
}

// CSS for Chatz
 #custom-search-input {
  background: #e8e6e7 none repeat scroll 0 0;
  margin: 0;
  padding: 10px;
}
   #custom-search-input .search-query {
   background: #fff none repeat scroll 0 0 !important;
   border-radius: 4px;
   height: 33px;
   margin-bottom: 0;
   padding-left: 7px;
   padding-right: 7px;
   }
   #custom-search-input button {
   background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
   border: 0 none;
   border-radius: 3px;
   color: #666666;
   left: auto;
   margin-bottom: 0;
   margin-top: 7px;
   padding: 2px 5px;
   position: absolute;
   right: 0;
   z-index: 9999;
   }
   .search-query:focus + button {
   z-index: 3;   
   }
   .all_conversation button {
   background: #f5f3f3 none repeat scroll 0 0;
   border: 1px solid #dddddd;
   height: 38px;
   text-align: left;
   width: 100%;
   }
   .all_conversation i {
   background: #e9e7e8 none repeat scroll 0 0;
   border-radius: 100px;
   color: #636363;
   font-size: 17px;
   height: 30px;
   line-height: 30px;
   text-align: center;
   width: 30px;
   }
   .all_conversation .caret {
   bottom: 0;
   margin: auto;
   position: absolute;
   right: 15px;
   top: 0;
   }
   .all_conversation .dropdown-menu {
   background: #f5f3f3 none repeat scroll 0 0;
   border-radius: 0;
   margin-top: 0;
   padding: 0;
   width: 100%;
   }
   .all_conversation ul li {
   border-bottom: 1px solid #dddddd;
   line-height: normal;
   width: 100%;
   }
   .all_conversation ul li a:hover {
   background: #dddddd none repeat scroll 0 0;
   color:#333;
   }
   .all_conversation ul li a {
  color: #333;
  line-height: 30px;
  padding: 3px 20px;
}
   .member_list .chat-body {
   margin-left: 47px;
   margin-top: 0;
   }
   .top_nav {
   overflow: visible;
   }
   .member_list .contact_sec {
   margin-top: 3px;
   }
   .member_list li {
   padding: 6px;
   }
   .member_list ul {
   border: 1px solid #dddddd;
   }
   .chat-img img {
   height: 34px;
   width: 34px;
   }
   .member_list li {
   border-bottom: 1px solid #dddddd;
   padding: 6px;
   }
   .member_list li:last-child {
   border-bottom:none;
   }
   .member_list {
   height: 380px;
   overflow-x: hidden;
   overflow-y: auto;
   }
   .sub_menu_ {
  background: #e8e6e7 none repeat scroll 0 0;
  left: 100%;
  max-width: 233px;
  position: absolute;
  width: 100%;
}
.sub_menu_ {
  background: #f5f3f3 none repeat scroll 0 0;
  border: 1px solid rgba(0, 0, 0, 0.15);
  display: none;
  left: 100%;
  margin-left: 0;
  max-width: 233px;
  position: absolute;
  top: 0;
  width: 100%;
}
.all_conversation ul li:hover .sub_menu_ {
  display: block;
}
.new_message_head button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
}
.new_message_head {
  background: #f5f3f3 none repeat scroll 0 0;
  float: left;
  font-size: 13px;
  font-weight: 600;
  padding: 18px 10px;
  width: 100%;
}
.message_section {
  border: 1px solid #dddddd;
}
.chat_area {
  float: left;
  height: 300px;
  overflow-x: hidden;
  overflow-y: auto;
  width: 100%;
}
.chat_area li {
  padding: 14px 14px 0;
}
.chat_area li .chat-img1 img {
  height: 40px;
  width: 40px;
}
.chat_area .chat-body1 {
  margin-left: 50px;
}
.chat-body1 p {
  background: #fbf9fa none repeat scroll 0 0;
  padding: 10px;
}
.chat_area .admin_chat .chat-body1 {
  margin-left: 0;
  margin-right: 50px;
}
.chat_area li:last-child {
  padding-bottom: 10px;
}
.message_write {
  background: #f5f3f3 none repeat scroll 0 0;
  float: left;
  padding: 15px;
  width: 100%;
}

.message_write textarea.form-control {
  height: 70px;
  padding: 10px;
}
.chat_bottom {
  float: left;
  margin-top: 13px;
  width: 100%;
}
.upload_btn {
  color: #777777;
}
.sub_menu_ > li a, .sub_menu_ > li {
  float: left;
  width:100%;
}
.member_list li:hover {
  background: #428bca none repeat scroll 0 0;
  color: #fff;
  cursor:pointer;
}

.badge {
  position: absolute;
  top: 8px;
  right: -3px;
}

.badge-info {
    background: #00a0df;
    font-family: 'Lato', sans-serif;
    font-size: 11px;
}
</style>
<script type="text/javascript" src="./JQuery/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="./bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).on("click",".sidebar-toggle", function(){
    $(".wrapper").toggleClass("toggled");
});
</script>
</head>
<body>
<link href="./font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" media="screen">
<nav class="navbar navbar-default navbar-fixed-top topbar">
	<div class="container-fluid">
		<div class="navbar-header">
			<a href="#" class="navbar-brand">
				<span class="visible-xs">KL</span>
				<span class="hidden-xs">Admin Panel</span>
			</a>
			<p class="navbar-text">
				<a href="#" class="sidebar-toggle">
                       <i class="fa fa-bars"></i>
                   </a>
			</p>
		</div>
		<div class="navbar-collapse collapse" id="navbar-collapse-main">
			<ul class="nav navbar-nav navbar-right">                    
                   <li>
						<button class="navbar-btn">
							<a href="./page.php?page=dashboard"><i class="fa fa-envelope"></i></a>
							<?php
								$query = mysqli_query($con,"SELECT COUNT(*) jumData from chatz");
								$data = mysqli_fetch_array($query);
								$jumlahData = $data["jumData"];
								echo "<span class=\"badge badge-info\">".$jumlahData."</span>";
							?>							
						</button>
                   </li>                    
				<li class="dropdown">
					<button class="navbar-btn" data-toggle="dropdown">
						<img src="./profile/<?php echo $_SESSION[picture]; ?>" width="30px" class="img-thumbnail">
					</button>
					<ul class="dropdown-menu">
						<li><a href="./page.php?page=showuser&id=<?php echo $_SESSION[id]; ?>">My Profile</a></li>
						<li><a href="./page.php?page=dashboard">Dashboard</a></li>
						<li class="nav-divider"></li>
						<li><a href="./logout.php">Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>	
<article class="wrapper">	    
    <aside class="sidebar">
        <ul class="sidebar-nav">
		    <li class="active"><a href="./page.php?page=dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>		    
		    <li><a href="./page.php?page=users"><i class="fa fa-users"></i><span>Users</span></a></li>
	    </ul>
    </aside>	    
    <section class="main">	        
        <section class="tab-content">			
			<section class="tab-pane active fade in content" id="content">				
			<?php
				if ($page=='dashboard'){
					@include './pages/dashboard.php';
				} elseif ($page=='users'){
					@include './pages/users.php';
				} elseif ($page=='showuser'){
					@include './pages/showuser.php';
				} elseif ($page=='deleuser'){
					@include './pages/deleuser.php';
				}		
			?>
			</section>
		</section>
	</section>
</article>                           
</body>
</html>