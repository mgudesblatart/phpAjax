<?php
include_once 'db.php';
include_once 'functions.php';
sec_session_start();

$_SESSION['LAST_ACTIVITY'] = time(); 

if(isSet($_POST['email'])&&isSet($_POST['p'])){
	
$error_msg = "<span style='color:red;'> email and password went through.</span>";
$email = mysqli_real_escape_string($db, trim($_POST['email']));
$pass = mysqli_real_escape_string($db, trim($_POST['p']));

//$query = mysqli_query($db, "SELECT * FROM agents WHERE PEmail='".$email."'");
//$numrows = mysqli_num_rows($query);

if($stmt = $db->prepare("SELECT id, UserName, Password, salt FROM agents WHERE PEmail = ? LIMIT 1"))
{
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();
$stmt->num_rows();
$stmt->bind_result($user_id, $username, $db_password, $salt);
$stmt->fetch();

$password = hash('sha512', $pass . $salt);
if($stmt->num_rows == 1){	
	/*while($row = mysqli_fetch_array($query)){
		
		$dbusername = $row['username'];
		$dbpass = $row['password'];
		$dbfirstname = $row['first_name'];
		$salt = $row['salt'];
		$password = hash('sha512', $pass . $salt);
		$user_id=$row['id'];
		}*/
		$error_msg = "<span style='color:red;'> email matches database email</span>";
		 if (checkbrute($user_id, $db) == true) {
                // Account is locked 
                // Send an email to user saying their account is locked
				$_SESSION["loginerror"] = 2;
				//$error_msg = "<span style='color:red;'> Too many attempts!</span>";
                echo 3;
				return false;
		 }
	if($db_password == $password){
		$error_msg = "<span style='color:red;'> passwords match</span>";
		  $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
                                                                "", 
                                                                $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', 
                     $password . $user_browser);
					 
                    // Login successful
					
				return true;
					
	}else{
		 $now = time();
         $db->query("INSERT INTO login_attempts(user_id, time) VALUES ('$user_id', '$now')");
			//$error_msg = "<span style='color:red;'> Invalid Credentials! invalid password</span>";
			echo 2;
	}
	

}else{
	//$error_msg = "<span style='color:red;'> Invalid Credentials! invalid email</span>";
	echo 1;
}
}
}


/*if($_SERVER['REQUEST_METHOD'] == 'POST'){
	
//create condition to check if there is 1 row with that email

if($numrows != 0){

//grab the email and password from that row returned before

	while($row = mysqli_fetch_array($query)){
		
		$dbusername = $row['username'];
		$dbpass = $row['password'];
		$dbfirstname = $row['first_name'];
		$salt = $row['salt'];
		$pass = hash('sha512', $password. $salt);
		}
	
//create condition to check if email and password are equal to the returned row	
	
	if($username==$dbusername){
		if($pass==$dbpass){
		
		echo "<p>Welcome ".$dbfirstname.", you are in! You will be redirected to the control panel in 3 seconds...</p>";
		$_SESSION['login_user']=$dbusername;
			
		
		}else{
		
			echo 2 ;
		
		}
	}
}else{
echo 1;

}

}*/
?>