<?php
ini_set('display_errors','On');
date_default_timezone_set('America/Los_Angeles');

require_once('../../adminInc/configOS.php');


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

$data = preg_replace('~\s+\S+$~', '', $data); 

$content = "\n\n\n $name";
//$data .= $content;
$return['msg'] = $data;
//echo json_encode($return);
$adminID = $_COOKIE['adm'];
$vehicleID = $_COOKIE['vehicleID'];
$date = date("Y-m-d");
$dateTime = date("Y-m-d G:i");

switch($name){
	case 'vehicleKeypoint':$userArray2 = array(
    			'vehicleID' => $vehicleID,
    			'adminID' => $adminID,
    			'entrydate' =>$date,
    			'modified' =>$dateTime,
    			'keypointText' =>$data,
    			'live' => 1	
    			);
		$futureIntel = 'vehicleKeypoint';
	break;
	case 'futureIntl':
    		$userArray2 = array(
    			'vehicleID' => $vehicleID,
    			'adminID' => $adminID,
    			'entrydate' =>$date,
    			'modified' =>$dateTime,
    			'futureIntl' =>$data,
    			'live' => 1
    				
    			);
		$futureIntel = 'vehicleFutureIntel';
		
    break;
    case 'currentGenerationEquipmentUpdates':
    $userArray2 = array(
    			'vehicleID' => $vehicleID,
    			'adminID' => $adminID,
    			'entrydate' =>$date,
    			'modified' =>$dateTime,
    			'currentGenerationEquipmentUpdates' =>$data,
    			'live' => 1
    				
    			);
		$futureIntel = 'vehicleCGEquipUpdates';
		
	break;
	case 'vehicleCGLaunchInfo':
	$userArray2 = array(
    			'vehicleID' => $vehicleID,
    			'adminID' => $adminID,
    			'entrydate' =>$date,
    			'modified' =>$dateTime,
    			'currentGenerationLaunchInfo' =>$data,
    			'live' => 1
    				
    			);
		$futureIntel = 'vehicleCGLaunchInfo';
		
	break;
	case 'vehiclePriorGenerationInfo':
	$userArray2 = array(
    			'vehicleID' => $vehicleID,
    			'adminID' => $adminID,
    			'entrydate' =>$date,
    			'modified' =>$dateTime,
    			'priorGenerationInfo' =>$data,
    			'live' => 1
    				
    			);
		$futureIntel = 'vehiclePriorGenerationInfo';

	break;
	case 'vehicleConfigPowerTrainProfile':
	
	$userArray2 = array(
    			'vehicleID' => $vehicleID,
    			'adminID' => $adminID,
    			'entrydate' =>$date,
    			'modified' =>$dateTime,
    			'vehicleConfigPowerTrainProfile' =>$data,
    			'live' => 1
    				
    			);
		$futureIntel = 'vehicleConfigPowerTrainProfile';
	break;
	case 'vehicleAutoPacificsTake':
	
	$userArray2 = array(
    			'vehicleID' => $vehicleID,
    			'adminID' => $adminID,
    			'entrydate' =>$date,
    			'modified' =>$dateTime,
    			'autopacificsTake' =>$data,
    			'live' => 1
    				
    			);
		$futureIntel = 'vehicleAutoPacificsTake';
	
	break;
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
$db->save($userArray2,$futureIntel,'vehicleID');
?>