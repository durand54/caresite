<?php
ini_set('display_errors','On');
require_once('eapInc/configOS.php');

$cbgid = 1;
$makeArray = array();
$competitiveMakes = $db->get("SELECT distinct m.* from make as m, service as sv, makeservice ms, vehicles as v where sv.cbgid=$cbgid and sv.serviceid = ms.serviceid and ms.makeid = m.makeid and v.makeid = m.makeid and v.ActiveFlag = 1 order by m.name");
if($competitiveMakes){
    		while(list($key,$value) = each($competitiveMakes)){
    		$makeID = $value['makeid'];
    		$manufactureID = $value['manufactureid'];
    		$makeName = $value['name'];
    		$makeModel = array($makeID,$manufactureID,$makeName);
    		array_push($makeArray,$makeModel);
    		}
    		}
unset($competitiveMakes);

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

for($e = 0;$e<$counted;$e++){
	$j = $e%7;
	
	$make = $makeArray[$e][2];
	$makeID = $makeArray[$e][0];
	
	switch ($j) {
	case "0":
	if($e == 0){
	$arraySet .= "<div class='arrayBoxes northAmericanArrayBoxes1'>\n";
	} else {
	$arraySet .= "<div class='arrayBoxes northAmericanArrayBoxes'>\n";
	}
	$arraySet .=<<<TAX
<div class="button  $makeID" title="$make">
		<div class="buttonCenterM2">$make</div>
		</div>
		<div class='clear'></div>
TAX;
	break;
	case "1":
	$arraySet .=<<<TAX
<div class="button  $makeID" title="$make">
		<div class="buttonCenterM2">$make</div>
		</div>
		<div class='clear'></div>
TAX;
	break;
	case "2":
	$arraySet .=<<<TAX
<div class="button  $makeID" title="$make">
		<div class="buttonCenterM2">$make</div>
		</div>
		<div class='clear'></div>
TAX;
	break;
	case "3":
	$arraySet .=<<<TAX
<div class="button  $makeID" title="$make">
		<div class="buttonCenterM2">$make</div>
		</div>
		<div class='clear'></div>
TAX;
	break;
	case "4":
	$arraySet .=<<<TAX
<div class="button  $makeID" title="$make">
		<div class="buttonCenterM2">$make</div>
		</div>
		<div class='clear'></div>
TAX;
	break;
	case "5":
	$arraySet .=<<<TAX
<div class="button  $makeID" title="$make">
		<div class="buttonCenterM2">$make</div>
		</div>
		<div class='clear'></div>
TAX;
	break;
	case "6":
	$arraySet .=<<<TAX
<div class="button  $makeID" title="$make">
		<div class="buttonCenterM2">$make</div>
		</div>
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
<div class="button  $makeID" title="$make">
		<div class="buttonCenterM2">$make</div>
		</div>
		<div class='clear'></div>
TAX;
	
	}
	$arraySet .= "</div>\n";
}
echo $arraySet;



?>