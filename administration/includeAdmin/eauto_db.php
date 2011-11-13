<?php
defined('_VALID_PAGE') or die('Direct access not allowed');
class eautoDB{

	function getSegmentsByForecast($sfcsid){
		$query = "SELECT distinct s.* from segment as s, service as sv, segmentservice ss, vehicles as v  ";
		$query .= "where sv.sfcsid=$sfcsid and sv.serviceid = ss.serviceid and ss.segmentid = s.segmentid ";
		$query .= "and v.segmentid = s.segmentid and v.ActiveFlag = 1 ";
		$query .= "order by s.name ";
		$result=db::executeQuery($query);
		return $result;
	}
	function getSegmentsByBattleground($cbgid){
		$query = "SELECT distinct s.* from segment as s, service as sv, segmentservice ss, vehicles as v  ";
		$query .= "where sv.cbgid=$cbgid and sv.serviceid = ss.serviceid and ss.segmentid = s.segmentid ";
		$query .= "and v.segmentid = s.segmentid and v.ActiveFlag = 1 ";
		$query .= "order by s.name ";

		$result=db::executeQuery($query);
		return $result;
	}
	function getMakesByBattleground($cbgid){
		$query = "SELECT distinct m.* from make as m, service as sv, makeservice ms, vehicles as v ";
		$query .= "where sv.cbgid=$cbgid and sv.serviceid = ms.serviceid and ms.makeid = m.makeid ";
		$query .= "and v.makeid = m.makeid and v.ActiveFlag = 1 ";
		$query .= "order by m.name ";
		$result=db::executeQuery($query);
		return $result;
	}
	function getMakesByForecast($sfcsid){
		$query = "SELECT distinct m.* from make as m, service as sv, makeservice ms, vehicles as v  ";
		$query .= "where sv.sfcsid=$sfcsid and sv.serviceid = ms.serviceid and ms.makeid = m.makeid ";
		$query .= "and v.makeid = m.makeid and v.ActiveFlag = 1 and v.sfcsactive=1 ";
		$query .= "order by m.name ";
		$result=db::executeQuery($query);
		return $result;
	}
	function getMakesByCBG($cbgid){
		if($task='forecast'){
			$query = "SELECT distinct m.* from make as m, vehicles as v  ";
			$query .="where v.cbgid=$cbgid and v.makeid = m.makeid ";
			$query .= "order by m.name ";
		}
		$result=db::executeQuery($query);
		return $result;
	}
	function getAdminMakesByCBG($cbgid){
			$query = "SELECT distinct m.* from make as m, makeservice as ms, service as s  ";
			$query .="where s.cbgid=$cbgid and s.serviceid = ms.serviceid and ms.makeid=m.makeid ";
			$query .= "order by m.name ";
		$result=db::executeQuery($query);
		return $result;
	}
	function getVehiclesByMakeAndBattleground($makeid,$cbgid){
		$query = "SELECT * from  vehicles as v ";
		$query.= "where v.makeid='$makeid' and v.cbgid='$cbgid' and DeleteFlag=0 ";
		$query.= "order by v.VehicleName ";
		$result=db::executeQuery($query);
		return $result;
	}
	function getVehicleSegment($vehicleid){
		$query = "SELECT s.* from  vehicles as v, segment as s ";
		$query.= "where v.vehicleid=$vehicleid and s.segmentid=v.segmentid";
		$result=db::executeQuery($query);
		$row=mysql_fetch_object($result);
		return $row->name;
	}
	function getVehicle($vehicleid){
		$query = "SELECT *,v.VehicleID as VehicleID,s.name as segment_name,m.name as make_name ";
		$query.= "from  make as m, vehicles as v ";
		$query.= "left join segment as s on v.segmentid=s.segmentid ";
		$query.= "left join vehiclebattleground as vb on v.vehicleid=vb.vehicleid ";
		$query.= "left join vehicledemographic as vd on v.vehicleid=vd.vehicleid ";
		$query.= "left join vehicleengine as ve on v.vehicleid=ve.vehicleid ";
		$query.= "where v.vehicleid='$vehicleid' and v.makeid=m.makeid ";
		$result=db::executeQuery($query);
		$row=mysql_fetch_object($result);
		return $row;
	}
	function getDrivesByVehicle($vehicleid){
		$query="select * from vehicledrive as vd, drive as d ";
		$query.="where vd.vehicleid='$vehicleid' and d.driveid = vd.driveid";
		$result=db::executeQuery($query);
		return $result;
	}
	function getTransmissionsByVehicle($vehicleid){
		$query="select * from vehicletransmission as vt, transmission as t ";
		$query.="where vt.vehicleid='$vehicleid' and t.transmissionid = vt.transmissionid";
		$result=db::executeQuery($query);
		return $result;
	}
	function getBodystylesByVehicle($vehicleid){
		$query="select * from  vehiclebodystyle as vb, bodystyle as b ";
		$query.="where vb.vehicleid= '$vehicleid' and vb.bodystyleid = b.bodystyleid ";
		$result=db::executeQuery($query);
		return $result;
	}

	function getContent($vehicleid){
		$query= "SELECT		ContentID,Content,PublishDate,ArchiveDate,ActiveFlag ";
		$query .="FROM		Content ";
		$query .=" WHERE		DeleteFlag = '0' ";
		$query .=" AND			Type = 'VPR' AND			VehicleID = '$vehicleid' ";
		$query .=" ORDER BY	PublishDate DESC ";
		$result=db::executeQuery($query);
		return $result;
	}
	
	function getDownloads(){
		global $my;
		
		foreach($my->services['cbg'] as $service){
			$services.= "'{$service['id']}',";
		}
		foreach($my->services['sfcs'] as $service){
			$services.= "'{$service['id']}',";
		}
		$services=rtrim($services,',');

		$query = " SELECT		SourceFileName, FileCaption, UploadDate, ModifyDate, FileSize ";
		$query .= " FROM		Files ";
		$query .= " WHERE		serviceid = '0' or serviceid in($services)";
		$query .= " ORDER BY	FileCaption ASC ";

				$q = "
					SELECT		SourceFileName,
								FileCaption,
								UploadDate,
								ModifyDate,
								FileSize
					FROM		Files
					WHERE		(
									CategoryItemID IN ($accessLevelList)
									OR CategoryItemID = '1'
								)
					ORDER BY	FileCaption ASC
				";
		$result=db::executeQuery($query);
		return $result;
	}
	
	function getMakeCategory($id){
		$cbg_result=db::getResultByColumn('service','type','CBG','order by name');
		$this->cbg=array();
		$this->cbg_active=array();
		while($row=mysql_fetch_object($cbg_result)){
			$this->cbg[$row->serviceid]['name']=$row->name;
		}
		$query="select * from makeservice as ms, service as s ";
		$query.="where ms.serviceid = s.serviceid and s.type='CBG'  and ms.makeid='$id'";
		$makeservice_result=db::executeQuery($query);
		while($row=mysql_fetch_object($makeservice_result)){
			$this->cbg[$row->serviceid]['checked']='checked';
			$this->cbg_active[$row->serviceid]=$row->name;
		}

		$sfcs_result=db::getResultByColumn('service','type','SFCS','order by name');
		$this->sfcs=array();
		$this->sfcs_active=array();
		while($row=mysql_fetch_object($sfcs_result)){
			$this->sfcs[$row->serviceid]['name']=$row->name;
		}
		$query="select * from makeservice as ms, service as s ";
		$query.="where ms.serviceid = s.serviceid and s.type='SFCS'   and ms.makeid='$id' ";
		$makeservice_result=db::executeQuery($query);
		while($row=mysql_fetch_object($makeservice_result)){
			$this->sfcs[$row->serviceid]['checked']='checked';
			$this->sfcs_active[$row->serviceid]=$row->name;
		}
	}
	function getSegmentCategory($id){
		$cbg_result=db::getResultByColumn('service','type','CBG','order by name');
		$this->cbg=array();
		$this->cbg_active=array();
		while($row=mysql_fetch_object($cbg_result)){
			$this->cbg[$row->serviceid]['name']=$row->name;
		}
		$query="select * from segmentservice as ss, service as s ";
		$query.="where ss.serviceid = s.serviceid and s.type='CBG'  and ss.segmentid='$id'";
		$service_result=db::executeQuery($query);
		while($row=mysql_fetch_object($service_result)){
			$this->cbg[$row->serviceid]['checked']='checked';
			$this->cbg_active[$row->serviceid]=$row->name;
		}

		$sfcs_result=db::getResultByColumn('service','type','SFCS','order by name');
		$this->sfcs=array();
		$this->sfcs_active=array();
		while($row=mysql_fetch_object($sfcs_result)){
			$this->sfcs[$row->serviceid]['name']=$row->name;
		}
		$query="select * from segmentservice as ss, service as s ";
		$query.="where ss.serviceid = s.serviceid and s.type='SFCS'   and ss.segmentid='$id' ";
		$service_result=db::executeQuery($query);
		while($row=mysql_fetch_object($service_result)){
			$this->sfcs[$row->serviceid]['checked']='checked';
			$this->sfcs_active[$row->serviceid]=$row->name;
		}
	}
	function getServiceMakeText($serviceid,$makeid){
			$query="select * from servicemaketext as s, additionaltext as a ";
			$query.="where s.makeid = '$makeid' and s.serviceid='$serviceid' ";
			$query.="and s.additionaltextid = a.additionaltextid";
			$this->text_row=db::executeFetchObject($query);
			
			$query="select * from servicemakepr as s, content as c ";
			$query.="where s.serviceid='$serviceid' and s.makeid='$makeid' and s.contentid = c.contentid ";
			$query.="order by c.PublishDate desc";
			$this->result=db::executeQuery($query);
	}
	function getServiceSegmentText($serviceid,$segmentid){
			$query="select * from servicesegmenttext as s, additionaltext as a ";
			$query.="where s.segmentid = '$segmentid' and s.serviceid='$serviceid' ";
			$query.="and s.additionaltextid = a.additionaltextid";
			$this->text_row=db::executeFetchObject($query);
			
			$query="select * from servicemakepr as s, content as c ";
			$query.="where s.serviceid='$serviceid' and s.segmentid='$segmentid' and s.contentid = c.contentid ";
			$query.="order by c.PublishDate desc";
//			$this->result=db::executeQuery($query);
	}
	
	function getAdminSegment($cbgid,$type){
		
		$query="select *, s.name as segment_name from segment as s, service as sv, segmentservice as ss ";
		$query.="where s.type='$type' and sv.cbgid='$cbgid' and sv.serviceid = ss.serviceid ";
		$query.="and ss.segmentid = s.segmentid  order by s.name asc";
		$result=db::executeQuery($query);
		return($result);
	}
}
class pressreleaseDB{
	function getEauto(){
		$requestDate = date("Ymd");
		$query = "SELECT		ContentID, Content FROM		Content ";
		$query .= "WHERE		Type = 'HPR' AND			ActiveFlag = '1' AND			DeleteFlag = '0' ";
		$query .= "	AND	$requestDate >= PublishDate AND	($requestDate <= ArchiveDate OR ArchiveDate = '') ";
		$query .= "		ORDER BY	PublishDate DESC ";
		$result= db::executeQuery($query);
		return $result;
	}
	function getVehicle($id){
		$requestDate = date("Ymd");
		$query = "SELECT		ContentID, Content FROM		Content ";
		$query .= "WHERE		Type = 'VPR' AND			ActiveFlag = '1' AND			DeleteFlag = '0' ";
		$query .= "	AND	$requestDate >= PublishDate AND	($requestDate <= ArchiveDate OR ArchiveDate = '') ";
		$query .= "	AND	vehicleid = '$id'";
		$query .= "		ORDER BY	PublishDate DESC ";
		$result= db::executeQuery($query);
		return $result;
	}

	function get($id){
		$query = "SELECT	Content, Type FROM	Content ";
		$query .= "WHERE	ContentID = '$id' ";
		$result= db::executeQuery($query);
		$row = mysql_fetch_object($result);
		return $row;
	}
	function getMakeService($makeid,$serviceid){
		$query="select * from servicemakepr as smpr, content as c ";
		$query .= "WHERE	smpr.serviceid = '$serviceid'and smpr.makeid='$makeid' ";
		$query .= "and smpr.contentid = c.contentid order by c.publishdate desc ";
		$result= db::executeQuery($query);
		return $result;
	}
}

class vehicleDB{
	function getDimensions($vehicleid){
		$measurements=$_SESSION['measurements']==''?'metric':$_SESSION['measurements'];
		$query="select * from vehicledimension ";
		$query.="where vehicleid = '$vehicleid' ";
		$query.="and deleteflag=0 ";
		$result=db::executeQuery($query);
		$this->dimensions=array();
		while($row=mysql_fetch_object($result)){
			$id=$row->VehicleDimensionID;
			$this->dimensions[$id]['VariationName']=$row->VariationName;
			$this->dimensions[$id]['PlannedLifeCycle']=$row->PlannedLifeCycle;
			$this->dimensions[$id]['OAH']=
				$measurements=='english'?vehicleDB::toEnglish($row->OAH):$row->OAH.' mm';
			$this->dimensions[$id]['OAW']=
				$measurements=='english'?vehicleDB::toEnglish($row->OAW):$row->OAW.' mm';
			$this->dimensions[$id]['OAL']=
				$measurements=='english'?vehicleDB::toEnglish($row->OAL):$row->OAL.' mm';
			$this->dimensions[$id]['WB']=
				$measurements=='english'?vehicleDB::toEnglish($row->WB):$row->WB.' mm';
		}
	}
	function getAdminDimensions($vehicleid){
		$query="select * from vehicledimension ";
		$query.="where vehicleid = '$vehicleid' ";
		$query.="and deleteflag=0 ";
		$result=db::executeQuery($query);
		$this->dimensions=array();
		while($row=mysql_fetch_object($result)){
			$id=$row->VehicleDimensionID;
			$this->dimensions[$id]['VariationName']=$row->VariationName;
			$this->dimensions[$id]['PlannedLifeCycle']=$row->PlannedLifeCycle;
			$this->dimensions[$id]['OAH']=$row->OAH;
			$this->dimensions[$id]['OAW']=$row->OAW;
			$this->dimensions[$id]['OAL']=$row->OAL;
			$this->dimensions[$id]['WB']=$row->WB;
		}
	}
	function toEnglish($dimension){
		return round(($dimension/25.4),1).' in';
	}
	
}

class subscriberDB{
	function getSubscriber($id){
		$result=db::getResultByColumn('service','type','CBG','order by name');
		while($row=mysql_fetch_object($result)){
			$this->cbg[$row->serviceid]['name']=$row->name;
			$this->cbg[$row->serviceid]['dates']='disabled';
			$this->cbg[$row->serviceid]['StartDate']=
				date("Ymd");			
			$this->cbg[$row->serviceid]['EndDate']=
				date("Ymd",mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1));

		}
		$result=db::getResultByColumn('service','type','SFCS','order by name');
		while($row=mysql_fetch_object($result)){
			$this->sfcs[$row->serviceid]['name']=$row->name;
			$this->sfcs[$row->serviceid]['dates']='disabled';
			$this->sfcs[$row->serviceid]['StartDate']=
				date("Ymd");			
			$this->sfcs[$row->serviceid]['EndDate']=
				date("Ymd",mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1));
		}
		if($id!=''){
			$query="select * from service as s, accesslevel as al ";
			$query.="where al.SubscriberID = '$id' and s.serviceid = al.serviceid";
			$result=db::executeQuery($query);
			while($row=mysql_fetch_object($result)){
				if($row->type=='CBG'){
					$this->cbg[$row->serviceid]['subscribed']='checked="checked"';
					$this->cbg[$row->serviceid]['StartDate']=$row->StartDate;
					$this->cbg[$row->serviceid]['EndDate']=$row->EndDate;
					$this->cbg[$row->serviceid]['dates']='';
				}else{
					$this->sfcs[$row->serviceid]['subscribed']='checked="checked"';
					$this->sfcs[$row->serviceid]['StartDate']=$row->StartDate;
					$this->sfcs[$row->serviceid]['EndDate']=$row->EndDate;
					$this->sfcs[$row->serviceid]['dates']='';
				}
			}
		}
	}
	function getAccess($id){
		$query="select *,curtime()-access_time as diff_time from subscriberinfo ";
		$query.="where SubscriberID = '$id' ";
		$row=db::executeFetchObject($query);
		return $row;
	}
	function getService($serviceid,$userid){
		if(!$serviceid){
			return;
		}
		$query="select * from user as u, subscriberinfo as s, accesslevel as a ";
		$query.="where u.UserID = $userid and u.SubscriberID and u.SubscriberID= a.SubscriberID ";
		$query.="and a.serviceid =  $serviceid ";
		$query.="and a.StartDate < curdate()+0 and  a.EndDate > curdate() + 0 ";
		$row=db::executeFetchObject($query);
		return $row;
	}
	function getServicesByUser($userid){
		$query="select * from user as u, subscriberinfo as su, accesslevel as al, service as sv ";
		$query.="where u.userid='$userid' and u.SubscriberID = su.SubscriberID ";
		$query.="and su.SubscriberID=al.SubscriberID and al.serviceid = sv.serviceid ";
		$query.="and al.StartDate < curdate()+0 and  al.EndDate > curdate() + 0 ";
		$query.="order by sv.name";
		$result=db::executeQuery($query);
		return $result;
	}
	function getServicesBySubsciber($subscriberid){
		$query="select * from subscriberinfo as su, accesslevel as al, service as sv ";
		$query.="where  $subscriberid = su.SubscriberID ";
		$query.="and su.SubscriberID=al.SubscriberID and al.serviceid = sv.serviceid ";
		$query.="order by sv.name";
		$result=db::executeQuery($query);
		return $result;
	}
	function getUserNotesByUser($userid,$vehicleid,$serviceid){
		$query="select * from usernotes as n ";
		$query.="where n.userid = '$userid' and n.VehicleID ='$vehicleid' and n.serviceid = '$serviceid' ";
		$row=db::executeFetchObject($query);
		return $row;
	}
	function getUserNotes($userid,$vehicleid,$serviceid){
		$query="select n.* from usernotes as n, subscriberinfo as s, user as u ,user as un ";
		$query.="where u.userid = '$userid' and u.SubscriberID = s.SubscriberID ";
		$query.="and un.SubscriberID = s.SubscriberID and un.master = 1 ";
		$query.="and n.VehicleID ='$vehicleid' and n.serviceid = '$serviceid' ";
		$query.="and un.UserID =n.UserID ";
		$result=db::executeQuery($query);
		while($row=mysql_fetch_object($result)){
			$notes=$row->Notes;
		}
		return $notes;
	}
	function setUserNotes($userid,$vehicleid,$serviceid,$Notes){
		$row=eautoDB::getUserNotesByuser($userid,$vehicleid,$serviceid);
		if($row==''){
			$values=array(
				'VehicleID'=>$vehicleid,
				'serviceid'=>$serviceid,
				'UserID'=>$userid,
				'Notes'=>$Notes);
			db::insert('usernotes',$values);
		}else{
			$values=array('Notes'=>$row->Notes.'<br />'.$Notes);
			db::updateByColumn('usernotes','NoteID',$row->NoteID,$values);
		}
	}
}
class customSegmentDB{
	function getBySubscriberAndService($id,$serviceid){
		$query="select * from customsegments as cs, user as u ";
		$query.="where cs.userid = u.userid ";
		$query.="and u.SubscriberID = '$id' and cs.serviceid='$serviceid' ";
		$query.="order by SegmentName asc ";
		$result=db::executeQuery($query);
		return $result;
	}

	function getByUserAndService($id,$serviceid){
		$query="select * from customsegments as cs, user as u, user as mu ";
		$query.="where (cs.userid = '$id' and cs.serviceid='$serviceid' and u.userid ='$id' and mu.userid='$id') ";
		$query.="or (cs.userid=mu.userid and u.userid='$id' and mu.SubscriberID = u.SubscriberID and mu.Master = 1 and cs.serviceid='$serviceid') ";
		$query.="order by SegmentName asc ";
		$result=db::executeQuery($query);
		return $result;
	}

	function getByIDAndUser($id,$userid){
		$query="select * from customsegments as cs,service as s ";
		$query.="where cs.userid = '$userid' and cs.customsegmentid='$id' ";
		$query.="and s.serviceid = cs.serviceid ";
		$result=db::executeQuery($query);
		$this->row=mysql_fetch_object($result);

		$query="select * from customsegmentvehicles as csv, vehicles as v ";
		$query.="where csv.CustomSegmentID = '$id' and csv.vehicleid=v.vehicleid";
		$result=db::executeQuery($query);
		$this->vehicles=array();
		while($row=mysql_fetch_object($result)){
			$this->vehicles[$row->VehicleID]=$row->VehicleName;
		}
	}
}
class salesforecastDB{
	function getByVehicle($vehicleid){
		$this->year_min=10000000;
		$result=$this->getVehicleSales($vehicleid);
		while($row=mysql_fetch_object($result)){
			$this->bodystyle[$row->name][$row->SalesYear]=$row->SalesValue;
			$this->total[$row->SalesYear]+=$row->SalesValue;
			$this->total_max<$this->total[$row->SalesYear]?
				$this->total_max=$this->total[$row->SalesYear]:"";
			$this->year_min>$row->SalesYear?
				$this->year_min=$row->SalesYear:"";
			$this->year_max<$row->SalesYear?
				$this->year_max=$row->SalesYear:"";			
		}
		$this->vehicle=eautoDB::getVehicle($vehicleid);
		$this->text=$this->getSalesForecasttextByVehicle($vehicleid);
		$category=$_SESSION['category'];
		$this->cbgid=$this->vehicle->cbgid;
		if($category=='make'){
			$result=$this->getVehicleTotalsByMake($this->vehicle->makeid);
		}else if($category=='segment'){
			$result=$this->getVehicleTotalsBySegment($this->vehicle->segmentid);
		}
		while($row=mysql_fetch_object($result)){
			$this->category_total[$row->salesyear]=$row->total;
		}
		$sfcs_row=db::fetchObjectByColumn('sfcs','cbgid',$this->vehicle->cbgid);
		$this->service_row=db::fetchObjectByColumn('service','sfcsid',$sfcs_row->sfcsid);

	}
	function getListByVehicle($vehicleid,$start_year,$end_year){
		$this->bodystyles=array();
		$query="select * from bodystyle as b, vehiclebodystyle as vb ";
		$query.="where  vb.vehicleid=$vehicleid and vb.bodystyleid = b.bodystyleid ";
		$result=db::executeQuery($query);
		while($row=mysql_fetch_object($result)){
			$this->bodystyles[$row->name]='';
			$this->bodystyles[$row->name]['id']=$row->bodystyleid;
		}
		$result=$this->getSalesListByVehicle($vehicleid,$start_year,$end_year);
		while($row=mysql_fetch_object($result)){
			$this->bodystyles[$row->name][$row->SalesYear]=$row;
			$this->totals[$row->SalesYear]+=$row->SalesValue;
		}
		$this->vehicle=eautoDB::getVehicle($vehicleid);
		$this->row=$this->getSalesForecasttextListByVehicle($vehicleid);
	}
	function getSalesListByVehicle($vehicleid,$start_year,$end_year){
		$query ="SELECT * From salesforecast as sf , bodystyle as b, vehiclebodystyle as vb ";
		$query.="Where sf.vehicleid = $vehicleid and b.bodystyleid = sf.bodystyleid ";
		$query.="and b.bodystyleid=vb.bodystyleid and vb.vehicleid='$vehicleid'";
		$query.="and sf.salesyear>=$start_year and sf.salesyear<=$end_year";
		$result=db::executeQuery($query);
		return $result;
	}
	function getByVehicleBodyStyle($vehicleid,$bodystyleid,$start_year,$end_year){
		$query="select * from salesforecast ";
		$query.="where salesyear >=$start_year and salesyear <=$end_year ";
		$query.="and vehicleid =$vehicleid and bodystyleid =$bodystyleid ";
		$result=db::executeQuery($query);
		return $result;
	}
	function getSalesForecasttextByVehicle($vehicleid){
		$query="select * from salesforecasttext  ";
		$query.="where vehicleid='$vehicleid' ";
		$result=db::executeQuery($query);
		$row=mysql_fetch_object($result);
		$text=$row->SFText;
		return $text;
	}
	function getSalesForecasttextListByVehicle($vehicleid){
		$query="select * from salesforecasttext  ";
		$query.="where vehicleid='$vehicleid' ";
		$result=db::executeQuery($query);
		$row=mysql_fetch_object($result);
		return $row;
	}
	function getVehicleTotalsByMake($makeid){
		$query="select salesyear,sum(salesvalue) as total ";
		$query.="from vehicles as v, salesforecast as s ";
		$query.="where s.vehicleid = v.vehicleid  ";
		$query.="and v.makeid = '$makeid' and v.sfcsactive='1' ";
		$query.="and v.cbgid = '$this->cbgid' ";
		$query.="and s.SalesValue <> 0 ";
		$query.="group by salesyear";
		
		$result=db::executeQuery($query);
		return $result;
	}
	function getVehicleTotalsBySegment($segmentid){
		$query="select salesyear,sum(salesvalue) as total ";
		$query.="from vehicles as v, salesforecast as s ";
		$query.="where s.vehicleid = v.vehicleid  ";
		$query.=" and v.segmentid = '$segmentid' and v.sfcsactive='1' ";
		$query.="and v.cbgid = '$this->cbgid' ";
		$query.="and s.SalesValue <> 0 ";
		$query.="group by salesyear ";
		
		$result=db::executeQuery($query);
		return $result;
	}
	function getVehicleTotalsByCustomSegment($segmentid){
		$query="select * from customsegmentvehicles where CustomSegmentID = $segmentid ";
		$result=db::executeQuery($query);
		while($row=mysql_fetch_object($result)){
			$vehicles .="'$row->VehicleID',";
		}
		$vehicles=rtrim($vehicles,',');
		$vehicles=$vehicles==''?"''":$vehicles;
		$query="select s.salesyear,sum(s.salesvalue) as total ";
		$query.="from salesforecast as s, vehicles as v ";
		$query.="where s.vehicleid in ($vehicles) and s.vehicleid=v.vehicleid and v.sfcsactive='1' ";
		$query.="and v.cbgid = '$this->cbgid' ";
		$query.=" group by salesyear";
		$result=db::executeQuery($query);
		return $result;
	}
	function getVehicleSalesByVehicle($vehicleid,$start_year,$end_year){
		$query="SELECT * From salesforecast ";
		$query.="where vehicleid= $vehicleid and salesyear>'$start_year' and salesyear < '$end_year'";
		$result=db::executeQuery($query);
		return $result;		
	}

	function getVehicleSalesByMake($makeid,$start_year,$end_year){
		$query ="SELECT * From salesforecast as sf,vehicles as v ";
		$query.="Where v.makeid=$makeid and v.sfcsactive='1' ";
		$query.="and v.cbgid='$this->cbgid' ";
		$query.="and v.vehicleid= sf.vehicleid and salesyear >='$start_year' and salesyear <='$end_year'";
		$result=db::executeQuery($query);
		return $result;		
	}

	function getVehicleSalesBySegment($segmentid,$start_year,$end_year){
		$query ="SELECT * From salesforecast as sf,vehicles as v ";
		$query.="Where v.segmentid=$segmentid and v.sfcsactive='1' ";
		$query.="and v.cbgid='$this->cbgid' ";
		$query.="and v.vehicleid= sf.vehicleid and salesyear >='$start_year' and salesyear <='$end_year' ";
		$result=db::executeQuery($query);
		return $result;		
	}

	function getVehicleSalesByCustomSegment($segmentid,$start_year,$end_year){
		$query="select * from customsegmentvehicles where CustomSegmentID = $segmentid ";
		$result=db::executeQuery($query);
		while($row=mysql_fetch_object($result)){
			$vehicles .="$row->VehicleID,";
		}
		$vehicles=rtrim($vehicles,',');
		$vehicles=$vehicles==''?"''":$vehicles;

		$query ="SELECT * From salesforecast as sf,vehicles as v ";
		$query.="Where v.vehicleid in ($vehicles)  and v.sfcsactive='1' ";
		$query.="and v.cbgid='$this->cbgid' ";
		$query.="and v.vehicleid= sf.vehicleid and salesyear >='$start_year' and salesyear <='$end_year'";
		$result=db::executeQuery($query);
		return $result;		
	}
	
	function getVehicleSales($vehicleid){
		$query ="SELECT * From salesforecast as sf , bodystyle as b ";
		$query.="Where sf.vehicleid = $vehicleid and b.bodystyleid = sf.bodystyleid ";
		$query.="and sf.SalesValue <> 0 ";
		$query.="order by b.name ";
		$result=db::executeQuery($query);
		return $result;
	}

	function getVehicleSalesLimits($vehicleid){
		$query ="SELECT Max(sf.SalesYear) as year_max, Min(sf.SalesYear) as year_min ";
		$query.="From salesforecast as sf ";
		$query.="Where sf.vehicleid = $vehicleid ";
		$query.="group by sf.vehicleid ";
		$result=db::executeQuery($query);
		$row=mysql_fetch_object($result);
		return $row;
	}

	function getVehiclesForecastBySegment($segmentid,$start_year,$end_year){
		$result=$this->getVehicleTotalsBySegment($segmentid);
		$this->year_min=10000000;
		while($row=mysql_fetch_object($result)){
			$year = $row->salesyear;
			$this->total[$year]=$row->total;
				$this->year_max<$year?
					$this->year_max=$year:"";
				$this->year_min>$year?
					$this->year_min=$year:"";
				$this->total_max<$row->total?
					$this->total_max=$row->total:"";
		}
		$this->text=$this->getSFCSSegmentAdditionaltext($this->serviceid,$segmentid);

		$query = "SELECT *,name as segmentname from vehicles as v , segment as s ";
		$query.= "where v.segmentid=$segmentid and v.segmentid = s.segmentid and v.sfcsactive='1' ";
		$query.=" order by v.Vehiclename ";
		$result=db::executeQuery($query);
		
		$this->cars=array();
		$this->trucks=array();
		while($row=mysql_fetch_object($result)){
			if($row->TruckFlag==0){
				$this->cars[$row->VehicleID]['vehicle']=$row;
			}else{
				$this->trucks[$row->VehicleID]['vehicle']=$row;
			}
		}
		$sales_result = $this->getvehicleSalesBySegment($segmentid,$start_year,$end_year);
		while($sales_row=mysql_fetch_object($sales_result)){
			$sales=$sales_row->SalesValue;
			$year=$sales_row->SalesYear;
			if($sales_row->TruckFlag==0){
				$this->cars[$sales_row->VehicleID]['sales'][$year]+=$sales;
				$this->cars[$sales_row->VehicleID]['total']+=$sales;
				$this->cars_total[$year]+=$sales;
			}else{
				$this->trucks[$sales_row->VehicleID]['sales'][$year]+=$sales;
				$this->trucks[$sales_row->VehicleID]['total']+=$sales;
				$this->trucks_total[$year]+=$sales;
			}
		}
	}
	
	function getVehiclesForecastByCustomSegment($segmentid,$start_year,$end_year){
		$result=$this->getVehicleTotalsByCustomSegment($segmentid);
		$this->year_min=10000000;
		while($row=mysql_fetch_object($result)){
			$year = $row->salesyear;
			$this->total[$year]=$row->total;
				$this->year_max<$year?
					$this->year_max=$year:"";
				$this->year_min>$year?
					$this->year_min=$year:"";
				$this->total_max<$row->total?
					$this->total_max=$row->total:"";
		}

		$query="select * from customsegmentvehicles where CustomSegmentID = $segmentid ";
		$result=db::executeQuery($query);
		while($row=mysql_fetch_object($result)){
			$vehicles .="$row->VehicleID,";
		}
		$vehicles=rtrim($vehicles,',');

		$vehicles=$vehicles==''?"''":$vehicles;
		$query = "SELECT * from vehicles as v  ";
		$query.= "where v.vehicleid in($vehicles) and v.sfcsactive='1' ";
		$query.=" order by v.Vehiclename ";
		$result=db::executeQuery($query);
		
		$this->cars=array();
		$this->trucks=array();
		while($row=mysql_fetch_object($result)){
			if($row->TruckFlag==0){
				$this->cars[$row->VehicleID]['vehicle']=$row;
			}else{
				$this->trucks[$row->VehicleID]['vehicle']=$row;
			}
		}
		
		$sales_result = $this->getvehicleSalesByCustomSegment($segmentid,$start_year,$end_year);
		while($sales_row=mysql_fetch_object($sales_result)){
			$sales=$sales_row->SalesValue;
			$year=$sales_row->SalesYear;
			if($sales_row->TruckFlag==0){
				$this->cars[$sales_row->VehicleID]['sales'][$year]+=$sales;
				$this->cars[$sales_row->VehicleID]['total']+=$sales;
				$this->cars_total[$year]+=$sales;
			}else{
				$this->trucks[$sales_row->VehicleID]['sales'][$year]+=$sales;
				$this->trucks[$sales_row->VehicleID]['total']+=$sales;
				$this->trucks_total[$year]+=$sales;
			}
		}
	}
	
	function getVehiclesForecastByMake($makeid,$start_year,$end_year){
		$result=$this->getVehicleTotalsByMake($makeid);
		$this->year_min=10000000;
		while($row=mysql_fetch_object($result)){
			$year = $row->salesyear;
			$this->total[$year]=$row->total;
				$this->year_max<$year?
					$this->year_max=$year:"";
				$this->year_min>$year?
					$this->year_min=$year:"";
				$this->total_max<$row->total?
					$this->total_max=$row->total:"";
		}
		$this->text=$this->getSFCSMakeAdditionaltext($this->serviceid,$makeid);

		$query = "SELECT *,name as segmentname from vehicles as v , segment as s ";
		$query.= "where v.makeid=$makeid and v.segmentid = s.segmentid and v.sfcsactive='1' ";
		$query.=" order by v.Vehiclename ";
		$result=db::executeQuery($query);
		
		$this->cars=array();
		$this->trucks=array();
		while($row=mysql_fetch_object($result)){
			if($row->TruckFlag==0){
				$this->cars[$row->VehicleID]['vehicle']=$row;
			}else{
				$this->trucks[$row->VehicleID]['vehicle']=$row;
			}
		}
		
		$sales_result = $this->getvehicleSalesByMake($makeid,$start_year,$end_year);
		while($sales_row=mysql_fetch_object($sales_result)){
			$sales=$sales_row->SalesValue;
			$year=$sales_row->SalesYear;
			if($sales_row->TruckFlag==0){
				$this->cars[$sales_row->VehicleID]['sales'][$year]+=$sales;
				$this->cars[$sales_row->VehicleID]['total']+=$sales;
				$this->cars_total[$year]+=$sales;
			}else{
				$this->trucks[$sales_row->VehicleID]['sales'][$year]+=$sales;
				$this->trucks[$sales_row->VehicleID]['total']+=$sales;
				$this->trucks_total[$year]+=$sales;
			}
		}
	}
	function getSFCSMakeAdditionaltext($serviceid,$makeid){
		$query="select * from servicemaketext as sma, additionaltext as a ";
		$query.="where sma.serviceid= '$serviceid' and sma.makeid='$makeid' and sma.additionaltextid = a.additionaltextid";
		$result=db::executeQuery($query);
		$row=mysql_fetch_object($result);
		$text=$row->AdditionalText;
		return $text;
	}

	function getVehicleTotals($sfcsid){
		$query="select * from storedcalculations ";
		$query.="where (categoryitemid = 715 or categoryitemid = 716) ";
		$query.="and sfcsid ='$sfcsid' ";
		$result=db::executeQuery($query);
		$total['truck']=array();
		$total['car']=array();
		while($row=mysql_fetch_object($result)){
			if($row->TruckFlag==1){
				$total['truck'][$row->SalesYear]=$row->Total;
			}else{
				$total['car'][$row->SalesYear]=$row->Total;
			}
			$total['vehicle'][$row->SalesYear]+=$row->Total;
		}
		return $total;
	}
	function getSFCSSegmentAdditionaltext($serviceid,$segmentid){
		$query="select * from servicesegmenttext as ssa, additionaltext as a ";
		$query.="where ssa.serviceid= '$serviceid' and ssa.segmentid='$segmentid' and ssa.additionaltextid = a.additionaltextid";
		$result=db::executeQuery($query);
		$row=mysql_fetch_object($result);
		$text=$row->AdditionalText;
		return $text;
	}
	
}
class battlegroundDB{
	function getByMake($makeid,$cbgid,$start_year,$end_year){
		$query="select * from vehiclebattlegroundcycle as vbc, vehicles as v  ";
		$query.="where vbc.vehicleid = v.vehicleid and v.makeid=$makeid ";
		$query.="and v.cbgid = $cbgid  and v.ActiveFlag = '1' ";
		$query.="and vbc.LineYear >= $start_year and vbc.LineYear <= $end_year ";
		$query.="ORDER BY	v.VehicleName ASC,vbc.LineYear";
		$result=db::executeQuery($query);
		$this->cycles=array();
		while($row=mysql_fetch_object($result)){
			$this->cycles[$row->VehicleID]['id']=$row->VehicleID;
			$this->cycles[$row->VehicleID]['name']=$row->VehicleName;
			$this->cycles[$row->VehicleID][$row->LineYear]=$row->CycleText;
		}
		$query="select * from service as s, servicemaketext as smt, additionaltext as a ";
		$query.="where s.cbgid= '$cbgid' and smt.serviceid= s.serviceid and smt.makeid = '$makeid' ";
		$query.="and smt.additionaltextid=a.additionaltextid";
		$row=db::executeFetchObject($query);
		$this->text=$row->AdditionalText;
	}
	
	function getBySegment($segmentid,$cbgid,$start_year,$end_year){
		$query="select * from vehiclebattlegroundcycle as vbc, vehicles as v  ";
		$query.="where vbc.vehicleid = v.vehicleid and v.segmentid=$segmentid ";
		$query.="and v.cbgid = $cbgid   and v.ActiveFlag = '1' ";
		$query.="and vbc.LineYear >= $start_year and vbc.LineYear <= $end_year ";
		$query.="ORDER BY	v.VehicleName ASC,vbc.LineYear";
		$result=db::executeQuery($query);
		$this->cycles=array();
		while($row=mysql_fetch_object($result)){
			$this->cycles[$row->VehicleID]['id']=$row->VehicleID;
			$this->cycles[$row->VehicleID]['name']=$row->VehicleName;
			$this->cycles[$row->VehicleID][$row->LineYear]=$row->CycleText;
		}
		$query="select * from service as s, servicesegmenttext as sst, additionaltext as a ";
		$query.="where s.cbgid= '$cbgid' and sst.serviceid= s.serviceid and sst.segmentid = '$segmentid' ";
		$query.="and sst.additionaltextid=a.additionaltextid";
		$row=db::executeFetchObject($query);
		$this->text=$row->AdditionalText;
	}
	
	function getByCustomSegment($custom_segmentid,$start_year,$end_year){
		$query="select * from vehiclebattlegroundcycle as vbc, vehicles as v, customsegmentvehicles as csv  ";
		$query.="where csv.vehicleid = v.vehicleid and csv.CustomSegmentID='$custom_segmentid' ";
		$query.="and vbc.vehicleid = v.vehicleid   and v.ActiveFlag = '1' ";
		$query.="and vbc.LineYear >= '$start_year' and vbc.LineYear <= '$end_year' ";
		$query.="ORDER BY	v.VehicleName ASC,vbc.LineYear";
		$result=db::executeQuery($query);
		$this->cycles=array();
		while($row=mysql_fetch_object($result)){
			$this->cycles[$row->VehicleID]['id']=$row->VehicleID;
			$this->cycles[$row->VehicleID]['name']=$row->VehicleName;
			$this->cycles[$row->VehicleID][$row->LineYear]=$row->CycleText;
		}
	}
	function  getBattlegroundPayoff($vehicleid,$start_year,$end_year){
		$query = "SELECT * from vehiclebattlegroundcycle ";
		$query.= "where vehicleid='$vehicleid' ";
		$query.= "and LineYear >= $start_year and LineYear <= $end_year";
		$result=db::executeQuery($query);
		while($row=mysql_fetch_object($result)){
			$this->years[$row->LineYear]=$row->CycleText;
		}
		$query = "SELECT * from vehicles ";
		$query.= "where vehicleid='$vehicleid' ";
		$result=db::executeQuery($query);
		$this->vehicle_row=mysql_fetch_object($result);
		
		$query = "SELECT * from vehiclebattleground ";
		$query.= "where vehicleid='$vehicleid' ";
		$result=db::executeQuery($query);
		$this->row=mysql_fetch_object($result);
		
		$query="select * from vehiclephoto where vehicleid=$vehicleid and mainflag=1";
		$result=db::executeQuery($query);
		$this->photo_row=mysql_fetch_object($result);
		
		$this->service_row=db::fetchObjectByColumn('service','cbgid',$this->vehicle_row->cbgid);
	}
	function getBattlegroundCycleByVehicle($vehicleid){
		$query = "SELECT * from vehiclebattlegroundcycle ";
		$query.= "where vehicleid='$vehicleid'  order by LineYear ";
		$result=db::executeQuery($query);
		$this->years=array();
		while($row=mysql_fetch_object($result)){
			$this->years[]=$row;
		}
	}
	
}
class searchDB{
	function getBattleground($search){
		global $my;
		$result=subscriberDB::getServicesByUser($my->id);
		while($row=mysql_fetch_object($result)){
			if($row->cbgid){
				$set.="'$row->cbgid',";
			}
		}
		$set=rtrim($set,',');
		$query="select v.*,cbg.*,s.* from vehicles as v, vehiclebattleground as vb, ";
		$query.="cbg, service as s ";
		$query.="where v.vehicleid = vb.vehicleid and v.cbgid = cbg.cbgid and v.cbgid in ($set) and cbg.cbgid=s.cbgid ";
		$query.="and (MATCH (vb.FutureProduct)AGAINST ('$search') ";
		$query.="OR MATCH (vb.XToY)AGAINST ('$search')  ";
		$query.="OR MATCH (vb.PresentProduct)AGAINST ('$search')  ";
		$query.="OR MATCH (vb.PowertrainChassis )AGAINST ('$search')  ";
		$query.="OR MATCH (vb.History )AGAINST ('$search') ) ";
		$result=db::executeQuery($query);
		return $result;
	}

	function getSalesforecast($search){
		global $my;
		$result=subscriberDB::getServicesByUser($my->id);
		while($row=mysql_fetch_object($result)){
			if($row->sfcsid){
				$query="select * from cbg,sfcs ";
				$query.="where cbg.cbgid=sfcs.cbgid and sfcs.sfcsid = $row->sfcsid";
				$cbg_row=db::executeFetchObject($query);
				$set.="'$cbg_row->cbgid',";
			}
		}
		$set=rtrim($set,',');
		$query="select v.*,cbg.* from vehicles as v, salesforecasttext as sf, cbg ";
		$query.="where v.vehicleid = sf.vehicleid and v.cbgid = cbg.cbgid and cbg.cbgid in ($set)";
		$query.="and MATCH (sf.SFText)AGAINST ('$search') ";
		$result=db::executeQuery($query);
		return $result;
	}
}

class userDB{
	function get(){
		$query="select *, max(enddate) subscription_enddate from user as u, accesslevel as a ";
		$query.="where u.SubscriberID=a.SubscriberID group by u.subscriberid,lastName, firstName ";
		$result=db::executeQuery($query);
		return $result;
	}
}
?>