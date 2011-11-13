<?php
/*
**insuring that there are no sessions set
*/
session_start();

//ini_set('display_errors','On');

date_default_timezone_set('America/Los_Angeles');

require_once('eapInc/configOS.php');

//session_start();
$date = date("Y-m-d");
$cookie = $_COOKIE['day'];
//echo $date." cookie ".$cookie.'<br />';
$cID = '';
$cID .= $_COOKIE['cid'];
if($date == $cookie){
$timer = $_COOKIE['last'];
$timely = date("G.i");
$timed = $timely-$timer;
//echo $timer." timely ".$timely.'<br />'.$timed.'<br />cid'.$cID;
if($timed<.20){

if($cID != ''){
//echo '<br />cid'.$cID;
$target4 = 'http://eap.rcomcreative.com/index';
header('Location:'.$target4);
} 
}
}else {
//}


sessionLogout();


}

function sessionLogout(){
$sessionName = session_id();
$sessionCookie = session_get_cookie_params();
function logout(){
    $_SESSION = array(); 
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_unset();
    session_destroy();
}

logout();
}

/*
**end of session killer
*/

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

</head>

<body>
  <header class="loginWrapper">



  <h1 class="head">eAutoPacific Authoritative Automotive Research & Insight</h1>
  <div id="header">
  <div class="inner">
  <div role="main">
  <!--<div id="loginBox">-->
  <div id="login">
  
  <div class="userPass">
  		<form id="myFormL" action="form.php" method="post" class="secure">
		<div class="boxLeft3 text">User Name:</div>
		<div class="boxLeft text"><input type="text" name="uName" value=""  /></div>
		<div class="clear"></div>
		<div class="boxLeft4 text">Password:</div>
		<div class="boxLeft2 text"><input type="password" name="pass" value=""  /></div>
		<div class="clear"></div>
		<input class="login" type="submit" name="submit" value="Login" />
		
		</form>
		<div class="account">Don't have an account?</div>
		
		</div>
  
  </div>
  <!--</div>-->
  </div>
  </div>
  <div class="push"></div>
  </div>
		
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
		
  </footer>


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->



  <!-- scripts concatenated and minified via build script -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js" type="text/javascript"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.4.min.js"><\/script>')</script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js" type="text/javascript"></script>


  <script defer src="js/plugins.js"></script>
  
  <script defer src="js/script.js"></script>
  

  <!-- end scripts -->

</script>

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
