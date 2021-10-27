<?php
session_start();
$_SESSION["Loggedin"] = false;
session_destroy();
header("Location: index.php ");	
?>