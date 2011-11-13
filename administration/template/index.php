<html>
	<head>
		<title>eAutoPacific - Home</title>
		<link rel="stylesheet" href="<?php echo $live_site; ?>/template/css/autopacific.css" type="text/css" />
	</head>
	<body marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" bgcolor="#ffffff"  onLoad="//soopaSetup();">
	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<!-- Car Image Column Hear Row -->
		<td width="194" height="147" bgcolor="#FF7029" valign="top"><img src="media/images/tlCornerImage.jpg" border="0" /></td>
		<!-- Header BG + Nav -->
		<td bgcolor="#FF7029" valign="top">
			<table border="0" cellspacing="0" cellpadding="0" height="102" width="100%">
			<tr>
				<td width="510" height="102" align="left"><img src="media/images/headerLeft.jpg" border="0" /></td>
				<td background="media/images/headerRepeat.jpg"><img src="media/images/spacer.gif" border="0" /></td>
				<td width="295" height="102" align="right"><img src="media/images/headerRight.jpg" border="0" /></td>
			</tr>
			</table>
			<table border="0" cellspacing="0" cellpadding="0" height="45" width="100%">
			<tr>
				<td width="10" height="45" align="left"><img src="media/images/navLeft.jpg" border="0" /></td>
				<td background="media/images/navRepeat.jpg" valign="top">
					<table border="0" cellspacing="0" cellpadding="0" height="17">
					<tr>
						<?php system::getMenu('navigation'); ?>
					</tr>
					<tr>
						<td colspan="13" align="center"><?php system::getModule('login'); ?></td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<!-- Left Navigation Column -->
		<td width="194" bgcolor="#D2BEB5" align="center" valign="top">
			<?php system::getMenu('navigation2'); ?>
		</td>
		<!-- Main Content Column -->
		<td valign="top">
			<?php system::getModule('breadcrumb'); ?>
			<?php system::getModule('message'); ?>
			<?php system::getModule('error'); ?>
			<?php system::getComponent(); ?>
		</td>
	</tr>
	<tr>
		<!-- Footer Row -->
		<td colspan="2" height="54" background="media/images/footerbg.gif"><img src="media/images/spacer.gif" border="0" width="100%" height="54" /></td>
	</tr>
	</table>
	<!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->



  <!-- scripts concatenated and minified via build script -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js" type="text/javascript"></script>
<script>window.jQuery || document.write('<script src="media/js/libs/jquery-1.6.4.min.js"><\/script>')</script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js" type="text/javascript"></script>


  <script defer src="media/js/plugins.js"></script>
  
  <script defer src="media/js/script.js"></script>
  

  <!-- end scripts -->

</script>
	</body>
</html>
