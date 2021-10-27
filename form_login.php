<?php session_start(); error_reporting(~E_NOTICE );
if ($_SESSION["UserID"]){
	echo "<script>";
	echo "alert(\"You are already logged in!\");";
	echo "window.history.back()";
	echo "</script>";
}
?>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Form Login</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
	<style>
		@import url('https://fonts.googleapis.com/css?family=Mitr&display=swap');
		body {
			font-family: 'Mitr', serif;
			font-size: '20pt';
			background-color: #dddddd;
		}
	</style>
</head>
<body>
	<nav class="navbar navbar-expand">
		  <a class="navbar-brand" href="index.php">
			<img src="Materials/homepage/cropped-cu-eng-logo.png" width="130" height="18" class="d-inline-block align-top" alt="">
		  </a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
			<?php if($_SESSION["Loggedin"]){ ?>
			  <li class="nav-item active">
				<a class="btn btn-danger" href="logout.php" style="color: white">Logout</a>
			  </li>
			<?php } else{ ?>
			  <li class="nav-item">
				<a class="btn btn-danger" href="form_login.php" style="color: white">Login</a>
			  </li>
			<?php } ?>
			  <li class="nav-item">
				<a class="nav-link" href="usermenu.php" style="color: #7f1d17">Menu</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="newspage.php" style="color: #7f1d17">News</a>
			  </li>
			</ul>
		  </div>
		</nav>
  <div id="register" align="center" class="container-fluid">
      <form name="frmlogin"  method="post" action="login.php">
        <div style="width: 300px; height: 60px;" class="form-group">
			<label for="menuname">Username :</label>
				<input type="text" class="form-control" name="Username" id="Username" required="required" placeholder="Username" /><br /><br />
		</div>
        <div style="width: 300px; height: 60px;" class="form-group">
			<label for="menuname">Password :</label>
				<input type="password" class="form-control" name="Password" id="Password" required="required" placeholder="Password" /><br /><br />
		<div style="width: 300px; height: 80px;" class="form-group">
			<input type="submit" value=" Login " name="submitbtn" class="btn btn-success"/>
			<input type="reset" value=" Reset " name="resetbtn" class="btn btn-outline-secondary"/>
		</div>
      </form>
  </div>
</body>
</html>