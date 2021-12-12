<?php session_start(); error_reporting(~E_NOTICE );
		
include('Connections/condb.php');

$query = "SELECT * FROM restaurant ORDER BY restaurant_id ASC" or die("Error:" . mysqli_error()); 
$result= mysqli_query($conn, $query);
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>I-CANTEEN</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="css.css" rel="stylesheet">
	<style>
		@import url('https://fonts.googleapis.com/css?family=Mitr&display=swap');
		body {
			font-family: 'Mitr', serif;
			font-size: '20pt';
			background-color: #dddddd;
		}
		.scrolling-wrapper {
		  overflow-x: scroll;
		  overflow-y: hidden;
		  white-space: nowrap;
		}
		.scrolling-wrapper::-webkit-scrollbar {
		  display: none;
		}

		.scrolling-wrapper::-webkit-scrollbar-track {
		  width: 8px;
		  background: #bbbbbb; 
		  border-radius: 10px;
		}

		.scrolling-wrapper::-webkit-scrollbar-thumb {
		  background: #999999; 
		  border-radius: 10px;
		}

		.scrolling-wrapper::-webkit-scrollbar-thumb:hover {
		  background: #777777; 
		}
		.card-box {
		  width: 8rem;
		  height: 10.2rem;
		  display: inline-block;
		}
		.card-img-box {
			width: 7.85rem;
			height: 8rem;
			object-fit: cover;
		}
		.card-title {
			height: 1.5rem;
			font-size: 0.8rem;
			margin-top: -0.8rem;
			overflow: hidden;
		}
		@media (min-width: 576px) {
			.card-box {
			  width: 15rem;
			  height: 17.5rem;
			  display: inline-block;
			}
			.card-img-box {
			  width: 14.9rem;
			  height: 15rem;
			  object-fit: cover;
			}
			.scrolling-wrapper::-webkit-scrollbar {
			  display: block;
			  height: 8px;
			}
			.card-title {
			height: 1.5rem;
			font-size: 1.1rem;
			margin-top: -0.8rem;
			overflow: hidden;
			}
		}
		.price-badge {
			position: absolute;
			right: 10px;
			top: 10px;
			background: #7f1d17;
			text-align: center;
			border-radius: 50px;
			color: white;
			padding: 3px 7px;
			font-size: 14px;
		}
		.recommended-badge {
			position: absolute;
			left: 10px;
			top: 10px;
			background: #2ecc71;
			text-align: center;
			border-radius: 50px;
			color: white;
			padding: 3px 7px;
			font-size: 14px;
		}
		
    </style>
</head>
<body>
<?php include("navbar.php"); ?>
	<div class="container-fluid">
		<?php 
		while($row = mysqli_fetch_array($result)) {
			$restaurant_id = $row["restaurant_id"];
			$restaurant_name = $row['restaurant_name'];
			echo "<label style='font-size: 1.5rem'>".$restaurant_id.". ".$restaurant_name."</label>";
			echo "<div class='scrolling-wrapper'>";
			$sql2 = "SELECT * FROM menu WHERE restaurant_id = '$restaurant_id'";
			$menuresult = mysqli_query($conn, $sql2);
			
			while($menurow = mysqli_fetch_array($menuresult)) {
				$sql3 = "SELECT SUM(order_amount) FROM orderhistory WHERE menu_id = $menurow[0] AND orderhistory.finish_timestamp >= DATE(NOW()) - INTERVAL 30 DAY";
				$ispopular= mysqli_fetch_array(mysqli_query($conn, $sql3));
				echo "<div class='card card-box mr-2 mb-2'>";
					echo "<a href='selectmenu.php?menu_id=$menurow[0]'>";
					echo "<img src='menu_picture/".$menurow["menu_picture"]."' class='card-img card-img-box' alt=''>";
					if ($ispopular[0] >= 5) {
						echo "<span class='recommended-badge'>Recommended!</span>";
					}
					echo "<span class='price-badge'>".$menurow["menu_price"].".-</span>";
					echo "</a>";
					echo "<div class='card-body'>";
					echo "<p class='card-title'>".$menurow["menu_name"]."</p>";
					echo "</div>";
				echo "</div>";
				}
			echo "</div>" ;
		}?>
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