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

        } else if ($_SESSION["user_role"]=="vendor" && isset($_GET['order_id'])) { 
            $vendor_id = $_SESSION["user_id"];
            $vendor_balance = $_SESSION["user_balance"];

            $requestinfo = "SELECT *, order_amount*menu_price AS order_total FROM orderhistory, menu WHERE menu.menu_id = orderhistory.menu_id AND orderhistory.order_id=".$_GET['order_id'] or die("Error:" . mysqli_error());
		    $orderinfo = mysqli_fetch_array(mysqli_query($conn, $requestinfo));
            $order_user_id = $orderinfo['user_id'];
            $order_total = $orderinfo['order_total'];
            $current_order_status = $orderinfo['order_status'];
            
            $order_status = $_GET['order_status'];
            $order_id = $_GET['order_id'];

            $requestuserinfo = "SELECT * FROM user WHERE user.user_id = $order_user_id" or die("Error:" . mysqli_error());
		    $userinfo = mysqli_fetch_array(mysqli_query($conn, $requestuserinfo));
            $order_user_balance = $userinfo['user_balance'];

            $requestvendorinfo = "SELECT * FROM user WHERE user.user_id = $vendor_id" or die("Error:" . mysqli_error());
		    $vendorinfo = mysqli_fetch_array(mysqli_query($conn, $requestvendorinfo));
            if ($current_order_status == 'รอร้านรับคำสั่งซื้อ') {
                if ($_GET['order_status'] == 'accept' ) {
                    $query = "UPDATE orderhistory SET order_status='กำลังเตรียมอาหาร' WHERE order_id=$order_id" or die("Error:" . mysqli_error());
                    
                } elseif ($_GET['order_status'] == 'reject' ) {
                    $new_balance = $order_user_balance + $order_total;
                    $query = "UPDATE orderhistory SET order_status='ถูกยกเลิก' WHERE order_id=$order_id;
                    UPDATE user SET user_balance=$new_balance WHERE user_id=$order_user_id;" or die("Error:" . mysqli_error());
                    
                } else {
                    echo "<script type='text/javascript'>"; 
                    echo "alert('Error: unable to update status, please try again');"; 
                    echo "window.location = 'restaurantorders.php'; "; 
                    echo "</script>";
                }
            } elseif ($_GET['order_status'] == 'finish' ) {
                $new_vendor_balance = $vendor_balance + $order_total;
                $query = "UPDATE orderhistory SET order_status='อาหารเสร็จแล้ว', finish_timestamp=now(), time_diff=TIMESTAMPDIFF(MINUTE, order_timestamp, now()) WHERE order_id=$order_id;
                UPDATE user SET user_balance=$new_vendor_balance WHERE user_id=$vendor_id " or die("Error:" . mysqli_error());
                

            } else {
                echo "<script>";
                echo "alert(\"Error $conn->error\");"; 
                echo "window.history.back()";
                echo "</script>";
            }
        
            $result = mysqli_multi_query($conn, $query); 

            if($result){
                echo "<script>";
                echo "alert(\"เปลี่ยนสถานะออเดอร์เรียบร้อยแล้ว\");";
                $_SESSION["user_balance"] = $new_vendor_balance; 
                echo "window.history.back()";
                echo "</script>";
            } else {
                echo "<script>";
                echo "alert(\"Error $conn->error\");"; 
                echo "window.history.back()";
                echo "</script>";
            }
        }
    }
?>