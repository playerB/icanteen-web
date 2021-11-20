<?php session_start();?>
<?php 

if (!$_SESSION["user_name"]){  //check session
	Header("Location: form_login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า form_login.php 

}else{
if ($_SESSION["user_role"]!="admin"){
	echo "<script>";
	echo "alert(\"You do not have access to this page\");"; 
	echo "window.history.back()";
	echo "</script>";

}
if ($_SESSION["user_role"]=="admin"){ ?>
<!doctype html>
<html>
<head></head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta charset="utf-8">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<link href="css.css" rel="stylesheet">
<?php
//1. เชื่อมต่อ database: 
include('Connections/condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลัก
if($_GET['news_id']==''){ 
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'newspage.php'; "; 
echo "</script>"; 
}

//รับค่าไอดีที่จะแก้ไข
$news_id = mysqli_real_escape_string($conn,$_GET['news_id']);

//2. query ข้อมูลจากตาราง: 
$sql = "SELECT * FROM news WHERE news_id=$news_id ";
$result = mysqli_query($conn, $sql) or die ("Error in query: $sql " . mysqli_error());
$row = mysqli_fetch_array($result);
$news_headline = $row["news_headline"];
$news_content = $row["news_content"];
$news_picture = $row["news_picture"];
extract($row);
?>
	<div id="register" style="position: absolute; top: 20px; left: 20px;">
		<h2>EDIT NEWS</h2><hr/>
		<form action="newsupdate_db.php" method="post" enctype="multipart/form-data">
			<div style="width: 300px; height: 60px;" class="form-group">
				<label for="news_id">ID :</label>
					<input class="form-control" type="text" name="news_id" value="<?php echo $news_id; ?>" readonly/><br /><br />
					<input type="hidden" name="news_id" value="<?php echo $news_id; ?>" />
			</div>
			<div style="width: 300px; height: 80px;" class="form-group">
				<label for="news_headline">Headline :</label>
					<input type="text" class="form-control" name="news_headline" id="news_headline" placeholder="<?php echo $news_headline; ?>" value="<?php echo $news_headline; ?>" required="required"/><br/><br/>
			</div>
			<div style="width: 300px; " class="form-group">
				<label for="news_content">News content:</label>
					<textarea class="form-control" name="news_content" id="news_content" rows="5" placeholder="<?php echo $news_content; ?>" value="<?php echo $news_content; ?>" required="required"> </textarea>
			</div>
			<div style="width: 300px; height: 60px;" class="form-group">
					<input type="file" class="form-control-file" name="news_picture" id="news_picture" /><br/><br/>
			</div>
			<div style="height: 200px;" class="form-group">
				<?php
					echo "<img src=news_picture/$news_picture height='200px'>"
				?>
			</div>
			<div style="width: 300px; height: 20px;" class="form-group">
					<input type="submit" name="Update" id="Update" value="Update" class="btn btn-warning"/>
					<input type="button" value=" Cancel " onclick="window.location='newspage.php' " class="btn btn-outline-secondary"/> 
			</div>
		</form>
	</div>
</html>
<?php } }?>