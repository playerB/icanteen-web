<?php session_start(); error_reporting(~E_NOTICE);
include('Connections/condb.php');

if($_GET['menu_id']==''){ 
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'index.php'; "; 
echo "</script>"; 
}

$menu_id = mysqli_real_escape_string($conn,$_GET['menu_id']);
$sql = "SELECT * FROM menu, restaurant WHERE menu_id='$menu_id' AND restaurant.restaurant_id = menu.restaurant_id " or die("Error:" . mysqli_error()); 
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
<?php include("navbar.php"); ?>
	<div class="jumbotron" style="padding-top: 30px;">
		<?php
		echo "<div class='row'>";
		echo "<div class='col-12 col-md-4'>";
		echo "<h1 class='display-5'>" .$row["menu_name"] .  "</h1>";
	  	echo "<img src='menu_picture/".$row["menu_picture"]." 'class='menu-img'>";
		echo "</div>";
		echo "<div class='col-12 col-md-8'>";
	  	echo "<h2 style='padding-top: 10px;'>ร้าน " .$row["restaurant_name"] .  "</h2> ";
		echo "<h2 style='padding-top: 10px;'>ราคา <span class='price-badge'>".$row["menu_price"]." ฿</span></h2> ";
		echo "<h4 style='padding-top: 10px;'>ประเภท : " .$row["menu_category"] .  "</h4> ";
		echo "<p style='padding-top: 10px;'>รายละเอียด : " .$row["menu_detail"].  "</p> ";
		if ($_SESSION["user_role"]=="member") {
		echo "<form action='addtoorder.php' method='get'>";
			echo "<label for='menu_amount'>ใส่จำนวน</label>";
			echo "<input type='number' name='menu_amount' id='menu_amount' value=1 min='0' step='1'/>";
			echo "<input type='hidden' name='menu_id' id='menu_id' value=$menu_id />";
			echo "<div style='padding-top: 20px;'><input type='submit' class='btn btn-success btn-lg' value='สั่งเลย!' name='submitbtn'/></div>";
		echo "</form>";
		} else {
		echo "<div style='padding-top: 20px;'><button class='btn btn-success btn-lg'  href='#' role='button' disabled>ต้อง loginเป็น member ก่อนเพื่อสั่งอาหาร </button></div>";
		}
		echo "</div></div>";
		?>
	  	
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>