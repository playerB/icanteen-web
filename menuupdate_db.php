<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('Connections/condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
 
//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลักและไม่แก้ไขข้อมูล
if($_POST["m_id"]==''){
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'showmenu.php'; "; 
echo "</script>";
}
 
//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
	$m_id = $_POST["m_id"];
	$menuname = $_POST["menuname"];
	$resname = $_POST["resname"];
	$price = $_POST["price"];
	$cate = $_POST["cate"];
	$info = $_POST["info"];
	if(!empty($_FILES['image']['name'])) {
			$filename = md5($_FILES['image']['name'].time());
			$ext = explode('.',$_FILES['image']['name']);
			$path = "m_image/";
			$path_copy = $path.$filename;

			move_uploaded_file($_FILES['image']['tmp_name'],$path_copy);  	
		$sql = "UPDATE icanteen_menu SET " 
			."m_name='$menuname', "
			."m_resname='$resname', "
			."m_price='$price', "
			."m_cate='$cate', "
			."m_info='$info', "
			."m_image='$filename'
			WHERE m_id='$m_id'";
	} else { //ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database
		$sql = "UPDATE icanteen_menu SET " 
			."m_name='$menuname', "
			."m_resname='$resname', "
			."m_price='$price', "
			."m_cate='$cate', "
			."m_info='$info'
			WHERE m_id='$m_id'";
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