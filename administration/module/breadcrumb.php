<?php
global $my,$system;
if(isset($my->admin_id)){
if(isset($system->breadcrumbs)){
$length = count($system->breadcrumbs);
$i = 1;
$links =<<<LNK
	<div style='font-size:10px;margin-left:10px;margin-top:10px;'>You Are Here:
	<span>
LNK;
foreach($system->breadcrumbs as $breadcrumb=>$url){
	if($length != $i++){
	$links .="<a class='linkBlack' href='$url' >$breadcrumb</a>";
	} else {
	$links .=$breadcrumb;
	}
}
$links .="</span></div>";
echo $links;
}
} else {
return;
}

?>