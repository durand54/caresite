<?php
//$site_path = '/Library/WebServer/Documents/administration/';
require_once('systemDB.php');
class system{
	function getComponent(){
		global $system;
		

		echo  $system->component_buffer;
	}
	
	function setComponent($component){
		$this->component=$component;
		$path = "component/$component/$component.php";
		ob_start();
		if(is_file($path)){
			include $path;
		}
		$this->component_buffer=ob_get_contents();
		ob_clean();
	}
	
	function getTemplate(){
		global $live_site;
		$component=html::getInput($_REQUEST,'comp');
		$task=html::getInput($_REQUEST,'task');
		$template=html::getInput($_REQUEST,'template','index');
		$page = "template/$template.php";
		require_once("$page");
	}
	
	function getMenu($menu){
		require_once("menu/$menu.php");
	}
	
	function getmodule($module){
		require_once("module/$module.php");
	}
	
	function getContent($content){
	}
	
	function getComponentPath($component,$content){
		//global $site_path;
		
		//$component_path=$site_path.$path;
		//$component==''?$component=$this->component:"";
		return "component/$component/$content";
	}
	function getAdminComponentPath($component=''){
		global $site_path;
		
		$component==''?$component=$this->component:"";
		return "component/$component";
	}
	
}

?>
