<!DOCTYPE html>
<?php
error_reporting(1);

if($_SERVER['REQUEST_METHOD']=='POST'){
		include_once('db.php');
	$username = mysqli_real_escape_string($db, trim($_POST['username']));
	$fname = mysqli_real_escape_string($db, trim($_POST['fname']));
	$lname = mysqli_real_escape_string($db, trim($_POST['lname']));
	$email = mysqli_real_escape_string($db, trim($_POST['email']));
	$password = mysqli_real_escape_string($db, hash(sha512, $_POST['password']));
	$password2 = mysqli_real_escape_string($db, hash(sha512, $_POST['password2']));
	

		if(!empty($fname) && !empty ($lname) && !empty($username) && !empty($email) && !empty($password) && !empty($password2)){
		
		if($password == $password2){
			
		 	mysqli_query($db, "INSERT INTO  users(first_name,last_name,username,email,password,registration_date) VALUES('$fname','$lname','$email','$username','$password', NOW())");
		 
			$registered = mysqli_affected_rows($db);

		$result = $registered." row is affected, everything works!";
		
		}else{ $result = "<p style='color: red'>Error: passwords do not match</p>";}
		
		}else{
		
					$result = "<p style='color: red'>Error: Please complete all fields</p>";
		 
				}
	
}else{
			$result = "<h2>Please complete the form</h2>";}


?>
<html>
<head>
<title>New User Registration</title>
<link rel="stylesheet" href="css/style.css" />
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
</head>
<body>
<div id="container">
		<form action="newUserorig.php" method="post">

		<p>First Name: <input type="text" name="fname" size="20" maxlength="50" /></p>
		<p>Last Name: <input type="text" name="lname" size="20" maxlength="50" /></p>
		<p>Username: <input type="text" name="username" size="20" maxlength="50" /></p>
		<p>Email: <input type="text" name="email" size="20" maxlength="50" /></p>
		<p>Password: <input type="password" name="password" maxlength="20"> </p>
		<p>Confirm Pass: <input type="password" name="password2" maxlength="20"> </p>
		<p><input type="submit" name="submit" value="Submit" /></p>
		
	</form>
	<div id="error"><?php echo $result ?></div><br />
	<p><a href="index.php">Go back to login form</a></p>
</div>
</body>

</html>