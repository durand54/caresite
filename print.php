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
$vehicleNamed = $vName." ".$sName;
$stringLength = strlen($vehicleNamed);
$style = '';
$clearing = '';
$carInsights = '';
if($stringLength>40){
	$style = "style='width:1024px;'";
}
$basicBar =<<<BAS
	<div id="carName" $style>$vehicleNamed</div>
	<div class="clear"></div>
	<div class="buttonRule"><div id="buttonBox1" class="basic" data-filter='$vID'>the basics</div><div id="buttonBox2" class="specifications"  data-filter='$vID'>specifications</div><div id="buttonBox2" class="photos"  data-filter='$vID'>photos</div><div id="buttonBox2" class="overview"  data-filter='$vID'>product overview</div><div id="buttonBox2" class="insights"  data-filter='$vID'>insights</div><div id="buttonBox3B" class="print"  data-filter='$vID'>print</div><div id="buttonBox2" class="salesforecast"  data-filter='$vID'>sales forecast</div><div id="english"  data-filter='$vID'>english</div><div id="slantBar"></div><div id="metric"  data-filter='$vID'>metric</div></div>
	<div class="clear"></div>
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
</script>
SCR;
echo $basicBar;
?>