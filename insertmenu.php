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
           
			if(isset($_POST['submitbtn'])){
				
				if(!empty($_FILES['image']['name'])) {
					$filename = md5($_FILES['image']['name'].time());
					$ext = explode('.',$_FILES['image']['name']);
					$path = "menu_picture/";
					$path_copy = $path.$filename;
					
					move_uploaded_file($_FILES['image']['tmp_name'],$path_copy);  	
				}
				
				$menu_name = mysqli_real_escape_string($conn, $_POST['menu_name']);
				$restaurant_id = mysqli_fetch_array(mysqli_query($conn, "SELECT restaurant_id FROM restaurant WHERE owner_id = '".$_SESSION['user_id']."'"))['restaurant_id'];
				$menu_price = mysqli_real_escape_string($conn, $_POST['menu_price']);
				$menu_category = mysqli_real_escape_string($conn, $_POST['menu_category']);
				$menu_detail = mysqli_real_escape_string($conn, $_POST['menu_detail']);

				$sql = "INSERT INTO menu (menu_name, restaurant_id, menu_price, menu_category, menu_detail, menu_picture)
				VALUES ('$menu_name','$restaurant_id','$menu_price','$menu_category','$menu_detail','$filename')";

				if ($conn->query($sql) === TRUE) {
				} else {
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
				<label for="menu_name">Menu name :</label>
					<input type="text" class="form-control" name="menu_name" id="menu_name" required="required" /><br /><br />
			</div>
			<div style="width: 300px; height: 60px;">
			<div class="input-group">
				<label for="menu_price">Price :</label>
					<input type="float" class="form-control" name="menu_price" id="menu_price"  required="required"/>
				<div class="input-group-append">
					<span class="input-group-text">฿</span>
				</div>
			</div>
			</div>
			<div style="width: 300px; height: 80px;" class="form-group">
				<label for="menu_category">Category :</label>
					<select type="text" class="custom-select" name="menu_category" id="menu_category" required="required">
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
				<label for="menu_detail">Description :</label>
					<input type="text" class="form-control" name="menu_detail" id="menu_detail" /><br/><br/>
			</div>
			<div style="width: 300px; height: 20px;" class="form-group">
				<label for="menu_picture">Picture :</label>
					<input type="file" class="form-control-file" name="menu_picture" id="menu_picture"/><br/><br />
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