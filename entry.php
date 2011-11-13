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
$sfMakeArray = array();
$competitiveMakes = $db->get("SELECT distinct m.* from make as m, service as sv, makeservice ms, vehicles as v where sv.cbgid=$cbgid and sv.serviceid = ms.serviceid and ms.makeid = m.makeid and v.makeid = m.makeid and v.ActiveFlag = 1 order by m.name");
if($competitiveMakes){
    		while(list($key,$value) = each($competitiveMakes)){
    		$makeID = $value['makeid'];
    		$manufactureID = $value['manufactureid'];
    		$makeName = $value['name'];
    		$makeModel = array($makeID,$manufactureID,$makeName);
    		array_push($makeArray,$makeModel);
    		array_push($sfMakeArray,$makeModel);
    		}
    		}
unset($competitiveMakes);
$countCM = count($makeArray);
$sfMakeArray2 = $sfMakeArray;
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
	array_shift($sfMakeArray2);
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
<div class="button" href="#filter=make/$make/$makeID" data-filter="$makeID" title="$make">$make</div>
		<div class='clear'></div>
TAX;
	break;
	case "1":
	$arraySet .=<<<TAX
<div class="button"  href="#filter=make/$make/$makeID" data-filter="$makeID" title="$make">$make</div>
		<div class='clear'></div>
TAX;
	break;
	case "2":
	$arraySet .=<<<TAX
<div class="button" href="#filter=make/$make/$makeID"  data-filter="$makeID" title="$make">$make</div>
		<div class='clear'></div>
TAX;
	break;
	case "3":
	$arraySet .=<<<TAX
<div class="button"  href="#filter=make/$make/$makeID" data-filter="$makeID" title="$make">$make</div>
		<div class='clear'></div>
TAX;
	break;
	case "4":
	$arraySet .=<<<TAX
<div class="button"  href="#filter=make/$make/$makeID" data-filter="$makeID" title="$make">$make</div>
		<div class='clear'></div>
TAX;
	break;
	case "5":
	$arraySet .=<<<TAX
<div class="button"  href="#filter=make/$make/$makeID" data-filter="$makeID" title="$make">$make</div>
		<div class='clear'></div>
TAX;
	break;
	case "6":
	$arraySet .=<<<TAX
<div class="button"  href="#filter=make/$make/$makeID" data-filter="$makeID" title="$make">$make</div>
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
<div class="button"  href="#filter=make/$make/$makeID" data-filter="$makeID" title="$make">$make</div>
		<div class='clear'></div>
TAX;
	
	}
	$arraySet .= "</div>\n";
}

/*sales forecaset make array box set*/

$sfArraySet = '';
for($e = 0;$e<$counted;$e++){
	$j = $e%7;
	
	$make = $sfMakeArray[$e][2];
	$makeID = $sfMakeArray[$e][0];
	$sf = 'forecast';
	
	switch ($j) {
	case "0":
	if($e == 0){
	$sfArraySet .= "<div class='arrayBoxes northAmericanArrayBoxes1'>\n";
	} else {
	$sfArraySet .= "<div class='arrayBoxes northAmericanArrayBoxes'>\n";
	}
	$sfArraySet .=<<<TAX
<div class="sfMButton" href="#filter=sfMake/$make/$makeID" data-filter="$makeID" title="$make" name='$sf'>$make</div>
		<div class='clear'></div>
TAX;
	break;
	case "1":
	$sfArraySet .=<<<TAX
<div class="sfMButton" href="#filter=sfMake/$make/$makeID" data-filter="$makeID" title="$make"  name='$sf'>$make</div>
		<div class='clear'></div>
TAX;
	break;
	case "2":
	$sfArraySet .=<<<TAX
<div class="sfMButton" href="#filter=sfMake/$make/$makeID" data-filter="$makeID" title="$make"  name='$sf'>$make</div>
		<div class='clear'></div>
TAX;
	break;
	case "3":
	$sfArraySet .=<<<TAX
<div class="sfMButton" href="#filter=sfMake/$make/$makeID" data-filter="$makeID" title="$make"  name='$sf'>$make</div>
		<div class='clear'></div>
TAX;
	break;
	case "4":
	$sfArraySet .=<<<TAX
<div class="sfMButton" href="#filter=sfMake/$make/$makeID" data-filter="$makeID" title="$make"  name='$sf'>$make</div>
		<div class='clear'></div>
TAX;
	break;
	case "5":
	$sfArraySet .=<<<TAX
<div class="sfMButton" href="#filter=sfMake/$make/$makeID" data-filter="$makeID" title="$make"  name='$sf'>$make</div>
		<div class='clear'></div>
TAX;
	break;
	case "6":
	$sfArraySet .=<<<TAX
<div class="sfMButton" href="#filter=sfMake/$make/$makeID" data-filter="$makeID" title="$make" name='$sf'>$make</div>
		<div class='clear'></div>
		</div>
		
TAX;
	break;
	}
}

if($remainder != 0){
	$sfArraySet .= "<div class='arrayBoxes northAmericanArrayBoxes'>\n";
	for($k = 0; $k<$remainder;$k++){
	
	
	$make = $sfMakeArray2[$k][2];
	$makeID = $sfMakeArray2[$k][0];
	
	$sfArraySet .=<<<TAX
<div class="sfMButton" href="#filter=sfMake/$make/$makeID" data-filter="$makeID" title="$make"  name='$sf'>$make</div>
		<div class='clear'></div>
TAX;
	
	}
	$sfArraySet .= "</div>\n";
}

/*end sales forecase make array box set*/

$segmentArray = array();
$sfSegmentArray = array();
$comparisonArray = array();
$competitiveSegments = $db->get("SELECT distinct s.* from segment as s, service as sv, segmentservice ss, vehicles as v where sv.cbgid=$cbgid and sv.serviceid = ss.serviceid and ss.segmentid = s.segmentid and v.segmentid = s.segmentid and v.ActiveFlag = 1 ");
if($competitiveSegments){
    		while(list($key,$value) = each($competitiveSegments)){
    		$segmentID = $value['segmentid'];
    		$segmentName = $value['name'];
    		$sArray = array($segmentID,$segmentName);
    		array_push($segmentArray,$sArray);
    		array_push($sfSegmentArray,$sArray);
    		array_push($comparisonArray,$sArray);
    		}
    		}
unset($competitiveSegments);

$countCS = count($segmentArray);

	
	
$segmentArray2 = $segmentArray;
$comparisonArray2 = $comparisonArray;
$sfSegmentArray2 = $sfSegmentArray;
$segmentArray3 = $segmentArray;
$counterS = floor($countCS/7);
$remainderS = $countCS % 7;

for($i=0;$i<$remainderS;$i++){
	array_pop($segmentArray);
}

$countedS = $countCS-$remainderS;

for($e=0;$e<$countedS;$e++){
	array_shift($segmentArray2);
	array_shift($sfSegmentArray2);
	array_shift($comparisonArray2);
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
<div class="segmentButton" href="#filter=segment/$segmentID" data-filter="$segmentID" title="$segment">$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "1":
	$SegmentArraySet .=<<<TAX
<div class="segmentButton" href="#filter=segment/$segmentID" data-filter="$segmentID" title="$segment">$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "2":
	$SegmentArraySet .=<<<TAX
<div class="segmentButton" href="#filter=segment/$segmentID" data-filter="$segmentID" title="$segment">$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "10":
	$SegmentArraySet .=<<<TAX
<div class="segmentButton" href="#filter=segment/$segmentID" data-filter="$segmentID" title="$segment">$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "4":
	$SegmentArraySet .=<<<TAX
<div class="segmentButton" href="#filter=segment/$segmentID" data-filter="$segmentID" title="$segment">$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "5":
	$SegmentArraySet .=<<<TAX
<div class="segmentButton" href="#filter=segment/$segmentID" data-filter="$segmentID" title="$segment">$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "6":
	$SegmentArraySet .=<<<TAX
<div class="segmentButton" href="#filter=segment/$segmentID" data-filter="$segmentID" title="$segment">$segment</div>
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
<div class="segmentButton" href="#filter=segment/$segmentID" data-filter="$segmentID" title="$segment">$segment</div>
		<div class='clear'></div>
TAX;
	
	}
	$SegmentArraySet .= "</div>\n";
}

/*sales forecast segment array set start*/

$sfSegmentArraySet = '';

for($m = 0;$m<$countedS;$m++){
	$j = $m%7;

	$segment = $sfSegmentArray[$m][1];
	$segmentID = $sfSegmentArray[$m][0];
	
	$sf = 'forecast';
	
	switch ($j) {
	case "0":
	if($m == 0){
	$sfSegmentArraySet .= "<div class='arrayBoxes northAmericanArrayBoxes1'>\n";
	} else {
	$sfSegmentArraySet .= "<div class='arrayBoxes northAmericanArrayBoxes'>\n";
	}
	$sfSegmentArraySet .=<<<TAX
<div class="sfSegmentButton" href="#filter=sfSegment/$segmentID" data-filter="$segmentID" title="$segment" name='$sf'>$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "1":
	$sfSegmentArraySet .=<<<TAX
<div class="sfSegmentButton" href="#filter=sfSegment/$segmentID" data-filter="$segmentID" title="$segment" name='$sf'>$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "2":
	$sfSegmentArraySet .=<<<TAX
<div class="sfSegmentButton" href="#filter=sfSegment/$segmentID" data-filter="$segmentID" title="$segment" name='$sf'>$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "10":
	$sfSegmentArraySet .=<<<TAX
<div class="sfSegmentButton" href="#filter=sfSegment/$segmentID" data-filter="$segmentID" title="$segment" name='$sf'>$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "4":
	$sfSegmentArraySet .=<<<TAX
<div class="sfSegmentButton" href="#filter=sfSegment/$segmentID" data-filter="$segmentID" title="$segment" name='$sf'>$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "5":
	$sfSegmentArraySet .=<<<TAX
<div class="sfSegmentButton" href="#filter=sfSegment/$segmentID" data-filter="$segmentID" title="$segment" name='$sf'>$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "6":
	$sfSegmentArraySet .=<<<TAX
<div class="sfSegmentButton" href="#filter=sfSegment/$segmentID" data-filter="$segmentID" title="$segment" name='$sf'>$segment</div>
		<div class='clear'></div>
		</div>
		
TAX;
	break;
	}
}

if($remainder != 0){
	$sfSegmentArraySet .= "<div class='arrayBoxes northAmericanArrayBoxes'>\n";
	for($k = 0; $k<$remainder;$k++){
	
	
	$segment = $sfSegmentArray2[$k][1];
	$segmentID = $sfSegmentArray2[$k][0];
	
	$sfSegmentArraySet .=<<<TAX
<div class="sfSegmentButton" href="#filter=sfSegment/$segmentID" data-filter="$segmentID" title="$segment" name='$sf'>$segment</div>
		<div class='clear'></div>
TAX;
	
	}
	$sfSegmentArraySet .= "</div>\n";
}


/*sales forecast segment array set end*/

/*comparison segment array set start*/

$comparisonArraySet = '';

for($m = 0;$m<$countedS;$m++){
	$j = $m%7;

	$segment = $comparisonArray[$m][1];
	$segmentID = $comparisonArray[$m][0];
	$compare = 'comparison';
	
	$sf = 'forecast';
	
	switch ($j) {
	case "0":
	if($m == 0){
	$comparisonArraySet .= "<div class='arrayBoxes northAmericanArrayBoxes1'>\n";
	} else {
	$comparisonArraySet .= "<div class='arrayBoxes northAmericanArrayBoxes'>\n";
	}
	$comparisonArraySet .=<<<TAX
<div class="comparisonButton" href="#filter=comparison/$segmentID" data-filter="$segmentID" title="$segment" name='$compare'>$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "1":
	$comparisonArraySet .=<<<TAX
<div class="comparisonButton" href="#filter=comparison/$segmentID" data-filter="$segmentID" title="$segment" name='$compare'>$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "2":
	$comparisonArraySet .=<<<TAX
<div class="comparisonButton" href="#filter=comparison/$segmentID" data-filter="$segmentID" title="$segment" name='$compare'>$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "10":
	$comparisonArraySet .=<<<TAX
<div class="comparisonButton" href="#filter=comparison/$segmentID" data-filter="$segmentID" title="$segment" name='$compare'>$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "4":
	$comparisonArraySet .=<<<TAX
<div class="comparisonButton" href="#filter=comparison/$segmentID" data-filter="$segmentID" title="$segment" name='$compare'>$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "5":
	$comparisonArraySet .=<<<TAX
<div class="comparisonButton" href="#filter=comparison/$segmentID" data-filter="$segmentID" title="$segment" name='$compare'>$segment</div>
		<div class='clear'></div>
TAX;
	break;
	case "6":
	$comparisonArraySet .=<<<TAX
<div class="comparisonButton" href="#filter=comparison/$segmentID" data-filter="$segmentID" title="$segment" name='$compare'>$segment</div>
		<div class='clear'></div>
		</div>
		
TAX;
	break;
	}
}

if($remainder != 0){
	$comparisonArraySet .= "<div class='arrayBoxes northAmericanArrayBoxes'>\n";
	for($k = 0; $k<$remainder;$k++){
	
	
	$segment = $comparisonArray2[$k][1];
	$segmentID = $comparisonArray2[$k][0];
	
	$comparisonArraySet .=<<<TAX
<div class="comparisonButton" href="#filter=comparison/$segmentID" data-filter="$segmentID" title="$segment" name='$compare'>$segment</div>
		<div class='clear'></div>
TAX;
	
	}
	$comparisonArraySet .= "</div>\n";
}
/*comparison segment array set end*/
$customSegmentArray = array();
 
$customSegments = $db->get("select * from customsegments as cs, user as u, user as mu where (cs.userid = '$cID' and cs.serviceid='$cbgid' and u.userid ='$cID' and mu.userid='$cID') or (cs.userid=mu.userid and u.userid='$cID' and mu.SubscriberID = u.SubscriberID and mu.Master = 1 and cs.serviceid='$cbgid') order by SegmentName asc ");
if($customSegments){
    		while(list($key,$value) = each($customSegments)){
    		$csegmentID = $value['CustomSegmentID'];
    		$csegmentServiceID = $value['serviceid'];
    		$csegmentUserID = $value['UserID'];
    		$csegmentName = $value['SegmentName'];
    		$csArray = array($csegmentID,$csegmentServiceID,$csegmentUserID,$csegmentName);
    		array_push($customSegmentArray,$csArray);
    		}
    		}
unset($customSegments);

$countCuS = count($customSegmentArray);

$customSegmentArray2 = $customSegmentArray;
$customSegmentArray3 = $customSegmentArray;
$counterCS = ceil($countCuS/7);
$remainderCS = $countCuS % 7;


$countedS = $countCuS-$remainderCS;

for($e=0;$e<$countedS;$e++){
	array_shift($customSegmentArray2);
}

$p = 7;
$t = 0;

$customSegmentArraySet = '';

for($m = 0;$m<$countCuS;$m++){
	$j = $m;

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
<div class="customSegmentButton" href="#filter=cSegment/$cSegmentID" data-filter="$cSegmentID" title="$cSegment">$cSegment</div>
		<div class='clear'></div>
TAX;
	break;
	case "1":
	$customSegmentArraySet .=<<<TAX
<div class="customSegmentButton" href="#filter=cSegment/$cSegmentID" data-filter="$cSegmentID" title="$cSegment">$cSegment</div>
		<div class='clear'></div>
TAX;
	break;
	case "2":
	$customSegmentArraySet .=<<<TAX
<div class="customSegmentButton" href="#filter=cSegment/$cSegmentID" data-filter="$cSegmentID" title="$cSegment">$cSegment</div>
		<div class='clear'></div>
TAX;
	break;
	case "10":
	$customSegmentArraySet .=<<<TAX
<div class="customSegmentButton" href="#filter=cSegment/$cSegmentID" data-filter="$cSegmentID" title="$cSegment">$cSegment</div>
		<div class='clear'></div>
TAX;
	break;
	case "4":
	$customSegmentArraySet .=<<<TAX
<div class="customSegmentButton" href="#filter=cSegment/$cSegmentID" data-filter="$cSegmentID" title="$cSegment">$cSegment</div>
		<div class='clear'></div>
TAX;
	break;
	case "5":
	$customSegmentArraySet .=<<<TAX
<div class="customSegmentButton" href="#filter=cSegment/$cSegmentID" data-filter="$cSegmentID" title="$cSegment">$cSegment</div>
		<div class='clear'></div>
TAX;
	break;
	case "6":
	$customSegmentArraySet .=<<<TAX
<div class="customSegmentButton" href="#filter=cSegment/$cSegmentID" data-filter="$cSegmentID" title="$cSegment">$cSegment</div>
		<div class='clear'></div>
		</div>
		
TAX;
	break;
	}
}
if($countCuS<7){
	$customSegmentArraySet .="</div>\n";
}
if($countCuS>7){
if($remainderCS != 0){
	$customSegmentArraySet .= "<div class='arrayBoxes northAmericanArrayBoxes'>\n";
	for($k = 0; $k<$remainder;$k++){
	
	
	$cSegment = $customSegmentArray2[$k][3];
	$cSegmentID = $customSegmentArray2[$k][0];
	
	$customSegmentArraySet .=<<<TAX
<div class="customSegmentButton" href="#filter=cSegment/$cSegmentID" data-filter="$cSegmentID" title="$cSegment">$cSegment</div>
		<div class='clear'></div>
TAX;
	
	}
	$customSegmentArraySet .= "</div>\n";
}
}
require_once('eapInc/entryBody.php');



?>