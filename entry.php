<?php
ini_set('display_errors','On');

date_default_timezone_set('America/Los_Angeles');

require_once('eapInc/configOS.php');

session_start();
$date = date("Y-m-d");
$cookie = $_COOKIE['day'];

if($date != $cookie){

$target3 = 'http://eap.rcomcreative.com/Login';
header('Location:'.$target3);
} else {
$timer = $_COOKIE['last'];
$timely = date("G.i");
$timed = $timely-$timer;

if($timed>.20){
$target3 = 'http://eap.rcomcreative.com/Login';
header('Location:'.$target3);
}
}


require_once('eapInc/entryBody.php');

?>
