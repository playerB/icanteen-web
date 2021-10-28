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
<style>
</style>
<?php
		
include('Connections/condb.php');

$query = "SELECT * FROM news ORDER BY news_id asc" or die("Error:" . mysqli_error()); 
$result = mysqli_query($conn, $query); 

?>
<div class="container-fluid" style="display: inline;">
	Logged in as : <?php print_r($_SESSION["user_name"]);?> <a class='btn btn-danger' href='logout.php' role='button'>Log out</a> <a class='btn btn-primary' href='insertnews.php' role='button'>+News</a>
</div>
<div class='table-responsive'>
<table class='table table-striped table-hover'>

<thead class='thead-dark' align='center' bgcolor='#CCCCCC'><tr><th scope='col'>News ID</th><th scope='col'>Headline</th><th scope='col'>Date published</th><th scope='col'>News</th><th scope='col'>Type</th><th scope='col'>Picture</th></tr></thead>
<?php
while($row = mysqli_fetch_array($result)) { 
  echo "<tbody>";
  echo "<th scope='row'>" .$row["news_id"] .  "</th> "; 
  echo "<td align='center'>" .$row["news_headline"] .  "</td> ";
  echo "<td align='center'>" .$row["news_content"] .  "</td> ";
  echo "<td align='center'>" .$row["news_timestamp"] .  "</td> ";
  echo "<td align='center'>" ."<img src='news_picture/".$row["news_picture"]." 'width='150'>". "</td>";
  
  echo "</tbody>";
}?>
</table>
</div>

<?php mysqli_close($conn);?>
</html>
<?php } }?>