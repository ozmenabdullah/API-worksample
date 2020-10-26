<?php
	header('Access-Control-Allow-Origin: *'); 
	
	require_once "application/models/pageBuilder.php";
	
	if(isset($_GET['route'])){
		$route = $_GET['route'];
	} else {
		$route = "";
	}

	$uri = $_SERVER['REQUEST_URI'];
	$pathArray = explode("/",$route);
	$absPath = implode("/",$pathArray);
	
	$query = parse_url($uri, PHP_URL_QUERY);
	
	$pageBuilder = new PageBuilder();
	
	if(isset($query)){
		$pageBuilder->homeJSON($query);
	} else{
		$pageBuilder->home($absPath);
	}
	
?>