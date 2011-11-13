<?php
global $my,$system;
defined('_VALID_PAGE') or die('Direct access not allowed');
global $system;
//session_start();
//echo "this is system: ".system::getComponentPath('user','/administration');
//require_once(system::getComponentPath('user','/administration').'/user_html.php');
require_once('user_html.php');
//require(system::getComponentPath('eauto').'/eauto_db.php');
$task=html::getInput($_GET,'task','list');
switch($task){
	case 'listsubscribers':
		list_subscribers();
		break;
	case 'subscriber':
		subscriber();
		break;
	case 'login':
		login();
		break;
	case 'logout':
		logout();
		break;
	case 'user':
		user();
		break;
	case 'preferences':
		preferences();
		break;	
	case 'export_users':
	case 'export_subscribers':
		export();
		break;
	default:
		list_subscribers();
}

function list_subscribers(){
	global $my,$system;
	
	if($my->admin_id==''){
		$system->errors[]=_ERROR_NO_LOGIN;
		return;
	}
	userHtml::listSubscribers();
}
function subscriber(){
	global $my,$system;
	
	if($my->admin_id==''){
		$system->errors[]='No Login';
		return;
	}
	$SubscriberID=html::getInput($_GET,'id');
	if($SubscriberID){
		$subscriber_row=subscriberDB::getAccess($SubscriberID);
		if($subscriber_row->adminid !=''
			&& $subscriber_row->adminid!=$my->admin_id 
			&& ($subscriber_row->diff_time < 300 && $subscriber_row->diff_time > 0)){
			$system->errors[]='Sorry Subscriber is in use.';
			userHtml::listSubscribers();
			return;
		}
		db::updateByColumn('subscriberinfo','SubscriberID',
			$SubscriberID,array('access_time'=>'curtime()','adminid'=>$my->admin_id));
	}
	$userHtml= new userHtml;
	$userHtml->SubscriberID=$SubscriberID;
	$action=html::getInput($_GET,'action');
	switch($action){
		case 'setmaster':
			$userid=html::getInput($_GET,'userid');
			//db::updateByColumn('user','SubscriberID',$SubscriberID,array('Master'=>"'0'"));
			//db::updateByColumn('user','UserID',$userid,array('Master'=>"'1'"));
			break;
		case 'subscribe0000':
			$startdate=date("Ymd");
			$enddate=date("Ymd",mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1));
			$serviceid=html::getInput($_GET,'serviceid');
			$sets=array(
				'SubscriberID'=>"'$SubscriberID'",
				'serviceid'=>"'$serviceid'",
				'StartDate'=>"'$startdate'",
				'EndDate'=>"'$enddate'"
				);
			db::insert('accesslevel',$sets);
//			header("location:index.php?comp=user&task=subscriber&id=$SubscriberID");
//			exit;
			break;
		case 'unsubscribe0000':
			$serviceid=html::getInput($_GET,'serviceid');
			db::deleteByColumns(
				'accesslevel',
				array('SubscriberID'=>"'$SubscriberID'",'serviceid'=>"'$serviceid'")
				);
			break;
		case 'delete_user':
			$confirm=html::getInput($_GET,'confirm');
			if($confirm=='yes'){
				$UserID=html::getInput($_GET,'uid');
				db::deleteByColumn('user','UserID',$UserID);
			}else if($confirm=='no'){
			}else{
				$UserID=html::getInput($_GET,'uid');
				$system->breadcrumbs['Subscribers']='index.php?comp=user';
				$system->breadcrumbs['Edit Subscriber']="index.php?comp=user&task=subscriber&id=$SubscriberID";
				$system->breadcrumbs['Confirm Delete User']='';
				$row=db::fetchObjectByColumn('user','UserID',$UserID);
				$userHtml=new userHtml;
				$userHtml->prompt="Are you sure you want to delete User $row->UserName?<br />";
				$userHtml->location='#user';
				$userHtml->confirm();
				return;
			}
			break;
		case 'delete':
			$confirm=html::getInput($_GET,'confirm');
			if($confirm=='yes'){
				$SubscriberID=html::getInput($_GET,'id');
				db::deleteByColumn('accesslevel','SubscriberID',$SubscriberID);
				db::deleteByColumn('user','SubscriberID',$SubscriberID);
				db::deleteByColumn('subscriberinfo','SubscriberID',$SubscriberID);
				$system->messages[]='Subscriber successfully deleted.';
				$userHtml->listSubscribers();
				return;
			}else if($confirm=='no'){
				header("location:index.php?comp=user");
				exit;
			}else{
				$system->breadcrumbs['Subscribers']='index.php?comp=user';
				$system->breadcrumbs['Confirm Delete Subscriber']='';
				$id=html::getInput($_GET,'id');
				$row=db::fetchObjectByColumn('subscriberinfo','SubscriberID',$id);
				$userHtml=new userHtml;
				$userHtml->prompt="Are you sure you want to delete Subscriber $row->CompanyName?<br />";
				$userHtml->prompt.="This will delete all the Users.";
				$userHtml->confirm();
				return;
			}
	}
	$submit=html::getInput($_POST,'submit');
	if($submit=='subscriber'){
		$fields=array(
			'CompanyName'=>'Company Name',
			'Address1'=>'Address',
			'Address2'=>'',
			'City'=>'City',
			'State'=>'State',
			'ZipCode'=>'Zip Code',
			'Country'=>'Country',
			'DaytimePhone'=>'Day time phone',
			'EveningPhone'=>'',
			'FaxNumber'=>'',
			'Identification'=>'',
			'SubscriberSince'=>'',
			'History'=>''
		);
		$sets=html::getPosts($fields,$userHtml);
		if(!$system->errors){
			db::addQuotes($sets);
			if($SubscriberID){
				db::updateBycolumn('subscriberinfo','SubscriberID',$SubscriberID,$sets);
				$system->messages[]='Your changes have been saved.';
			}else{
				$sets['adminid']=$my->admin_id;
				$sets['access_time']='curtime()';
				$userHtml->SubscriberID=db::insert('subscriberinfo',$sets);
			}
			$userHtml->subscriber();
			return;
		}
	}else if($submit=='service'){
		db::deleteByColumn('accesslevel','SubscriberID',$SubscriberID);
		foreach($_POST as $name=>$value){
			if($value=='on'){
				$StartDate=html::getInput($_POST,"StartDate_$name");
				$EndDate=html::getInput($_POST,"EndDate_$name");
				list($month,$day,$year)=explode("/",$StartDate);
				$StartDate="$year$month$day";
				list($month,$day,$year)=explode("/",$EndDate);
				$EndDate="$year$month$day";
				db::insert('accesslevel',array(
					'SubscriberID'=>"'$SubscriberID'",
					'serviceid'=>"'$name'",
					'StartDate'=>"'$StartDate'",
					'EndDate'=>"'$EndDate'"
					));
			}
		}
		$system->messages[]='Your changes have been saved.';
	}
	$userHtml->subscriber();
}
function login(){
	global $system;

	$username=html::getInput($_POST,'username');
	$password=html::getInput($_POST,'password');
	$result=systemDB::getAdminLogin($username,$password);
	if(mysql_num_rows($result)==1){
		$row=mysql_fetch_object($result);
		$_SESSION['admin_id']=$row->id;
			header('location: index.php');
			exit;
	}else{
				$system->error=_EROR_BAD_LOGIN;
	}
}
function logout(){
	$_SESSION['admin_id']='';
	header('location: index.php');
	exit;
}


function user(){
	global $system,$my;
	
	if($my->admin_id==''){
		$system->errors[]=_ERROR_NO_LOGIN;
		return;
	}
	$userHtml= new userHtml;
	$UserID=html::getInput($_GET,'id');
	$SubscriberID=html::getInput($_GET,'sid');
	$userHtml->SubscriberID=$SubscriberID;
	$submit=html::getInput($_POST,'submit');
	if($submit=='user'){
		$fields=array(
			'UserName'=>'Username',
			'FirstName'=>'First Name',
			'MiddleInitial'=>'',
			'LastName'=>'Last Name',
			'Title'=>'',
			'PhoneNumber'=>'',
			'EmailAddress'=>'Email',
			'Password'=>'Password');
		$sets=html::getPosts($fields,$userHtml);
		if(!$system->errors){
			db::addQuotes($sets);
			if($UserID!=''){
				$user_row=db::fetchObjectByColumn('user','UserID',$UserID);
				db::updateBycolumn('user','UserID',$UserID,$sets);
			}else{
				$row=db::fetchObjectByColumn('matrixprefs','PrefName','YearIncrement');
				$sets['SubscriberID']="'$SubscriberID'";
				$sets['YearIncrement']="'$row->PrefValue'";
				db::insert('user',$sets);
				$UserID=mysql_insert_id();
			}
			$Master=html::getInput($_POST,'Master');
			if($Master=='on'){
				db::updateByColumn('user','SubscriberID',$SubscriberID,array('Master'=>"'0'"));
				db::updateByColumn('user','UserID',$UserID,array('Master'=>"'1'"));
			}
			if($user_row->Master){
				$system->messages[]='A change has been successfully made to the Master User account.';
			}else{
				$system->messages[]='A change has been successfully made to a user account.';
			}
			$userHtml->subscriber();
			return;
		}
	}
	$userHtml->editUser();
}
function preferences(){
	global $system,$my;

	if($my->admin_id==''){
		$system->errors[]=_ERROR_NO_LOGIN;
		return;
	}
	$userHTML=new userHTML;
	$id=$my->id;
	$submit=html::getInput($_POST,'submit');
	if($submit=='preferences'){
		$fields=array(
			'BegYear'=>'Default beginning year',
			'YearIncrement'=>'Number of years');
		$sets=html::getPosts($fields,$userHTML);
		db::addQuotes($sets);
		if(!$system->errors){
			db::updateByColumn('matrixprefs','PrefID',1,array('PrefValue'=>$sets['BegYear']));
			db::updateByColumn('matrixprefs','PrefID',2,array('PrefValue'=>$sets['YearIncrement']));
		}
		$system->messages[]='Your preferences have been saved.';
	}
	$userHTML->preferences();
}
function export(){
	$task=html::getInput($_GET,'task','');
	switch($task){
		case 'export_subscribers':
			userHTML::exportSubscribers();
			break;
		case 'export_users':
			userHTML::exportUsers();
			break;
	}
	exit;
}
?>