<?php 
require_once 'conn.php';
session_start();
//文件过滤函数
function filterFile($file,$upload_dir){
	$allowExts = array("jpg","jpeg","gif","png");
	$allowTypes = array("image/gif","image/jpg","image/jpeg","image/png","image/pjpeg","image/png");
	$temp = explode('.', $file['name']);
	$ext = end($temp);	
	if(in_array($file['type'],$allowTypes) && $file['size'] < 512000 && in_array($ext, $allowExts)){
		if($file['error'] > 0){
			return 2;//系统错误
		}
		$rand = md5(uniqid(microtime(true)));
		if(file_exists("${upload_dir}${rand}.$ext")){
			return 3;//文件已存在
		}else{
			return "${upload_dir}${rand}.$ext";//文件合法
		}
	}else{
		return 1;//文件类型不允许或太大
	}	
}

if(!isset($_POST['publish'])||($_SESSION['token'] != $_POST['token'])){
	echo "<script>alert('Something Wrong');</script>";
	exit();
}
$title = addslashes($_POST['title']);
$intro = addslashes($_POST['intro']);
$content = addslashes($_POST['test-editormd-markdown-doc']);
mysqli_select_db($conn,'sec');
if(isset($_FILES['cover']) && $title != ''&&$intro != ''&&$content != ''){
	$cover_tmp = $_FILES['cover'];
	$flag = filterFile($cover_tmp,'stats/covers/');
	switch($flag){
		case 1:
			echo "<script>alert('文件类型不允许或太大');</script>";
			break;
		case 2:
			echo "<script>alert('系统从错误');</script>";
			break;
		case 3:
			echo "<script>alert('文件已存在');</script>";
			break;
		default:
			if(move_uploaded_file($cover_tmp['tmp_name'], $flag)){
				$cover = $flag;
				$date = date("Y-m-d H:i:s");
				$sql = "insert into article(title,content,intro,visits,category,date,cover) values ('$title','$content','$intro',1024,'Web安全','$date','$cover')";
				mysqli_query($conn,"set names utf8");

				if(mysqli_query($conn,$sql)){
					echo "<script>alert('文章发布成功！');</script>";
					header("location:admin.php");
				}else{
					echo mysqli_error($conn);
				}
			}else{
				echo "<script>alert('文件上传失败');</script>";
			}
	}
}else{
	echo "<script>alert('请填写完整！')</script>";
}
?>