<?php
class adminHTML{
	function listAdmins(){
		global $system;
		
		$system->breadcrumbs['Administrator Access']='';
		$result=db::getResult('administrators','order by name');
		
?>
<br />
<table style="margin-left:50px;" cellpadding="0" cellspacing="0">
	<tr><td class="header">Administrator Access</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<th>Name</th>
		<th>Email</th>
		<th>Username</th>
		<th>Password</th>
		<th><a href="index.php?comp=admin&task=edit"><img src="media/images/add.jpg" border="0"/></a>
			<input type="image" src="media/images/cancel.jpg" border="0"/></a></th>
	</tr>
	<?php while($row=mysql_fetch_object($result)){ ?>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td ><?php echo $row->name; ?></td>
		<td ><?php echo $row->email; ?></td>
		<td ><?php echo $row->username; ?></td>
	
		<td ><?php echo $row->password; ?></td>
		<td width="45" height="24">
			<a href="index.php?comp=admin&task=edit&id=<?php echo $row->id; ?>">
				<img src="media/images/edit.jpg" border="0"/></a>
			<a href="index.php?comp=admin&action=delete&id=<?php echo $row->id; ?>">
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
	function editAdmin(){
		global $system;

		$system->breadcrumbs['Administrator Access']='index.php?comp=admin';
		
		$id=html::getInput($_GET,'id');
		if($id){
			if(!$system->errors){
				$row=db::fetchObjectByColumn('administrators','id',$id);
				$this->name=$row->name;
				$this->email=$row->email;
				$this->username=$row->username;
				$this->password=$row->password;
			}
			$image='update';
			$system->breadcrumbs[$this->username]='';
		}else{
			$image='add';
			$system->breadcrumbs['Add']='';
		}

?>
<br />
<form action="index.php?comp=admin&task=edit&id=<?php echo $id; ?>" method="post">
	<input type="hidden" name="submit" value="admin" />
<table style="margin-left:50px" cellpadding="0" cellspacing="3">
	<tr><td class="header" colspan="10">Administrator Access</td></tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td  align="left">Name:</td><td align="left"><input type="text" name="name" value="<?php echo $this->name; ?>" /></td>
	</tr>
	<tr>
		<td  align="left">Email:</td><td align="left"><input type="text" name="email" value="<?php echo $this->email; ?>" /></td>
	</tr>
	<tr>
		<td  align="left">Username:</td><td align="left"><input type="text" name="username" value="<?php echo $this->username; ?>" /></td>
	</tr>
	<tr>
		<td  align="left">Password:</td><td align="left"><input type="text" name="password" value="<?php echo $this->password; ?>" /></td>
	
	</tr>
	<tr><td class="greySpacerLine" colspan="10"></td></tr>
	<tr>
		<td colspan="10" align="right">
			<a href="index.php?comp=admin">
				<img src="media/images/cancel.jpg" border="0"/></a>
			<input type="image"src="media/images/<?php echo $image; ?>.jpg"/>
		</td>
	</tr>
</table>
</form>
<br />
<?php
	}
	function confirm(){
?>
<br />
<div class="greySpacerLine"   style="margin-left:50px;width:500px;line-height:1px;">&nbsp;</div>
<br />
<table style="margin-left:50px">
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
	</tr>
</table>
<?php
	}
}
?>