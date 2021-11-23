<?php
session_start(); error_reporting(~E_NOTICE );
include('Connections/condb.php');
if ($_SESSION["user_role"]!="member"){  //check session
	Header("Location: form_login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า form_login.php 
}

$requestinfo = "SELECT *, order_amount*menu_price AS order_total FROM orderhistory, menu WHERE menu.menu_id = orderhistory.menu_id AND orderhistory.order_id=".$_GET['order_id'] or die("Error:" . mysqli_error());
$orderinfo = mysqli_fetch_array(mysqli_query($conn, $requestinfo));
$order_user_id = $orderinfo['user_id'];
$order_total = $orderinfo['order_total'];
$order_status = $orderinfo['order_status']; 
if ($order_status != 'รอร้านรับคำสั่งซื้อ') {
    echo "<script type='text/javascript'>"; 
    echo "alert('Error: ไม่สามารถยกเลิกได้');"; 
    echo "window.location = 'myorder.php'; "; 
    echo "</script>";
}

$order_id = $_GET['order_id'];

$requestuserinfo = "SELECT * FROM user WHERE user.user_id = $order_user_id" or die("Error:" . mysqli_error());
$userinfo = mysqli_fetch_array(mysqli_query($conn, $requestuserinfo));
$order_user_balance = $userinfo['user_balance'];

$new_balance = $order_user_balance + $order_total;
$query = "UPDATE orderhistory SET order_status='ถูกยกเลิก' WHERE order_id=$order_id;
UPDATE user SET user_balance=$new_balance WHERE user_id=$order_user_id;" or die("Error:" . mysqli_error());

$result = mysqli_multi_query($conn, $query); 

if($result){
    echo "<script>";
    echo "alert(\"เปลี่ยนสถานะออเดอร์เรียบร้อยแล้ว\");";
    $_SESSION["user_balance"] = $new_balance; 
    echo "window.history.back()";
    echo "</script>";
} else {
    echo "<script>";
    echo "alert(\"Error $conn->error\");"; 
    echo "window.history.back()";
    echo "</script>";
}
?>