<?php session_start(); error_reporting(~E_NOTICE);
include('Connections/condb.php');

if($_GET['menu_id']==''){ 
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'index.php'; "; 
echo "</script>"; 
}

$menu_id = mysqli_real_escape_string($conn,$_GET['menu_id']);
$sql = "SELECT * FROM menu WHERE menu_id='$menu_id' " or die("Error:" . mysqli_error()); 
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

?>
<html>
<head>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>I-CANTEEN</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="css.css" rel="stylesheet">
	<style>
		@import url('https://fonts.googleapis.com/css?family=Mitr&display=swap');
		body {
			font-family: 'Mitr', serif;
			font-size: '20pt';
			background-color: #dddddd;
		}
		.price-badge {
			background: #7f1d17;
			text-align: center;
			border-radius: 20px;
			color: white;
			padding: 3px 10px;
			font-size: 22px;
		}
		.menu-img{
			overflow: hidden;
			width: 20rem;
			height: 20rem;
			object-fit: cover;
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
	<div class="jumbotron" style="padding-top: 30px;">
		<?php
		echo "<div class='row'>";
		echo "<div class='col-12 col-md-4'>";
		echo "<h1 class='display-5'>" .$row["menu_name"] .  "</h1>";
	  	echo "<img src='menu_picture/".$row["menu_picture"]." 'class='menu-img'>";
		echo "</div>";
		echo "<div class='col-12 col-md-8'>";
	  	echo "<h2 style='padding-top: 10px;'>ร้าน " .$row["restaurant_id"] .  "</h2> ";
		echo "<h2 style='padding-top: 10px;'>ราคา <span class='price-badge'>".$row["menu_price"]." ฿</span></h2> ";
		echo "<h4 style='padding-top: 10px;'>ประเภท : " .$row["menu_category"] .  "</h4> ";
		echo "<p style='padding-top: 10px;'>รีวิว : " .$row["menu_detail"] .  "</p> ";
		echo "<div style='padding-top: 20px;'><a class='btn btn-success btn-lg'  href='line://oaMessage/@045jpvio/?สั่ง ".$row["menu_name"]." ร้าน ".$row["m_resname"]."' role='button'>สั่งเลย! <img src='Materials/homepage/LINE_SOCIAL_Circle.png' style='width: 1.5rem;'></a></div>";
		echo "</div></div>";?>
	  	
	</div>
</body>
</html>