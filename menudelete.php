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
           

			$menu_id = $_REQUEST["menu_id"];

			//ลบข้อมูลออกจาก database ตาม menu_id ที่ส่งมา

			$sql = "DELETE FROM menu WHERE menu_id='$menu_id' ";
			$result = mysqli_query($conn, $sql) or die ("Error in query: $sql " . mysqli_error());

				if($result){
				echo "<script type='text/javascript'>";
				echo "alert('Succesfully removed record no. $menu_id');";
				echo "window.location = 'showmenu.php'; ";
				echo "</script>";
				}
				else{
				echo "<script type='text/javascript'>";
				echo "alert('Error');";
				echo "</script>";
			}
		}
	}?>