<?php
global $my;

defined('_VALID_PAGE') or die('Direct access not allowed');
if($my->admin_id==''){
	$system->error=_ERRROR_NO_LOGIN;
	return;
}
global $system;
//session_start();
//require(system::getComponentPath('vehicle','/administration').'/vehicle_html.php');
//require(system::getComponentPath('eauto').'/eauto_db.php');
$path = system::getComponentPath('vehicle','vehicle_html.php');
//echo $path;
require_once($path);
require_once('includeAdmin/eauto_db.php');

$task=html::getInput($_GET,'task','list');

switch($task){
	case 'vehicles':
		vehicleControl::search();
		break;
	case 'vehicle':
		vehicleControl::edit();
		break;
	case 'editbattleground':
		battlegroundControl::edit();
		break;
	case 'listbattlegroundcycle':
		battlegroundControl::searchCycle();
		break;
	case 'editbattlegroundcycleyear':
		battlegroundControl::editCycleyear();
		break;
	case 'editsalesforecast':
		salesforecastControl::search();
		break;
	case 'editsalesforecasttext':
		salesforecastControl::editText();
		break;
	case 'editsales':
		salesforecastControl::editData();
		break;
	case 'addphoto':
		photoControl::edit();
		break;
	case 'editphoto':
		photoControl::edit();
		break;
	case 'viewphotos':
		photoControl::search();
		break;
	case 'editpressrelease':
		pressreleaseControl::edit();
		break;
	case 'editattribute':
		attributeControl::edit();
		break;
	case 'editsegment':
		attributeControl::editSegment();
		break;
	case 'editdivision':
		attributeControl::editDivision();
		break;
	case 'editvariation':
		dimensionControl::editVariation();
		break;
	case 'editstartofp':
		dimensionControl::editStartOfProduction();
		break;
	case 'editsaleslaunch':
		dimensionControl::editSalesLaunch();
		break;
	case 'editcurbweight':
		dimensionControl::editCurbWeightRange();
		break;
	case 'edittiresize':
		dimensionControl::editTireSizes();
		break;
	case 'editengine':
		dimensionControl::editEngine();
		break;
	case 'editsuspension':
		dimensionControl::editSuspension();
		break;
	case 'editprice':
		dimensionControl::editPriceRange();
		break;
	
	default:
		vehicleControl::search();
}
class vehicleControl{
	function search(){
		global $system;
		
		$action=html::getInput($_GET,'action');
		$vehicleid=html::getInput($_GET,'vehicleid');
		switch($action){
			case 'delete':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$result=db::getResultByColumn('vehiclephoto','VehicleID',$vehicleid);
					if(mysql_num_rows($result)){
						$system->errors[]='Vehicle has photos.';
					}
					$result=db::getResultByColumns('content',array('VehicleID'=>$vehicleid,'DeleteFlag'=>0));
					if(mysql_num_rows($result)){
						$system->errors[]='Vehicle has press releases.';
					}
					if(!$system->errors){
						$system->messages[]='Vehicle has been succesfully deleted.';
						db::deleteByColumn('vehicles','VehicleID',$vehicleid);
						db::deleteByColumn('vehiclebattleground','VehicleID',$vehicleid);
						db::deleteByColumn('vehiclebattlegroundcycle','VehicleID',$vehicleid);
						db::deleteByColumn('vehiclebodystyle','VehicleID',$vehicleid);
						db::deleteByColumn('vehiclecurbweightrange','VehicleID',$vehicleid);
						db::deleteByColumn('vehicledemographic','VehicleID',$vehicleid);
						db::deleteByColumn('vehicledimension','VehicleID',$vehicleid);
						db::deleteByColumn('vehicledivision','VehicleID',$vehicleid);
						db::deleteByColumn('vehicledrive','VehicleID',$vehicleid);
						db::deleteByColumn('vehicleengine','VehicleID',$vehicleid);
						db::deleteByColumn('vehiclepricerange','VehicleID',$vehicleid);
						db::deleteByColumn('vehiclesaleslaunch','VehicleID',$vehicleid);
						db::deleteByColumn('vehicleseat','VehicleID',$vehicleid);
						db::deleteByColumn('vehiclestartofproduction','VehicleID',$vehicleid);
						db::deleteByColumn('vehiclesuspension','VehicleID',$vehicleid);
						db::deleteByColumn('vehicletiresize','VehicleID',$vehicleid);
						db::deleteByColumn('vehicletransmission','VehicleID',$vehicleid);
						}
				}else if($confirm=='no'){
				}else{
						vehicleHtml::breadCrumbs($vehicleid);
						$system->breadcrumbs['Delete Vehicle']='';
						$row=db::fetchObjectByColumn('vehicles','VehicleID',$vehicleid);
						$vehicleHtml=new vehicleHtml;
						$vehicleHtml->header='Confirm Vehicle Deletion';
						$vehicleHtml->prompt='Are you sure you want to delete this Vehicle? ';
						$vehicleHtml->confirm();
						return;
				}
				break;
		}
		vehicleHtml::search();
	}

	function edit(){
		global $system;
		
		$vehicleid=html::getInput($_GET,'vehicleid','');
		$action=html::getInput($_GET,'action');
		switch($action){
			case 'active':
				$value=html::getInput($_GET,'v');
				if($value=='0'){
					db::updateByColumn('vehicles','vehicleid',$vehicleid,array('sfcsactive'=>$value));
				}
				db::updateByColumn('vehicles','vehicleid',$vehicleid,array('activeflag'=>$value));
				$system->messages[]='Your request was processed successfully.';
				break;
			case 'sfcsactive':
				$value=html::getInput($_GET,'v');
				db::updateByColumn('vehicles','vehicleid',$vehicleid,array('sfcsactive'=>$value));
				$system->messages[]='Your request was processed successfully.';
				break;
			case 'deletevariation':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$id=html::getInput($_GET,'id');
					db::deleteByColumn('vehicledimension','VehicleDimensionID',$id);
					$system->messages[]='Your changes have been saved.';
				}else if($confirm=='no'){
				}else{
					$vehicleid=html::getInput($_GET,'vehicleid');
					vehicleHtml::breadCrumbs($vehicleid);
					$system->breadcrumbs['Confirm Delete Vehicle Dimensions']='';
					$vehicleHtml=new vehicleHtml;
					$vehicleHtml->header='Confirm Delete Vehicle Dimensions';
					$vehicleHtml->prompt='Are you sure you want to delete this Dimension? ';
					$vehicleHtml->confirm();
					return;
				}
				break;
			case 'deletestartofp':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$id=html::getInput($_GET,'id');
					db::deleteByColumn('vehiclestartofproduction','VehicleStartOfProductionID',$id);
					$system->messages[]='Your changes have been saved.';
				}else if($confirm=='no'){
				}else{
					$vehicleid=html::getInput($_GET,'vehicleid');
					vehicleHtml::breadCrumbs($vehicleid);
					$system->breadcrumbs['Confirm Delete Start Of Production']='';
					$vehicleHtml=new vehicleHtml;
					$vehicleHtml->header='Confirm Start Of Production Deletion';
					$vehicleHtml->prompt='Are you sure you want to delete this Start Of Production? ';
					$vehicleHtml->confirm();
					return;
				}
				break;
			case 'deletesaleslaunch':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$id=html::getInput($_GET,'id');
					db::deleteByColumn('vehiclesaleslaunch','VehicleSalesLaunchID',$id);
					$system->messages[]='Your changes have been saved.';
				}else if($confirm=='no'){
				}else{
					$vehicleid=html::getInput($_GET,'vehicleid');
					vehicleHtml::breadCrumbs($vehicleid);
					$system->breadcrumbs['Confirm Delete Sales Launch']='';
					$vehicleHtml=new vehicleHtml;
					$vehicleHtml->header='Confirm Sales Launch Deletion';
					$vehicleHtml->prompt='Are you sure you want to delete this Sales Launch? ';
					$vehicleHtml->confirm();
					return;
				}
				break;
			case 'deletecurbweight':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$id=html::getInput($_GET,'id');
					db::deleteByColumn('vehiclecurbweightrange','VehicleCurbWeightRangeID',$id);
					$system->messages[]='Your changes have been saved.';
				}else if($confirm=='no'){
				}else{
					$vehicleid=html::getInput($_GET,'vehicleid');
					vehicleHtml::breadCrumbs($vehicleid);
					$system->breadcrumbs['Confirm Delete Curb Weight Range']='';
					$vehicleHtml=new vehicleHtml;
					$vehicleHtml->header='Confirm Curb Weight Range Deletion';
					$vehicleHtml->prompt='Are you sure you want to delete this Curb Weight Range? ';
					$vehicleHtml->confirm();
					return;
				}
				break;
			case 'deletetiresize':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$id=html::getInput($_GET,'id');
					db::deleteByColumn('vehicletiresize','VehicleTireSizeID',$id);
					$system->messages[]='Your changes have been saved.';
				}else if($confirm=='no'){
				}else{
					$vehicleid=html::getInput($_GET,'vehicleid');
					vehicleHtml::breadCrumbs($vehicleid);
					$system->breadcrumbs['Confirm Delete Tire Sizes']='';
					$vehicleHtml=new vehicleHtml;
					$vehicleHtml->header='Confirm Tire Sizes Deletion';
					$vehicleHtml->prompt='Are you sure you want to delete this Tire Sizes? ';
					$vehicleHtml->confirm();
					return;
				}
				break;
			case 'deleteengine':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$id=html::getInput($_GET,'id');
					db::deleteByColumn('vehicleengine','VehicleEngineID',$id);
					$system->messages[]='Your changes have been saved.';
				}else if($confirm=='no'){
				}else{
					$vehicleid=html::getInput($_GET,'vehicleid');
					vehicleHtml::breadCrumbs($vehicleid);
					$system->breadcrumbs['Confirm Delete Engine']='';
					$vehicleHtml=new vehicleHtml;
					$vehicleHtml->header='Confirm Engine Deletion';
					$vehicleHtml->prompt='Are you sure you want to delete this Engine? ';
					$vehicleHtml->confirm();
					return;
				}
				break;
			case 'deletesuspension':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$id=html::getInput($_GET,'id');
					db::deleteByColumn('vehiclesuspension','VehicleSuspensionID',$id);
					$system->messages[]='Your changes have been saved.';
				}else if($confirm=='no'){
				}else{
					$vehicleid=html::getInput($_GET,'vehicleid');
					vehicleHtml::breadCrumbs($vehicleid);
					$system->breadcrumbs['Confirm Delete Suspension']='';
					$vehicleHtml=new vehicleHtml;
					$vehicleHtml->header='Confirm Suspension Deletion';
					$vehicleHtml->prompt='Are you sure you want to delete this Suspension? ';
					$vehicleHtml->confirm();
					return;
				}
				break;
			case 'deleteprice':
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$id=html::getInput($_GET,'id');
					db::deleteByColumn('vehiclepricerange','VehiclePriceRangeID',$id);
					$system->messages[]='Your changes have been saved.';
				}else if($confirm=='no'){
				}else{
					$vehicleid=html::getInput($_GET,'vehicleid');
					vehicleHtml::breadCrumbs($vehicleid);
					$system->breadcrumbs['Confirm Delete Price Range']='';
					$vehicleHtml=new vehicleHtml;
					$vehicleHtml->header='Confirm Price Range Deletion';
					$vehicleHtml->prompt='Are you sure you want to delete this Price Range? ';
					$vehicleHtml->confirm();
					return;
				}
				break;
			case 'deletepress':
				$confirm=html::getInput($_GET,'confirm');
				$ContentID=html::getInput($_GET,'id');
				if($confirm=='yes'){
					db::update('content',$ContentID,array('DeleteFlag'=>'1'));
					$system->messages[]='Vehicle Press Release successfully deleted.';
				}else if($confirm=='no'){
				}else{
					$vehicleid=html::getInput($_GET,'vehicleid');
					vehicleHtml::breadCrumbs($vehicleid);
					$system->breadcrumbs['Press Releases']='index.php?comp=vehicle&task=vehicle';
					$system->breadcrumbs['Confirm Delete Vehicle Press Release']='';
					$row=db::fetchObject('content',$ContentID);
					$vehicleHtml=new vehicleHtml;
					$vehicleHtml->header='Confirm Press Release Deletion';
					$vehicleHtml->prompt='Are you sure you want to delete this Vehicle press release? ';
					$vehicleHtml->page_location='#press';
					$vehicleHtml->confirm();
					return;
				}
				break;
		}
		$submit=html::getInput($_POST,'submit');
		if($submit=='demographic'){
			$fields=array(
				'Age'=>'',
				'MaritalStatus'=>'',
				'CollegeEducation'=>'',
				'Income'=>'',
				'BrandLoyalty'=>'',
				'SecondChoiceVehicle'=>'',
				'PreviousVehicle'=>'',
				'FutureSegment'=>'',
				'PricePaid'=>'',
			);
			$sets=html::getPosts($fields,$battlegroundHtml);
			$sets_checked=$sets;
			foreach($sets_checked as $set=>$value){
				$checked=html::getInput($_POST,"{$set}Check");
				if($checked){
					$sets[$set]='<*>'.$sets[$set];
				}
			}
			db::addQuotes($sets);
			$row=db::fetchObjectByColumn('vehicledemographic','vehicleid',$vehicleid);
			if($row){
				db::updateByColumn('vehicledemographic','vehicleid',$vehicleid,$sets);
			}else{
				$sets['vehicleid']=$vehicleid;
				db::insert('vehicledemographic',$sets);
			}
			$system->messages[]='Your changes have been saved.';
		}
		vehicleHtml::edit($vehicleid);
	}
}
class battlegroundControl{
	function edit(){
		global $system;
		
		$battlegroundHtml= new battlegroundHtml;
		$vehicleid=html::getInput($_GET,'vehicleid');
		$add_vehicle=false;
		$form=html::getInput($_POST,'form');
		if($form=='battleground'){
			$fields=array(
				'VehicleName'=>'Vehicle Name',
			);
			if(!$vehicleid){
				$fields['TruckFlag']='Vehicle Type';
			}
			$sets=html::getPosts($fields,$battlegroundHtml);
			if(!$system->errors){
				if($vehicleid){
					db::addQuotes($sets);
					db::updateByColumn('vehicles','vehicleid',$vehicleid,$sets);
					$system->messages[]='Your changes have been saved.';
				}else{
					$sets['cbgid']=html::getInput($_POST,'cbgid');
					$sets['makeid']=html::getInput($_POST,'makeid');
					$sets['ActiveFlag']=0;
					db::addQuotes($sets);
					db::insert('vehicles',$sets);
					$vehicleid=mysql_insert_id();
					$battlegroundHtml->vehicleid=$vehicleid;
					$system->messages[]='Vehicle has been succesfully added.';
					$this->vehicleid=$vehicleid;
					$add_vehicle=true;
				}
			}
			$fields=array(
				'CurrentCodeName'=>'',
				'FutureCodeName'=>'',
				'Change1'=>'',
				'Change2'=>'',
				'Change3'=>'',
				'FutureProduct'=>'',
				'XToY'=>''
			);
			$sets=html::getPosts($fields,$battlegroundHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				$sets['AmericaRegion']=$_POST['AmericaRegion']=='on'?'1':'0';
				$sets['AsiaRegion']=$_POST['AsiaRegion']=='on'?'1':'0';
				$sets['EuropeRegion']=$_POST['EuropeRegion']=='on'?'1':'0';
				if(!$add_vehicle){
					db::addQuotes($sets);
					db::updateByColumn('vehiclebattleground','vehicleid',$vehicleid,$sets);
					vehicleHtml::edit($vehicleid);
					return;
				}else{
					$sets['VehicleID']=$vehicleid;
					db::addQuotes($sets);
					db::insert('vehiclebattleground',$sets);
					vehicleControl::search();
					return;
				}
			}
//			header("location:index.php?comp=vehicle&task=vehicle&vehicleid=$vehicleid");
//			exit;
		}
		$battlegroundHtml->edit($vehicleid);
	}
	function searchCycle(){
		global $system;

		$vehicleid=html::getInput($_GET,'vehicleid','');
		$action=html::getInput($_GET,'action');
		switch($action){
			case 'delete':
				$vehicleBattleGroundCycleID=html::getInput($_GET,'id');
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					db::deleteBycolumn('vehiclebattlegroundcycle','vehicleBattleGroundCycleID',$vehicleBattleGroundCycleID);
					$system->messages[]='Cycle Plan Year successfully deleted.';
				}else if($confirm=='no'){
				}else{
					$vehicleid=html::getInput($_GET,'vehicleid');
					vehicleHtml::breadCrumbs($vehicleid);
					$system->breadcrumbs['View Battleground Cycle Text']='index.php?comp=vehicle&task=listbattlegroundcycle&vehicleid=2522';
					$system->breadcrumbs['Delete']='';
					$vehicleHtml=new vehicleHtml;
					$vehicleHtml->header='Confirm Battleground Cycle Text Deletion';
					$vehicleHtml->prompt='Are you sure you want to delete this Battleground Cycle Text? ';
					$vehicleHtml->confirm();
					return;
				}
				break;
		}
		battlegroundHtml::listcycle($vehicleid);
	}
	function editCycleyear(){
		global $system;
		
		
		$battlegroundHtml= new battlegroundHtml;
		$id=html::getInput($_GET,'id','');
		$submit=html::getInput($_POST,'submit');
		if($submit=='cycleyear'){
			$fields=array(
				'LineYear'=>'Year',
				'CycleText'=>'Text'
				);
			$sets=html::getPosts($fields,$battlegroundHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				$vehicleBattleGroundCycleID=html::getInput($_GET,'id');
				if($vehicleBattleGroundCycleID!=''){
					$vehicleid=html::getInput($_GET,'vehicleid');
					db::updateByColumn('vehiclebattlegroundcycle','vehicleBattleGroundCycleID',$vehicleBattleGroundCycleID,$sets);
				}else{
					$vehicleid=html::getInput($_GET,'vehicleid');
					$sets['vehicleid']=$vehicleid;
					db::insert('vehiclebattlegroundcycle',$sets);
				}
				$system->messages[]='Your changes have been saved.';
				$battlegroundHtml->listCycle($vehicleid);
				return;
			}
		}
		$battlegroundHtml->editCycleYear($id);
	}
}
class salesforecastControl{
	function search(){
		global $system;
		
		$vehicleid=html::getInput($_GET,'vehicleid',$_SESSION['vehicleid']);
		$submit=html::getInput($_POST,'submit');
		if($submit=='data'){
			$bodystyleid=html::getInput($_GET,'bodystyleid');
			foreach($_POST as $key=>$val){
				if(substr($key,0,9)=="SalesYear"){
					$value=html::getInput($_POST,$key);
					$year=substr($key,9);
					$row=db::fetchObjectByColumns('salesforecast',
						array(
							'VehicleID'=>$vehicleid,
							'bodystyleid'=>$bodystyleid,
							'SalesYear'=>$year
							)
						);
					if($row){
						db::updateByColumn('salesforecast','SFID',$row->SFID,array('SalesValue'=>$value));
					}else{
						if($value){
							db::insert('salesforecast',
								array(
									'VehicleID'=>$vehicleid,
									'bodystyleid'=>$bodystyleid,
									'SalesYear'=>$year,
									'SalesValue'=>$value
								)
							);
						}
					}
				}
			}
			$system->messages[]='Your changes have been saved.';

		}
		sfcsHtml::search($vehicleid);
	}
	function editText(){
		global $system;
		
		$sfcsHtml= new sfcsHtml;
		$id=html::getInput($_GET,'id','');
		$submit=html::getInput($_POST,'submit');
		if($submit=='text'){
			$fields=array(
				'SFText'=>''
				);
			$sets=html::getPosts($fields,$sfcsHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				$SFTextID=html::getInput($_GET,'id');
				if($SFTextID!=''){
					$vehicleid=html::getInput($_GET,'vehicleid',$_SESSION['vehicleid']);
					db::updateByColumn('salesforecasttext ','SFTextID',$SFTextID,$sets);
				}else{
					$vehicleid=html::getInput($_GET,'vehicleid',$_SESSION['vehicleid']);
					$sets['vehicleid']=$vehicleid;
					db::insert('salesforecasttext ',$sets);
				}
				$system->messages[]='Your changes have been saved.';
				sfcsHtml::search($vehicleid);
				return;
			}
		}
		$sfcsHtml->editText($id);
	}

	function editData(){
		sfcsHtml::editData();
	}
}
class photoControl{
	function edit(){
		global $system,$site_path;
	
		$photoHtml= new photoHtml;
		$vehicleid=html::getInput($_GET,'vehicleid');
		$submit=html::getInput($_POST,'submit');
		if($submit=='photo'){
			$id=html::getInput($_GET,'id');
			$fields=array(
				'ModelYear'=>'',
				'PhotoCaption'=>'',
				'PhotoCredit'=>'',
				'MainFlag'=>''
				);
			$sets=html::getPosts($fields,$vehicleHtml);
			if(strstr($sets['MainFlag'],"on")){
				$sets['MainFlag']=$photoHtml->MainFlag=1;
			}else{
				$sets['MainFlag']=$photoHtml->MainFlag=0;
			}
			switch($_FILES['photo']['error']){
				case 1:
				case 2:
					$system->errors[]='File size limit exceded.';
					break;
				case 3:
					$system->errors[]='File upoad incomplete.';
					break;
				case 4:
					if(!$id){
						$system->errors[]='Photo required.';
					}
					break;
			}
			if(!$system->errors&&$_FILES['photo']['name']){
				$upload_path=$site_path.'/media/upload_photos';
				$file_info=pathinfo($_FILES['photo']['name']);
				$LargeFileName=basename($_FILES['photo']['tmp_name']).'_'.date("Ymdis").'l.'.$file_info["extension"];
				$large_file=$upload_path.'/'.$LargeFileName;

				$MediumFileName=basename($_FILES['photo']['tmp_name']).'_'.date("Ymdis").'m.'.$file_info["extension"];
				$medium_file=$upload_path.'/'.$MediumFileName;

				$SmallFileName=basename($_FILES['photo']['tmp_name']).'_'.date("Ymdis").'s.'.$file_info["extension"];
				$small_file=$upload_path.'/'.$SmallFileName;
				if(file_exists($large_file)){
					$system->errors[]='Photo upload was not successful.';
					$photoHtml->edit();
					return;
				}
				if(!move_uploaded_file($_FILES['photo']['tmp_name'], $large_file)){
					$system->errors[]='Photo upload was not successful.';
					$photoHtml->edit();
					return;
				}
				photoControl::resize($large_file,$medium_file,245,150);
				photoControl::resize($large_file,$small_file,154,93);
			}
			if(!$system->errors){
				if($_FILES['photo']['name']){
					$sets['LargeFileName']=$LargeFileName;
					$sets['MediumFileName']=$MediumFileName;
					$sets['SmallFileName']=$SmallFileName;
					$sets['SourcePhotoName']=$_FILES['photo']['name'];
				}
				if($sets['MainFlag']){
					db::updateByColumn('vehiclephoto','VehicleID',$vehicleid,array('MainFlag'=>0));
				}
				if($id){
					db::addQuotes($sets);
					db::update('vehiclephoto',$id,$sets);
					$system->messages[]='Your changes have been saved.';
					$photoHtml->search();
					return;
				}else{
					$sets['vehicleid']=$vehicleid;
					db::addQuotes($sets);
					$sets['PhotoDate']='CURDATE() + 0';
					db::insert('vehiclephoto',$sets);
					$system->messages[]='Your changes have been saved.';
					vehicleHtml::edit($vehicleid);
					return;
				}
			}
		}
		$photoHtml->edit();
	}
	function search(){
		global $system,$site_path,$photo_path;
		
		$action=html::getInput($_GET,'action');
		switch($action){
			case 'delete':
				$id=html::getInput($_GET,'id');
				$confirm=html::getInput($_GET,'confirm');
				if($confirm=='yes'){
					$row=db::fetchObject('vehiclephoto',$id);
					unlink("$site_path/$photo_path/{$row->SmallFileName}");
					unlink("$site_path/$photo_path/{$row->MediumFileName}");
					unlink("$site_path/$photo_path/{$row->LargeFileName}");
					db::delete('vehiclephoto',$id);
					$system->messages[]='Your changes have been saved.';
				}else if($confirm=='no'){
				}else{
					$vehicleid=html::getInput($_GET,'vehicleid');
					vehicleHtml::breadCrumbs($vehicleid);
					$system->breadcrumbs['Photo Selection']='index.php?comp=vehicle&task=viewphotos&vehicleid=2522';
					$system->breadcrumbs['Confirm Delete Photo']='';
					$vehicleHtml=new vehicleHtml;
					$vehicleHtml->header='Confirm Photo Deletion';
					$vehicleHtml->prompt='Are you sure you want to delete this Photo?';
					$vehicleHtml->confirm();
					return;
				}
		}
		photoHtml::search();
	}
	function resize($source, $destination, $dest_width="154", $dest_height="93", $quality="100"){
		$src_img     = imagecreatefromjpeg($source);
		$size        = getimagesize ($source); // 0 = width, 1 = height
		$deltaw      = ($size[0] / $dest_width);
		$deltah      = ($size[1] / $dest_height);
		$too_wide    = ($size[0] / $deltah);
		$too_tall    = ($size[1] / $deltaw);
		$x           = ($dest_width / 2) - (int)($too_wide / 2);
		$y           = ($dest_height / 2) - (int)($too_tall / 2);
		
		if ($size[0] > $size[1] && $too_wide >= $dest_width)
		{ // make the height match up to the edges
			$dst_img = imagecreatetruecolor($dest_width,$dest_height);
			imagefilledrectangle($dst_img, 0, 0, $dest_width, $dest_height, ImageColorAllocate($dst_img, 255, 255, 255));
			imagecopyresampled($dst_img, $src_img, $x, 0, 0, 0, $too_wide, $dest_height, $size[0], $size[1]);
			
		} else if ($size[1] > $size[0] && $too_tall >= $dest_height)
		{ // make the width match up to the edges
			$dst_img = imagecreatetruecolor($dest_width,$dest_height);
			imagefilledrectangle($dst_img, 0, 0, $dest_width, $dest_height, ImageColorAllocate($dst_img, 255, 255, 255));
			imagecopyresampled($dst_img, $src_img, 0, $y, 0, 0, $dest_width, $too_tall, $size[0], $size[1]);
			
		} else if ($size[0] > $size[1] && $too_wide < $dest_width)
		{
			$too_tall    = ($size[1] / $deltaw);
			$y           = ($dest_height / 2) - (int)($too_tall / 2);
			
			$dst_img = imagecreatetruecolor($dest_width,$dest_height);
			imagefilledrectangle($dst_img, 0, 0, $dest_width, $dest_height, ImageColorAllocate($dst_img, 255, 255, 255));
			imagecopyresampled($dst_img, $src_img, 0, $y, 0, 0, $dest_width, $too_tall, $size[0], $size[1]);
			
		} else if ($size[1] > $size[0] && $too_tall < $dest_height)
		{
			$too_wide    = ($size[0] / $deltah);
			$x           = ($dest_width / 2) - (int)($too_wide / 2);
			
			$dst_img = imagecreatetruecolor($dest_width,$dest_height);
			imagefilledrectangle($dst_img, 0, 0, $dest_width, $dest_height, ImageColorAllocate($dst_img, 255, 255, 255));
			imagecopyresampled($dst_img, $src_img, $x, 0, 0, 0, $too_wide, $dest_height, $size[0], $size[1]);
			
		}
		imagejpeg($dst_img, $destination, $quality);
		imagedestroy($src_img);
		imagedestroy($dst_img);
	}
}
class pressreleaseControl{
	function edit(){
		global $system;
		
		$vehicleHtml= new vehicleHtml;
		$vehicleid=html::getInput($_GET,'vehicleid');
		$submit=html::getInput($_POST,'submit');
		if($submit=='pressrelease'){
			$ContentID=html::getInput($_GET,'pid');
			$fields=array(
				'Content'=>'Press Release',
				'PublishDate'=>'',
				'ArchiveDate'=>'',
				'ActiveFlag'=>''
				);
			$posts=html::getPosts($fields,$vehicleHtml);
			if(strstr($posts['ActiveFlag'],"on")){
				$posts['ActiveFlag']=$vehicleHtml->ActiveFlag=0;
			}else{
				$posts['ActiveFlag']=$vehicleHtml->ActiveFlag=1;
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
					$posts['type']="'VPR'";
					$posts['vehicleid']=$vehicleid;
					db::insert('content',$posts);
				}
				$system->messages[]='Your changes have been saved.';
				vehicleHtml::edit($vehicleid);
				return;
			}
		}
		$vehicleHtml->editPressrelease();
	}
}
class attributeControl{
	function edit(){
		global $system;
		
		$attribute=html::getInput($_GET,'name');
		$name=html::getInput($_GET,'name');
		$submit=html::getInput($_POST,'submit');
		$vehicleid=html::getInput($_GET,'vehicleid');
		if($submit=='attribute'){
			db::deleteByColumn("vehicle{$name}",'vehicleid',$vehicleid);
			foreach($_POST as $id=>$on){
				if($on=='on'){
					db::insert("vehicle{$name}",array('vehicleid'=>"'$vehicleid'", $name.'id'=>"'$id'"));
				}
			}
			$system->messages[]='Your changes have been saved.';
			vehicleHtml::edit($vehicleid);
			return;
		}
		if($name=='seat'){
			attributeHtml::editSeat();
		}else{
			attributeHtml::edit();
		}
	}
	function editSegment(){
		global $system;
		$submit=html::getInput($_POST,'submit');
		if($submit=='attribute'){
				$segmentid=html::getInput($_POST,'segmentid');
				$vehicleid=html::getInput($_GET,'vehicleid');
				db::updateByColumn('vehicles','vehicleid',$vehicleid,array('segmentid'=>$segmentid));
			$system->messages[]='Your changes have been saved.';
			vehicleHtml::edit($vehicleid);
			return;
		}
		attributeHtml::editSegment();
	}
	function editDivision(){
		global $system;
		
		$submit=html::getInput($_POST,'submit');
		if($submit=='attribute'){
			$divisionid=html::getInput($_POST,'divisionid');
			$vehicleid=html::getInput($_GET,'vehicleid');
			$row=db::fetchObjectByColumn('vehicledivision','vehicleid',$vehicleid);
			if($row){
				db::updateByColumn('vehicledivision','vehicleid',$vehicleid,array('divisionid'=>$divisionid));
			}else{
				db::insert('vehicledivision',array('vehicleid'=>$vehicleid,'divisionid'=>$divisionid));
			}
			$system->messages[]='Your changes have been saved.';
			vehicleHtml::edit($vehicleid);
			return;
		}
		attributeHtml::editDivision();
	}
}

class dimensionControl{
	function editVariation(){
		global $system;
		
		$dimensionHtml=new dimensionHtml;
		$id=html::getInput($_GET,'id','');
		$vehicleid=html::getInput($_GET,'vehicleid');
		$submit=html::getInput($_POST,'submit');
		if($submit=='variation'){
			$fields=array(
				'VariationName'=>'Variation Name',
				'PlannedLifeCycle'=>'',
				'WB'=>'',
				'OAL'=>'',
				'OAW'=>'',
				'OAH'=>''
				);
			$sets=html::getPosts($fields,$dimensionHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				$id=html::getInput($_GET,'id');
				if($id!=''){
					db::updateByColumn('vehicledimension ','VehicleDimensionID',$id,$sets);
				}else{
					$sets['vehicleid']=$vehicleid;
					db::insert('vehicledimension ',$sets);
				}
				$system->messages[]='Your changes have been saved.';
				vehicleHtml::edit($vehicleid);
				return;
			}
		}
		$dimensionHtml->editVariation();
	}
	function editStartOfProduction(){
		global $system;
		
		$dimensionHtml=new dimensionHtml;
		$id=html::getInput($_GET,'id','');
		$vehicleid=html::getInput($_GET,'vehicleid');
		$submit=html::getInput($_POST,'submit');
		if($submit=='dimension'){
			$fields=array(
				'StartOfProduction'=>'Start of Production'
				);
			$sets=html::getPosts($fields,$dimensionHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				$id=html::getInput($_GET,'id');
				if($id!=''){
					db::updateByColumn('vehiclestartofproduction ','VehicleStartOfProductionID',$id,$sets);
				}else{
					$sets['vehicleid']=$vehicleid;
					db::insert('vehiclestartofproduction ',$sets);
				}
				$system->messages[]='Your changes have been saved.';
				vehicleHtml::edit($vehicleid);
				return;
			}
		}
		$dimensionHtml->editStartOfProduction();
	}
	function editSalesLaunch(){
		global $system;
		
		$dimensionHtml=new dimensionHtml;
		$id=html::getInput($_GET,'id','');
		$vehicleid=html::getInput($_GET,'vehicleid');
		$submit=html::getInput($_POST,'submit');
		if($submit=='dimension'){
			$fields=array(
				'SalesLaunch'=>'Sales Launch'
				);
			$sets=html::getPosts($fields,$dimensionHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				$id=html::getInput($_GET,'id');
				if($id!=''){
					db::updateByColumn('vehiclesaleslaunch ','VehicleSalesLaunchID',$id,$sets);
				}else{
					$sets['vehicleid']=$vehicleid;
					db::insert('vehiclesaleslaunch ',$sets);
				}
				$system->messages[]='Your changes have been saved.';
				vehicleHtml::edit($vehicleid);
				return;
			}
		}
		$dimensionHtml->editSalesLaunch();

	}
	function editCurbWeightRange(){
		global $system;
		
		$dimensionHtml=new dimensionHtml;
		$id=html::getInput($_GET,'id','');
		$vehicleid=html::getInput($_GET,'vehicleid');
		$submit=html::getInput($_POST,'submit');
		if($submit=='dimension'){
			$fields=array(
				'CurbWeightRange'=>'Curb Weight Range'
				);
			$sets=html::getPosts($fields,$dimensionHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				$id=html::getInput($_GET,'id');
				if($id!=''){
					db::updateByColumn('vehiclecurbweightrange ','VehicleCurbWeightRangeID',$id,$sets);
				}else{
					$sets['vehicleid']=$vehicleid;
					db::insert('vehiclecurbweightrange ',$sets);
				}
				$system->messages[]='Your changes have been saved.';
				vehicleHtml::edit($vehicleid);
				return;
			}
		}
		$dimensionHtml->editCurbWeightRange();

	}
	function editTireSizes(){
		global $system;
		
		$dimensionHtml=new dimensionHtml;
		$id=html::getInput($_GET,'id','');
		$vehicleid=html::getInput($_GET,'vehicleid');
		$submit=html::getInput($_POST,'submit');
		if($submit=='dimension'){
			$fields=array(
				'TireSize'=>'Tire Size'
				);
			$sets=html::getPosts($fields,$dimensionHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				$id=html::getInput($_GET,'id');
				if($id!=''){
					db::updateByColumn('vehicletiresize ','VehicleTireSizeID',$id,$sets);
				}else{
					$sets['vehicleid']=$vehicleid;
					db::insert('vehicletiresize ',$sets);
				}
				$system->messages[]='Your changes have been saved.';
				vehicleHtml::edit($vehicleid);
				return;
			}
		}
		$dimensionHtml->editTireSizes();

	}
	function editEngine(){
		global $system;
		
		$dimensionHtml=new dimensionHtml;
		$id=html::getInput($_GET,'id','');
		$submit=html::getInput($_POST,'submit');
		$vehicleid=html::getInput($_GET,'vehicleid');
		if($submit=='dimension'){
			$fields=array(
				'Engine'=>'Engine'
				);
			$sets=html::getPosts($fields,$dimensionHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				$id=html::getInput($_GET,'id');
				if($id!=''){
					db::updateByColumn('vehicleengine ','VehicleEngineID',$id,$sets);
				}else{
					$sets['vehicleid']=$vehicleid;
					db::insert('vehicleengine ',$sets);
				}
				$system->messages[]='Your changes have been saved.';
				vehicleHtml::edit($vehicleid);
				return;
			}
		}
		$dimensionHtml->editEngine();

	}
	function editSuspension(){
		global $system;
		
		$dimensionHtml=new dimensionHtml;
		$id=html::getInput($_GET,'id','');
		$vehicleid=html::getInput($_GET,'vehicleid');
		$submit=html::getInput($_POST,'submit');
		if($submit=='dimension'){
			$fields=array(
				'FrontSuspension'=>'Start of Production',
				'RearSuspension'=>'Start of Production'
				);
			$sets=html::getPosts($fields,$dimensionHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				$id=html::getInput($_GET,'id');
				if($id!=''){
					db::updateByColumn('vehiclesuspension ','VehicleSuspensionID',$id,$sets);
				}else{
					$sets['vehicleid']=$vehicleid;
					db::insert('vehiclesuspension ',$sets);
				}
				$system->messages[]='Your changes have been saved.';
				vehicleHtml::edit($vehicleid);
				return;
			}
		}
		$dimensionHtml->editSuspension();

	}
	function editPriceRange(){
		global $system;
		
		$dimensionHtml=new dimensionHtml;
		$id=html::getInput($_GET,'id','');
		$vehicleid=html::getInput($_GET,'vehicleid');
		$submit=html::getInput($_POST,'submit');
		if($submit=='dimension'){
			$fields=array(
				'Low'=>'Low',
				'High'=>''
				);
			$sets=html::getPosts($fields,$dimensionHtml);
			if(!$system->errors){
				db::addQuotes($sets);
				$id=html::getInput($_GET,'id');
				if($id!=''){
					db::updateByColumn('vehiclepricerange ','VehiclePriceRangeID',$id,$sets);
				}else{
					$sets['vehicleid']=$vehicleid;
					db::insert('vehiclepricerange ',$sets);
				}
				$system->messages[]='Your changes have been saved.';
				vehicleHtml::edit($vehicleid);
				return;
			}
		}
		$dimensionHtml->editPriceRange();

	}

}
?>
