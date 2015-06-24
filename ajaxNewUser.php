<?php
include_once './functions.php';
include_once './db.php';

/*
if(isset($_POST['action'])) {
    $action = $_POST['action'];

		switch($action) {
			case 1: 
			echo userNameCheck();
			break;
			case 2: 
			echo formSubmit();
			break;
				break;
			default:
				die('Access denied for this function!');
		}	
}


 function userNameCheck (){if(!empty($_POST['username'])){
	include_once('db.php');
	
	$username = mysqli_real_escape_string($db, trim($_POST['username']));
	$dup = mysqli_query($db,"SELECT username FROM users WHERE username='".$username."'");
	
	if(mysqli_num_rows($dup) <1){
	   echo '<span style="color:green">'.$username.' is good!</span>';}
	   else{ echo '<span  style="color:red; font-weight:bold">'.$username.' is in use.</span>'; }
	
}

}
*/

	
	$error_msg = "";
	
	if(isSet($_POST['username']) && isSet($_POST['p'])){
		
	$username = mysqli_real_escape_string($db, trim($_POST['username']));
	$fname = mysqli_real_escape_string($db, trim($_POST['fname']));
	$lname = mysqli_real_escape_string($db, trim($_POST['lname']));
	$email = mysqli_real_escape_string($db, trim($_POST['email']));
	$pass = mysqli_real_escape_string($db, trim($_POST['p']));
	
	$query = mysqli_query($db,'SELECT * FROM users WHERE email = "'.$email.'" LIMIT 1');
	$numrows = mysqli_num_rows($query);
	
	if($numrows == 1 ){
		$error_msg = "<span style='color:red;'> Error: email is already registered.</span>";
		$query->close();
		}
		
		$query = mysqli_query($db, 'SELECT * FROM users WHERE username = "'.$username.'"LIMIT 1');
		$numrows = mysqli_num_rows($query);
			
	if($numrows == 1){
		$error_msg = "<span style='color:red;'> Error: username is already registered.</span>";
		$query->close();
		}
	
	if(empty($error_msg)){
		$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
		$password = hash('sha512', $pass . $random_salt);
		$time = "NOW()";
		
		$insert_stmt = $db-> prepare('INSERT INTO users (first_name,last_name,username,email,password, salt, registration_date) VALUES (?,?,?,?,?,?,?)');
		$insert_stmt->bind_param('ssssssi', $fname, $lname, $username, $email, $password, $random_salt, $time);
		
		if(!$insert_stmt->execute()){
			$error_msg = "<span style='color:red;'> There was a database error</span>";
		}else{
			 header('Location: ./logIn.php');
			
		}
		
	}
		
	}

	/*$prep_stmt =  "Select id From users Where email = ? LIMIT 1";
	$stmt = mysqli_stmt_prepare($db, $prep_stmt);
	
	//check if this email already exists
	if($stmt){
		mysqli_stmt_bind_param($stmt, 's', $email);
		mysqli_stmt_execute($stmt);
		mysqli_store_result($stmt);
		
		if(mysqli_num_rows($stmt) == 1){
			$error_msg = "<span style='color:red;'>A user with this email address already exists.</span>";
			mysqli_stmt_close($stmt);
		}
		mysqli_stmt_close($stmt);
		
	}else{$error_msg = '<span style="color:red;">There was an error</span>';
                mysqli_stmt_close($stmt);}
				
		//check if username exists
	$prep_stmt = "SELECT id FROM users WHERE UserName = ? LIMIT 1";
   $stmt = mysqli_stmt_prepare($db, $prep_stmt);
	
	if($stmt){
		mysqli_stmt_bind_param($stmt, 's', $username);
		mysqli_stmt_execute($stmt);
		mysqli_store_result($stmt);
		
		if(mysqli_num_rows($stmt) == 1){
			$error_msg = "<span style='color:red;'>A user with this Username  already exists.</span>";
			mysqli_stmt_close($stmt);
		}
		mysqli_stmt_close($stmt);
		
	}else{$error_msg = '<span style="color:red;">There was an error</span>';
                mysqli_stmt_close($stmt);}
				
 if (empty($error_msg)) {
	 //create a random salt
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
 
        // Create salted password 
        $password = hash('sha512', $password . $random_salt);
 
        // Insert the new user into the database 
        if ($insert_stmt = mysqli_stmt_prepare($db, "INSERT INTO users (INSERT INTO  users(first_name,last_name,username,email,password, salt, registration_date) VALUES (?, ?, ?, ?,?,?, NOW())")) {
            mysqli_stmt_bind_param($insert_stmt, 'ssssss', $fname, $lname, $username, $email, $password, $random_salt);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                $error_msg = "<span style='color:red;'>Something went wrong;</span>";
            }
        }
        header('Location: ./login.php');
    }
}*/

?>