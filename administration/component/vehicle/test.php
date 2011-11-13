<?php
?>
<!DOCTYPE html>
<html>
<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title></title>
		</head>
		<body>
		<textarea class="Content"><p class='specificationsBox6Text'>For the next generation, GM is now expected to put the next Camaro on the upcoming Alpha RWD platform to be used also for the Cadillac ATS as well as the next generation CTS, with production tipped for Q1 2014 (2015MY).  The new platform should help create a lighter Camaro than the Holden-developed Zeta platform used for the current car.  Expect some cost-cutting from the platform to ensure appropriate pricing for a Chevrolet.  Entering production for 2015MY means a five-year lifecycle for this pony car.</p>
<p class='specificationsBox6Text'></p>
<p class='specificationsBox6Text'><b>Current Generation Equipment Updates.</b>  The rakish and long-awaited Camaro redux debuted in March 2009 as a 2010 model, a bright spot in an otherwise grim 2009.  Symbolically, it helped communicate to American taxpayers that the government bailout was worth it and that there was in fact a product renaissance underway.</p>
<p class='specificationsBox6Text'></p>
<p class='specificationsBox6Text'>The car debuted on the Holden-developed Zeta rear wheel drive platform and launched with a 304HP 3.6L V6 and two versions of the 6.2L V8: 425HP with the six-speed manual and 400HP with the six-speed automatic.  A high performance ZL1 with 580HP joined the lineup for 2012MY.</p>
</textarea>
<textarea class="Content1"></textarea>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js" type="text/javascript"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js" type="text/javascript"></script>
		<script type="text/javascript">
		$(document).ready(function() {
		/*var person = "{ name: 'John Doe' }"; // notice the double quotes here, this is a string, and not an object
		$.ajax({
		    type: "POST",
		    url: "test2.php",
		    dataType: "json",
		    data: { json: person }
		    });
		    success: function (data, status)
            {
              alert(data.msg);              
            }
            var dataString = 'name='+ name + '&email=' + email + '&phone=' + phone;  
//alert (dataString);return false;  
$.ajax({  
  type: "POST",  
  url: "bin/process.php",  
  data: dataString,  
  success: function() {  
    $('#contact_form').html("<div id='message'></div>");  
    $('#message').html("<h2>Contact Form Submitted!</h2>")  
    .append("<p>We will be in touch soon.</p>")  
    .hide()  
    .fadeIn(1500, function() {  
      $('#message').append("<img id='checkmark' src='images/check.png' />");  
    });  
  }  
}); 
val = val.replace(/\n/g,"").replace(/\r/g,""); */

var stuff = $('.Content').val();
/*var strSingleLineText = stuff.replace(
// Replace out the new line character.
new RegExp( "\\n", "g", "\\r" ),
 
// Put in ... so we can see a visual representation of where
// the new line characters were replaced out.
""
);
 
// Alert the new single-line text value.
//$('.Content').remove();
//$('.Content1').append(strSingleLineText);
//var tab= RegExp( "\\n", "\\r","g");
//var stuff = document.getElementById( "Content" ).value.replace(tab, "");
//alert(stuff); 
// Alert the new single-line text value.
alert( strSingleLineText );*/
			$.ajax({
			type : 'POST',
			url : 'test2.php',
			dataType : 'json',
			data: {
				email : stuff
			},
			success : function(data){
			$('.Content1').val(data.msg);
			}
			});
			
return false;
		});
		</script>
		</body>
		</html>