<?php 
$host = "localhost";
$user = 'root';
$pass = '';
$conn = mysqli_connect($host,$user,$pass);
if (!$conn){
	die("Something goes wrong:".mysqli_connect_error());
}
?>