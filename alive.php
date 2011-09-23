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

echo "OK";
?>