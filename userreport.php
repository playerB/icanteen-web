<?php session_start(); error_reporting(~E_NOTICE );
include('Connections/condb.php');
if(isset($_POST['submit'])){
	
    $user_id = $_SESSION["user_id"];
	$report_title = mysqli_real_escape_string($conn, $_POST['report_title']);
	$report_detail = mysqli_real_escape_string($conn, $_POST['report_detail']);
	$report_type = mysqli_real_escape_string($conn, $_POST['report_type']);

	$sql = "INSERT INTO report (user_id, report_title, report_detail, report_type, report_status)
	VALUES ('$user_id', '$report_title','$report_detail','$report_type', 'ยังไม่แก้ไข')";

	if ($conn->query($sql) === TRUE) {
        echo "<script type= 'text/javascript'>alert('Report recieved! We are sorry for your in convenience');</script>";
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
<?php include("navbar.php"); ?>
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