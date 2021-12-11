<?php session_start(); error_reporting(~E_NOTICE );

include('Connections/condb.php');

$query = "SELECT * FROM news ORDER BY news_id ASC" or die("Error:" . mysqli_error()); 

$result = mysqli_query($conn, $query);


?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>I-CANTEEN</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
	<link href="css.css" rel="stylesheet">
</head>

<body>
<?php include("navbar.php"); ?>
	<div class="container-fluid row">
		<div class="container-fluid d-block" style="font-size: 2rem">
			News
			<?php
			if ($_SESSION["user_role"]=="admin") {
				echo "<a href='insertnews.php' class='btn btn-primary'> + Add news</a>";
			}
			?>
		</div>
		<?php
		while($row = mysqli_fetch_array($result)) { ?>
			<div class="col-12 col-md-6">
				<div class="card card-hz mb-3">
				<div class="row no-gutters">
					<div class="col-5">
						<img src="news_picture/<?php echo $row['news_picture']; ?>" class="card-img" alt="">
					</div>
					<div class="col-7">
					<div class="card-body card-body-hz">
						<h5 class="card-title"><?php echo $row['news_headline']; ?></h5>
						<div class="card-text"><?php echo $row['news_content']; ?></div>
						<?php 
						echo '<a href="selectnews.php?news_id='.$row['news_id'].'" class="btn btn-primary">อ่านต่อ</a>';
						?>
					</div>
					</div>
				</div>
				</div>
			</div>
			
		<?php } ?>
	</div>
	<footer style="background-color: #cccccc">
			<div class="container">
				<p id = "btext"><br>
					คณะวิศวกรรมศาสตร์<br> 
					จุฬาลงกรณ์มหาวิทยาลัย<br>
					ถนนพญาไท เเขวงวังใหม่<br>
					เขตปทุมวัน กรุงเทพฯ 10400<br>
					info@eng.chula.ac.th<br>
					+66-2-218-6337<br>
					&nbsp;
				</p>
			</div>
    </footer>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>