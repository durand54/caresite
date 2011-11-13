<?php

ini_set('display_errors','On');
session_start();
date_default_timezone_set('America/Los_Angeles');

$cID = $_COOKIE['cid'];
$time = date("G.i");
$sessionID = session_id();
$userArray = array(
	'TimeOut' => $time,
	'UserID'=>$cID,
	'SessionID'=>$sessionID
);
require_once('eapInc/configOS.php');

		$sessions = 'session';
		$db->save($userArray,$sessions,'SessionID');
		echo "you have been logged out!";	
 $sessionName = session_id();
  $sessionCookie = session_get_cookie_params();
	function logout(){
    $_SESSION = array(); 
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_unset();
    session_destroy();
    $time2 = date("Y");
    setcookie("day","",time()-3600,'/','eap.rcomcreative.com');
    setcookie("last","",time()-3600,'/','eap.rcomcreative.com');
    setcookie('cid',"",time()-3600,'/','eap.rcomcreative.com');
    //setcookie("day","2011-07-06",0,'/','.preinit.com');
    unset($_COOKIE['day']); 
    unset($_COOKIE['last']);
    unset($_COOKIE['cid']);
    
}

logout();


?>
