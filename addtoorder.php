<?php session_start(); error_reporting(~E_NOTICE);
include('Connections/condb.php');

if($_GET['menu_id']==''){ 
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'index.php'; "; 
echo "</script>"; 
} elseif ($_SESSION["user_role"]!="member"){  //check session
	Header("Location: form_login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า form_login.php 
} else {

    $menu_id = mysqli_real_escape_string($conn,$_GET['menu_id']);
    $user_id = mysqli_real_escape_string($conn,$_SESSION['user_id']);
    $user_balance = mysqli_real_escape_string($conn,$_SESSION['user_balance']);
    $order_amount = mysqli_real_escape_string($conn,$_GET['menu_amount']);
    $note = mysqli_real_escape_string($conn,$_GET['note']);
    $order_status = 'รอร้านรับคำสั่งซื้อ';
    $requestinfo = "SELECT * FROM menu WHERE menu_id=$menu_id" or die("Error:" . mysqli_error());
	$menuinfo = mysqli_fetch_array(mysqli_query($conn, $requestinfo));
    $order_price = $menuinfo['menu_price']*$order_amount;
    $leftover_balance = $user_balance - $order_price;
    
    if ($leftover_balance >= 0) {
        $sql = "INSERT INTO orderhistory (menu_id,user_id,order_amount,order_status,note)
        VALUES ('$menu_id','$user_id','$order_amount','$order_status','$note');
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
        echo "<script type='text/javascript'>"; 
        echo "alert('Error: insufficient balance');"; 
        echo "window.location = 'myorder.php'; "; 
        echo "</script>";
    }
}


?>