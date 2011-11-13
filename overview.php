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
$vehicleNamed = $vName." ".$sName;$stringLength = strlen($vehicleNamed);
$style = '';
$clearing = '';
$carInsights = '';
if($stringLength>40){
	$style = "style='width:1024px;'";
}
$keyPoints = '';
$keypoint = $db->get("SELECT * FROM vehicleKeypoint where vehicleID = '$vID'");
			if($keypoint){
				while(list($key,$value) = each($keypoint)){
    			$keyPoints = $value['keypointText'];
    		}
    		}
			unset($keypoint);
$futureIntl = '';
$poFutureIntel = $db->get("SELECT * FROM vehicleFutureIntel where vehicleID = '$vID'");
			if($poFutureIntel){
				while(list($key,$value) = each($poFutureIntel)){
    			$futureIntl = $value['futureIntl'];
    		}
    		}
			unset($poFutureIntel);
$CGEquipUpdates = '';
$poCGEquipUpdates = $db->get("SELECT * FROM vehicleCGEquipUpdates where vehicleID = '$vID'");
			if($poCGEquipUpdates){
				while(list($key,$value) = each($poCGEquipUpdates)){
    			$CGEquipUpdates = $value['currentGenerationEquipmentUpdates'];
    		}
    		}
			unset($poCGEquipUpdates);
$CGLaunchInfo = '';
$poCGLaunchInfo = $db->get("SELECT * FROM vehicleCGEquipUpdates where vehicleID = '$vID'");
			if($poCGLaunchInfo){
				while(list($key,$value) = each($poCGLaunchInfo)){
    			$CGLaunchInfo = $value['currentGenerationEquipmentUpdates'];
    		}
    		}
			unset($poCGLaunchInfo);
$PriorGenerationInfo = '';
$poPriorGenerationInfo = $db->get("SELECT * FROM vehiclePriorGenerationInfo where vehicleID = '$vID'");
			if($poPriorGenerationInfo){
				while(list($key,$value) = each($poPriorGenerationInfo)){
    			$PriorGenerationInfo = $value['priorGenerationInfo'];
    		}
    		}
			unset($poPriorGenerationInfo);
$vehicleConfigPowerTrainProfile = '';			
$povehicleConfigPowerTrainProfile = $db->get("SELECT * FROM vehicleConfigPowerTrainProfile where vehicleID = '$vID'");
			if($povehicleConfigPowerTrainProfile){
				while(list($key,$value) = each($povehicleConfigPowerTrainProfile)){
    			$vehicleConfigPowerTrainProfile = $value['vehicleConfigPowerTrainProfile'];
    		}
    		}
			unset($povehicleConfigPowerTrainProfile);
$basicBar =<<<BAS
	<div id="productOverview">
	<div id="carName" $style>$vehicleNamed</div>
	<div class="clear"></div>
	<div class="buttonRule"><div id="buttonBox1" class="basic" data-filter='$vID'>the basics</div><div id="buttonBox2" class="specifications"  data-filter='$vID'>specifications</div><div id="buttonBox2" class="photos"  data-filter='$vID'>photos</div><div id="buttonBox2B" class="overview"  data-filter='$vID'>product overview</div><div id="buttonBox2" class="insights"  data-filter='$vID'>insights</div><div id="buttonBox3" class="print"  data-filter='$vID'>print</div><div id="buttonBox2" class="salesforecast"  data-filter='$vID'>sales forecast</div><div id="english"  data-filter='$vID'>english</div><div id="slantBar"></div><div id="metric"  data-filter='$vID'>metric</div></div>
	<div class="clear"></div>
	<div id='accordionBoxTop'>
	<div id='accordionRule'><div id='collapse'>collapse all</div><div id='vertRule'></div><div id='expand'>expand all</div></div>
	</div>
	
	<div class='clear'></div>
	<div id='productOverviewBox'>
	<div class='productBoxHolder'>
	<div id='poKeyPointsBox'>
	<div id='poKeyPointsArrowRight'></div>
	<div id='poKeyPointsArrowDown'></div>
	<div id='poKeyPointsHeader'>Key Points</div>
	</div>
	<div class='clear'></div>
	<div id='poKeyPointsBoxHolder'>
	<div id='poKeyPointTextBox'>
	$keyPoints
	</div>
	</div>
	</div>
	<div id='overviewPhotoBox'><img src='/img/upload_photos/$MediumVehiclePhoto' alt='$PhotoCaption' width='461px' /></div>
	</div>
	<div class='clear'></div>
	<div class='poAccordionRule'></div>
	<div class='clear'></div>
	<div id='poFutureIntelBox'>
	<div id='poFutureIntelArrowRight'></div>
	<div id='poFutureIntelArrowDown'></div>
	<div id='poFutureIntelHeader'>Future Intel</div>
	</div>
	<div class='clear'></div>
	<div id='poFutureIntelBoxHolder'>
	<div id='poFutureIntelText'>
	$futureIntl
	</div>
	</div>
	<div class='clear'></div>
	<div class='poAccordionRule'></div>
	<div class='clear'></div>
	<div id='poCGEquipUpdatesBox'>
	<div id='poCGEquipUpdatesArrowRight'></div>
	<div id='poCGEquipUpdatesArrowDown'></div>
	<div id='poCGEquipUpdatesHeader'>Current Generation Equipment Updates</div>
	</div>
	<div class='clear'></div>
	<div id='poCGEquipUpdatesBoxHolder'>
	<div id='poCGEquipUpdatesText'>
	$CGEquipUpdates
	</div>
	</div>
	<div class='clear'></div>
	<div class='poAccordionRule'></div>
	<div class='clear'></div>
	<div id='poCGLaunchInfoBox'>
	<div id='poCGLaunchInfoArrowRight'></div>
	<div id='poCGLaunchInfoArrowDown'></div>
	<div id='poCGLaunchInfoHeader'>Current Generation Launch Info</div>
	</div>
	<div class='clear'></div>
	<div id='poCGLaunchInfoBoxHolder'>
	<div id='poCGLaunchInfoText'>
	$CGLaunchInfo
	</div>
	</div>
	<div class='clear'></div>
	<div class='poAccordionRule'></div>
	<div class='clear'></div>
	<div id='poPriorGenerationInfoBox'>
	<div id='poPriorGenerationInfoArrowRight'></div>
	<div id='poPriorGenerationInfoArrowDown'></div>
	<div id='poPriorGenerationInfoHeader'>Prior Generation Info</div>
	</div>
	<div class='clear'></div>
	<div id='poPriorGenerationInfoBoxHolder'>
	<div id='poPriorGenerationInfoText'>
	$PriorGenerationInfo
	</div>
	</div>
	<div class='clear'></div>
	<div class='poAccordionRule'></div>
	<div class='clear'></div>
	<div id='povehicleConfigPowerTrainProfileBox'>
	<div id='povehicleConfigPowerTrainProfileArrowRight'></div>
	<div id='povehicleConfigPowerTrainProfileArrowDown'></div>
	<div id='povehicleConfigPowerTrainProfileHeader'>Vehicle Configuration and Powertrain Profile</div>
	</div>
	<div class='clear'></div>
	<div id='povehicleConfigPowerTrainProfileBoxHolder'>
	<div id='povehicleConfigPowerTrainProfileText'>
	$vehicleConfigPowerTrainProfile
	</div>
	</div>
	<div class='clear'></div>
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
			
			$('#poKeyPointsBox').mouseover(function(){
			$('#poKeyPointsBox').css('cursor','pointer');
			});
			$('#poKeyPointsBox').mouseout(function(){
			$('#poKeyPointsBox').css('cursor','default');
			});
			$('#poKeyPointsBox').click(function(){
			$('#poKeyPointsBoxHolder').toggle();
			
			$("#poKeyPointsArrowRight").toggle();
			$("#poKeyPointsArrowDown").toggle();
			});
			
			$('#poFutureIntelBox').mouseover(function(){
			$('#poFutureIntelBox').css('cursor','pointer');
			});
			$('#poFutureIntelBox').mouseout(function(){
			$('#poFutureIntelBox').css('cursor','default');
			});
			$('#poFutureIntelBox').click(function(){
			$('#poFutureIntelBoxHolder').toggle();
			
			$("#poFutureIntelArrowRight").toggle();
			$("#poFutureIntelArrowDown").toggle();
			});
			
			
			
			$('#poCGEquipUpdatesBox').mouseover(function(){
			$('#poCGEquipUpdatesBox').css('cursor','pointer');
			});
			$('#poCGEquipUpdatesBox').mouseout(function(){
			$('#poCGEquipUpdatesBox').css('cursor','default');
			});
			$('#poCGEquipUpdatesBox').click(function(){
			$('#poCGEquipUpdatesBoxHolder').toggle();
			
			$("#poCGEquipUpdatesArrowRight").toggle();
			$("#poCGEquipUpdatesArrowDown").toggle();
			});
			
			$('#poCGLaunchInfoBox').mouseover(function(){
			$('#poCGLaunchInfoBox').css('cursor','pointer');
			});
			$('#poCGLaunchInfoBox').mouseout(function(){
			$('#poCGLaunchInfoBox').css('cursor','default');
			});
			$('#poCGLaunchInfoBox').click(function(){
			$('#poCGLaunchInfoBoxHolder').toggle();
			
			$("#poCGLaunchInfoArrowRight").toggle();
			$("#poCGLaunchInfoArrowDown").toggle();
			});
			
			
			
			$('#poPriorGenerationInfoBox').mouseover(function(){
			$('#poPriorGenerationInfoBox').css('cursor','pointer');
			});
			$('#poPriorGenerationInfoBox').mouseout(function(){
			$('#poPriorGenerationInfoBox').css('cursor','default');
			});
			$('#poPriorGenerationInfoBox').click(function(){
			$('#poPriorGenerationInfoBoxHolder').toggle();
			
			$("#poPriorGenerationInfoArrowRight").toggle();
			$("#poPriorGenerationInfoArrowDown").toggle();
			});
			
			$('#povehicleConfigPowerTrainProfileBox').mouseover(function(){
			$('#povehicleConfigPowerTrainProfileBox').css('cursor','pointer');
			});
			$('#povehicleConfigPowerTrainProfileBox').mouseout(function(){
			$('#povehicleConfigPowerTrainProfileBox').css('cursor','default');
			});
			$('#povehicleConfigPowerTrainProfileBox').click(function(){
			$('#povehicleConfigPowerTrainProfileBoxHolder').toggle();
			
			$("#povehicleConfigPowerTrainProfileArrowRight").toggle();
			$("#povehicleConfigPowerTrainProfileArrowDown").toggle();
			});
			
			$('#collapse').mouseover(function(){
			$('#collapse').css('cursor','pointer');
			});
			
			$('#collapse').mouseout(function(){
			$('#collapse').css('cursor','default');
			});
			
			$('#collapse').click(function(){
			$('#poKeyPointsBoxHolder').slideUp();
			$('#poFutureIntelBoxHolder').slideUp();
			$('#poCGEquipUpdatesBoxHolder').slideUp();
			$('#poCGLaunchInfoBoxHolder').slideUp();
			$('#poPriorGenerationInfoBoxHolder').slideUp();
			
			$('#povehicleConfigPowerTrainProfileBoxHolder').slideUp();
			
			
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
			$('#poKeyPointsBoxHolder').slideDown();
			$('#poFutureIntelBoxHolder').slideDown();
			$('#poCGLaunchInfoBoxHolder').slideDown();
			$('#poCGEquipUpdatesBoxHolder').slideDown();
			$('#poPriorGenerationInfoBoxHolder').slideDown();
			
			$('#povehicleConfigPowerTrainProfileBoxHolder').slideDown();
			
			});
</script>
SCR;
echo $basicBar;
?>