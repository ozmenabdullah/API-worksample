<?php
	
	session_start();
	
	require_once 'application/controllers/routes.php';
	$routes = new Routes();
	$requireLogin = 0;
	
	function not_found($page){
		echo "Page <b>$page</b> not found!";
	}
	
	function fallback($val){
		$requireLogin = $val;
		header("location:login");
	}
	
	$routes->add('/',function(){include_once 'application/views/home.php';});
	$routes->add('/login',function(){include_once 'application/views/login.php';});
	$routes->add('/admin',function(){include_once 'application/views/admin.php';},1);
		
	echo $routes->run();
	 
