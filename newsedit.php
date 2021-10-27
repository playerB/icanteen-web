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
	if ($_SESSION["Userlevel"]=="A"){ ?>
<!doctype html>
<html>
<head></head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta charset="utf-8">
<link href="css/bootstrap.css" rel="stylesheet" crossorigin="anonymous">
<style>
</style>
<?php
//1. เชื่อมต่อ database: 
include('Connections/condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//ตรวจสอบถ้าว่างให้เด้งไปหน้าหลัก
if($_GET['n_id']==''){ 
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'shownews.php'; "; 
echo "</script>"; 
}

//รับค่าไอดีที่จะแก้ไข
$n_id = mysqli_real_escape_string($conn,$_GET['n_id']);

//2. query ข้อมูลจากตาราง: 
$sql = "SELECT * FROM news WHERE n_id='$n_id' ";
$result = mysqli_query($conn, $sql) or die ("Error in query: $sql " . mysqli_error());
$row = mysqli_fetch_array($result);
$n_head = $row["n_head"];
$n_news = $row["n_news"];
$n_type = $row["n_type"];
$n_image = $row["n_image"];
extract($row);
?>
	<div id="register" style="position: absolute; top: 20px; left: 20px;">
		<h2>EDIT NEWS</h2><hr/>
		<form action="menuupdate_db.php" method="post" enctype="multipart/form-data">
			<div style="width: 300px; height: 60px;" class="form-group">
				<label for="n_id">ID :</label>
					<input class="form-control" type="text" name="n_id" value="<?php echo $n_id; ?>" readonly/><br /><br />
					<input type="hidden" name="n_id" value="<?php echo $n_id; ?>" />
			</div>
			<div style="width: 300px; height: 80px;" class="form-group">
				<label for="headline">Headline :</label>
					<input type="text" class="form-control" name="headline" id="headline" placeholder="<?php echo $n_head; ?>" value="<?php echo $n_head; ?>" required="required"/><br/><br/>
			</div>
			<div style="width: 300px; height: 60px;" class="form-group">
				<label for="news">News :</label>
					<input type="text" class="form-control" name="news" id="news" placeholder="<?php echo $n_news; ?>" value="<?php echo $n_news; ?>" required="required"/>
			</div>
			<div style="width: 300px; height: 80px;" class="form-group">
				<label for="type">Type :</label>
				<select type="text" class="custom-select" name="type" id="type" required="required">
					<option selected value="P">Promotion</option>
					<option value="N">Other news</option>
					</select>
					<br /><br />
			</div>
			<div style="width: 300px; height: 60px;" class="form-group">
					<input type="file" class="form-control-file" name="image" id="image" /><br/><br/>
			</div>
			<div style="height: 200px;" class="form-group">
				<?php
					echo "<img src=n_image/$n_image "."height='200px'>"
				?>
			</div>
			<div style="width: 300px; height: 20px;" class="form-group">
					<input type="submit" name="Update" id="Update" value="Update" class="btn btn-warning"/>
					<input type="button" value=" Cancel " onclick="window.location='shownews.php' " class="btn btn-outline-secondary"/> 
			</div>
		</form>
	</div>
</html>
<?php } }?>