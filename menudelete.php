<meta charset="UTF-8">
<?php session_start();?>
<?php 

if (!$_SESSION["UserID"]){  //check session
		Header("Location: form_login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form 

}else{
	if ($_SESSION["Userlevel"]=="M"){  //ถ้าเป็น member ให้กระโดดไปหน้า user_page.php
		echo "<script>";
        echo "alert(\"You do not have access to this page\");"; 
        echo "window.history.back()";
        echo "</script>";

    }
	if ($_SESSION["Userlevel"]=="A"){
//1. เชื่อมต่อ database: 
include('Connections/condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//สร้างตัวแปรสำหรับรับค่า m_id จากไฟล์แสดงข้อมูล
$m_id = $_REQUEST["m_id"];

//ลบข้อมูลออกจาก database ตาม m_id ที่ส่งมา

$sql = "DELETE FROM icanteen_menu WHERE m_id='$m_id' ";
$result = mysqli_query($conn, $sql) or die ("Error in query: $sql " . mysqli_error());

//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('Succesfully removed record no. $m_id');";
	echo "window.location = 'showmenu.php'; ";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error');";
	echo "</script>";
}
} }?>