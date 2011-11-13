<?php
global $system;
if(isset($system->errors)){
$errors = "";
	foreach($system->errors as $error){
	$errors .="<div class='redBold' style='margin-left:50px;'>$error</div><br />";
	}
echo $errors;
}
?>