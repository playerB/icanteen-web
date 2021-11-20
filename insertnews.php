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
		$path = "news_picture/";
		$path_copy = $path.$filename;
		
		move_uploaded_file($_FILES['image']['tmp_name'],$path_copy);  	
	}
	
	$news_headline = mysqli_real_escape_string($conn, $_POST['news_headline']);
	$news_content = mysqli_real_escape_string($conn, $_POST['news_content']);

	$sql = "INSERT INTO news (news_headline, news_content, news_picture)
	VALUES ('$news_headline','$news_content','$filename')";

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
			<h2>I-CANTEEN NEWS</h2>
				<hr/>
		<form action="" method="post" enctype="multipart/form-data">
			<div style="width: 300px; height: 80px;" class="form-group">
				<label for="news_headline">News headline :</label>
					<input type="text" class="form-control" name="news_headline" id="news_headline" required="required" /><br /><br />
			</div>
			<div style="width: 300px; height: 60px;" class="form-group">
				<label for="news_content">News content :</label>
					<input type="text" class="form-control" name="news_content" id="news_content"  required="required"/><br /><br />
			</div>
			<div style="width: 300px; height: 20px;" class="form-group">
				<label for="image">Picture :</label>
					<input type="file" class="form-control-file" name="image" id="image"/><br/><br />
					<input type="submit" value=" Submit " name="submitbtn" class="btn btn-success"/>
				 	<a class='btn btn-outline-primary' href='newspage.php' role='button'>Show all news</a>
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