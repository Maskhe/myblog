<?php 
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

$upload_dir = "stats/article_imgs/";

$flag = filterFile($_FILES['editormd-image-file'],$upload_dir);

switch ($flag){
	case 1:
		$arr = [
			"success"=>0,
			"message"=>"上传失败(文件类型不允许或太大)",
			"url"=>""
		];
		echo json_encode($arr);
		break;
	case 2:
		$arr = [
			"success"=>0,
			"message"=>"上传失败(文件类型不允许或太大)",
			"url"=>""
		];
		echo json_encode($arr);
		break;
	case 3:
		$arr = [
			"success"=>0,
			"message"=>"上传失败(文件类型不允许或太大)",
			"url"=>""
		];
		echo json_encode($arr);
		break;
	default:
		if(move_uploaded_file($_FILES['editormd-image-file']['tmp_name'], "$flag")){
			$arr = [
					"success"=>1,
					"message"=>"上传成功",
					"url"=>"$flag"
				];
			echo json_encode($arr);					
		}else{
			$arr = [
				"success"=>0,
				"message"=>"上传失败",
				"url"=>""
			];
			echo json_encode($arr);					
		}
		break;
}
?>