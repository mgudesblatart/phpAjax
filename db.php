<?php

$host = "localhost"; 
	$username = "srgUser"; 
	$password = "5THEsrgNet5"; 
	$db_name = "srg_portal";  
	
	define("HOST", "localhost");     // The host you want to connect to.
	define("USER", "srgUser");    // The database username. 
	define("PASSWORD", "5THEsrgNet5");    // The database password. 
	define("DATABASE", "srg_portal");    // The database name.
	define("CAN_REGISTER", "any");
	define("DEFAULT_ROLE", "member");
	define("SECURE", FALSE);

$db = new mysqli(HOST, USER, PASSWORD, DATABASE);

mysqli_set_charset($db, "utf-8");




?>