<?php
global $system;
if(isset($system->messages)){
?>
<br />
<?php
	foreach($system->messages as $message){
?>
<div class="message" style="margin-left:50px;"><?php echo $message; ?></div>
<?php } ?>
<br />
<?php
}
?>
