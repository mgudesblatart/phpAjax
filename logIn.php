<!DOCTYPE html>
<?php
include_once './db.php';
include_once './ajaxLogin.php';
include_once './functions.php';
sec_session_start();


if (login_check($db) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<html>
<head>
<title>phpAjax</title>
<link rel="stylesheet" href="css/style.css" />
<script src="js/jquery-1.11.1.min.js"> </script>
<script src ="js/jsFunctions.js"></script>
<script src="js/sha512.js"></script>
<script>
$(document).ready(function(){

$('#logInButton').click(function(){

	var login = logInform(this.form, this.form.email, this.form.password);
	
	if(login){
		
		var p = login[1];
		var email = login[0];
		
		$.post("ajaxLogin.php",{email:email, p:p}, function(data){
			if(data == 1){
				$("#error").html("<span style='color:red'>Invalid credentials! If you are not registered please register <a href='newuser.php'>here</a></span>");
			
			}else if(data == 2){
				$("#error").html("<span style='color:red'>Your password is incorrect!</span>");
			}
			else if(data == 3){
				$("#error").html("<span style='color:red'>You've attempted a login too many times.</span>");
			}
			else if(data != 1||2){
				var url = "./index.php";    
				$(location).attr('href',url);
				//console.log(data);
			}
			else{
				$("#error").html("<span style='color:red'>Something went wrong.</span>");
				
			}
	});
		
		
	}

});

});

</script>
<!--<script>
			$(document).ready(function() {
			
			$("#login").click(function(){
	var username = $("#username").val();
	var password = $("#password").val();
	
	$.post("ajaxLogin.php",{username:username, password:password}, function(data){
			if(data == 1){
				$("#error").html("<span style='color:red'>Invalid credentials! If you are not registered please register <a href='newuser.php'>here</a></span>");
			
			}else if(data == 2){
				$("#error").html("<span style='color:red'>Your password is incorrect!</span>");
			}
			else if(data != 1||2){
				$("#error").html(data);
				$("body").load("index.php").hide().fadeIn(1500).delay(6000);
				//console.log(data);
			}
			else{
				$("#error").html("<span style='color:red'>Something went wrong.</span>");
				
			}
	});
	
	
});
			
				
			});
		</script>--->
</head>
<body>
<div id="container">
<?php
		echo "<p>Today is " . date("m/d/Y") . "</p>";
		
       
        ?> 
<div id="loginbox">
	<form action="logIn.php" method="post" name="logIn" >
	<input name="email" id="email" type="text" placeholder="your email" />
	<br />
	<input name="password" id="password" type="password" placeholder="your password" />
	<br />
	<input type="button" value="Log In" id="logInButton" /> 
	
	</form>
	<div id="error"><?php
        if (!empty($error_msg)) {
            echo $error_msg ;
        }
        ?></div><br />
		<div id="logged">
		<h4>Currently logged <?php echo $logged ?>.</h4>
				<p>If you are finished with your session, <br />please <a href="./logout.php">log out</a>.</p>
		</div>
		
	<div id="register">Not yet registered? Please register <a href="./newUser.php">here.</a></div>
</div>
</div>
</body>
</html>