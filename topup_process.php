<?php
    session_start();
    require('Connections/condb.php');
    if (!$_SESSION["user_name"]){  //check session
        Header("Location: form_login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า form_login.php 
    
        
    } else if ((float)$_POST['amount'] < 0){
        echo "<script type='text/javascript'>";
        echo "alert('Error back to topup again');";
            echo "window.location = 'topup.php'; ";
        echo "</script>";
    } else {

        
        $username = $_SESSION['user_name'];
        $newbalance = (float)$_SESSION["user_balance"] + (float)$_POST['amount'];

        $sql = "UPDATE user SET "."user_balance=$newbalance "."WHERE user_name='$username'";


        $result = mysqli_query($conn, $sql) or die ("Error in query: $sql " . mysqli_error($conn));
    
        mysqli_close($conn); //ปิดการเชื่อมต่อ database 
    
        
        if($result){
            $_SESSION["user_balance"] = $newbalance;
            echo "<script type='text/javascript'>";
            echo "alert('Succesfully updated your balance');";
            echo "window.location = 'index.php'; ";
            echo "</script>";
        } else{
            echo "<script type='text/javascript'>";
            echo "alert('Error back to topup again');";
                echo "window.location = 'topup.php'; ";
            echo "</script>";
        }

    }
?>