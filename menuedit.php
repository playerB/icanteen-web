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
if($_GET['m_id']==''){ 
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'showmenu.php'; "; 
echo "</script>"; 
}

//รับค่าไอดีที่จะแก้ไข
$m_id = mysqli_real_escape_string($conn,$_GET['m_id']);

//2. query ข้อมูลจากตาราง: 
$sql = "SELECT * FROM icanteen_menu WHERE m_id='$m_id' ";
$result = mysqli_query($conn, $sql) or die ("Error in query: $sql " . mysqli_error());
$row = mysqli_fetch_array($result);
$m_name = $row["m_name"];
$m_resname = $row["m_resname"];
$m_price = $row["m_price"];
$m_cate = $row["m_info"];
$m_info = $row["m_info"];
$m_image = $row["m_image"];
extract($row);
?>
	<div id="register" style="position: absolute; top: 20px; left: 20px;">
		<h2>EDIT MENU</h2><hr/>
		<form action="menuupdate_db.php" method="post" enctype="multipart/form-data">
			<div style="width: 300px; height: 60px;" class="form-group">
				<label for="m_id">ID :</label>
					<input class="form-control" type="text" name="m_id" value="<?php echo $m_id; ?>" readonly/><br /><br />
					<input type="hidden" name="m_id" value="<?php echo $m_id; ?>" />
			</div>
			<div style="width: 300px; height: 80px;" class="form-group">
				<label for="menuname">Menu name :</label>
					<input type="text" class="form-control" name="menuname" id="menuname" placeholder="<?php echo $m_name; ?>" value="<?php echo $m_name; ?>" required="required"/><br/><br/>
			</div>
			<div style="width: 300px; height: 80px;" class="form-group">
				<label for="resname">Restaurant :</label>
					<select type="text" class="custom-select" name="resname" id="resname" required="required">
					<option selected value="1.สุชาดา น้ำผลไม้">1.สุชาดา น้ำผลไม้</option>
					<option value="2.ส้ม อาหารชุด">2.ส้ม อาหารชุด</option>
					<option value="3.รุจิศรี เส้นเล็กต้มยำ">3.รุจิศรี เส้นเล็กต้มยำ</option>
					<option value="4.อรวรรณ">4.อรวรรณ</option>
					<option value="5.ข้าวเหนียวอักษร สาขา2">5.ข้าวเหนียวอักษร สาขา2</option>
					<option value="6.รัตน์ จานด่วน">6.รัตน์ จานด่วน</option>
					<option value="7.ลุงเหนอ ก๋วยเตี๋ยวทรงเครื่อง">7.ลุงเหนอ ก๋วยเตี๋ยวทรงเครื่อง</option>
					<option value="8.ข้าวราดแกงป้าหลง">8.ข้าวราดแกงป้าหลง</option>
					<option value="9.ข้าว-มัน-ไก่ น้ากวาง">9.ข้าว-มัน-ไก่ น้ากวาง</option>
					<option value="10.ขนมหวานเย็น">10.ขนมหวานเย็น</option>
					<option value="11.ทูเดย์สเต็ก">11.ทูเดย์สเต็ก</option>
					</select>
					<br /><br />
			</div>
			<div style="width: 300px; height: 60px;">
			<div class="input-group">
				<label for="price">Price :</label>
					<input type="float" class="form-control" name="price" id="price" placeholder="<?php echo $m_price; ?>" value="<?php echo $m_price; ?>" required="required"/>
				<div class="input-group-append">
					<span class="input-group-text">฿</span>
				</div>
			</div>
			</div>
			<div style="width: 300px; height: 80px;" class="form-group">
				<label for="cate">Category :</label>
				<select type="text" class="custom-select" name="cate" id="cate" required="required">
					<option selected value="ข้าว">ข้าว</option>
					<option value="เส้น">เส้น</option>
					<option value="ของทอด">ของทอด</option>
					<option value="ต้ม">ต้ม</option>
					<option value="เสต็ก">เสต็ก</option>
					<option value="เครื่องดื่ม">เครื่องดื่ม</option>
					<option value="ของหวาน">ของหวาน</option>
					<option value="อื่นๆ">อื่นๆ</option>
					</select>
					<br /><br />
			</div>
			<div style="width: 300px; height: 80px;" class="form-group">
				<label for="info">Description :</label>
					<input type="text" class="form-control" name="info" id="info" placeholder="<?php echo $m_info; ?>" value="<?php echo $m_info; ?>" /><br/><br/>
			</div>
			<div style="width: 300px; height: 60px;" class="form-group">
				<!--<label for="image">Picture :</label>-->
					<input type="file" class="form-control-file" name="image" id="image" /><br/><br/>
			</div>
			<div style="height: 200px;" class="form-group">
				<?php
					echo "<img src=m_image/$m_image "."height='200px'>"
				?>
			</div>
			<div style="width: 300px; height: 20px;" class="form-group">
					<input type="submit" name="Update" id="Update" value="Update" class="btn btn-warning"/>
					<input type="button" value=" Cancel " onclick="window.location='showmenu.php' " class="btn btn-outline-secondary"/> 
			</div>
		</form>
	</div>
</html>
<?php } }?>