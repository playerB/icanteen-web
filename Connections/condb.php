<?php

$dbservername = "127.0.0.1"; //localhost
$dbusername = "friday2";
$dbpassword = "fd2";
$dbname = "friday2";

// Create connection
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
mysqli_query($conn, "SET NAMES 'utf8' ");

?>