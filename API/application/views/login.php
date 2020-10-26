<?php

	require_once "application/models/pageBuilder.php";
	
	if(isset($_GET['route'])){
		$route = $_GET['route'];
	} else {
		$route = "";
	}
	
	$pathArray = explode("/",$route);
	$absPath = implode("/",$pathArray);
	
	$pageBuilder = new PageBuilder();
	$pageBuilder->login($absPath);
?>
	
	<body class="bg_pattern">
		<div id="login_container">
				<div id="login_content">
					<div id="logo">
						<h1 class="logo_font">eLibrary</h1>
					</div>
					<div id="login_msg"></div>
					<form id="login_frm" action="" method="POST">
						<table id="login_table" class="table">
							<tr><td><input type="text" id="username" class="login_input" placeholder="Username" style="margin-bottom: 10px; text-align: center"/></td></tr>
							<tr><td><input type="password" id="password" class="login_input" placeholder="Password"style="margin-bottom: 10px; text-align: center"/></td></tr>
							<tr><td><input type="submit" id="submit_login" class="login_button" value="SIGN IN" style="margin-bottom: 10px; text-align: center"/></td></tr>
							<tr><td><input type="button" id="forgot_pass" class="password_button" value="Forgot password?" style="margin-bottom: 10px; text-align: center"/></td></tr>
						</table>
					</form>
				</div>
		</div>
	</body>
</html>

