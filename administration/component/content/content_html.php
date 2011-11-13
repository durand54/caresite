<?php
defined('_VALID_PAGE') or die('Direct access not allowed');
class contentHTML{
			function confirm(){
?>
<br />
<table style="margin-left:50px;width:500px;" cellpadding="0" cellspacing="0">
	<tr><td class="header" colspan="2"><?php echo $this->header; ?></td></tr>
	<tr><td class="greySpacerLine"  colspan="2"></td></tr>
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
	<tr><td class="greySpacerLine" colspan="2"></td></tr>
</table>
<?php
	}
	function executiveSummary(){
		global $system;
		
		$system->breadcrumbs['Edit Executive Summary']='';

?>
<br />
<div class="greySpacerLine" style="margin-left:50px;line-height:1px;width:500px">&nbsp;</div>
<br />
<?php
	}
}
class fileHtml{
	function search(){
		global $system;
		
		$system->breadcrumbs['Upload Files']='';
		$files_result=db::getResult('files','order by FileCaption');
?>
<br />
<table style="margin-left:50px;;width:500px" cellpadding="0" cellspacing="0">
	<tr><td class="header">Upload Files</td><td>&nbsp;</td>
	<tr><td class="greySpacerLine"  colspan="2"></td></tr>
	<tr>
		<td style="width:390px;">New File</td>
		<th align="left" style="width:110px;">
			<a href="index.php?comp=content&task=file_entry" >
				<img src="media/images/add.jpg" border="0" /></a>
		</th>
	</tr>
	<?php while($row=mysql_fetch_object($files_result)){ ?>
	<tr><td style="background-color:#cccccc;line-height:1px" colspan="2" ><img src="/media/images/spacer.gif" height="1" border="0" /></td>
	</tr>
	<tr>
		<td ><?php echo $row->FileCaption; ?></td>
		<td align="left">
			<a href="index.php?comp=content&task=file_entry&id=<?php echo $row->FileID; ?>" >
				<img src="media/images/edit.jpg" border="0" /></a>
			<a href="index.php?comp=content&task=files&action=delete&id=<?php echo $row->FileID; ?>" >
				<img src="media/images/delete.jpg" border="0" /></a>
		</td>
	</tr>
	<?php }
	?>
</table>
<?php
	}
	function edit(){
		global $system;
		
		$system->breadcrumbs['Upload Files']='index.php?comp=content&task=files';
		$id=html::getInput($_REQUEST,'id');
		if($id!=''){
			$row=db::fetchObjectByColumn('files','FileID',$id);
			$this->FileCaption=$row->FileCaption;
			$this->serviceid=$row->serviceid;
			$image='update';
			$system->breadcrumbs[$this->FileCaption]='';
			$header='Edit File';
			$all_selected=$this->serviceid==0?'selected="selected"':'';
		}else{
			$image='add';
			$system->breadcrumbs['Add File']='';
			$header='New File';
		}
		$service_result=db::getResult('service','order by name');
?>
<br />
<form action="index.php?comp=content&task=file_entry&id=<?php echo $id; ?>" method="post" enctype="multipart/form-data" >
	<input type="hidden" name="submit" value="file" />
<table style="margin-left:50px;;width:500px" cellpadding="0" cellspacing="3">
	<tr><td class="Header"><?php echo $header; ?></td><td>&nbsp;</td></tr>
	<tr><td class="greySpacerLine" colspan="2"></td></tr>
	<tr><td colspan="2"><span class="red">* Entry required.</span></td></tr>
	<tr>
		<td align="right" >Upload File<span class="red">*</span>:</td>
		<td ><input type="file" name="file" /></td>
	</tr>
	<?php if($id){
	?>
	<tr>
		<td align="right" >File:</td>
		<td ><?php echo $row->SourceFileName; ?></td>
	</tr>
	<tr>
		<td align="right" >Size:</td>
		<td ><?php echo $row->FileSize; ?>Kb</td>
	</tr>
	<?php }
	?>
	<tr>
		<td align="right" >File Caption<span class="red">*</span>:</td>
	
		<td ><input type="text" name="FileCaption" maxlength="100" size="30" value="<?php echo  $this->FileCaption; ?>"/> (Spaces OK)</td>
	</tr>
	<tr>
		<td align="right" >Service<span class="red">*</span>:</td>
		<td>
			<select name="serviceid">
				<option value="" >-- Select Service --</option>
				<option value="0" <?php echo $all_selected; ?>>All Services</option>
				<?php 
				html::selectOptions($service_result,'name','serviceid',$this->serviceid);
				?>	
			</select>
		</td>
	</tr>
	<tr><td>&nbsp;</td><td colspan="2">Push button once: Large Files may take a while to upload.</td></tr>
	<tr><td colspan="2" class="greySpacerLine" ></td></tr>
	<tr>
		<td align="right" colspan="2" >
			<a href="index.php?comp=content&task=files" >
				<img src="media/images/cancel.jpg" border="0" /></a>
			<input type="image" src="media/images/<?php echo $image; ?>.jpg" />
		</td>
	</tr>
</table>
<?php
	}
	
}

class backgroundHtml{
	function search(){
		global $system;
		
		$system->breadcrumbs['Background Information']='';
		return;
?>

<div style="margin-top:100px;width:600px;text-align:center">
<a href="index.php?comp=content&task=background_edit&type=M" >
		<img src="media/images/methodology.jpg" border="0" /></a>
<a href="index.php?comp=content&task=background_edit&type=ROS" >
		<img src="media/images/rationale.jpg" border="0" /></a>
<a href="index.php?comp=content&task=executive_summary" >
		<img src="media/images/executive.jpg" border="0" /></a>
</div>
<?php
	}
	function searchExecutiveSummary(){
		global $system,$live_site;

		$system->breadcrumbs['Background Information']='index.php?comp=content&task=background';
		$system->breadcrumbs['Executive Summary']='';
		$result=db::getResultByColumn('content','type','ES','and DeleteFlag<>1 order by PublishDate desc');
		$this->publish_date=date("F d Y");
?>
<br />
<form action="index.php?comp=content&task=executive_summary" method="post" enctype="multipart/form-data" >
	<input type="hidden" name="submit" value="ES" />
<table border="0" cellspacing="3" cellpadding="0"	style="width:600px;margin-left:50px;">
	<tr><td class="header">Executive Summary</td><td>&nbsp;</td>
	<tr><td class="greySpacerLine" colspan="2"></td></tr>
	<tr>
		<td>
			Publish Date: 
			<?php $this->publishDate(); ?>
			<input type="file" name="Content"/>	
		</td>
		<td align="left">
			<input style="margin-left:50px;" type="image" src="media/images/add.jpg"/>
		</td>
	</tr>
	<tr><td class="greySpacerLine"colspan="2"></td></tr>
	<?php while($row=mysql_fetch_object($result)){
			$position=strpos($row->Content,"<trunc>");
			if($position===false){
				$this->title='Download PDF';
				$file=$row->Content;
			}else{
				$this->title=substr($row->Content,0,$position);
				$file=substr($row->Content,$position+7);
			}
	
	?>
	<tr>
		<td><?php echo $this->title; ?> - <?php echo strftime("%m/%d/%Y",strtotime($row->PublishDate)); ?>
		</td>
		<td align="left">
			<a href="index.php?comp=content&task=edit_summary&id=<?php echo $row->ContentID; ?>" >
				<img src="media/images/edit.jpg" border="0" /></a>
			<a href="index.php?comp=content&task=executive_summary&action=delete&id=<?php echo $row->ContentID; ?>" >
				<img src="media/images/delete.jpg" border="0" /></a>
		</td>
	</tr>
	<tr><td class="greySpacerLine" colspan="2"></td></tr>
	<?php 
	}
	?>
</table>
</form>
<?php
	}
	function editExecutiveSummary(){
		global $system,$live_site;

		$system->breadcrumbs['Background Information']='index.php?comp=content&task=background';
		$system->breadcrumbs['Executive Summary']='index.php?comp=content&task=executive_summary';
		
		if(!$system->errors){
			$this->ContentID=html::getInput($_GET,'id');
		}
		$row=db::fetchObjectByColumn('content','ContentID',$this->ContentID);
		if(!$system->errors){
			$this->PublishDate=$row->PublishDate;
			$position=strpos($row->Content,"<trunc>");
			if($position===false){
			}else{
				$this->title=substr($row->Content,0,$position);
			}
		}
		if($this->ContentID){
			$header ='Edit Executive Summary';
			$image='update';
		}else{
			$header ='Add Executive Summary';
			$image='add';
		}
		$system->breadcrumbs[$header]='';
		
		$this->publish_date=date("F d Y",strtotime($this->PublishDate));
?>
<br />
<form action="index.php?comp=content&task=edit_summary&id=<?php echo $this->ContentID; ?>" method="post" enctype="multipart/form-data" >
	<input type="hidden" name="submit" value="ES" />
<table style="margin-left:50px;width:500px" cellpadding="0">
	<tr><td class="header" colspan="10"><?php echo $header; ?></td></tr>
	<tr><td style="background-color:#cccccc;line-height:1px" colspan="2" >&nbsp;</td></tr>	
	<tr>
		<td align="right">
			Publish Date: 
		</td>
		<td align="left">
			<?php $this->publishDate(); ?>
		</td>
	</tr>
	<tr><td style="background-color:#cccccc;line-height:1px" colspan="2" >&nbsp;</td></tr>	
	<tr>
		<td  colspan="2"  align="left">
			<a href="<?php echo $live_site; ?>/media/execsumm/<?php echo $row->Content; ?>">View PDF</a>
			<br /><br />
		</td>
	</tr>
	<tr>
		<td align="right">
			Title: 
		</td>
		<td align="left">
			<input name="title" value="<?php echo $this->title; ?>"/>	
		</td>
	</tr>
	<tr>
		<td align="right">
			File: 
		</td>
		<td align="left">
			<input type="file" name="Content"/>	
			<br /><br />
		</td>
	</tr>
	<tr><td style="background-color:#cccccc;line-height:1px" colspan="2" >&nbsp;</td></tr>	
	<tr>
		<td align="right" colspan="10">
			<a href="index.php?comp=content&task=executive_summary" >
				<img src="media/images/cancel.jpg" border="0" /></a>
			<input type="image" src="media/images/<?php echo $image; ?>.jpg" border="0" />
		</td>
	</tr>
</table>
</form>

<?php
	}

	function publishDate(){
		require_once ('include/calendar.php');
		$calendar = new DHTML_Calendar('template/jscalendar/', 'en', 'calendar-win2k-2', false);
		$calendar->load_files();

?>
			<input style="width: 120px; border: 1px solid #000; text-align: left" 
				id="PublishDate" name="PublishDate" value="<?php echo   $this->publish_date; ?>" readonly="readonly"/>
			<a href="#" id="PublishDateTrigger"><img align="middle" border="0" src="template/jscalendar/img.gif" alt="" /></a>
<script type="text/javascript">
  Calendar.setup(
    { 
      inputField  : "PublishDate",         // ID of the input field
      ifFormat    : "%B %e %Y",    // the date format
      button      : "PublishDateTrigger"       // ID of the button
    }
  );
</script>
<?php
	}
	
	function edit(){
		global $system;
		
		
		$type=html::getInput($_GET,'type');
		$system->breadcrumbs['Background Information']='index.php?comp=content&task=background';
		switch($type){
			case 'M':
				$system->breadcrumbs['Methodology']='';
				$header='Edit Methodology';
				$submit='M';
				break;
			case 'ROS':
				$system->breadcrumbs['Rationale of Segmentation']='';
				$header='Edit Rationale of Segmentation';
				$submit='ROS';
				break;
			case 'ES':
				$system->breadcrumbs['Executive Summary']='';
				break;
		}
		$row=db::fetchObjectByColumn('content','Type',$type);
?>
<br />
<form action="index.php?comp=content&task=background" method="post">
	<input type="hidden" name="submit" value="<?php echo $submit; ?>" />
<table style="margin-left:10px;width:500px" cellpadding="0">
	<tr><td class="header"><?php echo $header; ?></td></tr>
	<tr><td style="background-color:#cccccc;line-height:1px" colspan="2" >&nbsp;</td>	
	<tr><td>
			<textarea name="Content" cols="95" rows="20"><?php echo $row->Content; ?></textarea>
		</td>
	</tr>
	<tr><td style="background-color:#cccccc;line-height:1px" colspan="2" >&nbsp;</td>
	<tr>
		<td align="right">
			<a href="index.php?comp=content&task=background" >
				<img src="media/images/cancel.jpg" border="0" /></a>
			<input type="image" src="media/images/update.jpg" border="0"/>
		</td>
	</tr>
</table>
</form>
<?php

	}
}
class pressreleaseHtml{
	function search(){
		global $system;

		$system->breadcrumbs['Press Releases']='';
		$result=db::getResultByColumns('content',array('type'=>'HPR','DeleteFlag'=>0),'order by PublishDate desc');
?>
<br />
<table style="margin-left:50px;width:600px" cellpadding="0" cellspacing="0">
	<tr><td class="header">AutoPacific Press Releases</td></tr>
	<tr><td style="background-color:#cccccc;line-height:1px" colspan="2" >&nbsp;</td>	
	<tr>
		<th align="left">
			<img src="media/images/active.jpg" border="0" /> = Active
			<img src="media/images/archived.jpg" border="0" /> = Archived
			<img src="media/images/pending.jpg" border="0" /> = Pending
		</th>
		<th align="right">
			<a href="index.php?comp=content&task=pressrelease" >
				<img src="media/images/add.jpg" border="0" /></a>
			<a href="index.php" >
				<img src="media/images/cancel.jpg" border="0" /></a>
		</th>
	</tr>
	<?php while($row=mysql_fetch_object($result)){
		if(date("Ymd") >= $row->PublishDate && $row->ArchiveDate==''){
			$status='active';
		}else if(date("Ymd") >= $row->PublishDate && date("Ymd") <= $row->ArchiveDate){
			$status='active';
		}else if(date("Ymd") <= $row->PublishDate){
			$status='pending';
		}else{
			$status='archived';
		};
	?>
	<tr><td style="background-color:#cccccc;line-height:1px" colspan="2" >&nbsp;</td>
	</tr>
	<tr>
		<td>
			<img src="media/images/<?php echo $status; ?>.jpg" border="0" />
			<?php echo substr($row->Content, 0, 75); ?>...</td>
		<td align="right">
			<a href="index.php?comp=content&task=pressrelease&id=<?php echo $row->ContentID; ?>" >
				<img src="media/images/edit.jpg" border="0" /></a>
			<a href="index.php?comp=content&task=press_releases&action=delete&id=<?php echo $row->ContentID; ?>" >
				<img src="media/images/delete.jpg" border="0" /></a>
		</td>
	</tr>
	<?php 
	}
	?>
</table>
<?php
	}

	function edit(){
			global $system;
			

		$system->breadcrumbs['Press Releases']='index.php?comp=content&task=press_releases';

		$ContentID=html::getInput($_GET,'id');		
		if($ContentID){
			if(!$system->errors){
				$row=db::fetchObject('content',$ContentID);
				$this->Content=$row->Content;
				$this->ActiveFlag=$row->ActiveFlag;
				$this->PublishDate=$row->PublishDate==''?'':date("F j Y",strtotime($row->PublishDate));
				if($row->ArchiveDate!=''){
					$this->ArchiveDate=$row->ArchiveDate==''?'':date("F j Y",strtotime($row->ArchiveDate));
				}
			}
			$image='update';
			$offset=strpos($this->Content,'<trunc>');
			$crumb=substr($this->Content,0,$offset);
			$system->breadcrumbs[$crumb]='';
		}else{
			$image='add';
			$system->breadcrumbs['Add']='';
		}
		$active=$this->ActiveFlag?'':'checked';
		
		$pressreleaseHtml= new pressreleaseHtml;
		$pressreleaseHtml->PublishDate=$this->PublishDate;
		$pressreleaseHtml->ArchiveDate=$this->ArchiveDate;
		$pressreleaseHtml->ActiveFlag=$this->ActiveFlag;
		
?>
<br />
<form action="index.php?comp=content&task=pressrelease&id=<?php echo  $ContentID; ?>" method="post">
	<input type="hidden"  name="submit" value="press_release"/>
<table style="margin-left:10px;width:600px" cellpadding="0" cellspacing="0">
	<tr><td class="header">Edit Press Releases</td></tr>
	<tr><td style="background-color:#cccccc;line-height:1px" colspan="2" >&nbsp;</td>	
	<tr><td><?php $pressreleaseHtml->dates(); ?></td></tr>
	<tr><td><textarea name="Content" cols="95" rows="20"><?php echo $this->Content; ?></textarea></td></tr>
	<tr>
		<td align="right">
			<a href="index.php?comp=content&task=press_releases">
				<img src="media/images/cancel.jpg" border="0"/></a>
			<input type="image"  src="media/images/<?php echo $image; ?>.jpg" border="0" />
		</td>
	</tr>
</table>
</form>
	<?php
	}
	function dates(){
		require_once ('include/calendar.php');
		$calendar = new DHTML_Calendar('template/jscalendar/', 'en', 'calendar-win2k-2', false);
		$calendar->load_files();
		if($this->ArchiveDate==''){
			$this->ArchiveDate=date("F j Y",mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1));
			$archive_disabled="disabled";
		}
		if($this->PublishDate==''){
			$this->PublishDate=date("F j Y");
		}
		if($this->ActiveFlag){
			$archive_disabled='disabled="disabled"';
		}else{
			$archive='checked="checked"';
		}
?>
<script type="text/javascript">
  function archive()
    { 
    	triggerObj=document.getElementById('ArchiveDateTrigger');
    	dateObj=document.getElementById('ArchiveDate');
			if(dateObj.disabled){
//				triggerObj.style.display='inline';
				dateObj.disabled=false;				
			}else{
//				triggerObj.style.display='none';
				dateObj.disabled=true;				
			}
   }
</script>
<div style="margin-left:10px">
Publish Date: 
<input style="width: 120px; border: 1px solid #000; text-align: left" 
	id="PublishDate" name="PublishDate" value="<?php echo  $this->PublishDate; ?>" readonly="readonly"/>
<a href="#" id="PublishDateTrigger"><img align="middle" border="0" src="template/jscalendar/img.gif" alt="" /></a>
<script type="text/javascript">
  Calendar.setup(
    { 
      inputField  : "PublishDate",         // ID of the input field
      ifFormat    : "%B %e %Y",    // the date format
      button      : "PublishDateTrigger"       // ID of the button
    }
  );
</script>
<input type="checkbox" name="ActiveFlag" <?php echo $archive; ?> 
	onclick="archive()"/> Archive?
Archive Date: 
<input style="width: 120px; border: 1px solid #000; text-align: left" 
	id="ArchiveDate" name="ArchiveDate" value="<?php echo  $this->ArchiveDate; ?>" <?php echo $archive_disabled; ?> readonly="readonly" />
<a href="#" id="ArchiveDateTrigger" style="display:<?php echo $archive_display; ?>"><img align="middle" border="0" src="template/jscalendar/img.gif" alt="" /></a>
<script type="text/javascript">
  Calendar.setup(
    { 
      inputField  : "ArchiveDate",         // ID of the input field
      ifFormat    : "%B %e %Y",    // the date format
      button      : "ArchiveDateTrigger"       // ID of the button
    }
  );
</script>
</div>
<?php
	}

}

?>