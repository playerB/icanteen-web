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
           
?>
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
if($_GET['menu_id']==''){ 
echo "<script type='text/javascript'>"; 
echo "alert('Error Contact Admin !!');"; 
echo "window.location = 'showmenu.php'; "; 
echo "</script>"; 
}

//รับค่าไอดีที่จะแก้ไข
$menu_id = mysqli_real_escape_string($conn,$_GET['menu_id']);

//2. query ข้อมูลจากตาราง: 
$sql = "SELECT * FROM menu WHERE menu_id='$menu_id' ";
$result = mysqli_query($conn, $sql) or die ("Error in query: $sql " . mysqli_error());
$row = mysqli_fetch_array($result);
$menu_name = $row["menu_name"];
$restaurant_id = $row["restaurant_id"];
$menu_price = $row["menu_price"];
$menu_category = $row["menu_category"];
$menu_detail = $row["menu_detail"];
$menu_picture = $row["menu_picture"];
extract($row);
?>
	<div id="register" style="position: absolute; top: 20px; left: 20px;">
		<h2>EDIT MENU</h2><hr/>
		<form action="menuupdate_db.php" method="post" enctype="multipart/form-data">
			<div style="width: 300px; height: 60px;" class="form-group">
				<label for="menu_id">ID :</label>
					<input class="form-control" type="text" name="menu_id" value="<?php echo $menu_id; ?>" readonly/><br /><br />
					<input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>" />
			</div>
			<div style="width: 300px; height: 80px;" class="form-group">
				<label for="menu_name">Menu name :</label>
					<input type="text" class="form-control" name="menu_name" id="menu_name" placeholder="<?php echo $menu_name; ?>" value="<?php echo $menu_name; ?>" required="required"/><br/><br/>
			</div>
			<div style="width: 300px; height: 80px;" class="form-group">
				<label for="restaurant_id">Restaurant :</label>
					<select type="text" class="custom-select" name="restaurant_id" id="restaurant_id" required="required">
					<option selected value="<?php echo $restaurant_id; ?>"><?php echo $restaurant_id; ?></option>
					<option value="1">1.สุชาดา น้ำผลไม้</option>
					<option value="2">2.ส้ม อาหารชุด</option>
					<option value="3">3.รุจิศรี เส้นเล็กต้มยำ</option>
					<option value="4">4.อรวรรณ</option>
					<option value="5">5.ข้าวเหนียวอักษร สาขา2</option>
					<option value="6">6.รัตน์ จานด่วน</option>
					<option value="7">7.ลุงเหนอ ก๋วยเตี๋ยวทรงเครื่อง</option>
					<option value="8">8.ข้าวราดแกงป้าหลง</option>
					<option value="9">9.ข้าว-มัน-ไก่ น้ากวาง</option>
					<option value="10">10.ขนมหวานเย็น</option>
					<option value="11">11.ทูเดย์สเต็ก</option>
					</select>
					<br /><br />
			</div>
			<div style="width: 300px; height: 60px;">
			<div class="input-group">
				<label for="menu_price">Price :</label>
					<input type="float" class="form-control" name="menu_price" id="menu_price" placeholder="<?php echo $menu_price; ?>" value="<?php echo $menu_price; ?>" required="required"/>
				<div class="input-group-append">
					<span class="input-group-text">฿</span>
				</div>
			</div>
			</div>
			<div style="width: 300px; height: 80px;" class="form-group">
				<label for="menu_category">Category :</label>
				<select type="text" class="custom-select" name="menu_category" id="menu_category" required="required">
					<option selected value="<?php echo $menu_category; ?>"><?php echo $menu_category; ?></option>
					<option value="ข้าว">ข้าว</option>
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
				<label for="menu_detail">Description :</label>
					<input type="text" class="form-control" name="menu_detail" id="menu_detail" placeholder="<?php echo $menu_detail; ?>" value="<?php echo $menu_detail; ?>" /><br/><br/>
			</div>
			<div style="width: 300px; height: 60px;" class="form-group">
				<!--<label for="menu_picture">Picture :</label>-->
					<input type="file" class="form-control-file" name="menu_picture" id="menu_picture" /><br/><br/>
			</div>
			<div style="height: 200px;" class="form-group">
				<?php
					echo "<img src=menu_picture/$menu_picture "."height='200px'>"
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