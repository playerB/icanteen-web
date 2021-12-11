<?php session_start(); error_reporting(~E_NOTICE );
include('Connections/condb.php');

if ($_SESSION["user_role"]!="member"){  //check session
	Header("Location: form_login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า form_login.php 
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
	<link href="css.css" rel="stylesheet">
</head>
<body>
<?php include("navbar.php"); ?>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>My Order</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Order ID</th>
							<th>Menu</th>
							<th>Order Time</th>
							<th>Amount</th>
							<th>Total Price</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$user_id = $_SESSION["user_id"];
							$sql = "SELECT * FROM orderhistory INNER JOIN menu ON menu.menu_id=orderhistory.menu_id WHERE user_id = '$user_id' ORDER BY order_timestamp DESC";
							$result = $conn->query($sql);
							
							if ($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									// different background color for different status
									$bgcolor = "#f5f5f5";
									if($row["order_status"]=="รอร้านรับคำสั่งซื้อ"){
										$bgcolor = "#b2bec3";
									} elseif($row["order_status"]=="กำลังเตรียมอาหาร"){
										$bgcolor = "#74b9ff";
									} elseif($row["order_status"]=="ถูกยกเลิก"){
										$bgcolor = "#ff7675";
									} elseif($row["order_status"]=="อาหารเสร็จแล้ว") {
										$bgcolor = "#2ecc71";
									}
									echo "<tr style='background-color: $bgcolor;'>";
									echo "<td><img src='menu_picture/".$row["menu_picture"]." 'height='80'></td>";
									echo "<td>".$row["menu_name"]."</td>";
									echo "<td>".$row["order_timestamp"]."</td>";
									echo "<td>x".$row["order_amount"]."</td>";
									echo "<td>".$row["order_amount"]*$row["menu_price"]."฿</td>";
									echo "<td>".$row["order_status"]."</td>";
									if ($row["order_status"]=="รอร้านรับคำสั่งซื้อ") {
										echo "<td><a href='cancelorder.php?order_id=".$row["order_id"]."' class='btn btn-secondary'>ยกเลิก</a></td>";
									} elseif ($row["order_status"]=="อาหารเสร็จแล้ว") {
										echo "<td><a href='selectmenu.php?menu_id=".$row["menu_id"]."' class='btn btn-success'>สั่งอีกครั้ง</a></td>";
									} else {
										echo "<td></td>";
									}
									echo "</tr>";
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>