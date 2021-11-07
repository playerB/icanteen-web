<?php session_start(); error_reporting(~E_NOTICE);
include('Connections/condb.php');

if($_GET['menu_id']==''){ 
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'index.php'; "; 
echo "</script>"; 
} else if (!$_SESSION["user_name"]) {
    Header("Location: form_login.php");
} else {
    $menu_id = mysqli_real_escape_string($conn,$_GET['menu_id']);
    $user_id = mysqli_real_escape_string($conn,$_SESSION['user_id']);
    $order_amount = 1;
    $order_status = 'รอร้านรับคำสั่งซื้อ';
    
    $sql = "INSERT INTO orderhistory (menu_id,user_id,order_amount,order_status)
    VALUES ('$menu_id','$user_id','$order_amount','$order_status')";

    if ($conn->query($sql) === TRUE) {
        echo "<script type='text/javascript'>"; 
        echo "alert('สั่งอาหารเรียบร้อยแล้ว');"; 
        echo "window.location = 'myorder.php'; "; 
        echo "</script>"; 
    } else {
        echo "Error: " . $conn->error;
    }
}


?>