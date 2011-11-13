<?php
global $system;
if(isset($system->messages)){
$messages = '';
foreach($ystem->messages as $message){
$messages .="<div class='message' style='margin-left: 50px;'>$message<div><br />";
}
echo $messages;
}
?>