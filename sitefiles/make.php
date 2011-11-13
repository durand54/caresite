<?php
ini_set('display_errors','On');

date_default_timezone_set('America/Los_Angeles');

require_once('eapInc/configOS.php');
$makeID = mysql_escape_string($_GET['m']);
$makeName = mysql_escape_string($_GET['n']);
$makeID2 = $makeID;
$cID = $_COOKIE['cid'];
if(!$cID){
$target3 = 'http://eap.rcomcreative.com/Login';
header('Location:'.$target3);
}

$cbgid = 1;
$start_year = 1987;
$max = $db->get("SELECT MAX(LineYear) AS MaxYear FROM vehiclebattlegroundcycle WHERE LineYear != 'Y1' AND LineYear != 'Y2' AND LineYear != 'Y3'");
if($max){
	while(list($key,$value) = each($max)){
	$end_year = $value['MaxYear'];
	$end_year = $end_year+1;
	}
}
$end_year = 2032;
$makeArray = array();
$competitiveMakesOne = $db->get("SELECT * from  vehicles as v where v.makeid='$makeID' and v.cbgid='$cbgid' and DeleteFlag=0 and ActiveFlag='1' order by v.VehicleName ");
$carArray = array();

if($competitiveMakesOne){
			while(list($key,$value)= each($competitiveMakesOne)){
			$vID = $value['VehicleID'];
			$vName = $value['VehicleName'];
			$car = array($vID,$vName);
			array_push($carArray,$car);
			}
}
unset($competitiveMakesOne);
$logoMake = $db->get("SELECT * from brandlogo WHERE makeid = '$makeID2'");
if($logoMake){
	while(list($key,$value) = each($logoMake)){
			$brandLogoID = $value['BrandLogoID'];
			$categoryItemID = $value['CategoryItemID'];
    		$logoFileName = $value['LogoFileName'];
    		}
}
unset($logoMake);
$years = ($end_year-$start_year)+1;
$size = $years*72;
$years = "<div id='vehicleYears'>\n";
$years .= "<div class='vehicle'>Vehicle</div>\n";
$years .= "<div class='yearHolder'>\n";
$years .= "<div id='yearScroller' style='width:".$size."px; height: 18px;' >\n";
for($i=$start_year;$i<$end_year;$i++){
	$years .=<<<YER
	<div class='years'>$i</div>
YER;
}
$years .= "</div>\n</div>\n</div>\n<div class='clear'></div>\n";
$vehicleBox =<<<TOP
<div id="modelYearTop">
<div id="leftArrow"><img src='/img/leftArrow.jpg' width='35px' /></div>
<div class='logo $makeID2'><img src='/img/logos/$logoFileName' alt='$brandLogoID $categoryItemID $makeID2' height='60px'/></div>
<div id="rightArrow"><img src='/img/rightArrow.jpg' width='35px' /></div>
</div>
<div class="clear"></div>
TOP;
$vehicleBox .= $years;
$vehicleBox .= "<div id='vehicleMY'>\n";
//$vehicleYear = "<div id='yearInfoBox'>\n";
$counter = count($carArray);
for($i=0;$i<$counter;$i++){
	$car = $carArray[$i][0];
	$carName = $carArray[$i][1];
	$carReplace = "$makeName<br />";
	$carName = str_replace($makeName, $carReplace, $carName);
	$vehicleBox .=<<<CAR
		<div class="model" data-filter="$car">$carName</div>
CAR;
	$competitiveMakes = $db->get("select * from vehiclebattlegroundcycle where VehicleID = '$car' and LineYear >= $start_year and LineYear <= $end_year");
			if($competitiveMakes){
    		while(list($key2,$value2) = each($competitiveMakes)){
    		$lineYear = $value2['LineYear'];
    		$cycleText = $value2['CycleText'];
			/*$vehicleYear .=<<<VYR
			<div class='yearVehicle $lineYear" data-filter="$car">$cycleText</div>		
VYR;*/
    		$makeModel = array($car=>$lineYear,$carName=>$cycleText);
    		array_push($makeArray,$makeModel);
    		}
    		}
    
			/*$vehicleYear .=<<<VER
			<div class="$clear"></div>		
VER;		*/
}
//$vehicleYear .= "</div>\n";


$vehicleBox .= "</div>\n<div id='vehicleMYHolder'>$vehicleYear</div>\n";
$vehicleBox .=<<<SCR
	<script>
	$('#leftArrow').mouseover(function() {
  			$('#leftArrow').css('cursor', 'pointer');
			});
  			
  			$('#leftArrow').mouseout(function() {
  			$('#leftArrow').css('cursor', 'default');
  			});
  			
  			$('#leftArrow').click(function(event){
  			var scrolling = $('#yearScroller').margin();
  			var positions = scrolling.left;
  			var sizeWidth = $size;
  			var size = positions+427;
  			if(size>0){
  			size = 10;
  			}
  			
  			//alert(positions+' '+sizeWidth+' '+size);
  			$("#yearScroller").css({'margin-left': size});
  			event.preventDefault();
  			
  			  			
  			});
	$('#rightArrow').mouseover(function() {
  			$('#rightArrow').css('cursor', 'pointer');
			});
  			
  			$('#rightArrow').mouseout(function() {
  			$('#rightArrow').css('cursor', 'default');
  			});
  			
  			$('#rightArrow').click(function(event){
  			var scrolling = $('#yearScroller').margin();
  			var positions = scrolling.left;
  			var sizeWidth = $size;
  			var size = positions-427;
  			if(size<-2310){
  			size = -2350;
  			}
  			
  			//alert(positions+' '+sizeWidth+' '+size);
  			$("#yearScroller").css({'margin-left': size});
  			event.preventDefault();
  			
  			  			
  			});

	</script>
SCR;
echo $vehicleBox;
?>