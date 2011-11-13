<?php
ini_set('display_errors','On');

date_default_timezone_set('America/Los_Angeles');

//config file
require_once('eapInc/configOS.php');

//fed in through .htaccess vehicleID
$vID = mysql_escape_string($_GET['n']);

$vID2 = $vID;
$cbgid = 1;

//check that user is signed in
$cID = $_COOKIE['cid'];
if(!$cID){
$target3 = 'http://eap.rcomcreative.com/Login';
header('Location:'.$target3);
}


$competitiveMakesOne = $db->get("SELECT * from  vehicles as v, segment as s where v.VehicleID='$vID' and v.cbgid='$cbgid' and s.segmentid = v.segmentid and DeleteFlag=0 and ActiveFlag='1' order by v.VehicleName ");
$carArray = array();

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
$start_year = 1987;
$max = $db->get("SELECT MAX(LineYear) AS MaxYear FROM vehiclebattlegroundcycle WHERE LineYear != 'Y1' AND LineYear != 'Y2' AND LineYear != 'Y3'");
if($max){
	while(list($key,$value) = each($max)){
	$end_year = $value['MaxYear'];
	$end_year = $end_year+1;
	}
}
$end_year = 2032;

$yearsLength = ($end_year-$start_year)+1;
$size1 = ($yearsLength*100);
$size = $size1."px";
$size2 = $size1;
$sizeStyle = "style='width:$size; height: 20px;'";
$sizeStyle2 = "style='width:$size; height: 103px;'";
$yearsBox = '';
for($i=$start_year;$i<$end_year;$i++){
	$yearsBox .=<<<YER
	<div class='years'><div class="yearTextBox">$i</div></div>
YER;
}
$years = array();
for($k=$start_year;$k<$end_year;$k++){

array_push($years,$k);
}
$vehicleArray = array();
$threeYearArray = array();
$vehicleYear = "<div id='vehicleUpdateHolder'>\n";
$vehicleYear .= "<div id='vehicleUpdateScroller'  $sizeStyle2>\n";
$yearModelUpdates = $db->get("select * from vehiclebattlegroundcycle where VehicleID = '$vID' and LineYear >= '$start_year' and LineYear <= '$end_year'");
if($yearModelUpdates){
	while(list($key,$value) = each($yearModelUpdates)){
    		$lineYear = $value['LineYear'];
    		
    		
    		array_push($threeYearArray,$lineYear);
    		
    		$cycleText = $value['CycleText'];
    		$line = $lineYear." ".$cycleText;
    		$lineYearArray = array($lineYear=>array($cycleText));
    		array_push($vehicleArray,$line);
	}
	
}
$result = array_merge($years,$vehicleArray);
asort($result);
$year = '';
foreach($result as $key => $val){
	if(is_numeric($val)){
	if($val != $year){
	$vehicleYear .="<div class='yearBox' data-filter='$val'></div>\n";
	}
	} else {
	$year = substr($val,0,4);
	$text = substr($val,4);
	$vehicleYear .="<div class='yearBox' data-filter='$year'>\n<div class='yearsTextBox'>$text</div>\n</div>\n";
	}
}
$vehicleYear .= "</div'>\n</div>\n";
$vehicleNamed = $vName." ".$sName;
$stringLength = strlen($vehicleNamed);
$style = '';
$clearing = '';
$carInsights = '';
if($stringLength>40){
	$style = "style='width:1024px;'";
	$clearing = "<div class='clear'></div>";
	$carInsights = "style='margin-left: 489px;'";
}

$three = array();
	foreach($threeYearArray as $key => $val){
	$date = date("Y");
	if($val < $date)
	{

	array_push($three,$val);
	
	}
	}



$t = count($three);
for($q=0;$q<$t;$q++){
	$u = count($three);
	if($u>3){
	$ts = array_shift($three);
	}
}
$v = count($three);
$tYear = '';

$t2Year = '';
$b = '';
if($v<3){
$b = 3-$v;
for($w = 0;$w<$b;$w++){
$t2Year .="<div class='threeYearBoxes'><div class='threeYearText'></div></div>\n";
}
} else if($v<1){
$tYear .= "<div class='threeYearBoxes'><div class='threeYearText'></div></div>\n<div class='threeYearBoxes'><div class='threeYearText'></div></div>\n<div class='threeYearBoxes'><div class='threeYearText'></div></div>\n";
}

foreach($three as $key=>$value){
	$tYear .= "<div class='threeYearBoxes'><div class='threeYearText'>$value</div></div>\n";
}
if($b!=''){
$tYear .= $t2Year;
}
$keyPoints = '';
$keyPointSearch = $db->get("select * from vehicleKeypoint where vehicleID= '$vID' AND live = '1'");//need to add vehicleID once keypoints are sepped out to all cars
if($keyPointSearch){
	while(list($key,$value) = each($keyPointSearch)){
    		$keyPoint = $value['keypointText'];
    		//$keyPoints .="<div id='keyPointTextBox'>$keyPoint</div>\n<div class='clear'></div>\n";
    			}
	
}
$regionsSold = '';
$regionsSoldSearch = $db->get("select * from vehiclebattleground where vehicleID = '$vID'");
if($regionsSoldSearch){
	while(list($key,$value) = each($regionsSoldSearch)){
    		$americanRegion = $value['AmericaRegion'];
    		$europeRegion = $value['EuropeRegion'];
    		$asiaRegion = $value['AsiaRegion'];
    		if($americanRegion =='1'){
    		$regionsSold .= "<div class='regionSoldBox'><img src='img/blueDot25x21.png' width='16px' alt='blueDot' style='margin-top: 3px;'/></div>";
    		} else {
    		$regionsSold .= "<div class='regionSoldBox'></div>";
    		}
    		
    		if($europeRegion =='1'){
    		$regionsSold .= "<div class='regionSoldBox'><img src='img/blueDot25x21.png' width='16px' alt='blueDot' style='margin-top: 3px;'/></div>";
    		} else {
    		$regionsSold .= "<div class='regionSoldBox'></div>";
    		}
    		if($asiaRegion =='1'){
    		$regionsSold .= "<div class='regionSoldBox'><img src='img/blueDot25x21.png' width='16px' alt='blueDot' style='margin-top: 3px;'/></div>";
    		} else {
    		$regionsSold .= "<div class='regionSoldBox'></div>";
    		}
    	}
	
}


$basicBar =<<<BAS
	<div id="carName" $style>$vehicleNamed</div>
	$clearing
	<div id='carInsights' $carInsights></div>
	<div class="clear"></div>
	<div class="buttonRule"><div id="buttonBox1B" class="basic" data-filter='$vID'>the basics</div><div id="buttonBox2" class="specifications"  data-filter='$vID'>specifications</div><div id="buttonBox2" class="photos"  data-filter='$vID'>photos</div><div id="buttonBox2" class="overview"  data-filter='$vID'>product overview</div><div id="buttonBox2" class="insights"  data-filter='$vID'>insights</div><div id="buttonBox3" class="print"  data-filter='$vID'>print</div><div id="buttonBox2" class="salesforecast"  data-filter='$vID'>sales forecast</div><div id="english"  data-filter='$vID'>english</div><div id="slantBar"></div><div id="metric"  data-filter='$vID'>metric</div></div>
	<div class="clear"></div>
	<div id='accordionBoxTop'>
	<div id='accordionRule'><div id='collapse'>collapse all</div><div id='vertRule'></div><div id='expand'>expand all</div></div>
	</div>
	<div class='clear'></div>
	<div id='accordion'>
	<div id='modelYearBar'>
	<div id='modelYearArrowRight'></div>
	<div id='modelYearArrowDown'></div>
	<div class='modelYearTitle'>Model Years</div>
	</div>
	<div class='clear'></div>
	<div id='timeLineBox'>
	<div id='timeLineLeftArrow'></div>
	<div id='timeLineScrollBox'>
	<div id='timeLineYearHolder'>
	<div id='timeLineYearScroller' $sizeStyle>
	$yearsBox
	</div>
	</div>
	<div class="clear"></div>
	$vehicleYear
	</div>
	</div>
	<div id='timeLineRightArrow'></div>
	</div>
	<div class='clear'></div>
	<div id='photoBox'><img src='/img/upload_photos/$MediumVehiclePhoto' alt='$PhotoCaption' width='461px' /></div>
	<div id='threeBox'>
	<div class='horizontalRuler'></div>
	<div class='clear'></div>
	<div id='threeChangesBox'>
	<div id='threeYearArrowRight'></div>
	<div id='threeYearArrowDown'></div>
	<div id='threeYearHeader'>Last Three Changes</div>
	</div>
	<div class='clear'></div>
	<div id='threeYearBoxHolder'>
	$tYear
	</div>
	<div class='clear'></div>
	<div class='horizontalRuler'></div>
	<div class='clear'></div>
	<div id='keyPointBox'>
	<div id='keyPointsArrowRight'></div>
	<div id='keyPointsArrowDown'></div>
	<div id='keyPointsHeader'>Key Points</div>
	</div>
	<div class='clear'></div>
	<div id='tbKeyPointTextBox'>
	$keyPoint
	</div>
	<div class='clear'></div>
	<div class='horizontalRuler'></div>
	<div class='clear'></div>
	<div id='regionsSoldBox'>
	<div id='regionsSoldArrowRight'></div>
	<div id='regionsSoldArrowDown'></div>
	<div id='regionsSoldHeader'>Regions Sold</div>
	</div>
	<div class='clear'></div>
	<div id='regionsSoldBoxHolder'>
	<div class='regionTextBox'>North America</div>
	<div class='regionTextBox'>Europe</div>
	<div class='regionTextBox'>Asia</div>
	<div class='clear'></div>
	$regionsSold
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
			
			$('#metric').mouseover(function(){
			$('#metric').css('cursor','pointer');
			});
			$('#metric').mouseout(function(){
			$('#metric').css('cursor','default');
			});
			
			$('#regionsSoldBox').mouseover(function(){
			$('#regionsSoldBox').css('cursor','pointer');
			});
			$('#regionsSoldBox').mouseout(function(){
			$('#regionsSoldBox').css('cursor','default');
			});
			$('#regionsSoldBox').click(function(){
			$('#regionsSoldBoxHolder').toggle();
			
			$("#regionsSoldArrowRight").toggle();
			$("#regionsSoldArrowDown").toggle();
			});
			
			$('#keyPointBox').mouseover(function(){
			$('#keyPointBox').css('cursor','pointer');
			});
			$('#keyPointBox').mouseout(function(){
			$('#keyPointBox').css('cursor','default');
			});
			$('#keyPointBox').click(function(){
			$('#keyPointTextBox').toggle();
			
			$("#keyPointsArrowRight").toggle();
			$("#keyPointsArrowDown").toggle();
			});
			
			$('#threeChangesBox').mouseover(function(){
			$('#threeChangesBox').css('cursor','pointer');
			});
			$('#threeChangesBox').mouseout(function(){
			$('#threeChangesBox').css('cursor','default');
			});
			$('#threeChangesBox').click(function(){
			$('#threeYearBoxHolder').toggle();
			
			$("#threeYearArrowRight").toggle();
			$("#threeYearArrowDown").toggle();
			});
			
	
			$('#collapse').mouseover(function(){
			$('#collapse').css('cursor','pointer');
			});
			
			$('#collapse').mouseout(function(){
			$('#collapse').css('cursor','default');
			});
			
			$('#collapse').click(function(){
			//$('#accordion').slideUp();
			$('#threeYearBoxHolder').slideUp();
			$('#timeLineBox').slideUp();
			$('#keyPointTextBox').slideUp();
			$('#regionsSoldBoxHolder').slideUp();
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
			//$('#accordion').slideDown();
			$('#collapse').css('color','#B3B3B3');
			$('#expand').css('color','#000000');
			$('#threeYearBoxHolder').slideDown();
			$('#timeLineBox').slideDown();
			
			$('#keyPointTextBox').slideDown();
			$('#regionsSoldBoxHolder').slideDown();
			});
			
			
			$('#modelYearBar').mouseover(function() {
  			$('#modelYearBar').css('cursor', 'pointer');
			});
  			
  			$('#modelYearBar').mouseout(function() {
  			$('#modelYearBar').css('cursor', 'default');
  			});
  			
  			$('#modelYearBar').click(function(){
  			
  			var down = $('#modelYearArrowDown').is(':visible');
  			var right = $('#modelYearArrowRight').is(':visible');
  			

  			
  			$('#timeLineBox').toggle();
			$("#modelYearArrowRight").toggle();
			$("#modelYearArrowDown").toggle();
  			

  			
  			
  			
  			});
	$('#timeLineLeftArrow').mouseover(function() {
  			$('#timeLineLeftArrow').css('cursor', 'pointer');
			});
  			
  			$('#timeLineLeftArrow').mouseout(function() {
  			$('#timeLineLeftArrow').css('cursor', 'default');
  			});
  			
  		$('#timeLineLeftArrow').click(function(event){
  			var scrolling = $('#timeLineYearScroller').margin();
  			var positions = scrolling.left;
  			var sizeWidth = $size2;
  			var size = positions+427;
  			if(size>0){
  			size = 10;
  			}
  			
  			//alert(positions+' '+sizeWidth+' '+size);
  			$('#timeLineYearScroller').css({'margin-left': size});
  			$('#vehicleUpdateScroller').css({'margin-left': size});
  			event.preventDefault();
  			
  			  			
  			});
  			
  		$('#timeLineRightArrow').mouseover(function() {
  			$('#timeLineRightArrow').css('cursor', 'pointer');
			});
  			
  			$('#timeLineRightArrow').mouseout(function() {
  			$('#timeLineRightArrow').css('cursor', 'default');
  			});
  			
  			$('#timeLineRightArrow').click(function(event){
  			var scrolling = $('#timeLineYearScroller').margin();
  			var positions = scrolling.left;
  			var sizeWidth = $size2;
  			var size = positions-627;
  			if(size<-3727){
  			size = -3653;
  			}
  			
  			//alert(positions+' '+sizeWidth+' '+size);
  			$('#timeLineYearScroller').css({'margin-left': size});
  			$('#vehicleUpdateScroller').css({'margin-left': size});
  			event.preventDefault();
  			
  			  			
  			});
  			
  			
	
  	</script>
SCR;

echo $basicBar;
?>