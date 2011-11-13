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
$inSightsAutoPacificsTake = '';
$isAutoPacificsTake = $db->get("SELECT * FROM vehicleAutoPacificsTake where vehicleID = '$vID'");
			if($isAutoPacificsTake){
				while(list($key,$value) = each($isAutoPacificsTake)){
    			$inSightsAutoPacificsTake = $value['autopacificsTake'];
    		}
    		}
			unset($isAutoPacificsTake);
$yourTakeText= '';
$isYourTake = $db->get("SELECT * FROM vehicleYourTake WHERE vehicleID ='$vID' AND subscribersID ='$cID'");
			if($isYourTake){
				while(list($key,$value) = each($isYourTake)){
    			$yourTakeText .= $value['yourTake'];
    		}
    		}
			unset($isYourTake);
$yourTakeText2= '';
$isYourTake2 = $db->get("SELECT * FROM vehicleYourTake WHERE vehicleID ='$vID' AND subscribersID ='$cID' AND entrydate = '$entrydate'");
			if($isYourTake2){
				while(list($key,$value) = each($isYourTake2)){
    			$yourTakeText2 = $value['yourTake'];
    			$yourTakeText2 = preg_replace('~\s+\S+$~', '', $yourTakeText2);
    		}
    		}
			unset($isYourTake2);

$insightFile= '';
$isInsightFile = $db->get("SELECT * FROM vehicleinsightfile WHERE  `VehicleID` = '$vID'");
			if($isInsightFile){
				while(list($key,$value) = each($isInsightFile)){
    			$insightFile = $value['insightFile'];
    		}
    		}
			unset($isInsightFile);
			

$vehicleNamed = $vName." ".$sName;
$stringLength = strlen($vehicleNamed);
$style = '';
$clearing = '';
$carInsights = '';
if($stringLength>40){
	$style = "style='width:1024px;'";
}


$basicBar =<<<BAS
	<div id='inSights'>
	<div id='carName' $style>$vehicleNamed</div>
	<div class='clear'></div>
	<div class="buttonRule"><div id="buttonBox1" class="basic" data-filter='$vID'>the basics</div><div id="buttonBox2" class="specifications"  data-filter='$vID'>specifications</div><div id="buttonBox2" class="photos"  data-filter='$vID'>photos</div><div id="buttonBox2" class="overview"  data-filter='$vID'>product overview</div><div id="buttonBox2B" class="insights"  data-filter='$vID'>insights</div><div id="buttonBox3" class="print"  data-filter='$vID'>print</div><div id="buttonBox2" class="salesforecast"  data-filter='$vID'>sales forecast</div><div id="english"  data-filter='$vID'>english</div><div id="slantBar"></div><div id="metric"  data-filter='$vID'>metric</div></div>
	<div class="clear"></div>
	<div id='accordionBoxTop'>
	<div id='accordionRule'><div id='collapse'>collapse all</div><div id='vertRule'></div><div id='expand'>expand all</div></div>
	</div>
	<div class='clear'></div>
	<div id='inSightsBox'>
	<div class='inSightsBoxHolder'>
	<div id='inSightsConsumersTakeBox'>
	<div id='inSightsConsumersTakeArrowRight'></div>
	<div id='inSightsConsumersTakeArrowDown'></div>
	<div id='inSightsConsumersTakeHeader'>The Consumer's Take</div>
	</div>
	<div id='inSightsConsumersTakeBoxHolder'>
	<div id='inSightsConsumersTakeTextBox'>
	<div id='pdfImage'></div>
	<div class='clear'></div>
	<div id='pdfDownload'></div>
	<div id='pdfDownload2' data-filter='$insightFile'></div>
	</div>
	</div>
	</div>
	<div id='insightsPhotoBox'>
	<img src='/img/upload_photos/$MediumVehiclePhoto' alt='$PhotoCaption' width='461px' />
	</div>
	</div>
	<div class='clear'></div>
	<div class='insightsAccordionRule'></div>
	<div class='clear'></div>
	<div id='inSightsAutoPacificsTakeBox'>
	<div id='inSightsAutoPacificsTakeArrowRight'></div>
	<div id='inSightsAutoPacificsTakeArrowDown'></div>
	<div id='inSightsAutoPacificsTakeHeader'>AutoPacific's Take</div>
	</div>
	<div class='clear'></div>
	<div id='inSightsAutoPacificsTakeBoxHolder'>
	<div id='inSightsAutoPacificsTakeText'>
	$inSightsAutoPacificsTake
	</div>
	</div>
	<div class='clear'></div>
	<div class='insightsAccordionRule'></div>
	<div class='clear'></div>
	<div id='inSightsYourTakeBox'>
	<div id='inSightsYourTakeArrowRight'></div>
	<div id='inSightsYourTakeArrowDown'></div>
	<div id='inSightsYourTakeHeader'>Your Take</div>
	</div>
	<div class='clear'></div>
	<div id='inSightsYourTakeBoxHolder'>
	<div id='inSightsYourTakeText'>
	$yourTakeText
	</div>
	<div class='clear'></div>
	<textarea id="markItUp" class="markItUp" data-filter="vehicleYourTake" model='$vID' subscriber='$cID' >$yourTakeText2</textarea>
	</div>
	<div class='clear'></div>
	<div class='insightsAccordionRule'></div>
	<div class='clear'></div>
	</div>
BAS;
$basicBar .=<<<SCR
	<script src="js/mylibs/settings.js"></script>
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
			
			
			$('#pdfDownload').mouseover(function(){
			$('#pdfDownload').css('cursor','pointer');
			$('#pdfDownload').hide();
			$('#pdfDownload2').show();
			$('#pdfDownload2').css('cursor','pointer');
			});
			
			$('#pdfDownload2').mouseout(function(){
			$('#pdfDownload2').css('cursor','default');
			$('#pdfDownload').css('cursor','default');
			$('#pdfDownload2').hide();
			$('#pdfDownload').show();
			});
			
			
		//PDF DOWNLOAD	
			$('#pdfDownload2').click(function(e) {
    		e.preventDefault();
    		var data = $('#pdfDownload2').attr('data-filter');
    		//alert(data);
    		if(data != ''){
    		$.download('/download2.php','f=' + data );
    		}
    		//$('.formula').form.reset();
    		//$.download.unbind();
		      //  return false;
			});
			
			$('#inSightsConsumersTakeBox').mouseover(function(){
			$('#inSightsConsumersTakeBox').css('cursor','pointer');
			});
			$('#inSightsConsumersTakeBox').mouseout(function(){
			$('#inSightsConsumersTakeBox').css('cursor','default');
			});
			$('#inSightsConsumersTakeBox').click(function(){
			$('#inSightsConsumersTakeBoxHolder').toggle();
			
			$("#inSightsConsumersTakeArrowRight").toggle();
			$("#inSightsConsumersTakeArrowDown").toggle();
			});
			
			
			
			$('#inSightsAutoPacificsTakeBox').mouseover(function(){
			$('#inSightsAutoPacificsTakeBox').css('cursor','pointer');
			});
			$('#inSightsAutoPacificsTakeBox').mouseout(function(){
			$('#inSightsAutoPacificsTakeBox').css('cursor','default');
			});
			$('#inSightsAutoPacificsTakeBox').click(function(){
			$('#inSightsAutoPacificsTakeBoxHolder').toggle();
			
			$("#inSightsAutoPacificsTakeArrowRight").toggle();
			$("#inSightsAutoPacificsTakeArrowDown").toggle();
			});
			
			
			
			$('#inSightsYourTakeBox').mouseover(function(){
			$('#inSightsYourTakeBox').css('cursor','pointer');
			});
			$('#inSightsYourTakeBox').mouseout(function(){
			$('#inSightsYourTakeBox').css('cursor','default');
			});
			$('#inSightsYourTakeBox').click(function(){
			$('#inSightsYourTakeBoxHolder').toggle();
			
			$("#inSightsYourTakeArrowRight").toggle();
			$("#inSightsYourTakeArrowDown").toggle();
			});
			
			
			$('#collapse').mouseover(function(){
			$('#collapse').css('cursor','pointer');
			});
			
			$('#collapse').mouseout(function(){
			$('#collapse').css('cursor','default');
			});
			
			$('#collapse').click(function(){
			$('#inSightsYourTakeBoxHolder').slideUp();
			$('#inSightsAutoPacificsTakeBoxHolder').slideUp();
			$('#inSightsConsumersTakeBoxHolder').slideUp();
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
			
			$('#inSightsYourTakeBoxHolder').slideDown();
			$('#inSightsAutoPacificsTakeBoxHolder').slideDown();
			$('#inSightsConsumersTakeBoxHolder').slideDown();
			});
			
			
</script>
SCR;
echo $basicBar;
?>