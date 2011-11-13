<?php
ini_set('display_errors','On');

date_default_timezone_set('America/Los_Angeles');

//config file
require_once('eapInc/configOS.php');

//fed in through .htaccess vehicleID
$vID = mysql_escape_string($_GET['n']);
$eng = mysql_escape_string($_GET['e']);




$vID2 = $vID;
$cbgid = 1;
$specificationHeight = 0;

//check that user is signed in
$cID = $_COOKIE['cid'];
if(!$cID){
$target3 = 'http://eap.rcomcreative.com/Login';
header('Location:'.$target3);
}
$competitiveMakesOne = $db->get("SELECT * from  vehicles as v, segment as s where v.VehicleID='$vID' and v.cbgid='$cbgid' and s.segmentid = v.segmentid and DeleteFlag=0 and ActiveFlag='1' order by v.VehicleName ");
$carArray = array();
//call vehicle
if($competitiveMakesOne){
			while(list($key,$value)= each($competitiveMakesOne)){
			$vID = $value['VehicleID'];
			$vName = $value['VehicleName'];
			$sName = $value['name'];
			$car = array($vID,$vName);
			array_push($carArray,$car);
			}
}
unset($competitiveMakesOne);
//photo call
$mainVehiclePhoto = $db->get("SELECT * from vehiclephoto where VehicleID = $vID AND MainFlag = '1'");
if($mainVehiclePhoto){
			while(list($key,$value)= each($mainVehiclePhoto)){
			$LargeVehiclePhoto = $value['LargeFileName'];
			$MediumVehiclePhoto = $value['MediumFileName'];
			$SmallVehiclePhoto = $value['SmallFileName'];
			$PhotoCaption = $value['PhotoCaption'];
			}
}
unset($mainVehiclePhoto);

//vehicleDimesion call
$vehicleDimensionsArray = array();
$lifeCycle = '';
$vehicleDimensions = $db->get("SELECT * FROM `vehicledimension` WHERE `VehicleID` = '$vID' AND DeleteFlag = '0'");
if($vehicleDimensions){
			while(list($key,$value)= each($vehicleDimensions)){
				$plannedLifeCycle = $value['PlannedLifeCycle'];
				$bodyStyleDimensions = $value['VariationName'];
				$oah = $eng== 1 ? toEnglish($value['OAH']):$value['OAH'].' mm';
				$oaw = $eng== 1 ? toEnglish($value['OAW']):$value['OAW'].' mm';
				$oal = $eng== 1 ? toEnglish($value['OAL']):$value['OAL'].' mm';
				$wb = $eng== 1 ? toEnglish($value['WB']):$value['WB'].' mm';
				$array = array($plannedLifeCycle,$bodyStyleDimensions,$oah,$oaw,$oal,$wb);
				array_push($vehicleDimensionsArray,$array);
			}
}
$counted = count($vehicleDimensionsArray);
$bodyStyleDimensions = '';
$wheelBaseDimensions = '';
$overallLengthDimensions = '';
$overallWidthDimensions = '';
$overallHeightDimensions = '';
$bodyStyleDimensionsArray = array();
$body4DimensionsArray = array();
$value1 = '';
//planned life cycle
for($e=0;$e<$counted;$e++){
	if(isset($vehicleDimensionsArray[$e][0])){
	$value1 = $vehicleDimensionsArray[$e][0];
	}
	switch ($e) {
	case 0:
	if($value1 != ''){
	$specificationHeight = $specificationHeight+24;
				$lifeCycle .=<<<LIF
				<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Planned Life Cycle</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				<div class='specificationsBox4Text'>$value1</div>
				</div>
				</div>
LIF;
				}
	
	break;
				}



//setting up the bodyStyle Dimensions
	$value2 = $vehicleDimensionsArray[$e][1];
	array_push($bodyStyleDimensionsArray,$value2);
	
//setting up the wheelbase,overall length,height,width
	$wheelbase = $vehicleDimensionsArray[$e][5];
	$overallLength = $vehicleDimensionsArray[$e][4];
	$overallWidth = $vehicleDimensionsArray[$e][3];
	$overallHeight = $vehicleDimensionsArray[$e][2];
	$array = array($wheelbase,$overallLength,$overallWidth,$overallHeight);
	array_push($body4DimensionsArray,$array);
}
	if($value1 == ''){
	
	$specificationHeight = $specificationHeight+24;
	
	$lifeCycle .=<<<LIF
				<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Planned Life Cycle</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				</div>
				</div>
LIF;
	}
unset($vehicleDimensionsArray);	
//building Bodystyle/Dimensions
$counted = count($bodyStyleDimensionsArray);
$count = $counted % 2;
$counter = $counted-$count;

switch ($count) {
	case 0:
	


if($counted != 0){
	$h = $counted/2;
	$specificationHeight = ($specificationHeight+120)*$h;
	$bodyStyleDimensions .=<<<BSD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Bodystyle/Dimensions</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox3'>
BSD;
	$wheelBaseDimensions .=<<<WBD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Wheelbase</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox3'>	
WBD;
	$overallLengthDimensions .=<<<OLD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Overall Length</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox3'>
OLD;
	$overallWidthDimensions .=<<<OWD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Overall Width</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox3'>	
OWD;
	$overallHeightDimensions .=<<<OHD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Overall Height</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox3'>	
OHD;
for($k=0;$k<$counted;$k++){
	
	
	
	
	$bodyStyle = $bodyStyleDimensionsArray[$k];
	$wheelBase = $body4DimensionsArray[$k][0];
	$overallLength = $body4DimensionsArray[$k][1];
	$overallWidth = $body4DimensionsArray[$k][2];
	$overallHeight = $body4DimensionsArray[$k][3];
$bodyStyleDimensions .=<<<SDE
	<div class='split'>
	<div class='specificationsBox4Text'>$bodyStyle</div>
	</div>
SDE;
$wheelBaseDimensions .=<<<WEB
<div class='split'>
	<div class='specificationsBox4Text'>$wheelBase</div>
	</div>
WEB;
$overallLengthDimensions .=<<<OLD
<div class='split'>
	<div class='specificationsBox4Text'>$overallLength</div>
	</div>
OLD;
$overallWidthDimensions .=<<<OWD
<div class='split'>
	<div class='specificationsBox4Text'>$overallWidth</div>
	</div>
OWD;
$overallHeightDimensions .=<<<OWD
<div class='split'>
	<div class='specificationsBox4Text'>$overallHeight</div>
	</div>
OWD;
}
$bodyStyleDimensions .= "</div>\n</div>\n";
$wheelBaseDimensions .= "</div>\n</div>\n";
$overallLengthDimensions .= "</div>\n</div>\n";
$overallWidthDimensions .= "</div>\n</div>\n";
$overallHeightDimensions .= "</div>\n</div>\n";
} else {
if($counted == 0){

	$specificationHeight = $specificationHeight+120;
	$bodyStyleDimensions .=<<<BSD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Bodystyle/Dimensions</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				</div>
				</div>
BSD;
	$wheelBaseDimensions .=<<<WBD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Wheelbase</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				</div>
				</div>	
WBD;
	$overallLengthDimensions .=<<<OLD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Overall Length</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				</div>
				</div>
OLD;
	$overallWidthDimensions .=<<<OWD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Overall Width</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				</div>
				</div>
OWD;
	$overallHeightDimensions .=<<<OHD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Overall Height</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				</div>
				</div>
OHD;
}
}
	break;
	case '1':
	$h = ceil($counted/2);
	$specificationHeight = ($specificationHeight+120)*$h;
	$bodyStyleDimensions .=<<<BSD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Bodystyle/Dimensions</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox3'>
BSD;
	$wheelBaseDimensions .=<<<WBD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Wheelbase</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox3'>	
WBD;
	$overallLengthDimensions .=<<<OLD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Overall Length</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox3'>
OLD;
	$overallWidthDimensions .=<<<OWD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Overall Width</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox3'>	
OWD;
	$overallHeightDimensions .=<<<OHD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Overall Height</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox3'>	
OHD;
for($k=0;$k<$counted;$k++){
	$bodyStyle = $bodyStyleDimensionsArray[$k];
	
	$wheelBase = $body4DimensionsArray[$k][0];
	$overallLength = $body4DimensionsArray[$k][1];
	$overallWidth = $body4DimensionsArray[$k][2];
	$overallHeight = $body4DimensionsArray[$k][3];
	
$bodyStyleDimensions .=<<<SDE
	<div class='split'>
	<div class='specificationsBox4Text'>$bodyStyle</div>
	</div>
SDE;


$wheelBaseDimensions .=<<<WEB
<div class='split'>
	<div class='specificationsBox4Text'>$wheelBase</div>
	</div>
WEB;
$overallLengthDimensions .=<<<OLD
<div class='split'>
	<div class='specificationsBox4Text'>$overallLength</div>
	</div>
OLD;
$overallWidthDimensions .=<<<OWD
<div class='split'>
	<div class='specificationsBox4Text'>$overallWidth</div>
	</div>
OWD;
$overallHeightDimensions .=<<<OWD
<div class='split'>
	<div class='specificationsBox4Text'>$overallHeight</div>
	</div>
OWD;

}
$bodyStyleDimensions .=<<<SDE
	<div class='split'>
	<div class='specificationsBox4Text'>&nbsp;</div>
	</div>
SDE;

$wheelBaseDimensions .=<<<SDE
	<div class='split'>
	<div class='specificationsBox4Text'>&nbsp;</div>
	</div>
SDE;

$overallLengthDimensions .=<<<SDE
	<div class='split'>
	<div class='specificationsBox4Text'>&nbsp;</div>
	</div>
SDE;

$overallWidthDimensions .=<<<SDE
	<div class='split'>
	<div class='specificationsBox4Text'>&nbsp;</div>
	</div>
SDE;


$overallHeightDimensions .=<<<SDE
	<div class='split'>
	<div class='specificationsBox4Text'>&nbsp;</div>
	</div>
SDE;
$bodyStyleDimensions .= "</div>\n</div>\n";

$wheelBaseDimensions .= "</div>\n</div>\n";
$overallLengthDimensions .= "</div>\n</div>\n";
$overallWidthDimensions .= "</div>\n</div>\n";
$overallHeightDimensions .= "</div>\n</div>\n";

	break;
	case '2':
	$h = ceil($counted/2);
	$specificationHeight = ($specificationHeight+120)*$h;
	$bodyStyleDimensions .=<<<BSD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Bodystyle/Dimensions</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox3'>
BSD;


	$wheelBaseDimensions .=<<<WBD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Wheelbase</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox3'>	
WBD;
	$overallLengthDimensions .=<<<OLD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Overall Length</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox3'>
OLD;
	$overallWidthDimensions .=<<<OWD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Overall Width</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox3'>	
OWD;
	$overallHeightDimensions .=<<<OHD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Overall Height</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox3'>	
OHD;

for($k=0;$k<$counted;$k++){
	$bodyStyle = $bodyStyleDimensionsArray[$k];
	
	
	
	$wheelBase = $body4DimensionsArray[$k][0];
	$overallLength = $body4DimensionsArray[$k][1];
	$overallWidth = $body4DimensionsArray[$k][2];
	$overallHeight = $body4DimensionsArray[$k][3];
$bodyStyleDimensions .=<<<SDE
	<div class='split'>
	<div class='specificationsBox4Text'>$bodyStyle</div>
	</div>
SDE;



$wheelBaseDimensions .=<<<WEB
<div class='split'>
	<div class='specificationsBox4Text'>$wheelBase</div>
	</div>
WEB;
$overallLengthDimensions .=<<<OLD
<div class='split'>
	<div class='specificationsBox4Text'>$overallLength</div>
	</div>
OLD;
$overallWidthDimensions .=<<<OWD
<div class='split'>
	<div class='specificationsBox4Text'>$overallWidth</div>
	</div>
OWD;
$overallHeightDimensions .=<<<OWD
<div class='split'>
	<div class='specificationsBox4Text'>$overallHeight</div>
	</div>
OWD;


}

$bodyStyleDimensions .=<<<SDE
	<div class='split'>
	<div class='specificationsBox4Text'>&nbsp;</div>
	</div>
SDE;

$bodyStyleDimensions .=<<<SDE
	<div class='split'>
	<div class='specificationsBox4Text'>&nbsp;</div>
	</div>
SDE;

$wheelBaseDimensions .=<<<SDE
	<div class='split'>
	<div class='specificationsBox4Text'>&nbsp;</div>
	</div>
SDE;

$overallLengthDimensions .=<<<SDE
	<div class='split'>
	<div class='specificationsBox4Text'>&nbsp;</div>
	</div>
SDE;

$overallWidthDimensions .=<<<SDE
	<div class='split'>
	<div class='specificationsBox4Text'>&nbsp;</div>
	</div>
SDE;


$overallHeightDimensions .=<<<SDE
	<div class='split'>
	<div class='specificationsBox4Text'>&nbsp;</div>
	</div>
SDE;
$bodyStyleDimensions .= "</div>\n</div>\n";


$wheelBaseDimensions .= "</div>\n</div>\n";
$overallLengthDimensions .= "</div>\n</div>\n";
$overallWidthDimensions .= "</div>\n</div>\n";
$overallHeightDimensions .= "</div>\n</div>\n";
	break;
	default:

	}
	
//call and build of seats
$seat = '';
$seats = '';
$vehicleSeat = $db->get("SELECT * from  vehicles as v, seat as s, vehicleseat as vs where v.VehicleID='$vID' and vs.vehicleid='$vID' and s.seatid = vs.seatid");
if($vehicleSeat){
			while(list($key,$value)= each($vehicleSeat)){
				$seat = $value['seats'];
				
			}
}
unset($vehicleSeat);
if($seat != ''){
	
	$specificationHeight = $specificationHeight+24;
	
$seats .=<<<BSD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Seating Capacity</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				<div class='specificationsBox4Text'>$seat</div>
				</div>
				</div>
BSD;

} else {
	
	$specificationHeight = $specificationHeight+24;
	
$seats .=<<<BSD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Seating Capacity</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				</div>
				</div>
BSD;
}
//call curb weight range and check for height of specification1box
$curbWeightRangeA = '';
$curbWeightRangeB = '';
$vehicleCurbWeight = '';
$curbWeight = $db->get("SELECT * from  vehiclecurbweightrange as v where v.VehicleID='$vID' AND DeleteFlag = '0'");
if($curbWeight){
	while(list($key,$value)= each($curbWeight)){
		$vehicleCurbWeight = $value['CurbWeightRange'];
	}
}
unset($curbWeight);
if($vehicleCurbWeight != ''){
if($specificationHeight>239){

$curbWeightRangeB .=<<<BSD
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Curb Weight Range</div>
				</div>
				<div id='specificationsBox6'>
				<div class='splitBox'>
				<div class='specificationsBox6Text'>$vehicleCurbWeight</div>
				</div>
				</div>
BSD;
} else {

	$specificationHeight = $specificationHeight+24;
	
$curbWeightRangeA .=<<<BSD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Curb Weight Range</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				<div class='specificationsBox4Text'>$vehicleCurbWeight</div>
				</div>
				</div>
BSD;

}

} else {
if($specificationHeight>239){
$curbWeightRangeB .=<<<BSD
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Curb Weight Range</div>
				</div>
				<div id='specificationsBox6'>
				<div class='splitBox'>
				<div class='specificationsBox6Text'>&nbsp;</div>
				</div>
				</div>
BSD;
} else {

	$specificationHeight = $specificationHeight+24;
	
$curbWeightRangeA .=<<<BSD
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Curb Weight Range</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				<div class='specificationsBox4Text'>&nbsp;</div>
				</div>
				</div>
BSD;

}
}

//build engine boxes and check height to move into specificationsBox2

$vehicleEngineA = '';
$vehicleEngineB = '';
$vehicleEngineArray = array();
$vehicleEngines = $db->get("SELECT * FROM  vehicleengine WHERE VehicleID = '$vID' AND DeleteFlag = '0'");

if($vehicleEngines){
	while(list($key,$value)= each($vehicleEngines)){
		$engine = $value['Engine'];
		array_push($vehicleEngineArray,$engine);
	}
}
unset($vehicleEngines);
$count = count($vehicleEngineArray);
if($count != 0){
if($specificationHeight>239){
$vehicleEngineB .=<<<VEA
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Engines</div>
				</div>
				<div id='specificationsBox6'>
VEA;
for($w=0;$w<$count;$w++){
$engine = $vehicleEngineArray[$w];
$vehicleEngineB .=<<<VEA
				<div class='splitBox'>
				<div class='specificationsBox6Text'>$engine</div>
				</div>
VEA;
}
$vehicleEngineB .="</div>\n";
} else {


	$specificationHeight = $specificationHeight+24;
$vehicleEngineA .=<<<VEA
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Engines</div>
				</div>
				<div id='specificationsBox4'>
VEA;
for($w=0;$w<$count;$w++){
$engine = $vehicleEngineArray[$w];
$vehicleEngineA .=<<<VEA
				<div class='splitBox'>
				<div class='specificationsBox4Text'>$engine</div>
				</div>
VEA;
}
$vehicleEngineA .="</div>\n";
}
} else {
if($specificationHeight>239){
$vehicleEngineB .=<<<VEA
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Engines</div>
				</div>
				<div id='specificationsBox6'>
				<div class='splitBox'>
				<div class='specificationsBox6Text'>&nbsp;</div>
				</div>
				</div>
VEA;
} else {


	$specificationHeight = $specificationHeight+24;
$vehicleEngineA .=<<<VEA
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Engines</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				<div class='specificationsBox4Text'>&nbsp;</div>
				</div>
				</div>
VEA;
}
}

//build drive configuration plus add height if necessary to box

$driveConfigurationA = '';
$driveConfigurationB = '';
$driveConfigurationArray = array();
$driveConfiguration = $db->get("SELECT * FROM  drive as d, vehicledrive as vd, vehicles as v WHERE vd.VehicleID = '$vID' and vd.VehicleID = v.VehicleID and d.driveid = vd.driveid AND v.DeleteFlag = '0'");

if($driveConfiguration){
	while(list($key,$value)= each($driveConfiguration)){
		$drive = $value['name'];
		array_push($driveConfigurationArray,$drive);
	}
}
unset($driveConfiguration);
$count = count($driveConfigurationArray);
if($count !=0){
if($specificationHeight>239){
$driveConfigurationB .=<<<VEA
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Drive Configuration</div>
				</div>
				<div id='specificationsBox6'>
VEA;
for($w=0;$w<$count;$w++){
$drive = $driveConfigurationArray[$w];
$driveConfigurationB .=<<<VEA
				<div class='splitBox'>
				<div class='specificationsBox6Text'>$drive</div>
				</div>
VEA;
}
$driveConfigurationB .="</div>\n";
} else {


	$specificationHeight = $specificationHeight+24;
$driveConfigurationA .=<<<VEA
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Drive Configuration</div>
				</div>
				<div id='specificationsBox4'>
VEA;
for($w=0;$w<$count;$w++){
$drive = $driveConfigurationArray[$w];
$driveConfigurationA .=<<<VEA
				<div class='splitBox'>
				<div class='specificationsBox4Text'>$drive</div>
				</div>
VEA;
}
$driveConfigurationA .="</div>\n";
}
} else {
if($specificationHeight>239){
$driveConfigurationB .=<<<VEA
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Drive Configuration</div>
				</div>
				<div id='specificationsBox6'>
				<div class='splitBox'>
				<div class='specificationsBox6Text'>&nbsp;</div>
				</div>
				</div>
VEA;
} else {


	$specificationHeight = $specificationHeight+24;
$driveConfigurationA .=<<<VEA
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Drive Configuration</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				<div class='specificationsBox4Text'>&nbsp;</div>
				</div>
				</div>
VEA;
}
}

//build transmissions
$transmissionA = '';
$transmissionB = '';
$transmissionArray = array();
$transmission = $db->get("SELECT * FROM  transmission as t, vehicletransmission as vt, vehicles as v WHERE v.VehicleID = '$vID' and vt.VehicleID = v.VehicleID and t.transmissionid = vt.transmissionid AND v.DeleteFlag = '0'");

if($transmission){
	while(list($key,$value)= each($transmission)){
		$tAbbrev = $value['abbrev'];
		$tName = $tAbbrev." ".$value['name'];
		array_push($transmissionArray,$tName);
	}
}
unset($transmission);
$count = count($transmissionArray);
if($count !=0){
if($specificationHeight>239){
$transmissionB .=<<<VEA
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Transmission</div>
				</div>
				<div id='specificationsBox6'>
VEA;
for($w=0;$w<$count;$w++){
$transmission = $transmissionArray[$w];
$transmissionB .=<<<VEA
				<div class='splitBox'>
				<div class='specificationsBox6Text'>$transmission</div>
				</div>
VEA;
}
$transmissionB .="</div>\n";
} else {


	$specificationHeight = $specificationHeight+24;
$transmissionA .=<<<VEA
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Transmission</div>
				</div>
				<div id='specificationsBox4'>
VEA;
for($w=0;$w<$count;$w++){
$transmission = $transmissionArray[$w];
$transmissionA .=<<<VEA
				<div class='splitBox'>
				<div class='specificationsBox4Text'>$transmission</div>
				</div>
VEA;
}
$transmissionA .="</div>\n";
}
} else {
if($specificationHeight>239){
$transmissionB .=<<<VEA
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Transmission</div>
				</div>
				<div id='specificationsBox6'>
				<div class='splitBox'>
				<div class='specificationsBox6Text'>&nbsp;</div>
				</div>
				</div>
VEA;
} else {


	$specificationHeight = $specificationHeight+24;
$transmissionA .=<<<VEA
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Transmission</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				<div class='specificationsBox4Text'>&nbsp;</div>
				</div>
				</div>
VEA;
}
}




//build suspensions
$suspensionA = '';
$suspensionB = '';
$suspensionArray = array();
$suspension = $db->get("SELECT * FROM  vehiclesuspension as vs, vehicles as v WHERE v.VehicleID = '$vID' and vs.VehicleID = v.VehicleID AND v.DeleteFlag = '0'");

if($suspension){
	while(list($key,$value)= each($suspension)){
		$front = $value['FrontSuspension'];
		$rear =  $value['RearSuspension'];
		$array = array($front,$rear);
		array_push($suspensionArray,$array);
	}
}
unset($suspension);
$count = count($suspensionArray);
if($count !=0){
if($specificationHeight>239){
$suspensionB .=<<<VEA
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Suspension</div>
				</div>
				<div class='clear'></div>
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Front</div>
				</div>
				<div id='specificationsBox6'>
VEA;
for($w=0;$w<$count;$w++){
$suspension = $suspensionArray[$w][0];
$suspensionB .=<<<VEA
				<div class='splitBox'>
				<div class='specificationsBox6Text'>$front</div>
				</div>
VEA;
}
$suspensionB .='</div>';
$suspensionB .=<<<VEA
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Rear</div>
				</div>
				<div id='specificationsBox6'>
VEA;
for($w=0;$w<$count;$w++){
$suspension = $suspensionArray[$w][1];
$suspensionB .=<<<VEA
				<div class='splitBox'>
				<div class='specificationsBox6Text'>$rear</div>
				</div>
VEA;
}

$suspensionB .='</div>';
} else {

$specificationHeight = $specificationHeight+24;
$suspensionA .=<<<VEA
	<div id='specificationsBox3'>
				<div class='specificationsBox53ext'>Suspension</div>
				</div>
				<div class='clear'></div>
	<div id='specificationsBox3'>
	<div class='specificationsBox3Text'>Front</div>
				</div>
				<div id='specificationsBox4'>
VEA;
for($w=0;$w<$count;$w++){
$suspension = $suspensionArray[$w][0];
$suspensionA .=<<<VEA
				<div class='splitBox'>
				<div class='specificationsBox4Text'>$front</div>
				</div>
VEA;
}

$suspensionA .='</div>';
$suspensionA .=<<<VEA
<div class='clear'></div>
<div id='specificationsBox3'>
	<div class='specificationsBox3Text'>Rear</div>
				</div>
				<div id='specificationsBox4'>
VEA;
for($w=0;$w<$count;$w++){
$suspension = $suspensionArray[$w][1];
$suspensionA .=<<<VEA
				<div class='splitBox'>
				<div class='specificationsBox4Text'>$rear</div>
				</div>
VEA;
}

$suspensionA .='</div>';

}
 
} else {
if($specificationHeight>239){
$suspensionB .=<<<VEA
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Suspension</div>
				</div>
				<div class='clear'></div>
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Front</div>
				</div>
				<div id='specificationsBox6'>
				<div class='splitBox'>
				<div class='specificationsBox6Text'>&nbsp;</div>
				</div>
				</div>
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Rear</div>
				</div>
				<div id='specificationsBox6'>
				<div class='splitBox'>
				<div class='specificationsBox6Text'>&nbsp;</div>
				</div>
				</div>
VEA;
} else {


	$specificationHeight = $specificationHeight+24;
$suspensionA .=<<<VEA
<div id='specificationsBox3'>
				<div class='specificationsBox53ext'>Suspension</div>
				</div>
				<div class='clear'></div>
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Front</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				<div class='specificationsBox4Text'>&nbsp;</div>
				</div>
				</div>

<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Rear</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				<div class='specificationsBox4Text'>&nbsp;</div>
				</div>
				</div>
VEA;
}
}

//build tires
$tireA = '';
$tireB = '';
$tireArray = array();
$tire = $db->get("SELECT * FROM  vehicletiresize as vt, vehicles as v WHERE v.VehicleID = '$vID' and vt.VehicleID = v.VehicleID AND v.DeleteFlag = '0'");

if($tire){
	while(list($key,$value)= each($tire)){
		$tireSize = $value['TireSize'];
		array_push($tireArray,$tireSize);
	}
}
unset($tire);
$count = count($tireArray);
if($count !=0){
if($specificationHeight>239){
$tireB .=<<<VEA
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Tire Size</div>
				</div>
				<div id='specificationsBox6'>
VEA;
for($w=0;$w<$count;$w++){
$tire = $tireArray[$w];
$tireB .=<<<VEA
				<div class='splitBox'>
				<div class='specificationsBox6Text'>$tire</div>
				</div>
VEA;
}
$tireB .="</div>\n";
} else {


	$specificationHeight = $specificationHeight+24;
$tireA .=<<<VEA
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Tire Size</div>
				</div>
				<div id='specificationsBox4'>
VEA;
for($w=0;$w<$count;$w++){
$tire = $tireArray[$w];
$tireA .=<<<VEA
				<div class='splitBox'>
				<div class='specificationsBox4Text'>$tire</div>
				</div>
VEA;
}
$tireA .="</div>\n";
}
} else {
if($specificationHeight>239){
$tireB .=<<<VEA
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Tire Size</div>
				</div>
				<div id='specificationsBox6'>
				<div class='splitBox'>
				<div class='specificationsBox6Text'>&nbsp;</div>
				</div>
				</div>
VEA;
} else {


	$specificationHeight = $specificationHeight+24;
$tireA .=<<<VEA
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Tire Size</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				<div class='specificationsBox4Text'>&nbsp;</div>
				</div>
				</div>
VEA;
}
}

//build priceRanges
$priceRangeA = '';
$priceRangeB = '';
$priceRangeArray = array();
$price = $db->get("SELECT * FROM  vehiclepricerange as vpr, vehicles as v WHERE v.VehicleID = '$vID' and vpr.VehicleID = v.VehicleID AND v.DeleteFlag = '0'");
if($price){
	while(list($key,$value)= each($price)){
		$priceRange1 = $value['Low'];
		$priceRange2 = $value['High'];
		if($priceRange2 != ''){
		$priceRange = $priceRange1." - ".$priceRange2;
		} else {
		$priceRange = $priceRange1;
		}
		array_push($priceRangeArray,$priceRange);
	}
}
unset($price);
$count = count($priceRangeArray);
if($count !=0){
if($specificationHeight>239){
$priceRangeB .=<<<VEA
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Base Price Range</div>
				</div>
				<div id='specificationsBox6'>
VEA;
for($w=0;$w<$count;$w++){
$priceRange = $priceRangeArray[$w];
$priceRangeB .=<<<VEA
				<div class='splitBox'>
				<div class='specificationsBox6Text'>$priceRange</div>
				</div>
VEA;
}
$priceRangeB .="</div>\n";
} else {


	$specificationHeight = $specificationHeight+24;
$priceRangeA .=<<<VEA
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Base Price Range</div>
				</div>
				<div id='specificationsBox4'>
VEA;
for($w=0;$w<$count;$w++){
$priceRange = $priceRangeArray[$w];
$priceRangeA .=<<<VEA
				<div class='splitBox'>
				<div class='specificationsBox4Text'>$priceRange</div>
				</div>
VEA;
}
$priceRangeA .="</div>\n";
}
} else {
if($specificationHeight>239){
$priceRangeB .=<<<VEA
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Base Price Range</div>
				</div>
				<div id='specificationsBox6'>
				<div class='splitBox'>
				<div class='specificationsBox6Text'>&nbsp;</div>
				</div>
				</div>
VEA;
} else {


	$specificationHeight = $specificationHeight+24;
$priceRangeA .=<<<VEA
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Base Price Range</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				<div class='specificationsBox4Text'>&nbsp;</div>
				</div>
				</div>
VEA;
}
}

//build startOfProductions
$startOfProductionA = '';
$startOfProductionB = '';
$startOfProductionArray = array();
$start = $db->get("SELECT * FROM  vehiclestartofproduction as vpr, vehicles as v WHERE v.VehicleID = '$vID' and vpr.VehicleID = v.VehicleID AND v.DeleteFlag = '0'");
if($start){
	while(list($key,$value)= each($start)){
		$startOfProduction1 = $value['StartOfProduction'];
		array_push($startOfProductionArray,$startOfProduction1);
	}
}
unset($price);
$count = count($startOfProductionArray);
if($count !=0){
if($specificationHeight>239){
$startOfProductionB .=<<<VEA
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Start of Production</div>
				</div>
				<div id='specificationsBox6'>
VEA;
for($w=0;$w<$count;$w++){
$startOfProduction = $startOfProductionArray[$w];
$startOfProductionB .=<<<VEA
				<div class='splitBox'>
				<div class='specificationsBox6Text'>$startOfProduction</div>
				</div>
VEA;
}
$startOfProductionB .="</div>\n";
} else {


	$specificationHeight = $specificationHeight+24;
$startOfProductionA .=<<<VEA
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Start of Production</div>
				</div>
				<div id='specificationsBox4'>
VEA;
for($w=0;$w<$count;$w++){
$startOfProduction = $startOfProductionArray[$w];
$startOfProductionA .=<<<VEA
				<div class='splitBox'>
				<div class='specificationsBox4Text'>$startOfProduction</div>
				</div>
VEA;
}
$startOfProductionA .="</div>\n";
}
} else {
if($specificationHeight>239){
$startOfProductionB .=<<<VEA
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Start of Production</div>
				</div>
				<div id='specificationsBox6'>
				<div class='splitBox'>
				<div class='specificationsBox6Text'>&nbsp;</div>
				</div>
				</div>
VEA;
} else {


	$specificationHeight = $specificationHeight+24;
$startOfProductionA .=<<<VEA
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Start of Production</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				<div class='specificationsBox4Text'>&nbsp;</div>
				</div>
				</div>
VEA;
}
}

//build salesLaunchs
$salesLaunchA = '';
$salesLaunchB = '';
$salesLaunchArray = array();
$start = $db->get("SELECT * FROM  vehiclesaleslaunch as vpr, vehicles as v WHERE v.VehicleID = '$vID' and vpr.VehicleID = v.VehicleID AND v.DeleteFlag = '0'");
if($start){
	while(list($key,$value)= each($start)){
		$salesLaunch1 = $value['SalesLaunch'];
		array_push($salesLaunchArray,$salesLaunch1);
	}
}
unset($price);
$count = count($salesLaunchArray);
if($count !=0){
if($specificationHeight>239){
$salesLaunchB .=<<<VEA
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Sales Launch</div>
				</div>
				<div id='specificationsBox6'>
VEA;
for($w=0;$w<$count;$w++){
$salesLaunch = $salesLaunchArray[$w];
$salesLaunchB .=<<<VEA
				<div class='splitBox'>
				<div class='specificationsBox6Text'>$salesLaunch</div>
				</div>
VEA;
}
$salesLaunchB .="</div>\n";
} else {


	$specificationHeight = $specificationHeight+24;
$salesLaunchA .=<<<VEA
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Sales Launch</div>
				</div>
				<div id='specificationsBox4'>
VEA;
for($w=0;$w<$count;$w++){
$salesLaunch = $salesLaunchArray[$w];
$salesLaunchA .=<<<VEA
				<div class='splitBox'>
				<div class='specificationsBox4Text'>$salesLaunch</div>
				</div>
VEA;
}
$salesLaunchA .="</div>\n";
}
} else {
if($specificationHeight>239){
$salesLaunchB .=<<<VEA
<div id='specificationsBox5'>
				<div class='specificationsBox5Text'>Sales Launch</div>
				</div>
				<div id='specificationsBox6'>
				<div class='splitBox'>
				<div class='specificationsBox6Text'>&nbsp;</div>
				</div>
				</div>
VEA;
} else {


	$specificationHeight = $specificationHeight+24;
$salesLaunchA .=<<<VEA
<div id='specificationsBox3'>
				<div class='specificationsBox3Text'>Sales Launch</div>
				</div>
				<div id='specificationsBox4'>
				<div class='splitBox'>
				<div class='specificationsBox4Text'>&nbsp;</div>
				</div>
				</div>
VEA;
}
}

$vehicleNamed = $vName." ".$sName;
$stringLength = strlen($vehicleNamed);
$style = '';
$clearing = '';
$carInsights = '';
if($stringLength>40){
	$style = "style='width:1024px;'";
}
$basicBar =<<<BAS
	<div id="specification">
	<div id="carName" $style>$vehicleNamed</div>
	<div class="clear"></div>
	<div class="buttonRule"><div id="buttonBox1" class="basic" data-filter='$vID'>the basics</div><div id="buttonBox2B" class="specifications"  data-filter='$vID'>specifications</div><div id="buttonBox2" class="photos"  data-filter='$vID'>photos</div><div id="buttonBox2" class="overview"  data-filter='$vID'>product overview</div><div id="buttonBox2" class="insights"  data-filter='$vID'>insights</div><div id="buttonBox3" class="print"  data-filter='$vID'>print</div><div id="buttonBox2" class="salesforecast"  data-filter='$vID'>sales forecast</div><div id="english"  class='engspec' data-filter='$vID'>english</div><div id="slantBar"></div><div id="metric" class='metspec' data-filter='$vID'>metric</div></div>
	<div class="clear"></div>
	<div id='accordionBoxTop'>
	<div id='accordionRule'><div id='collapse'>collapse all</div><div id='vertRule'></div><div id='expand'>expand all</div></div>
	</div>
	<div class='clear'></div>
	<div id='specificationsBox'>
	<div id='specificationsBox1'>
	<div class='specificationsBoxHolder'>
	$lifeCycle
	$seats
	$bodyStyleDimensions
	$wheelBaseDimensions
	$overallLengthDimensions
	$overallWidthDimensions
	$overallHeightDimensions
	$curbWeightRangeA
	$vehicleEngineA
	$driveConfigurationA
	$transmissionA
	$suspensionA
	$tireA
	$priceRangeA
	$startOfProductionA
	$salesLaunchA
	</div>
	<div id='specificationPhotoBox'><img src='/img/upload_photos/$MediumVehiclePhoto' alt='$PhotoCaption' width='461px' /></div>
	</div>
	<div class='clear'></div>
	<div id='specificationsBox2'>
	$curbWeightRangeB
	$vehicleEngineB
	$driveConfigurationB
	$transmissionB
	$suspensionB
	$tireB
	$priceRangeB
	$startOfProductionB
	$salesLaunchB
	</div>
	</div>
	</div>
BAS;
$basicBar .=<<<SCR
	<script>
	
			$('.basic').mouseover(function(){
			$('.basic').css('cursor','pointer');
			});
			$('.basic').mouseout(function(){
			$('.basic').css('cursor','default');
			});
			
			$('.basic').click(function(){
			$('.segmentCallout').remove();
			var data = $(this).attr('data-filter');
			var name = $(this).attr('class');
			
			  $.get("index/"+name+"/"+data,function(txt){
			  $('.hello').append("<div class='segmentCallout'>"+txt+"</div>");
			  });
			});
			
			$('.specifications').mouseover(function(){
			$('.specifications').css('cursor','pointer');
			});
			$('.specifications').mouseout(function(){
			$('.specifications').css('cursor','default');
			});
			
			$('.specifications').click(function(){
			$('.segmentCallout').remove();
			var data = $(this).attr('data-filter');
			var name = $(this).attr('class');
			
			  $.get("index/"+name+"/"+data,function(txt){
			  $('.hello').append("<div class='segmentCallout'>"+txt+"</div>");
			  });
			});
			
			$('.photos').mouseover(function(){
			$('.photos').css('cursor','pointer');
			});
			$('.photos').mouseout(function(){
			$('.photos').css('cursor','default');
			});
			
			$('.photos').click(function(){
			$('.segmentCallout').remove();
			var data = $(this).attr('data-filter');
			var name = $(this).attr('class');
			
			  $.get("index/"+name+"/"+data,function(txt){
			  $('.hello').append("<div class='segmentCallout'>"+txt+"</div>");
			  });
			});
			
			$('.overview').mouseover(function(){
			$('.overview').css('cursor','pointer');
			});
			$('.overview').mouseout(function(){
			$('.overview').css('cursor','default');
			});
			
			$('.overview').click(function(){
			$('.segmentCallout').remove();
			var data = $(this).attr('data-filter');
			var name = $(this).attr('class');
			
			
			  $.get("index/"+name+"/"+data,function(txt){
			  $('.hello').append("<div class='segmentCallout'>"+txt+"</div>");
			  });
			});
			
			$('.insights').mouseover(function(){
			$('.insights').css('cursor','pointer');
			});
			$('.insights').mouseout(function(){
			$('.insights').css('cursor','default');
			});
			
			$('.insights').click(function(){
			$('.segmentCallout').remove();
			var data = $(this).attr('data-filter');
			var name = $(this).attr('class');
			
			
			  $.get("index/"+name+"/"+data,function(txt){
			  $('.hello').append("<div class='segmentCallout'>"+txt+"</div>");
			  });
			});
			
			$('.print').mouseover(function(){
			$('.print').css('cursor','pointer');
			});
			$('.print').mouseout(function(){
			$('.print').css('cursor','default');
			});
			
			$('.print').click(function(){
			$('.segmentCallout').remove();
			var data = $(this).attr('data-filter');
			var name = $(this).attr('class');
			
			
			  $.get("index/"+name+"/"+data,function(txt){
			  $('.hello').append("<div class='segmentCallout'>"+txt+"</div>");
			  });
			});
			
			$('.salesforecast').mouseover(function(){
			$('.salesforecast').css('cursor','pointer');
			});
			$('.salesforecast').mouseout(function(){
			$('.salesforecast').css('cursor','default');
			});
			
			$('.salesforecast').click(function(){
			$('.segmentCallout').remove();
			var data = $(this).attr('data-filter');
			var name = $(this).attr('class');
			
			
			  $.get("index/"+name+"/"+data,function(txt){
			  $('.hello').append("<div class='segmentCallout'>"+txt+"</div>");
			  });
			});
			
			$('#english').mouseover(function(){
			$('#english').css('cursor','pointer');
			});
			$('#english').mouseout(function(){
			$('#english').css('cursor','default');
			});
			
			$('#english').click(function(){
			
			$('.segmentCallout').remove();
			var data = $(this).attr('data-filter');
			var name = $(this).attr('class');
			
			
			  $.get("index/"+name+"/"+data,function(txt){
			  $('.hello').append("<div class='segmentCallout'>"+txt+"</div>");
			  });
			});
			
			$('#metric').mouseover(function(){
			$('#metric').css('cursor','pointer');
			});
			$('#metric').mouseout(function(){
			$('#metric').css('cursor','default');
			});
			
			$('#metric').click(function(){
			
			$('.segmentCallout').remove();
			var data = $(this).attr('data-filter');
			var name = $(this).attr('class');
			
			
			  $.get("index/"+name+"/"+data,function(txt){
			  $('.hello').append("<div class='segmentCallout'>"+txt+"</div>");
			  });
			});
			
			$('#collapse').mouseover(function(){
			$('#collapse').css('cursor','pointer');
			});
			
			$('#collapse').mouseout(function(){
			$('#collapse').css('cursor','default');
			});
			
			$('#collapse').click(function(){
			$('.specificationsBoxHolder').slideUp();
			$('#specificationsBox2').slideUp();
			$('#specificationPhotoBox').css('margin-left','482px');
			$('#collapse').css('color','#000000');
			$('#expand').css('color','#B3B3B3');
			});
			
			
			$('#expand').mouseover(function(){
			$('#expand').css('cursor','pointer');
			});
			
			$('#expand').mouseout(function(){
			$('#expand').css('cursor','default');
			});
			
			$('#expand').click(function(){
			$('#collapse').css('color','#B3B3B3');
			$('#expand').css('color','#000000');
			$('.specificationsBoxHolder').slideDown();
			$('#specificationsBox2').slideDown();
			$('#specificationPhotoBox').css('margin-left','12px');
			});
</script>
SCR;
echo $basicBar;
?>