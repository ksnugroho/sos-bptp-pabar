<?php
$host = "localhost";
$username = "u5471254_sos";
$password = "sos2020";
$database = "u5471254_sos";
$con = mysqli_connect($host,$username,$password,$database);
if (!$con) {
	echo "<script>alert('DB connection Fails')</script>";
	exit();
}

date_default_timezone_set('Asia/Jakarta'); //WIB
// date_default_timezone_set('Asia/Ujung_Pandang'); //WITA
// date_default_timezone_set('Asia/Jayapura'); //WIT
?>