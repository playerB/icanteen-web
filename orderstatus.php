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
            $order_status = $_GET['order_status'];
            $order_id = $_GET['order_id'];

            if ($_GET['order_status'] == 'accept' && isset($_GET['order_id'])) {
                $query = "UPDATE orderhistory SET order_status='กำลังเตรียมอาหาร' WHERE order_id=$order_id" or die("Error:" . mysqli_error());
                
            } else if ($_GET['order_status'] == 'reject' && isset($_GET['order_id'])) {
                $query = "UPDATE orderhistory SET order_status='ถูกยกเลิก' WHERE order_id=$order_id" or die("Error:" . mysqli_error());
                
            } else if ($_GET['order_status'] == 'finish' && isset($_GET['order_id'])) {
                $query = "UPDATE orderhistory SET order_status='อาหารเสร็จแล้ว' WHERE order_id=$order_id" or die("Error:" . mysqli_error());

            } else {
                echo "<script>";
                echo "alert(\"Error\");"; 
                echo "window.history.back()";
                echo "</script>";
            }
        
            $result = mysqli_query($conn, $query); 

            if($result){
                echo "<script>";
                echo "alert(\"เปลี่ยนสถานะออเดอร์เรียบร้อยแล้ว\");"; 
                echo "window.history.back()";
                echo "</script>";
            } else {
                echo "<script>";
                echo "alert(\"Error\");"; 
                echo "window.history.back()";
                echo "</script>";
            }
        }
    }
?>