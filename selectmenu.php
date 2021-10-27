<?php session_start(); error_reporting(~E_NOTICE);
include('Connections/condb.php');

if($_GET['m_id']==''){ 
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'showmenu.php'; "; 
echo "</script>"; 
}

$m_id = mysqli_real_escape_string($conn,$_GET['m_id']);
$sql = "SELECT * FROM icanteen_menu WHERE m_id='$m_id' " or die("Error:" . mysqli_error()); 
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

?>
<html>
<head>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>I-CANTEEN</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
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
	<div class="jumbotron" style="padding-top: 30px;">
		<?php
		echo "<div class='row'>";
		echo "<div class='col-12 col-md-4'>";
		echo "<h1 class='display-5'>" .$row["m_name"] .  "</h1>";
	  	echo "<img src='m_image/".$row["m_image"]." 'class='menu-img'>";
		echo "</div>";
		echo "<div class='col-12 col-md-8'>";
	  	echo "<h2 style='padding-top: 10px;'>ร้าน " .$row["m_resname"] .  "</h2> ";
		echo "<h2 style='padding-top: 10px;'>ราคา <span class='price-badge'>".$row["m_price"]." ฿</span></h2> ";
		echo "<h4 style='padding-top: 10px;'>ประเภท : " .$row["m_cate"] .  "</h4> ";
		echo "<p style='padding-top: 10px;'>รีวิว : " .$row["m_info"] .  "</p> ";
		echo "<div style='padding-top: 20px;'><a class='btn btn-success btn-lg'  href='line://oaMessage/@045jpvio/?สั่ง ".$row["m_name"]." ร้าน ".$row["m_resname"]."' role='button'>สั่งเลย! <img src='Materials/homepage/LINE_SOCIAL_Circle.png' style='width: 1.5rem;'></a></div>";
		echo "</div></div>";?>
	  	
	</div>
</body>
</html>