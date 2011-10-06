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

$cID = $_COOKIE['cid'];
if(!$cID){
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
<div class="button" data-filter="$makeID" title="$make">$make</div>
		<div class='clear'></div>
TAX;
	break;
	case "1":
	$arraySet .=<<<TAX
<div class="button" data-filter="$makeID" title="$make">$make</div>
		<div class='clear'></div>
TAX;
	break;
	case "2":
	$arraySet .=<<<TAX
<div class="button" data-filter="$makeID" title="$make">$make</div>
		<div class='clear'></div>
TAX;
	break;
	case "3":
	$arraySet .=<<<TAX
<div class="button" data-filter="$makeID" title="$make">$make</div>
		<div class='clear'></div>
TAX;
	break;
	case "4":
	$arraySet .=<<<TAX
<div class="button" data-filter="$makeID" title="$make">$make</div>
		<div class='clear'></div>
TAX;
	break;
	case "5":
	$arraySet .=<<<TAX
<div class="button" data-filter="$makeID" title="$make">$make</div>
		<div class='clear'></div>
TAX;
	break;
	case "6":
	$arraySet .=<<<TAX
<div class="button" data-filter="$makeID" title="$make">$make</div>
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
<div class="button" data-filter="$makeID" title="$make">$make</div>
		<div class='clear'></div>
TAX;
	
	}
	$arraySet .= "</div>\n";
}
$segmentArray = array();
$competitiveSegments = $db->get("SELECT distinct s.* from segment as s, service as sv, segmentservice ss, vehicles as v where sv.cbgid=$cbgid and sv.serviceid = ss.serviceid and ss.segmentid = s.segmentid and v.segmentid = s.segmentid and v.ActiveFlag = 1 ");
if($competitiveSegments){
    		while(list($key,$value) = each($competitiveSegments)){
    		$segmentID = $value['segmentid'];
    		$segmentName = $value['name'];
    		$sArray = array($segmentID,$segmentName);
    		array_push($segmentArray,$sArray);
    		}
    		}
unset($competitiveSegments);

$countCS = count($segmentArray);

$segmentArray2 = $segmentArray;
$segmentArray3 = $segmentArray;
$counterS = floor($countCS/7);
$remainderS = $countCS % 7;

for($i=0;$i<$remainderS;$i++){
	array_pop($segmentArray);
}

$countedS = $countCS-$remainderS;

for($e=0;$e<$countedS;$e++){
	array_shift($segmentArray2);
}

$p = 7;
$t = 0;

$SegmentArraySet = '';

for($m = 0;$m<$countedS;$m++){
	$j = $m%7;

	$segment = $segmentArray[$m][1];
	$segmentID = $segmentArray[$m][0];
	
	switch ($j) {
	case "0":
	if($m == 0){
	$SegmentArraySet .= "<div class='arrayBoxes northAmericanArrayBoxes1'>\n";
	} else {
	$SegmentArraySet .= "<div class='arrayBoxes northAmericanArrayBoxes'>\n";
	}
	$SegmentArraySet .=<<<TAX
<div class="segmentButton" data-filter="$segmentID" title="$segment">$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "1":
	$SegmentArraySet .=<<<TAX
<div class="segmentButton" data-filter="$segmentID" title="$segment">$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "2":
	$SegmentArraySet .=<<<TAX
<div class="segmentButton" data-filter="$segmentID" title="$segment">$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "10":
	$SegmentArraySet .=<<<TAX
<div class="segmentButton" data-filter="$segmentID" title="$segment">$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "4":
	$SegmentArraySet .=<<<TAX
<div class="segmentButton" data-filter="$segmentID" title="$segment">$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "5":
	$SegmentArraySet .=<<<TAX
<div class="segmentButton" data-filter="$segmentID" title="$segment">$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "6":
	$SegmentArraySet .=<<<TAX
<div class="segmentButton" data-filter="$segmentID" title="$segment">$segment</div>
		<div class='clear'></div>
		</div>
		
TAX;
	break;
	}
}

if($remainder != 0){
	$SegmentArraySet .= "<div class='arrayBoxes northAmericanArrayBoxes'>\n";
	for($k = 0; $k<$remainder;$k++){
	
	
	$segment = $segmentArray2[$k][1];
	$segmentID = $segmentArray2[$k][0];
	
	$SegmentArraySet .=<<<TAX
<div class="segmentButton" data-filter="$segmentID" title="$segment">$segment</div>
		<div class='clear'></div>
TAX;
	
	}
	$SegmentArraySet .= "</div>\n";
}

$customSegmentArray = array();
 
$customSegments = $db->get("select * from customsegments as cs, user as u, user as mu where (cs.userid = '$cID' and cs.serviceid='$cbgid' and u.userid ='$cID' and mu.userid='$cID') or (cs.userid=mu.userid and u.userid='$cID' and mu.SubscriberID = u.SubscriberID and mu.Master = 1 and cs.serviceid='$cbgid') order by SegmentName asc ");
if($customSegments){
    		while(list($key,$value) = each($customSegments)){
    		$csegmentID = $value['CustomSegmentID'];
    		$csegmentServiceID = $value['serviceid'];
    		$csegmentUserID = $value['UserID'];
    		$csegmentName = $value['SegmentName'];
    		$csArray = array($csegmentID,$csegmentServiceID,$csegmentUserID,$segmentName);
    		array_push($customSegmentArray,$csArray);
    		}
    		}
unset($customSegments);

$countCuS = count($customSegmentArray);

$customSegmentArray2 = $customSegmentArray;
$customSegmentArray3 = $customSegmentArray;
$counterCS = floor($countCuS/7);
$remainderCS = $countCuS % 7;

for($i=0;$i<$remainderCS;$i++){
	array_pop($customSegmentArray);
}

$countedS = $countCuS-$remainderCS;

for($e=0;$e<$countedS;$e++){
	array_shift($customSegmentArray2);
}

$p = 7;
$t = 0;

$customSegmentArraySet = '';

for($m = 0;$m<$countedS;$m++){
	$j = $m%7;

	$cSegment = $customSegmentArray[$m][3];
	$cSegmentID = $customSegmentArray[$m][0];
	
	switch ($j) {
	case "0":
	if($m == 0){
	$customSegmentArraySet .= "<div class='arrayBoxes northAmericanArrayBoxes1'>\n";
	} else {
	$customSegmentArraySet .= "<div class='arrayBoxes northAmericanArrayBoxes'>\n";
	}
	$customSegmentArraySet .=<<<TAX
<div class="customSegmentButton" data-filter="$cSegmentID" title="$cSegment">$cSegment</div>
		<div class='clear'></div>
TAX;
	break;
	case "1":
	$customSegmentArraySet .=<<<TAX
<div class="customSegmentButton" data-filter="$cSegmentID" title="$cSegment">$cSegment</div>
		<div class='clear'></div>
TAX;
	break;
	case "2":
	$customSegmentArraySet .=<<<TAX
<div class="customSegmentButton" data-filter="$cSegmentID" title="$cSegment">$cSegment</div>
		<div class='clear'></div>
TAX;
	break;
	case "10":
	$customSegmentArraySet .=<<<TAX
<div class="customSegmentButton" data-filter="$cSegmentID" title="$cSegment">$cSegment</div>
		<div class='clear'></div>
TAX;
	break;
	case "4":
	$customSegmentArraySet .=<<<TAX
<div class="customSegmentButton" data-filter="$cSegmentID" title="$cSegment">$cSegment</div>
		<div class='clear'></div>
TAX;
	break;
	case "5":
	$customSegmentArraySet .=<<<TAX
<div class="customSegmentButton" data-filter="$cSegmentID" title="$cSegment">$cSegment</div>
		<div class='clear'></div>
TAX;
	break;
	case "6":
	$customSegmentArraySet .=<<<TAX
<div class="customSegmentButton" data-filter="$cSegmentID" title="$cSegment">$cSegment</div>
		<div class='clear'></div>
		</div>
		
TAX;
	break;
	}
}

if($remainderCS != 0){
	$customSegmentArraySet .= "<div class='arrayBoxes northAmericanArrayBoxes'>\n";
	for($k = 0; $k<$remainder;$k++){
	
	
	$cSegment = $customSegmentArray2[$k][3];
	$cSegmentID = $customSegmentArray2[$k][0];
	
	$customSegmentArraySet .=<<<TAX
<div class="customSegmentButton" data-filter="$cSegmentID" title="$cSegment">$cSegment</div>
		<div class='clear'></div>
TAX;
	
	}
	$customSegmentArraySet .= "</div>\n";
}

require_once('eapInc/entryBody.php');



?>