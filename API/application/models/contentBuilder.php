<?php
	require_once "db.class.php";
	date_default_timezone_set('CET');
	
	class ContentBuilder{
		
		public function get_dateTime($format){
			if($format == ""){
				$dateResult  = date("Y-m-d H:i:s");
			} else {
				$dateResult  = date($format);
			}
			
			return $dateResult;
		}
		
		public function get_date($format){
			if($format == ""){
				$dateResult  = date("Y-m-d");
			} else {
				$dateResult  = date($format);
			}
			
			return $dateResult;
		}
			
		public function webSafeText($str){
			$pattern1 = array('/Å/', '/Ä/', '/Ö/', '/Ş/', '/å/', '/ä/', '/ö/', '/ /', '/ı/', '/ğ/', '/ş/', '/ç/', '/é/');
			$replace1 = array('A', 'A', 'O', 'S', 'a', 'a', 'o', '_', 'i', 'g', 's', 'c', 'e');
			$webSafeText = preg_replace($pattern1, $replace1, $str);
		
			$a = array('A','B','C','D','E','F','G','H','I','J',
				'K','L','M','N','O','P','Q','R','S','T','U','V','X','Y','Z');
			$b = array('a','b','c','d','e','f','g','h','i','j',
				'k','l','m','n','o','p','q','r','s','t','u','v','x','y','z');
			
			return str_replace($a,$b,$webSafeText);
		}
		
		public function formatRegularText($str){
			$stringLength = strlen($str);
			$pattern1 = array('/_/');
			$replace1 = array(' ');
			$formatRegularText = preg_replace($pattern1, $replace1, $str);
			
			return ucwords($formatRegularText);
		}
			
		public function page_head($absPath){
			$absPath = $this->formatRegularText($absPath);
			
			echo '
				<table class="page_heading table">
					<tbody>
						<tr>
							<td style="border:none;"><h1 class="font">'.$absPath.'</h1></td>
							<td style="border:none;text-align:right;"><td>
						</tr>
					</tbody>
				</table>';
		}
		
		public function pageHeader($script){
			echo '<!DOCTYPE html>';
			echo '	<html>';
			echo '		<head>';
			echo '			<meta http-equiv = "Content-Type:application/javascript"; charset = utf-8"/>';
			echo '			<meta name="viewport" content="width=device-width,inital-scale=1,maximum-scale=1"/>';
			echo '			<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>';
			echo '			<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">';
			echo '			<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>';
			echo '			<script src="js/'.$script.'.js"></script>';
			echo '			<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">';
			echo '			<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">';
			echo '			<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">';
			echo '			<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400" rel="stylesheet">';
			echo '			<link href="https://fonts.googleapis.com/css?family=Lato:400|Rubik:400" rel="stylesheet">';
			echo '			<link rel="stylesheet" type="text/css" href="css/style.css">';
			echo '		</head>';
		}
		
		public function nav($str){
			$page = $str;
			$products = "";
			$slider = "";
			$users = "";
			$categories = "";
			
			echo '<div id="nav_wrapper">';
			echo '	<ul id="nav_bar">';
			echo '		<li style="border-bottom: solid 1px #f1f1f1; padding: 20px 20px 30px 20px; line-height: 50px;"><span id="nav_logo" class="font" style="font-size: 2.5rem; font-weight: bold;"><span style="color:#78bc42;font-weight: bold;">e</span>Library</span></li>';
			
			echo '		
			<li>
				<button id="show_home" class="nav_btn">
					<img style="vertical-align:middle;" src="img/home.svg" width="40px"/>
					<span style="display:inline-block; padding: 10px 5px;">HOME</span>
				</button>
			</li>';		
			if(empty($_SESSION['logged_in_username'])){
				echo '		
				<li>
					<button id="show_admin" class="nav_btn">
						<img style="vertical-align:middle;" src="img/admin.svg" width="40px"/>
						<span style="display:inline-block; padding: 10px 5px;">ADMIN</span>
					</button>
				</li>';
			} else {
				echo '		
				<li>
					<button id="logout" class="nav_btn">
						<img style="vertical-align:middle;" src="img/signout.svg" width="40px"/>
						<span style="display:inline-block; padding: 10px 5px;">LOG OUT</span>
					</button>
				</li>';
			}
			echo '		
			<li>
				<button id="close_menu" class="nav_btn">
					<img style="vertical-align:middle;" src="img/close.svg" width="40px"/>
					<span style="display:inline-block; padding: 10px 5px;">CLOSE</span>
				</button>
			</li>';
			echo '	</ul>';
			echo '</div>';
		}
		
		public function select(){
			echo '
				<div id="" class="filter_bar box_shadow">
					<input type="text" id="search" class="search_input font" placeholder="&#x1F50D;  Filtrera på"/>
					<ul id="search_input_select_list" class="select_list font">
						<li class="search">Abdullah Özmen</li>
						<li class="search">Ali Rama</li>
						<li class="search">Robert Erlandsson</li>
						<li class="search">Jim Wästerberg</li>
						<li class="search">Test</li>
					</ul>
				</div>';
		}
				
		public function home_view(){
			
			$db = new DB();
			$conn = $db->connectDB();
			
			$SQLQuery = "SELECT id, title, isbn, description FROM books;";
			$stmt = $conn->prepare($SQLQuery);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($id, $title, $isbn, $description);
			
			echo '<div class="space"></div>';
			echo '<div class="tb_tr"><div class="tb_td font left">Showing all '.$stmt->num_rows.' books</div></div>';
			echo '<div class="space"></div>';
			echo '
				<div id="home_wrapper">';			
				while($stmt->fetch()){
					echo '<div id="" class="tb card right" style="padding:0px;margin-bottom: 10px;">
							<div class="tb_tr">
								<div class="tb_td green_bg" style="width: 10px;padding: 0;width: 8px; border-top-left-radius: 5px; border-bottom-left-radius: 5px;">
							</div>
							<div class="tb_td" style="padding:0px;">
								<div class="tb">
									<div class="tb_tr">
										<span class="tb_td" style="width:100px;"><h3 class="font left">'.$id.'</h3></span>
										<span class="tb_td"><h3 class="title font left">'.$title.'</h3></span>
										<input type="hidden" class="book_description" value="'.$description.'"/>
									</div>
								</div>
								<div id="tag_bar" class="tags_container">
									<span class="tag font"><b>ISBN:</b></span>
									<span class="isbn tag font">'.$isbn.'</span>';
									
									//SELECT ALL GENRES ON EXISITING BOOKS
									$SQLQuery2 = "SELECT g.name FROM books_genres as bg JOIN genres as g ON bg.genre_id = g.id WHERE	book_id = $id";
									$stmt2 = $conn->prepare($SQLQuery2);
									$stmt2->execute();
									$stmt2->store_result();
									$numrows2 = $stmt2->num_rows;
									$stmt2->bind_result($genre);
									
									echo '<span class="tag font"><b>Genre:</b></span>';									
									while($stmt2->fetch()){
										echo '<span class="genres tag font">'.$genre.'</span>';	
									}
									
									if($numrows2 < 1){
										echo '<span class="isbn"></span>';
									}			
									
									//SELECT ALL AUTHORS ON EXISTING BOOKS
									$SQLQuery3 = "SELECT a.name, a.biography FROM authors_books as ab JOIN authors as a ON ab.author_id = a.id WHERE ab.book_id = $id";
									$stmt3 = $conn->prepare($SQLQuery3);
									$stmt3->execute();
									$stmt3->store_result();
									$numrows3 = $stmt3->num_rows;
									$stmt3->bind_result($author,$biography);
									
									echo '<span class="tag font"><b>Authors:</b></span>';
									
									while($stmt3->fetch()){
										echo '<span class="author tag font">'.$author.'</span>';
										echo '<input type="hidden" class="author_biography" value="'.$biography.'"/>';
									}
									
									if($numrows3 < 1){
										echo '<span class="author"></span>';
									}
									
								echo '</div>
							</div>
						</div>
					</div>';
				}
			echo '</div>';
			
			$stmt->close();
			$stmt2->close();
			$stmt3->close();
			$db->closeDB($conn);
		}
						
		public function responsive_menu_button(){
			echo '
				<button id="responsive_menu_btn" class="filter_btn">
					<img style="vertical-align:middle;" src="img/table_layout.svg" width="40px"/>
					<span style="display:inline-block; padding: 10px 5px;">MENU</span>
				</button>';
		}

		public function modal(){
			echo '<div class="overlay">';
			echo '	<div class="modal">';
			echo '		<div class="modal_content">';
			echo '			<div class="modal_heading font book_title"></div>';
			echo '			<div class="modal_text font book_description"></div>';
			echo '			<div class="modal_heading font modal_author"></div>';
			echo '			<div class="modal_text font author_biography"></div>';
			echo '			<div class="space"></div>';
			echo '			<div">
									<input type="button" id="" class="close_modal std_input font bg_sunburn sunburn_border transition" value="CLOSE" onclick="">
								</div>';
			#echo '			<div id="modal_button_success" class="box_buttons">';
			#echo '				<input type="button" id="close" class="table_button bottom_right_radius bottom_left_radius" value="Kapat"/>';
			#echo '			</div>';
			echo '		</div>';
			echo '	</div>';
			echo '</div>';
		}
		
		public function label_input($name,$heading,$img,$type){
			echo '	<div id="" style="margin-bottom: 25px;">
							<div class="label_input_container">
								<label for="'.$this->webSafeText($name).'_heading" id="'.$this->webSafeText($name).'_heading_label" class="label font">
									<img style="vertical-align:middle;" src="img/'.$img.'" width="40px"/>
									<span>'.$heading.'</span>
								</label>
								<input type="text" id="'.$this->webSafeText($name).'_heading_input" class="input font std_input '.$type.'" style="font-size: 3rem;text-align:center !important;"/>
							</div>
						</div>';
		}
		
		public function label_input_selectDB($name,$query){
			$db = new DB();
			$conn = $db->connectDB();
				
			$stmt = $conn->prepare($query);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($value);
			
			echo ' 	<div id="" style="padding: 5px 0;">
							<div class="label_input_container">
								<label for="'.$this->webSafeText($name).'" id="'.$this->webSafeText($name).'_label" class="label font">'.$name.'</label>
								<input type="text" id="'.$this->webSafeText($name).'" class="input font std_input select" style="text-align:left !important;"/>
								<ul id="'.$this->webSafeText($name).'_select_list" class="select_list font">';
								
								while($stmt->fetch()){
									echo '<li class="select_item">'.$value.'</li>';
								}
			echo '			</ul>
							</div>
						</div>';
		}
		
		public function label_input_select($name,array $values,$img,$default){
			
			echo ' 	<div id="" style="padding: 5px 0;">
							<div class="label_input_container">
								<label for="'.$this->webSafeText($name).'" id="'.$this->webSafeText($name).'_label" class="label font" style="background:#fff;">
									<img style="vertical-align:middle;" src="img/'.$img.'" width="40px"/>
									<span>'.$name.'</span>
								</label>
								<input type="text" id="'.$this->webSafeText($name).'" class="input font std_input select case bold" style="text-align:center !important;" value="'.$default.'"/>
								<ul id="'.$this->webSafeText($name).'_select_list" class="select_list font">';
								
								foreach($values as $val){
									echo	 '<li class="select_item">'.$val.'</li>';
								}
								
			echo '			</ul>
							</div>
						</div>';
		}
		
		public function label_input_spinner($name){
			echo '	<div id="ticket_heading" style="padding: 10px 0;">
							<div class="label_input_spinner_container">
								<label for="'.$this->webSafeText($name).'_heading" id="'.$this->webSafeText($name).'_heading_label" class="label font label_small">'.$name.'</label>
								<input type="text" id="'.$this->webSafeText($name).'_heading_input" class="input input_hour font std_input timepicker_hour" style="text-align:left !important;" value="00"/>
								<input type="text" id="'.$this->webSafeText($name).'_heading_input" class="input input_minute font std_input timepicker_minute" style="text-align:left !important;" value="00"/>
							</div>
						</div>';
		}
		
		public function label_input_textarea($name){
			echo '	<div style="padding: 10px 0px;">
							<div class="label_textarea_container transition">
								<label for="'.$this->webSafeText($name).'_heading" id="'.$this->webSafeText($name).'_label" class="label font">Description</label>
								<textarea type="text" id="'.$this->webSafeText($name).'_heading_input" class="textarea font std_input" rows="5"></textarea>
							</div>
						</div>';
		}
		
		public function button($id, $value, $img){
			echo '<button id="'.$id.'" class="filter_btn sidepanel_box green_btn green_border border-radius transition std_input font white_font">
					<img style="vertical-align:middle;" src="img/'.$img.'" width="40px"/>
					<span style="display:inline-block; padding: 10px 5px;">'.$value.'</span>
				</button>';
		}
				
		public function getJSONData($query){
			if(isset($_GET['list'])){$list = $_GET['list'];}
			if(isset($_GET['show'])){$show = $_GET['show'];}
			if(isset($_GET['id'])){$id = $_GET['id'];}

			if(isset($list) && isset($id) && isset($show)){
				switch($show){
					case "books":
						if($list == "authors"){$this->getAuthorBooks($id);}
						break;
					case "authors":
						if($list == "books"){$this->getBookAuthors($id);}
						break;
					case "genres":
						if($list == "books"){$this->getBookGenres($id);}
						break;
				}
			} else if(isset($list) && isset($id)){
				$this->getListWithID($list,$id);
			} else if(isset($list) && empty($id)){
				$this->getList($list);
			}
		}
		
		public function getList($table){
			$db = new DB();
			$conn = $db->connectDB();
			
			$sqlQuery = "SELECT * FROM $table";
			$stmt = $conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();
			$data = $result->fetch_all(MYSQLI_ASSOC);
			
			echo json_encode($data);
		}
		
		public function getListWithID($table,$id){
			$db = new DB();
			$conn = $db->connectDB();
			
			$sqlQuery = "SELECT * FROM $table WHERE ID = $id";
								
			$stmt = $conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();
			$data = $result->fetch_all(MYSQLI_ASSOC);
			
			echo json_encode($data);
		}
		
		public function getBookAuthors($bookID){
			$db = new DB();
			$conn = $db->connectDB();
			
			$sqlQuery = "SELECT a.id,a.name,a.biography FROM authors as a LEFT JOIN authors_books as ab ON a.id = ab.author_id LEFT JOIN books as b ON b.id = ab.book_id WHERE b.id = $bookID";
								
			$stmt = $conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();
			$data = $result->fetch_all(MYSQLI_ASSOC);
			
			echo json_encode($data);
		}
		
		public function getAuthorBooks($authorID){
			$db = new DB();
			$conn = $db->connectDB();
			
			$sqlQuery = "SELECT b.id, b.title,b.isbn,b.description FROM authors as a LEFT JOIN authors_books as ab ON a.id = ab.author_id LEFT JOIN books as b ON b.id = ab.book_id WHERE a.id = $authorID";
								
			$stmt = $conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();
			$data = $result->fetch_all(MYSQLI_ASSOC);
			
			echo json_encode($data);
		}
		
		public function getBookGenres($bookID){
			$db = new DB();
			$conn = $db->connectDB();
			
			$sqlQuery = "SELECT g.id,g.name FROM genres as g LEFT JOIN books_genres as bg ON g.id = bg.genre_id LEFT JOIN books as b ON b.id = bg.book_id WHERE b.id = $bookID";
								
			$stmt = $conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();
			$data = $result->fetch_all(MYSQLI_ASSOC);
			
			echo json_encode($data);
		}
	}