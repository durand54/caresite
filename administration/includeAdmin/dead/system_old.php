<?php
require($site_path.'/include/systemDB.php');
class system{
	function getComponent(){
		global $system;

		echo  $system->component_buffer;
	}
	
	function setComponent($component){
		$this->component=$component;
		$path = $this->site_path."/component/$component/$component.php";
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
		require $this->site_path."/template/$template.php";
	}
	
	function getMenu($menu){
		require $this->site_path."/menu/$menu.php";
	}
	
	function getmodule($module){
		require $this->site_path."/module/$module.php";
	}
	
	function getContent($content){
	}
	
	function getComponentPath($component='',$path=''){
		global $site_path;
		
		$component_path=$site_path.$path;
		$component==''?$component=$this->component:"";
		return $component_path."/component/$component";
	}
	function getAdminComponentPath($component=''){
		global $site_path;
		
		$component==''?$component=$this->component:"";
		return $site_path."/administration/component/$component";
	}
	
}

?>