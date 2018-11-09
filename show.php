<?php 
require_once('conn.php');
if(!isset($_GET['id'])){
	header("location:index.php");
	exit();
}
$id = intval($_GET['id']);
// echo "<script>alert(${id})</script>";
$sql = "select cover,title,content from article where id=".$id;
mysqli_select_db($conn,'sec');
mysqli_query($conn,"set names utf8");
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>文章详情</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<!-- 自定义css -->
	<link rel="stylesheet" href="css/show.css">
	<!-- editromd样式文件 -->
	<link rel="stylesheet" href="js/editormd/examples/css/style.css" />
    <link rel="stylesheet" href="js/editormd/css/editormd.preview.css" />
    <!-- editor js文件 -->
	<script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
	<script src="js/editormd/lib/marked.min.js"></script>
	<script src="js/editormd/lib/prettify.min.js"></script>
	<script src="js/editormd/lib/raphael.min.js"></script>
	<script src="js/editormd/lib/underscore.min.js"></script>
	<script src="js/editormd/lib/sequence-diagram.min.js"></script>
	<script src="js/editormd/lib/flowchart.min.js"></script>
	<script src="js/editormd/lib/jquery.flowchart.min.js"></script>
	<script src="js/editormd/editormd.min.js"></script>
	<!-- bootstrap -->
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">  
   	<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="bg">
	<!-- 导航栏 -->
	<div class="header">
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="background-color:rgb(165, 203, 226);
				border-color:rgb(165, 203, 226)">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
	                data-target="#example-navbar-collapse">
		            <span class="sr-only">切换导航</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
	       		 </button>
				<a href="index.php" class="navbar-brand"><span class="glyphicon glyphicon-globe"></span>侠客行</a>
			</div>
			<div class="collapse navbar-collapse" id="example-navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="#">Web安全</a></li>
					<li><a href="#">二进制安全</a></li>
					<li><a href="#">技术漫谈</a></li>
					<li><a href="#">人间有感</a></li>
				</ul>
			</div>
		</nav>
	</div>
	<div class="mycontainer" id="#top">
		<!-- 文章封面 -->
		<div class="cover" style="background-image: url(<?php echo $row['cover']?>);background-size: auto">
			<p class="title"><?php echo $row['title'] ?></p>
		</div>
		<!-- 文章内容 -->
		<div id="doc-content">
		<textarea name="" id="" cols="30" rows="10">
<?php 
echo $row['content'];
?>
		</textarea>
		</div>
		<!-- 留言表单 -->
		<div class="leave_comment">
			<form action="" id="comment" method="post">
				<div class="info">
					<input type="text" name="name" placeholder="名称">
					<input type="text" name="email" placeholder="邮箱">
					<input type="text" name="blog" placeholder="博客地址">
				</div>
				<div class="message">
					<input type="text" name="content" placeholder="欢迎大家来留言鸭~">
					<button type="button" name="submit" title="提交"><span class="glyphicon glyphicon-ok"></span></button>
				</div>	
			</form>
		</div>
		<div class="comments">
		<!-- 从数据库获取当前评论 -->
		<?php 
			$result = mysqli_query($conn,"select name,content,date from comment where aid=$id order by date");
			if(!$result){
				exit('获取评论失败');
			}
			while($row = mysqli_fetch_array($result)){
				echo "<div class='single '>";
				echo "<div class='uname'>".$row['name']." 说：</div>";
				echo "<div class='content'>".$row['content']."</div>";
				echo "<div class='date'>".$row['date']." | <a class='blockquote'>引用</a></div>";
				echo "</div>";
			}
		?>
	
		</div>	
	</div>
	<div class="gotop">
		<a href="#top" style="color:white"><span class="glyphicon glyphicon-chevron-up"></span></a>
	</div>
</div>
	
	<script type="text/javascript">
	    var testEditor;
	    $(function () {
	        testEditor = editormd.markdownToHTML("doc-content", {//注意：这里是上面DIV的id
	            htmlDecode: "style,script,iframe",
	            emoji: true,
	            taskList: true,
	            tex: true, // 默认不解析
	            flowChart: true, // 默认不解析
	            sequenceDiagram: true, // 默认不解析
	            codeFold: true,
	    });});
	    var submit = document.querySelector('button[name="submit"]');
	    var content = document.querySelector('input[name="content"]');
	    //ajax提交评论
	    function sendComment(){
	    	if(window.XMLHttpRequest){
	    		var xhr = new XMLHttpRequest();
	    	}else{
	    		var xhr = new ActiveXObject('Microsoft.XMLHTTP');
	    	}
	    	var form = document.getElementById('comment');
	    	var name = document.querySelector('input[name="name"]');
	    	var email = document.querySelector('input[name="email"]');
	    	var blog = document.querySelector('input[name="email"]');
	    	
	    	var aid = <?php echo $id?>;
			function clear(){
				this.style.borderBottom = "2px solid blue";
			}
			function recover(){
				this.style.borderBottom = "1px solid #aaa";
			}
			function over(){
				this.style.borderBottom = "2px solid black";	
			}
			name.onclick = clear;
			email.onclick = clear;
			content.onclick = clear;
			name.onmouseover = over;
			email.onmouseover = over;
			content.onmouseover = over;
			name.onmouseout = recover;
			email.onmouseout = recover;
			content.onmouseout = recover;
		    
	    	xhr.open("post","comment.php",true);
	    	xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	    	xhr.send("name="+name.value+"&email="+email.value+"&blog="+blog.value+"&content="+content.value+"&aid="+aid);
	    	//评论的回调函数
	    	xhr.onreadystatechange = function(){
	    		if(xhr.readyState == 4){
			    	if((xhr.status >= 200 && xhr.status < 300)|| xhr.status == 304){
			    		var response = xhr.responseText;
			    		response = JSON.parse(response);
			    		//检测信息是否填写完整
			    		if(!response.name){
			    			name.style.borderBottom = "2px solid red";
			    		}
			    		if(!response.email){
			    			email.style.borderBottom = "2px solid red";
			    		}
			    		if(!response.content){
			    			content.style.borderBottom = "2px solid red";
			    		}
			    		if(!response.safe){
			    			alert("what are you 弄啥勒~");
			    		}
			    		if(response.success){
			    			alert('评论成功');
			    			//评论成功后，异步获取当前评论内容，并显示在页面上
			    			this.open('get','getcomment.php?aid='+<?php echo $id;?>,'true');
		    				this.send(null);
					    	this.onreadystatechange = function(){
					    		if(xhr.readyState == 4){
							    	if((xhr.status >= 200 && xhr.status < 300)|| xhr.status == 304){
							    		var response = xhr.responseText;
							    		response = JSON.parse(response);
							    		var comments = document.getElementsByClassName('comments')[0];
							    		var single = document.createElement('div');
							    		single.className = 'single';
							    		var html = "\
											    		<div class='uname'>"+response['name']+" 说：</div>\
														<div class='content'>"+response['content']+"</div>\
														<div class='date'>"+response['date']+" | <a class='blockquote'>引用</a></div>"
							    		single.innerHTML = html;
							    		
										comments.appendChild(single);
							    	}else{
							    		alert("Request was unsuccessful: " + xhr.status);
							    	}		
					    		}
					    	}
			    		}
			    	}else{
			    		alert("Request was unsuccessful: " + xhr.status);
			    	}		
	    		}
	    		return 0;
	    	}
	    }
	    
	    //绑定事件
		submit.onclick = sendComment;
		var blockquotes = document.getElementsByClassName('blockquote');
		//引用评论
		function quote(){
			console.log(this.parentNode);
			var uname = this.parentNode.parentNode.children[0].innerHTML;
			console.log(uname);
			var comment_content = this.parentNode.parentNode.children[1].childNodes;
			console.log(comment_content);
			//处理那些只引用却不写评论的内容
			if(!comment_content[comment_content.length-1].data){
				var res = "<blockquote><b>"+uname+"</b>空白</blockquote>";	
			}else{
				var res = "<blockquote><b>"+uname+"</b>"+comment_content[comment_content.length-1].data+"</blockquote>";	
			}
			
			content.value = res;
			content.focus();
		}
		for (var i = 0;i < blockquotes.length;i++){
			blockquotes[i].onclick = quote;	
		}
	</script>

</body>
</html>