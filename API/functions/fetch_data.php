<?php
	
	require_once $_SERVER['DOCUMENT_ROOT']."/api/application/models/db.class.php";
		
	$db = new DB();
	$conn = $db->connectDB();
			
	$fetchType = mysqli_real_escape_string ($conn, $_POST['id']);
	
	if($fetchType == "author"){
		
		$SQLQuery = "SELECT id, name, biography FROM authors;";
		$stmt = $conn->prepare($SQLQuery);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($id, $name, $biography);
		
		echo '<div class="space"></div>';
		echo '<div class="tb_tr"><div class="tb_td font left">Showing all '.$stmt->num_rows.' authors</div></div>';
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
								<span class="tb_td"><h3 class="author font left">'.$name.'</h3></span>
								<input type="hidden" class="author_biography" value="'.$biography.'"/>
							</div>
						</div>
						<div id="tag_bar" class="tags_container">';
							
							//SELECT ALL AUTHORS ON EXISTING BOOKS
							$SQLQuery2 = "SELECT b.title,b.description FROM books as b JOIN authors_books as ab ON ab.book_id = b.id WHERE author_id = $id";
							$stmt2 = $conn->prepare($SQLQuery2);
							$stmt2->execute();
							$stmt2->store_result();
							$numrows2 = $stmt2->num_rows;
							$stmt2->bind_result($title,$description);
							
							echo '<span class="tag font"><b>Books:</b></span>';
							
							while($stmt2->fetch()){
								echo '<span class="title tag font">'.$title.'</span>';
								echo '<input type="hidden" class="book_description" value="'.$description.'"/>';
							}
									
							if($numrows2 < 1){
								echo '<span class="book"></span>';
							}		
	
						echo '</div>
					</div>
				</div>
			</div>';
		}
		echo '</div>';
		
		$stmt->close();
		$stmt2->close();
		$db->closeDB($conn);
	} 
	else if($fetchType == "book"){
				
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
	else if($fetchType == "Genre"){
		$SQLQuery = "SELECT id, name FROM genres;";
		$stmt = $conn->prepare($SQLQuery);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($id, $name);
		
		echo '<div class="space"></div>';
		echo '<div class="tb_tr"><div class="tb_td font left">Showing all '.$stmt->num_rows.' genres</div></div>';
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
								<span class="tb_td"><h3 class="title font left">'.$name.'</h3></span>
							</div>
						</div>
						<div id="tag_bar" class="tags_container">';
							
							//SELECT ALL AUTHORS ON EXISTING BOOKS
							$SQLQuery2 = "SELECT b.title,b.description FROM books as b JOIN books_genres as bg ON bg.book_id = b.id WHERE genre_id = $id";
							$stmt2 = $conn->prepare($SQLQuery2);
							$stmt2->execute();
							$stmt2->store_result();
							$numrows2 = $stmt2->num_rows;
							$stmt2->bind_result($title,$description);
							
							echo '<span class="tag font"><b>Books:</b></span>';
							
							while($stmt2->fetch()){
								echo '<span class="book tag font">'.$title.'</span>';
								echo '<input type="hidden" class="book_description" value="'.$description.'"/>';
							}
									
							if($numrows2 < 1){
								echo '<span class="book"></span>';
							}		
	
						echo '</div>
					</div>
				</div>
			</div>';
		}
		echo '</div>';
		
		$stmt->close();
		$stmt2->close();
		$db->closeDB($conn);
	}

?>
	

