<?php 
defined('_VALID_PAGE') or die('Direct access not allowed');
class categoryHTML{
	function search(){
		global $system;

		$system->breadcrumbs['Categories']='';
		$categorys=array(
			'bodystyle'=>'Bodystyle',
			'division'=>'Division',
			'drive'=>'Drive Configuration',
			'make'=>'Make',
			'manufacturer'=>'Manufacturer',
			'seat'=>'Seating Capacity',
			'segment'=>'Segment',
			'service'=>'Service',
			'transmission'=>'Transmission');
?>
<br />
<div class="header" style="margin-left:50px;">Categories</div>
<table style="margin-left:50px;width:500px;" cellpadding="0">
		<tr><td class="greySpacerLine"  colspan="2" ></td>
	<?php foreach($categorys as $key=>$category){?>
	<tr>
		<td style="width:400px;">
			<?php echo $category; ?>
		</td>
		<td>
			<a href="index.php?comp=category&task=list<?php echo $key; ?>">
				<img src="media/images/edit.jpg" border="0" /></a>
		</td>
	</tr>
		<tr><td class="greySpacerLine"  colspan="2" ></td>
	</tr>
	<?php
	 }
	 ?>
</table>
<?php 
	}
	function confirm(){
?>
<br /><br />
<table style="margin-left:50px" cellpadding="0">
		<tr><td class="greySpacerLine"  colspan="20" ></td>
	<tr>
		<td valign="center">
			<?php echo $this->prompt; ?>
			&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
		<td>
			<a href="<?php echo $_SERVER[REQUEST_URI]; ?>&confirm=yes">
				<img src="media/images/yes.jpg" border="0" /></a>
			&nbsp;
			<a href="<?php echo $_SERVER[REQUEST_URI]; ?>&confirm=no">
				<img src="media/images/no.jpg" border="0" /></a>
		</td>
		<tr><td class="greySpacerLine"  colspan="20" ></td>
	</tr>
</table>
<?php 
	}
}
class bodystyleHtml{
	function search(){
		global $system;

		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Bodystyles']='';
		$result = db::getResult('bodystyle','order by name');
?>
<br />
<div class="Header" style="margin-left:50px;">View Bodystyle</div>
<form action="index.php?comp=category&task=editbodystyle" method="post">
<table style="margin-left:50px;width:600px;" cellpadding="0" cellspacing="0">
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>Bodystyle Name:<input type="text" name="name" /></td>
		<td>Abbreviation:<input type="text" name="abbrev" /></td>
		<td><input type="image" name="submit" value="bodystyle" src="media/images/add.jpg" border="0"/></td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php while($row=mysql_fetch_object($result)){
	?>
	<tr>
		<td><?php echo $row->name; ?></td>
		<td><?php echo $row->abbrev; ?></td>
		<td>
			<a href="index.php?comp=category&task=editbodystyle&id=<?php echo $row->bodystyleid; ?>">
				<img src="media/images/edit.jpg" border="0"></a>
			<a href="index.php?comp=category&task=listbodystyle&action=delete_bodystyle&id=<?php echo $row->bodystyleid; ?>">
				<img src="media/images/delete.jpg" border="0"></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php 
	}
	?>
</table>
<br /><br />
<?php 
	}
	function edit(){
				global $system;

		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Bodystyles']='index.php?comp=category&task=listbodystyle';
		
		$bodystyleid=html::getInput($_GET,'id');
		if($bodystyleid){
			if(!$system->errors){
				$row=db::fetchObject('bodystyle',$bodystyleid);
				$this->name=$row->name;
				$this->abbrev=$row->abbrev;
			}
			$image='update';
			$system->breadcrumbs["$this->name"]='';
			$header ='Edit Bodystyle';
		}else{
			$image='add';
			$system->breadcrumbs['Add']='';
			$header ='Add Bodystyle';
		}
?>
<br />
<div class="header" style="margin-left:50px"><?php echo $header; ?></div>
<form action="index.php?comp=category&task=editbodystyle&id=<?php echo $bodystyleid; ?>" method="post">
<table style="margin-left:50px;width:600px;" cellpadding="0">
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td valign="center">
			Bodystyle Name:
			<input type="text" name="name" value="<?php echo $this->name; ?>" />
			Abbreviation:
			<input type="text" name="abbrev" value="<?php echo $this->abbrev; ?>" />
		</td>
		<td valign="center">
			<input type="image" src="media/images/<?php  echo $image; ?>.jpg" border="0" name="submit" value="bodystyle"
				onclick="this.form.submit" />
			<a href="index.php?comp=category&task=listbodystyle">
				<img src="media/images/cancel.jpg" border="0"></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
</form>
<?php 
	}
}
class driveHtml{
	function search(){
		global $system;

		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Drive Configurations']='';
		$result = db::getResult('drive','order by name');
?>
<br />
<div class="header" style="margin-left:50px;">View Drive Configuration</div>
<form action="index.php?comp=category&task=editdrive" method="post">
<table style="margin-left:50px;width:500px;" cellpadding="0">
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>Drive Configuration Name:<input name="name"/></th>
		<td><input type="image" src="media/images/add.jpg" name="submit" value="drive" border="0"/></td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php while($row=mysql_fetch_object($result)){
	?>
	<tr>
		<td><?php echo $row->name; ?></td>
		<td>
			<a href="index.php?comp=category&task=editdrive&id=<?php echo $row->driveid; ?>">
				<img src="media/images/edit.jpg" border="0"></a>
			<a href="index.php?comp=category&task=listdrive&listdrive&action=delete_drive&id=<?php echo $row->driveid; ?>">
				<img src="media/images/delete.jpg" border="0" /></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php
	}
	?>
</table>
</form>
<br /><br />
<?php 
	}
	function edit(){
		global $system;
	
		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Drive Configurations']='index.php?comp=category&task=listdrive';
		
		$driveid=html::getInput($_GET,'id');
		if($driveid){
			if(!$system->errors){
				$row=db::fetchObject('drive',$driveid);
				$this->name=$row->name;
			}
			$image='update';
			$system->breadcrumbs[$this->name]='';
			$header="Edit Drive Configuration";
		}else{
			$image='add';
			$system->breadcrumbs['Add']='';
			$header="Add Drive Configuration";
		}

?>
<br />
<div class="header" style="margin-left:50px"><?php echo $header; ?></div>
<form action="index.php?comp=category&task=editdrive&id=<?php echo $driveid; ?>" method="post">
<table style="margin-left:50px"  cellpadding="0">
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr valign="center">
		<td valign="center">
			Drive Configuration Name:
			<input type="text" name="name" value="<?php echo $this->name; ?>" />
		</td>
		<td valign="center">
			<input type="image" src="media/images/<?php  echo $image; ?>.jpg" border="0" name="submit" value="drive"
				onclick="this.form.submit" />
			<a href="index.php?comp=category&task=listdrive">
				<img src="media/images/cancel.jpg" border="0"></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
</form>
<br />
<?php 
	}
}
class divisionHtml{
	function search(){
		global $system;

		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Divisions']='';
		$result = db::getResult('division','order by name');
?>
<br />
<div class="Header" style="margin-left:50px;">View Division</div>
<form action="index.php?comp=category&task=editdivision" method="post">
<table style="margin-left:50px;width:600px;" cellpadding="0" cellspacing="0">
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>Division Name:<input type="text" name="name" /></td>
		<td><input type="image" src="media/images/add.jpg" name="submit" value="division" border="0"/></td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php while($row=mysql_fetch_object($result)){
	?>
	<tr>
		<td><?php echo $row->name; ?></td>
		<td>
			<a href="index.php?comp=category&task=editdivision&id=<?php echo $row->divisionid; ?>">
				<img src="media/images/edit.jpg" border="0"></a>
			<a href="index.php?comp=category&task=listdivision&action=delete_division&id=<?php echo $row->divisionid; ?>">
				<img src="media/images/delete.jpg" border="0"></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php
	}
	?>
</table>
<br /><br />
<?php 
	}
	function edit(){
		global $system;
	
		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Divisions']='index.php?comp=category&task=listdivision';
		
		$divisionid=html::getInput($_GET,'id');
		if($divisionid){
			if(!$system->errors){
				$row=db::fetchObject('division',$divisionid);
				$this->name=$row->name;
			}
			$image='update';
			$system->breadcrumbs["$this->name"]='';
			$header='Edit Division';
		}else{
			$image='add';
			$system->breadcrumbs['Add']='';
			$header='Add Division';
		}

?>
<br />
<div class="header" style="margin-left:50px"><?php echo $header; ?></div>
<form action="index.php?comp=category&task=editdivision&id=<?php echo $divisionid; ?>" method="post">
<table style="margin-left:50px" cellpadding="0">
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td valign="center">
			Division Name:
			<input type="text" name="name" value="<?php echo $this->name; ?>" />
		</td>
		<td valign="center">
			<input type="image" src="media/images/<?php  echo $image; ?>.jpg" border="0" name="submit" value="division"
				onclick="this.form.submit" />
			<a href="index.php?comp=category&task=listdivision">
				<img src="media/images/cancel.jpg" border="0"></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
</form>
<br />
<?php 
	}
}
class manufactureHtml{
	function search(){
		global $system;

		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Manufacturers']='';
		$result = db::getResult('manufacture','order by name');
?>
<br />
<div class="Header" style="margin-left:50px;">View Manufacturer</div>
<form action="index.php?comp=category&task=editmanufacture" method="post">
<table style="margin-left:50px;width:600px;" cellpadding="0" cellspacing="0">
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>Manufacturer  Name:<input type="text" name="name" /></td>
		<td><input type="image" name="submit" value="manufacture" src="media/images/add.jpg" border="0"/></td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php while($row=mysql_fetch_object($result)){
	?>
	<tr>
		<td><?php echo $row->name; ?></td>
		<td>
			<a href="index.php?comp=category&task=editmanufacturer&id=<?php echo $row->manufactureid; ?>">
				<img src="media/images/edit.jpg" border="0"></a>
			<a href="index.php?comp=category&task=listmanufacturer&action=delete_manufacturer&id=<?php echo $row->manufactureid; ?>">
				<img src="media/images/delete.jpg" border="0"></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php 
	}
	?>
</table>
</form>
<br /><br />
<?php 
	}
	function edit(){
		global $system;
	
		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Manufacturers']='index.php?comp=category&task=listmanufacturer';
		
		$manufactureid=html::getInput($_GET,'id');
		if($manufactureid){
			if(!$system->errors){
				$row=db::fetchObject('manufacture',$manufactureid);
				$this->name=$row->name;
			}
			$image='update';
			$system->breadcrumbs["$this->name"]='';
			$header='Edit Manufacture';
		}else{
			$image='add';
			$system->breadcrumbs['Add']='';
			$header='Add Manufacture';
		}

?>
<br />
<div class="header" style="margin-left:50px"><?php echo $header; ?></div>
<form action="index.php?comp=category&task=editmanufacturer&id=<?php echo $manufactureid; ?>" method="post">
<table style="margin-left:50px" cellpadding="0">
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td valign="center">
			Manufacture Name:
			<input type="text" name="name" value="<?php echo $this->name; ?>" />
		</td>
		<td valign="center">
			<input type="image" src="media/images/<?php  echo $image; ?>.jpg" border="0" name="submit" value="manufacture"
				onclick="this.form.submit" />
			<a href="index.php?comp=category&task=listmanufacturer">
				<img src="media/images/cancel.jpg" border="0"></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
</form>
<br />
<?php 
	}
}
class engineHtml{
	function search(){
		global $system;

		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['View Engine Arrangement']='';
		$result = db::getResult('engine','order by name');
?>
<br />
<div class="Header" style="margin-left:50px;">View Engine Arrangement</div>
<form action="index.php?comp=category&task=editengine" method="post">
<table style="margin-left:50px;width:500px;" cellpadding="0" cellspacing="0">
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	<tr>
		<td>Engine Arrangement: <input name="name"/></td>
		<td><input type="image" src="media/images/add.jpg" name="submit" value="engine" border="0"/></td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php while($row=mysql_fetch_object($result)){
	?>
	<tr>
		<td><?php echo $row->name; ?></td>
		<td>
			<a href="index.php?comp=category&task=editengine&id=<?php echo $row->engineid; ?>">
				<img src="media/images/edit.jpg" border="0"></a>
			<a href="index.php?comp=category&task=listengine&action=delete_engine&id=<?php echo $row->engineid; ?>">
				<img src="media/images/delete.jpg" border="0"></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	<?php
	}
	?>
</table>
</form>
<br /><br />
<?php 
	}
	function edit(){
		global $system;

		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Engine Arrangement']='index.php?comp=category&task=listengine';

		$engineid=html::getInput($_GET,'id');
		if($engineid){
			if(!$system->errors){
				$row=db::fetchObject('engine',$engineid);
				$this->name=$row->name;
			}
			$image='update';
			$system->breadcrumbs["Edit  $this->name"]='';
			$header ='Edit Engine Arrangement';
		}else{
			$image='add';
			$system->breadcrumbs['Add']='';
			$header ='Add Engine Arrangement';
		}
?>
<br />
<div class="header" style="margin-left:50px"><?php echo $header; ?></div>
<form action="index.php?comp=category&task=editengine&id=<?php echo $engineid; ?>" method="post">
<table style="margin-left:50px" cellpadding="0">
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	<tr>
		<td valign="cengter">
			Engine Arrangement Name:
			<input type="text" name="name" value="<?php echo $row->name; ?>" />
		</td>
		<td valign="cengter">
			<input type="image" src="media/images/update.jpg" border="0" name="submit" value="engine"
				onclick="this.form.submit" />
			<a href="<?php echo $_SERVER[HTTP_REFERER]; ?>">
				<img src="media/images/cancel.jpg" border="0"></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
</table>
</form>
<?php 
	}
}
class seatHtml{
	function search(){
		global $system;

		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Seating Capacity']='';
		$result = db::getResult('seat','order by seats');
?>
<br />
<div class="Header" style="margin-left:50px;">View Seating Capacity</div>
<form action="index.php?comp=category&task=editseat" method="post">
<table style="margin-left:50px;width:500px;" cellpadding="0" cellspacing="0">
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>Seating Capacity Name:<input name="seats"/></td>
		<td><input type="image" src="media/images/add.jpg" name="submit" value="seat" border="0"/></td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php while($row=mysql_fetch_object($result)){
	?>
	<tr>
		<td><?php echo $row->seats; ?></td>
		<td>
			<a href="index.php?comp=category&task=editseat&id=<?php echo $row->seatid; ?>">
				<img src="media/images/edit.jpg" border="0"></a>
			<a href="index.php?comp=category&task=listseat&action=delete_seat&id=<?php echo $row->seatid; ?>">
				<img src="media/images/delete.jpg" border="0" /></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php
	}
	?>
</table>
</form>
<br /><br />
<?php 
	}
	function edit(){
		global $system;

		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Seating Capacity']='index.php?comp=category&task=listseat';
		
		$seatid=html::getInput($_GET,'id');
		if($seatid){
			if(!$system->errors){
				$row=db::fetchObject('seat',$seatid);
				$this->seats=$row->seats;
			}
			$image='update';
			$system->breadcrumbs["$row->seats"]='';
			$header='Edit Seating Capacity';
		}else{
			$image='add';
			$system->breadcrumbs['Add']='';
			$header='Add Seating Capacity';
		}
?>
<br />
<div class="header" style="margin-left:50px"><?php echo $header; ?></div>
<form action="index.php?comp=category&task=editseat&id=<?php echo $seatid; ?>" method="post">
<table style="margin-left:50px;width:500px;" cellpadding="0" cellspacing="0">
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td valign="center">
			Seating Capacity Name:
			<input size="5" name="seats" value="<?php echo $this->seats; ?>" />
		</td>
		<td valign="center">
			<input type="image" src="media/images/<?php echo $image; ?>.jpg" border="0" name="submit" value="seat"
				onclick="this.form.submit" />
			<a href="index.php?comp=category&task=listseat">
				<img src="media/images/cancel.jpg" border="0"></a>
	</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
</form>
<?php 
	}
}
class transmissionHtml{
	function search(){
		global $system;

		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Transmissions']='';
		$result = db::getResult('transmission','order by name');
?>
<br />
<div class="Header" style="margin-left:50px;">View Transmission</div>
<form action="index.php?comp=category&task=edittransmission" method="post">
<table style="margin-left:50px;width:600px;" cellpadding="0" cellspacing="0">
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>Transmission Name: <input name="name"/></td><td>Abbreviation: <input name ="abbrev"/></td>
		<td><input type="image" src="media/images/add.jpg" name="submit" value="transmission" border="0"/></td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php while($row=mysql_fetch_object($result)){
	?>
	<tr>
		<td><?php echo $row->name; ?></td>
		<td><?php echo $row->abbrev; ?></td>
		<td>
			<a href="index.php?comp=category&task=edittransmission&id=<?php echo $row->transmissionid; ?>">
				<img src="media/images/edit.jpg" border="0"></a>
			<a href="index.php?comp=category&task=listtransmission&action=delete_transmission&id=<?php echo $row->transmissionid; ?>">
				<img src="media/images/delete.jpg" border="0" /></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	<?php
	}
	?>
</table>
</form>
<?php 
	}
	function edit(){
		global $system;

		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Transmissions']='index.php?comp=category&task=listtransmission';
		
		$transmissionid=html::getInput($_GET,'id');
		if($transmissionid){
			if(!$system->errors){
				$row=db::fetchObject('transmission',$transmissionid);
				$this->name=$row->name;
				$this->abbrev=$row->abbrev;
			}
			$image='update';
			$system->breadcrumbs["$row->name"]='';
			$header='Edit Transmission';
		}else{
			$image='add';
			$system->breadcrumbs['Add']='';
			$header='Add Transmission';
		}

?>
<br />
<div class="header" style="margin-left:50px"><?php echo $header; ?></div>
<form action="index.php?comp=category&task=edittransmission&id=<?php echo $transmissionid; ?>" method="post">
<table style="margin-left:50px" cellpadding="0">
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td valign="center">
			Transmission Name:
			<input name="name" value="<?php echo $this->name; ?>" />
			Abbreviation:
			<input size="5" name="abbrev" value="<?php echo $this->abbrev; ?>" />
		</td>
		<td>
			<input type="image" src="media/images/<?php echo $image; ?>.jpg" border="0" name="submit" value="transmission"
				onclick="this.form.submit" />
			<a href="index.php?comp=category&task=listtransmission">
				<img src="media/images/cancel.jpg" border="0"></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
</form>
<?php 
	}
}
class makeHtml{	
	function search(){
		global $system;
		
		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Makes']='';
		
		$result=db::getResult('make','order by name');
		$manufacture_result=db::getResult('manufacture','order by name')

?>
<br />
<form action="index.php?comp=category&task=editmake" method="post">
	<input type ="hidden" name="submit" value="make"/>
<table style="margin-left:50px;width:700px;" cellpadding="0" cellpadding="0">
	<tr><td class="Header" colspan="10">View Make</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>
			Make: <input name="name"/> 
			Manufacturer: 
			<select name="manufactureid">
				<option value="">Select a Manufacturer</option>
				<?php while($row=mysql_fetch_object($manufacture_result)){
				?>
				<option value="<?php echo $row->manufactureid; ?>"><?php echo $row->name; ?></option>
				<?php
				}
				?>
			</select>
		</td>
		<td align="center"><input type="image" src="media/images/add.jpg" border="0"/></td>
		<td>&nbsp;</td>
	</tr>
	<tr><td colspan="10" class="greySpacerLine" ></td></tr>
	<?php while($row=mysql_fetch_object($result)){
	?>
	<tr>
		<td><?php echo $row->name; ?></td>
		<td align="center">
			<a href="index.php?comp=category&task=editmake&mid=<?php echo $row->makeid; ?>">
				<img src="media/images/edit.jpg" border="0"/></a>
		</td>
		<td align="center">
			<a href="index.php?comp=category&task=listmake&action=delete&mid=<?php echo $row->makeid; ?>">
				<img src="media/images/delete.jpg" border="0"/></a>
		</td>
	</tr>
	<tr><td colspan="10" class="greySpacerLine" ></td></tr>
	</tr>
		<?php 
		}
		?>
</table>
</form>
<br /><br />
<?php 
	}
	
	function edit(){
		global $system,$live_site;
		
		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Makes']='index.php?comp=category&task=listmake';
	
		$makeid=html::getInput($_GET,'mid');
		
		if($makeid){
			$make_row=db::fetchObject('make',$makeid);
			$system->breadcrumbs["$make_row->name"]='';
			$logo_row=db::fetchObjectByColumn('BrandLogo','makeid',$makeid);
			$eautodb= new eautoDB;
			$eautodb->getMakeCategory($makeid);
			$this->name=$make_row->name;
			$image='update';
			$header='Edit Make';
		}else{
			$system->breadcrumbs['Add']='';
			$image='add';
			$header='Add Make';
		}
		$manufacture_result=db::getResult('manufacture','order by name');

?>
<br />
<form action="index.php?comp=category&task=editmake&mid=<?php  echo $makeid; ?>" method="post">
	<input type ="hidden" name="submit" value="make"/>
<table style="margin-left:50px;width:700px;" cellpadding="0" cellspacing="3">
	<tr><td class="Header" colspan="10"><?php  echo $header; ?></td></tr>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	<tr>
		<td>
			Make:
			<input size="30" name="name" value="<?php  echo $this->name; ?>"/>
			Manufacturer:
			<select name="manufactureid">
				<option value="">Select a Manufacturer</option>
				<?php while($row=mysql_fetch_object($manufacture_result)){
					$selected=$row->manufactureid==$make_row->manufactureid?'selected':'';
				?>
				<option value="<?php echo $row->manufactureid; ?>"<?php echo $selected; ?>><?php echo $row->name; ?></option>
				<?php 
				}
				?>
			</select>
		</td>
		<td align="center"><input type="image" src="media/images/<?php  echo $image; ?>.jpg" border="0"/></td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	</tr>
</table>
</form>
<br />
<?php if(!$makeid) {return;}
?>
<form action="index.php?comp=category&task=editmake&mid=<?php  echo $makeid; ?>" method="post" >
	<input type="hidden" name="submit" value="service" />
<table style="margin-left:50px;width:600px;" cellpadding="0" cellspacing="0">
	<tr><td class="Header" colspan="10">Battleground Active Services</td></tr>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	<?php while (list($id, $values) = each ($eautodb->cbg)) {
		$checked=$values['checked']=='checked'?'checked':'';
		$action=$values['checked']=='checked'?'inactive':'active';
	?>
	<tr>
		<td style="width:20px">
			<input type="checkbox" name="service_<?php echo $id; ?>" <?php echo $checked; ?> />
		</td>
		<td><?php echo $values['name']; ?></td>
		<?php if(list($id, $values) = each ($eautodb->cbg)){
		$checked=$values['checked']=='checked'?'checked':'';
		$action=$values['checked']=='checked'?'inactive':'active';?>
		<td style="width:20px">
			<input type="checkbox" name="service_<?php echo $id; ?>" <?php echo $checked; ?> />
		</td>
		<td><?php echo $values['name']; ?></td>
		<?php
		}
		?>
	</tr>
	<?php
	}
	?>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
<br />

<table style="margin-left:50px;width:600px;" cellpadding="0" cellspacing="0">
	<tr><td class="Header" colspan="10">Sales Forecast Active Services</td></tr>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	<?php foreach($eautodb->sfcs as $id=>$values){
		$checked=$values['checked']=='checked'?'checked':'';
		$action=$values['checked']=='checked'?'inactive':'active';
	?>
	<tr>
		<td style="width:20px"><input type="checkbox" name="service_<?php echo $id; ?>"  <?php echo $checked; ?>/>
		</td>
		<td align="left"><?php echo $values['name']; ?></td>
	</tr>
	<?php
	}
	?>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	<tr><td colspan="10" align="right" >
		<input type="image" src="media/images/update.jpg" border="0"/></td>
	</tr>
</table>
</form>		
	
<br />
<table style="margin-left:50px;width:500px;" cellpadding="0" cellspacing="0">
	<tr><td class="Header" colspan="10">Background Text Active Battlegrounds</td></tr>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	<?php foreach($eautodb->cbg_active as $id=>$name){
	?>
	<tr>
		<td><?php echo $name; ?></td>
		<td align="right">
			<a href="index.php?comp=category&task=editmake_text&mid=<?php echo $makeid; ?>&sid=<?php echo $id; ?>">
				<img src="media/images/edit.jpg" border="0"/></a>
		</td>
	<?php
	}
	?>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
<br />
<table style="margin-left:50px;width:500px;" cellpadding="0" cellspacing="0">
	<tr><td class="Header" colspan="10">Background Text Active Sales Forecast</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php foreach($eautodb->sfcs_active as $id=>$name){
	?>
	<tr>
		<td><?php echo $name; ?></td>
		<td align="right">
			<a href="index.php?comp=category&task=editmake_text&mid=<?php echo $makeid; ?>&sid=<?php echo $id; ?>">
				<img src="media/images/edit.jpg" border="0"/></a>
		</td>
	<?php
	}
	?>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
<br />

<form action="index.php?comp=category&task=editmake&mid=<?php echo $makeid; ?>" method="post"  enctype="multipart/form-data">
	<input type ="hidden" name="submit" value="logo"/>
<table style="margin-left:50px;width:500px;" cellpadding="0" cellspacing="3">
	<tr><td class="Header" colspan="10">Logo</td></tr>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
	<tr>
		<td valign="center" align="left">
			<?php if($logo_row->LogoFileName){
			?>
			<img src="<?php  echo $live_site; ?>/media/logos/<?php  echo $logo_row->LogoFileName; ?>" />
			<?php
			 }else{
			 ?>
			<input type="file" name="logo" />
			<?php
			}
			?>
		</td>
		<td valign="center" align="right">
			<?php if(!$logo_row->LogoFileName){
			?>
			<input type="image" src="media/images/upload.jpg"/>
			<?php 
			}else{
			?>
			<a href="index.php?comp=category&task=editmake&action=deletelogo&mid=<?php echo $makeid; ?>">
				<img src="media/images/delete.jpg" border="0"/></a>
			<?php
			}
			?>
		</td>
	</tr>
	<tr><td class="greySpacerLine"  colspan="10"></td></tr>
</table>
</form>
<?php 
	}

	function editText(){
		global $system;
		
		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Makes']='index.php?comp=category&task=listmake';
		$makeid=html::getInput($_GET,'mid');
		$serviceid=html::getInput($_GET,'sid');
		
		$make_row=db::fetchObject('make',$makeid);
		$service_row=db::fetchObject('service',$serviceid);
		$system->breadcrumbs["$make_row->name"]="index.php?comp=category&task=editmake&mid=$makeid";
		$system->breadcrumbs['Background Text']='';

		$eautodb= new eautoDB;
		$eautodb->getServiceMakeText($serviceid,$makeid);
?>
<br />
<form action="index.php?comp=category&task=editmake_text&mid=<?php echo $makeid; ?>&sid=<?php echo $serviceid; ?>" method="POST">
	<input type="hidden"  name="submit" value="AdditionalText"/>
	<input type="hidden" name="AdditionalTextID" value="<?php echo $eautodb->text_row->AdditionalTextID; ?>"/>
<table style="margin-left:50px;width:500px;" cellpadding="0">
	<tr><td class="header" >Edit Background Text</td></tr>
	<tr><td class="greySpacerLine" ></td></tr>
	<tr>
		<td class="strong">
			Background Text for <span class="red">'<?php echo $make_row->name; ?>'</span> in <span class="red">'<?php echo $service_row->name; ?>'</span>:
		</td>
	</tr>
	<tr><td class="greySpacerLine" ></td></tr>
	<tr>
		<td>
			<textarea cols="55" rows="20" name="AdditionalText"><?php echo $eautodb->text_row->AdditionalText; ?></textarea>
		</td>
	</tr>
	<tr>
		<td align="right">
			<a href="index.php?comp=category&task=editmake&mid=<?php echo $makeid; ?>">
				<img src="media/images/cancel.jpg" border="0"/></a>
			<input type="image" src="media/images/update.jpg" border="0"/>
		</td>
	</tr>
</table>
</form>
<br />
<table style="margin-left:50px;width:600px;" cellpadding="0">
	<tr><td class="header" >Press Releases:</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>
	<img src="media/images/active.jpg" border="0" /> = Active&nbsp;&nbsp;&nbsp;&nbsp;
	<img src="media/images/archived.jpg" border="0" /> = Archived&nbsp;&nbsp;&nbsp;&nbsp;
	<img src="media/images/pending.jpg" border="0" /> = Pending
		</td>
		<td>
			<a href="index.php?comp=category&task=editmakepr&mid=<?php echo $makeid; ?>&sid=<?php echo $serviceid; ?>">
				<img src="media/images/add.jpg" border="0"  /></a>
		</td>
	</tr>
	<?php while ($row = mysql_fetch_object($eautodb->result)){
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
		<td>
			<a  href="index.php?comp=category&task=editmakepr&mid=<?php echo $makeid; ?>&cid=<?php echo $row->ContentID; ?>&sid=<?php echo $serviceid; ?>">
				<img src="media/images/edit.jpg" border="0"/></a>
			<a  href="index.php?comp=category&task=editmake_text&action=deletepr&mid=<?php echo $makeid; ?>&cid=<?php echo $row->ContentID; ?>&sid=<?php echo $serviceid; ?>">
				<img src="media/images/delete.jpg" border="0"/></a>
		</td>
	</tr>
	<?php
	}
	?>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
<br />
<?php 
	}
	function editPressrelease(){
		global $system;
		
		require(system::getComponentPath('content','/administration').'/content_html.php');

		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Makes']='index.php?comp=category&task=listmake';
		$makeid=html::getInput($_GET,'mid');
		$ContentID=html::getInput($_GET,'cid');
		$serviceid=html::getInput($_GET,'sid');
	
		$make_row=db::fetchObject('make',$makeid);
		$service_row=db::fetchObject('service',$serviceid);
		$system->breadcrumbs["$make_row->name"]="index.php?comp=category&task=editmake&mid=$makeid";
		$system->breadcrumbs['Background Text']="index.php?comp=category&task=editmake_text&mid=$makeid&sid=$serviceid";

		if($ContentID){
			if(!$system->errors){
				$row=db::fetchObject('content',$ContentID);
				$this->Content=$row->Content;
				$this->ActiveFlag=$row->ActiveFlag;
				$this->PublishDate=$row->PublishDate==''?'':date("F j Y",strtotime($row->PublishDate));
				$this->ArchiveDate=$row->ArchiveDate==''?'':date("F j Y",strtotime($row->ArchiveDate));
			}
			$image='update';
			$system->breadcrumbs['Press Release']='';
			$header='Edit Press Release';
		}else{
			$image='add';
			$header='Add Press Release';
			$system->breadcrumbs['Add Press Release']='';
			$this->ActiveFlag=1;
		}
		$pressreleaseHtml= new pressreleaseHtml;
		$pressreleaseHtml->PublishDate=$this->PublishDate;
		$pressreleaseHtml->ArchiveDate=$this->ArchiveDate;
		$pressreleaseHtml->ActiveFlag=$this->ActiveFlag;
		
?>
<br />
<form action="index.php?comp=category&task=editmakepr&mid=<?php echo $makeid; ?>&cid=<?php echo $ContentID; ?>&sid=<?php echo $serviceid; ?>" method="post">
	<input type="hidden"  name="submit" value="press_release"/>
<table style="margin-left:10px;width:500px;" cellpadding="0">
	<tr><td class="header" ><?php echo $header; ?></td></tr>
	<tr><td class="greySpacerLine" ></td></tr>
	<tr><td><?php  $pressreleaseHtml->dates(); ?></td></tr>
	<tr><td class="greySpacerLine" ></td></tr>
	<tr>
		<td>
			<textarea   name="Content" cols="95" rows="20"><?php echo $this->Content; ?></textarea>
		</td>
	</tr>
	<tr><td class="greySpacerLine" ></td></tr>
	<tr>
		<td align="right">
			<a href="index.php?comp=category&task=editmake_text&mid=<?php echo $makeid; ?>&sid=<?php echo $serviceid; ?>">
				<img src="media/images/cancel.jpg" border="0"/></a>
			<input type="image" src="media/images/<?php echo $image; ?>.jpg" border="0"/>
		</td>
	</tr>
</table>
</form>
	<?php 
	}
}
class segmentHtml{
	function search(){
		global $system;
		
		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Segments']='';
		
		$result=db::getResult('segment','order by name')
	
?>
<br />
<form action="index.php?comp=category&task=listsegment" method="post">
	<input type ="hidden" name="submit" value="segment"/>
<table style="margin-left:50px;width:600px;" cellpadding="0" cellspacing="0">
	<tr><td class="Header" colspan="10">View Segment</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>Segment: <input type="text" name="name" value="<?php  echo $this->name; ?>"/>
			Segment Type: 
			<select name="type">
				<option value="">Select a Segment Type</option>
				<option  value="1">Car</option>
				<option  value="2">Truck</option>
			</select>
		</td>
		<td><input type="image" src="media/images/add.jpg" border="0"/></td>
		<td>&nbsp;</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php while($row=mysql_fetch_object($result)){
	?>
	<tr>
		<td><?php echo $row->name; ?></td>
		<td>
			<a href="index.php?comp=category&task=editsegment&id=<?php echo $row->segmentid; ?>">
				<img src="media/images/edit.jpg" border="0"/></a>
		</td>
		<td>
			<a href="index.php?comp=category&task=listsegment&action=delete&id=<?php echo $row->segmentid; ?>">
				<img src="media/images/delete.jpg" border="0"/></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	</tr>
		<?php
		}
		?>
</table>
</form>
<?php 
	}
	
	function edit(){
		global $system;
		
		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Segments']='index.php?comp=category&task=listsegment';

		$segmentid=html::getInput($_GET,'id');
		if($segmentid){
			$segment_row=db::fetchObject('segment',$segmentid);
			$this->name=$segment_row->name;
			$eautodb= new eautoDB;
			$eautodb->getSegmentCategory($segmentid);
			$system->breadcrumbs["$segment_row->name"]='';
			$segment_row->type==1?
				$car_selected='selected="selected"':
				$truck_selected='selected="selected"';
			$disable=$segmentid==''?'':'disabled="disabled"';
			$header='Edit Segment';
			$image='update';
		}else{
			$header='Add Segment';
			$image='add';
			$system->breadcrumbs["Add"]='';
		}
?>
<br />
<form action="index.php?comp=category&task=editsegment&id=<?php echo $segmentid; ?>" method="post">
	<input type="hidden" name="submit" value="segment" />
<table style="margin-left:50px;width:700px;" cellpadding="0" cellspacing="3">
	<tr ><td class="header" colspan="10" valign="center"><?php echo $header; ?></td></tr>
	<tr  ><td class="greySpacerLine"  colspan="10"></td></tr>
	<tr>
		<td>
			Segment:<input name="name" value="<?php  echo $this->name; ?>"/>
			Segment Type:
				<select <?php  echo $disable; ?> name="type">
					<option value="">Select a Segment Type</option>
					<option value="1" <?php  echo $car_selected; ?> >Car</option>
					<option value="2" <?php  echo $truck_selected; ?> >Truck<option>
				</select>
		</td>
		<td>
			<a style="margin-left:50px;" href="index.php?comp=category&task=listsegment">
				<img src="media/images/cancel.jpg" border="0"/></a>
		</td>
		<td><input type="image" src="media/images/<?php  echo $image; ?>.jpg" border="0"/></td></td>
	</tr>
	<tr ><td  class="greySpacerLine" colspan="10"></td></tr>
</table>
</form>
<br />
<?php  if($segmentid=='')
return;
?>
<form action="index.php?comp=category&task=editsegment&id=<?php echo $segmentid; ?>" method="post">
	<input type="hidden" name="submit" value="service" />
<table style="margin-left:50px;width:500px;" cellpadding="0" cellspacing="0">
	<tr><td class="header" colspan="10">Battleground Active Services</td></tr>
	<tr  ><td  class="greySpacerLine" colspan="10"></td></tr>
	<?php while (list($id, $values) = each ($eautodb->cbg)) {
		$checked=$values['checked']=='checked'?'checked':'';
		$action=$values['checked']=='checked'?'inactive':'active';
	?>
	<tr>
		<td style="width:20px">
			<input type="checkbox" name="service_<?php echo $id; ?>" <?php echo $checked; ?> />
		</td>
		<td align="left"><?php echo $values['name']; ?>
		</td>
		<?php if(list($id, $values) = each ($eautodb->cbg)){
		$checked=$values['checked']=='checked'?'checked="checked"':'';
		$action=$values['checked']=='checked'?'inactive':'active';
	?>
		<td style="width:20px">
			<input type="checkbox" name="service_<?php echo $id; ?>" <?php echo $checked; ?> />
		</td>
		<td  align="left"><?php echo $values['name']; ?>
		</td>
	<?php
	}
	?>
	</tr>
	<?php
	}
	?>
	<tr><td class="greySpacerLine"   colspan="10"></td></tr>
</table>
<br />
<table style="margin-left:50px;width:500px;" cellpadding="0" cellspacing="0">
	<tr><td class="header" colspan="10">Sales Forecast Active Services</td></tr>
	<tr ><td  class="greySpacerLine"  colspan="10"></td></tr>
	<?php foreach($eautodb->sfcs as $id=>$values){
		$checked=$values['checked']=='checked'?'checked="checked"':'';
		$action=$values['checked']=='checked'?'inactive':'active';
	?>
	<tr>
		<td style="width:20px">
			<input type="checkbox" name="service_<?php echo $id; ?>" <?php echo $checked; ?>/>
		</td>
		<td align="left"><?php echo $values['name']; ?></td>
	</tr>
	<?php 
	}
	?>
	<tr ><td  class="greySpacerLine"  colspan="10"></td></tr>
	<tr><td colspan="10" align="right" >
		<input type="image" src="media/images/update.jpg" border="0"/></td>
	</tr>
</table>
</form>
<br />
<table style="margin-left:50px;width:500px;" cellpadding="0" cellspacing="0">
	<tr><td class="header" colspan="10">Background Text Active Battlegrounds</td></tr>
	<tr><td   class="greySpacerLine" colspan="10"></td></tr>
	<?php foreach($eautodb->cbg_active as $id=>$name){
	?>
	<tr>
		<td><?php echo $name; ?></td>
		<td align="right">
			<a href="index.php?comp=category&task=editsegment_text&sgid=<?php echo $segmentid; ?>&sid=<?php echo $id; ?>">
				<img src="media/images/edit.jpg" border="0"/></a>
		</td>
	<?php
	}
	?>
	<tr ><td  class="greySpacerLine"  colspan="10"></td></tr>
</table>
<br />
<table style="margin-left:50px;width:500px;" cellpadding="0" cellspacing="0">
	<tr><td class="header" colspan="10">Background Text Active Sales Forecast</td></tr>
	<tr ><td  class="greySpacerLine" colspan="10"></td></tr>
	<?php foreach($eautodb->sfcs_active as $id=>$name){
	?>
	<tr>
		<td><?php echo $name; ?></td>
		<td align="right">
			<a href="index.php?comp=category&task=editsegment_text&sgid=<?php echo $segmentid; ?>&sid=<?php echo $id; ?>">
				<img src="media/images/edit.jpg" border="0"/></a>
		</td>
	<?php
	}
	?>
	<tr ><td  class="greySpacerLine"  colspan="10"></td></tr>
</table>
<br />
<?php 
	}

	function editText(){
		global $system;
		
		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Segments']='index.php?comp=category&task=listsegment';
		$segmentid=html::getInput($_GET,'sgid');
		$serviceid=html::getInput($_GET,'sid');
		
		$segment_row=db::fetchObject('segment',$segmentid);
		$service_row=db::fetchObject('service',$serviceid);
		$system->breadcrumbs["$segment_row->name"]="index.php?comp=category&task=editsegment&id=$segmentid";
		$system->breadcrumbs['Edit Background Text']='';

		$eautodb= new eautoDB;
		$eautodb->getServiceSegmentText($serviceid,$segmentid);

?>
<br />
<form action="index.php?comp=category&task=editsegment_text&id=<?php echo $segmentid; ?>&sid=<?php echo $serviceid; ?>" method="POST">
	<input type="hidden"  name="submit" value="AdditionalText"/>
	<input type="hidden" name="AdditionalTextID" value="<?php echo $eautodb->text_row->AdditionalTextID; ?>"/>
<table style="margin-left:50px;width:500px;" cellpadding="0">
	<tr><td class="header" >Edit Background Text</td></tr>
	<tr><td class="greySpacerLine" ></td></tr>
	<tr>
		<td class="strong">
			Background Text for <span class="red">'<?php echo $segment_row->name; ?>'</span> in <span class="red">'<?php echo $service_row->name; ?>'</span>:
		</td>
	</tr>
	<tr><td class="greySpacerLine" ></td></tr>
	<tr>
		<td>
			<textarea cols="55" rows="20" name="AdditionalText"><?php echo $eautodb->text_row->AdditionalText; ?></textarea>
		</td>
	</tr>
	<tr>
	<tr>
		<td align="right">
	<a href="index.php?comp=category&task=editsegment&id=<?php echo $segmentid; ?>">
		<img src="media/images/cancel.jpg" border="0"/></a>
	<input type="image" src="media/images/update.jpg" border="0"/>
		</td>
	</tr>
</table>
</form>
<br />
<?php 
return; 
?>
<table style="margin-left:50px;width:600px;" cellpadding="0">
	<tr><td class="header" >Press Releases:</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>
	<img src="media/images/active.jpg" border="0" /> = Active&nbsp;&nbsp;&nbsp;&nbsp;
	<img src="media/images/archived.jpg" border="0" /> = Archived&nbsp;&nbsp;&nbsp;&nbsp;
	<img src="media/images/pending.jpg" border="0" /> = Pending
		</td>
		<td>
	<input type="image" src="media/images/add.jpg" border="0" onclick="" />
		</td>
	</tr>
	<?php if($eautodb->result){
			while ($row = mysql_fetch_object($eautodb->result)){
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
		<td>
			<a  href="index.php?comp=category&task=editpr&mid=<?php echo $makeid; ?>&cid=<?php echo $row->ContentID; ?>&sid=<?php echo $serviceid; ?>">
				<img src="media/images/edit.jpg" border="0"/></a>
		<input type="image" src="media/images/delete.jpg" border="0" onclick="document.vehicleForm.action='vehicles.php?action=deleteVPR&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[id]&edit=$r[ContentID]'" />
		</td>
	</tr>
	<?php 
	}
		}
		?>
</table>
<?php 
	}
}
class serviceHtml{
	function search(){
		global $system;

		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Services']='';
		$result = db::getResult('cbg','order by name');
?>
<br />
<div class="Header" style="margin-left:50px;">View Competitive Battleground</div>
<form action="index.php?comp=category&task=editcbg" method="post">
<table style="margin-left:50px;width:500px;" cellpadding="0" cellspacing="0">
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td>Name:<input name="name"/></td>
		<td><input type="image" src="media/images/add.jpg" name="submit" value="cbg" border="0"/></td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php while($row=mysql_fetch_object($result)){
	?>
	<tr>
		<td><?php echo $row->name; ?></td>
		<td>
			<a href="index.php?comp=category&task=editcbg&cbgid=<?php echo $row->cbgid; ?>">
				<img src="media/images/edit.jpg" border="0"></a>
			<a href="index.php?comp=category&task=listservice&action=delete_cbg&cbgid=<?php echo $row->cbgid; ?>">
				<img src="media/images/delete.jpg" border="0" /></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<?php
	}
	?>
</table>
</form>
<br /><br />
<?php 
	}
	function edit(){
		global $system;

		$system->breadcrumbs['Categories']='index.php?comp=category';
		$system->breadcrumbs['Services']='index.php?comp=category&task=listservice';
		
		$cbgid=html::getInput($_GET,'cbgid');
		$action=html::getInput($_GET,'action');
		if($cbgid){
			$row=db::fetchObject('cbg',$cbgid);
			$this->name=$row->name;
//			if(!$system->errors||$action=='delete_sfcs'){
				$sfcs_row=db::fetchObjectByColumn('sfcs','cbgid',$cbgid);
				if($sfcs_row){
					$this->sfcs_name=$sfcs_row->name;
					$sfcsid=$sfcs_row->sfcsid;
					$sfcs_image='update';
				}else{
					$sfcs_image='add';
				}
//			}
			$image='update';
			$system->breadcrumbs["$row->name"]='';
			$header='Edit Competitive Battleground';
		}else{
			$image='add';
			$system->breadcrumbs['Add']='';
			$header='Add Competitive Battleground';
		}
?>
<br />
<div class="header" style="margin-left:50px"><?php echo $header; ?></div>
<form action="index.php?comp=category&task=editcbg&cbgid=<?php echo $cbgid; ?>" method="post">
	<input type="hidden" name="submit" value="cbg" />
<table style="margin-left:50px;width:600px;" cellpadding="0" cellspacing="0">
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td align="right" valign="center" style="width:160px;">
			Competitive Battleground Name:
		</td>
		<td>
			<input size="40" name="name" value="<?php echo $this->name; ?>" />
		</td>
		<td colspan="2" valign="right"align="right">
			<input type="image" src="media/images/<?php echo $image; ?>.jpg" border="0" 
				onclick="this.form.submit" />
			<a href="index.php?comp=category&task=listservice">
				<img src="media/images/cancel.jpg" border="0"></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
</form>
<?php if($image=='update'){
?>
<form action="index.php?comp=category&task=editcbg&cbgid=<?php echo $cbgid; ?>" method="post">
	<input type="hidden" name="submit" value="sfcs" />
<table style="margin-left:50px;width:600px;" cellpadding="0" cellspacing="0">
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td align="right" valign="center" style="width:160px;">
			Sales Forecast Service Name:
		</td>
		<td>
			<input size="40" name="sfcs_name" value="<?php echo $this->sfcs_name; ?>" />
		</td>
		<td colspan="2" align="right" valign="center">
			<input type="image" src="media/images/<?php echo $sfcs_image; ?>.jpg" border="0" 
				onclick="this.form.submit" />
			<?php if($sfcs_image=='update'){
			?>
			<a href="index.php?comp=category&task=editcbg&action=delete_sfcs&cbgid=<?php echo $cbgid; ?>&sfcsid=<?php echo $sfcsid; ?>">
				<img src="media/images/delete.jpg" border="0" /></a>
			<?php
			}
			?>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
</table>
</form>
<?php
} 
	}
}


?>

