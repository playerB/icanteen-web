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
<head>
	<meta charset="UTF-8">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<title>Admin page</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="container-fluid" style="display: inline;">
	Logged in as : <?php print_r($_SESSION["User"]);?> <a class='btn btn-danger' href='logout.php' role='button'>Log out</a><br/>
	</div>
	<div class="container-fluid" style="display: inline;">
	Admin options
	<a class='btn btn-primary' href='insertmenu.php' role='button'>+Menu</a>
	<a class='btn btn-primary' href='insertnews.php' role='button'>+News</a>
	<a class='btn btn-outline-primary' href='showmenu.php' role='button'>Show all menu</a>
	<a class='btn btn-outline-primary' href='shownews.php' role='button'>Show all news</a>
	</div>

</body>
</html>
<?php } }?>