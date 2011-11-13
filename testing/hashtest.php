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

 
		<title>bbq web development testing</title>
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
  <li class="test" href="#filter=*" class="selected">show all</li>
  <li class="test" href="#filter=C - Sporty/35">metal</li>
  <li class="test" href="#filter=C - Executive Luxury/27">transition</li>
  <li class="test" href="#filter=C - Aspirational Luxury/14">alkali and alkaline-earth</li>
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
  $('.test').click(function(){
      // get href attr, remove leading #
  var href = $(this).attr('href').replace( /^#/, '' ),
      // convert href into object
      
      // i.e. 'filter=.inner-transition' -> { filter: '.inner-transition' }
      option = $.deparam( href, true );
      alert(href);
  // set hash, triggers hashchange on window
  $.bbq.pushState( option );
  return false;
	});
	$(window).bind( 'hashchange', function( event ){
  // get options object from hash
  var pathname = window.location.hash;
  pathname = pathname.replace(/^#filter=/,'');
  
  $('.segmentCallout').replaceWith('');
			  $.get("../index/make/"+pathname,function(txt){
			  $('.hello').append("<div class='segmentCallout'>"+txt+"</div>");
			  return false;
			  });

})
  // trigger hashchange to capture any hash data on init
  .trigger('hashchange');
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