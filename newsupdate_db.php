<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('Connections/condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
 
//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลักและไม่แก้ไขข้อมูล
if($_POST["news_id"]==''){
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'shownews.php'; "; 
echo "</script>";
}
 
//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
	$news_id = $_POST["news_id"];
	$news_headline = $_POST["news_headline"];
	$news_content = $_POST["news_content"];
	if(!empty($_FILES['news_picture']['name'])) {
			$filename = md5($_FILES['news_picture']['name'].time());
			$ext = explode('.',$_FILES['news_picture']['name']);
			$path = "news_picture/";
			$path_copy = $path.$filename;

			move_uploaded_file($_FILES['news_picture']['tmp_name'],$path_copy);  	
		$sql = "UPDATE news SET 
			news_headline='$news_headline', 
			news_content='$news_content',
			news_picture='$filename'
			WHERE news_id=$news_id";
	} else {
		$sql = "UPDATE news SET 
			news_headline='$news_headline', 
			news_content='$news_content', 
			WHERE news_id=$news_id";
	}
#error_reporting(~E_NOTICE );
 
$result = mysqli_query($conn, $sql) or die ("Error in query: $sql " . mysqli_error($conn));
 
mysqli_close($conn);
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('Succesfully updated');";
	echo "window.location = 'newspage.php'; ";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error back to Update again');";
    echo "window.location = 'newspage.php'; ";
	echo "</script>";
}
?>