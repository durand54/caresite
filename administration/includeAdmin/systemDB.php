<?php
//require_once('adminInc/configOS.php');

class systemDB{
			

	function getLogin($username,$password){
	global $db;
	global $d;
	$subscriber = $db->get("SELECT *, max(enddate) subscription_enddate FROM user as u, accesslevel as a where u.UserName = '$username' and u.Password = '$password' and  u.SubscriberID=a.SubscriberID group by u.subscriberid");
			if($subscriber){
    		while(list($key,$value) = each($subscriber)){
    		$user = $value['UserName'];
    		$pass = $value['Password'];
			echo "THIS IS USER<br />$user";
    		}
    		}
			unset($subscriber);	
		
	}
	
	function getAdminLogin($username,$password){
			global $db;
			global $d;
			$result = '';
			$administrator = $db->get("SELECT * FROM administrators where username = '$username' and password = '$password'");
			if($administrator){
			
    		while(list($key,$value) = each($administrator)){
    		$result = $value['id'];
    		setcookie("adm",$result);
			
    		}
    		}
			unset($administrator);	
			//echo "THIS IS ID $result<br />";
			return $result;
		
	}
}
?>
