<?php
ini_set('display_errors','On');

date_default_timezone_set('America/Los_Angeles');

require_once('eapInc/configOS.php');
$makeID = mysql_escape_string($_GET['m']);
$makeID2 = $makeID;
$cID = $_COOKIE['cid'];
if(!$cID){
$target3 = 'http://eap.rcomcreative.com/Login';
header('Location:'.$target3);
}

$cbgid = 1;
$start_year = 1987;
$max = $db->get("SELECT MAX(SalesYear) AS MaxYear FROM salesforecast WHERE SalesValue > 0");
if($max){
	while(list($key,$value) = each($max)){
	$end_year = $value['MaxYear'];
	}
}
$makeArray = array();
$competitiveMakesOne = $db->get("SELECT * from  vehicles as v where v.makeid='$makeID' and v.cbgid='$cbgid' and DeleteFlag=0 order by v.VehicleName ");
$carArray = array();

if($competitiveMakesOne){
			while(list($key,$value)= each($competitiveMakesOne)){
			$vID = $value['VehicleID'];
			$vName = $value['VehicleName'];
			$car = array($vID,$vName);
			array_push($carArray,$car);
			}
}
$counter = count($carArray);
for($i=0;$i<$counter;$i++){
	$car = $carArray[$i][0];
	$carName = $carArray[$i][1];
	echo "<br /><br />this is CAR $carName<br />";
	$competitiveMakes = $db->get("select * from vehiclebattlegroundcycle where VehicleID = '$car' and LineYear >= $start_year and LineYear <= $end_year");
			if($competitiveMakes){
    		while(list($key2,$value2) = each($competitiveMakes)){
    		$lineYear = $value2['LineYear'];
    		$cycleText = $value2['CycleText'];
    		echo "$lineYear - $cycleText<br />";
    		$makeModel = array($car=>$lineYear,$cycleText);
    		array_push($makeArray,$makeModel);
    		}
    		}
}
/*if($competitiveMakes){
    		while(list($key,$value) = each($competitiveMakes)){
    		$vehicleID = $value['VehicleID'];
    		$lineYear = $value['LineYear'];
    		$cycleText = $value['CycleText'];
    		$makeModel = array($vehicleID,$lineYear,$cycleText);
    		array_push($makeArray,$makeModel);
    		}
    		}
unset($competitiveMakes);



$logoArray = array();
$logoMake = $db->get("SELECT * from brandlogo WHERE makeid = '$makeID2'");
if($logoMake){
	while(list($key,$value) = each($logoMake)){
			$brandLogoID = $value['BrandLogoID'];
			$categoryItemID = $value['CategoryItemID'];
    		$logoFileName = $value['LogoFileName'];
    		}
}
unset($logoMake);


$countCM = count($makeArray);
$makeArray2 = $makeArray;
$makeArray3 = $makeArray;
$counter = floor($countCM/7);
$remainder = $countCM % 7;


for($i=0;$i<$remainder;$i++){
	array_pop($makeArray);
}

$counted = $countCM-$remainder;

for($e=0;$e<$counted;$e++){
	array_shift($makeArray2);
}


$p = 7;
$t = 0;

$arraySet = '';
$arraySet .= "<div class='logoBrand $makeID2'><img src='/img/logos/$logoFileName' alt='$brandLogoID $categoryItemID $makeID2' /></div>";
for($e = 0;$e<$counted;$e++){
	$j = $e%7;
	
	$makeID = $makeArray[$e][0];
	$vehicleID = $makeArray[$e][1];
	$vehicleName = $makeArray[$e][2];
	$lineYear = $makeArray[$e][3];
	$cycleText = $makeArray[$e][4];
	
	switch ($j) {
	case "0":
	if($e == 0){
	$arraySet .= "<div class='arrayBoxes northAmericanArrayBoxes1'>\n";
	} else {
	$arraySet .= "<div class='arrayBoxes northAmericanArrayBoxes'>\n";
	}
	$arraySet .=<<<TAX
<div class="button" data-filter="$vehicleID" title="$makeID">$vehicleName $lineYear  $cycleText</div>
		<div class='clear'></div>
TAX;
	break;
	case "1":
	$arraySet .=<<<TAX
<div class="button" data-filter="$vehicleID" title="$makeID">$vehicleName $lineYear  $cycleText</div>
		<div class='clear'></div>
TAX;
	break;
	case "2":
	$arraySet .=<<<TAX
<div class="button" data-filter="$vehicleID" title="$makeID">$vehicleName $lineYear  $cycleText</div>
		<div class='clear'></div>
TAX;
	break;
	case "3":
	$arraySet .=<<<TAX
<div class="button" data-filter="$vehicleID" title="$makeID">$vehicleName $lineYear  $cycleText</div>
		<div class='clear'></div>
TAX;
	break;
	case "4":
	$arraySet .=<<<TAX
<div class="button" data-filter="$vehicleID" title="$makeID">$vehicleName $lineYear  $cycleText</div>
		<div class='clear'></div>
TAX;
	break;
	case "5":
	$arraySet .=<<<TAX
<div class="button" data-filter="$vehicleID" title="$makeID">$vehicleName $lineYear  $cycleText</div>
		<div class='clear'></div>
TAX;
	break;
	case "6":
	$arraySet .=<<<TAX
<div class="button" data-filter="$vehicleID" title="$makeID">$vehicleName $lineYear  $cycleText</div>
		<div class='clear'></div>
		</div>
		
TAX;
	break;
	}
}

if($remainder != 0){
	$arraySet .= "<div class='arrayBoxes northAmericanArrayBoxes'>\n";
	for($k = 0; $k<$remainder;$k++){
	
	
	$make = $makeArray2[$k][2];
	$makeID = $makeArray2[$k][0];
	
	$arraySet .=<<<TAX
<div class="button" data-filter="$vehicleID" title="$makeID">$vehicleName $lineYear  $cycleText</div>
		<div class='clear'></div>
TAX;
	
	}
	$arraySet .= "</div>\n";
}
echo $arraySet;*/
?>