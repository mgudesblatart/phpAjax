<!DOCTYPE html>
<?php 
include_once './db.php';
include_once './ajaxNewUser.php';
include_once './functions.php';
?>
<html>
<head>
<title>New User Registration</title>
<link rel="stylesheet" href="css/style.css" />
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/jsFunctions.js"></script>
<script type="text/javascript" src="js/sha512.js"></script>

<body>
<div id="container">
	
<form action="newUser.php" method="post" name="userRegistrationForm">
		<p>First Name: <input type="text" name="fname" id='fname' size="20" maxlength="50" /></p>
		<p>Last Name: <input type="text" name="lname" id='lname'  size="20" maxlength="50" /></p>
		<p>Username: <input type="text" name="username" id='username'  size="20" maxlength="50" /><br />
				<div id="usernameCheck"></div></p>
		<p>Email: <input type="text" name="email" size="20" id='email'  maxlength="50" /></p>
		<p>Password: <input type="password" name="password" id='password'  maxlength="20"> </p>
		<p>Confirm Pass: <input type="password" name="password2" id='password2'  maxlength="20"> </p>
		 <input type="button" 
                   value="Register" 
                   onclick="return userRegistration(this.form,
									this.form.fname,
									this.form.lname,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.password2);" /> 
		</form>
		<div id="error" style="margin-top: 10px;"><?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?></div><br />
	<a href="index.php">Go back to login form</a>
</div>
</body>

</html>