<?php session_start(); error_reporting(~E_NOTICE );
include('Connections/condb.php');
if(isset($_POST['submit'])){
	
	$report_title = mysqli_real_escape_string($conn, $_POST['report_title']);
	$report_detail = mysqli_real_escape_string($conn, $_POST['report_detail']);
	$report_type = mysqli_real_escape_string($conn, $_POST['report_type']);

	$sql = "INSERT INTO report (report_title, report_detail, report_type)
	VALUES ('$report_title','$report_detail','$report_type')";

	if ($conn->query($sql) === TRUE) {
	}
	else {
	echo "<script type= 'text/javascript'>alert('Error: " . $sql . "<br>" . $conn->error."');</script>";
	}
    mysqli_close($conn);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a report</title>
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
                <h1>Submit a report</h1>
            </div>
        </div>
        <div class="form-group">
            <form action="userreport.php" method="post">
                <div class="row">
                    <div class="col-md-3">
                        <select type="text" class="custom-select" name="report_type" id="report_type" required="required">
                            <option selected value="Other">Category</option>
                            <option value="Food">Food</option>
                            <option value="Service">Service</option>
                            <option value="Payment">Payment</option>
                            <option value="Website">Website</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-9">
                        <label for="report_title">Title</label>
                        <input type="text" class="form-control" name="report_title" id="report_title" placeholder="<?php echo $menu_name; ?>" value="<?php echo $menu_name; ?>" required="required"/><br/><br/>
                
                        <label for="report_detail">Description</label>
                        <textarea class="form-control" id="report_detail" rows="3" name="report_detail"></textarea>
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>