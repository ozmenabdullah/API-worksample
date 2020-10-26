<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/ebuddy/application/models/db.class.php";
	$db = new DB();
	
	// Estabilsh connection.
	$conn = $db->connectDB();
	
	// Variables.
	$username = mysqli_real_escape_string ($conn, $_POST['username']);
	$password = mysqli_real_escape_string ($conn, $_POST['password']);
	
	$salt = "tfk11aomxpt8ercqsy52ld3x";
	$salt = '$6$rounds=10000$'.strtr(base64_encode($salt), array('_' => '.', '~' => '/'));
	$password_hash = crypt($password, $salt);
		
	$query = "SELECT * FROM user WHERE username = '".$username."'";
	$result = mysqli_query($conn,$query) or die (mysqli_error($conn));
	$data = mysqli_fetch_assoc($result);
		
	// If record found.
	if(crypt($password,$password_hash) == $data['password']){
		session_start();
		$_SESSION['logged_in_username'] = $data["display_name"];
		#$_SESSION['admin_access'] = $data["usertype"];
		echo "1";
	} else {
		echo "0";
	}
		
	mysqli_free_result($result);
	mysqli_close($conn);
?>