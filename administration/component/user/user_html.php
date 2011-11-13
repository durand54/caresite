<?php

defined('_VALID_PAGE') or die('Direct access not allowed');
class userHTML{

	function listSubscribers(){
		global $system;

		$system->breadcrumbs['Subscribers']='';
		$result=db::getResult('subscriberinfo','order by companyName');
?>
<br />
<table cellpadding="0" cellspacing="0" border="0" style="margin-left:50px;width:500px;">
	<tr><td class="header" >Subscribers</td></tr>
	<tr ><td colspan="2" class="greySpacerLine"></td></tr>
	<tr>
		<td >Export Subscribers</td>
		<td align="left">
			<input type="image" src="media/images/export.jpg" border="0"
				onclick="window.open('index.php?comp=user&task=export_subscribers', 'export', 'width=50,height=50');"/>
		</td>
	</tr>
	<tr  ><td colspan="2" class="greySpacerLine"></td></tr>
	<tr>
		<td >Export Users</td>
		<td align="left">
			<input type="image" src="media/images/export.jpg" border="0"
				onclick="window.open('index.php?comp=user&task=export_users', 'export', 'width=50,height=50');"/>
		</td>
	</tr>
	<tr ><td colspan="2" class="greySpacerLine"></td></tr>
	<tr>
		<td >New Subscriber</td>
		<td align="left">
			<a href="index.php?comp=user&task=subscriber">
				<img src="media/images/add.jpg" border="0"/></a>
		</td>
	</tr>
	<?php while($row =mysql_fetch_object($result)){
	?>
	<tr ><td colspan="2" class="greySpacerLine"></td></tr>
	<tr>
		<td><?php echo $row->CompanyName; ?></td>
		<td>
			<a href="index.php?comp=user&task=subscriber&id=<?php echo $row->SubscriberID?>">
				<img src="media/images/edit.jpg" border="0"></a>
			<a href="index.php?comp=user&task=subscriber&action=delete&id=<?php echo $row->SubscriberID?>">
				<img src="media/images/delete.jpg" border="0"></a>
		</td>
	</tr>
	<?php }
	?>
	<tr ><td colspan="2" class="greySpacerLine"></td></tr>
</table>
<br />
<?php
	}
	function subscriber(){
		global $system;

		$system->breadcrumbs['Subscribers']='index.php?comp=user';
		require_once ('include/calendar.php');
		$calendar = new DHTML_Calendar('template/jscalendar/', 'en', 'calendar-win2k-2', false);
		$calendar->load_files();

		$SubscriberID=$this->SubscriberID;
		$submit_image=$SubscriberID==''?'add':'update';
		if($SubscriberID!=''){
			if(!$system->errors){
				$row=db::fetchObjectByColumn('subscriberinfo','SubscriberID',$SubscriberID);
				foreach(get_object_vars($row) as $variable=>$value){
					$this->$variable=$value;
				} 
			}
			$user_result=db::getResultByColumn('user','SubscriberID',$SubscriberID,'order by lastname,firstname');
			$subscriberDB= new subscriberDB;
			$subscriberDB->getSubscriber($SubscriberID);
			$system->breadcrumbs[$this->CompanyName]='';
			
			$users=array();
			while($row=mysql_fetch_object($user_result)){
				if($row->Master){
					$master_row=$row;
				}else{
					$users[]=$row;
				}
			}
		}else{
			$system->breadcrumbs['Add Subscriber']='';
		}

		$today_date=date("Ymd");			
		$nextyear_date=
			date("Ymd",mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1));
		$today_date_format = substr($today_date, 4, 2) . "/" . substr($today_date, 6, 2) . "/" . substr($today_date, 0, 4);
		$nextyear_date_format = substr($nextyear_date, 4, 2) . "/" . substr($nextyear_date, 6, 2) . "/" . substr($nextyear_date, 0, 4);

?>
<br />
<form action="index.php?comp=user&task=subscriber&id=<?php echo $SubscriberID?>" method="post">
	<input type="hidden" name="submit" value="subscriber"/>
<table  cellpadding="0"  style="margin-left:50px;">
	<tr><td class="header" >Edit Subscriber</td></tr>
	<tr ><td colspan="10" class="greySpacerLine"></td></tr>
	<td colspan="2" class="red">* Entry required.</td>
	<td align="right">
			<a href="index.php?comp=user">
				<img src="media/images/cancel.jpg" border="0"/></a>
		<input type="image" src="media/images/<?php echo $submit_image?>.jpg" border="0"/>
		</td>
	</tr>
	<tr ><td colspan="10" class="greySpacerLine"></td></tr>
	<tr>
		<td align="right" >Company Name<span class="red">*</span>:</td>
		<td ><input type="text" name="CompanyName" maxlength="100" size="30" value="<?php echo $this->CompanyName?>"/></td>
	</tr>
	<tr>
		<td align="right" >Address 1<span class="red">*</span>:</td>
		<td ><input type="text" name="Address1" maxlength="255" size="30" value="<?php echo $this->Address1?>"/></td>
	</tr>
	<tr>
		<td align="right" >Address 2:</td>
		<td ><input type="text" name="Address2" maxlength="255" size="30" value="<?php echo $this->Address2?>"/></td>
	</tr>
	<tr>
		<td align="right" >City<span class="red">*</span>:</td>
		<td ><input type="text" name="City" maxlength="50" size="30" value="<?php echo $this->City?>"/></td>
	</tr>
	<tr>
		<td align="right" >State<span class="red">*</span>:</td>
		<td ><input type="text" name="State" maxlength="50" size="30" value="<?php echo $this->State?>"/></td>
	</tr>
	<tr>
		<td align="right" >Zip Code<span class="red">*</span>:</td>
		<td ><input type="text" name="ZipCode" maxlength="15" size="20" value="<?php echo $this->ZipCode?>"/></td>
	</tr>
	<tr>
		<td align="right" >Country<span class="red">*</span>:</td>
		<td ><input type="text" name="Country" maxlength="50" size="30" value="<?php echo $this->Country?>"/></td>
	</tr>
	<tr>
		<td align="right" >Daytime Phone<span class="red">*</span>:</td>
		<td ><input type="text" name="DaytimePhone" maxlength="25" size="30" value="<?php echo $this->DaytimePhone?>"/></td>
	</tr>
	<tr>
		<td align="right" >Evening Phone:</td>
		<td ><input type="text" name="EveningPhone" maxlength="25" size="30" value="<?php echo $this->EveningPhone?>"/></td>
	</tr>
	<tr>
		<td align="right" >Fax:</td>
		<td ><input type="text" name="FaxNumber" maxlength="25" size="30" value="<?php echo $this->FaxNumber?>"/></td>
	</tr>
	<tr>
		<td align="right" >P.O.#/I.D.#:</td>
		<td ><input type="text" name="Identification" maxlength="25" size="30" value="<?php echo $this->Identification?>"/></td>
	</tr>
	<tr>
		<td align="right" >Subscriber Since:</td>
		<td ><input type="text" name="SubscriberSince"  maxlength="50" size="30" value="<?php echo date_format(date_create($this->SubscriberSince),"m/d/Y")?>"/></td>
	</tr>
	<tr>
		<td align="right" valign="top" >History:</td>
		<td ><textarea name="History" cols="35" rows="10"><?php echo $this->History; ?></textarea></td>
	</tr>
	<tr><td colspan="10" class="greySpacerLine"></td></tr>
</table>
</form>
<?php
if($SubscriberID==''){
 return;
}
?>
<br /><br />
<a name="service"></a>
<script >
function toggle(date_input){
	if(document.getElementById('StartDate_'+date_input).disabled){
		document.getElementById('StartDate_'+date_input).disabled=false
		document.getElementById('StartDate_'+date_input).value='<?php echo $today_date_format; ?>'
		document.getElementById('EndDate_'+date_input).disabled=false
		document.getElementById('EndDate_'+date_input).value='<?php echo $nextyear_date_format; ?>'
	}else{
		document.getElementById('StartDate_'+date_input).disabled=true
		document.getElementById('StartDate_'+date_input).value=''
		document.getElementById('EndDate_'+date_input).disabled=true
		document.getElementById('EndDate_'+date_input).value=''
	}
}
</script>
<form action="index.php?comp=user&id=<?php echo $SubscriberID; ?>&task=subscriber#service" method="post">
	<input type="hidden" name="submit" value="service"/>
<table cellpadding="0"  style="margin-left:50px;">
	<tr><td class="header" >Competitive Battleground Services</td></tr>
	<tr ><td colspan="10" class="greySpacerLine"></td></tr>
	<tr>
		<th>&nbsp;</th>
		<th >Subscribe</th>
		<th style="width:100px;">Start Date</th>
		<th style="width:100px;">End Date</th>
	</tr>
	<?php foreach($subscriberDB->cbg as $id=>$cbg){
		$start_date = $end_date='';
		if($cbg['subscribed']){
			$start_date = substr($cbg['StartDate'], 4, 2) . "/" . substr($cbg['StartDate'], 6, 2) . "/" . substr($cbg['StartDate'], 0, 4);
			$end_date = substr($cbg['EndDate'], 4, 2) . "/" . substr($cbg['EndDate'], 6, 2) . "/" . substr($cbg['EndDate'], 0, 4);
		}
		$service_row=db::fetchObjectByColumn('service','cbgid',$id);
	?>
	<tr ><td colspan="10" class="greySpacerLine"></td></tr>
	<tr>
		<td><?php echo $cbg['name']; ?></td>
		<td>
			<input type="checkbox" name="<?php echo $id; ?>" <?php echo $cbg['subscribed']; ?>
				onclick="toggle('<?php echo $id; ?>')"/>
		</td>
		<td>
			<input name="StartDate_<?php echo $id; ?>" id="StartDate_<?php echo $id; ?>" value="<?php echo $start_date; ?>" 
				readonly="readonly" <?php echo $cbg['dates']; ?> style="width: 100px; border: 1px solid #000; text-align: left" />
			<a href="#" id="StartDateButton_<?php echo $id; ?>"><img border="0" src="template/jscalendar/img.gif" alt="" /></a>
		</td>
		<td>
			<input name="EndDate_<?php echo $id; ?>" id="EndDate_<?php echo $id; ?>" value="<?php echo $end_date; ?>" 
				readonly="readonly" <?php echo $cbg['dates']; ?> style="width: 100px; border: 1px solid #000; text-align: left" />
			<a href="#" id="EndDateButton_<?php echo $id; ?>"><img border="0" src="template/jscalendar/img.gif" alt="" /></a>		
		</td>
	</tr>
<script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "StartDate_<?php echo $id; ?>",         // ID of the input field
      ifFormat    : "%m/%d/%Y",    // the date format
      button      : "StartDateButton_<?php echo $id; ?>"       // ID of the button
    }
  );
  Calendar.setup(
    {
      inputField  : "EndDate_<?php echo $id; ?>",         // ID of the input field
      ifFormat    : "%m/%d/%Y",    // the date format
      button      : "EndDateButton_<?php echo $id; ?>"       // ID of the button
    }
  );
</script>
	<?php
	}
	?>
	<tr ><td colspan="10" class="greySpacerLine"></td></tr>
	<tr><td colspan="10">&nbsp;</td></tr>
	<tr><td colspan="10">&nbsp;</td></tr>
	<tr><td class="header" >Sales Forecast Services</td></tr>
	<tr ><td colspan="10" class="greySpacerLine"></td></tr>
	<tr>
		<th>&nbsp;</th>
		<th>Subscribe</th>
		<th style="width:100px;">Start Date</th>
		<th style="width:100px;">End Date</th>
	</tr>
	<?php foreach($subscriberDB->sfcs as $id=>$sfcs){
		$start_date = $end_date='';
		if($sfcs['subscribed']){
			$start_date = substr($sfcs['StartDate'], 4, 2) . "/" . substr($sfcs['StartDate'], 6, 2) . "/" . substr($sfcs['StartDate'], 0, 4);
			$end_date = substr($sfcs['EndDate'], 4, 2) . "/" . substr($sfcs['EndDate'], 6, 2) . "/" . substr($sfcs['EndDate'], 0, 4);
		}
		$service_row=db::fetchObjectByColumn('service','sfcsid',$id);
	?>
	<tr><td colspan="10" class="greySpacerLine"></td></tr>
	<tr>
		<td><?php echo $sfcs['name']; ?></td>
		<td> 
			<input type="checkbox" name="<?php echo $id; ?>" <?php echo $sfcs['subscribed']; ?> 
				onclick="toggle('<?php echo $id; ?>')"/>
		</td>
		<td>
			<input name="StartDate_<?php echo $id; ?>" id="StartDate_<?php echo $id; ?>" value="<?php echo $start_date; ?>" 
				readonly="readonly" <?php echo $sfcs['dates']; ?> style="width: 100px; border: 1px solid #000; text-align: left" />
			<a href="#" id="StartDateButton_<?php echo $id; ?>"><img border="0" src="template/jscalendar/img.gif" alt="" /></a>
		</td>
		<td>
			<input name="EndDate_<?php echo $id; ?>" id="EndDate_<?php echo $id; ?>" value="<?php echo $end_date; ?>" 
				readonly="readonly" <?php echo $sfcs['dates']; ?> style="width: 100px; border: 1px solid #000; text-align: left" />
			<a href="#" id="EndDateButton_<?php echo $id; ?>"><img border="0" src="template/jscalendar/img.gif" alt="" /></a>		
		</td>
	</tr>
<script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "StartDate_<?php echo $id; ?>",         // ID of the input field
      ifFormat    : "%m/%d/%Y",    // the date format
      button      : "StartDateButton_<?php echo $id; ?>"       // ID of the button
    }
  );
  Calendar.setup(
    {
      inputField  : "EndDate_<?php echo $id; ?>",         // ID of the input field
      ifFormat    : "%m/%d/%Y",    // the date format
      button      : "EndDateButton_<?php echo $id; ?>"       // ID of the button
    }
  );
</script>
	<?php
	}
	?>
	<tr ><td colspan="10" class="greySpacerLine"></td></tr>
	<tr>
		<td  colspan="4" align="right">
			<a href="index.php?comp=user">
				<img src="media/images/cancel.jpg" border="0"/></a>
			<input type="image" src="media/images/update.jpg" border="0"/>
		</td>
	</tr>
	<tr ><td colspan="10" class="greySpacerLine"></td></tr>
</table>
</form>
<br /><br />
<a name="user"></a>
<form action="index.php?comp=user&sid=<?php echo $SubscriberID; ?>&task=user" method="post">
<?php
if($master_row){
?>
<table  cellpadding="0" style="margin-left:10px;">
	<tr>
		<td class="header" colspan="10">Master User 
		</td>
	</tr>
	<tr ><td colspan="10" class="greySpacerLine"></td></tr>
	<tr>
		<th  class="strong" style="width:5px;">&nbsp;</th>
		<th  class="strong" style="width:100px;">Last Name</th>
		<th  class="strong" style="width:100px;">First Name</th>
		<th  class="strong" style="width:100px;">Email</th>
		<th  class="strong" style="width:100px;">Username</th>
		<th  class="strong" style="width:100px;">Password</th>
		<td>
			&nbsp;
		</td>
	</tr>
	<tr><td colspan="10"class="greySpacerLine"></td></tr>
	<tr>
		<td valign="center">
			&nbsp;
		</td>
		<td >	<?php echo $master_row->LastName; ?></td>
		<td ><?php echo $master_row->FirstName; ?></td>
		<td ><?php echo $master_row->EmailAddress; ?></td>
		<td ><?php echo $master_row->UserName; ?></td>
		<td ><?php echo $master_row->Password; ?></td>
		<td>
			<a href="index.php?comp=user&task=user&id=<?php echo $master_row->UserID; ?>&sid=<?php echo $SubscriberID; ?>">
				<img src="media/images/edit.jpg" border="0"/></a>
		</td>
	</tr>
	<tr ><td colspan="10" class="greySpacerLine"></td></tr>
</table>
<?php
}
?>
<br />
<table  cellpadding="0" style="margin-left:10px;">
	<tr>
		<td class="header" colspan="10">User Accounts 
		</td>
	</tr>
	<tr ><td colspan="10" class="greySpacerLine"></td></tr>
	<tr>
		<th  class="strong" style="width:5px;">&nbsp;</th>
		<th  class="strong" style="width:100px;">Last Name</th>
		<th  class="strong" style="width:100px;">First Name</th>
		<th  class="strong" style="width:100px;">Email</th>
		<th  class="strong" style="width:100px;">Username</th>
		<th  class="strong" style="width:100px;">Password</th>
		<td>
			<input type="image" src="media/images/add.jpg" border="0" />		
		</td>
	</tr>
	<tr><td colspan="10"class="greySpacerLine"></td></tr>
	<?php foreach($users as $row){
	?>
	<tr>
		<td valign="center">
			&nbsp;
		</td>
		<td >	<?php echo $row->LastName; ?></td>
		<td ><?php echo $row->FirstName; ?></td>
		<td ><?php echo $row->EmailAddress; ?></td>
		<td ><?php echo $row->UserName; ?></td>
		<td ><?php echo $row->Password; ?></td>
		<td>
			<a href="index.php?comp=user&task=user&id=<?php echo $row->UserID; ?>&sid=<?php echo $SubscriberID; ?>">
				<img src="media/images/edit.jpg" border="0"/></a>
			<a href="index.php?comp=user&task=subscriber&action=delete_user&id=<?php echo $SubscriberID; ?>&uid=<?php echo $row->UserID; ?>#user">
				<img src="media/images/delete.jpg" border="0"/></a>
		</td>
	</tr>
	<?php
	}
	?>
	<tr ><td colspan="10" class="greySpacerLine"></td></tr>
</table>
</form>
<br />
<?php
	}

	function confirm(){
?>
<br /><br />
<table style="margin-left:50px" cellpadding="0" >
	<tr ><td colspan="10" class="greySpacerLine"></td></tr>
	<tr>
		<td valign="center">
			<?php echo $this->prompt; ?>
			&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
		<td>
			<a href="<?php echo $_SERVER[REQUEST_URI]; ?>&confirm=yes<?php echo $this->location; ?>">
				<img src="media/images/yes.jpg" border="0" /></a>
			&nbsp;
			<a href="<?php echo $_SERVER[REQUEST_URI]; ?>&confirm=no<?php echo $this->location; ?>">
				<img src="media/images/no.jpg" border="0" /></a>
		</td>
	</tr>
	<tr ><td colspan="10" class="greySpacerLine"></td></tr>
</table>
<?php
	}
	
	function editUser(){
		global $system,$db;
		
		$UserID=html::getInput($_GET,'id');
		$SubscriberID=html::getInput($_GET,'sid');
		$system->breadcrumbs['Subscribers']='index.php?comp=user';
		if($UserID!=''){
			if(!$system->errors){
				$row=db::fetchObjectByColumn('user','UserID',$UserID);
				foreach(get_object_vars($row) as $name=>$variable){
					$this->$name=$variable;
				}
			}
			$submit_image='update';
			$breadcrumb=$this->UserName;
		}else{
			$sid=html::getInput($_GET,'sid');
			$submit_image='add';
			$breadcrumb='Add User';
		}
		$subscriber_row=db::fetchObjectByColumn('subscriberinfo','SubscriberID',$SubscriberID);
		$system->breadcrumbs[$subscriber_row->CompanyName]="index.php?comp=user&task=subscriber&id=$SubscriberID";
		$system->breadcrumbs[$breadcrumb]='';
?>
<script language="javascript">
	function validateMasterUser(checkbox)
	{
		if(checkbox.checked){
			if(!confirm('Are you sure you want to assign this user as Master User?')){
				checkbox.checked=false;
			}
		}
	}
</script>
<br />
<div class="red" style="margin-left:50px;">* Entry required.</div>
<form action="index.php?comp=user&task=user&id=<?php echo $UserID; ?>&sid=<?php echo $SubscriberID; ?>" method="post">
	<input type="hidden" name="submit" value="user"/>
<table style="margin-left:50px" cellpadding="0">
	<tr><td class="header" >Edit User</td></tr>
	<tr ><td colspan="10" class="greySpacerLine"></td></tr>
	<? /* if(!$this->Master){?>
	<tr>
		<td align="right" >Master: NOT HERE</td>
		<td align="left"><input type="checkbox" name="Master" onclick="validateMasterUser(this)"/></td>
	</tr>
	<?}else{?>
	<tr>
		<td align="right" >&nbsp;</td>
		<td >Master User</td>
	</tr>
	<?}*/?>
	<tr>
		<td align="right" >First Name<span class="red">*</span> First Name:</td>
	
		<td ><input type="text" name="FirstName" maxlength="50" size="30" value="<?php echo $this->FirstName?>"/></td>
	</tr>
	<tr>
		<td align="right" >Middle Initial:</td>
	
		<td ><input type="text" name="MiddleInitial" maxlength="50" size="5" value="<?php echo $this->MiddleInitial?>"/></td>
	</tr>
	<tr>
		<td align="right" >Last Name<span class="red">*</span>:</td>
		<td ><input type="text" name="LastName" maxlength="50" size="30" value="<?php echo $this->LastName?>"/></td>
	</tr>
	<tr>
		<td align="right" >Title:</td>
		<td ><input type="text" name="Title" maxlength="50" size="30" value="<?php echo $this->Title?>"/></td>
	</tr>
	<tr>
		<td align="right" >Phone Number:</td>
		<td ><input type="text" name="PhoneNumber" maxlength="50" size="30" value="<?php echo $this->PhoneNumber?>"/></td>
	</tr>
	<tr>
		<td align="right" >Email<span class="red">*</span>:</td>
	
		<td ><input type="text" name="EmailAddress" maxlength="50" size="30" value="<?php echo $this->EmailAddress?>"/></td>
	</tr>
	<tr>
		<td align="right" >Username<span class="red">*</span>:</td>
	
		<td ><input type="text" name="UserName" maxlength="50" size="30" value="<?php echo $this->UserName?>"/></td>
	</tr>
	<tr>
		<td align="right" >Password<span class="red">*</span>:</td>
	
		<td ><input type="text" name="Password" maxlength="50" size="30" value="<?php echo $this->Password?>"/></td>
	</tr>
	<tr ><td colspan="10" class="greySpacerLine"></td></tr>
	<tr>
		<td colspan="10" align="right">
			<a href="index.php?comp=user&task=subscriber&id=<?php echo $SubscriberID?>">
				<img src="media/images/cancel.jpg" border="0"/></a>
			<input  type="image" src="media/images/<?php echo $submit_image?>.jpg"/>
		</td>
	</tr>
</table>
</form>
<?php
	}
	function preferences(){
		global $system,$my;
		
		$system->breadcrumbs['Matrix Preferences']='';
		if(!$system->errors){
			$result=db::getResult('matrixprefs');
			while($row=mysql_fetch_object($result)){
				$this->{$row->PrefName}=$row->PrefValue;
			}
		}
?>
<br />
<form action="index.php?comp=user&task=preferences" method="POST">
	<input type="hidden" name="submit" value="preferences" />
<table border="0" cellspacing="3" cellpadding="0"	style="width:400px;margin-left:50px;">
<tr><td class="header">Matrix Preferences</td><td>&nbsp;</td>
<tr><td class="greySpacerLine" colspan="2"></td></tr>
<tr>
	<td >Default beginning year:</td>
	<td  align="right"><input type="text" name="BegYear" value="<?php echo $this->BegYear?>" /></td>
</tr>
<tr><td class="greySpacerLine" colspan="2"></td></tr>
<tr>
	<td >Number of years to move per click:</td>
	<td  align="right"><input type="text" name="YearIncrement" value="<?php echo $this->YearIncrement?>" /></td>
</tr>
<tr><td class="greySpacerLine" colspan="2"></td></tr>
</table>
	<input style="margin-left:50px;" type="image" src="media/images/update.jpg"/>
</form>

<?php
	}
	function exportSubscribers(){
		$result=db::getResult('subscriberinfo','order by CompanyName');
		header("Content-Type: application/csv");
		header("Content-Disposition: attachment; filename=MasterClientList.csv"); 
?>
"Name","Company Name","Address","Phone Number","Email","North American","SFS: U.S.","Concept Cars","Latin American","Intl European","Intl Asian","Intl China"
<?php 
while($subscriber_row=mysql_fetch_object($result)){
$query="select * from accesslevel  ";
	$query.="where SubscriberID = '$subscriber_row->SubscriberID' and serviceid='1' ";
	$NA_CBG_expire_row=db::executeFetchObject($query);
	$NA_CBG_enddate=$NA_CBG_expire_row->EndDate?date("F j, Y",strtotime($NA_CBG_expire_row->EndDate)):"";
	
	$query="select * from accesslevel  ";
	$query.="where SubscriberID = '$subscriber_row->SubscriberID' and serviceid='3' ";
	$NA_SFCS_expire_row=db::executeFetchObject($query);
	$NA_SFCS_enddate=$NA_SFCS_expire_row->EndDate?date("F j, Y",strtotime($NA_SFCS_expire_row->EndDate)):"";
	
	$query="select * from accesslevel  ";
	$query.="where SubscriberID = '$subscriber_row->SubscriberID' and serviceid='6' ";
	$concept_expire_row=db::executeFetchObject($query);
	$concept_enddate=$concept_expire_row->EndDate?date("F j, Y",strtotime($concept_expire_row->EndDate)):"";
	
	$query="select * from accesslevel  ";
	$query.="where SubscriberID = '$subscriber_row->SubscriberID' and serviceid='2' ";
	$LA_CBG_expire_row=db::executeFetchObject($query);
	$LA_CBG_enddate=$LA_CBG_expire_row->EndDate?date("F j, Y",strtotime($LA_CBG_expire_row->EndDate)):"";
	
	$query="select * from accesslevel  ";
	$query.="where SubscriberID = '$subscriber_row->SubscriberID' and serviceid='4' ";
	$IE_CBG_expire_row=db::executeFetchObject($query);
	$IE_CBG_enddate=$IE_CBG_expire_row->EndDate?date("F j, Y",strtotime($IE_CBG_expire_row->EndDate)):"";
	
	$query="select * from accesslevel  ";
	$query.="where SubscriberID = '$subscriber_row->SubscriberID' and serviceid='5' ";
	$IA_CBG_expire_row=db::executeFetchObject($query);
	$IA_CBG_enddate=$IA_CBG_expire_row->EndDate?date("F j, Y",strtotime($IA_CBG_expire_row->EndDate)):"";
	
	$query="select * from accesslevel  ";
	$query.="where SubscriberID = '$subscriber_row->SubscriberID' and serviceid='7' ";
	$IC_CBG_expire_row=db::executeFetchObject($query);
	$IC_CBG_enddate=$IC_CBG_expire_row->EndDate?date("F j, Y",strtotime($IC_CBG_expire_row->EndDate)):"";
	
	
	$csv_line='';
	$master_row=db::fetchObjectByColumns('user',
		array('SubscriberID'=>$subscriber_row->SubscriberID,'Master'=>1));
	$csv_line.=userHTML::csvField("$master_row->FirstName $master_row->LastName");
	$csv_line.=userHTML::csvField("$subscriber_row->CompanyName");
	$csv_line.=userHTML::csvField("$subscriber_row->Address1 $subscriber_row->Address2 $subscriber_row->City $subscriber_row->State $subscriber_row->ZipCode $subscriber_row->Country");
	$csv_line.=userHTML::csvField("$subscriber_row->DaytimePhone");
	$csv_line.=userHTML::csvField("$subscriber_row->Email");
	$csv_line.=userHTML::csvField("$NA_CBG_enddate");
	$csv_line.=userHTML::csvField("$NA_SFCS_enddate");
	$csv_line.=userHTML::csvField("$concept_enddate");
	$csv_line.=userHTML::csvField("$LA_CBG_enddate");
	$csv_line.=userHTML::csvField("$IE_CBG_enddate");
	$csv_line.=userHTML::csvField("$IA_CBG_enddate");
	$csv_line.=userHTML::csvField("$IC_CBG_enddate");
	$csv_line=rtrim($csv_line,',');
	echo $csv_line;
}
?>

<?php
}
	}
	function exportUsers(){
		$result=userDB::get();
		
		header("Content-Type: application/csv");
		header("Content-Disposition: attachment; filename=MasterUserList.csv"); 

?>
"Name","Company Name","Email","Username","Password","Phone Number","Expire","Master"
<?php
while($user_row=mysql_fetch_object($result)){
	if($user_row->subscription_enddate){
		$subscription_enddate=date_format(date_create($user_row->subscription_enddate),"m/d/Y");
	}else{
		$subscription_enddate=='';
	}
	$csv_line='';
	$subscriber_row=db::fetchObjectByColumn('subscriberinfo','SubscriberID',$user_row->SubscriberID);
	$csv_line.=userHTML::csvField("$user_row->FirstName  $user_row->LastName");
	$csv_line.=userHTML::csvField("$subscriber_row->CompanyName");
	$csv_line.=userHTML::csvField("$user_row->EmailAddress");
	$csv_line.=userHTML::csvField("$user_row->UserName");
	$csv_line.=userHTML::csvField("$user_row->Password");
	$csv_line.=userHTML::csvField("$user_row->PhoneNumber");
	$csv_line.=userHTML::csvField("$subscription_enddate");
	if($user_row->Master){
		$csv_line.=userHTML::csvField("Master");
	}else{
		$csv_line.=userHTML::csvField("");
	}
	$csv_line=rtrim($csv_line,',');
	echo $csv_line;
	}
?>

<?php
//}
//	}
	
	function csvField($value){
		return "\"$value\",";
	}
}

?>
