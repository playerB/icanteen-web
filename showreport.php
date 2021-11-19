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
    <nav class="navbar navbar-expand">
		  <a class="navbar-brand" href="index.php">
			<img src="Materials/homepage/cropped-cu-eng-logo.png" width="130" height="18" class="d-inline-block align-top" alt="">
		  </a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="index.php" style="color: #7f1d17">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="usermenu.php" style="color: #7f1d17">Menu</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="newspage.php" style="color: #7f1d17">News</a>
				</li>
				<?php if($_SESSION["user_role"]=="member") {?>
				<li class="nav-item">
					<a class="nav-link" href="myorder.php" style="color: #7f1d17">Order</a>
				</li>
				<?php } elseif($_SESSION["user_role"]=="admin") {?>
				<li class="nav-item">
					<a class="nav-link" href="showreport.php" style="color: #7f1d17">Report</a>
				</li>
				<?php } elseif($_SESSION["user_role"]=="vendor") {?>
				<li class="nav-item">
					<a class="nav-link" href="restaurantmanage.php" style="color: #7f1d17">Manage</a>
				</li>
				<?php } ?>

				<?php if($_SESSION["Loggedin"]){ ?>

				<li class="nav-item rightaligned">
				<div class="dropdown">
					<button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php print_r($_SESSION["user_name"]); ?>
					</button>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item" href="#">Balance: <?php print_r($_SESSION["user_balance"]); ?> ฿</a>
						<a class="dropdown-item" href="topup.php">Topup</a>
						<a class="dropdown-item" href="userreport.php">Report problem</a>
						<a class="dropdown-item" href="logout.php">Logout</a>
					</div>
				</div>
				</li>
				<?php } else{ ?>
				<li class="nav-item rightaligned">
					<a class="btn btn-danger" href="form_login.php" style="color: white">Login</a>
				</li>
				<?php } ?>
			</ul>
		  </div>
	</nav>
    <div class="container">
		<div class="row">
            <div class="col-md-12">
				<a href="admin_page.php" class="btn btn-primary">Show dashboard overview</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h1>All report</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">User ID</th>
                            <th scope="col">Problem Type</th>
                            <th scope="col">Title</th>
                            <th scope="col">Datetime</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM report";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>".$row["report_id"]."</td>";
                                    echo "<td>".$row["user_id"]."</td>";
                                    echo "<td>".$row["report_type"]."</td>";
                                    echo "<td>".$row["report_title"]."</td>";
                                    echo "<td>".$row["report_timestamp"]."</td>";
                                    echo "<td>".$row["report_status"]."</td>";
									echo "<td><a href='selectreport.php?report_id=".$row["report_id"]."' class='btn btn-warning btn-sm'>check</a></td> ";
                                    echo "</tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
<?php } } ?>