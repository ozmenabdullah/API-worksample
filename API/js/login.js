//Document ready.
$(document).ready(function(){

	//Clear username field.
	$('#userName').click(function(){
		$('#loginMsg').html("");
	});
	
	//Clear password field.
	$('#userPass').click(function(){
		$('#loginMsg').html("");
	});
	
	//AJAX login function
	$('#login_frm').submit(function(event){
		event.preventDefault();
		var username=$("#username").val();
		var password=$("#password").val();
		if(username == "" || password == ""){
			$('#loginMsg').html("Lütfen gerekli bilgileri doldurunuz!");
			return false;
		} else{
			var dataString = 'username='+username+'&password='+password;
			$.ajax({
				type: "post",
				url: "functions/validate_user.php",
				data: dataString,
				cache: false,
				beforeSend: function(){ $("#login").val('Validating, please wait...');},
				success: function(data){
					if(data == "1"){
						window.location.href = "admin";
					} else {
						$("#login_msg").html("<span>Wrong username or password!</span>");
						$("#login").val('SIGN IN');
					}
				}
			});
		}
		event.preventDefault();
	});
});