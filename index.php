<?php session_start(); error_reporting(~E_NOTICE );
include('Connections/condb.php');?>
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
		.rightaligned {
			position: absolute;
			right: 20px;
			color: #ffffff;
		}
		.dropdown-menu {
			background-color: #7f1d17;
		}
		.dropdown-item {
			color: white;
		}
		.textbgred {
			background-color: #7f1d17;
		}
		.carousel-caption {
			text-align: left;
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
		.chat-button {
			position: fixed;
			bottom: 1rem;
			right: 1rem;
			width: 4rem;
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
			.chat-button {
			position: fixed;
			bottom: 2rem;
			right: 1rem;
			width: 5rem;
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
	<div class="container-fluid" style="align-content: center">
		<div class="row">
			<div class="col-12 col-md-6">
				<div id="carouselFood" class="carousel slide" data-interval="3000" data-ride="carousel">
				  <ol class="carousel-indicators">
					<li data-target="#carouselFood" data-slide-to="0" class="active"></li>
					<li data-target="#carouselFood" data-slide-to="1"></li>
					<li data-target="#carouselFood" data-slide-to="2"></li>
					<li data-target="#carouselFood" data-slide-to="3"></li>
					<li data-target="#carouselFood" data-slide-to="4"></li>
				  </ol>
				  <div class="carousel-inner">
				  <div class="carousel-item active">
					<img src="menu_picture/20b2a45e15e915848f88fbbe3bf00e31" class="d-block w-100" alt="">
					<div class="carousel-caption d-none d-block">
					  <h5><span style="background-color: #7f1d17;">&nbsp;ข้าวเหนียวไก่ทอด&nbsp;</span></h5>
					  <p>ร้านข้าวเหนียวไก่อักษร สาขา 2</p>
					</div>
				  </div>
				  <div class="carousel-item">
					<img src="menu_picture/	
		db7bb7c5507b5f3421d96323b609ac2c" class="d-block w-100" alt="">
					<div class="carousel-caption d-none d-block">
					  <h5><span style="background-color: #7f1d17;">&nbsp;สปาเก็ตตี้คาโบนารา&nbsp;</span></h5>
					  <p>ร้านรัตน์ จานด่วน</p>
					</div>
				  </div>
				  <div class="carousel-item">
					<img src="menu_picture/329e045ba08e9254008ad7a1b241688d" class="d-block w-100" alt="">
					<div class="carousel-caption d-none d-block">
					  <h5><span style="background-color: #7f1d17;">&nbsp;น้ำตกหมู&nbsp;</span></h5>
					  <p>ร้านข้าวเหนียวไก่อักษร สาขา 2</p>
					</div>
				  </div>
				  <div class="carousel-item">
					<img src="menu_picture/a10f29e7720ccd8d609d10b57772b231" class="d-block w-100" alt="">
					<div class="carousel-caption d-none d-block">
					  <h5><span style="background-color: #7f1d17;">&nbsp;เสต็กหมูพริกไทยดำ&nbsp;</span></h5>
					  <p>ร้านทูเดย์เสต็ก</p>
					</div>
				  </div>
				  <div class="carousel-item">
					<img src="menu_picture/294d92ff2acf64813cd569560b376955" class="d-block w-100" alt="">
					<div class="carousel-caption d-none d-block">
					  <h5><span style="background-color: #7f1d17;">&nbsp;ไข่กระทะ&nbsp;</span></h5>
					  <p>ร้านส้ม อาหารชุด</p>
					</div>
				  </div>
				  </div>
				  <a class="carousel-control-prev" href="#carouselFood" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				  </a>
				  <a class="carousel-control-next" href="#carouselFood" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				  </a>
				</div>
			</div>
			<div class="col-12 col-md-6">
				<div class="row">
					<div class="card card-hz mb-3">
					  <div class="row no-gutters">
						<div class="col-5">
						  <img src="n_image/4d5307e5af046411059dce8545c1040b" class="card-img " alt="">
						</div>
						<div class="col-7">
						  <div class="card-body card-body-hz">
							<h5 class="card-title">ลด 10% ทุกเมนู!</h5>
							<div class="card-text">ร้านส้ม อาหารชุด จัดโปรเด็ดเอาใจเหล่าวิศวะ อิ่มอร่อยกันได้ตั้งแต่วันนี้</div>
							<div class="card-caption"><small class="text-muted">1 ต.ค. 62</small></div>
							<a href="#" class="btn btn-success">รับเลย</a>
						  </div>
						</div>
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="card card-hz mb-3">
					  <div class="row no-gutters">
						<div class="col-5">
						  <img src="n_image/39bc5bb73fc571fda1fae134b93d118d" class="card-img" alt="">
						</div>
						<div class="col-7">
						  <div class="card-body card-body-hz">
							<h5 class="card-title">รับโค้ดส่วนลดฟรี ที่นี่!</h5>
							<div class="card-text">แจกส่วนลดสำหรับร้านรัตน์ จานด่วน ใช้ได้กับเมนูไก่</div>
							<div class="card-caption"><small class="text-muted">15 ต.ค. 62</small></div>
							<a href="#" class="btn btn-success">รับเลย</a>
						  </div>
						</div>
					  </div>
					</div>
				</div>
			</div>
		 </div>
	  </div>
	<div style="display: inline; font-size: 30px">
		<div class="container-fluid d-none d-md-block">เมนูประจำสัปดาห์</div>
		<a href = "usermenu.php">
			<img src = "Materials/homepage/button.png" class="rounded mx-auto d-block" width="300px" alt = "menubutton">
		</a>
	</div>
	  <div class="container-fluid" style="align-content: center">
			<div class="row">
				<div class="col-12 col-md-3">
					<div class="card">
					  <img src="n_image/69283e3ccb04cf1251a10d0779130794" class="card-img-top" alt="">
					  <div class="card-body">
						<h5 class="card-title">ต่อแถวให้เป็นระเบียบกันเถอะ!</h5>
						<p class="card-text">ร่วมต่อแถวให้เป็นระเบียบ ลดความวุ่นวายใน i-canteen</p>
						<a href="#" class="btn btn-primary">อ่านต่อ</a>
					  </div>
					</div>
				</div>
				<div class="col-12 col-md-3">
					<div class="card">
					  <img src="n_image/92c4cda8117406ff53a7591371911eba" class="card-img-top" alt="" style="width: 18.5rem; height: 12rem;">
					  <div class="card-body">
						<h5 class="card-title">แยกขยะถูกที่ ทิ้งให้ลงถัง</h5>
						<p class="card-text">ช่วยกันรีไซเคิลขยะ ลดโลกร้อน</p>
						<a href="#" class="btn btn-primary">อ่านต่อ</a>
					  </div>
					</div>
				</div>
				<div class="col-12 col-md-3">
					<div class="card">
					  <img src="n_image/c5cda3432e730e3537f8e7b6a4755640" class="card-img-top" alt="">
					  <div class="card-body">
						<h5 class="card-title">น้ำมันทอดซ้ำ อันตรายอย่างไร</h5>
						<p class="card-text"></p>
						<a href="#" class="btn btn-primary">อ่านต่อ</a>
					  </div>
					</div>
				</div>
				<div class="col-12 col-md-3">
					<div class="card">
					  <img src="n_image/2934332ae41562988b7a489b8b31fe8b" class="card-img-top" alt="">
					  <div class="card-body">
						<h5 class="card-title">ตรวจสอบความปลอดภัยอาหาร</h5>
						<p class="card-text"></p>
						<a href="#" class="btn btn-primary">อ่านต่อ</a>
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
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>