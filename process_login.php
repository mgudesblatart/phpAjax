<?php
include_once 'db.php';
include_once 'ajaxLogin.php';
sec_session_start();

$_SESSION['LAST_ACTIVITY'] = time(); 
if(isSet($_POST['email'])&&isSet($_POST['p'])){
	
$error_msg = "<span style='color:red;'> email and password went through.</span>";
$email = mysqli_real_escape_string($db, trim($_POST['email']));
$pass = mysqli_real_escape_string($db, trim($_POST['p']));
if (login($email, $pass, $db) == true) {
        // Login success 
        header('Location: ./index.php');
		exit();
		
    } else {
      echo "<span style='color:red;'> something is horribly wrong</span>";
	  exit();
    }
}
?>