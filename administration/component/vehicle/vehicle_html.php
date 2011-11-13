<?php
//ini_set('display_errors','On');
	
class vehicleHtml{

	function search(){
		global $system;
			
		$result=db::getResult('cbg');
		$cbgid=html::getInput($_REQUEST,'cbgid','');
		
		$make=html::getInput($_REQUEST,'make','');
		if($make!='reset'){
			$makeid=html::getInput($_REQUEST,'makeid','');
		}
		$task=html::getInput($_GET,'task');
		if($cbgid==''){
			$make_submit="disabled";
		}else{
			$make_submit=' onChange="this.form.submit()"';
			$make_result=eautoDB::getAdminMakesByCBG($cbgid);
			$cbg_row=db::fetchObject('cbg',$cbgid);
		}
		if($makeid!=''){
			$make_row=db::fetchObject('make',$makeid);
			$vehicle_result=eautoDB::getVehiclesByMakeAndBattleground($makeid,$cbgid);
		}
		if($cbgid==''&&$makeid==''){
			$message='Select a Competitive Battleground.';
			$system->breadcrumbs['Vehicle List']='';
		}else if($makeid==''||!mysql_num_rows($make_result)){
			$system->breadcrumbs['Vehicle List']='index.php?comp=vehicle';
			$system->breadcrumbs[$cbg_row->name]="index.php?comp=vehicle&task=vehicles";
			$message='Select a Make.';
		}else{
			$system->breadcrumbs['Vehicle List']='index.php?comp=vehicle';
			$system->breadcrumbs[$cbg_row->name]="index.php?comp=vehicle&task=vehicles&cbgid=$cbgid";
			$system->breadcrumbs["$make_row->name"]='';
		}
		
?>

<br />

<form action="index.php?comp=vehicle&task=vehicles" method="POST">
	<input type="hidden" name="make" />
<table style="margin-left:50px;width:500px;" cellpadding="0">
	<tr><td class="header" >Vehicle List</td></tr>
	<tr ><td class="greySpacerLine" ></td></tr>
	<tr align="left">
		<td align="left">
			<select name="cbgid" onChange="this.form.make.value='reset';this.form.submit()">
				<option value="">Select a Competitive Battleground</option>
				<?php  while ($row = mysql_fetch_object($result)) {
					$selected=($row->cbgid==$cbgid)?'selected="selected"':"";
				?>
				<option value="<?php  echo $row->cbgid; ?>" <?php  echo $selected; ?>><?php  echo $row->name; ?></option>
				<?php  }
				?>
			</select>
			<select name="makeid" <?php  echo $make_submit; ?>>
				<option selected value="">Select a Make</option>
				<?php  while ($row = mysql_fetch_object($make_result)) {
						$selected='';
					if($row->makeid==$makeid){
						$selected='selected="selected"';
						$name=$row->name;
					}
				?>
				<option value="<?php  echo $row->makeid; ?>"<?php  echo $selected; ?>><?php  echo $row->name; ?></option>
				<?php  }
				?>
			</select>
		</td>
	</tr>
	<tr><td class="red" ><?php echo $message; ?><span class="strong"></span></td></tr>
	<tr ><td class="greySpacerLine" ></td></tr>
</table>
</form>

<?php  
if(!isset($vehicle_result))
return;
?>
<table cellspacing="3" cellpadding="0" style="margin-left:50px;width:500px;">
	<tr>
	<td >New <?php  echo $name; ?></td>
	<td width="46" height="24">
		<a href="index.php?comp=vehicle&task=editbattleground&cbgid=<?php echo $cbgid; ?>&makeid=<?php echo $makeid; ?>" >
			<img src="media/images/add.jpg" border="0"/> </a>
	</td>
	<td width="60" height="24"><img src="media/images/spacer.gif" border="0" width="60" height="24" /></td>
	</tr>
	<?php 	while ($row = mysql_fetch_object($vehicle_result)){ ?>
	<tr ><td class="greySpacerLine"  colspan="3"></td></tr>
	<tr>
		<td>
			<?php  echo "($row->VehicleID) $row->VehicleName"; ?>
		</td>
		<td width="45" height="24">
			<a class="blackText" href="index.php?comp=vehicle&task=vehicle&vehicleid=<?php echo $row->VehicleID; ?>&cbgid=<?php echo $cbgid; ?>&makeid=<?php echo $makeid; ?>">
				<img src="media/images/edit.jpg" border="0" /></a>
		</td>
		<td width="60" height="24">
			<a class="blackText" href="index.php?comp=vehicle&task=vehicles&action=delete&vehicleid=<?php echo $row->VehicleID; ?>&cbgid=<?php echo $cbgid; ?>&makeid=<?php echo $makeid; ?>">
				<img src="media/images/delete.jpg" border="0" /></a>
		</td>
	</tr>
	<?php  
	}
	?>

	<tr ><td class="greySpacerLine"  colspan="3"></td></tr>
</table>
	<br /><br />
<?php
		}
//
//
//  View
//
//
//
		function edit($vehicleid,$VehicleFileID=0,$fileCaption='',$errorlist=''){
			global $system,$live_site,$images_path;
						
			$row=db::fetchObjectByColumn('matrixprefs','PrefName','BegYear');
			$default_start_year=$row->PrefValue;
			$start_year=html::getInput($_GET,'sy',$default_start_year);
			$end_year=$start_year+7;
			$row=db::fetchObjectByColumn('matrixprefs','PrefName','YearIncrement');
			$year_change=$row->PrefValue;
			
			$eautoDB= new eautoDB;
			vehicleHTML::breadcrumbs($vehicleid);
			$cbgid=html::getInput($_GET,'cbgid');
			
			$makeid=html::getInput($_GET,'makeid');
			$vehicle_row=eautoDB::getVehicle($vehicleid);

			if($vehicle_row->ActiveFlag == 1){ 
				$active_checked = 'checked';
				$active_onclick= "if(validateInactive())window.location.assign('index.php?comp=vehicle&task=vehicle&vehicleid=$vehicleid&cbgid=$cbgid&makeid=$makeid&action=active&v=0');";
			}else{
				$active_onclick= "window.location.assign('index.php?comp=vehicle&task=vehicle&vehicleid=$vehicleid&cbgid=$cbgid&makeid=$makeid&action=active&v=1');";
			}
			if($vehicle_row->sfcsactive == 1){ 
				$sfcsactive_checked = 'checked';
				$sfcsactive_onclick= "if(validateInactiveSfcs())window.location.assign('index.php?comp=vehicle&task=vehicle&vehicleid=$vehicleid&cbgid=$cbgid&makeid=$makeid&action=sfcsactive&v=0');";
			}else{
				$sfcsactive_onclick= "window.location.assign('index.php?comp=vehicle&task=vehicle&vehicleid=$vehicleid&cbgid=$cbgid&makeid=$makeid&action=sfcsactive&v=1');";
			}
			$main_photo_row=db::fetchObjectByColumn('vehiclephoto','vehicleid',$vehicleid,' and MainFlag=1');
			$content=eautoDB::getContent($vehicleid);
			$battlegroundDB= new battlegroundDB;
			$battlegroundDB->getBattlegroundPayoff($vehicleid,$start_year,$end_year);
			$result=eautoDB::getBodystylesByVehicle($vehicleid);
			while($row=mysql_fetch_object($result)) {  
				$bodystyles.= ' '.$row->abbrev.',';
			}
			$bodystyles=rtrim($bodystyles,',');

			$result=db::getRelationResult('vehicle','division',$vehicleid);
			$row=mysql_fetch_object($result);
			$division=$row->name;
			
			$result=db::getRelationResult('vehicle','drive',$vehicleid);
			while($row=mysql_fetch_object($result)) {  
				$drives.= ' '.$row->name.',';
			}
			$drives=rtrim($drives,',');

			$result=db::getRelationResult('vehicle','seat',$vehicleid);
			while($row=mysql_fetch_object($result)) {  
				$seats.= ' '.$row->seats.',';
			}
			$seats=rtrim($seats,',');

			$result=db::getRelationResult('vehicle','transmission',$vehicleid);
			while($row=mysql_fetch_object($result)) {  
				$transmissions.= ' '.$row->abbrev.',';
			}
			$transmissions=rtrim($transmissions,',');

			$segment=eautoDB::getVehicleSegment($vehicleid);
			
			$vehicleDB = new vehicleDB;
			$vehicleDB->getAdminDimensions($vehicleid);
			
			$startofproduction_result=
				db::getResultByColumn('vehiclestartofproduction','vehicleid',$vehicleid);
			$saleslaunch_result=
				db::getResultByColumn('vehiclesaleslaunch','vehicleid',$vehicleid);
			$curbweightrange_result=
				db::getResultByColumn('vehiclecurbweightrange','vehicleid',$vehicleid);
			$tiresize_result=
				db::getResultByColumn('vehicletiresize','vehicleid',$vehicleid);
			$engine_result=
				db::getResultByColumn('vehicleengine','vehicleid',$vehicleid,' and DeleteFlag=0 ');
			$suspension_result=
				db::getResultByColumn('vehiclesuspension','vehicleid',$vehicleid);
			$pricerange_result=
				db::getResultByColumn('vehiclepricerange','vehicleid',$vehicleid);
				
				
			$demographic_row=
				db::fetchObjectByColumn('vehicledemographic','vehicleid',$vehicleid);
			$age_checked=
				vehicleHTML::getDemographicChecked($demographic_row->Age);
			$maritalstatus_checked=
				vehicleHTML::getDemographicChecked($demographic_row->MaritalStatus);
			$collegeeducation_checked=
				vehicleHTML::getDemographicChecked($demographic_row->CollegeEducation);
			$income_checked=
				vehicleHTML::getDemographicChecked($demographic_row->Income);
			$brandloyalty_checked=
				vehicleHTML::getDemographicChecked($demographic_row->BrandLoyalty);
			$secondvehicle_checked=
				vehicleHTML::getDemographicChecked($demographic_row->SecondChoiceVehicle);
			$previousvehicle_checked=
				vehicleHTML::getDemographicChecked($demographic_row->PreviousVehicle);
			$futuresegment_checked=
				vehicleHTML::getDemographicChecked($demographic_row->FutureSegment);
			$pricepaid_checked=
				vehicleHTML::getDemographicChecked($demographic_row->PricePaid);
				
			$pressreleases_result=db::getResultByColumn('content','vehicleid',$vehicleid,'and DeleteFlag=0 order by PublishDate desc');
			
	// Competitive Battleground
?>
<script language="javascript">

	function validateInactive()
	{
			if (document.getElementById('cbg_active_checkbox').checked==false){
				if(confirm('STOP.\n You should only inactivate vehicles that were NEVER PRODUCED.\n Production vehicle remain active forever.\n Push CANCEL to stop or OK to inactivate.')){
					if(confirm('Are you REALLY sure?!?')){
						return true;
					}
					else{
						document.getElementById('cbg_active_checkbox').checked=true
					 return false;
					}
				} else
				{
					document.getElementById('cbg_active_checkbox').checked=true
					return false;
				}
			}
	}
	function validateInactiveSfcs()
	{
			if (document.getElementById('sfcs_active_checkbox').checked==false){
				if(confirm('STOP.\n You should only inactivate vehicles that were NEVER PRODUCED.\n Production vehicle remain active forever.\n Push CANCEL to stop or OK to inactivate.')){
					if(confirm('Are you REALLY sure?!?')){
						return true;
					}
					else{
						document.getElementById('sfcs_active_checkbox').checked=true
					 return false;
					}
				} else
				{
					document.getElementById('sfcs_active_checkbox').checked=true
					return false;
				}
			}
	}

</script>

<br	/>
<?php
setcookie("vehicleID",'');
setcookie("vehicleID",$vehicleid);
setcookie("cbgid",'');
setcookie("cbgid",$cbgid);
setcookie("makeid",'');
setcookie("makeid",$makeid);

require_once($system->site_path.'/component/vehicle/vehicleText.php');
?>
<table style="margin-left:50px;width:700px;" cellpadding="0">
	<tr><td class="header" colspan="2">Competitive Battleground</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td align="right">Vehicle Name:</td><td><?php  echo $vehicle_row->VehicleName; ?></td>
		<td align="right">Active:</td>
		<td>
			<input id="cbg_active_checkbox"onclick="<?php  echo $active_onclick; ?>" type="checkbox" name="ActiveFlag" <?php  echo $active_checked; ?> />
		</td>
		<td align="right">
			<a href="index.php?comp=vehicle&task=vehicles&cbgid=<?php echo $cbgid; ?>&makeid=<?php echo $makeid; ?>">
				<img src="media/images/cancel.jpg" border="0" /></a> 
			<a href="index.php?comp=vehicle&task=editbattleground&vehicleid=<?php echo $vehicleid; ?>">
				<img src="media/images/edit.jpg" border="0" /></a> 
		</td>
	</tr>
	<tr>
		<td align="right">Current Code Name:</td><td><?php  echo $vehicle_row->CurrentCodeName; ?></td>
		<td align="right">Future Code Name:</td><td colspan="2"><?php  echo $vehicle_row->FutureCodeName; ?></td>
	</tr>
	<tr><td class="greySpacerLine"colspan="10"></td></tr>
</table>
<br />
<table cellspacing="0" cellpadding="0" style="width:700px;margin-left:50px;">
	<tr>
		<td colspan="3" align="left">
		<a href="<?php  echo $_SERVER['REQUEST_URI']; ?>&sy=<?php echo $start_year-$year_change;?>"><img src="media/images/cartoonLeft.jpg" border="0" /></a>
		</td>
		<td colspan="4" align="right">
		<a href="<?php  echo $_SERVER['REQUEST_URI']?>&sy=<?php echo $start_year+$year_change; ?>"><img src="media/images/cartoonRight.jpg" border="0" /></a>
		</td>
	</tr>
	<tr>
		<?php for ($year = $start_year; $year < ($start_year+7); $year++) {
		?>
			<td align="center" style="background-image:url(media/images/cartoonHeaderBG.jpg);border: 1px solid #7B7F83;height:19px;font-weight:bold;">&nbsp;<?php  echo $year; ?>&nbsp;</td>
		<?php
		}
		?>
	</tr>
	<tr>
		<?php for ($year = $start_year; $year < ($start_year+7); $year++) {
		?>
			<?php  $text= $battlegroundDB->years[$year] == '' ? '&nbsp;' : $battlegroundDB->years[$year]; 
			?>
			<td align="center" style="background-color:#D6D6D6;border: 1px solid #7B7F83; height:75px;"><?php  echo $text; ?></td>
		<?php 
		}
		?>
	<tr>
</table>

<br />
<div style="width:700px;margin-left:50px;text-align:right">
	<a  href="index.php?comp=vehicle&task=listbattlegroundcycle&vehicleid=<?php echo $vehicleid; ?>">
		<img src="media/images/list.jpg" border="0"/></a>
</div>
<br />
<table style="margin-left:50px;width:700px;" cellpadding="0">
	<tr><td class="header" colspan="2">Sales Forecast</td></tr>
	<tr><td class="greySpacerLine"colspan="10"></td></tr>
	<tr>
		<td>
			<?php if($vehicle_row->ActiveFlag == 1){ 
			?>
			Active: <input  id="sfcs_active_checkbox" onclick="<?php  echo $sfcsactive_onclick; ?>" type="checkbox" <?php  echo $sfcsactive_checked; ?> />
			<?php 
			}else{
			?>
			&nbsp;
			<?php
			}
			?>
		</td>
		<td align="right">
			<a href="index.php?comp=vehicle&task=editsalesforecast&vehicleid=<?php echo $vehicleid; ?>" >
				<img src="media/images/edit.jpg" border="0"/></a>
		</td>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
<br />
<table style="margin-left:50px;width:700px;" cellpadding="0">
	<tr><td colspan="2">Photos</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td align="left">
			<?php if ($main_photo_row){

			?>
			<img src="<?php echo $images_path; ?>upload_photos/<?php echo $main_photo_row->SmallFileName; ?>" border="0" />
			<?php
			} else{
			?>
			No Main Photo (thumbnail)
			<?php
			}
			?>
		</td>
		<td align="right" valign="center">
			<a href="index.php?comp=vehicle&task=addphoto&vehicleid=<?php echo $vehicleid; ?>">
				<img src="media/images/add.jpg"  border="0"/></a>
			<a href="index.php?comp=vehicle&task=viewphotos&vehicleid=<?php echo $vehicleid; ?>">
				<img src="media/images/view.jpg"  border="0"/></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
	<br /><br />
<a name="attribute"></a>
<table style="margin-left:50px;width:400px;" cellpadding="0">
	<tr><td colspan="2"class="strong">Attributes:</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td style="width:100px;" >Bodystyle</td>
		<td style="width:300px;" >
			<?php echo $bodystyles;?>
		</td>
		<td align="right"><a href="index.php?comp=vehicle&task=editattribute&name=bodystyle&vehicleid=<?php echo $vehicleid; ?>">
			<img src="media/images/edit.jpg" border="0"/></a>	
		</td>
	</tr>
	<tr><td colspan="3" class="greySpacerLine" ></td></tr>
	<tr>
		<td>Division</td>
		<td><?php echo $division; ?></td>
		<td align="right"><a href="index.php?comp=vehicle&task=editdivision&vehicleid=<?php echo $vehicleid; ?>">
			<img src="media/images/edit.jpg" border="0"/></a>	
	</tr>
	<tr><td colspan="3" class="greySpacerLine" ></td></tr>
	<tr>
		<td>Drive Configuration</td>
		<td><?php echo $drives; ?></td>
		<td align="right"><a href="index.php?comp=vehicle&task=editattribute&name=drive&vehicleid=<?php echo $vehicleid; ?>">
			<img src="media/images/edit.jpg" border="0"/></a>	
		</td>
	</tr>
	<tr><td colspan="3" class="greySpacerLine" ></td></tr>
	<tr>
		<td>Seating Capacity</td>
		<td><?php echo $seats; ?></td>
		<td align="right"><a href="index.php?comp=vehicle&task=editattribute&name=seat&vehicleid=<?php echo $vehicleid; ?>">
			<img src="media/images/edit.jpg" border="0"/></a>	
		</td>
	</tr>
	<tr><td colspan="3" class="greySpacerLine" ></td></tr>
	<tr>
		<td>Transmission</td>
		<td><?php echo $transmissions; ?></td>
		<td align="right"><a href="index.php?comp=vehicle&task=editattribute&name=transmission&vehicleid=<?php echo $vehicleid; ?>">
			<img src="media/images/edit.jpg" border="0"/></a>	
		</td>
	</tr>
	<tr><td colspan="3" class="greySpacerLine" ></td></tr>
	<tr>
		<td>Segment</td>
		<td><?php echo $segment; ?></td>
		<td align="right"><a href="index.php?comp=vehicle&task=editsegment&vehicleid=<?php echo $vehicleid; ?>">
			<img src="media/images/edit.jpg" border="0"/></a>	
		</td>
	</tr>
	<tr><td colspan="3" class="greySpacerLine" ></td></tr>
	</table>
	<br /><br />


<form action="index.php?comp=vehicle&task=editvariation&vehicleid=<?php echo $vehicleid; ?>" method="post">
	<input type="hidden" name="submit" value="variation" />
<table style="margin-left:50px;width:710px;" cellpadding="0" cellspacing="3">
	<tr><td colspan="2"class="strong"><a name="dimension">Vehicle Dimensions:</a></td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td align="left">Variation Name:</td>
		<td align="left">Life Cycle:</td>
		<td align="left">WB:</td>
		<td align="left">OAL:</td>
		<td align="left">OAW:</td>
		<td align="left">OAH:</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><input type="text" name="VariationName" /></td>
		<td><input type="text" name="PlannedLifeCycle" size="10"/></td>
		<td><input type="text" name="WB" size="10"/></td>
		<td><input type="text" name="OAL"  size="10"/></td>
		<td><input type="text" name="OAW"  size="10"/></td>
		<td><input type="text" name="OAH"  size="10"/></td>
		<td align="left">
			<input type="image" src="media/images/add.jpg" border="0"/>
	</tr>
	<?php foreach($vehicleDB->dimensions as $id=>$dimension){
	?>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td><?php  echo $dimension['VariationName']; ?></td>
		<td><?php  echo $dimension['PlannedLifeCycle']; ?></td>
		<td><?php  echo $dimension['WB']; ?></td>
		<td><?php  echo $dimension['OAL']; ?></td>
		<td><?php  echo $dimension['OAW']; ?></td>
		<td><?php  echo $dimension['OAH']; ?></td>
		<td align="left">
			<a href="index.php?comp=vehicle&task=editvariation&id=<?php  echo $id;?>&vehicleid=<?php echo $vehicleid; ?>">
		 		<img src="media/images/edit.jpg" border="0"/></a>	
			<a href="index.php?comp=vehicle&task=vehicle&action=deletevariation&id=<?php  echo $id;?>&vehicleid=<?php echo $vehicleid; ?>#dimension">
				<img src="media/images/delete.jpg" border="0"/></a>	
		</td>
	</tr>
	<?php
	}
	?>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
</table>
</form>
	<br />
	<br />
<form action="index.php?comp=vehicle&task=editstartofp&vehicleid=<?php echo $vehicleid; ?>" method="post">
	<input type="hidden" name="submit" value="dimension" />
<table style="margin-left:50px;width:600px;" cellpadding="0" >
	<tr><td colspan="2"class="strong">Start Of Production:</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>Start Of Production:<input type="text" name="StartOfProduction" size="50" /></td>
		<td align="left">			
			<input type="image" src="media/images/add.jpg" border="0"/>
		</td>
	</tr>
	<?php while($row=mysql_fetch_object($startofproduction_result)){
	?>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	<tr>
		<td><?php  echo $row->StartOfProduction; ?></td>
		<td>
			<a href="index.php?comp=vehicle&task=editstartofp&id=<?php  echo $row->VehicleStartOfProductionID;?>&vehicleid=<?php echo $vehicleid; ?>">
		 		<img src="media/images/edit.jpg" border="0"/></a>	
			<a href="index.php?comp=vehicle&task=vehicle&action=deletestartofp&id=<?php  echo $row->VehicleStartOfProductionID;?>&vehicleid=<?php echo $vehicleid; ?>#dimension">
				<img src="media/images/delete.jpg" border="0"/></a>	
		</td>
	</tr>
	<?php
	}
	?>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
</form>
	<br />
	<br />
<form action="index.php?comp=vehicle&task=editsaleslaunch&vehicleid=<?php echo $vehicleid; ?>" method="post">
	<input type="hidden" name="submit" value="dimension" />
<table style="margin-left:50px;width:600px;" cellpadding="0" >
	<tr><td colspan="2"class="strong">Sales Launch:</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>Sales Launch:<input type="text" name="SalesLaunch" size="50" /></td>
		<td align="left">
			<input type="image" src="media/images/add.jpg" border="0"/>
		</td>
	</tr>
	<?php while($row=mysql_fetch_object($saleslaunch_result)){
	?>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	<tr>
		<td><?php  echo $row->SalesLaunch; ?></td>
		<td>
			<a href="index.php?comp=vehicle&task=editsaleslaunch&id=<?php  echo $row->VehicleSalesLaunchID;?>&vehicleid=<?php echo $vehicleid; ?>">
		 		<img src="media/images/edit.jpg" border="0"/></a>	
			<a href="index.php?comp=vehicle&task=vehicle&action=deletesaleslaunch&id=<?php  echo $row->VehicleSalesLaunchID;?>&vehicleid=<?php echo $vehicleid; ?>#dimension">
				<img src="media/images/delete.jpg" border="0"/></a>	
		</td>
	</tr>
	<?php
	}
	?>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
</form>
	<br />
	<br />
<form action="index.php?comp=vehicle&task=editcurbweight&vehicleid=<?php echo $vehicleid; ?>" method="post">
	<input type="hidden" name="submit" value="dimension" />
<table style="margin-left:50px;width:600px;" cellpadding="0" >
	<tr><td colspan="2"class="strong">Curb Weight Range:</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>Curb Weight Range:<input type="text" name="CurbWeightRange" size="50" /></td>
		<td align="left">			
			<input type="image" src="media/images/add.jpg" border="0"/>
		</td>
	</tr>
	<?php while($row=mysql_fetch_object($curbweightrange_result)){
	?>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	<tr>
		<td><?php  echo $row->CurbWeightRange; ?></td>
		<td>
			<a href="index.php?comp=vehicle&task=editcurbweight&id=<?php  echo $row->VehicleCurbWeightRangeID;?>&vehicleid=<?php echo $vehicleid; ?>">
		 		<img src="media/images/edit.jpg" border="0"/></a>	
			<a href="index.php?comp=vehicle&task=vehicle&action=deletecurbweight&id=<?php  echo $row->VehicleCurbWeightRangeID;?>&vehicleid=<?php echo $vehicleid; ?>#dimension">
				<img src="media/images/delete.jpg" border="0"/></a>	
		</td>
	</tr>
	<?php 
	}
	?>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
</form>
	<br />
	<br />
<form action="index.php?comp=vehicle&task=edittiresize&vehicleid=<?php echo $vehicleid; ?>" method="post">
	<input type="hidden" name="submit" value="dimension" />
<table style="margin-left:50px;width:600px;" cellpadding="0" >
	<tr><td colspan="2"class="strong">Tire Sizes:</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>Size:<input type="text" name="TireSize" size="50" /></td>
		<td align="left">			
			<input type="image" src="media/images/add.jpg" border="0"/>
		</td>
	</tr>
	<?php while($row=mysql_fetch_object($tiresize_result)){
	?>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	<tr>
		<td><?php  echo $row->TireSize; ?></td>
		<td>
			<a href="index.php?comp=vehicle&task=edittiresize&id=<?php  echo $row->VehicleTireSizeID;?>&vehicleid=<?php echo $vehicleid; ?>">
		 		<img src="media/images/edit.jpg" border="0"/></a>	
			<a href="index.php?comp=vehicle&task=vehicle&action=deletetiresize&id=<?php  echo $row->VehicleTireSizeID;?>&vehicleid=<?php echo $vehicleid; ?>#dimension">
				<img src="media/images/delete.jpg" border="0"/></a>	
		</td>
	</tr>
	<?php 
	}
	?>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
</form>
	<br />
	<br />
<form action="index.php?comp=vehicle&task=editengine&vehicleid=<?php echo $vehicleid; ?>" method="post">
	<input type="hidden" name="submit" value="dimension" />
<table style="margin-left:50px;width:600px;" cellpadding="0" >
	<tr><td colspan="2"class="strong">Engine:</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>Engine:<input type="text" name="Engine" size="50" /></td>
		<td align="left">			
			<input type="image" src="media/images/add.jpg" border="0"/>
		</td>
	</tr>
	<?php while($row=mysql_fetch_object($engine_result)){
	?>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	<tr>
		<td><?php  echo $row->Engine; ?></td>
		<td>
			<a href="index.php?comp=vehicle&task=editengine&id=<?php  echo $row->VehicleEngineID;?>&vehicleid=<?php echo $vehicleid; ?>">
		 		<img src="media/images/edit.jpg" border="0"/></a>	
			<a href="index.php?comp=vehicle&task=vehicle&action=deleteengine&id=<?php  echo $row->VehicleEngineID;?>&vehicleid=<?php echo $vehicleid; ?>#dimension">
				<img src="media/images/delete.jpg" border="0"/></a>	
		</td>
	</tr>
	<?php 
	}
	?>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
</form>
	<br />
	<br />
<form action="index.php?comp=vehicle&task=editsuspension&vehicleid=<?php echo $vehicleid; ?>" method="post">
	<input type="hidden" name="submit" value="dimension" />
<table style="margin-left:50px;width:600px;" cellpadding="0" >
	<tr><td colspan="2"class="strong">Suspension:</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>Front:<input type="text" name="FrontSuspension" size="25" /></td>
		<td>Rear:<input type="text" name="RearSuspension" size="25" /></td>
		<td align="left">			
			<input type="image" src="media/images/add.jpg" border="0"/>
		</td>
	</tr>
	<?php while($row=mysql_fetch_object($suspension_result)){
	?>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	<tr>
		<td>Front:<?php  echo $row->FrontSuspension; ?></td>
		<td>Rear:<?php  echo $row->RearSuspension; ?></td>
		<td>
			<a href="index.php?comp=vehicle&task=editsuspension&id=<?php  echo $row->VehicleSuspensionID;?>&vehicleid=<?php echo $vehicleid; ?>">
		 		<img src="media/images/edit.jpg" border="0"/></a>	
			<a href="index.php?comp=vehicle&task=vehicle&action=deletesuspension&id=<?php  echo $row->VehicleSuspensionID;?>&vehicleid=<?php echo $vehicleid; ?>#dimension">
				<img src="media/images/delete.jpg" border="0"/></a>	
		</td>
	</tr>
	<?php 
	}
	?>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
</form>
	<br />
	<br />

<form action="index.php?comp=vehicle&task=editprice&vehicleid=<?php echo $vehicleid; ?>" method="post">
	<input type="hidden" name="submit" value="dimension" />
<table style="margin-left:50px;width:600px;" cellpadding="0" >
	<tr><td colspan="2"class="strong">Price Range:</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>Low:<input type="text" name="Low" size="25" /></td>
		<td>High:<input type="text" name="High" size="25" /></td>
		<td align="left">			
			<input type="image" src="media/images/add.jpg" border="0"/>
		</td>
	</tr>
	<?php while($row=mysql_fetch_object($pricerange_result)){
	?>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	<tr>
		<td>Low:<?php  echo $row->Low; ?> </td>
		<td>High:<?php  echo $row->High; ?> </td>
		<td>
			<a href="index.php?comp=vehicle&task=editprice&id=<?php  echo $row->VehiclePriceRangeID;?>&vehicleid=<?php echo $vehicleid; ?>">
		 		<img src="media/images/edit.jpg" border="0"/></a>	
			<a href="index.php?comp=vehicle&task=vehicle&action=deleteprice&id=<?php  echo $row->VehiclePriceRangeID;?>&vehicleid=<?php echo $vehicleid; ?>#dimension">
				<img src="media/images/delete.jpg" border="0"/></a>	
		</td>
	</tr>
	<?php 
	}
	?>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
</form>
	<br /><br />
	
<form action="index.php?comp=vehicle&task=vehicle&vehicleid=<?php echo $vehicleid; ?>" method="post">
	<input type="hidden" name="submit" value="demographic" />
<table style="margin-left:50px;" cellpadding="0">
	<tr><td colspan="2"class="strong"><a name="demographic">Demographics</a> (choose 3 to 5)</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td><input type="checkbox" name="AgeCheck" <?php  echo $age_checked; ?> /></td>
		<td>Age:</td>
		<td><input type="text" name="Age" value="<?php  echo $demographic_row->Age; ?>" /> (Years)</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="MaritalStatusCheck" <?php  echo $maritalstatus_checked; ?> /></td>
		<td>Marital Status:</td>
		<td><input type="text" name="MaritalStatus" value="<?php  echo $demographic_row->MaritalStatus; ?>" /> (Percentage)</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="CollegeEducationCheck" <?php  echo $collegeeducation_checked; ?> /></td>
		<td>College Education:</td>
		<td><input type="text" name="CollegeEducation" value="<?php  echo $demographic_row->CollegeEducation; ?>" /> (Percentage)</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="IncomeCheck" <?php  echo $income_checked; ?> /></td>
		<td>Income:</td>
		<td><input type="text" name="Income" value="<?php  echo $demographic_row->Income; ?>" /> ($ in Thousands)</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="BrandLoyaltyCheck" <?php  echo $brandloyalty_checked; ?> /></td>
		<td>Brand Loyalty:</td>
		<td><input type="text" name="BrandLoyalty" value="<?php  echo $demographic_row->BrandLoyalty; ?>" /> (Number)</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="SecondChoiceVehicleCheck" <?php  echo $secondvehicle_checked; ?> /></td>
		<td>Second Vehicle:</td>
		<td><input type="text" name="SecondChoiceVehicle" value="<?php  echo $demographic_row->SecondChoiceVehicle; ?>" /> (Text)</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="PreviousVehicleCheck" <?php  echo $previousvehicle_checked; ?> /></td>
		<td>Previous Vehicle:</td>
		<td><input type="text" name="PreviousVehicle" value="<?php  echo $demographic_row->PreviousVehicle; ?>" /> (Text)</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="FutureSegmentCheck" <?php  echo $futuresegment_checked; ?> /></td>
		<td>Future Segment:</td>
		<td><input type="text" name="FutureSegment" value="<?php  echo $demographic_row->FutureSegment; ?>" /> (Text)</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="PricePaidCheck" <?php  echo $pricepaid_checked; ?> /></td>
		<td>Price Paid:</td>
		<td><input type="text" name="PricePaid" value="<?php  echo $demographic_row->PricePaid; ?>" /> ($ in Thousands)</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="ExteriorStylingRankCheck" <?php  echo $style_checked; ?> /></td>
		<td>Exterior Styling Rank:</td>
		<td><input type="text" name="ExteriorStylingRank" value="<?php  echo $demographic_row->ExteriorStylingRank; ?>" /> (Number)</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="right"><input type="image" src="media/images/update.jpg" border="0" /></td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
</form>
	<br /><br />
	
<table style="margin-left:50px;width:600px;" cellpadding="0">
	<tr><td colspan="2"class="header"><a name="press">Press Releases</a></td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>
			<img src="media/images/active.jpg" border="0" /> = Active&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="media/images/archived.jpg" border="0" /> = Archived&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="media/images/pending.jpg" border="0" /> = Pending
		</td>
		<td align="left">
			<a  href="index.php?comp=vehicle&task=editpressrelease&vehicleid=<?php echo $vehicleid; ?>">
				<img src="media/images/add.jpg" border="0"/></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	</tr>
	<?php while ($row = mysql_fetch_object($pressreleases_result)){
		if (date("Ymd") >= $row->PublishDate && $row->ArchiveDate == ""){
			$bullet = "active"; 
		} else if (date("Ymd") >= $row->PublishDate && date("Ymd") <= $row->ArchiveDate){
			$bullet = "active";
		} else if (date("Ymd") > $row->ArchiveDate && $row->ArchiveDate != ""){
			$bullet = "archived";
		} else if (date("Ymd") < $row->PublishDate){
			$bullet = "pending";
		}
		?>
	<tr>
		<td>
			<img src="media/images/<?php  echo $bullet; ?>.jpg" border="0" /> <?php  echo substr($row->Content, 0, 75); ?>...
		</td>
		<td align="left">
			<a  href="index.php?comp=vehicle&task=editpressrelease&id=<?php echo $row->ContentID; ?>&vehicleid=<?php echo $vehicleid; ?>">
				<img src="media/images/edit.jpg" border="0"/></a>
			<a  href="index.php?comp=vehicle&task=vehicle&action=deletepress&id=<?php echo $row->ContentID; ?>&vehicleid=<?php echo $vehicleid; ?>#press">
				<img src="media/images/delete.jpg" border="0"/></a>
		</td>
	</tr>	
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	<?php 
	}
	?>
		</td>
	</tr>
</table>
<br /><br /><br />
<?php
		}

	function getDemographicChecked(&$demographic){
		if(substr($demographic,0,3)=='<*>'){
			$demographic=substr($demographic,3);
			return 'checked';
		}
	}

	function breadCrumbs($vehicleid){
		global $system;
		
		if($vehicleid){
			$row=db::fetchObjectByColumn('vehicles','vehicleid',$vehicleid);
			$cbgid=$row->cbgid;
			$makeid=$row->makeid;
		}
		$system->breadcrumbs['Vehicle List']='index.php?comp=vehicle';
		$cbg_row=db::fetchObject('cbg',$cbgid);
		$system->breadcrumbs[$cbg_row->name]="index.php?comp=vehicle&task=vehicles&cbgid=$cbgid";
		$make_row=db::fetchObject('make',$makeid);
		$system->breadcrumbs["$make_row->name"]="index.php?comp=vehicle&task=vehicles&cbgid=$cbgid&makeid=$makeid";
		if($vehicleid){
			$system->breadcrumbs["$row->VehicleName"]="index.php?comp=vehicle&task=vehicle&vehicleid=$vehicleid";
		}
	}
	function addBreadCrumbs($cbgid,$makeid){
		global $system;
		
		$system->breadcrumbs['Vehicle List']='index.php?comp=vehicle';
		$cbg_row=db::fetchObject('cbg',$cbgid);
		$system->breadcrumbs[$cbg_row->name]="index.php?comp=vehicle&task=vehicles&cbgid=$cbgid";
		$make_row=db::fetchObject('make',$makeid);
		$system->breadcrumbs["$make_row->name"]="index.php?comp=vehicle&task=vehicles&cbgid=$cbgid&makeid=$makeid";
	}
	function editPressrelease(){
			global $system;
			
		require(system::getComponentPath('content','/administration').'/content_html.php');
			
		$ContentID=html::getInput($_GET,'id');
		$vehicleid=html::getInput($_GET,'vehicleid');
		vehicleHTML::breadcrumbs($vehicleid);

		if($ContentID){
			if(!$system->errors){
				$row=db::fetchObject('content',$ContentID);
				$this->Content=$row->Content;
				$this->ActiveFlag=$row->ActiveFlag;
				$this->PublishDate=$row->PublishDate==''?'':date("F j Y",strtotime($row->PublishDate));
				$this->ArchiveDate=$row->ArchiveDate==''?'':date("F j Y",strtotime($row->ArchiveDate));
			}
			$image='update';
			$system->breadcrumbs['Edit Vehicle Press Release']='';
			$header='Edit Press Release';
		}else{
			if(!$system->errors){
				$this->ActiveFlag=1;
			}
			$image='add';
			$system->breadcrumbs['Add Vehicle Press Release']='';
		$header='Add Press Release';
		}
		$pressreleaseHtml= new pressreleaseHtml;
		$pressreleaseHtml->PublishDate=$this->PublishDate;
		$pressreleaseHtml->ArchiveDate=$this->ArchiveDate;
		$pressreleaseHtml->ActiveFlag=$this->ActiveFlag;

?>
<br />
<div class="header" style="margin-left:10px;"><?php  echo $header;?></div>
<form action="index.php?comp=vehicle&task=editpressrelease&pid=<?php  echo $ContentID; ?>&vehicleid=<?php echo $vehicleid; ?>#press" method="post">
	<input type="hidden"  name="submit" value="pressrelease"/>
<div style="margin-left:10px;width:800px;text-align:right;">
	<a href="index.php?comp=vehicle&task=vehicle&vehicleid=<?php echo $vehicleid; ?>#press">
		<img src="media/images/cancel.jpg" border="0"/></a>
	<input type="image" src="media/images/<?php  echo $image;?>.jpg" border="0" onclick="" />
</div>
<div class="greySpacerLine" style="margin-left:10px;line-height:1px;width:800px;">&nbsp;</div>
<?php  $pressreleaseHtml->dates(); ?>
<textarea name="Content"  style="margin-left:10px;" cols="95" rows="20"><?php echo $row->Content; ?>
</textarea>
<div class="greySpacerLine" style="line-height:1px;width:800px;margin-left:10px;">&nbsp;</div>
<div style="margin-left:10px;width:800px;text-align:right;">
	<a href="index.php?comp=vehicle&task=vehicle&vehicleid=<?php echo $vehicleid; ?>#press">
		<img src="media/images/cancel.jpg" border="0"/></a>
	<input type="image" src="media/images/<?php  echo $image;?>.jpg" border="0" onclick="" />
</div>
</form>
	<?php
	}
	function confirm(){
?>
<br /><br />
<table style="margin-left:50px" cellpadding="0">
	<tr  class="greySpacerLine" ><td colspan="4"></td></tr>
	<tr>
		<td valign="center">
			<?php echo $this->prompt;?>
			&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
		<td>
			<a href="<?php echo $_SERVER[REQUEST_URI]; ?>&confirm=yes<?php echo $this->page_location;?>">
				<img src="media/images/yes.jpg" border="0" /></a>
			&nbsp;
			<a href="<?php echo $_SERVER[REQUEST_URI]; ?>&confirm=no<?php echo $this->page_location; ?>">
				<img src="media/images/no.jpg" border="0" /></a>
		</td>
	</tr>
	<tr  class="greySpacerLine" ><td colspan="4"></td></tr>
</table>
<?php
	}
}
class attributeHtml{
	function edit(){
		global $system,$live_site_admin;
		
		$vehicleid=html::getInput($_GET,'vehicleid');
		vehicleHTML::breadcrumbs($vehicleid);
		
		$attribute=html::getInput($_GET,'name');
		
		$system->breadcrumbs["Assign ".ucfirst($attribute)]='';
		
		if($attribute=='transmission'){
			$result=db::getResult($attribute,'order by abbrev');
		}else{
			$result=db::getResult($attribute,'order by name');
		}
		while($row=mysql_fetch_object($result)){
			$attributes[$row->name]='';
			$attributes[$row->name]['id']=$row->{$attribute."id"};
		}
		$result=db::getRelationResult('vehicle',$attribute,$vehicleid);
		while($row=mysql_fetch_object($result)){
			$attributes[$row->name]['checked']='checked';
		}
		$attribute_result=db::getResult($attribute,'order by name');
		$uri=$live_site_admin.'/index.php?comp=vehicle&task=editattribute&name='.$attribute;
?>
<br />
<script language="javascript">

	function validateBodystyle(checkbox)
	{
		if(!checkbox.checked){
			if(confirm('STOP!! WAIT!! \n Before discontinuing this bodystyle, \n you should verify that its current and future sales forecasts are ZERO.\n Continue anyway?')){
				if(!confirm('LAST CHANCE!! \n Are you sure you want to continue? ')){
					checkbox.checked=true
				}
			}else{
				checkbox.checked=true
			}
		}
	}

</script>

<form action="index.php?comp=vehicle&task=editattribute&name=<?php echo $attribute; ?>&vehicleid=<?php echo $vehicleid; ?>" method="post" >
	<input type="hidden" name="submit" value="attribute"/>
<table style="margin-left:50px;width:400px;" cellpadding="0">
	<tr><td colspan="2"class="header"><a name="demo">Assign <?php  echo ucfirst($attribute); ?></td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td style="line-height:1px;" colspan="10" align="right">
			<a href="<?php echo 'index.php?comp=vehicle&task=vehicle'; ?>&vehicleid=<?php echo $vehicleid; ?>#attribute">
				<img src="media/images/cancel.jpg"  border="0"/></a>
		<input  type="image" src="media/images/update.jpg" border="0" />
	</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php foreach($attributes as $name=>$vals){ 
	?>
	<tr><td><?php echo $name; ?></td>
		<td align="right">
			<input type="checkbox" name="<?php echo $vals['id']; ?>" <?php echo $vals['checked']; ?>
				<?php if($attribute=='bodystyle'){ 
				?> onclick="validateBodystyle(this)"<?php
				}
				?>
			/>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="2"></td></tr>
	</tr>
	<?php 
	} 
	?>
	<tr><td align="right" colspan="2">
			<a href="<?php echo 'index.php?comp=vehicle&task=vehicle'; ?>&vehicleid=<?php echo $vehicleid; ?>#attribute">
				<img src="media/images/cancel.jpg"  border="0"/></a>
		<input  type="image" src="media/images/update.jpg" border="0" />
	</td>
</table>
</form>
<?php
	}
	function editSeat(){
		global $system,$live_site_admin;
		
		$vehicleid=html::getInput($_GET,'vehicleid');
		vehicleHTML::breadcrumbs($vehicleid);
		
		$attribute=html::getInput($_GET,'name');
		$system->breadcrumbs["Assign Seating Capacity"]='';
		$result=db::getRelationResult('vehicle',$attribute,$vehicleid);
		while($row=mysql_fetch_object($result)){
			$attributes[$row->seats]['checked']='checked';
			$attributes[$row->seats]['value']='1';
			$attributes[$row->seats]['id']=$row->{"vehicle".$attribute."id"};
		}
		$attribute_result=db::getResult($attribute,'order by seats');
		$uri=$live_site_admin.'/index.php?comp=vehicle&task=editattribute&name='.$attribute;

?>
<br />
<div style="margin-left:50px;" class="header">Assign <?php  echo ucfirst($attribute); ?></div>
<div class="greySpacerLine" style="margin-left:50px;width:400px;"></div>
<div class="greySpacerLine" style="margin-left:50px;width:400px;"></div>

<form action="index.php?comp=vehicle&task=editattribute&name=<?php echo $attribute; ?>&vehicleid=<?php echo $vehicleid; ?>" method="post">
	<input type="hidden" name="submit" value="attribute"/>
<table style="margin-left:50px;width:400px;" cellpadding="0">
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr><td align="right" colspan="2">
			<a href="<?php echo 'index.php?comp=vehicle&task=vehicle'; ?>&vehicleid=<?php echo $vehicleid; ?>#attribute">
				<img src="media/images/cancel.jpg"  border="0"/></a>
		<input  type="image" src="media/images/update.jpg" border="0" />
	</td>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php while($row=mysql_fetch_object($attribute_result)){
	?>
	<tr><td><?php echo $row->seats; ?></td>
		<td align="right">
			<input type="checkbox" name="<?php echo $row->seatid; ?>" <?php echo $attributes[$row->seats]['checked']; ?>/>
		</td>
	</tr>
	<tr><td class="greySpacerLine"colspan="2"></td></tr>
	<?php 
	}
	?>
	<tr><td align="right" colspan="2">
			<a href="<?php echo 'index.php?comp=vehicle&task=vehicle'; ?>&vehicleid=<?php echo $vehicleid; ?>#attribute">
				<img src="media/images/cancel.jpg"  border="0"/></a>
		<input  type="image" src="media/images/update.jpg" border="0" />
	</td>
</table>
</form>
<?php
	}
	function editDivision(){
		global $system;
		
		$vehicleid=html::getInput($_GET,'vehicleid');
		vehicleHTML::breadcrumbs($vehicleid);
		
		$system->breadcrumbs["Assign Division"]='';
		$result=db::getRelationResult('vehicle','division',$vehicleid);
		while($row=mysql_fetch_object($result)){
			$attributes[$row->name]['checked']='checked';
			$attributes[$row->name]['value']='1';
		}
		$division_result=db::getResult('division','order by name');
		$uri='http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];
?>
<br />
<div style="margin-left:50px;" class="header">Assign Division</div>
<div class="greySpacerLine" style="margin-left:50px;width:600px;line-height:1px;">&nbsp;</div>

<form action="index.php?comp=vehicle&task=editdivision&vehicleid=<?php echo $vehicleid; ?>" method="post">
	<input type="hidden" name="submit" value="attribute"/>
<table style="margin-left:50px;width:600px;" cellpadding="0">
	<tr><td align="right" colspan="2">
			<a href="<?php echo 'index.php?comp=vehicle&task=vehicle'; ?>&vehicleid=<?php echo $vehicleid; ?>#attribute">
				<img src="media/images/cancel.jpg"  border="0"/></a>
		<input  type="image" src="media/images/update.jpg" border="0" />
	</td>
	<tr><td class="greySpacerLine" colspan="2"></td></tr>
	<?php while($row=mysql_fetch_object($division_result)){
		$value=$attributes[$row->name]['checked']?0:1; 
		?>
	<tr><td><?php echo $row->name; ?></td>
		<td align="center">
			<input type="radio" name="divisionid"<?php echo $attributes[$row->name]['checked']; ?> 
				value="<?php echo $row->divisionid;  ?>"/>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="2"></td></tr>
	<?php 
	}
	?>
	<tr><td align="right" colspan="2">
			<a href="<?php echo 'index.php?comp=vehicle&task=vehicle'; ?>&vehicleid=<?php echo $vehicleid; ?>#attribute">
				<img src="media/images/cancel.jpg"  border="0"/></a>
		<input  type="image" src="media/images/update.jpg" border="0" />
	</td>
</table>
</form>
<?php
	}
		function editSegment(){
		global $system;

		$vehicleid=html::getInput($_GET,'vehicleid');
		vehicleHTML::breadcrumbs($vehicleid);
		$system->breadcrumbs["Assign Segment"]='';
		
		$vehicle_row=db::fetchObjectByColumn('vehicles','vehicleid',$vehicleid);
		$segments=array();
		
		if($vehicle_row->segmentid){
			$segments[$vehicle_row->segmentid]='checked="checked"';
		}else{
			$no_segment='checked="checked"';
		}
		$type=$vehicle_row->TruckFlag?2:1;
		$attribute_result=eautodb::getAdminSegment($vehicle_row->cbgid,$type);
		$uri='http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];
?>
<br />
<form action="index.php?comp=vehicle&task=editsegment&vehicleid=<?php echo $vehicleid; ?>" method="post">
	<input type="hidden" name="submit" value="attribute"/>
<table style="margin-left:50px;width:600px;" cellpadding="0">
	<tr><td class="header" colspan="2">Assign Segment</td></tr>
	<tr><td class="greySpacerLine" colspan="2"></td></tr>
	<tr><td align="right" colspan="2">
			<a href="<?php echo 'index.php?comp=vehicle&task=vehicle'; ?>&vehicleid=<?php echo $vehicleid; ?>#attribute">
				<img src="media/images/cancel.jpg"  border="0"/></a>
		<input  type="image" src="media/images/update.jpg" border="0" />
	</td>
	<tr><td class="greySpacerLine" colspan="2"></td></tr>
	<tr><td>No Segment</td>
		<td align="center"><input type="radio" name="segmentid" value="0" <?php echo $no_segment; ?>/>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="2"></td></tr>
	<?php while($row=mysql_fetch_object($attribute_result)){
	?>
	<tr><td><?php echo $row->segment_name; ?></td>
		<td align="center"><input type="radio" name="segmentid" value="<?php echo $row->segmentid; ?>" <?php echo $segments[$row->segmentid]; ?> />
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="2"></td></tr>
	<?php 
	}
	?>
	<tr><td align="right" colspan="2">
			<a href="<?php echo 'index.php?comp=vehicle&task=vehicle'; ?>&vehicleid=<?php echo $vehicleid; ?>#attribute">
				<img src="media/images/cancel.jpg"  border="0"/></a>
		<input  type="image" src="media/images/update.jpg" border="0" />
	</td>
</table>
</form>
<?php
	}
}
class photoHtml{
	function search(){
		global $system,$live_site,$images_path;
		
		$vehicleid=html::getInput($_GET,'vehicleid');
		$result=db::getResultByColumn('vehiclephoto','vehicleid',$vehicleid,'order by ModelYear desc, PhotoDate desc, vehiclephotoid desc');
		$vehicle_row=eautoDB::getVehicle($vehicleid);
		$i=1;
			vehicleHTML::breadcrumbs($vehicleid);
			$system->breadcrumbs[' Photo Selection']='';
?>
<script language="javascript">

	function validatePhoto()
	{
		alert('This is the Main Photo. Another photo must be assigned as Main Photo before this can be deleted.')
		return 
	}

</script>

<br />
<table style="width:600px;margin-left:50px" cellpadding="0">
	<tr><td class="header" colspan="20">Photo Selection</td></tr>
	<tr><td class="greySpacerLine" colspan="20"></td></tr>
	<tr>
		<td class="header">
			<a href="index.php?comp=vehicle&task=vehicle&vehicleid=<?php echo $vehicleid; ?>">
				<img src="media/images/cancel.jpg"  border="0"/></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="20"></td></tr>
	<?php $td_count=0;
		while($row=mysql_fetch_object($result)){
			$delete_href="index.php?comp=vehicle&task=viewphotos&action=delete&id=$row->vehiclephotoid&vehicleid=$vehicleid";
			if($row->MainFlag){
				$delete_href="javascript:validatePhoto()";
			}
		?>
	<?php if($td_count==0){
	?>
	<tr>
	<?php 
	}
	?>
		<td align="left"  valign="top" style="width:158px;">
			<div class="strong" style="width:158px;"><span>Photo <?php echo $i++; ?></span><br /><br />
				<a href="<?php echo $images_path; ?>upload_photos/<?php echo $row->LargeFileName; ?>" target="_blank">
					<img src="<?php echo $images_path; ?>upload_photos/<?php echo $row->SmallFileName; ?>" width="154" height="93"style="border: 1px solid black" /></a><br />
		<table style="width:100%" border="0" cellspacing="2" cellpadding="2">
			<tr class="greySpacerLine"><td>Model Year: <?php echo $row->ModelYear; ?></td></tr>
			<tr class="greySpacerLine"><td>Caption: <?php echo $row->PhotoCaption; ?></td></tr>
			<tr class="greySpacerLine"><td>Credit: <?php echo $row->PhotoCredit; ?></td></tr>
			<tr>
				<td align="center">
			<a href="index.php?comp=vehicle&task=editphoto&id=<?php echo $row->vehiclephotoid; ?>&vehicleid=<?php echo $vehicleid; ?>">
				<img src="media/images/edit.jpg"  border="0"/></a>
			<a href="<?php echo $delete_href; ?>" >
				<img src="media/images/delete.jpg"  border="0"/></a>
				</td>
			</tr>
		</table>
			</div>
		</td>
	<?php if($td_count==2){
	?>
	</tr>
	<?php $td_count=0;
	}else{
	$td_count++;
	}
	?>
	<?php 
	}
	?>
</table>
<?php
	}
	function edit(){
		global $system, $live_site, $images_path;;

		$vehicleid=html::getInput($_GET,'vehicleid');
		vehicleHTML::breadcrumbs($vehicleid);
		$id=html::getInput($_GET,'id');
		if($id){
			$row=db::fetchObjectByColumn('vehiclephoto','vehiclephotoid',$id);
			$this->ModelYear=$row->ModelYear;
			$this->PhotoCredit=$row->PhotoCredit;
			$this->SmallFileName=$row->SmallFileName;
			$this->MainFlag=$row->MainFlag;
			$this->PhotoCaption=$row->PhotoCaption;
			$this->SourcePhotoName=$row->SourcePhotoName;
			$this->PhotoDate=$row->PhotoDate;
			$system->breadcrumbs['Photo Selection']="index.php?comp=vehicle&task=viewphotos&vehicleid=$vehicleid";
			$system->breadcrumbs['Edit Photo']='';
			$image='update';
			$header='Edit Photo';
			$task='viewphotos';
		}else{
			$system->breadcrumbs['Add Photo']='';
			$image='add';
			$header='Add Photo';
			$task='vehicle';
		}
		$mainflag_checked=$this->MainFlag?'checked="checked"':'';
		$photodate=date("m/d/Y",strtotime($this->PhotoDate));
?>
<br />
<form action="index.php?comp=vehicle&task=editphoto&id=<?php echo $id; ?>&vehicleid=<?php echo $vehicleid; ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="submit" value="photo" />
<table  style="margin-left:50px;" cellpadding="0" cellspacing="3" border="0">
	<tr><td class="Header" ><?php echo $header; ?></td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php if(!$id){
	?>
	<?php }else{
	?>
	<tr>
		<td align="right" valign="bottom">Thumbnail:</td>
		<td><img src="<?php  echo $images_path;  ?>upload_photos/<?php  echo $this->SmallFileName;  ?>" />
		</td>
		<td>
			<span class="strong">Source File:</span> <?php  echo $this->SourcePhotoName;  ?><br /><br />
			<span class="strong">Last Upload:</span> <?php  echo $photodate;  ?>
		</td>
	</tr>
	<?php 
	}
	?>
	<tr>
		<td align="right">Model Year:</td>
		<td><input type="text" size="10" name="ModelYear" value="<?php echo $this->ModelYear; ?>"/></td>
	</tr>
	<tr>
		<td align="right">Photo File Name:</td>
		<td><input type="file" size="30" name="photo" /></td>
		<?php if($id){
	?>
		<td class="red">(Leave blank to keep the current images.)</td>
	<?php 
	}
	?>
	</tr>
	<tr>
		<td align="right">Caption:</td>
		<td><input type="text" size="30" name="PhotoCaption" value="<?php echo $this->PhotoCaption; ?>"/></td>
	</tr>
	<tr>
		<td align="right">Credit:</td>
		<td><input type="text" size="30" name="PhotoCredit" value="<?php echo $this->PhotoCredit; ?>"/></td>
	</tr>
	<tr>
		<td align="right"><input type="checkbox" <?php  echo $mainflag_checked;  ?>size="10" name="MainFlag"/></td>
		<td>Mark as main image.</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td >
			<a href="index.php?comp=vehicle&task=<?php echo $task; ?>&vehicleid=<?php echo $vehicleid; ?>">
				<img src="media/images/cancel.jpg"  border="0"/></a>
			<input type="image" src="media/images/<?php  echo $image; ?>.jpg"  border="0"/>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
<?php
	}
}
class battlegroundHtml{
	function edit(){
		global $system,$images_pathm,$vehicleid;
		
		$vehicleid=html::getInput($_GET,'vehicleid',$vehicleid);
		if($vehicleid){
			vehicleHTML::breadcrumbs($vehicleid);
			$system->breadcrumbs['Edit Competitive Battleground Info']='';
			$row=eautoDB::getVehicle($vehicleid);
			$this->VehicleName=$row->VehicleName;
			$type_select_disabled='disabled="disabled"';
			if($row->TruckFlag){
				$truck_selected='selected="selected"';
			}else{
				$car_selected='selected="selected"';
			}
			$image='update';
			$cancel_href="index.php?comp=vehicle&task=vehicle&vehicleid=$vehicleid";
		}else{
			$cbgid=html::getInput($_REQUEST,'cbgid');
			$makeid=html::getInput($_REQUEST,'makeid');
			$image='add';
			vehicleHTML::addBreadcrumbs($cbgid,$makeid);
			$system->breadcrumbs['Add Competitive Battleground Info']='';
			$on_submit="onsubmit=\"return validateAdd();\"";
			$cancel_href="index.php?comp=vehicle&task=vehicles";
		}
		if(isset($system->errors)){
		}else{
		}
		$onclick="window.location.assign(\"index.php?comp=vehicle&task=editbattleground&vehicleid=$vehicleid&action=sold&r=AmericaRegion&v";
		$AmericaRegion=$row->AmericaRegion?'checked':'';
		$AmericaRegionOnClick=$row->AmericaRegion?
			"$onclick=0\")":
			"$onclick=1\")";
		$AsiaRegion=$row->AsiaRegion?'checked':'';
		$AsiaRegionOnClick=$row->AsiaRegion?
			"$onclick=0\")":
			"$onclick=1\")";
		$EuropeRegion =$row->EuropeRegion ?'checked':'';
		$EuropeRegionOnClick=$row->EuropeRegion?
			"$onclick=0\")":
			"$onclick=1\")";
?>
<script language="javascript">

	function validateAdd()
	{
			if (document.battleground_form.TruckFlag.options[document.battleground_form.TruckFlag.options.selectedIndex].value != '')
			{
				return true;
			} else
			{
				alert('You need to specify a Vehicle Type from the list above.');
				return false;
			}
	}

</script>
<br />
<?php //echo "here is ".$_COOKIE['cbgid']." ".$_COOKIE['makeid']; ?>
<form name="battleground_form" action="index.php?comp=vehicle&task=editbattleground&vehicleid=<?php echo $vehicleid; ?>" method="post">
	<?php  echo $on_submit?>
	<input type="hidden"  name="form" value="battleground"/>
	<input type="hidden"  name="cbgid" value="<?php echo $_COOKIE['cbgid']; ?>"/>
	<input type="hidden"  name="makeid" value="<?php echo $_COOKIE['makeid']; ?>"/>
<table style="width:700px;" cellpadding="0">
	<tr><td class="Header"colspan="4" >Competitive Battleground</td></tr>
	<tr><td colspan="4" align="right" >
		<a href="<?php  echo $cancel_href?>">
			<img src="media/images/cancel.jpg" border="0"/></a>
		<input  type="image" src="media/images/<?php  echo $image; ?>.jpg" border="0" />
		</td></tr>
	<tr><td colspan="4" class="greySpacerLine" ></td></tr>
	<tr>
		<td  style="width:150px" align="right">Vehicle Name:</td>
		<td ><input type="text" name="VehicleName" value="<?php echo $this->VehicleName; ?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td  align="right">Vehicle Type:</td>
		<td >
			<select name="TruckFlag" <?php echo $type_select_disabled; ?> >
				<option value="">Select a Type</option>
				<option <?php echo $car_selected;  ?> value="0">Car</option>
				<option <?php echo $truck_selected;  ?> value="1">Truck</option>
			</select>
		</td>
	</tr>
	<tr>
		<td  align="right">Current Code Name:</td>
		<td><input type="text" name="CurrentCodeName" size="10" value="<?php echo $row->CurrentCodeName;?>" /></td>
		<td  align="right">Future Code Name:</td>
		<td><input type="text" name="FutureCodeName" size="10" value="<?php echo $row->FutureCodeName;?>" /></td>
	</tr>
	<tr><td colspan="4" class="greySpacerLine" ></td></tr>
	<tr>
		<td  align="right">Major Change 1:</td>
		<td><input type="text" name="Change1" size="10" value="<?php echo $row->Change1;?>" /></td>
	<td  align="right"><input type="checkbox" name="AmericaRegion" <?php echo $AmericaRegion;?>   /></td>
	<td>Sold in America</td>
		<tr>
	</tr>
		<td  align="right">Major Change 2:</td>
		<td><input type="text" name="Change2" size="10" value="<?php echo $row->Change2;?>" /></td>
	<td  align="right"><input type="checkbox" name="AsiaRegion" <?php echo $AsiaRegion;?>  /></td>
	<td>Sold in Asia</td>
	<tr>
	</tr>
		<td  align="right">Major Change 3:</td>
		<td><input type="text" name="Change3" size="10" value="<?php echo $row->Change3;?>" /></td>
	<td  align="right"><input type="checkbox" name="EuropeRegion" <?php echo $EuropeRegion;?>  /></td>
	<td>Sold in Europe</td>
	</tr>
</table>


<table style="width:800px;" cellpadding="0">
	<tr><td colspan="4" class="greySpacerLine" ></td></tr>
	<tr><td valign="top">Main Body:</td>
		<td>
			<textarea name="FutureProduct" rows="30" cols="80"><?php echo $row->FutureProduct; ?></textarea>
		</td>
	</tr>
	<tr><td colspan="4" class="greySpacerLine"></td></tr>
	<tr><td valign="top">What X means to Y:</td>
		<td>
			<textarea name="XToY" rows="10" cols="80"><?php echo $row->XToY; ?></textarea>
		</td>
	</tr>
</table>
</form>
<?php 
//ini_set('display_errors','On');
//echo "here is ".$_COOKIE['cbgid']." ".$_COOKIE['makeid'];
require_once('vehicleText.php');
?>
<table style="width:800px;" cellpadding="0">
	<tr><td colspan="4" class="greySpacerLine" ></td></tr>
	<tr>
	<td valign="top" style="padding-left: 8px; padding-top: 15px; font-size: 11px; font-family: sans-serif; line-height: 150%; color: #000000; font-weight: 700; text-align: left; letter-spacing: 2px;">Key Points:</td><td><div class="test" ><textarea id="markItUp" class="markItUp" data-filter="vehicleKeypoint"><?php echo $keyPoint; ?></textarea></div></td>
	</tr>
	<tr><td colspan="4" class="greySpacerLine" ></td></tr>
	<tr>
	<td valign="top" style="padding-left: 8px; padding-top: 15px; font-size: 11px; font-family: sans-serif; line-height: 150%; color: #000000; font-weight: 700; text-align: left; letter-spacing: 2px;">Future Intel:</td><td><div class="test" ><textarea id="markItUp" class="markItUp" data-filter="futureIntl"><?php echo $futureIntl; ?></textarea></div></td>
	</tr>
	<tr><td colspan="4" class="greySpacerLine" ></td></tr>
	<tr>
	<td valign="top" style="padding-left: 8px; padding-top: 15px; font-size: 11px; font-family: sans-serif; line-height: 150%; color: #000000; font-weight: 700; text-align: left; letter-spacing: 2px;">Current Generation<br />Equiptment Updates:</td><td><textarea id="markItUp" class="markItUp" data-filter="currentGenerationEquipmentUpdates"><?php echo $currentGenerationEquipmentUpdates; ?></textarea></td>
	</tr>
	<tr><td colspan="4" class="greySpacerLine" ></td></tr>
	<tr>
	<td valign="top" style="padding-left: 8px; padding-top: 15px; font-size: 11px; font-family: sans-serif; line-height: 150%; color: #000000; font-weight: 700; text-align: left; letter-spacing: 2px;">Current Generation<br />
	Launch Info</td><td><textarea id="markItUp" class="markItUp" data-filter="vehicleCGLaunchInfo"><?php echo $currentGenerationLaunchInfo; ?></textarea></td>
	</tr>
	<tr><td colspan="4" class="greySpacerLine" ></td></tr>
	<tr>
	<td valign="top" style="padding-left: 8px; padding-top: 15px; font-size: 11px; font-family: sans-serif; line-height: 150%; color: #000000; font-weight: 700; text-align: left; letter-spacing: 2px;">Prior Generation Info:</td><td><textarea id="markItUp" class="markItUp" data-filter="vehiclePriorGenerationInfo"><?php echo $priorGenerationInfo; ?></textarea></td>
	</tr>
	<tr><td colspan="4" class="greySpacerLine" ></td></tr>
	<tr>
	<td valign="top" style="padding-left: 8px; padding-top: 15px; font-size: 11px; font-family: sans-serif; line-height: 150%; color: #000000; font-weight: 700; text-align: left; letter-spacing: 2px;">Vehicle Configuration<br />and Powertrain Profile:</td><td><textarea id="markItUp" class="markItUp" data-filter="vehicleConfigPowerTrainProfile"><?php echo $vehicleConfigPowerTrainProfile; ?></textarea></td>
	</tr>
	<tr><td colspan="4" class="greySpacerLine" ></td></tr>
	<tr>
	<td valign="top" style="padding-left: 8px; padding-top: 15px; font-size: 11px; font-family: sans-serif; line-height: 150%; color: #000000; font-weight: 700; text-align: left; letter-spacing: 2px;">AutoPacific's Take:</td><td><textarea id="markItUp" class="markItUp" data-filter="vehicleAutoPacificsTake"><?php echo $autopacificsTake; ?></textarea></td>
	</tr>
</table>

</div>

<?php
		}
		function listCycle($vehicleid){
			global $system,$images_path;
			$battlegroundDB= new battlegroundDB;
			$battlegroundDB->getBattlegroundCycleByVehicle($vehicleid);
			vehicleHTML::breadcrumbs($vehicleid);
			$system->breadcrumbs['View Battleground Cycle Text']='';

?>
<br />
<form action="index.php?comp=vehicle&task=editbattlegroundcycleyear&vehicleid=<?php echo $vehicleid; ?>&id=<?php echo $id; ?>" method="post">
	<input type="hidden"  name="submit" value="cycleyear"/>
<table style="margin-left:50px;width:600px;" cellpadding="0">
	<tr><td class="header" colspan="10">Competitive Battleground Cycle Text List</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr><th>Year: </th><th>Cell Text Information: </th><th>&nbsp;</th></tr>
	<tr>
		<td><input type="text" size="5"name="LineYear" /></td>
		<td><input type="text" size="60"name="CycleText" /></td>
		<td>
			<input type="image" src="media/images/add.jpg" border="0" />
			<a href="index.php?comp=vehicle&task=vehicle&vehicleid=<?php echo $vehicleid; ?>" >
				<img src="media/images/cancel.jpg" border="0"/></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php foreach($battlegroundDB->years as $year){
	?>
	<tr>
		<td><?php echo $year->LineYear; ?></td>
		<td align="center"><?php echo $year->CycleText; ?></td>
		<td valign="middle">
			<a href="index.php?comp=vehicle&task=editbattlegroundcycleyear&vehicleid=<?php echo $vehicleid; ?>&id=<?php echo $year->vehicleBattleGroundCycleID; ?>" >
				<img src="media/images/edit.jpg" border="0"/></a>
			<a href="index.php?comp=vehicle&task=listbattlegroundcycle&vehicleid=<?php echo $vehicleid; ?>&id=<?php echo $year->vehicleBattleGroundCycleID; ?>&action=delete" >
				<img src="media/images/delete.jpg" border="0"/></a>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php 
	}
	?>
</table>
</form>
<?php
		}
		
		function editCycleYear($id){
			global $system,$images_path;
			
			$vehicleid=html::getInput($_GET,'vehicleid');
			$image=$id==''?'add':'update';
			if(!$system->errors){
				$row=db::fetchObject('vehicleBattlegroundCycle',$id);
				$this->LineYear=$row->LineYear;
				$this->CycleText=$row->CycleText;
			}
			vehicleHTML::breadcrumbs($vehicleid);
			$system->breadcrumbs['View Battleground Cycle Text']="index.php?comp=vehicle&task=listbattlegroundcycle&vehicleid=$vehicleid";
			$system->breadcrumbs['Edit Cycle Plan Year']='';
?>
<br />
<form action="index.php?comp=vehicle&task=editbattlegroundcycleyear&vehicleid=<?php echo $vehicleid; ?>&id=<?php echo $id; ?>" method="post">
	<input type="hidden"  name="submit" value="cycleyear"/>
<table style="margin-left:50px" cellpadding="0">
	<tr><td class="Header"colspan="4" >Competitive Battleground Cycle Text List</td></tr>
	<tr><td colspan="4" class="greySpacerLine"></td></tr>
	<tr>
		<td valign="middle" align="left">
			Year: <input type="text" name="LineYear" value="<?php echo $this->LineYear; ?>" size="6"/>&nbsp;&nbsp;
			Text: <input type="text" name="CycleText"  size="80" value="<?php echo $this->CycleText; ?>" />
		</td>
	</tr>
	<tr><td colspan="4" class="greySpacerLine"></td></tr>
	<tr>
		<td valign="middle" align="right">
			<a href="<?php echo $_SERVER[HTTP_REFERER]; ?>" ><img src="media/images/cancel.jpg" border="0"/></a>
			<input type="image" src="media/images/<?php  echo $image; ?>.jpg" border="0" />
		</td>
	</tr>
</table>
</form>
<?php
	}
	
}
class dimensionHtml{
	function editVariation(){
		global $system,$images_path;

		$id=html::getInput($_GET,'id');
		$vehicleid=html::getInput($_GET,'vehicleid');
		$image=$id==''?'add':'update';
		$header=$id==''?'Add Dimensions':'Edit Dimensions';
		if(!$system->errors && $id){
			$row=db::fetchObject('vehicleDimension',$id);
			$this->VariationName=$row->VariationName;
			$this->PlannedLifeCycle=$row->PlannedLifeCycle;
			$this->WB=$row->WB;
			$this->OAL=$row->OAL;
			$this->OAW=$row->OAW;
			$this->OAH=$row->OAH;
		}
		vehicleHTML::breadcrumbs($vehicleid);
		$system->breadcrumbs[$header]='';
?>

<br />
<form action="index.php?comp=vehicle&task=editvariation&id=<?php echo $id; ?>&vehicleid=<?php echo $vehicleid; ?>#dimension" method="post" >
	<input type="hidden"  name="submit" value="variation"/>
<table style="margin-left:50px;width:600px;" cellpadding="0" cellspacing="3">
	<tr><td class="Header"colspan="4" ><?php  echo $header; ?></td></tr>
	<tr><td colspan="10" class="greySpacerLine" ></td></tr>
	<tr>
		<td align="left">Variation Name:</td>
		<td align="left">Life Cycle:</td>
		<td align="left">WB:</td>
		<td align="left">OAL:</td>
		<td align="left">OAW:</td>
		<td align="left">OAH:</td>
	</tr>
	<tr>
		<td><input type="text" name="VariationName" value="<?php  echo $this->VariationName; ?>" /></td>
		<td><input type="text" name="PlannedLifeCycle" value="<?php  echo $this->PlannedLifeCycle; ?>" size="10"/></td>
		<td><input type="text" name="WB" value="<?php  echo $this->WB; ?>"  size="10"/></td>
		<td><input type="text" name="OAL" value="<?php  echo $this->OAL; ?>"  size="10"/></td>
		<td><input type="text" name="OAW" value="<?php  echo $this->OAW; ?>"  size="10"/></td>
		<td><input type="text" name="OAH" value="<?php  echo $this->OAH; ?>"  size="10"/></td>
	</tr>
	<tr><td colspan="10" class="greySpacerLine" ></td></tr>
	<tr>
		<td colspan="10" align="right">			
			<a href="<?php echo 'index.php?comp=vehicle&task=vehicle'; ?>&vehicleid=<?php echo $vehicleid; ?>#dimension">
				<img src="media/images/cancel.jpg"  border="0"/></a>
			<input type="image"  src="media/images/<?php echo $image; ?>.jpg" border="0" />
		</td>
	</tr>
</table>
</form>
<br />
<?php
	}
	function editStartOfProduction(){
		global $system,$images_path;

		$id=html::getInput($_GET,'id');
		$vehicleid=html::getInput($_GET,'vehicleid');
		$image=$id==''?'add':'update';
		$header=$id==''?'Add Start of Production':'Edit Start of Production';
		if(!$system->errors && $id){
			$row=db::fetchObject('vehiclestartofproduction',$id);
			$this->StartOfProduction=$row->StartOfProduction;
		}
		vehicleHTML::breadcrumbs($vehicleid);
		$system->breadcrumbs[$header]='';
?>
<br />
<form action="index.php?comp=vehicle&task=editstartofp&id=<?php echo $id; ?>&vehicleid=<?php echo $vehicleid; ?>#dimension" method="post" >
	<input type="hidden"  name="submit" value="dimension"/>
<table style="margin-left:50px;width:600px;" cellpadding="0" cellspacing="3">
	<tr><td class="Header"colspan="4" ><?php  echo $header; ?></td></tr>
	<tr><td colspan="10" class="greySpacerLine" ></td></tr>
	<tr>
		<td align="left">StartOfProduction:</td>
	</tr>
	<tr>
		<td><input type="text" name="StartOfProduction" value="<?php  echo $this->StartOfProduction; ?>" /></td>
	</tr>
	<tr><td colspan="10" class="greySpacerLine"></td></tr>
	<tr>
		<td colspan="10">			
			<a href="<?php echo 'index.php?comp=vehicle&task=vehicle'; ?>&vehicleid=<?php echo $vehicleid; ?>#dimension">
				<img src="media/images/cancel.jpg"  border="0"/></a>
			<input type="image"  src="media/images/<?php echo $image; ?>.jpg" border="0" />
		</td>
	</tr>
</table>
</form>
<br />
<?php
	}
	function editSalesLaunch(){
		global $system,$images_path;

		$id=html::getInput($_GET,'id');
		$vehicleid=html::getInput($_GET,'vehicleid');
		$image=$id==''?'add':'update';
		$header=$id==''?'Add Sales Launch':'Edit Sales Launch';
		if(!$system->errors && $id){
			$row=db::fetchObject('vehiclesaleslaunch',$id);
			$this->SalesLaunch=$row->SalesLaunch;
		}
		vehicleHTML::breadcrumbs($vehicleid);
		$system->breadcrumbs[$header]='';
?>
<br />
<form action="index.php?comp=vehicle&task=editsaleslaunch&id=<?php echo $id; ?>&vehicleid=<?php echo $vehicleid; ?>" method="post" >
	<input type="hidden"  name="submit" value="dimension"/>
<table style="margin-left:50px;width:600px;" cellpadding="0" cellspacing="3">
	<tr><td class="Header"colspan="4" ><?php  echo $header; ?></td></tr>
	<tr><td colspan="10" class="greySpacerLine"></td></tr>
	<tr>
		<td align="left">Sales Launch:</td>
	</tr>
	<tr>
		<td><input type="text" name="SalesLaunch" value="<?php  echo $this->SalesLaunch; ?>" /></td>
	</tr>
	<tr>
		<td colspan="10">			
			<a href="<?php echo 'index.php?comp=vehicle&task=vehicle'; ?>&vehicleid=<?php echo $vehicleid; ?>#dimension">
				<img src="media/images/cancel.jpg"  border="0"/></a>
			<input type="image"  src="media/images/<?php echo $image; ?>.jpg" border="0" />
		</td>
	</tr>
	<tr><td colspan="10" class="greySpacerLine" ></td></tr>
</table>

</form>
<?php
	}
	function editCurbWeightRange(){
		global $system,$images_path;

		$id=html::getInput($_GET,'id');
		$vehicleid=html::getInput($_GET,'vehicleid');
		$image=$id==''?'add':'update';
		$header=$id==''?'Add Curb Weight Range':'Edit Curb Weight Range';
		if(!$system->errors && $id){
			$row=db::fetchObject('vehiclecurbweightrange',$id);
			$this->CurbWeightRange=$row->CurbWeightRange;
		}
		vehicleHTML::breadcrumbs($vehicleid);
		$system->breadcrumbs[$header]='';
?>
<br />
<form action="index.php?comp=vehicle&task=editcurbweight&id=<?php echo $id; ?>&vehicleid=<?php echo $vehicleid; ?>" method="post" >
	<input type="hidden"  name="submit" value="dimension"/>
<table style="margin-left:50px;width:600px;" cellpadding="0" cellspacing="3">
	<tr><td class="Header"colspan="4" ><?php  echo $header; ?></td></tr>
	<tr><td colspan="10" class="greySpacerLine"></td></tr>
	<tr>
		<td align="left">Curb Weight Range:</td>
	</tr>
	<tr>
		<td><input type="text" name="CurbWeightRange" value="<?php  echo $this->CurbWeightRange; ?>" /></td>
	</tr>
	<tr>
		<td colspan="10">			
			<a href="<?php echo 'index.php?comp=vehicle&task=vehicle'; ?>&vehicleid=<?php echo $vehicleid; ?>#dimension">
				<img src="media/images/cancel.jpg"  border="0"/></a>
			<input type="image"  src="media/images/<?php echo $image; ?>.jpg" border="0" />
		</td>
	</tr>
	<tr><td colspan="10" class="greySpacerLine" ></td></tr>
</table>
</form>
<?php
	}
	function editTireSizes(){
		global $system;

		$id=html::getInput($_GET,'id');
		$vehicleid=html::getInput($_GET,'vehicleid');
		$image=$id==''?'add':'update';
		$header=$id==''?'Add Tire Sizes':'Edit Tire Sizes';
		if(!$system->errors && $id){
			$row=db::fetchObject('vehicletiresize',$id);
			$this->TireSize=$row->TireSize;
		}
		vehicleHTML::breadcrumbs($vehicleid);
		$system->breadcrumbs[$header]='';
?>
<br />
<form action="index.php?comp=vehicle&task=edittiresize&id=<?php echo $id; ?>&vehicleid=<?php echo $vehicleid; ?>" method="post" >
	<input type="hidden"  name="submit" value="dimension"/>
<table style="margin-left:50px;width:600px;" cellpadding="0" cellspacing="3">
	<tr><td class="Header"colspan="4" ><?php  echo $header; ?></td></tr>
	<tr><td colspan="10" class="greySpacerLine" ></td></tr>
	<tr>
		<td align="left">Tire Size:</td>
	</tr>
	<tr>
		<td><input type="text" name="TireSize" value="<?php  echo $this->TireSize; ?>" /></td>
	</tr>
	<tr>
		<td colspan="10">			
			<a href="<?php echo 'index.php?comp=vehicle&task=vehicle'; ?>&vehicleid=<?php echo $vehicleid; ?>#dimension">
				<img src="media/images/cancel.jpg"  border="0"/></a>
			<input type="image"  src="media/images/<?php echo $image; ?>.jpg" border="0" />
		</td>
	</tr>
	<tr><td colspan="10" class="greySpacerLine" ></td></tr>
</table>
</form>
<?php
	}
	function editEngine(){
		global $system;

		$id=html::getInput($_GET,'id');
		$vehicleid=html::getInput($_GET,'vehicleid');
		$image=$id==''?'add':'update';
		$header=$id==''?'Add Engine':'Edit Engine';
		if(!$system->errors && $id){
			$row=db::fetchObject('vehicleengine',$id);
			$this->Engine=$row->Engine;
		}
		vehicleHTML::breadcrumbs($vehicleid);
		$system->breadcrumbs[$header]='';
?>
<br />
<form action="index.php?comp=vehicle&task=editengine&id=<?php echo $id; ?>&vehicleid=<?php echo $vehicleid; ?>" method="post" >
	<input type="hidden"  name="submit" value="dimension"/>
<table style="margin-left:50px;width:600px;" cellpadding="0" cellspacing="3">
	<tr><td class="Header"colspan="4" ><?php  echo $header; ?></td></tr>
	<tr><td colspan="10" class="greySpacerLine"></td></tr>
	<tr>
		<td align="left">Engine:</td>
	</tr>
	<tr>
		<td><input type="text" name="Engine" value="<?php  echo $this->Engine; ?>" /></td>
	</tr>
	<tr>
		<td colspan="10">			
			<a href="<?php echo 'index.php?comp=vehicle&task=vehicle'; ?>&vehicleid=<?php echo $vehicleid; ?>#dimension">
				<img src="media/images/cancel.jpg"  border="0"/></a>
			<input type="image"  src="media/images/<?php echo $image; ?>.jpg" border="0" />
		</td>
	</tr>
	<tr><td colspan="10" class="greySpacerLine"></td></tr>
</table>
</form>
<?php
	}
	function editSuspension(){
		global $system;

		$id=html::getInput($_GET,'id');
		$vehicleid=html::getInput($_GET,'vehicleid');
		$image=$id==''?'add':'update';
		$header=$id==''?'Add Suspension':'Edit Suspension';
		if(!$system->errors && $id){
			$row=db::fetchObject('vehiclesuspension',$id);
			$this->FrontSuspension=$row->FrontSuspension;
			$this->RearSuspension=$row->RearSuspension;
		}
		vehicleHTML::breadcrumbs($vehicleid);
		$system->breadcrumbs[$header]='';
?>
<br />
<form action="index.php?comp=vehicle&task=editsuspension&id=<?php echo $id; ?>&vehicleid=<?php echo $vehicleid; ?>" method="post" >
	<input type="hidden"  name="submit" value="dimension"/>
<table style="margin-left:50px;width:600px;" cellpadding="0" cellspacing="3">
	<tr><td class="Header"colspan="4" ><?php  echo $header; ?></td></tr>
	<tr><td colspan="10" class="greySpacerLine"></td></tr>
	<tr>
		<td align="left">Front Suspension:</td>
		<td align="left">Rear Suspension:</td>
	</tr>
	<tr>
		<td><input type="text" name="FrontSuspension" value="<?php  echo $this->FrontSuspension; ?>" /></td>
		<td><input type="text" name="RearSuspension" value="<?php  echo $this->RearSuspension; ?>" /></td>
	</tr>
	<tr>
		<td colspan="10">			
			<a href="<?php echo 'index.php?comp=vehicle&task=vehicle'; ?>&vehicleid=<?php echo $vehicleid; ?>#dimension">
				<img src="media/images/cancel.jpg"  border="0"/></a>
			<input type="image"  src="media/images/<?php echo $image; ?>.jpg" border="0" />
		</td>
	</tr>
	<tr><td colspan="10" class="greySpacerLine"></td></tr>
</table>
</form>
<?php
	}
	function editPriceRange(){
		global $system;

		$id=html::getInput($_GET,'id');
		$vehicleid=html::getInput($_GET,'vehicleid');
		$image=$id==''?'add':'update';
		$header=$id==''?'Add Price Range':'Edit Price Range';
		if(!$system->errors && $id){
			$row=db::fetchObject('vehiclepricerange',$id);
			$this->Low=$row->Low;
			$this->High=$row->High;
		}
		vehicleHTML::breadcrumbs($vehicleid);
		$system->breadcrumbs[$header]='';
?>
<br />
<form action="index.php?comp=vehicle&task=editprice&id=<?php echo $id; ?>&vehicleid=<?php echo $vehicleid; ?>" method="post" >
	<input type="hidden"  name="submit" value="dimension"/>
<table style="margin-left:50px;width:600px;" cellpadding="0" cellspacing="3">
	<tr><td class="Header"colspan="4" ><?php  echo $header; ?></td></tr>
	<tr><td colspan="10" class="greySpacerLine"></td></tr>
	<tr>
		<td align="left">Low:</td>
		<td align="left">High:</td>
	</tr>
	<tr>
		<td><input type="text" name="Low" value="<?php  echo $this->Low; ?>" /></td>
		<td><input type="text" name="High" value="<?php  echo $this->High; ?>" /></td>
	</tr>
	<tr>
		<td colspan="10">			
			<a href="<?php echo 'index.php?comp=vehicle&task=vehicle'; ?>&vehicleid=<?php echo $vehicleid; ?>#dimension">
				<img src="media/images/cancel.jpg"  border="0"/></a>
			<input type="image"  src="media/images/<?php echo $image; ?>.jpg" border="0" />
		</td>
	</tr>
	<tr><td colspan="10" class="greySpacerLine"></td></tr>
</table>
</form>
<?php
	}
}
class sfcsHtml{
	function editText($id){
		global $system;
		
		$vehicleid=html::getInput($_GET,'vehicleid');
		$row=db::fetchObjectByColumn('salesforecasttext','SFTextID',$id);
		vehicleHTML::breadcrumbs($vehicleid);
		$system->breadcrumbs['Sales Forecast Vehicle Edit']='index.php?comp=vehicle&task=editsalesforecast&vehicleid='.$vehicleid;
		$system->breadcrumbs['Edit Sales Forecast Text']='';
?>
<br />
<div class="header" style="margin-left:50px;">Sales Forecast</div>
<form action="index.php?comp=vehicle&task=editsalesforecasttext&id=<?php echo $id; ?>&vehicleid=<?php echo $vehicleid; ?>" method="post">
	<input type="hidden"  name="submit" value="text"/>
<div style="width:800px;text-align:right;margin-left:50px;">
	<a href="index.php?comp=vehicle&task=editsalesforecast&vehicleid=<?php echo $vehicleid; ?>">
	<img src="media/images/cancel.jpg"  border="0"/></a>
	<input type="image" src="media/images/update.jpg"  border="0"/>
</div>
<div class="greySpacerLine" style="margin-left:50px;width:800px;line-height:1px;">&nbsp;</div>
<textarea name="SFText" rows="20" cols="95" style="margin-left:50px;"><?php echo $row->SFText; ?></textarea>
<div class="greySpacerLine" style="margin-left:50px;width:800px;line-height:1px;">&nbsp;</div>
<div style="width:800px;text-align:right;margin-left:50px;">
	<a href="index.php?comp=vehicle&task=editsalesforecast&vehicleid=<?php echo $vehicleid; ?>">
	<img src="media/images/cancel.jpg"  border="0"/></a>
	<input type="image" src="media/images/update.jpg"  border="0"/>
</div>
</form>
<?php
	}
	function editData(){
		global $system;
		
		$start_year=html::getInput($_GET,'start_year');
		$end_year=$start_year+6;

		$vehicleid=html::getInput($_GET,'vehicleid');
		$bodystyleid=html::getInput($_GET,'bodystyleid');
		$result=salesforecastDB::getByVehicleBodyStyle($vehicleid,$bodystyleid,$start_year,$end_year);
		vehicleHTML::breadcrumbs($vehicleid);
		$system->breadcrumbs['Edit Sales Forecast Info']=$_SERVER['HTTP_REFERER'];
		$system->breadcrumbs['Edit Bodystyle Volume']='';
		$vehicle_row=db::fetchObjectByColumn('vehicles','VehicleID',$vehicleid);
		$bodystyle_row=db::fetchObject('bodystyle',$bodystyleid);
		for($year=$start_year;$year<=$end_year;$year++){
			$years[$year]='';
		}
		while($row=mysql_fetch_object($result)){
			$years[$row->SalesYear]=$row->SalesValue;
		}
?>
<br /><br />
<table style="margin-left:50px;" border="0" cellspacing="3" cellpadding="0" width="600px">
	<tr><td class="header"colspan="4" >Edit Vehicle Bodystyle Volume</td></tr>
	<tr><td colspan="40" class="greySpacerLine"></td></tr>
	<tr>
		<td nowrap="nowrap" class="strong">Vehicle Name:</td>
		<td style="width:100%"><?php echo $vehicle_row->VehicleName; ?></td>
	</tr>
	<tr>
		<td nowrap="nowrap" class="strong">BodyStyle:</td>
		<td><?php echo $bodystyle_row->name; ?></td>
	</tr>
	<tr><td colspan="40" class="greySpacerLine"></td></tr>
</table>
<br />
<form action="<?php echo $_SERVER[HTTP_REFERER]; ?>&bodystyleid=<?php echo $bodystyleid; ?>" method="post">
	<input type="hidden"  name="submit" value="data"/>
<table style="margin-left:30px;" border="0" cellspacing="3" cellpadding="0" width="600px">
	<tr><td class="strong"colspan="4" >Calendar Year</td></tr>
	<tr><td colspan="40" class="greySpacerLine"></td></tr>
	<tr>
		<?php foreach($years as $year=>$value){
	?>
		<td><?php echo $year; ?><br />
			<input size="10" name="SalesYear<?php echo $year; ?>" value="<?php echo $value; ?>"/>
			</td>
		<?php 
	}
	?>
	</tr>
	<tr><td colspan="40" class="greySpacerLine"></td></tr>
	<tr>
		<td colspan="40" align="right">
			<a href="<?php echo $_SERVER[HTTP_REFERER]; ?>"><img src="media/images/cancel.jpg"  border="0"/></a>
			<input type="image" src="media/images/update.jpg" border="0"/>
		</td>
	</tr>
</table>
</form>
<?php
	}
	
	function search($vehicleid){
		global $system;

		$salesforecastDB= new salesforecastDB;
		$row=db::fetchObjectByColumn('matrixprefs','PrefName','BegYear');
		$default_start_year=$row->PrefValue;
		$start_year=html::getInput($_GET,'sy',$default_start_year);
		$end_year=$start_year+6;
		$row=db::fetchObjectByColumn('matrixprefs','PrefName','YearIncrement');
		$year_change=$row->PrefValue;

		$salesforecastDB->getListByVehicle($vehicleid,$start_year,$end_year);
		$text=nl2br($salesforecastDB->row->SFText);
		vehicleHTML::breadcrumbs($vehicleid);
		$system->breadcrumbs['Sales Forecast Vehicle Edit']='';
		$vehicleid=html::getInput($_GET,'vehicleid');
?>
<br />
<table style="width:700px;margin-left:50px;" cellpadding="0">
	<tr><td class="Header"colspan="4" >Sales Forecast Vehicle Edit</td></tr>
	<tr><td colspan="4" class="greySpacerLine"></td></tr>
	<tr><td align="left">Vehicle Name: <?php  echo $salesforecastDB->vehicle->VehicleName; ?></td>
		<td align="right">
			<a href="index.php?comp=vehicle&task=vehicle&vehicleid=<?php echo $vehicleid; ?>">
				<img src="media/images/cancel.jpg"  border="0"/></a>
		</td>
	</tr>
	<tr><td colspan="4" class="greySpacerLine"></td></tr>
</table>
<br /><br />
<div class="strong" style="width;600px;margin-left:50px;">
	Sales Forecast:
</div>
<div class="greySpacerLine" style="margin-left:50px;width:700px;line-height:1px;">&nbsp;</div>
<p style="width:600px;margin-left:50px;">
<?php echo $text; ?>
</p>
<div class="greySpacerLine" style="margin-left:50px;width:700px;line-height:1px;">&nbsp;</div>
<div style="width:600px;text-align:right;margin-left:50px;">
	<a href="index.php?comp=vehicle&task=editsalesforecasttext&id=<?php echo $salesforecastDB->row->SFTextID; ?>&vehicleid=<?php echo $vehicleid; ?>">
		<img src="media/images/edit.jpg"  border="0"/></a>
</div>
<br /><br /><br />
<table  border="0" cellspacing="1" cellpadding="0" style="margin-left:50px;width:700px;">
	<tr><td class="strong"colspan="4" >SFS Volume/Body Style Detail (000's):</td></tr>
	<tr><td colspan="40" class="greySpacerLine" ></td></tr>
	<tr>
		<td>
<table border="0" cellspacing="1" cellpadding="2" width="100%">
	<tr class="strong" >
		<td style="width:100px;">Style</td>
		<td align="right">
			<a href="<?php echo $_SERVER[REQUEST_URI]."&sy=".($start_year-$year_change);?>">
				<img src="media/images/cartoonLeft.jpg"  border="0"/></a>
		</td>
		<?php  for($year=$start_year;$year<=$end_year;$year++){
	?>
		<td style="width:40px;" align="center"><?php echo $year; ?></td>
		<?php 
	}
	?>
		<td align="left">
			<a href="<?php echo $_SERVER[REQUEST_URI]."&sy=".($start_year+$year_change);?>">
				<img src="media/images/cartoonRight.jpg"  border="0"/></a>
		</td>
	</tr>
	<?php foreach($salesforecastDB->bodystyles as $name=>$bodystyle){ 
	?>
	<tr  class="greySpacerLine" >
		<td >&nbsp;<?php  echo $name; ?></td>
		<td>&nbsp;</td>
		<?php  for($year=$start_year;$year<=$end_year;$year++){
	?>
		<td  align="right">&nbsp;<?php echo $bodystyle[$year]->SalesValue==0?'0.0':$bodystyle[$year]->SalesValue; ?>&nbsp;</td>
		<?php 
	}
	?>
		<td >&nbsp;</td>
	</tr>
	<tr>
		<td colspan="10" align="right">
			<a href="index.php?comp=vehicle&task=editsales&vehicleid=<?php echo $vehicleid; ?>&bodystyleid=<?php echo $bodystyle['id']; ?>&start_year=<?php echo $start_year; ?>&end_year=<?php echo $end_year; ?>">
				<img src="media/images/edit.jpg" border="0"/></a>
		</td>
	</tr>
	<?php 
	}
	?>
	<tr class="strong">
		<td >Total</td>
		<td>&nbsp;</td>
		<?php  for($year=$start_year;$year<=$end_year;$year++){
	?>
		<td align="right"><?php echo $salesforecastDB->totals[$year]==0?'0.0':sprintf("%01.1f",$salesforecastDB->totals[$year]); ?>&nbsp;</td>
		<?php 
	}
	?>
		<td>&nbsp;</td>
	</tr>
		</td>
	</tr>
</table>
	<tr><td colspan="40" class="greySpacerLine">&nbsp;</td></tr>
</table>
<br /><br /><br />

<?php
	}
}

?>
