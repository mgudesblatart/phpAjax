<?php

function checkbrute($user_id, $db) {
    // Get timestamp of current time 
    $now = time();
 
    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);
 
    if ($stmt = $db->prepare("SELECT time 
                             FROM login_attempts 
                             WHERE user_id = ? 
                            AND time > '".$valid_attempts."'")) {
        $stmt->bind_param('i', $user_id);
 
        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();
 
        // If there have been more than 5 failed logins 
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}
function login_check($db) {
	//global $user;
    // Check if all session variables are set 
    if (isset($_SESSION['user_id'], 
                        $_SESSION['username'], 
                        $_SESSION['login_string'])) {
 
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
 
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt = $db->prepare("SELECT Password 
                                      FROM agents 
                                      WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
 
                if ($login_check == $login_string) {
                    // Logged In!!!! 
					//get/set session vars for main user info to returned array
					$_SESSION['user'] = initUser($user_id, $db);
					
					$_SESSION['AgentID'] = $_SESSION['user']['id'];
					$_SESSION['Level'] = $_SESSION['user']['Level'];
					$_SESSION['LAST_ACTIVITY'] = time();
					$RemoteIP = getenv('REMOTE_ADDR');
					
					//insert timestamp
					if ($insert = $db->prepare("UPDATE agents SET LastLogin = NOW(), RemoteIP = ? WHERE id = ?")) {
						$insert->bind_param('si', $RemoteIP, $_SESSION['AgentID']);
						$insert->execute();
					}
					
					
					//get session var for user notices
					//$_SESSION['notices'] = getNotices($user_id);
					
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Not logged in 
            return false;
        }
    } else {
        // Not logged in 
        return false;
    }
}

function initUser($user_id, $db){	//return data from NPN lookup
		
		$sql_getAgent = "SELECT * FROM agents WHERE id = '".$user_id."'";
		
		//$result = mysql_query($sql);
		$aResult = $db->query($sql_getAgent);
		//$user = mysql_fetch_array($result); 
		$user = $aResult->fetch_array();
		
		return $user;
}
function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
	ob_start();
    session_start();            // Start the PHP session 
    session_regenerate_id(true);    // regenerated the session, delete the old one. 
}
?>