<?php session_start(); error_reporting(~E_NOTICE );
if ($_SESSION["user_name"]){
	echo "<script>";
	echo "alert(\"You are already logged in!\");";
	echo "window.history.back()";
	echo "</script>";
} else {
    require('Connections/condb.php');
    if (isset($_POST['submitbtn'])) {

        $user_name = mysqli_real_escape_string($conn, $_POST['Username']);
        $user_email = mysqli_real_escape_string($conn, $_POST['Email']);
        $user_password = md5($_POST['Password']);
        $user_confirmpassword = md5($_POST['ConfirmPassword']);
        $user_balance = 0;
        $user_role = 'member';
		if ($user_password == $user_confirmpassword) {
			$sql = "INSERT INTO user (user_name, user_email, user_password, user_balance, user_role)
			VALUES ('$user_name','$user_email','$user_password','$user_balance','$user_role')";
			if ($conn->query($sql) === TRUE) {
				echo "<script>";
				echo "alert(\"Register Success!\");";
				echo "window.location = 'form_login.php'; ";
				echo "</script>";
			}
			else {
			echo "<script type= 'text/javascript'>alert('Error: ".$conn->error."');</script>";
			}
		} else {
			echo "<script type= 'text/javascript'>alert('Password not match!');</script>";
		}
	}
}?>
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
      <form name="frmregister"  method="post" action="" enctype="multipart/form-data">
        <div style="width: 300px; height: 60px;" class="form-group">
			<label for="Email">Email :</label>
				<input type="text" class="form-control" name="Email" id="Email" required="required" placeholder="Email" /><br /><br />
		</div>
        <div style="width: 300px; height: 60px;" class="form-group">
			<label for="Username">Username :</label>
				<input type="text" class="form-control" name="Username" id="Username" required="required" placeholder="Username" /><br /><br />
		</div>
        <div style="width: 300px; height: 60px;" class="form-group">
			<label for="Password">Password :</label>
				<input type="password" class="form-control" name="Password" id="Password" required="required" placeholder="Password" /><br /><br />
		</div>
        <div style="width: 300px; height: 60px;" class="form-group">
			<label for="ConfirmPassword">Confirm Password :</label>
			<input type="password" class="form-control" name="ConfirmPassword" id="ConfirmPassword" required="required" placeholder="Confirm Password" /><br /><br />
		</div>
		<div style="width: 300px; height: 80px;" class="form-group">
			<input type="submit" value=" Register " name="submitbtn" class="btn btn-outline-primary"/>
		</div>
      </form>
  </div>
</body>
</html>