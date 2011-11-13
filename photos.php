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
			$ModelYear = $value['ModelYear'];
			}
}
unset($mainVehiclePhoto);
$vehicleArray = array();
$vehicleLargePhotoArray = array();
$vehiclePhotos = $db->get("SELECT * from vehiclephoto where VehicleID = $vID ORDER BY `vehiclephoto`.`ModelYear` DESC");
if($vehiclePhotos){
	while(list($key,$value)= each($vehiclePhotos)){
			$LargeVehiclePhoto2 = $value['LargeFileName'];
			$MediumVehiclePhoto = $value['MediumFileName'];
			$SmallVehiclePhoto = $value['SmallFileName'];
			$PhotoCaption = $value['PhotoCaption'];
			$ModelYear = $value['ModelYear'];
			$PhotoCredit = $value['PhotoCredit'];
			$array = array($LargeVehiclePhoto2,$MediumVehiclePhoto,$SmallVehiclePhoto,$PhotoCaption,$ModelYear,$PhotoCredit);
			array_push($vehicleArray,$array);
			$array2 = array($LargeVehiclePhoto2,$ModelYear,$PhotoCaption);
			array_push($vehicleLargePhotoArray,$array2);
	}
}
unset($vehiclePhotos);
$counting = count($vehicleArray);
$count = floor($counting/5);
$remainder = $counting%5;
$count3 = count($vehicleLargePhotoArray);

$carphoto = array();

for($u=0;$u<$count3;$u++){
	$car = "image";
	$model = "modelYear";
	$list[$car] = $vehicleLargePhotoArray[$u][0];
	$list[$model] = "Model Year: ".$vehicleLargePhotoArray[$u][1]." ".$vehicleLargePhotoArray[$u][2];
	array_push($carphoto,$list);
}
$str = json_encode($carphoto);

$vehicleArray2 = $vehicleArray;
$vehicleArray3 = $vehicleArray;

for($i=0;$i<$remainder;$i++){
	array_pop($vehicleArray);
}
$counter = count($vehicleArray);


$counted = $counting-$remainder;

for($e=0;$e<$counted;$e++){
	array_shift($vehicleArray2);
}
$count2 = count($vehicleArray2);


$rows = "";
for($e=0;$e<$counter;$e++){

	$j = $e%5;
	
	$LargePhoto = $vehicleArray[$e][0];
	$PlaceHolderPhoto = $vehicleArray[$e][1];
	$ModelYear = $vehicleArray[$e][4];
	$PhotoCaption = $vehicleArray[$e][3];
	$PhotoCredit = '';
	$PhotoCredits = '';
	$PhotoCredit = $vehicleArray[$e][5];
	if($PhotoCredit !=''){
	$PhotoCredits = $PhotoCredit;
	}
	$modelYears = 'Model Year: '.$ModelYear.'<br />'.$PhotoCaption.'<br />'.$PhotoCredits;
	
	
	switch ($j) {
	case "0":
	$rows .=<<<ROW
<div class='photoBoxRow'>
<div class='autoBox1'>
<div class='autoBoxPhoto' photo-number='$e' data-filter='$LargePhoto' name='Model Year: $ModelYear $PhotoCaption'><img src='/img/upload_photos/$PlaceHolderPhoto' alt='$PhotoCaption" width="176px' /></div>
<div class='autoBoxText'>$modelYears</div>
</div>
ROW;
	break;
	case "1":
	$rows .=<<<ROW
<div class="autoBox">
<div class='autoBoxPhoto' photo-number='$e' data-filter='$LargePhoto' name='Model Year: $ModelYear $PhotoCaption'><img src='/img/upload_photos/$PlaceHolderPhoto' alt='$PhotoCaption" width="176px' /></div>
<div class='autoBoxText'>$modelYears</div>
</div>
ROW;
	break;
	case "2":
		$rows .=<<<ROW
<div class="autoBox">
<div class='autoBoxPhoto' photo-number='$e' data-filter='$LargePhoto' name='Model Year: $ModelYear $PhotoCaption'><img src='/img/upload_photos/$PlaceHolderPhoto' alt='$PhotoCaption" width="176px' /></div>
<div class='autoBoxText'>$modelYears</div>
</div>
ROW;
	break;
	case "3":
		$rows .=<<<ROW
<div class="autoBox">
<div class='autoBoxPhoto' photo-number='$e' data-filter='$LargePhoto' name='Model Year: $ModelYear $PhotoCaption'><img src='/img/upload_photos/$PlaceHolderPhoto' alt='$PhotoCaption" width="176px' /></div>
<div class='autoBoxText'>$modelYears</div>
</div>
ROW;
	break;
	case "4":
		$rows .=<<<ROW
<div class="autoBox">
<div class='autoBoxPhoto' photo-number='$e' data-filter='$LargePhoto' name='Model Year: $ModelYear $PhotoCaption'><img src='/img/upload_photos/$PlaceHolderPhoto' alt='$PhotoCaption" width="176px' /></div>
<div class='autoBoxText'>$modelYears</div>
</div>
</div>
ROW;
	break;
	}
	
}

if($remainder != 0){
$rows .=<<<ROW
<div class='photoBoxRow'>
ROW;
for($k = 0; $k<$remainder;$k++){
	$LargePhoto = $vehicleArray2[$k][0];
	$PlaceHolderPhoto = $vehicleArray2[$k][1];
	$ModelYear = $vehicleArray2[$k][4];
	$PhotoCaption = $vehicleArray2[$k][3];
	$PhotoCredit = '';
	$PhotoCredits = '';
	$PhotoCredit = $vehicleArray2[$k][5];
	if($PhotoCredit !=''){
	$PhotoCredits = $PhotoCredit;
	}
	$modelYears = 'Model Year: '.$ModelYear.'<br />'.$PhotoCaption.'<br />'.$PhotoCredits;
	$rows .=<<<ROW
<div class="autoBox">
<div class='autoBoxPhoto' photo-number='$k' data-filter='$LargePhoto' name='Model Year: $ModelYear $PhotoCaption'><img src='/img/upload_photos/$PlaceHolderPhoto' alt='$PhotoCaption" width="176px' /></div>
<div class='autoBoxText'>$modelYears</div>
</div>
ROW;
}
$rows .="</div>\n";
}
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
	<div class="buttonRule"><div id="buttonBox1" class="basic" data-filter='$vID'>the basics</div><div id="buttonBox2" class="specifications"  data-filter='$vID'>specifications</div><div id="buttonBox2B" class="photos"  data-filter='$vID'>photos</div><div id="buttonBox2" class="overview"  data-filter='$vID'>product overview</div><div id="buttonBox2" class="insights"  data-filter='$vID'>insights</div><div id="buttonBox3" class="print"  data-filter='$vID'>print</div><div id="buttonBox2" class="salesforecast"  data-filter='$vID'>sales forecast</div><div id="english"  data-filter='$vID'>english</div><div id="slantBar"></div><div id="metric"  data-filter='$vID'>metric</div></div>
	<div class="clear"></div>
	<div id='accordionBoxTop'>
	<div id='accordionRule'><div id='collapse'>collapse all</div><div id='vertRule'></div><div id='expand'>expand all</div></div>
	</div>
	<div class='clear'></div>
	<div id='photosCaptionHeader'><div class="modelTexter">Model Year: $ModelYear $PhotoCaption</div></div>
	<div class='clear'></div>
	<div id='photoLeftArrow'></div>
	<div id='photoLeftArrow2'></div>
	<div id='photosPhotoBox' data-filter='$LargeVehiclePhoto'><img src='/img/upload_photos/$LargeVehiclePhoto' alt='$PhotoCaption' width='768px' class='carPhoto' data-filter='$LargeVehiclePhoto'/></div>
	
	<div id='photoRightArrow'></div>
	<div id='photoRightArrow2'></div>
	<div class='clear'></div>
	<div id='photoDownload'></div>
	<div id='photoDownload2'></div>
	<div class='clear'></div>
	<div id="photoGroupBox">
	$rows
	</div>
BAS;
$basicBar .=<<<SCR
	<script>
	//passing json from php to the javascript
	var myjson = {};
	function pass(a){
	myjson = a;
	}
	var a = $str;//json
	pass(a);
	//now json for java
	var count = ($count3);
	var counted = -1;
			$('#photoLeftArrow').data("c",count);
			$('#photoRightArrow').data("c",counted);
			
			$('#photoLeftArrow').mouseover(function(){
			$('#photoLeftArrow').hide();
			$('#photoLeftArrow2').show();
			$('#photoLeftArrow2').css('cursor','pointer');
			/*var counter = ($('#photoLeftArrow').data("c")-1);
			var counter2 = ($('#photoRightArrow').data("c")+1);
			$('#photoRightArrow').data("c",counter2);
			alert($('#photoRightArrow').data("c"));
			$('#photoLeftArrow').data("c",counter);
			alert(myjson[counter].image);*/
			});
			
			$('#photoLeftArrow2').mouseout(function(){
			$('#photoLeftArrow').show();
			$('#photoLeftArrow2').hide();
			$('#photoLeftArrow2').css('cursor','default');
			$('#photoLeftArrow').css('cursor','default');
			});
			
			$('#photoLeftArrow2').click(function(){
			
			
			var counter = ($('#photoLeftArrow').data("c")-1);
			var minus = 0;
			
			$('#photoLeftArrow').data("c",counter);
			$('#photoRightArrow').data("c",counter);
			
			if(counter>=minus){
			var photonumber = myjson[counter].image;
			var name = myjson[counter].modelYear;
			var image = "/img/upload_photos/"+photonumber;
			var data = photonumber;
			var size = "768px";
			 $('.modelTexter').replaceWith('');
			 $('.carPhoto').replaceWith('');
			 $('#photosCaptionHeader').append("<div class='modelTexter'>"+name+"</div>");
  			 $('#photosPhotoBox').append('<img src='+image+' alt='+name+' width='+size+' class="carPhoto" data-filter'+data+'/>');
			
			} else {
			
			var countplus = ($count3-1);
			$('#photoLeftArrow').data("c",countplus);
			var photonumber = myjson[countplus].image;
			var name = myjson[countplus].modelYear;
			var image = "/img/upload_photos/"+photonumber;
			var data = photonumber;
			var size = "768px";
			 $('.modelTexter').replaceWith('');
			 $('.carPhoto').replaceWith('');
			 $('#photosCaptionHeader').append("<div class='modelTexter'>"+name+"</div>");
  			 $('#photosPhotoBox').append('<img src='+image+' alt='+name+' width='+size+' class="carPhoto" data-filter'+data+'/>');
  			  
			}
			return false;
			});
			
			$('#photoRightArrow').mouseover(function(){
			$('#photoRightArrow').hide();
			$('#photoRightArrow2').show();
			$('#photoRightArrow2').css('cursor','pointer');
			
			});
			
			$('#photoRightArrow2').mouseout(function(){
			$('#photoRightArrow').show();
			$('#photoRightArrow2').hide();
			$('#photoRightArrow2').css('cursor','default');
			$('#photoRightArrow').css('cursor','default');
			});
			
			$('#photoRightArrow2').click(function(){
			
			
			var counter = ($('#photoRightArrow').data("c")+1);
			var minus = $count3;
			
			$('#photoRightArrow').data("c",counter);
			$('#photoLeftArrow').data("c",counter);
			
			if(counter<minus){
			var photonumber = myjson[counter].image;
			var name = myjson[counter].modelYear;
			var image = "/img/upload_photos/"+photonumber;
			var data = photonumber;
			var carclass = 'carPhoto';
			var size = "768px";
			 $('.modelTexter').replaceWith('');
			 $('.carPhoto').replaceWith('');
			 $('#photosCaptionHeader').append("<div class='modelTexter'>"+name+"</div>");
  			 $('#photosPhotoBox').append("<img src="+image+" width="+size+" class='carPhoto' data-filter="+data+" ></img>");
			
			} else {
			
			var countplus = 0;
			$('#photoRightArrow').data("c",countplus);
			var photonumber = myjson[countplus].image;
			var name = myjson[countplus].modelYear;
			var image = "/img/upload_photos/"+photonumber;
			var data = photonumber;
			var carclass = 'carPhoto';
			var size = "768px";
			 $('.modelTexter').replaceWith('');
			 $('.carPhoto').replaceWith('');
			 $('#photosCaptionHeader').append("<div class='modelTexter'>"+name+"</div>");
  			 $('#photosPhotoBox').append("<img src="+image+" width="+size+" class='carPhoto' data-filter="+data+" ></img>");
  			  
			}
			return false;
			});
			
			$('.autoBoxPhoto').click(function(){
			
			  $(this).css({'background-color':'#4CBCFA','font-size':'14px','font-weight':'700'});
			  var name = $(this).attr('name');
			  var data = $(this).attr('data-filter');
			  var image = "/img/upload_photos/"+data;
			  
			  var photodata = parseInt($(this).attr('photo-number'));
				//alert(photodata);
			  $('#photoLeftArrow').data("c",photodata);
   			  $('#photoRightArrow').data("c",photodata);	
				//alert($('#photoRightArrow').data("c"));
			  $('.modelTexter').replaceWith('');
			  $('.carPhoto').replaceWith('');
  			  $('#photosCaptionHeader').append("<div class='modelTexter'>"+name+"</div>");
  			  $('#photosPhotoBox').append('<img src='+image+' alt='+name+' width="768px" class="carPhoto" data-filter='+data+'/>');
  			  window.scrollTo(0, 0);
  			  
  			  
			  });	
			  
			  
			$('#photoDownload').mouseover(function(){
			$('#photoDownload').css('cursor','pointer');
			$('#photoDownload').hide();
			$('#photoDownload2').show();
			$('#photoDownload2').css('cursor','pointer');
			});
			
			$('#photoDownload2').mouseout(function(){
			$('#photoDownload2').css('cursor','default');
			$('#photoDownload').css('cursor','default');
			$('#photoDownload2').hide();
			$('#photoDownload').show();
			});
			
			
		//PHOTO DOWNLOAD	
			$('#photoDownload2').click(function(e) {
    		e.preventDefault();
    		var data = $('.carPhoto').attr('data-filter');
    		//alert(data);
    		$.download('/download.php','f=' + data );
    		//$('.formula').form.reset();
    		//$.download.unbind();
		      //  return false;
			});
			
			
			
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
			
			$('#collapse').mouseover(function(){
			$('#collapse').css('cursor','pointer');
			});
			
			$('#collapse').mouseout(function(){
			$('#collapse').css('cursor','default');
			});
			
			$('#collapse').click(function(){
			$('#photoGroupBox').slideUp();
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
			$('#photoGroupBox').slideDown();
			});
</script>
SCR;
echo $basicBar;
?>