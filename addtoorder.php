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
    $user_balance = mysqli_real_escape_string($conn,$_SESSION['user_balance']);
    $order_amount = 1;
    $order_status = 'รอร้านรับคำสั่งซื้อ';
    $requestinfo = "SELECT * FROM menu WHERE menu_id=$menu_id" or die("Error:" . mysqli_error());
	$menuinfo = mysqli_fetch_array(mysqli_query($conn, $requestinfo));
    $menu_price = $menuinfo['menu_price'];
    $leftover_balance = $user_balance - $menu_price;
    
    if ($leftover_balance >= 0) {
        $sql = "INSERT INTO orderhistory (menu_id,user_id,order_amount,order_status)
        VALUES ('$menu_id','$user_id','$order_amount','$order_status');
        UPDATE user SET user_balance=$leftover_balance WHERE user_id=$user_id";

        $result = mysqli_multi_query($conn, $sql);
    
        if ($result) {
            echo "<script type='text/javascript'>"; 
            echo "alert('สั่งอาหารเรียบร้อยแล้ว');"; 
            echo "window.location = 'myorder.php'; "; 
            echo "</script>"; 
            $_SESSION['user_balance'] = $leftover_balance;
        } else {
            echo "Error: " . $conn->error;
        }

    } else {
        echo "Error: insufficient balance";
    }
}


?>