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

	}
	else if ($_SESSION["user_role"]=="admin") { 

        $report_id = mysqli_real_escape_string($conn,$_GET['report_id']);
        $sql = "UPDATE report SET report_status='แก้ไขแล้ว' WHERE report_id=$report_id" ;

        $result = mysqli_query($conn, $sql) or die ("Error in query: $sql " . mysqli_error($conn));
    
        mysqli_close($conn); //ปิดการเชื่อมต่อ database 
    
        if($result){
            echo "<script type='text/javascript'>";
            echo "alert('Succesfully updated report status');";
            echo "window.location = 'showreport.php'; ";
            echo "</script>";
        } else{
            echo "<script type='text/javascript'>";
            echo "alert('Error back to report view again');";
                echo "window.location = 'showreport.php'; ";
            echo "</script>";
        }
    }
}
?>