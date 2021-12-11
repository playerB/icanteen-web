<?php session_start(); error_reporting(~E_NOTICE );
if ($_SESSION["user_name"]){
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
<link href="css.css" rel="stylesheet">
</head>
<body>
<?php include("navbar.php"); ?>
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
		<div>Don't have an account? 
			<a href="register.php" name="register" class="btn btn-outline-primary">Register</a>
		</div>
      </form>
  </div>
</body>
</html>