<?php
	class DB{
			private $_host = "localhost";
			private $_user = "root";
			private $_password = "";
			private $_db = "api";
		
			public function connectDB(){
				$conn = new mysqli($this->_host,$this->_user,$this->_password,$this->_db);
				// Connection error.
				if($conn->connect_error){
					echo "Error: Unable to connect to MySQL." . PHP_EOL;
					echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
					echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
					exit;
				} else {
					//Set allowance for special characters.
					date_default_timezone_set("Europe/Stockholm");
					$stmt = $conn->prepare("SET NAMES 'utf8'");
					$stmt->execute();
					$stmt->close();
				}
				return $conn;
			}
		
			public function closeDB($conn){
				$conn->close();
			}
	}