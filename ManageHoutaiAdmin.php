<?php
require("conn.php");
session_start();
if(!isset($_SESSION['name'])){
	header('location:login.php');
	exit();
}
if(@$_GET['action']=='logout'){
	unset($_SESSION['name']);
	header('location:index.php');
}
$token = mt_rand();
$_SESSION['token'] = $token;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>admin</title>
	<link rel="stylesheet" href="js/editormd/css/editormd.min.css">
	<script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
	<script src="js/editormd/editormd.min.js"></script>
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">  
   	<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- <script src="js/showdown.min.js"></script> -->
</head>
<body>

	<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="background-color:#33b7b5;
				border-color:#33b7b5;">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
	                data-target="#example-navbar-collapse">
		            <span class="sr-only">切换导航</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
	       		 </button>
				<a href="./index.php" class="navbar-brand" style="color:white"><span class="glyphicon glyphicon-globe"></span>返回主页</a>
			</div>
			<div class="collapse navbar-collapse" id="example-navbar-collapse">
				<ul class="nav navbar-nav" >
					<li class="active"><a href="#" style="color:white">撰写博客</a></li>
					<li><a href="#" style="color:white">修改资料</a></li>
					<!-- <li><a href="#" style="color:white">Web安全</a></li>
					<li><a href="#" style="color:white">二进制安全</a></li> -->
				</ul>

				<a href="admin?action=logout"><button class="btn btn-default navbar-btn pull-right" style="margin-right:20px">退出登录</button></a>
			</div>
		</nav>
		<div class="container">
			<div class="row" style="height:54px"></div>
			<form action="article.php" method="post" role="form" class="form-horizontal" enctype="multipart/form-data">
				<div class="form-group">
					<label for="title" class="control-label col-md-1 col-md-offset-1">标题</label>
					<div class="col-md-8">
						<input type="text" class="form-control" name="title" placeholder="请输入标题">	
						<input type="hidden" name="token" value="<?php echo $token ?>">
					</div>
					
				</div>
				<div class="form-group">
					<label for="title" class="control-label col-md-1 col-md-offset-1">简介</label>
					<div class="col-md-8">
						<textarea name="intro" id="intro" cols="120" rows="6" class="form-control" style="resize:none">简介需要在20字以来，如果不填写则默认提取文章内容
						</textarea>
					</div>
				</div>
				<div class="form-group">
				    <label for="inputfile" class="control-label col-md-1 col-md-offset-1">文章封面</label>
				    <div class="col-md-8">
				    	<input type="file" id="inputfile" class="btn btn-default" name="cover">	
				    </div>
			  	</div>
			  	<div class="form-group">
			  		
		  			<div class="col-md-2 col-md-offset-2">
		  				<button type="submit" class="btn btn-primary" name="save_draft">保存草稿</button>
			  		</div>
			  		<div class="col-md-2">
			  			<button type="submit" class="btn btn-primary" name="preview">预&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;览</button>
			  		</div>
			  		<div class="col-md-2">
			  			<button type="submit" class="btn btn-primary" name="publish">发&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;布</button>
			  		</div>
				  </div>
				<div id="test-editormd" style="margin:50px auto 15px">
		            <textarea style="display: none;" id="ts"></textarea>
		    	</div>	
			</form>
		</div>
	

    <script type="text/javascript">
	    var testEditor;
	    $(function() {
	        testEditor = editormd("test-editormd", {//这个值就是上面div的id属性值
	            width : "1000px",
	            height : 640,
	            syncScrolling : "single",
	            path : "js/editormd/lib/",//自己的editormdlib路径

	            //上传图片相关配置
	            imageUpload    : true,
	            imageFormats   : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
	            imageUploadURL : " /sec/blog/imgupload.php",
	            saveHTMLToTextarea : true,//该配置方便post提交表单
	        });
	    });
		//获取输入的js文本
		//testEditor.getHTML(); 

		var clear = function(){
			document.getElementById('intro').onfocus = function(){
				this.innerHTML = "";
			}
		}
		clear();
	</script>
</body>
</html>