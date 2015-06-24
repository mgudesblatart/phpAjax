<?php

include_once './db.php';
include_once './functions.php';
sec_session_start();

/*if(empty($_SESSION['login_user']))
{
header('Location: logIn.php');
}*/

	
	
	if(login_check($db) == true ) {
	//set all vars for session
	$user = (isset ($_SESSION['user']) ? $_SESSION['user'] : null);
	$_SESSION['NPN'] = (isset ($user['NPN']) ? $user['NPN'] : null);
	$_SESSION['AgentID'] = (isset ($user['id']) ? $user['id'] : null);
	$_SESSION['Level'] = (isset ($user['Level']) ? $user['Level'] : null);
	//set static
	static $message = "";
	
	//set local vars for session data
	$NPN = (isset ($_SESSION['NPN']) ? $_SESSION['NPN'] : null);
	$AgentID = (isset ($_SESSION['AgentID']) ? $_SESSION['AgentID'] : null);
	$level = (isset ($_SESSION['Level']) ? $_SESSION['Level'] : null);	
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Welcome <?= $user["FirstName"] ?> <?= $user["LastName"] ?> </title>
<link rel="stylesheet" href="css/style.css"/>
<script src="js/jquery-1.11.1.min.js"> </script>
<script>
/*test vars for console output*/
	console.log("Agent ID = <?= $AgentID ?>");
	console.log("NPN = <?= $NPN ?>");
	console.log("level = <?= $level ?>");
</script>
</head>
<body>
<div id="container">
<h1>Welcome to Home Page</h1>
<p>Enjoy your stay <?= $user["FirstName"] ?></p>
<p><ul>
Here are some of the things we know about you:
				<li>Your user NPN is <?=$NPN ?></li>
				<li>Your user ID is <?= $AgentID ?></li>
				<li>Your user Level is <?= $level ?></li>
				
				
</ul></p>
<a href="logout.php">Logout</a>
</div>
 <?php
 
 if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    header( 'Location:includes/logout.php' ) ;
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

?>
<?php 
//end of main if
}
	 else {
	header( 'Location:login.php' ) ;
    exit();	
	} 
 ?> 
</body>
</html>