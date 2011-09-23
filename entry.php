<?php
//ini_set('display_errors','On');

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
$counter = floor($countCM/7);
echo "this is the counter $counter this is the count $countCM<br />";
$p = 7;
$t = 0;
echo "this is count $countCM<br />";
$arraySet = "<div class='arrayBoxes northAmericanArrayBoxes1'>\n";
for($e = 0;$e<$countCM;$e++){
	if($p>6){
	for($i=$t;$i<$p;$i++){ 
$make = $makeArray[$i][2];
$makeID = $makeArray[$i][0];
$arraySet .=<<<TAX
<div class="button  $makeID" title="$make">
		<div class="buttonCenterM2">$make</div>
		</div>
		<div class='clear'></div>
TAX;
	}

$arraySet .="</div>\n";
$arraySet .= "<div class='arrayBoxes northAmericanArrayBoxes'>\n";
$t = $i;
} else {break;}

if($p>$countCM){
 $p = $p-$countCM;
 echo "<br /><br />THIS IS $countCM THIS IS $p this is the subtracted p $p<br /><br />";
 }else{
$p = $p+7;
}
}
require_once('eapInc/entryBody.php');



/*if($p>$countCM){}else{	 
	for($i=$t;$i<$p;$i++){ 
	$arraySet .="<div class='button  $competitiveMakes[$i][0]' title='$competitiveMakes[$i][2]'>
		<div class='buttonCenterM2'>$competitiveMakes[$i][2]</div>
		</div>
		<div class='clear'></div>";
	}

}*/
?>