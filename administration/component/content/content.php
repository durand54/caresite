<?php
global $my;

defined('_VALID_PAGE') or die('Direct access not allowed');
if($my->admin_id==''){
	$system->error=_ERRROR_NO_LOGIN;
	return;
}
global $system;
//session_start();
$path = system::getComponentPath('content','content_html.php');
//echo $path;
require_once($path);
require_once('includeAdmin/eauto_db.php');
//require_once(system::getComponentPath('content','content_html.php'));
//require(system::getComponentPath('eauto').'/eauto_db.php');
$task=html::getInput($_GET,'task','static');


switch($task){
	case 'files':
		fileControl::search();
		break;
	case 'file_entry':
		fileControl::edit();
		break;
	case 'background':
		$system->background_menu=true;
		backgroundControl::search();
		break;
	case 'background_edit':
		$system->background_menu=true;
		backgroundControl::edit();
		break;
	case 'press_releases':
		pressreleaseControl::search();
		break;
	case 'pressrelease':
		pressreleaseControl::edit();
		break;
	case 'static':
		static_page();
		break;
	case 'executive_summary':
		$system->background_menu=true;
		executiveSummary::search();
		break;
	case 'edit_summary':
		$system->background_menu=true;
		executiveSummary::edit();
		break;

}
class fileControl{
	function search(){
		global $system,$site_path,$upload_files_path;

		$action=html::getInput($_GET,'action');
		if($action=='delete'){
			$confirm=html::getInput($_GET,'confirm');
			$FileID=html::getInput($_GET,'id');
			if($confirm=='yes'){
				$row=db::fetchObjectByColumn('files','FileID',$FileID);
				unlink($site_path.$upload_files_path.'/'.$row->SourceFileName);
				db::deleteByColumn('files','FileID',$FileID);
				$system->messages[]='File successfully deleted.';
			}else if($confirm=='no'){
			}else{
				$system->breadcrumbs['Upload Files']='index.php?comp=content&task=files';
				$system->breadcrumbs['Confirm Delete Upload File']='';
				$contentHtml=new contentHtml;
				$contentHtml->header='Confirm Upload File Deletion';
				$contentHtml->prompt='Are you sure you want to delete this Upload File? ';
				$contentHtml->confirm();
				return;
			}
		}
		fileHtml::search();
	}
	function edit(){
		global $system,$site_path,$upload_files_path;
		
		$fileHtml = new fileHtml;
		$submit=html::getInput($_POST,'submit');
		if($submit=='file'){
			$FileID=$fileHtml->FileID=html::getInput($_GET,'id');
			$fields=array(
				'FileCaption'=>'Caption',
				'serviceid'=>'Service'
				);
			$posts=html::getPosts($fields,$fileHtml);
			switch($_FILES['file']['error']){
				case 1:
				case 2:
					$system->errors[]='File size limit exceded.';
					break;
				case 3:
					$system->errors[]='File upload incomplete.';
					break;
				case 4:
					if(!$FileID){
						$system->errors[]='Upload File is required.';
					}
					break;
			}
			if(!$system->errors&&$_FILES['file']['name']){
				$upload_path=$site_path.$upload_files_path;
				$upload_path=$upload_path.'/'.$_FILES['file']['name'];
				if(!move_uploaded_file($_FILES['file']['tmp_name'], $upload_path)){
					$system->errors[]='File upload was not succesfull.';
					$fileHtml->edit();
					return;
				}
				$posts['SourceFileName']=$_FILES['file']['name'];
				$posts['WebFileName']=$_FILES['file']['name'];
				$posts['FileSize']=$_FILES['file']['size']/1000;
			}
			if(!$system->errors){
				db::addQuotes($posts);
				$posts['ModifyDate']=date("Ymd");
				if($FileID){
					db::updateByColumn('files','FileID',$FileID,$posts);
				}else{
					$posts['UploadDate']=date("Ymd");
					db::insert('files',$posts);
				}
				$system->messages[]='Your changes have been saved.';
				$fileHtml->search();
				return;
			}
		}
		$fileHtml->edit();
	}
}
class backgroundControl{
	function search(){
		global $system;
		
		$submit=html::getInput($_POST,'submit');
		if($submit=='M'){
			$Content=html::getInput($_POST,'Content');
			db::updateByColumn('content','type',"'M'",array('Content'=>"'$Content'"));
			$system->messages[]='Your changes have been saved.';
		}else if($submit=='ROS'){
			$Content=html::getInput($_POST,'Content');
			db::updateByColumn('content','type',"'ROS'",array('Content'=>"'$Content'"));
			$system->messages[]='Your changes have been saved.';
		}
		backgroundHtml::search();
	}
	function edit(){
		backgroundHtml::edit();
	}
}
class pressreleaseControl{
	function search(){
		global $system;
		$action=html::getInput($_GET,'action');
		if($action=='delete'){
			$confirm=html::getInput($_GET,'confirm');
			$ContentID=html::getInput($_GET,'id');
			if($confirm=='yes'){
				db::update('content',$ContentID,array('DeleteFlag'=>'1'));
				$system->messages[]='Press Release successfully deleted.';
			}else if($confirm=='no'){
			}else{
				$system->breadcrumbs['Press Releases']='index.php?comp=content&task=press_releases';
				$system->breadcrumbs['Confirm Delete Press Release']='';
				$row=db::fetchObject('content',$ContentID);
				$contentHtml=new contentHtml;
				$contentHtml->header='Confirm Press Release Deletion';
				$contentHtml->prompt='Are you sure you want to delete this AutoPacific press release? ';
				$contentHtml->confirm();
				return;
			}
		}
		pressreleaseHtml::search();
	}
	function edit(){
		global $system;
		
		$pressreleaseHtml=new pressreleaseHtml;
		$submit=html::getInput($_POST,'submit');
		if($submit=='press_release'){
			$ContentID=html::getInput($_GET,'id');
			$fields=array(
				'Content'=>'Press Release',
				'PublishDate'=>'',
				'ArchiveDate'=>'',
				'ActiveFlag'=>''
				);
			$posts=html::getPosts($fields,$pressreleaseHtml);
			if(strstr($posts['ActiveFlag'],"on")){
				$posts['ActiveFlag']=$contentHtml->ActiveFlag=0;
			}else{
				$posts['ActiveFlag']=$contentHtml->ActiveFlag=1;
			}
			if(!$system->errors){
				if($posts['PublishDate']){
					$posts['PublishDate']=date("Ymd",strtotime($posts['PublishDate']));
				}
				if($posts['ArchiveDate']){
					$posts['ArchiveDate']=date("Ymd",strtotime($posts['ArchiveDate']));
				}
				db::addQuotes($posts);
				if($ContentID){
					db::update('content',$ContentID,$posts);
				}else{
					$posts['type']="'HPR'";
					db::insert('content',$posts);
				}
				$system->messages[]='Your changes have been saved.';
				$pressreleaseHtml->search();
				return;
			}
		}
		$pressreleaseHtml->edit();
	}
}
function static_page(){
	global $admin_site_path;
	
	$page=html::getInput($_GET,'page','home');
	require $admin_site_path."/component/content/$page.html";
}
class executiveSummary{
	function search(){
		global $system,$site_path;
		
		$backgroundHtml= new backgroundHtml;
		$action=html::getInput($_GET,'action');
		if($action=='delete'){
			$confirm=html::getInput($_GET,'confirm');
			if($confirm=='yes'){
				$upload_path=$site_path.'/media/execsumm';
				$ContentID=html::getInput($_GET,'id');
				$row=db::fetchObjectByColumn('content','ContentID',$ContentID);
				unlink($upload_path.'/'.$row->Content);
				db::deleteByColumn('content','ContentID',$ContentID);
				$system->messages[]='File successfully deleted.';
			}else if($confirm=='no'){
			}else{
				$system->breadcrumbs['Background Information']='index.php?comp=content&task=background';
				$system->breadcrumbs['Executive Summary']='index.php?comp=content&task=executive_summary';
				$system->breadcrumbs['Confirm Delete Executive Summary']='';
				$contentHtml=new contentHtml;
				$contentHtml->header='Confirm Executive Summary Deletion';
				$contentHtml->prompt='Are you sure you want to delete this Executive Summary? ';
				$contentHtml->confirm();
				return;
			}
		}
		$submit=html::getInput($_POST,'submit');
		if($submit=='ES'){
			switch($_FILES['Content']['error']){
				case 1:
				case 2:
					$system->errors[]='File size limit exceded.';
					break;
				case 3:
					$system->errors[]='File upoad incomplete.';
					break;
				case 4:
					$system->errors[]='Pdf required.';
					break;
			}
			if(!$system->errors){
				$upload_path=$site_path.'/media/execsumm';
				$ContentID=$backgroundHtml->ContentID=html::getInput($_GET,'id');
				$backgroundHtml->PublishDate=date("Ymd",strtotime(html::getInput($_POST,'PublishDate')));
				$Content_info=pathinfo($_FILES['Content']['name']);
				$upload_file=basename($_FILES['Content']['tmp_name']).'.'.$Content_info["extension"];
				$upload_path.='/'.$upload_file;
				if(!move_uploaded_file($_FILES['Content']['tmp_name'], $upload_path)){
					$system->errors[]='Pdf upload was not succesfull.';
					$backgroundHtml->editExecutiveSummary();
					return;
				}
				$sets=array('PublishDate'=>$backgroundHtml->PublishDate,
							'Content'=>$upload_file,
							'Type'=>'ES');
				db::addQuotes($sets);
				db::insert('content',$sets);
				$system->messages[]='Your changes have been saved.';
			}
		}
		$backgroundHtml->searchExecutiveSummary();
	}
	function edit(){
		global $system,$site_path;
	
		$backgroundHtml= new backgroundHtml;
		$submit=html::getInput($_POST,'submit');
		if($submit=='ES'){
			$fields=array(
				'PublishDate'=>'');
			$sets=html::getPosts($fields,$backgroundHtml);
			$ContentID=html::getInput($_GET,'id');
			$title=html::getInput($_POST,'title');
			if(!$system->errors){
				$query="select * from content where contentid='$ContentID'";
				$row=db::executeFetchObject($query);
				$position=strpos($row->Content,"<trunc>");
				if($position===false){
					$upload_file=$row->Content;
				}else{
					$upload_file=substr($row->Content,$position+7);
				}
				$sets['PublishDate']=date("Ymd",strtotime($sets['PublishDate']));
				db::addQuotes($sets);
				if($_FILES['Content']['name']){
					$upload_path=$site_path.'/media/execsumm';
					$Content_info=pathinfo($_FILES['Content']['name']);
					$upload_file=basename($_FILES['Content']['tmp_name']).'.'.$Content_info["extension"];
					$upload_path.='/'.$upload_file;
					if(!move_uploaded_file($_FILES['Content']['tmp_name'], $upload_path)){
						$system->errors[]='Pdf upload was not succesfull.';
						$backgroundHtml->editExecutiveSummary();
						return;
					}
				}
				if($ContentID){
				$sets['Content']="'$title<trunc>$upload_file'";
					db::updateByColumn('content','ContentID',$ContentID,$sets);
				}
				$system->messages[]='Your changes have been saved.';
			}
			$backgroundHtml->searchExecutiveSummary();
			return;
		}
		$backgroundHtml->editExecutiveSummary();
	}
}
?>