<?php
ini_set('display_errors','On');
date_default_timezone_set('America/Los_Angeles');

require_once('eapInc/configOS2.php');


$data = $_POST['input']; // $json is a string
//$future = json_decode($json); // $person is an array with a key 'name'

function lastWord($sentence) {
// Break the sentence into its component words:
$words = explode(' ', $sentence);
// Get the last word and trim any punctuation:
$result = trim($words[count($words) - 1], '.?![](){}*');
// Return a result:
return $result;
}


$name = lastWord($data);
list($name, $vehicleID,$subscriber) = explode(":", $name);
$data = preg_replace('~\s+\S+$~', '', $data); 
//$yourTakeTextID = '';
/*$isYourTake = $db->get("SELECT * FROM vehicleYourTake WHERE vehicleID ='$vID' AND subscribersID ='$cID' AND entrydate='$date'");
			if($isYourTake){
				while(list($key,$value) = each($isYourTake)){
    			$yourTakeTextID= $value['ID'];
    		}
    		}
			unset($isYourTake);*/

//$content = "\n\n\n $yourTakeTextID";
//$data .= "<br />".$name."<br />".$vehicleID."<br />".$subscriber;
$return['msg'] = $data;
//echo json_encode($return);
//$adminID = $_COOKIE['cid'];
//$vehicleID = $_COOKIE['vehicleID'];
$date = date("Y-m-d");
$dateTime = date("Y-m-d G:i");
$data .="  $date";
//echo $data."<br />".$name."<br />".$vehicleID."<br />".$subscriber;
/*$autoIncrement = $db->get("SELECT * FROM vehicleYourTake WHERE vehicleYourTake.ID IS NOT NULL");
if($autoIncrement){
				while(list($key,$value) = each($autoIncrement)){
    			$auto = $value['ID'];
    		}
    		}
			unset($autoIncrement);
$increment = number_format($auto+1);

$yourTakeTextID = '';
$isYourTake = $db->get("SELECT * FROM vehicleYourTake WHERE vehicleID ='$vID' AND subscribersID ='$cID' AND entrydate='$date'");
			if($isYourTake){
				while(list($key,$value) = each($isYourTake)){
    			$yourTakeTextID= $value['ID'];
    		}
    		}
			unset($isYourTake);
if($yourTakeTextID != ''){
switch($name){
	case 'vehicleYourTake':
	
	$userArray2 = array(
    			'vehicleID' => $vehicleID,
    			'subscribersID' => $adminID,
    			'entrydate' =>$date,
    			'modified' =>$dateTime,
    			'yourTake' =>$data,
    			'live' => 1
    				
    			);
		$futureIntel = 'vehicleYourTake';
	
	break;
	
	}*/
$id = '';
$name = 'vehicleYourTake';
$state = mysql_query("SELECT * FROM $name WHERE vehicleID = '$vehicleID' AND subscribersID = '$subscriber' and entrydate= '$date'");
if ($state != '') {
while($a = mysql_fetch_object($state)) {
	$id = $a->ID;
	//$data = $data;
$sql = mysql_query("UPDATE  $name SET yourTake = '$data', modified = '$dateTime' WHERE  ID = '$id'");
 }
 }

$return['msg'] = $data; 
if($id == ''){
 $sql = "INSERT INTO $name SET
    		vehicleID = '$vehicleID',
    		subscribersID = '$subscriber',
    		entrydate = '$date',
    		modified = '$dateTime',
    		yourTake = '$data',
    		live = '1'";
    		if (@mysql_query($sql)) {
		  echo ( "Thank You $value[1] <br />");
		   } else {
		   echo mysql_error();
		   }
 }
/*$db->saveComment($userArray2,$futureIntel,'vehicleID','subscribersID','entrydate');
} else {
switch($name){
	case 'vehicleYourTake':
	$userArray2 = array(
    			'vehicleID' => $vehicleID,
    			'subscribersID' => $adminID,
    			'entrydate' =>$date,
    			'modified' =>$dateTime,
    			'yourTake' =>$data,
    			'live' => 1
    				
    			);
		$futureIntel = 'vehicleYourTake';
	
	break;
	
	}
$db->save($userArray2,$futureIntel,$increment);

}*/
?>