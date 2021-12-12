<?php session_start();
error_reporting(~E_WARNING);
    include('Connections/condb.php');

    if (!$_SESSION["user_name"]){  //check session
        Header("Location: form_login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า form_login.php 

    } else {
        if ($_SESSION["user_role"]!="vendor") {
            echo "<script>";
            echo "alert(\"You do not have access to this page\");"; 
            echo "window.history.back()";
            echo "</script>";

        } else if ($_SESSION["user_role"]=="vendor") { 
            include('Connections/condb.php');
            $owner_id = $_SESSION["user_id"];
            $query00 = "SELECT restaurant_id FROM restaurant WHERE restaurant.owner_id=$owner_id" or die("Error:" . mysqli_error()); 
            $restaurant_id = mysqli_fetch_array(mysqli_query($conn, $query00))[0]; 

            $query01 = "SELECT AVG(time_diff) FROM orderhistory, menu WHERE time_diff IS NOT NULL AND orderhistory.menu_id = menu.menu_id AND orderhistory.finish_timestamp >= DATE(NOW()) - INTERVAL 7 DAY AND restaurant_id = $restaurant_id" or die("Error:" . mysqli_error());
            $time_diff_avg = mysqli_fetch_array(mysqli_query($conn, $query01))[0];

            $query02 = "SELECT COUNT(order_id) FROM orderhistory, menu WHERE orderhistory.menu_id = menu.menu_id AND orderhistory.order_timestamp >= DATE(NOW()) - INTERVAL 7 DAY AND restaurant_id = $restaurant_id" or die("Error:" . mysqli_error());
            $order_count = mysqli_fetch_array(mysqli_query($conn, $query02))[0];

            $query03 = "SELECT COUNT(order_id) FROM orderhistory, menu WHERE time_diff IS NOT NULL AND order_status = 'อาหารเสร็จแล้ว' AND orderhistory.menu_id = menu.menu_id AND orderhistory.finish_timestamp >= DATE(NOW()) - INTERVAL 7 DAY AND restaurant_id = $restaurant_id" or die("Error:" . mysqli_error());
            $order_count_success = mysqli_fetch_array(mysqli_query($conn, $query03))[0];

            $query04 = "SELECT COUNT(order_id) FROM orderhistory, menu WHERE order_status = 'ถูกยกเลิก' AND orderhistory.menu_id = menu.menu_id AND orderhistory.order_timestamp >= DATE(NOW()) - INTERVAL 7 DAY AND restaurant_id = $restaurant_id" or die("Error:" . mysqli_error());
            $order_count_cancel = mysqli_fetch_array(mysqli_query($conn, $query04))[0];

            // collect total revenue of this restaurant for each week (last 1 to 8 weeks)
            $week_revenue = array();
            for ($i=0; $i <= 7; $i++) { 
                $query_weekly_rev = "SELECT SUM(order_amount*menu_price) FROM orderhistory,menu WHERE menu.menu_id = orderhistory.menu_id
                AND restaurant_id = $restaurant_id AND orderhistory.finish_timestamp >= DATE(NOW()) - INTERVAL $i WEEK AND orderhistory.finish_timestamp < DATE(NOW()) - INTERVAL ".($i-1)." WEEK
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

            // total sales of each menu in the last week
            $menu_share = array();
            $query_menu_share = "SELECT menu_name, SUM(order_amount*menu_price) AS total_menu_sale FROM orderhistory, menu WHERE menu.menu_id = orderhistory.menu_id
                AND restaurant_id = $restaurant_id AND orderhistory.finish_timestamp >= DATE(NOW()) - INTERVAL 0 WEEK 
                AND order_status IN ('อาหารเสร็จแล้ว') GROUP BY menu_name ORDER BY total_menu_sale" or die("Error:" . mysqli_error());
            $result_menu_share = mysqli_query($conn, $query_menu_share);

            while($row = mysqli_fetch_array($result_menu_share)) {
                array_push($menu_share, array("y" => $row[1], "label" => $row[0]));
            }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant manage</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
	<link href="css.css" rel="stylesheet">
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

        var menuShareChart = new CanvasJS.Chart("menuShareChart", {
            animationEnabled: true,
            title: {
                fontFamily: "Mitr",
                text: "Share of Sales by Menu"
            },
            subtitles: [{
                fontFamily: "Mitr",
                text: "only this week"
            }],
            data: [{
                type: "pie",
                yValueFormatString: "#,##0.00\"฿\"",
                indexLabel: "{label} ({y})",
                dataPoints: <?php echo json_encode($menu_share, JSON_NUMERIC_CHECK); ?>
            }]
        });
        menuShareChart.render();

        }
    </script>
</head>
<body>
    <?php include("navbar.php"); ?>
    
    <a href="showmenu.php" class="btn btn-primary">Show my menu</a>
    <a href="restaurantorders.php" class="btn btn-primary">Order list</a>
    <br>
    <div class="container" style="display: inline; font-size: 36px;">
	Restaurant dashboard
        <div class="row">
            &nbsp;
            <div id="weeklySalesChart" style="height: 400px; width: 45%;"></div>
            <div id="menuShareChart" style="height: 400px; width: 45%;"></div>
        </div>
        &nbsp; This week order statistics :
        <div class="row">
            <div class="alert alert-info col-4" style="font-size: 18px;" role="alert">
                Average time to deliver order: <?php echo $time_diff_avg; ?> Minutes
            </div>
			<div class="alert alert-primary col-2" style="font-size: 18px;" role="alert">
				Total order count: <?php echo $order_count; ?>
			</div>
			<div class="alert alert-success col-2" style="font-size: 18px;" role="alert">
				Total order finished: <?php echo $order_count_success; ?>
			</div>
			<div class="alert alert-danger col-2" style="font-size: 18px;" role="alert">
				Total order cancelled: <?php echo $order_count_cancel; ?>
			</div>
		</div>
	</div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
<?php } } ?>