<?php session_start(); error_reporting(~E_NOTICE );

    if (!$_SESSION["user_name"]){  //check session
        Header("Location: form_login.php"); //ไม่พบผู้ใช้กระโดดกลับไปหน้า form_login.php 

    } else {
        if ($_SESSION["user_role"]!="vendor") {
            echo "<script>";
            echo "alert(\"You do not have access to this page\");"; 
            echo "window.history.back()";
            echo "</script>";

        } else if ($_SESSION["user_role"]=="vendor") { 
            include('Connections/condb.php');

            $owner_id = $_SESSION["user_id"];
            $query = "SELECT * FROM menu, restaurant WHERE menu.restaurant_id = restaurant.restaurant_id AND restaurant.owner_id=$owner_id ORDER BY menu_id ASC" or die("Error:" . mysqli_error()); 
            $result = mysqli_query($conn, $query); 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant manage</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
	<link href="css.css" rel="stylesheet">
</head>
<body>
<?php include("navbar.php"); ?>
    <a class='btn btn-primary' href='insertmenu.php' role='button'>+ Add new menu</a>
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
            echo "<td align='center'><a href='menuedit.php?menu_id=$row[0]' class='btn btn-warning btn-sm'>edit</a></td> ";
            
            //ลบข้อมูล
            echo "<td align='center'><a href='menudelete.php?menu_id=$row[0]' class='btn btn-danger btn-sm' onclick=\"return confirm('Do you want to delete this record?')\">delete</a></td> ";
            echo "</tbody>";
            }?>
        </table>
    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
<?php } } ?>