<?php
global $my;

defined('_VALID_PAGE') or die('Direct access not allowed');
if($my->admin_id==''){
	$system->error=_ERROR_NO_LOGIN;
	return;
}
global $system;
//session_start();
//require(system::getComponentPath('sfcsupload','/administration').'/sfcsupload_html.php');
//require(system::getComponentPath('eauto').'/eauto_db.php');
$path = system::getComponentPath('sfcsupload','sfcsupload_html.php');
//echo $path;
require_once($path);
require_once('includeAdmin/eauto_db.php');
$task=html::getInput($_GET,'task','upload');

switch($task){
	case 'recalculate':
		recalculate();
		break;
	case 'upload':
		sfcsupload();
		break;
}

function sfcsupload(){
	global $system,$admin_site_path,$sfcs_data_path;

	$system->sfcsupload_menu=true;
	$submit=html::getInput($_POST,'submit');
	if($submit=='Upload'){
		switch($_FILES['csv']['error']){
			case 1:
			case 2:
				$system->errors[]='File size limit exceded.';
				break;
			case 3:
				$system->errors[]='File upoad incomplete.';
				break;
			case 4:
				$system->errors[]='CSV required.';
				break;
		}
		if(!isset($system->errors)){
			if (!move_uploaded_file($_FILES['csv']['tmp_name'], $admin_site_path.$sfcs_data_path.'/'.$_FILES['csv']['name'])){
			// Failed uploading file!
						$system->errors[]='CSV upload was not succesfull.';
			}
		}
		if(!isset($system->errors)){
			if (chmod( $admin_site_path.$sfcs_data_path.'/'.$_FILES["csv"]["name"], 0777)){
			// Could not chmod the file!
	//			$result=3;
			}
		}
		if(!isset($system->errors)){
			$open_file = $admin_site_path.$sfcs_data_path.'/'.$_FILES['csv']['name'];
			$delimeter = ",";
			if (!$file_contents = implode("", file($open_file))){
			// Could not implode the file!!
				$system->errors[]='Could not implode the file.';				
			}
		}
		if(!isset($system->errors)){
			if (!$lines = preg_split("(\r\n|\r|\n)", $file_contents)){
			// Could not split the records!
				$system->errors[]='Could not split the records!';				
			}
		}
		if(!isset($system->errors)){
			$start_year=html::getInput($_POST,'start_year');
			$num_years=html::getInput($_POST,'num_years');
			$header = explode($delimeter,str_replace("\"", "",array_shift ($lines)));
			$csv_start=$header[2];
			$csv_end=$header[count($header)-1];
			if($start_year<$csv_start || $start_year > $csv_end){
				$system->errors[]='Starting year out of range';				
				// Start Year out of bounds!
			}
		}
		if(!isset($system->errors)){
			if(($start_year+$num_years-1)>$csv_end){
				$system->errors[]='Number of Years out of range';				
				// Number of Year out of bounds!
			}
		}
		$i=0;
		if(!isset($system->errors)){
			$start=$time=microtime(true);
			foreach($lines as $line){
				if ($col = explode($delimeter,str_replace("\"", "",$line))){ // break into columns
					$VehicleID = $col[0];
				}else{
				// Could not individualize columns!
				$system->errors[]='Could not individualize columns!';				
					break;			
				}
				// echo  "VehicleID: $VehicleID<br />";
				if ($VehicleID == ""){
					break;
				}

				$values = array();
				for ($year = $start_year; $year < ($start_year + $num_years); $year++){
					$column = (2 + ($year - $csv_start));
					$values[$year] = $col[$column];
				}
				// bodystyle
				$BodyStyle = $col[1];
				$bodystyle_row=db::fetchObjectByColumn('bodystyle','abbrev',$BodyStyle);
				if(!$bodystyle_row){
					db::insert('bodystyle',array('abbrev'=>$BodyStyle));
					$bodystyleid=mysql_insert_id();
					db::insert('vehiclebodystyle',array('vehicleid'=>$VehicleID,'bodystyleid'=>$bodystyleid));
					$bodystyle_row=db::fetchObjectByColumn('bodystyle','abbrev',$BodyStyle);
				}
				for ($year = $start_year; $year < ($start_year + $num_years); $year++){
					$sales_row=db::fetchObjectByColumns('salesforecast',
						array('VehicleID'=>$VehicleID,
							'bodystyleid'=>$bodystyle_row->bodystyleid,
							'SalesYear'=>$year)
						);
					if($sales_row){
						db::updateByColumn('salesforecast','SFID',$sales_row->SFID,array('SalesValue'=>$values[$year]));
					}else{
						db::insert('salesforecast',
						array('VehicleID'=>$VehicleID,
							'bodystyleid'=>$bodystyle_row->bodystyleid,
							'SalesYear'=>$year,
							'SalesValue'=>$values[$year])
						);
					}
				}
			}									
		}
		if(!isset($system->errors)){
			$system->messages[]='File successfully uploaded.';
			calculate_sfs_totals($start_year,$num_years);
		}
	}
	sfcsuploadHTML::edit();
}

function recalculate(){
	global $system;
	
	$system->sfcsupload_menu=true;
	$op=html::getInput($_POST,'op');
	if($op=='recalc'||$op=='csv'){
		$start_year=html::getInput($_POST,'start_year');
		$num_years=html::getInput($_POST,'num_years');
		calculate_sfs_totals($start_year,$num_years);
		$system->messages[]='Recalculation successful';
	}
	sfcsuploadHTML::recalculate();
}
function calculate_sfs_totals($start_year,$num_years){
	$op=html::getInput($_POST,'op');
	$query="select *, cbg.name as cbg_name, sfcs.name as sfcs_name ";
	$query.="from sfcs, cbg ";
	$query.="where sfcs.cbgid = cbg.cbgid ";
	$result= db::executeQuery($query);
	while ($row = mysql_fetch_object($result)){
		$sfcss[$row->sfcsid]['row']=$row;
	}
	$num_years-=1;
	foreach($sfcss as $sfcsid => $sfcs){
		$cbgid=$sfcs['row']->cbgid;
		$trucks=array();
		$cars=array();
		$query = " SELECT s.SalesYear, v.TruckFlag, SUM(s.SalesValue) as Total ";
		$query .= "FROM Vehicles as v, SalesForecast as s ";
		$query .= "WHERE (v.ActiveFlag = '1' and v.sfcsactive = '1' AND v.DeleteFlag = '0') ";
		$query .= "AND v.VehicleID = s.VehicleID ";
		$query .= "AND s.SalesYear BETWEEN '$start_year' and '".($start_year+$num_years)."' ";
		$query .= "AND	v.cbgid = '$cbgid' ";
		$query .= "GROUP BY s.SalesYear, v.truckflag ";
		$result= db::executeQuery($query);
		while ($row = mysql_fetch_object($result)){
			$CategoryItemID = $row->TruckFlag==0?715:716;
			$where = "WHERE TruckFlag = '$row->TruckFlag' ";
			$where .= "AND SalesYear = '$row->SalesYear'  ";
			$where .= "AND CategoryItemID = '$CategoryItemID'  ";
			$where .= "AND sfcsid = '$sfcsid'  ";
			$query = "select * from StoredCalculations ";
			$query.= $where;
			$search_result=db::executeQuery($query);
			$totals[$row->SalesYear][$row->TruckFlag]=$row->Total;
			if(mysql_num_rows($search_result) > 0){
				$query = "UPDATE StoredCalculations ";
				$query .="SET Total = '$row->Total' ";
				$query .= $where;
			} else{
				$query ="INSERT StoredCalculations ";
				$query .="set Total = '$row->Total', ";
				$query .="SalesYear = '$row->SalesYear', ";
				$query .="sfcsid = '$sfcsid', ";
				$query .="TruckFlag = '$row->TruckFlag', ";
				$query .= "CategoryItemID = '$CategoryItemID'  ";
			}
			db::executeQuery($query);
		}
	}

	if($op=='recalc'||$op==''){
		return;
	}
	$query="select s.vehicleid, b.abbrev, s.bodystyleid, s.SalesYear, s.SalesValue, v.TruckFlag ";
	$query.="FROM			Vehicles as v , SalesForecast as s, bodystyle as b ";
	$query.="WHERE			(v.ActiveFlag = '1'  and Vehicles.sfcsactive = '1' AND v.DeleteFlag = '0') ";
	$query.="AND v.VehicleID = s.VehicleID and s.bodystyleid= b.bodystyleid ";
	$query.="AND				s.SalesYear BETWEEN '$start_year' and '".($start_year+$num_years)."' ";
	$query.="order by 			s.vehicleid asc ";
	$result= db::executeQuery($query);
	while($row = mysql_fetch_object($result)){
		if($row->TruckFlag){
			$trucks[$row->vehicleid][$row->abbrev][$row->SalesYear]=$row;
		}else{
			$cars[$row->vehicleid][$row->abbrev][$row->SalesYear]=$row;
		}
	}
		header("Content-Type: application/csv");
		header("Content-Disposition: attachment; filename=Totals.csv"); 
	$csv_line.=csvField('ID');
	$csv_line.=csvField('Body');
	for($year=$start_year;$year<=$start_year+$num_years;$year++){
		$csv_line.=csvField($year);
	}
	$csv_line=rtrim($csv_line,',');
	echo  $csv_line;
?>

<?php
	foreach($trucks as $vehicleid => $bodys){
		foreach($bodys as $body => $rows){
			$csv_line='';
			$csv_line.=csvField($vehicleid);
			$csv_line.=csvField($body);
			for($year=$start_year;$year<=$start_year+$num_years;$year++){
				$csv_line.=csvField($rows[$year]->SalesValue);
			}
			$csv_line=rtrim($csv_line,',');
			echo  $csv_line;
?>

<?php
		}
	}
		$csv_line='';
		$csv_line.=csvField('Total');
		$csv_line.=csvField('');
		for($year=$start_year;$year<=$start_year+$num_years;$year++){
			$csv_line.=csvField($totals[$year][1]);
		}
		$csv_line=rtrim($csv_line,',');
		echo  $csv_line;
?>


<?php

	foreach($cars as $vehicleid => $bodys){
		foreach($bodys as $body => $rows){
			$csv_line='';
			$csv_line.=csvField($vehicleid);
			$csv_line.=csvField($body);
			for($year=$start_year;$year<=$start_year+$num_years;$year++){
				$csv_line.=csvField($rows[$year]->SalesValue);
			}
			$csv_line=rtrim($csv_line,',');
			echo  $csv_line;
?>

<?php
		}
	}
		$csv_line='';
		$csv_line.=csvField('Total');
		$csv_line.=csvField('');
		for($year=$start_year;$year<=$start_year+$num_years;$year++){
			$csv_line.=csvField($totals[$year][0]);
		}
		$csv_line=rtrim($csv_line,',');
		echo  $csv_line;
	
		exit;

//	print_r($trucks);
//	print_r($cars);
}
	function csvField($value){
		return "\"$value\",";
	}

?>