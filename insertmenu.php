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
if ($_SESSION["user_role"]=="admin"){

include('Connections/condb.php');

error_reporting(~E_NOTICE );
if(isset($_POST['submitbtn'])){
	
	if(!empty($_FILES['image']['name'])) {
		$filename = md5($_FILES['image']['name'].time());
		$ext = explode('.',$_FILES['image']['name']);
		$path = "m_image/";
		$path_copy = $path.$filename;
		
		move_uploaded_file($_FILES['image']['tmp_name'],$path_copy);  	
	}
	
	$menuname = mysqli_real_escape_string($conn, $_POST['menuname']);
	$resname = mysqli_real_escape_string($conn, $_POST['resname']);
	$price = mysqli_real_escape_string($conn, $_POST['price']);
	$cate = mysqli_real_escape_string($conn, $_POST['cate']);
	$info = mysqli_real_escape_string($conn, $_POST['info']);

	$sql = "INSERT INTO icanteen_menu (m_name, m_resname, m_price, m_cate, m_info, m_image)
	VALUES ('$menuname','$resname','$price','$cate','$info','$filename')";

	if ($conn->query($sql) === TRUE) {
	}
	else {
	echo "<script type= 'text/javascript'>alert('Error: " . $sql . "<br>" . $conn->error."');</script>";
	}
mysqli_close($conn);
}
?>

<html>
	<head>
	</head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta charset="utf-8">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
	<link href="css.css" rel="stylesheet">
	<body>
		<div id="register" style="position: absolute; top: 20px; left: 20px;">
			<h2>I-CANTEEN MENU REGISTRATION</h2>
				<hr/>
		<form action="" method="post" enctype="multipart/form-data">
			<div style="width: 300px; height: 80px;" class="form-group">
				<label for="menuname">Menu name :</label>
					<input type="text" class="form-control" name="menuname" id="menuname" required="required" /><br /><br />
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
					<input type="float" class="form-control" name="price" id="price"  required="required"/>
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
			<div style="width: 300px; height: 60px;" class="form-group">
				<label for="info">Description :</label>
					<input type="text" class="form-control" name="info" id="info" /><br/><br/>
			</div>
			<div style="width: 300px; height: 20px;" class="form-group">
				<label for="image">Picture :</label>
					<input type="file" class="form-control-file" name="image" id="image"/><br/><br />
					<input type="submit" value=" Submit " name="submitbtn" class="btn btn-success"/>
				 	<a class='btn btn-outline-primary' href='showmenu.php' role='button'>Show all menu</a>
				  	<a class='btn btn-outline-primary' href='index.php' role='button'>Main</a>
			</div>
		  </form>
			<script>
					if ( window.history.replaceState ) {
						window.history.replaceState( null, null, window.location.href );
					}
			</script>
		</div>
	</body>
</html>
<?php } } ?>