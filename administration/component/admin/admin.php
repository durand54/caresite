<?php
global $my;

defined('_VALID_PAGE') or die('Direct access not allowed');
if($my->admin_id==''){
	$system->error=_ERROR_NO_LOGIN;
	return;
}
global $system;
//session_start();
//require(system::getComponentPath('admin','/administration').'/admin_html.php');
//require(system::getComponentPath('eauto').'/eauto_db.php');
$path = system::getComponentPath('admin','admin_html.php');
//echo $path;
require_once($path);
require_once('includeAdmin/eauto_db.php');
$task=html::getInput($_GET,'task','admins');

switch($task){
	case 'admins':
		list_admins();
		break;
	case 'edit':
		edit();
		break;

}

function list_admins(){
	global $system;
	$action=html::getInput($_GET,'action');
	if($action=='delete'){
		$confirm=html::getInput($_GET,'confirm');
		$id=html::getInput($_GET,'id');
		if($confirm=='yes'){
			db::deleteByColumn('administrators','id',$id);
			$system->messages[]='Admin successfully deleted.';
		}else if($confirm=='no'){
		}else{
			$system->breadcrumbs['Adminstrator Access']='index.php?comp=admin';
			$system->breadcrumbs['Confirm Delete Administration Access']='';
			$row=db::fetchObjectByColumn('administrators','id',$id);
			$adminHtml=new adminHtml;
			$adminHtml->prompt='Are you sure you want to delete Administrator ';
			$adminHtml->prompt.=$row->username;
			$adminHtml->confirm();
			return;
		}
	}
	adminHtml::listAdmins();
}

function edit(){
	global $system;
	
	$adminHtml = new adminHtml;
	$submit=html::getInput($_POST,'submit');
	if($submit=='admin'){
		$id=html::getInput($_GET,'id');
		$fields=array(
			'name'=>'Name',
			'username'=>'Username',
			'email'=>'Email',
			'password'=>'Password'
			);
		$sets=html::getPosts($fields,$adminHtml);
		if(!$system->errors){
			db::addQuotes($sets);
			if($id){
				db::updateByColumn('administrators','id',$id,$sets);
			}else{
				db::insert('administrators',$sets);
			}
			$system->messages[]='Your changes have been saved.';
			adminHtml::listAdmins();
			return;
		}
	}
	$adminHtml->editAdmin();
}

?>