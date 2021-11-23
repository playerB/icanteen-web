<?php session_start();?>
<?php 

if (!$_SESSION["user_name"]){  //check session
	Header("Location: form_login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า form_login.php 

}else{
if ($_SESSION["user_role"]!="admin"){
	echo "<script>";
	echo "alert(\"You do not have access to this page\");"; 
	echo "window.history.back()";
	echo "</script>";

}
if ($_SESSION["user_role"]=="admin"){

include('Connections/condb.php');

error_reporting(~E_NOTICE );
?>

<html>
	<head>
	</head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta charset="utf-8">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
	<link href="css.css" rel="stylesheet">
	<body>
		<div id="register" style="position: absolute; top: 20px; left: 20px;">
		<h2>NEW RESTAURANT</h2>
		<br>
		<form action="insertrestaurant.php" method="post" enctype="multipart/form-data">
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
				<label for="restaurant_name">Restaurant name :</label>
					<input type="text" class="form-control" name="restaurant_name" id="restaurant_name" required="required" /><br /><br />
			</div>
			<div style="width: 300px; height: 80px;" class="form-group">
				<input type="submit" value="Add new restaurant" name="submitbtn" class="btn btn-outline-primary"/>
			</div>
		</form>
		<script>
				if ( window.history.replaceState ) {
					window.history.replaceState( null, null, window.location.href );
				}
		</script>
		</div>
	</body>
</html>
<?php 
if(isset($_POST['submitbtn'])){
	
	$restaurant_name = mysqli_real_escape_string($conn, $_POST['restaurant_name']);
	

	$user_name = mysqli_real_escape_string($conn, $_POST['Username']);
	$user_email = mysqli_real_escape_string($conn, $_POST['Email']);
	$user_password = md5($_POST['Password']);
	$user_confirmpassword = md5($_POST['ConfirmPassword']);
	$user_balance = 0;
	$user_role = 'vendor';
	if ($user_password == $user_confirmpassword) {
		$sql = "INSERT INTO user (user_name, user_email, user_password, user_balance, user_role)
		VALUES ('$user_name','$user_email','$user_password','$user_balance','$user_role');";
		$result = mysqli_query($conn, $sql) or die("Error in query: $sql " . mysqli_error());

		if ($result) {
			$result2 = mysqli_query($conn, "SELECT user_id FROM user WHERE user_name = '$user_name'") or die("Error in query: $sql " . mysqli_error());
			$owner_id = mysqli_fetch_array($result2)[0];
			$sql3 = "INSERT INTO restaurant (restaurant_name, owner_id)
			VALUES ('$restaurant_name','$owner_id');";
			$result3 = mysqli_query($conn, $sql3) or die("Error in query: $sql " . mysqli_error());
			if ($result3) {
				echo "<script>";
				echo "alert('Insert Successfully');"; 
				header("location: admin_page.php");
				echo "</script>";
			} else {
				echo "<script type= 'text/javascript'>alert('Error: " . $conn->error."');</script>";
			}
		} else {
			echo "<script type= 'text/javascript'>alert('Error: " . $conn->error."');</script>";
		}
	} else {
		echo "<script type= 'text/javascript'>alert('Error: Password not match');</script>";
	}
	
} } } ?>