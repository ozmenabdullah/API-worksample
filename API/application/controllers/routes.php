<?php
	class Routes{
		
		/** Internal variables **/
		private $_uri = [];
		private $_callback = [];
		
		/** Function add to called routes and callbacks **/
		public function add($uri = '', $callback = '', $restricted = ''){
			//Assign data to array			
			$this->_uri[]= $uri;
			$this->_callback[]= $callback;
			$this->_restricted[] = $restricted;
		}
		
		public function run(){
			$check = 0;
			
			//If first operand true, do second operand else third operand.
			$url = isset($_GET['route']) ? '/'.$_GET['route'] : '/';
			
			foreach ($this ->_uri as $key => $value){
				 if(preg_match("#^$value$#", $url, $params)){
					if($this->_restricted[$key] == 1){
						if(empty($_SESSION['logged_in_username'])){
							call_user_func("fallback", true);
							$check = 1;
							
							//Return callback if the url match with a route
							call_user_func_array($this->_callback[$key], $params);
						} else {
							array_shift($params);
							$check = 1;
							
							//Return callback if the url match with a route
							call_user_func_array($this->_callback[$key], $params);
						}
					} else {
						array_shift($params);
						$check = 1;
						
						//Return callback if the url match with a route
						call_user_func_array($this->_callback[$key], $params);
					}
				}
			}
			
			if(isset($_GET['route']) && $check == 0){
				call_user_func_array("not_found", array($_GET['route']));
			}
		}
	}