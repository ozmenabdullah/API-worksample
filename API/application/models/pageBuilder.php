<?php
	require_once "application/models/contentBuilder.php";
	require_once "application/models/db.class.php";
	
	date_default_timezone_set('CET');
	class PageBuilder{
						
		public function home($absPath){
			$contentBuilder = new ContentBuilder();
			$contentBuilder->pageHeader('main');
			$contentBuilder->modal(1);
			echo '<body>';
			$contentBuilder->nav("main");
			$contentBuilder->responsive_menu_button("main");
			echo '<div id="brick_wrapper" class="page_wrapper">';
			
			//Add sort buttons
			echo '<div class="tb_tr"><div class="tb_td font left">Show</div></div>';
			echo '<div class="space"></div>';
			echo '<div class="tb_tr">';
			echo	'<div class="tb_td">';
							$contentBuilder->button("author_sort","Authors","author.svg");
			echo '	</div>';
			echo	'<div class="tb_td">';
							$contentBuilder->button("book_sort","Books","books.svg");
			echo '	</div>';
			echo	'<div class="tb_td">';
							$contentBuilder->button("Genre_sort","Genres","genre.svg");
			echo '	</div>';
			echo '</div>';
			
			//Add filter buttons
			echo '<div class="space"></div>';
			echo '<div class="tb_tr"><div class="tb_td font left">Filter</div></div>';
			echo '<div class="space"></div>';
			echo '<div class="tb_tr">';
			echo	'<div class="tb_td">';
							$contentBuilder->label_input("author","Author","search.svg",null);
			echo '	</div>';
			echo	'<div class="tb_td">';
							$contentBuilder->label_input("title","Title","search.svg",null);
			echo '	</div>';
			echo	'<div class="tb_td">';
							$contentBuilder->label_input("isbn","ISBN","search.svg",null);
			echo '	</div>';
			echo	'<div class="tb_td">';
							$contentBuilder->label_input("genres","Genres","search.svg",null);
			echo '	</div>';
			echo '</div>';
						
			//Fetch view data
			echo ' 
				<div class="space"></div>
				<div id="activity_table" class="table font">
					<div class="tb_tr">';
			echo	'<div class="tb_td" style="vertical-align: top !important;">';
							$contentBuilder->home_view();
			echo '	</div>
					</div>		
				</div>';
			echo '</body></html>';
		}
				
		public function homeJSON($query){
			$contentBuilder = new ContentBuilder();
			$contentBuilder->pageHeader('main');
			echo '<body>';
			echo '<div id="brick_wrapper" class="page_wrapper">';
			echo ' 			
				<div id="activity_table" class="table font">
					<div class="tb_tr">';
			echo	'<div class="tb_td">';
							$contentBuilder->getJSONData($query);
			echo '	</div>
					</div>				
				</div>';
			echo '</body></html>';
		}
		
		public function login($absPath){
			$contentBuilder = new ContentBuilder();
			$contentBuilder->pageHeader('login');
		}
	}
?>