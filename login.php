<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="gbk">
	<title>让我进去...</title>
	<link rel="stylesheet" href="css/login.css">
</head>
<body>
<?php
if(isset($_POST['submit']))
{
	if(!get_magic_quotes_gpc())
	{
		$name = addslashes($_POST["name"]);
		$passwd = addslashes($_POST["passwd"]);
	}
	$host = 'localhost';
	$user = 'root';
	$password = '';
	$database = 'sec';
	$sql = "select name,passwd from user where name='$name' and passwd='$passwd'";
	//echo $sql;
	$conn = mysqli_connect($host,$user,$password,$database);
	if(!$conn){
		exit("连接数据库错误");
	}else{
		mysqli_query($conn,'set names utf8');
		$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$row = mysqli_fetch_assoc($result);
		if (is_null($row)){
?>
<script>
	alert("用户名或者密码错误");
</script>
<?php
		}else{
			$_SESSION['name'] = $_POST['name'];
			header('location:admin.php');
		}
	}
}
?>
	<div class="box">
		<form action="" method="post">
			<span>用户名：</span>
			<input type="text" name="name">
			<br>
			<span>密&nbsp;&nbsp;&nbsp;&nbsp;码：</span>
			<input type="password" name="passwd">
			<br>
			<input type="submit" name="submit" value="登录">
		</form>
	</div>
</body>
</html>
