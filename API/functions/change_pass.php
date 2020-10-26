<?php
	
	/*
	 * Filename: delete_record.php
	 * Description: Deletes record from database.
	 * Version: 1.0.
	 */

		require_once $_SERVER['DOCUMENT_ROOT']."/api/application/models/db.class.php";
		$db = new DB();
		
		// Estabilsh connection.
		$conn = $db->connectDB();
		
		$id =mysqli_real_escape_string($conn,$_POST["id"]);
		$password =mysqli_real_escape_string($conn,$_POST["password"]);
		
		$salt = "tfk11aomxpt8ercqsy52ld3x";
		$salt = '$6$rounds=10000$'.strtr(base64_encode($salt), array('_' => '.', '~' => '/'));
		$password_hash = crypt($password, $salt);
		
		$query = "UPDATE user SET password = '".$password_hash."' WHERE id = ". $id;
		$result = mysqli_query($conn, $query);
		
		if(mysqli_affected_rows($conn) > 0){
			echo "1";
		} else {
			echo mysqli_errno($conn);
		}
?>
