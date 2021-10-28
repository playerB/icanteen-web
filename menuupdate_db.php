<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('Connections/condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
 
//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลักและไม่แก้ไขข้อมูล
if($_POST["menu_id"]==''){
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'showmenu.php'; "; 
echo "</script>";
}
 
//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
	$menu_id = $_POST["menu_id"];
	$menu_name = $_POST["menu_name"];
	$restaurant_id = $_POST["restaurant_id"];
	$menu_price = $_POST["menu_price"];
	$menu_category = $_POST["menu_category"];
	$menu_detail = $_POST["menu_detail"];
	if(!empty($_FILES['image']['name'])) {
			$filename = md5($_FILES['image']['name'].time());
			$ext = explode('.',$_FILES['image']['name']);
			$path = "menu_picture/";
			$path_copy = $path.$filename;

			move_uploaded_file($_FILES['image']['tmp_name'],$path_copy);  	
		$sql = "UPDATE menu SET " 
			."menu_name='$menu_name', "
			."restaurant_id='$restaurant_id', "
			."menu_price='$menu_price', "
			."menu_category='$menu_category', "
			."menu_detail='$menu_detail', "
			."menu_picture='$filename'
			WHERE menu_id='$menu_id'";
	} else { //ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database
		$sql = "UPDATE menu SET " 
			."menu_name='$menu_name', "
			."restaurant_id='$restaurant_id', "
			."menu_price='$menu_price', "
			."menu_category='$menu_category', "
			."menu_detail='$menu_detail'
			WHERE menu_id='$menu_id'";
	}
#error_reporting(~E_NOTICE );
 
$result = mysqli_query($conn, $sql) or die ("Error in query: $sql " . mysqli_error($conn));
 
mysqli_close($conn); //ปิดการเชื่อมต่อ database 
 
//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('Succesfully updated');";
	echo "window.location = 'showmenu.php'; ";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error back to Update again');";
        echo "window.location = 'showmenu.php'; ";
	echo "</script>";
}
?>