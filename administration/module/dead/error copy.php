<?php
global $system;
if(isset($system->errors)){
?>
<br />
<?php
	foreach($system->errors as $error){
?>
<div class="redBold" style="margin-left:50px;"><? echo $error?></div>
<?}?>
<br />
<?php
}?>
