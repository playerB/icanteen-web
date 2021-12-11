<?php session_start();?>
<?php 

if (!$_SESSION["user_name"]){  //check session
		Header("Location: form_login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form 

}else{
	if ($_SESSION["user_role"]!="admin"){  //ถ้าเป็น member ให้กลับ
		echo "<script>";
        echo "alert(\"You do not have access to this page\");"; 
        echo "window.history.back()";
        echo "</script>";

    }
	if ($_SESSION["user_role"]=="admin"){ 
		include('Connections/condb.php');
		$query01 = "SELECT AVG(time_diff) FROM orderhistory WHERE time_diff IS NOT NULL" or die("Error:" . mysqli_error());
		$time_diff_avg = mysqli_fetch_array(mysqli_query($conn, $query01))[0];

		$query02 = "SELECT COUNT(order_id) FROM orderhistory" or die("Error:" . mysqli_error());
		$order_count = mysqli_fetch_array(mysqli_query($conn, $query02))[0];

		$query03 = "SELECT COUNT(order_id) FROM orderhistory WHERE time_diff IS NOT NULL AND order_status = 'อาหารเสร็จแล้ว'" or die("Error:" . mysqli_error());
		$order_count_success = mysqli_fetch_array(mysqli_query($conn, $query03))[0];

		$query04 = "SELECT COUNT(order_id) FROM orderhistory WHERE order_status = 'ถูกยกเลิก'" or die("Error:" . mysqli_error());
		$order_count_cancel = mysqli_fetch_array(mysqli_query($conn, $query04))[0];

		$query05 = "SELECT COUNT(menu_id) FROM menu" or die("Error:" . mysqli_error());
		$menu_count = mysqli_fetch_array(mysqli_query($conn, $query05))[0];

		$query06 = "SELECT user_name, SUM(order_amount*menu_price) FROM orderhistory,menu,user WHERE menu.menu_id = orderhistory.menu_id AND user.user_id = orderhistory.user_id AND order_status IN ('อาหารเสร็จแล้ว') GROUP BY user_name ORDER BY 2 DESC" or die("Error:" . mysqli_error());
		$result06 = mysqli_fetch_array(mysqli_query($conn, $query06));
		$member_maxspent = $result06[0];
		$member_maxspent_count = $result06[1];

		$query07 = "SELECT restaurant_name, SUM(order_amount*menu_price) FROM orderhistory,menu,restaurant WHERE menu.menu_id = orderhistory.menu_id AND restaurant.restaurant_id = menu.restaurant_id AND order_status IN ('อาหารเสร็จแล้ว') GROUP BY restaurant_name ORDER BY 2 DESC" or die("Error:" . mysqli_error());
		$result07 = mysqli_fetch_array(mysqli_query($conn, $query07));
		$restaurant_maxrev =$result07[0];
		$restaurant_maxrev_count = $result07[1];


?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
	<link href="css.css" rel="stylesheet">
	<title>Admin page</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php include("navbar.php"); ?>
	<a href="insertrestaurant.php" class="btn btn-primary">+ Add new restaurant</a>
	<a href="allorders.php" class="btn btn-primary">Show all orders log</a>
	<br>
	<div class="container" style="display: inline; font-size: 36px;">
	Admin dashboard
		<div class="alert alert-info col-4" style="font-size: 18px;" role="alert">
			Average time to deliver order: <?php echo $time_diff_avg; ?> Minutes
		</div>
		<div class="row">
			<div class="alert alert-info col-4" style="font-size: 18px;" role="alert">
				Total order count: <?php echo $order_count; ?>
			</div>
			<div class="alert alert-success col-4" style="font-size: 18px;" role="alert">
				Total order succeed: <?php echo $order_count_success; ?>
			</div>
			<div class="alert alert-warning col-4" style="font-size: 18px;" role="alert">
				Total order cancelled: <?php echo $order_count_cancel; ?>
			</div>
		</div>
		<div class="row">
			<div class="alert alert-info col-4" style="font-size: 18px;" role="alert">
				Total menu in I-CANTEEN: <?php echo $menu_count; ?>
			</div>
		</div>
		<div class="row">
			<div class="alert alert-primary col-4" style="font-size: 18px;" role="alert">
				Member with max spent: <?php echo $member_maxspent; ?> <br>
				Total spent ฿: <?php echo $member_maxspent_count; ?>
			</div>
			<div class="alert alert-primary col-4" style="font-size: 18px;" role="alert">
				Restaurant with max revenue: <?php echo $restaurant_maxrev; ?> <br>
				Total revenue ฿: <?php echo $restaurant_maxrev_count; ?>
			</div>
		</div>
	</div>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
<?php } }?>