<?php session_start();?>
<?php 

if (!$_SESSION["UserID"]){  //check session
		Header("Location: form_login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า login form 

}else{
	if ($_SESSION["Userlevel"]=="M"){  //ถ้าเป็น member ให้กลับ
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
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<style>
</style>
<?php
		
include('Connections/condb.php');

$query = "SELECT * FROM news ORDER BY n_id asc" or die("Error:" . mysqli_error()); 
$result = mysqli_query($conn, $query); 

?>
<div class="container-fluid" style="display: inline;">
	Logged in as : <?php print_r($_SESSION["User"]);?> <a class='btn btn-danger' href='logout.php' role='button'>Log out</a> <a class='btn btn-primary' href='insertnews.php' role='button'>+News</a>
</div>
<div class='table-responsive'>
<table class='table table-striped table-hover'>

<thead class='thead-dark' align='center' bgcolor='#CCCCCC'><tr><th scope='col'>News ID</th><th scope='col'>Headline</th><th scope='col'>Date published</th><th scope='col'>News</th><th scope='col'>Type</th><th scope='col'>Picture</th></tr></thead>
<?php
while($row = mysqli_fetch_array($result)) { 
  echo "<tbody>";
  echo "<th scope='row'>" .$row["n_id"] .  "</th> "; 
  echo "<td align='center'>" .$row["n_head"] .  "</td> ";
  echo "<td align='center'>" .$row["n_date"] .  "</td> ";
  echo "<td align='center'>" .$row["n_news"] .  "</td> ";
  echo "<td align='center'>" .$row["n_type"] .  "</td> ";
  echo "<td align='center'>" ."<img src='n_image/".$row["n_image"]." 'width='150'>". "</td>";
  
  echo "</tbody>";
}?>
</table>
</div>

<?php mysqli_close($conn);?>
</html>
<?php } }?>