<?php session_start(); error_reporting(~E_NOTICE );
include('Connections/condb.php');

$query = "SELECT * FROM news ORDER BY news_id ASC" or die("Error:" . mysqli_error()); 
$result = mysqli_query($conn, $query);
$query2 = "SELECT SUM(order_amount), menu.menu_id, menu_name, menu_picture, restaurant_name FROM orderhistory, menu, restaurant WHERE menu.menu_id = orderhistory.menu_id AND menu.restaurant_id = restaurant.restaurant_id AND orderhistory.finish_timestamp >= DATE(NOW()) - INTERVAL 7 DAY GROUP BY menu.menu_id ORDER BY 1 DESC LIMIT 5" or die("Error:" . mysqli_error());
$result2 = mysqli_query($conn, $query2);

?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>I-CANTEEN</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
	<link href="css.css" rel="stylesheet">
</head>
    <body>
	<?php include("navbar.php"); ?>
	<div class="container-fluid" style="align-content: center">
		<div class="row justify-content-center">
			<div class="col-6">
				<div style="display: inline; font-size: 30px">
					<div class="container-fluid d-none d-md-block">เมนูขายดีที่สุด ประจำสัปดาห์</div>
				</div>
				<div id="carouselFood" class="carousel slide" data-interval="3000" data-ride="carousel">
					<ol class="carousel-indicators">
						<li data-target="#carouselFood" data-slide-to="0" class="active"></li>
						<li data-target="#carouselFood" data-slide-to="1"></li>
						<li data-target="#carouselFood" data-slide-to="2"></li>
						<li data-target="#carouselFood" data-slide-to="3"></li>
						<li data-target="#carouselFood" data-slide-to="4"></li>
					</ol>
				  	<div class="carousel-inner">
					<?php 
						$topmenu = mysqli_fetch_array($result2);
						$topmenu_id = $topmenu["menu_id"];
						$topmenu_picture = $topmenu["menu_picture"];
						$topmenu_name = $topmenu["menu_name"];
						$topmenu_restaurant = $topmenu["restaurant_name"];
						
						echo '
						<div class="carousel-item active" style="height: 30rem; object-fit: cover;">
							<a href="selectmenu.php?menu_id='.$topmenu_id.'"><img src="menu_picture/'.$topmenu_picture.'" style="width: 50rem; object-fit: cover;" alt=""></a>	
								<div class="carousel-caption d-none d-block">
									<h5><span style="background-color: #7f1d17;">&nbsp;'.$topmenu_name.'&nbsp;</span></h5>
									<p>'.$topmenu_restaurant.'</p>
								</div>
							</div>
						';

						while($showmenu = mysqli_fetch_array($result2)) {
							$showmenu_id = $showmenu["menu_id"];
							$showmenu_picture = $showmenu["menu_picture"];
							$showmenu_name = $showmenu["menu_name"];
							$showmenu_restaurant = $showmenu["restaurant_name"];
							
							echo '
							<div class="carousel-item" style="height: 30rem; object-fit: cover;">
								<a href="selectmenu.php?menu_id='.$showmenu_id.'"><img src="menu_picture/'.$showmenu_picture.'" style="width: 50rem; object-fit: cover;" alt=""></a>	
									<div class="carousel-caption d-none d-block">
										<h5><span style="background-color: #7f1d17;">&nbsp;'.$showmenu_name.'&nbsp;</span></h5>
										<p>'.$showmenu_restaurant.'</p>
									</div>
								</div>
							';
						}
					?>
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
				<div style="display: inline; font-size: 30px">
					<div class="container-fluid d-none d-md-block">เมนูประจำคณะ</div>
				</div>
				<div class="row">
					<div class="card card-hz mb-3">
					  <div class="row no-gutters">
						<div class="col-5">
						  <img src="menu_picture/d968f109078b81a707d0637f12a7b1b7" class="card-img " alt="">
						</div>
						<div class="col-7">
						  <div class="card-body card-body-hz">
							<h5 class="card-title">ข้าวเหนียวไก่ทอด</h5>
							<div class="card-text">ข้าวเหนียวไก่ทอดอักษร สาขา 2 ในตำนาน ที่ใครๆ ก็ต้องมากิน</div>
							<a href="selectmenu.php?menu_id=56" class="btn btn-success">ดูรายละเอียด</a>
						  </div>
						</div>
					  </div>
					</div>
				</div>
				<a href="usermenu.php" class="btn btn-danger btn-lg">ดูเมนูทั้งหมด</a>
			</div>
		 </div>
	  </div>
	
	  <div style="display: inline; font-size: 30px">
		  <div class="container-fluid d-none d-md-block">ข่าวประชาสัมพันธ์</div>
	  </div>
	  	<div class="container-fluid" style="align-content: center">
			<div class="row">
			<?php
				while($row = mysqli_fetch_array($result)) { ?>
					<div class="col-12 col-md-3">
						<div class="card">
							<img src="news_picture/<?php echo $row['news_picture']; ?>" class="card-img" alt="">
							<div class="card-body">
								<h5 class="card-title"><?php echo $row['news_headline']; ?></h5>
								<div class="card-text"><?php echo $row['news_content']; ?></div>
								<?php 
								echo '<a href="selectnews.php?news_id='.$row['news_id'].'" class="btn btn-primary">อ่านต่อ</a>';
								?>
							</div>
						</div>
					</div>
			<?php } ?>
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>