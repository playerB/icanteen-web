<?php session_start(); error_reporting(~E_NOTICE );
		
include('Connections/condb.php');

$query = "SELECT * FROM restaurant ORDER BY restaurant_id ASC" or die("Error:" . mysqli_error()); 
$result= mysqli_query($conn, $query);
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
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
		.scrolling-wrapper {
		  overflow-x: scroll;
		  overflow-y: hidden;
		  white-space: nowrap;
		}
		.scrolling-wrapper::-webkit-scrollbar {
		  display: none;
		}

		.scrolling-wrapper::-webkit-scrollbar-track {
		  width: 8px;
		  background: #bbbbbb; 
		  border-radius: 10px;
		}

		.scrolling-wrapper::-webkit-scrollbar-thumb {
		  background: #999999; 
		  border-radius: 10px;
		}

		.scrolling-wrapper::-webkit-scrollbar-thumb:hover {
		  background: #777777; 
		}
		.card-box {
		  width: 8rem;
		  height: 10.2rem;
		  display: inline-block;
		}
		.card-img-box {
			width: 7.85rem;
			height: 8rem;
			object-fit: cover;
		}
		.card-title {
			height: 1.5rem;
			font-size: 0.8rem;
			margin-top: -0.8rem;
			overflow: hidden;
		}
		@media (min-width: 576px) {
			.card-box {
			  width: 15rem;
			  height: 17.5rem;
			  display: inline-block;
			}
			.card-img-box {
			  width: 14.9rem;
			  height: 15rem;
			  object-fit: cover;
			}
			.scrolling-wrapper::-webkit-scrollbar {
			  display: block;
			  height: 8px;
			}
			.card-title {
			height: 1.5rem;
			font-size: 1.1rem;
			margin-top: -0.8rem;
			overflow: hidden;
			}
		}
		.price-badge {
			position: absolute;
			right: 10px;
			top: 10px;
			background: #7f1d17;
			text-align: center;
			border-radius: 50px;
			color: white;
			padding: 3px 7px;
			font-size: 14px;
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
                    <?php if($_SESSION["user_role"]=="member") {?>
                        <a class="dropdown-item" href="topup.php">Topup</a>
                        <a class="dropdown-item" href="userreport.php">Report problem</a>
                    <?php }  elseif($_SESSION["user_role"]=="vendor") {?>
                        <a class="dropdown-item" href="withdraw.php">Withdraw</a>
                    <?php } ?>
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
	<div class="container-fluid">
		<?php 
		while($row = mysqli_fetch_array($result)) {
			$restaurant_id = $row["restaurant_id"];
			$restaurant_name = $row['restaurant_name'];
			echo "<label style='font-size: 1.5rem'>".$restaurant_id.". ".$restaurant_name."</label>";
			echo "<div class='scrolling-wrapper'>";
			$sql2 = "SELECT * FROM menu WHERE restaurant_id = '$restaurant_id'";
			$menuresult = mysqli_query($conn, $sql2);
			while($menurow = mysqli_fetch_array($menuresult)) {
				echo "<div class='card card-box mr-2 mb-2'>";
					echo "<a href='selectmenu.php?menu_id=$menurow[0]'>";
					echo "<img src='menu_picture/".$menurow["menu_picture"]."' class='card-img card-img-box' alt=''>";
					echo "<span class='price-badge'>".$menurow["menu_price"].".-</span></a>";
					echo "<div class='card-body'>";
					echo "<p class='card-title'>".$menurow["menu_name"]."</p>";
					echo "</div>";
				echo "</div>";
				}
			echo "</div>" ;
		}?>
	</div>
	
	<footer style="background-color: #cccccc">
		<div class="container">
			<p id = "btext"><br>
				คณะวิศวกรรมศาสตร์<br> 
					คณะวิศวกรรมศาสตร์<br> 
				คณะวิศวกรรมศาสตร์<br> 
				จุฬาลงกรณ์มหาวิทยาลัย<br>
				ถนนพญาไท เเขวงวังใหม่<br>
				เขตปทุมวัน กรุงเทพฯ 10400<br>
				info@eng.chula.ac.th<br>
				+66-2-218-6337<br>
				&nbsp;
			</p>
		</div>
	</footer>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>