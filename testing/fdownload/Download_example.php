<?php
	
	include('includes/Download.class.php');
	
	$serve=new Download('test.pdf');
	$serve->rename('proba.pdf');
	$serve->resume();
	$serve->speed(256);
	$serve->start();
	if ($serve->error)	echo $serve->error;
	unset($serve);
	
?>