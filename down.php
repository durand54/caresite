<?php
$img = mysql_escape_string($_GET['n']);
//echo $img;
/*if($img !=''){
header("Content-disposition: attachment; filename=$img");
//header('Content-type: image/jpg');
readfile("img/upload_photos/$img");

}*/

$tempFileName4 = "hello";
$lName = 'jones';
$company = 'inskyle';
$phone = '7605679540';
$emailAddress = 'irldurandjones@gmail.com';

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js" type="text/javascript"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.4.min.js"><\/script>')</script>
<script type="text/javascript">
		

		    
		var data = "<?php echo $img; ?>";
		alert(data);
		$('.segmentCallout').replaceWith('');
		$.load("/download.php?f="+data);	
  		var flashvars = {
  			fName: "/<?php echo $img; ?>",
  			lName: "<?php echo $lName; ?>",
  			company: "<?php echo $company; ?>",
  			phone: "<?php echo $phone; ?>",
  			emailAddress: "<?php echo $emailAddress; ?>"
			}

</script>
</head>
<body>
<div class="segmentCallout">hello</div>
</body></html>