$(document).ready(function() {
    /**********************************************************************************************/
	/*Globals*/
	/**********************************************************************************************/
					
			var selectedBrickID = ""
			var activities = [];
			var bricks = [];
			var activities2 = [];
			var windowSize;
			
			var date = new Date();
			var day = date.getDate();
			var month = date.getMonth();
			var year = date.getFullYear();
			var hours = date.getHours();
			var seconds = date.getMinutes();
			var minutes = date.getSeconds();
						
			if(day < 10){day = "0"+day;}
			if(month < 10){month = "0"+month;}
			if(hours < 10){hours = "0"+hours;}
			if(minutes < 10){minutes = "0"+minutes;}
			if(seconds < 10){seconds = "0"+seconds;}
					
			var now = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
			
			$(".label_input_container").each(function(index){
				if($(this).find(".input").val() != ""){
					$(this).find(".label").addClass("label_small");
				}
			});
			
			var navWrapperWidth = $("#nav_wrapper").width();
			$("#brick_wrapper").css("left",(navWrapperWidth+50));
			
			var documentHeight = $(document).height();
			$("#nav_wrapper").css("height",(documentHeight));
			
			$('.btn_disabled').prop('disabled', true);
						
			$( window ).resize(function() {
				var documentHeight = $(document).height();
				$("#nav_wrapper").css("height",(documentHeight));
				windowSize = $(window).width();
					
				if(pageActive != "brick"){
					$("#"+pageActive+"_wrapper").css({"max-width":windowSize+"px","overflow-x":"scroll"});
				}
				
				var navWrapperWidth = $("#nav_wrapper").width();
				$("#brick_wrapper").css("left",(navWrapperWidth+50));
			});
			
			/*LabelInput*/
			/******************************************************/
			
			$(".label_input_container").focusin(function(){
				$(this).find(".label").addClass("label_small");
				$(this).addClass("bg_mintgreen_schwag border-radius");
			});	
			
			$(".label_input_container").focusout(function(){
				var inputId = $(this).find(".input").attr('id');
				var val = $('#'+inputId).val();
				var labelID = $(this).find(".label").attr("id");
				
				if($('#'+inputId).hasClass("date") || $('#'+inputId).hasClass("select")){
					setTimeout(function(){
						var inputVal = $("#"+inputId).val();
						if(inputVal == ""){
							$("#"+labelID).removeClass("label_small");
							$("#"+labelID).parent().removeClass("bg_mintgreen_border border-radius");
						}
					}, 200);
				} else if(val == ""){
					$(this).find(".label").removeClass("label_small");
					$(this).removeClass("bg_mintgreen_border border-radius");
				} 
				$(this).removeClass("bg_mintgreen_schwag");
			});					
			
			/*Navbar*/
			/******************************************************/
			$(".nav_btn").click(function(){
				$(".nav_btn").removeClass("nav_active");
				$(this).addClass("nav_active");
				var btnID = $(this).attr("id");
				var index = btnID.indexOf("_");
				var page = btnID.substring(0,index);
				
				$(".new_page_wrapper").each(function(index){
					if($(this).css('left') != '-100%'){
						$(this).animate({left: "-100%"});
					}
				});
				
				if(page != "brick"){
					$("#"+page+"_wrapper").css({"max-width":windowSize+"px","overflow-x":"scroll"});
				}
				$("#"+page+"_wrapper").animate({left: "100px"});
				
				if(($("#responsive_menu_btn").css("display"))=="block"){
					$("#nav_wrapper").toggle();
				}
			});
		
			/*Select*/
			/******************************************************/
			
			$('.select').click(function(){
				var id = $(this).attr("id");
				$('#'+id+'_select_list').toggle();
			});
			
			$('.select').focusout(function(){
				var id = $(this).attr("id");
				setTimeout(function(){
					if($('#'+id+'_select_list').css('display') == 'block'){
						$('#'+id+'_select_list').toggle();
					}
				}, 200);
			});
			
			$(document).on("click",".select_item",function(){
				var text = $(this).html();
				var selectListId = $(this).parent().attr("id");
				var index = selectListId.indexOf("_");
				var inputId = selectListId.substring(0,index);
				$('#'+inputId).val(text);
				$('#'+inputId).attr('value',text)
			});
			
			/*Select list*/
			/******************************************************/
			
			$(".has_select_list").focusout(function(){
				setTimeout(function(){
					$(".select_list").css('display','none'); 
				}, 200);
			});

			$("#brick_project_code").click(function(){
				if(selectedBrickID != ""){
					$("#project_code_select_list li").remove();
					$(".projectCodeBox").each(function(index){
						var projectCode = $(this).find(".projectCode").html();
						var projectDesc = $(this).find(".projectDesc").html();
						$("#project_code_select_list").append("<li class='project_code'>"+projectCode+" ("+projectDesc+")</li>");
					});
					
					if($("#project_code_select_list").css("display") == "block"){
						$("#project_code_select_list").removeClass("show_list");
					} else {
						$("#project_code_select_list").addClass("show_list");
					}
				} else {
					alert("Please select a brick!");
				}
			});
								
			$(document).on("click",".task_activity", function (){
				var selectedProjectCode = $("#brick_project_code").val();
				var taskBrickID = $(this).parent().parent().parent().attr("class");
				var taskID = $(this).parent().parent().parent().attr("id");
				
				taskBrickID = taskBrickID.split(" ");
				taskBrickID = taskBrickID[2].replace("_task","");
				var projectCode = $("#project_code_"+taskBrickID).val();
				projectCode = projectCode.split(" ");
				projectCode = projectCode[0];
				
				var projectActivities = $("#project_"+projectCode).find(".projectActivity");
				
				switch(selectedProjectCode){
					case "":
						$("#brick_project_code").addClass("red_bg");
						setTimeout(function(){
							$("#brick_project_code").removeClass("red_bg");
						}, 2000);
						break;
					
					default:
						$("#activity_list_"+taskID+" li").remove();
						projectActivities.each(function(index){
							var activity = $(this).html();
							$("#activity_list_"+taskID).append("<li style='font-size: 14px !important;' class='project_activity white_font'>"+activity+"</li>");
						});
						
						if($("#activity_list_"+taskID).css("display") == "block"){
							$("#activity_list_"+taskID).removeClass("show_list");
						} else {
							$("#activity_list_"+taskID).addClass("show_list");
						}
				}

			});
			
			$("#brick_project_code").focusout(function(){
				setTimeout(function(){
					$("#project_code_select_list").removeClass("show_list");
				}, 200);
			});
			
			$(document).on("focusout",".task_activity", function (){
				var taskID = $(this).parent().parent().parent().attr("id");
				setTimeout(function(){
					$("#activity_list_"+taskID).removeClass("show_list");
				}, 200);
			});		
			 
			$(document).on("click",".select_list li", function (){
				var listItemType = $(this).attr("class");
				var listItemType = listItemType.split(" ");
				var selectedValue = $(this).html();
				
				switch(listItemType[0]){
					case "project_code":
						$("#project_code_"+selectedBrickID).val(selectedValue);
						$("#brick_project_code").val(selectedValue);
						break;
					case "project_activity":
						var parentID = $(this).parent().attr("id");
						parentID = parentID.split("_");
						$("#task_activity_"+parentID[3]).val(selectedValue);
						$("#task_activity_"+parentID[3]).attr("value",selectedValue);
						break;
				}
			});
															
			/*Globals*/
			/******************************************************/
			var selectedBrickID = ""
			var activities = [];
			var bricks = [];
			var activities2 = [];
			var windowSize;
			
			$( window ).resize(function() {
				windowSize = $(window).width();
				var pageActive = $(".nav_active").attr("id");
				index = pageActive.indexOf("_");
				pageActive = pageActive.substring(0,index);
				
				if(pageActive != "brick"){
					$("#"+pageActive+"_wrapper").css({"max-width":windowSize+"px","overflow-x":"scroll"});
				}
			
			});
			/*LabelInput*/
			/******************************************************/			
			$(".label_input_container").focusin(function(){
				$(this).find(".label").addClass("label_small");
				$(".date").datepicker({
					changeMonth: true,
					changeYear: true
				});
			});
	
			$(".label_input_container").focusout(function(){
				var inputID = $(this).find(".input").attr("id");
				
				setTimeout(function(){
					if($("#"+inputID).val() == ""){
						$("#"+inputID+"_label").removeClass("label_small");
					}
					$(".date").datepicker("destroy");
				}, 400);
			});
															
			/*Select list*/
			/******************************************************/
			
			$("#brick_project_code").click(function(){
				if(selectedBrickID != ""){
					$("#project_code_select_list li").remove();
					$(".projectCodeBox").each(function(index){
						var projectCode = $(this).find(".projectCode").html();
						var projectDesc = $(this).find(".projectDesc").html();
						$("#project_code_select_list").append("<li class='project_code'>"+projectCode+" ("+projectDesc+")</li>");
					});
					
					if($("#project_code_select_list").css("display") == "block"){
						$("#project_code_select_list").removeClass("show_list");
					} else {
						$("#project_code_select_list").addClass("show_list");
					}
				} else {
					alert("Please select a brick!");
				}
			});
			
			$(document).on("click",".task_activity", function (){
				var selectedProjectCode = $("#brick_project_code").val();
				var taskBrickID = $(this).parent().parent().parent().attr("class");
				var taskID = $(this).parent().parent().parent().attr("id");
				
				taskBrickID = taskBrickID.split(" ");
				taskBrickID = taskBrickID[2].replace("_task","");
				var projectCode = $("#project_code_"+taskBrickID).val();
				projectCode = projectCode.split(" ");
				projectCode = projectCode[0];
				
				var projectActivities = $("#project_"+projectCode).find(".projectActivity");
				
				switch(selectedProjectCode){
					case "":
						$("#brick_project_code").addClass("red_bg");
						setTimeout(function(){
							$("#brick_project_code").removeClass("red_bg");
						}, 2000);
						break;
					
					default:
						$("#activity_list_"+taskID+" li").remove();
						projectActivities.each(function(index){
							var activity = $(this).html();
							$("#activity_list_"+taskID).append("<li style='font-size: 14px !important;' class='project_activity white_font'>"+activity+"</li>");
						});
						
						if($("#activity_list_"+taskID).css("display") == "block"){
							$("#activity_list_"+taskID).removeClass("show_list");
						} else {
							$("#activity_list_"+taskID).addClass("show_list");
						}
				}

			});
			
			$("#brick_project_code").focusout(function(){
				setTimeout(function(){
					$("#project_code_select_list").removeClass("show_list");
				}, 200);
			});
			
			$(document).on("focusout",".task_activity", function (){
				var taskID = $(this).parent().parent().parent().attr("id");
				setTimeout(function(){
					$("#activity_list_"+taskID).removeClass("show_list");
				}, 200);
			});		
			 
			$(document).on("click",".select_list li", function (){
				var listItemType = $(this).attr("class");
				var listItemType = listItemType.split(" ");
				var selectedValue = $(this).html();
				
				switch(listItemType[0]){
					case "project_code":
						$("#project_code_"+selectedBrickID).val(selectedValue);
						$("#brick_project_code").val(selectedValue);
						break;
					case "project_activity":
						var parentID = $(this).parent().attr("id");
						parentID = parentID.split("_");
						$("#task_activity_"+parentID[3]).val(selectedValue);
						$("#task_activity_"+parentID[3]).attr("value",selectedValue);
						break;
				}
			});
						 					
			/**************************************************/
			$("#responsive_menu_btn").click(function(){
				$("#nav_wrapper").toggle();
			});

			$("#close_menu").click(function(){
				$("#nav_wrapper").css("display","none")();
			});

			$(document).on("click",".card",function(){
				var title = $(this).find(".title").html();
				var description = $(this).find(".book_description").val();
				var author = $(this).find(".author").html();
				var author_biography = $(this).find(".author_biography").val();
				$('.book_title').html(title);
				$('.book_description').html(description);
				$('.modal_author').html('About the author');
				$('.author_biography').html(author_biography);

				$('.overlay').css('display','block');
				$('.modal').css('display','block');
				
				var modalHeight = $('.modal_content').height();
				$('.modal').height(modalHeight+150);
			});
			
			$(".close_modal").click(function(){
				$('.overlay').css('display','none');
				$('.modal').css('display','none');
			});
			
			$(".input").on("keyup", function() {
				var id = $(this).attr("id");
				id = id.replace("_heading_input","");
				var value = $(this).val().toLowerCase();
				
				if(id == "title"){
					$("."+id).filter(function() {
						if($(this).text().toLowerCase().indexOf(value) > -1){
							$(this).parent().parent().parent().parent().parent().parent().show();
						} else {
							$(this).parent().parent().parent().parent().parent().parent().hide();
						}
					});
				}
				
				$("."+id).filter(function() {
					if($(this).text().toLowerCase().indexOf(value) > -1){
						$(this).parent().parent().parent().parent().show();
					} else {
						$(this).parent().parent().parent().parent().hide();
					}
				});
			});	

			$(".filter_btn").click(function(){
				var id = $(this).attr("id");
				id = id = id.replace("_sort","");
				var dataString = "id="+id;
				
				$.ajax({
					type: 'post',
					url: 'functions/fetch_data.php',
					data: dataString,
					beforeSend: function(){},
					success: function(data){
						if(id == "author"){
							$("#isbn_heading_input").prop( "disabled", true );
							$("#genres_heading_input").prop( "disabled", true );
							$("#isbn_heading_input").parent().css("background","#ccc");
							$("#genres_heading_input").parent().css("background","#ccc");
							$("#author_heading_input").prop( "disabled", false );
							$("#author_heading_input").parent().css("background","none");
							$("#title_heading_input").prop( "disabled", false );
							$("#title_heading_input").parent().css("background","none");
						}
						if(id == "book"){
							$("#author_heading_input").prop( "disabled", false );
							$("#author_heading_input").parent().css("background","none");
							$("#isbn_heading_input").prop( "disabled", false );
							$("#isbn_heading_input").parent().css("background","none");
							$("#genres_heading_input").prop( "disabled", false );
							$("#genres_heading_input").parent().css("background","none");
						}
						if(id == "Genre"){
							$("#isbn_heading_input").prop( "disabled", true );
							$("#isbn_heading_input").parent().css("background","#ccc");
							$("#author_heading_input").prop( "disabled", true );
							$("#author_heading_input").parent().css("background","#ccc");
							$("#genres_heading_input").prop( "disabled", false );
							$("#genres_heading_input").parent().css("background","none");
						}
						$("#activity_table").html(data);
						
						$("#activity_table").html(data);
					}
				});
			});
			
			$("#logout").click(function(){
				var dataString = "";
				
				$.ajax({
					type: 'post',
					url: 'functions/log_out.php',
					data: dataString,
					beforeSend: function(){},
					success: function(data){
						window.location.href = "";
					}
				});
			});
			
			$("#show_admin").click(function(){
				window.location.href = "admin";
			});
	});