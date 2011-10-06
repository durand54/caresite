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
       More info: h5bp.com/b/378 
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

  <title>eautopacific dev</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->
	
  <link rel="stylesheet" href="css/start/jquery-ui-1.8.16.custom.css">
  <link rel="stylesheet" href="css/style.css">
  
  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->
	<style type="text/css">a.ui-dialog-titlebar-close { display:none }</style>
  <!-- All JavaScript at the bottom, except this Modernizr build incl. Respond.js
       Respond is a polyfill for min/max-width media queries. Modernizr enables HTML5 elements & feature detects; 
       for optimal performance, create your own custom Modernizr build: www.modernizr.com/download/ -->
  <script src="js/libs/modernizr-2.0.6.min.js"></script>
  <!--adaptive images script -->
  <script>document.cookie='resolution='+Math.max(screen.width,screen.height)+'; expires=; path=/';</script>

</head>

<body>
  <header class="wrapper">
    <div id="header2">
		<div class="inner">
		<div class="butt" id="competitive">
		<p class='competitive'>Competitive Battleground</p>
		<div class='arrow' id='battle' ></div>
		</div>
		<div id="logo"></div>
		<div class="buttTwo" id="sales">
		<p class='sales'>Sales Forecast Service</p>
		<div class='arrowTwo' id='forecast' ></div>
		</div>
		<div id="logout"></div>
		<div id="twitterEmail"></div>
		</div>
		</div>
	<div id="mainContent">
	<div class="inner">
	
		<div id="buttBar">
		<div class="butt make">make</div>
		<div class="butt segment">segment</div>
		<div class="butt customSegment">custom segment</div>
		<div class="butt comparison">comparison</div>
		</div>
		
		<div class="clear"></div>
	
		<div id="SFbuttBar">
		<div class="butt segmentSF">segment</div>
		<div class="butt makeSF">make</div>
		</div>
		
		<div class="clear"></div>
		
		<div id="makeBox">
		<?php echo $arraySet; ?>
		</div>
		
		<div class="clear"></div>
		<div id="segmentBox">
		<?php echo $SegmentArraySet; ?>
		</div>
		
		<div class="clear"></div>
		<div id="customSegmentBox">
		<?php echo $customSegmentArraySet; ?>
		</div>
		
		<div class="hello"></div>
	</div>
		
  		
	</div>
	
	<div class="push"></div>
  </header>
  <footer>
	<div class="footer">
		<div class="inner">
		<div id="loginLinkBox">
		<div id="eAutoPacificBrand"></div>	
		<div id="autoPacificBrand"></div>
		<div class="boxLeft">Contact</div>
		<div class="boxLeft">Help</div>
		<div class="boxLeft">Privacy</div>
		</div>
		
		
		</div>
		</div>
		<div id="dialog" title="Your session is about to expire!">
	<p>
		<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>
		You will be logged off in <span id="dialog-countdown" style="font-weight:bold"></span> seconds.
	</p>
	
	<p>Do you want to continue your session?</p>
</div>
  </footer>


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.4.min.js"><\/script>')</script>
	
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js" type="text/javascript"></script>

  <!-- scripts concatenated and minified via build script -->
  <script defer src="js/plugins.js"></script>
  <script defer src="js/script2.js"></script>
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