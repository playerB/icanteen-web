<?php session_start(); error_reporting(~E_NOTICE );
    include('Connections/condb.php');

    if (!$_SESSION["user_name"]){  //check session
        Header("Location: form_login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า form_login.php 

    } else {
        if ($_SESSION["user_role"]!="admin") {
            echo "<script>";
            echo "alert(\"You do not have access to this page\");"; 
            echo "window.history.back()";
            echo "</script>";

        } else if ($_SESSION["user_role"]=="admin") { 
            $owner_id = $_SESSION["user_id"];

            $query1 = "SELECT * FROM menu, orderhistory, user, restaurant WHERE 
            menu.menu_id= orderhistory.menu_id AND user.user_id = orderhistory.user_id AND menu.restaurant_id = restaurant.restaurant_id ORDER BY order_timestamp DESC" 

            or die("Error:" . mysqli_error()); 

            $result = mysqli_query($conn, $query1); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Log</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
	<link href="css.css" rel="stylesheet">
</head>
<body>
<?php include("navbar.php"); ?>
    <a href="showreport.php" class="btn btn-primary">Back to report page</a>
    <a href="admin_page.php" class="btn btn-primary">Show dashboard overview</a>
    <br>
    <div class='table-responsive'>
        <table class='table table-striped table-hover'>
            <thead class='thead-dark' align='center' bgcolor='#CCCCCC'>
                <tr>
                    <th scope='col'>Order ID</th>
                    <th scope='col'>User name</th>
                    <th scope='col'>Menu name</th>
                    <th scope='col'>Restaurant name</th>
                    <th scope='col'>Price</th>
                    <th scope='col'>Amount</th>
                    <th scope='col'>Note</th>
                    <th scope='col'>Order timestamp</th>
                    <th scope='col'>Finish timestamp</th>
                    <th scope='col'>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
            
            while($row = mysqli_fetch_array($result)) { 
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
                $total_price = $row["menu_price"] * $row["order_amount"];
                echo "<tr style='background-color: $bgcolor;'>";
                echo "<td align='center'>" .$row["order_id"] .  "</td> ";
                echo "<td align='center'>" .$row["user_name"] .  "</td> ";
                echo "<td align='center'>" .$row["menu_name"] .  "</td> ";
                echo "<td align='center'>" .$row["restaurant_name"] .  "</td> ";
                echo "<td align='center'>" .$total_price.  "</td> ";
                echo "<td align='center'>" .$row["order_amount"] .  "</td> ";
                echo "<td align='center'>" .$row["note"] .  "</td> ";
                echo "<td align='center'>" .$row["order_timestamp"] .  "</td> ";
                echo "<td align='center'>" .$row["finish_timestamp"] .  "</td> ";
                echo "<td align='center'>" .$row["order_status"] .  "</td> ";
                echo "</tr>";
            } ?>
            </tbody>
        </table>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
<?php } } ?>