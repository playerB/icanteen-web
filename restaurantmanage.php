<?php session_start(); error_reporting(~E_NOTICE );
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

            $query01 = "SELECT AVG(time_diff) FROM orderhistory, menu WHERE time_diff IS NOT NULL AND orderhistory.menu_id = menu.menu_id AND restaurant_id = $restaurant_id" or die("Error:" . mysqli_error());
            $time_diff_avg = mysqli_fetch_array(mysqli_query($conn, $query01))[0];

            $query02 = "SELECT COUNT(order_id) FROM orderhistory, menu WHERE orderhistory.menu_id = menu.menu_id AND restaurant_id = $restaurant_id" or die("Error:" . mysqli_error());
            $order_count = mysqli_fetch_array(mysqli_query($conn, $query02))[0];

            $query03 = "SELECT COUNT(order_id) FROM orderhistory, menu WHERE time_diff IS NOT NULL AND order_status = 'อาหารเสร็จแล้ว' AND orderhistory.menu_id = menu.menu_id AND restaurant_id = $restaurant_id" or die("Error:" . mysqli_error());
            $order_count_success = mysqli_fetch_array(mysqli_query($conn, $query03))[0];

            $query04 = "SELECT COUNT(order_id) FROM orderhistory, menu WHERE order_status = 'ถูกยกเลิก' AND orderhistory.menu_id = menu.menu_id AND restaurant_id = $restaurant_id" or die("Error:" . mysqli_error());
            $order_count_cancel = mysqli_fetch_array(mysqli_query($conn, $query04))[0];

            $query05 = "SELECT COUNT(menu_id) FROM menu WHERE restaurant_id = $restaurant_id" or die("Error:" . mysqli_error());
            $menu_count = mysqli_fetch_array(mysqli_query($conn, $query05))[0];

            $query06 = "SELECT user_name, SUM(order_amount*menu_price) FROM orderhistory,menu,user WHERE menu.menu_id = orderhistory.menu_id AND user.user_id = orderhistory.user_id AND restaurant_id = $restaurant_id GROUP BY user_name ORDER BY 2 DESC" or die("Error:" . mysqli_error());
            $result06 = mysqli_fetch_array(mysqli_query($conn, $query06));
            $member_maxspent = $result06[0];
            $member_maxspent_count = $result06[1];

            $query07 = "SELECT restaurant_id, SUM(order_amount*menu_price) FROM orderhistory,menu WHERE menu.menu_id = orderhistory.menu_id AND restaurant_id = $restaurant_id" or die("Error:" . mysqli_error());
            $result07 = mysqli_fetch_array(mysqli_query($conn, $query07));
            //$restaurant_maxrev =$result07[0];
            $restaurant_rev_count = $result07[1];

            $query08 = "SELECT menu_name, SUM(order_amount*menu_price) FROM orderhistory,menu WHERE menu.menu_id = orderhistory.menu_id AND restaurant_id = $restaurant_id AND order_status IN ('อาหารเสร็จแล้ว', 'กำลังเตรียมอาหาร') GROUP BY menu_name ORDER BY 2 DESC" or die("Error:" . mysqli_error());
            $result08 = mysqli_fetch_array(mysqli_query($conn, $query08));
            $best_selling_menu = $result08[0];
            $best_selling_menu_rev_count = $result08[1];
           
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
    
    <a href="showmenu.php" class="btn btn-primary">Show my menu</a>
    <a href="restaurantorders.php" class="btn btn-primary">Order list</a>
    <br>
    <div class="container" style="display: inline; font-size: 36px;">
	Restaurant dashboard
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
				Total menu in your restaurant: <?php echo $menu_count; ?>
			</div>
		</div>
		<div class="row">
			<div class="alert alert-primary col-4" style="font-size: 18px;" role="alert">
				Member with max spent: <?php echo $member_maxspent; ?> <br>
				Total spent ฿: <?php echo $member_maxspent_count; ?>
			</div>
			<div class="alert alert-primary col-4" style="font-size: 18px;" role="alert">
				Total revenue ฿: <?php echo $restaurant_rev_count; ?>
			</div>
			<div class="alert alert-primary col-4" style="font-size: 18px;" role="alert">
				Best selling menu ฿: <?php echo $best_selling_menu; ?> <br>
				Total sold ฿: <?php echo $best_selling_menu_rev_count; ?>
			</div>
		</div>
	</div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
<?php } } ?>