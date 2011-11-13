<?php

?>
<?php
?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

 
		<title>bbq web development</title>
		<meta name="google-site-verification" content="-5xomB8gXcaE7udi22mCu5SZltaz80y5jKNTj27-nQQ" />
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

  <link rel="stylesheet" href="../css/style.css">
  
  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

  <!-- All JavaScript at the bottom, except this Modernizr build incl. Respond.js
       Respond is a polyfill for min/max-width media queries. Modernizr enables HTML5 elements & feature detects; 
       for optimal performance, create your own custom Modernizr build: www.modernizr.com/download/ -->
  <script src="../js/libs/modernizr-2.0.6.min.js"></script>
</head>

<body>
  <header>
	<h1></h1>
  </header>
  <div role="main">
  	<div id="container">
	<ul class="option-set">
		<li class="test" href="#filter=*">show all</li>
		<li class="test metal" href="#this.php" >metal<br /></li>
		<li class="test water" href="#that.php">water<br /></li>
		<li class="test air" href="#andtheother.php">air<br /></li>
	</ul>
	</div>
	<div class="hello"></div>
  </div>
  <footer>

  </footer>


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="../js/libs/jquery-1.6.4.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via build script -->
  <script defer src="../js/plugins.js"></script>
  <!--<script defer src="../js/script2.js"></script>-->
	 <script src="../js/mylibs/jquery.bbq.js"></script>
  
  <script>
  $(function(){
  $('.test').click(function(){
      // get href attr, remove leading #
 		var optional = $(this).attr('href').replace( /^#/, '' );
 		alert(optional);
  		var myObj = $.deparam( optional,true );
  		$.bbq.pushState(myObj);
  		var l = $.bbq.length;
     		alert(l);
//		var testing = $.deparam.fragment();
		$('.segmentCallout').replaceWith('');
			 //var newUrl = $.param.fragment( "index.php", "/"+selector+"/"+data+"/", 2 );
			  $.get(optional,function(txt){
			  $('.hello').append("<div class='segmentCallout'>"+txt+"</div>");
			  return false;
			  });
     		});
     		
     		$(window).bind('hashchange',function(event){
     		var testing = $.deparam.fragment();
     		
     		});
  });
  	/*$(function(){
  	var cache = {
  		'':$('.option-set')
  	}
  	
  	$('.test').click(function(){
      // get href attr, remove leading #
 		var optional = $(this).attr('href').replace( /^#/, '' );
  		var myObj = $.deparam( optional,true );
  		$.bbq.pushState(myObj);

     		});
  	
  	$(window).bind('hashchange', function(e){
  	
  		var url = $.param.fragment();
  		alert(url);
  		
  		$( 'test' ).removeClass( 'bbq-current' );
  		
  		  	
  	});
  	
  	$(window).trigger( 'hashchange' );
  });
  $(function(){

  		var testing = $('#container'),
  		tab_a_selector = 'ul.option-set';
  		
  		tabs.tabs({event:'change'});
  		
  		$('.test').click(function(){
      // get href attr, remove leading #
 		var optional = $(this).attr('href').replace( /^#/, '' );
  		var myObj = $.deparam( optional,true );
  		$.bbq.pushState(myObj);

     		});
		$(window).bind('hashchange',function(event){
			var hashOptional = $.deparam.fragment();
			var pathname = window.location.hash;
			alert(pathname);
			$.each( hashOptional, function(i, n){
    			alert(  n );
    			var selector = i;
			 		var data = n;
			 		$('.segmentCallout').replaceWith('');
			 //var newUrl = $.param.fragment( "index.php", "/"+selector+"/"+data+"/", 2 );
			  $.get("../index/make/"+selector+"/"+data,function(txt){
			  $('.hello').append("<div class='segmentCallout'>"+txt+"</div>");
			  return false;
			  });
    			
		});
		});
		$(function(){
		
		var cache = {
		 '':$('.segmentCallout').replaceWith('')
		};
		
		$('.test').click(function(){
			var optional = $(this).attr('href').replace(/^#/,'');
			alert(optional);
			var myObj = $.deparam(optional,true);
			$.bbq.pushState(myObj);
			//var pathname = window.location.hash;
			//alert(pathname);
			var link = optional.replace(/=/,'');
			alert("../index/make/"+link);
			$('.segmentCallout').replaceWith('');
			$.get("../index/make/"+link,function(txt){
			  $('.hello').append("<div class='segmentCallout'>"+txt+"</div>");
			  return false;
			  });
			 
			//window.location.hash = '';
		});
		
		$(window).bind('hashchange',function(e){
		var hashOptional = $.deparam.fragment();
		
			
		 //var url= $.param.fragment();
		 //$('.segmentCallout').replaceWith('');
		 //alert(url);
		});

  	});*/
  </script>
  
  <!-- end scripts -->


  <!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
       mathiasbynens.be/notes/async-analytics-snippet -->
  <script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview'],['_trackPageLoadTime']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>

  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script defer src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script defer>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->

</body>
</html>
