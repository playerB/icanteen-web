<?php session_start(); error_reporting(~E_NOTICE);
include('Connections/condb.php');

if($_GET['news_id']==''){ 
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'index.php'; "; 
echo "</script>"; 
}

$news_id = mysqli_real_escape_string($conn,$_GET['news_id']);
$sql = "SELECT * FROM news WHERE news_id='$news_id' " or die("Error:" . mysqli_error()); 
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
	<div class="jumbotron" style="padding-top: 30px;">
		<?php
		echo "<div class='row'>";
		echo "<div class='col-12'>";
		if ($_SESSION["user_role"]=="admin") {
			echo "<div style='float:right'>";
			echo "<a href='newsedit.php?news_id=".$row['news_id']."' class='btn btn-warning'>Edit</a>";
			echo "<a href='newsdelete.php?news_id=".$row['news_id']."' class='btn btn-danger'>Delete</a>";
			echo "</div>";
		}
		echo "<h1 class='display-5'>" .$row["news_headline"] .  "</h1>";
		echo "<img src='news_picture/".$row["news_picture"]." '>";
		echo "<p style='padding-top: 10px;'>รายละเอียด : " .$row["news_content"].  "</p> ";
		echo "</div></div>";
		?>
	  	
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>