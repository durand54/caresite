<?php
global $my,$system;

if($my->admin_id == '' || !isset($system->breadcrumbs)){
	return;
}

$length=count($system->breadcrumbs);
$i=1;
?>

<div style="font-size:10px;margin-left:10px;margin-top:10px;">You Are Here:
<span >
<?php
foreach($system->breadcrumbs as $breadcrumb=>$url){
	if($length != $i++){
?>
<a  class="linkBlack" href="<?php echo  $url;?>"><?php echo  $breadcrumb;?></a> >
<?php
	}else{
		echo  $breadcrumb;
	}
}
?>
</span>
</div>
