<?php 
	require_once('conn.php');
	header("Content-Type: text/plain");
	$response = [
		'name'=>0,
		'email'=>0,
		'blog'=>0,
		'content'=>0,
		'aid'=>0,
		'safe'=>0,
		'success'=>0
	];
	function testInput($content){
		if(preg_match('/<script|<a|<iframe|<input|"|http:\/\//i',$content)||preg_match('/img/',$content)){
			return 0;
		}
		return 1;
	}
	if(!empty($_POST['name'])){
		$response['name'] = 1;
	}
	if(!empty($_POST['email'])){
		$response['email'] = 1;
	}
	if(!empty($_POST['blog'])){
		$response['blog'] = 1;
	}
	if(!empty($_POST['content'])){
		$response['content'] = 1;
	}
	if(!empty($_POST['aid'])){
		$response['aid'] = 1;
	}
	if(testInput($_POST['content'])&&testInput($_POST['name'])&&testInput($_POST['email'])&&testInput($_POST['blog'])){
		$response['safe'] = 1;
	}
	if(!$response['name']||!$response['email']||!$response['content']||!$response['aid']||!$response['safe']){
		echo json_encode($response);
		exit();
	}
	mysqli_select_db($conn,'sec');
	$sql = "insert into comment(aid,name,email,blog,content) values(".$_POST['aid'].",'".addslashes($_POST['name'])."','".addslashes($_POST['email'])."','".addslashes($_POST['blog'])."','".addslashes($_POST['content'])."')";
	mysqli_query($conn,"set names utf8");
	$result = mysqli_query($conn,$sql);
	if($result){
		$response['success'] = 1;
		echo json_encode($response);
	}
	exit();
?>