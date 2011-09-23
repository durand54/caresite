<?php
ini_set('display_errors','On');
session_start();
date_default_timezone_set('America/Los_Angeles');


require_once('eapInc/configOS.php');



$usr =  mysql_escape_string($_POST['uName']);
$id =  mysql_escape_string($_POST['pass']);


$client = $db->get("SELECT *, max(enddate) subscription_enddate FROM user as u, accesslevel as a where u.UserName = '$usr' and u.Password = '$id' and  u.SubscriberID=a.SubscriberID group by u.subscriberid");
    		if($client){
    		while(list($key,$value) = each($client)){
    		$fName = $value['FirstName'];
    		$lName = $value['LastName'];
    		$cID = $value['UserID'];
    		
    		$hello = "eAutoPacific";
    		
		$sessionName = session_id();

		$date = date("Y-m-d");
		setcookie('day',$date,0,'/','eap.rcomcreative.com');
		$time = date("G.i");
		setcookie('last',$time,0,'/','eap.rcomcreative.com');
		setcookie('cid',$cID,0,'/','eap.rcomcreative.com');
		
		$userArray = array(
		'UserID' => $cID,
		'SessionID' => $sessionName,
		'DayIn' => $date,
		'TimeIn' => $time,
		'Logged' => 'LOG'
		);
		$sessions = 'session';
		$db->save($userArray,$sessions,'SessionID');
    		echo $hello;
    		} 
    		
    		} else {
    		echo 'You either submitted the wrong user name or the wrong pass code';
    		}
    		
    		
    		


?>