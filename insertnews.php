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
	if ($_SESSION["Userlevel"]=="A"){

include('Connections/condb.php');

error_reporting(~E_NOTICE );
if(isset($_POST['submitbtn'])){
	
	if(!empty($_FILES['image']['name'])) {
		$filename = md5($_FILES['image']['name'].time());
		$ext = explode('.',$_FILES['image']['name']);
		$path = "n_image/";
		$path_copy = $path.$filename;
		
		move_uploaded_file($_FILES['image']['tmp_name'],$path_copy);  	
	}
	
	$headline = mysqli_real_escape_string($conn, $_POST['headline']);
	$news = mysqli_real_escape_string($conn, $_POST['news']);
	$type = mysqli_real_escape_string($conn, $_POST['type']);

	$sql = "INSERT INTO news (n_head, n_news, n_type, n_image)
	VALUES ('$headline','$news','$type','$filename')";

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
	<link href="css/bootstrap.css" rel="stylesheet" crossorigin="anonymous">
	<style>
	</style>
	<body>
		<div id="register" style="position: absolute; top: 20px; left: 20px;">
			<h2>I-CANTEEN NEWS</h2>
				<hr/>
		<form action="" method="post" enctype="multipart/form-data">
			<div style="width: 300px; height: 80px;" class="form-group">
				<label for="headline">News headline :</label>
					<input type="text" class="form-control" name="headline" id="headline" required="required" /><br /><br />
			</div>
			<div style="width: 300px; height: 60px;" class="form-group">
				<label for="news">News :</label>
					<input type="text" class="form-control" name="news" id="news"  required="required"/><br /><br />
			</div>
			<div style="width: 300px; height: 80px;" class="form-group">
				<label for="type">Type :</label>
					<select type="text" class="custom-select" name="type" id="type" required="required">
					<option selected value="P">Promotion</option>
					<option value="N">Other news</option>
					</select>
					<br /><br />
			</div>
			<div style="width: 300px; height: 20px;" class="form-group">
				<label for="image">Picture :</label>
					<input type="file" class="form-control-file" name="image" id="image"/><br/><br />
					<input type="submit" value=" Submit " name="submitbtn" class="btn btn-success"/>
				 	<a class='btn btn-outline-primary' href='shownews.php' role='button'>Show all news</a>
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