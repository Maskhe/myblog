<?php 
require_once('conn.php');
if(empty($_GET['aid'])){
	exit();
}
$aid = intval($_GET['aid']);
if(!$aid){
	exit();
}
mysqli_select_db($conn,'sec');
mysqli_query($conn,'set names utf8');
$result = mysqli_query($conn,"select name,content,date from comment where aid=$aid order by date desc limit 0,1");
$row = mysqli_fetch_array($result);
$response = [
	'name'=>$row['name'],
	'content'=>$row['content'],
	'date'=>$row['date']
];
echo json_encode($response);
?>