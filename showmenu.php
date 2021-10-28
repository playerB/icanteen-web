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

$query = "SELECT * FROM menu ORDER BY menu_id asc" or die("Error:" . mysqli_error()); 
$result = mysqli_query($conn, $query); 

?>
<div class="container-fluid" style="display: inline;">
	Logged in as : <?php print_r($_SESSION["user_name"]);?> <a class='btn btn-danger' href='logout.php' role='button'>Log out</a> <a class='btn btn-primary' href='insertmenu.php' role='button'>+Menu</a>
</div>
<div class='table-responsive'>
<table class='table table-striped table-hover'>

<thead class='thead-dark' align='center' bgcolor='#CCCCCC'><tr><th scope='col'>Menu ID</th><th scope='col'>Name</th><th scope='col'>Restaurant</th><th scope='col'>Price</th><th scope='col'>Category</th><th scope='col'>Description</th><th scope='col'>Picture</th><th scope='col'>Edit menu</th><th scope='col'>Delete menu</th></tr></thead>
<?php
while($row = mysqli_fetch_array($result)) { 
  echo "<tbody>";
  echo "<th scope='row'>" .$row["menu_id"] .  "</th> "; 
  echo "<td align='center'>" .$row["menu_name"] .  "</td> ";
  echo "<td align='center'>" .$row["restaurant_id"] .  "</td> ";
  echo "<td align='center'>" .$row["menu_price"] .  "</td> ";
  echo "<td align='center'>" .$row["menu_category"] .  "</td> ";
  echo "<td align='center'>" .$row["menu_detail"] .  "</td> ";
  echo "<td align='center'>" ."<img src='menu_picture/".$row["menu_picture"]." 'width='150'>". "</td>";
  //แก้ไขข้อมูล
  echo "<td align='center'><a href='menuedit.php?menu_id=$row[0]' class='btn btn-outline-warning btn-sm'>edit</a></td> ";
  
  //ลบข้อมูล
  echo "<td align='center'><a href='menudelete.php?menu_id=$row[0]' class='btn btn-outline-danger btn-sm' onclick=\"return confirm('Do you want to delete this record?')\">delete</a></td> ";
  echo "</tbody>";
}?>
</table>
</div>

<?php mysqli_close($conn);?>
</html>
<?php } }?>