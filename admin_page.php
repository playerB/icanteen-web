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
		$query01 = "SELECT AVG(time_diff) FROM orderhistory WHERE time_diff IS NOT NULL AND orderhistory.order_timestamp >= DATE(NOW()) - INTERVAL 0 WEEK" or die("Error:" . mysqli_error());
		$time_diff_avg = mysqli_fetch_array(mysqli_query($conn, $query01))[0];

		$query02 = "SELECT COUNT(order_id) FROM orderhistory WHERE orderhistory.order_timestamp >= DATE(NOW()) - INTERVAL 0 WEEK" or die("Error:" . mysqli_error());
		$order_count = mysqli_fetch_array(mysqli_query($conn, $query02))[0];

		$query03 = "SELECT COUNT(order_id) FROM orderhistory WHERE time_diff IS NOT NULL AND order_status = 'อาหารเสร็จแล้ว' AND orderhistory.finish_timestamp >= DATE(NOW()) - INTERVAL 0 WEEK" or die("Error:" . mysqli_error());
		$order_count_success = mysqli_fetch_array(mysqli_query($conn, $query03))[0];

		$query04 = "SELECT COUNT(order_id) FROM orderhistory WHERE order_status = 'ถูกยกเลิก' AND orderhistory.order_timestamp >= DATE(NOW()) - INTERVAL 0 WEEK" or die("Error:" . mysqli_error());
		$order_count_cancel = mysqli_fetch_array(mysqli_query($conn, $query04))[0];

		$query05 = "SELECT COUNT(menu_id) FROM menu" or die("Error:" . mysqli_error());
		$menu_count = mysqli_fetch_array(mysqli_query($conn, $query05))[0];

		$week_revenue = array();
		for ($i=0; $i <= 7; $i++) { 
			$query_weekly_rev = "SELECT SUM(order_amount*menu_price) FROM orderhistory, menu WHERE menu.menu_id = orderhistory.menu_id
			AND orderhistory.finish_timestamp >= DATE(NOW()) - INTERVAL $i WEEK AND orderhistory.finish_timestamp < DATE(NOW()) - INTERVAL ".($i-1)." WEEK
			AND order_status IN ('อาหารเสร็จแล้ว')" or die("Error:" . mysqli_error());

			$result_weekly_rev = mysqli_fetch_array(mysqli_query($conn, $query_weekly_rev));
			if ($result_weekly_rev[0] == null) {
				$this_week_revenue = 0;
			} else {
				$this_week_revenue = $result_weekly_rev[0];
			}
			if ($i == 0) {
				array_push($week_revenue, array("y" => $this_week_revenue, "label" => "this week"));
			} else {
				array_push($week_revenue, array("y" => $this_week_revenue, "label" => $i." week ago"));
			}
		}

		// total sales of each restaurant in the last week
		$restaurant_share = array();
		$query_restaurant_share = "SELECT restaurant_name, SUM(order_amount*menu_price) AS total_rev FROM orderhistory, menu, restaurant WHERE menu.menu_id = orderhistory.menu_id AND menu.restaurant_id = restaurant.restaurant_id
		AND orderhistory.finish_timestamp >= DATE(NOW()) - INTERVAL 0 WEEK
		AND order_status IN ('อาหารเสร็จแล้ว') GROUP BY restaurant_name ORDER BY total_rev" or die("Error:" . mysqli_error());
		$result_restaurant_share = mysqli_query($conn, $query_restaurant_share);

		while($row = mysqli_fetch_array($result_restaurant_share)) {
			array_push($restaurant_share, array("y" => $row[1], "label" => $row[0]));
		}

		$user_spent = array();
		$query_user_spent = "SELECT user_name, SUM(order_amount*menu_price) AS total_spent FROM orderhistory, menu, user WHERE menu.menu_id = orderhistory.menu_id AND user.user_id = orderhistory.user_id
		AND orderhistory.finish_timestamp >= DATE(NOW()) - INTERVAL 0 WEEK
		AND order_status IN ('อาหารเสร็จแล้ว') GROUP BY user_name ORDER BY total_spent LIMIT 10" or die("Error:" . mysqli_error());
		$result_user_spent = mysqli_query($conn, $query_user_spent);

		while($row = mysqli_fetch_array($result_user_spent)) {
			array_push($user_spent, array("y" => $row[1], "label" => $row[0]));
		}

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
	<script>
        window.onload = function () {

        var weeklySalesChart = new CanvasJS.Chart("weeklySalesChart", {
            title: {
                fontFamily: "Mitr",
                text: "Weekly Revenue"
            },
            axisY: {
                title: "Sales (฿)"
            },
            data: [{
                type: "line",
                dataPoints: <?php echo json_encode($week_revenue, JSON_NUMERIC_CHECK); ?>
            }]
        });
        weeklySalesChart.render();

        var restaurantShareChart = new CanvasJS.Chart("restaurantShareChart", {
            animationEnabled: true,
            title: {
                fontFamily: "Mitr",
                text: "Share of Sales by Restaurant"
            },
            subtitles: [{
                fontFamily: "Mitr",
                text: "only this week"
            }],
            data: [{
                type: "pie",
                yValueFormatString: "#,##0.00\"฿\"",
                indexLabel: "{label} ({y})",
                dataPoints: <?php echo json_encode($restaurant_share, JSON_NUMERIC_CHECK); ?>
            }]
        });
        restaurantShareChart.render();

		var userSpentChart = new CanvasJS.Chart("userSpentChart", {
            animationEnabled: true,
            title: {
                fontFamily: "Mitr",
                text: "Top 10 User Spending"
            },
            subtitles: [{
                fontFamily: "Mitr",
                text: "only this week"
            }],
            data: [{
                type: "pie",
                yValueFormatString: "#,##0.00\"฿\"",
                indexLabel: "{label} ({y})",
                dataPoints: <?php echo json_encode($user_spent, JSON_NUMERIC_CHECK); ?>
            }]
        });
        userSpentChart.render();

        }
    </script>
</head>
<body>
<?php include("navbar.php"); ?>
	<a href="insertrestaurant.php" class="btn btn-primary">+ Add new restaurant</a>
	<a href="allorders.php" class="btn btn-primary">Show all orders log</a>
	<br>
	<div class="container" style="display: inline; font-size: 36px;">
	Admin dashboard
		<div class="row">
            &nbsp;
            <div id="weeklySalesChart" style="height: 400px; width: 45%;"></div>
            <div id="restaurantShareChart" style="height: 400px; width: 45%;"></div>
        </div>
		<div class="row">
            &nbsp;
            <div id="userSpentChart" style="height: 400px; width: 45%;"></div>
        </div>
		&nbsp; This week order statistics:
		<div class="row">
			<div class="alert alert-info col-4" style="font-size: 18px;" role="alert">
				Average time to deliver order: <?php echo $time_diff_avg; ?> Minutes
			</div>
			<div class="alert alert-info col-2" style="font-size: 18px;" role="alert">
				Total order count: <?php echo $order_count; ?>
			</div>
			<div class="alert alert-success col-2" style="font-size: 18px;" role="alert">
				Total order succeed: <?php echo $order_count_success; ?>
			</div>
			<div class="alert alert-danger col-2" style="font-size: 18px;" role="alert">
				Total order cancelled: <?php echo $order_count_cancel; ?>
			</div>
		</div>
		<div class="row">
			<div class="alert alert-info col-4" style="font-size: 18px;" role="alert">
				Total menu in I-CANTEEN: <?php echo $menu_count; ?>
			</div>
		</div>
	</div>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
<?php } }?>