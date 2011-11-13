<?php


class systemDB{
	function getLogin($username,$password){
		$query="SELECT *, max(enddate) subscription_enddate ";
		$query.="FROM user as u, accesslevel as a  ";
		$query.="where u.UserName = '$username' and u.Password = '$password' ";
		$query.="and  u.SubscriberID=a.SubscriberID group by u.subscriberid ";
		$result=db::executeQuery($query);
		return $result;
	}
	
	function getAdminLogin($username,$password){
		$query="SELECT * FROM administrators where username = '$username' and password = '$password'";
		$result=db::executeQuery($query);
		return $result;
		
	}
}
?>
