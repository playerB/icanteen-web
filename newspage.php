<?php session_start(); error_reporting(~E_NOTICE );
include('Connections/condb.php');

$query = "SELECT * FROM menu ORDER BY menu_id asc" or die("Error:" . mysqli_error()); 
$result1 = mysqli_query($conn, $query);

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
		.card {
			width: 18.5rem;
			height: 23rem;
		}
		.card-hz {
			width: 22rem;
			height: 12rem;
		}
		.card-img-top {
			width: 18.5rem;
			height: 12rem;
			object-fit: cover;
		}
		.card-img {
			width: 10rem;
			height: 12rem;
			object-fit: cover;
		}
		.card-body-hz {
			width: 12rem;
			height: 12rem;
		}
		.card-title {
			height: 1.5rem;
			overflow: hidden;
		}
		.card-text {
			height: 3rem;
			overflow: hidden;
		}
		.card-caption {
			height: 2rem;
			overflow: hidden;
		}
		@media (min-width: 576px) {
			.card-hz {
			width: 38.5rem;
			height: 12rem;
			}
			.card-img {
			width: 16rem;
			height: 12rem;
			object-fit: cover;
			}
			.card-body-hz {
				width: 20rem;
				height: 12rem;
			}
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
	<div class="container-fluid row">
		<div class="container-fluid d-block" style="font-size: 2rem">News</div>
		<div class="col-12 col-md-6">
			<div class="card card-hz mb-3">
			  <div class="row no-gutters">
				<div class="col-5">
				  <img src="Materials/homepage/news1.png" class="card-img " alt="">
				</div>
				<div class="col-7">
				  <div class="card-body card-body-hz">
					<h5 class="card-title">ต่อแถวให้เป็นระเบียบกันเถอะ!</h5>
					<div class="card-text">ร่วมต่อแถวให้เป็นระเบียบ ลดความวุ่นวายใน i-canteen</div>
					<div class="card-caption"><small class="text-muted">23 ต.ค. 62</small></div>
					<a href="#" class="btn btn-primary">อ่านต่อ</a>
				  </div>
				</div>
			  </div>
			</div>
		</div>
		<div class="col-12 col-md-6">
			<div class="card card-hz mb-3">
			  <div class="row no-gutters">
				<div class="col-5">
				  <img src="Materials/homepage/news2.png" class="card-img" alt="">
				</div>
				<div class="col-7">
				  <div class="card-body card-body-hz">
					<h5 class="card-title">แยกขยะถูกที่ ทิ้งให้ลงถัง</h5>
					<div class="card-text">ช่วยกันรีไซเคิลขยะ ลดโลกร้อน</div>
					<div class="card-caption"><small class="text-muted">14 ต.ค. 62</small></div>
					<a href="#" class="btn btn-primary">อ่านต่อ</a>
				  </div>
				</div>
			  </div>
			</div>
		</div>
		<div class="col-12 col-md-6">
			<div class="card card-hz mb-3">
			  <div class="row no-gutters">
				<div class="col-5">
				  <img src="Materials/homepage/news3.png" class="card-img " alt="">
				</div>
				<div class="col-7">
				  <div class="card-body card-body-hz">
					<h5 class="card-title">น้ำมันทอดซ้ำ อันตรายอย่างไร</h5>
					<div class="card-text">-------------------</div>
					<div class="card-caption"><small class="text-muted">24 ก.ย. 62</small></div>
					<a href="#" class="btn btn-primary">อ่านต่อ</a>
				  </div>
				</div>
			  </div>
			</div>
		</div>
		<div class="col-12 col-md-6">
			<div class="card card-hz mb-3">
			  <div class="row no-gutters">
				<div class="col-5">
				  <img src="Materials/homepage/news4.png" class="card-img" alt="">
				</div>
				<div class="col-7">
				  <div class="card-body card-body-hz">
					<h5 class="card-title">ตรวจสอบความปลอดภัยอาหาร</h5>
					<div class="card-text">--------------------</div>
					<div class="card-caption"><small class="text-muted">5 ก.ย. 62</small></div>
					<a href="#" class="btn btn-primary">อ่านต่อ</a>
				  </div>
				</div>
			  </div>
			</div>
		</div>
	</div>
	<footer style="background-color: #cccccc">
			<div class="container">
				<p id = "btext"><br>
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
</body>
</html>