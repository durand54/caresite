<?php
global $my;

defined('_VALID_PAGE') or die('Direct access not allowed');
if($my->admin_id==''){
	$system->error=_ERRROR_NO_LOGIN;
	return;
}
global $system;
//session_start();
//require(system::getComponentPath('category','/administration').'/category_html.php');
//require(system::getComponentPath('eauto').'/eauto_db.php');
$path = system::getComponentPath('category','category_html.php');
//echo $path;
require_once($path);
require_once('includeAdmin/eauto_db.php');
$task=html::getInput($_GET,'task','list');

switch($task){
	case 'list':
		categoryControl::search();
		break;
	case 'listbodystyle':
		bodystyleControl::search();
		break;
	case 'editbodystyle':
		bodystyleControl::edit();
		break;
	case 'listdrive':
		driveControl::search();
		break;
	case 'editdrive':
		driveControl::edit();
		break;
	case 'editdivision':
		divisionControl::edit();
		break;
	case 'listengine':
		engineControl::search();
		break;
	case 'editengine':
		engineControl::edit();
		break;
	case 'listseat':
		seatControl::search();
		break;
	case 'editseat':
		seatControl::edit();
		break;
	case 'listtransmission':
		transmissionControl::search();
		break;
	case 'edittransmission':
		transmissionControl::edit();
		break;
	case 'listmake':
		makeControl::search();
		break;
	case 'editmake':
		makeControl::edit();
		break;
	case 'editmake_text':
		makeControl::editText();
		break;
	case 'editmakepr':
		makeControl::editPressrelease();
		break;
	case 'listsegment':
		segmentControl::search();
		break;
	case 'editsegment':
		segmentControl::edit();
		break;
	case 'editsegment_text':
		segmentControl::editText();
		break;
	case 'listdivision':
		divisionControl::search();
		break;
	case 'listmanufacturer':
		manufactureControl::search();
		break;
	case 'editmanufacturer':
		manufactureControl::edit();
		break;
	case 'listservice':
		serviceControl::search();
		break;
	case 'editcbg':
		serviceControl::edit();
		break;

	default:
		categoryControl::search();

}
class categoryControl{
	function search(){
		categoryHtml::search();
	}
}

class bodystyleControl{
	function search(){
		global $system;
		
		$action=html::getInput($_GET,'action');
		switch($action){
			case 'delete_bodystyle':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$bodystyleid=html::getInput($_GET,'id');
					$result=db::getResultByColumn('vehiclebodystyle','bodystyleid',$bodystyleid);
					if(mysql_num_rows($result)||!$result){
						$system->errors[]='Bodystyle is in use.';
					}else {
						db::deleteByColumn('bodystyle','bodystyleid',$bodystyleid);
						$system->messages[]='Bodystyle successfully deleted.';
					}
				}else if($confirm=='no'){
				}else{
					$system->breadcrumbs['Categories']='index.php?comp=category';
					$system->breadcrumbs['View Bodystyles ']='index.php?comp=category&task=listbodystyle';
					$system->breadcrumbs['Confirm Delete Bodystyle ']='';
					$categoryHTML=new categoryHTML;
					$categoryHTML->header='Confirm Bodystyle  Deletion';
					$categoryHTML->prompt='Are you sure you want to delete this Bodystyle ? ';
					$categoryHTML->confirm();
					return;
				}
				break;
		}
		bodystyleHtml::search();
	}
	function edit(){
		global $system;
		
		$bodystyleHtml = new bodystyleHtml;
		$submit=html::getInput($_POST,'submit');
		if($submit=='bodystyle'){
			$bodystyleid=html::getInput($_GET,'id');
			$fields=array(
				'name'=>'Name',
				'abbrev'=>'Abbreviation'
				);
			$sets=html::getPosts($fields,$bodystyleHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				if($bodystyleid){
					db::update('bodystyle',$bodystyleid,$sets);
				}else{
					$bodystyleid=db::insert('bodystyle',$sets);
				}
				$system->messages[]='Your changes have been saved.';
				$bodystyleHtml->search();
				return;
			}
		}
		$bodystyleHtml->edit();
	}
}
class driveControl{
	function search(){
		global $system;
	
		$driveHtml = new driveHtml;
		$action=html::getInput($_GET,'action');
		switch($action){
			case 'delete_drive':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$driveid=html::getInput($_GET,'id');
					$result=db::getResultByColumn('vehicledrive','driveid',$driveid);
					if(mysql_num_rows($result)||!$result){
						$system->errors[]='Drive Configuration is in use.';
					}else{
						db::deleteByColumn('drive','driveid',$driveid);
						$system->messages[]='Drive Configuration successfully deleted.';
					}
				break;
				}else if($confirm=='no'){
				}else{
					$system->breadcrumbs['Categories']='index.php?comp=category';
					$system->breadcrumbs['Drive Configurations']='index.php?comp=category&task=listtransmission';
					$system->breadcrumbs['Confirm Delete Drive Configuration']='';
					$categoryHTML=new categoryHTML;
					$categoryHTML->header='Confirm Drive Configuration Deletion';
					$categoryHTML->prompt='Are you sure you want to delete this Drive Configuration? ';
					$categoryHTML->confirm();
					return;
				}
		}
		$driveHtml->search();
	}
	function edit(){
		global $system;
		
		$driveHtml = new driveHtml;
		$submit=html::getInput($_POST,'submit');
		if($submit=='drive'){
			$driveid=html::getInput($_GET,'id');
			$fields=array(
				'name'=>'Name',
				);
			$sets=html::getPosts($fields,$driveHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				if($driveid){
					db::update('drive',$driveid,$sets);
				}else{
					db::insert('drive',$sets);
				}
				$system->messages[]='Your changes have been saved.';
				$driveHtml->search();
				return;
			}
		}
		$driveHtml->edit();
	}
}
class engineControl{
	function search(){
		$action=html::getInput($_GET,'action');
		switch($action){
			case 'delete_engine':
				$engineid=html::getInput($_GET,'id');
				$result=db::getResultByColumn('vehicleengine','engineid',$engineid);
				if(mysql_num_rows($result)||!$result){
					$system->errors[]='Engine Arrangement is in use.';
				}else{
					db::deleteByColumn('engine','engineid',$engineid,true);
				}
				break;
		}
		engineHtml::search();
	}
	function edit(){
		global $system;
		
		$engineHtml = new engineHtml;
		$submit=html::getInput($_POST,'submit');
		if($submit=='engine'){
			$engineid=html::getInput($_GET,'id');
			$fields=array(
				'name'=>'Name',
				);
			$sets=html::getPosts($fields,$engineHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				if($engineid){
					db::update('engine',$engineid,$sets);
				}else{
					db::insert('engine',$sets,true);
				}
				header("location:index.php?comp=category&task=listengine");
				exit;
			}
		}
		$engineHtml->edit();
	}
}
class seatControl{
	function search(){
		global $system;
		
		$action=html::getInput($_GET,'action');
		switch($action){
			case 'delete_seat':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$seatid=html::getInput($_GET,'id');
					$result=db::getResultByColumn('vehicleseat','seatid',$seatid);
					if(mysql_num_rows($result)||!$result){
						$system->errors[]='Seating Capacity is in use.';
					}else{
						db::deleteByColumn('seat','seatid',$seatid);
						$system->messages[]='Seating Capacity successfully deleted.';
					}
				}else if($confirm=='no'){
				}else{
					$system->breadcrumbs['Categories']='index.php?comp=category';
					$system->breadcrumbs['Seating Capacity']='index.php?comp=category&task=listseat';
					$system->breadcrumbs['Confirm Delete Seating Capacity']='';
					$categoryHTML=new categoryHTML;
					$categoryHTML->header='Confirm Seating Capacity Delete';
					$categoryHTML->prompt='Are you sure you want to delete this Seating Capacity? ';
					$categoryHTML->confirm();
					return;
				}
				
				break;
		}
		seatHtml::search();
	}
	function edit(){
		global $system;
		
		$seatHtml = new seatHtml;
		$submit=html::getInput($_POST,'submit');
		if($submit=='seat'){
			$seatid=html::getInput($_GET,'id');
			$fields=array(
				'seats'=>'Seating Capacity',
				);
			$sets=html::getPosts($fields,$seatHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				if($seatid){
					db::update('seat',$seatid,$sets);
				}else{
					db::insert('seat',$sets);
				}
				$system->messages[]='Your changes have been saved.';
				$seatHtml->search();
				return;
			}
		}
		$seatHtml->edit();
	}
}
class transmissionControl{
	function search(){
		global $system;
		
		$action=html::getInput($_GET,'action');
		switch($action){
			case 'delete_transmission':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$transmissionid=html::getInput($_GET,'id');
					$result=db::getResultByColumn('vehicletransmission','transmissionid',$transmissionid);
					if(mysql_num_rows($result)||!$result){
						$system->errors[]='Transmission has vehicles.';
					}else{
						db::deleteByColumn('transmission','transmissionid',$transmissionid);
						$system->messages[]='Transmission successfully deleted.';
					}
				}else if($confirm=='no'){
				}else{
					$system->breadcrumbs['Categories']='index.php?comp=category';
					$system->breadcrumbs['Transmissions']='index.php?comp=category&task=listtransmission';
					$system->breadcrumbs['Confirm Delete Transmission']='';
					$categoryHTML=new categoryHTML;
					$categoryHTML->header='Confirm Transmission Deletion';
					$categoryHTML->prompt='Are you sure you want to delete this Transmission? ';
					$categoryHTML->confirm();
					return;
				}
				break;
		}
		transmissionHtml::search();
	}
	function edit(){
		global $system;
		
		$transmissionHtml = new transmissionHtml;
		$submit=html::getInput($_POST,'submit');
		if($submit=='transmission'){
			$transmissionid=html::getInput($_GET,'id');
			$fields=array(
				'name'=>'Name',
				'abbrev'=>'Abbreviation',
				);
			$sets=html::getPosts($fields,$transmissionHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				if($transmissionid){
					db::update('transmission',$transmissionid,$sets);
				}else{
					db::insert('transmission',$sets);
				}
				$system->messages[]='Your changes have been saved.';
				$transmissionHtml->search();
				return;
			}
		}
		$transmissionHtml->edit();
	}
}
class makeControl{
	function search(){
		global $system;

		$action=html::getInput($_GET,'action');
		switch($action){
			case 'delete':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$makeid=html::getInput($_GET,'mid');
					$result=db::getResultByColumn('vehicles','makeid',$makeid);
					if(mysql_num_rows($result)){
						$system->errors[]='Make has vehicles.';
					}
					$result=db::getResultByColumn('makeservice','makeid',$makeid);
					if(mysql_num_rows($result)){
						$system->errors[]='Make has services.';
					}
					$result=db::getResultByColumn('servicemakepr','makeid',$makeid);
					if(mysql_num_rows($result)){
						$system->errors[]='Make has pressreleases.';
					}
					$result=db::getResultByColumn('brandlogo','makeid',$makeid);
					if(mysql_num_rows($result)){
						$system->errors[]='Make has logo.';
					}
					if(!$system->errors){
						db::deleteByColumn('servicemaketext','makeid',$makeid);
						db::deleteByColumn('make','makeid',$makeid);
						$system->messages[]='Make successfully deleted.';
					}
				}else if($confirm=='no'){
				}else{
					$system->breadcrumbs['Categories']='index.php?comp=category';
					$system->breadcrumbs['Makes']='index.php?comp=category&task=listmake';
					$system->breadcrumbs['Confirm Delete Make']='';
					$categoryHTML=new categoryHTML;
					$categoryHTML->header='Confirm Make Deletion';
					$categoryHTML->prompt='Are you sure you want to delete this Make? ';
					$categoryHTML->confirm();
					return;
				}
		}
		makeHtml::search();
	}
	function edit(){
		global $system,$site_path;

		$makeHtml= new makeHtml;
		$action=html::getInput($_GET,'action');
		$makeid=html::getInput($_GET,'mid');
		switch($action){
			case 'active---':
				$serviceid=html::getInput($_GET,'svid');
				db::insert('makeservice',array('makeid'=>$makeid,'serviceid'=>$serviceid));
				break;
			case 'inactive----':
				$serviceid=html::getInput($_GET,'svid');
				db::deleteByColumns('makeservice',array('makeid'=>$makeid,'serviceid'=>$serviceid));
				break;
			case 'deletelogo':
				$logo_row=db::fetchObjectByColumn('brandlogo','makeid',$makeid);
				unlink($site_path.'/media/logos/'.$logo_row->LogoFileName);
				db::deleteByColumn('brandlogo','makeid',$makeid);
				$system->messages[]='Logo successfully deleted.';
				break;
		}
		$submit=html::getInput($_POST,'submit');
		if($submit=='logo'){
			switch($_FILES['logo']['error']){
				case 1:
				case 2:
					$system->errors[]='File size limit exceded.';
					break;
				case 3:
					$system->errors[]='File upoad incomplete.';
					break;
				case 4:
					$system->errors[]='Logo required.';
					break;
			}
			if(!$system->errors){
				$upload_path=$site_path.'/media/logos';
				$file_info=pathinfo($_FILES['logo']['name']);
				$upload_file=basename($_FILES['logo']['tmp_name']).'_'.date("Ymd").'.'.$file_info["extension"];
				$upload_path.='/'.$upload_file;
				if(!move_uploaded_file($_FILES['logo']['tmp_name'], $upload_path)){
					$system->errors[]='Logo upload was not succesfull.';
				};
			}
			if(!$system->errors){
				$sets=array('makeid'=>$makeid,'LogoFileName'=>$upload_file);
				db::addQuotes($sets);
				db::insert('brandlogo',$sets);
				$system->messages[]='Your changes have been saved.';
			}
		}else if($submit=='make'){
			$fields=array(
				'name'=>'Name',
				'manufactureid'=>'Manufacturer'
				);
			$sets=html::getPosts($fields,$makeHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				if($makeid!=''){
					db::update('make',$makeid,$sets);
					$system->messages[]='Your changes have been saved.';
					$makeHtml->search();
					return;
				}else{
					db::insert('make',$sets);
					$system->messages[]='Your changes have been saved.';
					$makeHtml->search();
					return;
				}
			}
		}else if($submit=='service'){
			db::deleteByColumn('makeservice','makeid',$makeid);
			foreach($_POST as $name=>$value){
				if($value=='on'){
					$id=substr($name,8);
					db::insert('makeservice',array('makeid'=>$makeid,'serviceid'=>$id));
				}
			}
			$system->messages[]='Your changes have been saved.';
		}
		$makeHtml->edit();
	}
	function editText(){
		global $system;
		
		$action=html::getInput($_GET,'action');
		$makeid=html::getInput($_GET,'mid');
		$serviceid=html::getInput($_GET,'sid');
		$contentid=html::getInput($_GET,'cid');
		switch($action){
			case 'deletepr':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					db::deleteByColumn('content','ContentID',$contentid);
					db::deleteByColumns('servicemakepr',
						array('ContentID'=>$contentid,
							'serviceid'=>$serviceid,
							'makeid'=>$makeid,));
					$system->messages[]='Make Press Release successfully deleted.';
				}else if($confirm=='no'){
				}else{
					$make_row=db::fetchObject('make',$makeid);
					$system->breadcrumbs['Categories']='index.php?comp=category';
					$system->breadcrumbs['Makes']='index.php?comp=category&task=listmake';
					$system->breadcrumbs["Edit $make_row->name"]="index.php?comp=category&task=editmake&id=$makeid";
					$system->breadcrumbs['Edit Background Text']='';
					$system->breadcrumbs['Confirm Delete Press Release']='';
					$categoryHTML=new categoryHTML;
					$categoryHTML->header='Confirm Press Release Deletion';
					$categoryHTML->prompt='Are you sure you want to delete this Press Release? ';
					$categoryHTML->confirm();
					return;
				}
				break;
		}
		$submit=html::getInput($_POST,'submit');
		$makeHtml= new makeHtml;
		if($submit=='AdditionalText'){
			$fields=array(
				'AdditionalText'=>''
				);
			$sets=html::getPosts($fields,$makeHtml);
			if(!$system->errors){
				$AdditionalTextID=html::getInput($_POST,'AdditionalTextID');
				db::addQuotes($sets);
				if($AdditionalTextID!=''){
					db::updateByColumn('additionaltext','AdditionalTextID',$AdditionalTextID,$sets);
				}else{
					$AdditionalTextID=db::insert('additionaltext',$sets);
					$sets=array('serviceid'=>$serviceid,'makeid'=>$makeid,'AdditionalTextID'=>$AdditionalTextID);
					db::insert('servicemaketext',$sets);
				}
				$system->messages[]='Your changes have been saved.';
				makeHtml::edit();
				return;
			}
		}
		makeHtml::editText();
	}
	function editPressrelease(){
		global $system;
		
		$makeHtml = new makeHtml;
		$submit=html::getInput($_POST,'submit');
		if($submit=='press_release'){
			$ContentID=html::getInput($_GET,'cid');
			$fields=array(
				'Content'=>'Press Release',
				'PublishDate'=>'',
				'ArchiveDate'=>'',
				'ActiveFlag'=>''
				);
			$posts=html::getPosts($fields,$makeHtml);
			if(strstr($posts['ActiveFlag'],"on")){
				$posts['ActiveFlag']=$makeHtml->ActiveFlag=0;
			}else{
				$posts['ActiveFlag']=$makeHtml->ActiveFlag=1;
			}
			if(!$system->errors){
				if($posts['PublishDate']){
					$posts['PublishDate']=date("Ymd",strtotime($posts['PublishDate']));
				}
				if($posts['ArchiveDate']){
					$posts['ArchiveDate']=date("Ymd",strtotime($posts['ArchiveDate']));
				}
				db::addQuotes($posts);
				$makeid=html::getInput($_GET,'mid');
				$serviceid=html::getInput($_GET,'sid');
				if($ContentID){
					db::update('content',$ContentID,$posts);
				}else{
					$posts['type']="'MPR'";
					db::insert('content',$posts);
					$contentid=mysql_insert_id();
					db::insert('servicemakepr',
						array('serviceid'=>$serviceid,
							'makeid'=>$makeid,
							'contentid'=>$contentid));
				}
				$system->messages[]='Your changes have been saved.';
				$makeHtml->editText();
				return;
			}
		}
		$makeHtml->editPressrelease();
	}
}
class segmentControl{
	function search(){
		global $system;
		
		$segmentHtml = new segmentHtml;
		$submit=html::getInput($_POST,'submit');
		$action=html::getInput($_GET,'action');
		switch($action){
			case 'delete':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$segmentid=html::getInput($_GET,'id');
					$result=db::getResultByColumn('vehicles','segmentid',$segmentid);
					if(mysql_num_rows($result)){
						$system->errors[]='Segment has vehicles.';
					}
					$result=db::getResultByColumn('segmentservice','segmentid',$segmentid);
					if(mysql_num_rows($result)){
						$system->errors[]='Segment has service.';
					}
//					$result=db::getResultByColumn('servicesegmenttext','segmentid',$segmentid);
//					if(mysql_num_rows($result)){
//						$system->errors[]='Segment has text.';
//					}
					if(!$system->errors){
						db::deleteByColumn('segment','segmentid',$segmentid);
						db::deleteByColumn('segmentservice','segmentid',$segmentid);
						db::deleteByColumn('servicesegmenttext','segmentid',$segmentid);
						$system->messages[]='Segment successfully deleted.';
					}
				}else if($confirm=='no'){
				}else{
					$system->breadcrumbs['Categories']='index.php?comp=category';
					$system->breadcrumbs['Segments']='index.php?comp=category&task=listsegment';
					$system->breadcrumbs['Confirm Delete Segment']='';
					$categoryHTML=new categoryHTML;
					$categoryHTML->header='Confirm Segment Deletion';
					$categoryHTML->prompt='Are you sure you want to delete this Segment? ';
					$categoryHTML->confirm();
					return;
				}
				break;
		}
		if($submit=='segment'){
			$fields=array(
				'name'=>'Segment name',
				'type'=>'Segment type'
				);
			$sets=html::getPosts($fields,$segmentHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				if($segmentid!=''){
				}else{
					db::insert('segment',$sets);
					$segmentHtml->name='';
					$segmentHtml->type='';
					$system->messages[]='Your changes have been saved.';
				}
			}
		}
		$segmentHtml->search();
	}
	function edit(){
		global $system;
		
		$segmentHtml = new segmentHtml;
		$segmentid=html::getInput($_GET,'id');
		$action=html::getInput($_GET,'action');
		switch($action){
			case 'active---':
				$serviceid=html::getInput($_GET,'svid');
				db::insert('segmentservice',array('segmentid'=>$segmentid,'serviceid'=>$serviceid));
				break;
			case 'inactive---':
				$serviceid=html::getInput($_GET,'svid');
				db::deleteByColumns('segmentservice',array('segmentid'=>$segmentid,'serviceid'=>$serviceid));
				break;
		}
		$submit=html::getInput($_POST,'submit');
		if($submit=='segment'){
			$fields=array(
				'name'=>'Segment name'
				);
			$sets=html::getPosts($fields,$segmentHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				if($segmentid!=''){
					db::update('segment',$segmentid,$sets);
					$system->messages[]='Your changes have been saved.';
					$segmentHtml->search();
					return;
				}else{
				}
			}
		}else if($submit=='service'){
			db::deleteByColumn('segmentservice','segmentid',$segmentid);
			foreach($_POST as $name=>$value){
				if($value=='on'){
					$id=substr($name,8);
					db::insert('segmentservice',array('segmentid'=>$segmentid,'serviceid'=>$id));
				}
			}
			$system->messages[]='Your changes have been saved.';				
			$segmentHtml->search();
			return;
		}
		$segmentHtml->edit();
	}
	function editText(){
		global $system;
		
		$submit=html::getInput($_POST,'submit');
		$segmentHtml= new segmentHtml;
		if($submit=='AdditionalText'){
			$fields=array(
				'AdditionalText'=>''
				);
			$sets=html::getPosts($fields,$categoryHtml);
			if(!$system->errors){
				$AdditionalTextID=html::getInput($_POST,'AdditionalTextID');
				db::addQuotes($sets);
				$segmentid=html::getInput($_GET,'id');
				$serviceid=html::getInput($_GET,'sid');
				if($AdditionalTextID!=''){
					db::updateByColumn('additionaltext','AdditionalTextID',$AdditionalTextID,$sets);
				}else{
					$AdditionalTextID=db::insert('additionaltext',$sets);
					$sets=array('serviceid'=>$serviceid,'segmentid'=>$segmentid,'AdditionalTextID'=>$AdditionalTextID);
					db::insert('servicesegmenttext',$sets);
				}
				$system->messages[]='Your changes have been saved.';
				$segmentHtml->edit();
				return;
			}
		}
		segmentHtml::editText();
	}
}
class divisionControl{
	function search(){
		global $system;
	
		$divisionHtml = new divisionHtml;
		$action=html::getInput($_GET,'action');
		switch($action){
			case 'delete_division':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$divisionid=html::getInput($_GET,'id');
					$result=db::getResultByColumn('vehicledivision','divisionid',$divisionid);
					if(mysql_num_rows($result)||!$result){
						$system->errors[]='Division is in use.';
					}else{
						db::deleteByColumn('division','divisionid',$divisionid);
						$system->messages[]='Division successfully deleted.';
					}
				}else if($confirm=='no'){
				}else{
					$system->breadcrumbs['Categories']='index.php?comp=category';
					$system->breadcrumbs['Divisions ']='index.php?comp=category&task=listdivision';
					$system->breadcrumbs['Confirm Delete Division']='';
					$categoryHTML=new categoryHTML;
					$categoryHTML->header='Confirm Division Deletion';
					$categoryHTML->prompt='Are you sure you want to delete this Division ? ';
					$categoryHTML->confirm();
					return;
				}
				break;
		}
		$divisionHtml->search();
	}
	function edit(){
		global $system;
		
		$divisionHtml = new divisionHtml;
		$submit=html::getInput($_POST,'submit');
		if($submit=='division'){
			$divisionid=html::getInput($_GET,'id');
			$fields=array(
				'name'=>'Name',
				);
			$sets=html::getPosts($fields,$divisionHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				if($divisionid){
					db::update('division',$divisionid,$sets);
				}else{
					db::insert('division',$sets);
				}
				$system->messages[]='Your changes have been saved.';
				$divisionHtml->search();
				return;
			}
		}
		$divisionHtml->edit();
	}
}
class manufactureControl{
	function search(){
		global $system;
	
		$manufactureHtml = new manufactureHtml;
		$action=html::getInput($_GET,'action');
		switch($action){
			case 'delete_manufacturer':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$manufactureid=html::getInput($_GET,'id');
					$result=db::getResultByColumn('make','manufactureid',$manufactureid);
					if(mysql_num_rows($result)||!$result){
						$system->errors[]='Manufacturer has makes.';
					}else{
						db::deleteByColumn('manufacture','manufactureid',$manufactureid);
						$system->messages[]='Manufacturer successfully deleted.';
					}
					break;
				}else if($confirm=='no'){
				}else{
					$system->breadcrumbs['Categories']='index.php?comp=category';
					$system->breadcrumbs['Manufacturers']='index.php?comp=category&task=listmanufacturer';
					$system->breadcrumbs['Confirm Delete Manufacturer']='';
					$categoryHTML=new categoryHTML;
					$categoryHTML->header='Confirm Manufacturer Deletion';
					$categoryHTML->prompt='Are you sure you want to delete this Manufacturer? ';
					$categoryHTML->confirm();
					return;
				}
		}
		$manufactureHtml->search();
	}
	
	function edit(){
		global $system;
		
		$manufactureHtml = new manufactureHtml;
		$submit=html::getInput($_POST,'submit');
		if($submit=='manufacture'){
			$manufactureid=html::getInput($_GET,'id');
			$fields=array(
				'name'=>'Name',
				);
			$sets=html::getPosts($fields,$manufactureHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				if($manufactureid){
					db::update('manufacture',$manufactureid,$sets);
				}else{
					db::insert('manufacture',$sets);
				}
				$system->messages[]='Your changes have been saved.';
				$manufactureHtml->search();
				return;
			}
		}
		$manufactureHtml->edit();
	}
}
class serviceControl{
	function search(){
		global $system;
	
		$serviceHtml = new serviceHtml;
		$action=html::getInput($_GET,'action');
		switch($action){
			case 'delete_cbg':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$cbgid=html::getInput($_GET,'cbgid');
					$result=db::getResultByColumn('vehicles','cbgid',$cbgid);
					if(mysql_num_rows($result)){
						$system->errors[]='Battleground has vehicles.';
					}
					$query="select * from accesslevel as al, service as s ";
					$query.="where s.cbgid = '$cbgid' and s.serviceid = al.serviceid ";
					$result=db::executeQuery($query);
					if(mysql_num_rows($result)){
						$system->errors[]='Battleground has subscribers.';
					}
					$query="select * from segmentservice as ss, service as s ";
					$query.="where s.cbgid = '$cbgid' and s.serviceid = ss.serviceid ";
					$result=db::executeQuery($query);
					if(mysql_num_rows($result)){
						$system->errors[]='Battleground has segments.';
					}
					$query="select * from makeservice as ms, service as s ";
					$query.="where s.cbgid = '$cbgid' and s.serviceid = ms.serviceid ";
					$result=db::executeQuery($query);
					if(mysql_num_rows($result)){
						$system->errors[]='Battleground has makes.';
					}
					$query="select * from sfcs where cbgid='$cbgid' ";
					$result=db::executeQuery($query);
					if(mysql_num_rows($result)){
						$system->errors[]='Battleground has sales forecast service.';
					}
					if(!$system->errors){
						db::deleteByColumn('cbg','cbgid',$cbgid);
						db::deleteByColumn('service','cbgid',$cbgid);
					}
					break;
				}else if($confirm=='no'){
				}else{
					$system->breadcrumbs['Categories']='index.php?comp=category';
					$system->breadcrumbs['Services']='index.php?comp=category&task=listservice';
					$system->breadcrumbs['Confirm Delete Competitive Battleground']='';
					$categoryHTML=new categoryHTML;
					$categoryHTML->header='Confirm Competitive Battleground Deletion';
					$categoryHTML->prompt='Are you sure you want to delete this Competitive Battleground? ';
					$categoryHTML->confirm();
					return;
				}
		}
		$serviceHtml->search();
	}

	function edit(){
		global $system;
		
		$serviceHtml = new serviceHtml;
		$submit=html::getInput($_POST,'submit');
		$action=html::getInput($_GET,'action');
		if($submit=='cbg'){
			$cbgid=html::getInput($_GET,'cbgid');
			$fields=array(
				'name'=>'Name',
				);
			$sets=html::getPosts($fields,$serviceHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				if($cbgid){
					db::update('cbg',$cbgid,$sets);
				}else{
					$cbgid=db::insert('cbg',$sets);
					db::insert('service',array('cbgid'=>$cbgid,'name'=>$sets['name'],'type'=>"'CBG'"));
				}
				$system->messages[]='Your changes have been saved.';
				$serviceHtml->search();
				return;
			}
		}
		if($submit=='sfcs'){
			$cbgid=html::getInput($_GET,'cbgid');
			$sfcs_row=db::fetchObjectByColumn('sfcs','cbgid',$cbgid);
			$fields=array(
				'sfcs_name'=>'Name',
				);
			$sets=html::getPosts($fields,$serviceHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				if($sfcs_row){
					db::update('sfcs',$sfcs_row->sfcsid,$sets,true);
				}else{
					$sfcsid=db::insert('sfcs',array('name'=>$sets['sfcs_name'],'cbgid'=>$cbgid));
					db::insert('service',array('sfcsid'=>$sfcsid,'name'=>$sets['sfcs_name'],'type'=>"'SFCS'"));
				}
				$system->messages[]='Your changes have been saved.';
				$serviceHtml->edit();
				return;
			}
		}
		$action=html::getInput($_GET,'action');
		switch($action){
			case 'delete_sfcs':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$sfcsid=html::getInput($_GET,'sfcsid');
					$query="select * from accesslevel as al, service as s ";
					$query.="where s.sfcsid = '$sfcsid' and s.serviceid = al.serviceid ";
					$result=db::executeQuery($query);
					if(mysql_num_rows($result)){
						$system->errors[]='Salesforecast Service has subscribers.';
					}
					$query="select * from segmentservice as ss, service as s ";
					$query.="where s.sfcsid = '$sfcsid' and s.serviceid = ss.serviceid ";
					$result=db::executeQuery($query);
					if(mysql_num_rows($result)){
						$system->errors[]='Salesforecast Service has segments.';
					}
					$query="select * from makeservice as ms, service as s ";
					$query.="where s.sfcsid = '$sfcsid' and s.serviceid = ms.serviceid ";
					$result=db::executeQuery($query);
					if(mysql_num_rows($result)){
						$system->errors[]='Salesforecast Service has makes.';
					}
					if(!$system->errors){
						db::deleteByColumn('sfcs','sfcsid',$sfcsid);
						db::deleteByColumn('service','sfcsid',$sfcsid);
					}
					break;
				}else if($confirm=='no'){
				}else{
					$cbgid=html::getInput($_GET,'cbgid');
					$row=db::fetchObject('cbg',$cbgid);
					$system->breadcrumbs['Categories']='index.php?comp=category';
					$system->breadcrumbs['View Service']='index.php?comp=category&task=listservice';
					$system->breadcrumbs[$row->name]='index.php?comp=category&task=editcbg&cbgid='.$cbgid;
					$system->breadcrumbs['Confirm delete Sales Forecast Service']='';
					$categoryHTML=new categoryHTML;
					$categoryHTML->header='Confirm Sales Forecast Service Deletion';
					$categoryHTML->prompt='Are you sure you want to delete this Sales Forecast Service? ';
					$categoryHTML->confirm();
					return;
				}
		}
		$serviceHtml->edit();
	}
}

?>