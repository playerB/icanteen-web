<?php session_start(); error_reporting(~E_NOTICE );
include('Connections/condb.php');

if (!$_SESSION["user_name"]){  //check session
	Header("Location: form_login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า form_login.php 

} else {
	if ($_SESSION["user_role"]!="admin") {
	echo "<script>";
	echo "alert(\"You do not have access to this page\");"; 
	echo "window.history.back()";
	echo "</script>";

	}
	else if ($_SESSION["user_role"]=="admin") { 

        $report_id = mysqli_real_escape_string($conn,$_GET['report_id']);
        $sql = "SELECT * FROM report WHERE report_id='$report_id' " or die("Error:" . mysqli_error()); 
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All report</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="css.css" rel="stylesheet">
</head>
<body>
<?php include("navbar.php"); ?>
    <div class="jumbotron" style="padding-top: 30px;">
		<?php
		echo "<div class='row'>";
		echo "<div class='col-12 col-md-4'>";
		echo "<h1 class='display-5'>" .$row["report_title"] .  "</h1>";
	  	//echo "<img src='report_picture/".$row["report_picture"]." 'class='menu-img'>";
		echo "</div>";
		echo "<div class='col-12 col-md-8'>";
	  	echo "<h2 style='padding-top: 10px;'>เลขที่ " .$row["report_id"] .  "</h2> ";
		echo "<h4 style='padding-top: 10px;'>ประเภท : " .$row["report_type"]. "</h4> ";
		echo "<p style='padding-top: 10px;'>รายละเอียด : " .$row["report_detail"]. "</p> ";
		echo "<div style='padding-top: 20px;'><a class='btn btn-success btn-lg'  href='fixreport.php?report_id=".$row["report_id"]."' role='button'>แก้ไขแล้ว </a></div>";
		echo "</div></div>";
		?>
	  	
	</div>
    

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
<?php } } ?>