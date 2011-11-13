<?php
$img = mysql_escape_string($_GET['n']);
if($img !=''){
header("Content-disposition: attachment; filename=$img");
//header('Content-type: image/jpg');
readfile("img/upload_photos/$img");
?>