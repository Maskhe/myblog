<?php 
require 'conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- 后台地址:ManageHoutaiAdmin.php -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
	
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">  
   	<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<title>index</title>
	<link rel="stylesheet" href="css/before.css">
	<script type="text/javascript">
        //全屏
        function fullScreen(){
            var el = document.documentElement;
            var rfs = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;      
                if(typeof rfs != "undefined" && rfs) {
                    rfs.call(el);
                };
              return;
        }
        //退出全屏
        function exitScreen(){
            if (document.exitFullscreen) {  
                document.exitFullscreen();  
            }  
            else if (document.mozCancelFullScreen) {  
                document.mozCancelFullScreen();  
            }  
            else if (document.webkitCancelFullScreen) {  
                document.webkitCancelFullScreen();  
            }  
            else if (document.msExitFullscreen) {  
                document.msExitFullscreen();  
            } 
            if(typeof cfs != "undefined" && cfs) {
                cfs.call(el);
            }
        }
        //ie低版本的全屏，退出全屏都这个方法
        function iefull(){
            var el = document.documentElement;
            var rfs =  el.msRequestFullScreen;
            if(typeof window.ActiveXObject != "undefined") {
                //这的方法 模拟f11键，使浏览器全屏
                var wscript = new ActiveXObject("WScript.Shell");
                if(wscript != null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }
        //注：ie调用ActiveX控件，需要在ie浏览器安全设置里面把 ‘未标记为可安全执行脚本的ActiveX控件初始化并执行脚本’ 设置为启用
    </script>
</head>
<body class="body">
	<div class="header">
		<div class="expand">
			<span class="glyphicon glyphicon-fullscreen">&nbsp;全屏浏览</span>	
		</div>
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
	<?php 
		if(isset($_GET['p'])){
			$p = intval($_GET['p']);
		}else{
			$p = 1;
		}
		if(!isset($_GET['p'])){
	?>
			<div class="first">
				<div class="flag">
					我是阿信
				</div>
				<span class="glyphicon glyphicon-menu-down"></span>	
			</div>				
	<?php
		}
	?>
	
	<div class="second">
		<div class="test1">
			<div class="container">
				<?php 
					if($p >= 1){
						$offset = ($p-1)*6;
					}else{
						$offset = 0;
					}
					$sql = "select * from article limit $offset,6";
					mysqli_select_db($conn,'sec');
					mysqli_query($conn,"set names utf8");
					$result = mysqli_query($conn,$sql);
					$count = 1;
					while($row = mysqli_fetch_array($result)){
						if($count === 1){
				?>
							<div class="article page_first" id="article2">
								<div class="top" style="background:<?php echo $row['cover'];?>;background-size: auto">
									<p class="title"><?php echo $row['title'];?></p>
								</div>
								<div class="middle">
									<div class="intro"><?php echo $row['intro'];?></div>
									<p><a href=<?php echo "show.php?id=".$row['id']?>>阅读原文</a></p>
								</div> 
								<div class="bottom">
									<div class="bottom_left">
										<div class="head">
											<img src="imgs/m.jpg" alt="头像">
										</div>
										<div class="name_date">
											<!-- <span>阿三</span>
											<span>2018/10/11</span> -->
											<p class="name">阿三</p>
											<p><?php echo $row['date'];?></p>
										</div>
									</div>
									<div class="bottom_right">
										<?php echo $row['category']?>
									</div>
								</div>
							</div>
				<?php
						}else{
				?>
							<div class="article" id="article2">
								<div class="top" style="background-image:url(<?php echo $row['cover'];?>);background-size: auto">
									<p class="title"><?php echo $row['title'];?></p>
								</div>
								<div class="middle">
									<div class="intro"><?php echo $row['intro'];?></div>
									<p><a href=<?php echo "show.php?id=".$row['id']?>>阅读原文</a></p>
								</div>
								<div class="bottom">
									<div class="bottom_left">
										<div class="head">
											<img src="imgs/m.jpg" alt="头像">
										</div>
										<div class="name_date">
											<!-- <span>阿三</span>
											<span>2018/10/11</span> -->
											<p class="name">阿三</p>
											<p><?php echo $row['date'];?></p>
										</div>
									</div>
									<div class="bottom_right">
										<?php echo $row['category']?>
									</div>
								</div>
							</div>
				<?php			
						}
						$count++;
					}
				?>
							
				<!-- 分页显示 -->
				<div class="page">
					<div class="row" style="padding-top: 20px">
						<div class="col-xs-2 col-xs-offset-2">
							<?php 
								$result = mysqli_query($conn,"select count(*) from article");
								$row = mysqli_fetch_array($result);
								$count = intval($row[0]);
								$pages = ceil($count / 6);
								$nextP = $p+1;
								$preP = $p-1;
								if($p != 1){
									echo "<div class='pre_page'><a href='index.php?p=${preP}'><span class='glyphicon glyphicon-arrow-left' style='padding-top: 9px'></span></a></div>";
								}
							?>		
						</div>
						<div class="current_page col-xs-4">
							<?php								
								echo "$p / $pages";
							?>
						</div>
						<div class="col-xs-3 col-xs-offset-1">
							<?php 
								if($p != $pages){
									echo "<div class='next_page'><a href='index.php?p=${nextP}'><span class='glyphicon glyphicon-arrow-right' style='padding-top: 9px'></span></a></div>";
								}
							?>		
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 网页footer -->
	<div class="third">
		<div class="row" style="padding-top: 35px;width:100%">
			<div class="link col-md-4">
				<a href="https://blog.csdn.net/he_and"><span class="glyphicon glyphicon-comment"></span></a>
				<a href="#"><span class="glyphicon glyphicon-tree-conifer"></a>
				<a href="#"><span class="glyphicon glyphicon-leaf"></a>
			</div>
			<div class="copyright col-md-4">Copyright © 2018 阿三的博客</div>
			<div class="about col-md-4"><span>motto - </span>整就牛</div>			
		</div>

	</div>	
	<script>
		var query = location.search;
		if(query == ''){
			document.body.style.height=window.screen.height+'px';
			document.getElementsByClassName('first')[0].style.height=window.screen.height+'px';
			setInterval(function(){
				document.body.style.height=document.documentElement.clientHeight+'px';
				document.getElementsByClassName('first')[0].style.height=document.documentElement.clientHeight+'px';
			},500)
		}
		var span = document.getElementsByTagName('span')[0];
		var i = 0;
		span.onclick=function(){
			fullScreen();	
		}

		

  		setInterval(function(){
  			
  			var regexp = /p=(\d+)/;
  			var arr = regexp.exec(query);
  			if(query == ''){
	  			if(document.documentElement.scrollTop > 500){
	    			document.getElementsByClassName('navbar')[0].style.display="block"
	    			document.getElementsByClassName('glyphicon-fullscreen')[0].style.color="white";	
	    		}else{
	    				document.getElementsByClassName('navbar')[0].style.display="none"
	    				document.getElementsByClassName('glyphicon-fullscreen')[0].style.color="black";	
	    		}	
  			}else{
  				document.getElementsByClassName('navbar')[0].style.display = "block";
  				document.getElementsByClassName('glyphicon-fullscreen')[0].style.color="white";
  			}
  			
  			
  		},200)

  		// function next_page_hover(){
  		// 	var next_page = document.getElementsByClassName('next_page')[0];
  		// 	var hand = document.getElementsByClassName('glyphicon-hand-right')[0];
  		// 	next_page.onmouseover = function(){
  		// 		this.style.fontSize = "2em";
  		// 	}
  		// 	next_page.onmouseout = function(){
  		// 		this.style.fontSize = "1.4em";
  		// 		hand.style.paddingTop = "9px";
  		// 	}
  		// }
  		// next_page_hover();
	</script>
</body>
</html>