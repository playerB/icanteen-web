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
        $user_balance = 0;
        $user_role = 'member';
    
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
        mysqli_close($conn);
    }
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
	<nav class="navbar navbar-expand">
		<a class="navbar-brand" href="index.php">
		<img src="Materials/homepage/cropped-cu-eng-logo.png" width="130" height="18" class="d-inline-block align-top" alt="">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<a class="nav-link" href="index.php" style="color: #7f1d17">Home</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="usermenu.php" style="color: #7f1d17">Menu</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="newspage.php" style="color: #7f1d17">News</a>
			</li>
			<?php if($_SESSION["user_role"]=="member") {?>
			<li class="nav-item">
				<a class="nav-link" href="myorder.php" style="color: #7f1d17">Order</a>
			</li>
			<?php } elseif($_SESSION["user_role"]=="admin") {?>
			<li class="nav-item">
				<a class="nav-link" href="showreport.php" style="color: #7f1d17">Report</a>
			</li>
			<?php } elseif($_SESSION["user_role"]=="vendor") {?>
			<li class="nav-item">
				<a class="nav-link" href="restaurantmanage.php" style="color: #7f1d17">Manage</a>
			</li>
			<?php } ?>

			<?php if($_SESSION["Loggedin"]){ ?>

			<li class="nav-item rightaligned">
			<div class="dropdown">
				<button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?php print_r($_SESSION["user_name"]); ?>
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="#">Balance: <?php print_r($_SESSION["user_balance"]); ?> ฿</a>
					<a class="dropdown-item" href="topup.php">Topup</a>
					<a class="dropdown-item" href="userreport.php">Report problem</a>
					<a class="dropdown-item" href="logout.php">Logout</a>
				</div>
			</div>
			</li>
			<?php } else{ ?>
			<li class="nav-item rightaligned">
				<a class="btn btn-danger" href="form_login.php" style="color: white">Login</a>
			</li>
			<?php } ?>
		</ul>
		</div>
	</nav>
  <div id="register" align="center" class="container-fluid">
      <form name="frmregister"  method="post" action="" enctype="multipart/form-data">
        <div style="width: 300px; height: 60px;" class="form-group">
			<label for="menuname">Email :</label>
				<input type="text" class="form-control" name="Email" id="Email" required="required" placeholder="Email" /><br /><br />
		</div>
        <div style="width: 300px; height: 60px;" class="form-group">
			<label for="menuname">Username :</label>
				<input type="text" class="form-control" name="Username" id="Username" required="required" placeholder="Username" /><br /><br />
		</div>
        <div style="width: 300px; height: 60px;" class="form-group">
			<label for="menuname">Password :</label>
				<input type="password" class="form-control" name="Password" id="Password" required="required" placeholder="Password" /><br /><br />
		<div style="width: 300px; height: 80px;" class="form-group">
			<input type="submit" value=" Register " name="submitbtn" class="btn btn-outline-primary"/>
		</div>
      </form>
  </div>
</body>
</html>