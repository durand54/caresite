<?php
defined('_VALID_PAGE') or die('Direct access not allowed');
global $my;

if($my->admin_id ==''){
	return;
}		
global $live_site,$system;

if(0){
?>
	<tr><td nowrap>&nbsp;&nbsp;&nbsp;<a class="smallSubNav" href="'.$live_site_admin.'content/content.php?action=editM">Methodology</a></td></tr>
	<tr><td nowrap>&nbsp;&nbsp;&nbsp;<a class="smallSubNav" href="'.$live_site_admin.'content/content.php?action=editROS">Rationale of Segmentation</a></td></tr>
	<tr><td nowrap>&nbsp;&nbsp;&nbsp;<a class="smallSubNav" href="'.$live_site_admin.'content/content.php?action=editES">Executive Summary</a></td></tr>
<?php
?>
		<tr><td nowrap>&nbsp;&nbsp;&nbsp;<a class="smallSubNav" href="'.$live_site_admin.'sfsupload/sfsupload.php?action=uploadSFS">Upload SFS Data</a></td></tr>
		<tr><td nowrap>&nbsp;&nbsp;&nbsp;<a class="smallSubNav" href="'.$live_site_admin.'sfsupload/sfsupload.php?action=recalculateSFS">Recalculate SFS</a></td></tr>
<?php	
}
?>			
<table cellspacing="0" cellpadding="0" border="0" width="194" bgcolor="#E9E0DB">
			<tr>
				<td width="15"><img src="<?php echo  $live_site; ?>/media/images/spacer.gif" border="0" width="15" height="5" /></td>
				<td align="center">
					<br /><br />
					<table border="0" cellspacing="0" cellpadding="5" width="100%">
					<tr><td><a class="subNav" href="index.php?comp=vehicle">Vehicle List</a></td></tr>
					<tr><td><a class="subNav" href="index.php?comp=category">Categories</a></td></tr>
					<tr><td><a class="subNav" href="index.php?comp=user">Subscribers</a></td></tr>
					<tr><td><a class="subNav" href="index.php?comp=content&task=files">Upload Files</a></td></tr>
					<tr><td><a class="subNav" href="index.php?comp=user&task=preferences">Matrix Prefs</a></td></tr>
					<tr><td><a class="subNav" href="index.php?comp=content&task=background">Background Info</a></td></tr>
					<?php if($system->background_menu){?>
<tr><td nowrap>&nbsp;&nbsp;&nbsp;<a class="smallSubNav" href="index.php?comp=content&task=background_edit&type=M">Methodology</a></td></tr>
<tr><td nowrap>&nbsp;&nbsp;&nbsp;<a class="smallSubNav" href="index.php?comp=content&task=background_edit&type=ROS">Rationale of Segmentation</a></td></tr>
<tr><td nowrap>&nbsp;&nbsp;&nbsp;<a class="smallSubNav" href="index.php?comp=content&task=executive_summary">Executive Summary</a></td></tr>			
					<?php }?>
					<tr><td><a class="subNav" href="index.php?comp=content&task=press_releases">Press Releases</a></td></tr>
					<tr><td><a class="subNav" href="index.php?comp=admin">Admin Access</a></td></tr>
					<tr><td><a class="subNav" href="index.php?comp=sfcsupload">Sales Forecast Upload</a></td></tr>
					<?php if($system->sfcsupload_menu){?>
<tr><td nowrap>&nbsp;&nbsp;&nbsp;<a class="smallSubNav" href="index.php?comp=sfcsupload">Upload SFS Data</a></td></tr>
<tr><td nowrap>&nbsp;&nbsp;&nbsp;<a class="smallSubNav" href="index.php?comp=sfcsupload&task=recalculate">Recalculate SFS</a></td></tr>
					<?php }?>
					<tr><td><a class="subNav" href="http://vehiclevoice.com/index.php" target="_blank">View Client Site</a></td></tr>	
					</table>
					<br /><br />
				</td>
			</tr>
			<tr>
				<td bgcolor="#BFA395" valign="middle" colspan="2"><img src="media/images/spacer.gif" border="0" width="15" height="35" /></td>
			</tr>
			</table>	
			
