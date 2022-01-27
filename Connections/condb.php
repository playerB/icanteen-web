<?php

$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "icanteen";

// Create connection
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
mysqli_query($conn, "SET NAMES 'utf8' ");

?>