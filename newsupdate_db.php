<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('Connections/condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
 
//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลักและไม่แก้ไขข้อมูล
if($_POST["n_id"]==''){
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'shownews.php'; "; 
echo "</script>";
}
 
//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
	$n_id = $_POST["n_id"];
	$headline = $_POST["headline"];
	$news = $_POST["news"];
	$type = $_POST["type"];
	if(!empty($_FILES['image']['name'])) {
			$filename = md5($_FILES['image']['name'].time());
			$ext = explode('.',$_FILES['image']['name']);
			$path = "n_image/";
			$path_copy = $path.$filename;

			move_uploaded_file($_FILES['image']['tmp_name'],$path_copy);  	
		$sql = "UPDATE news SET " 
			."n_head='$headline', "
			."n_news='$news', "
			."n_type='$type', "
			."n_image='$filename'
			WHERE n_id='$n_id'";
	} else {
		$sql = "UPDATE news SET " 
			."n_head='$headline', "
			."n_news='$news', "
			."n_type='$type'
			WHERE n_id='$n_id'";
	}
#error_reporting(~E_NOTICE );
 
$result = mysqli_query($conn, $sql) or die ("Error in query: $sql " . mysqli_error($conn));
 
mysqli_close($conn);
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('Succesfully updated');";
	echo "window.location = 'shownews.php'; ";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error back to Update again');";
        echo "window.location = 'shownews.php'; ";
	echo "</script>";
}
?>