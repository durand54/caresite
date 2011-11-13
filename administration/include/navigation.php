<?php
	function navigation ()
	{
		global $live_site_admin;
		$nav = '
			<!-- INDEX -->
			<td><a href="index.php"><img src="'.$live_site_admin.'/media/images/home.jpg" hsrc="'.$live_site_admin.'/media/images/o_home.jpg" border="0" /></a></td>
			<td><img src="'.$live_site_admin.'/media/images/spacer.gif" border="0" width="15" height="5" /></td>
			
			<!-- VEHICLES -->
			<td><a href="'.$live_site_admin.'/vehicles/vehicles.php"><img src="'.$live_site_admin.'/media/images/vehicleList.jpg" hsrc="'.$live_site_admin.'/media/images/o_vehicleList.jpg" border="0" /></a></td>
			<td><img src="'.$live_site_admin.'/media/images/spacer.gif" border="0" width="15" height="5" /></td>
			
			<!-- CATEGORIES -->
			<td><a href="'.$live_site_admin.'/categories/categories.php"><img src="'.$live_site_admin.'/media/images/categories.jpg" hsrc="'.$live_site_admin.'/media/images/o_categories.jpg" border="0" /></a></td>
			<td><img src="'.$live_site_admin.'/media/images/spacer.gif" border="0" width="15" height="5" /></td>
			
			<!-- SUBSCRIBERS -->
			<td><a href="'.$live_site_admin.'/subscribers/subscribers.php"><img src="'.$live_site_admin.'/media/images/subscribers.jpg" hsrc="'.$live_site_admin.'/media/images/o_subscribers.jpg" border="0" /></a></td>
			<td><img src="'.$live_site_admin.'/media/images/spacer.gif" border="0" width="15" height="5" /></td>
			
			<!-- UPLOAD FILES -->
			<td><a href="'.$live_site_admin.'/uploads/uploads.php"><img src="'.$live_site_admin.'/media/images/uploads.jpg" hsrc="'.$live_site_admin.'/media/images/o_uploads.jpg" border="0" /></a></td>
			<td><img src="'.$live_site_admin.'/media/images/spacer.gif" border="0" width="15" height="5" /></td>
			
			<!-- MATRIX PREFERENCES -->
			<td><a href="'.$live_site_admin.'/matrix/matrix.php"><img src="'.$live_site_admin.'/media/images/matrix.jpg" hsrc="'.$live_site_admin.'/media/images/o_matrix.jpg" border="0" /></a></td>
			<td><img src="'.$live_site_admin.'/media/images/spacer.gif" border="0" width="15" height="5" /></td>
			
			<!-- BACKGROUND INFO -->
			<td><a href="'.$live_site_admin.'/content/content.php"><img src="'.$live_site_admin.'/media/images/bgInfo.jpg" hsrc="'.$live_site_admin.'/media/images/o_bgInfo.jpg" border="0" /></a></td>
			<td><img src="'.$live_site_admin.'/media/images/spacer.gif" border="0" width="15" height="5" /></td>
			
			<!-- PRESS RELEASES -->
			<td><a href="'.$live_site_admin.'/pr/pr.php"><img src="'.$live_site_admin.'/media/images/pr.jpg" hsrc="'.$live_site_admin.'/media/images/o_pr.jpg" border="0" /></a></td>
			<td><img src="'.$live_site_admin.'/media/images/spacer.gif" border="0" width="15" height="5" /></td>
			
			<!-- ADMIN ACCESS -->
			<td><a href="'.$live_site_admin.'/admins/admins.php"><img src="'.$live_site_admin.'/media/images/adminAccess.jpg" hsrc="'.$live_site_admin.'/media/images/o_adminAccess.jpg" border="0" /></a></td>
			<td><img src="'.$live_site_admin.'/media/images/spacer.gif" border="0" width="15" height="5" /></td>
			
			<!-- LOGOUT -->
			<td><a href="'.$_SERVER["PHP_SELF"].'?action=logout"><img src="'.$live_site_admin.'/media/images/logout.jpg" hsrc="'.$live_site_admin.'/media/images/o_logout.jpg" border="0" /></a></td>
		';
		return $nav;
	}
	
	function navigation2 ()
	{
		global $live_site_admin;
		$bg = "";
		$pr = "";
		if ($_SERVER["PHP_SELF"] == "/content/content.php")
		{
			$bg = '<tr><td nowrap>&nbsp;&nbsp;&nbsp;<a class="smallSubNav" href="'.$live_site_admin.'content/content.php?action=editM">Methodology</a></td></tr>';
			$bg.= '<tr><td nowrap>&nbsp;&nbsp;&nbsp;<a class="smallSubNav" href="'.$live_site_admin.'content/content.php?action=editROS">Rationale of Segmentation</a></td></tr>';
			$bg.= '<tr><td nowrap>&nbsp;&nbsp;&nbsp;<a class="smallSubNav" href="'.$live_site_admin.'content/content.php?action=editES">Executive Summary</a></td></tr>';
		} else if ($_SERVER["PHP_SELF"] == "/sfsupload/sfsupload.php")
		{
			$sf = '<tr><td nowrap>&nbsp;&nbsp;&nbsp;<a class="smallSubNav" href="'.$live_site_admin.'sfsupload/sfsupload.php?action=uploadSFS">Upload SFS Data</a></td></tr>';
			$sf.= '<tr><td nowrap>&nbsp;&nbsp;&nbsp;<a class="smallSubNav" href="'.$live_site_admin.'sfsupload/sfsupload.php?action=recalculateSFS">Recalculate SFS</a></td></tr>';
		}
		$profileBox = '
			<table cellspacing="0" cellpadding="0" border="0" width="194" bgcolor="#E9E0DB">
			<tr>
				<td width="15"><img src="'.$live_site_admin.'/media/images/spacer.gif" border="0" width="15" height="5" /></td>
				<td align="center">
					<br /><br />
					<table border="0" cellspacing="0" cellpadding="5" width="100%">
					<tr><td nowrap><a class="subNav" href="'.$live_site_admin.'/vehicles/vehicles.php">Vehicle List</a></td></tr>
					<tr><td nowrap><a class="subNav" href="'.$live_site_admin.'/categories/categories.php">Categories</a></td></tr>
					<tr><td nowrap><a class="subNav" href="'.$live_site_admin.'/subscribers/subscribers.php">Subscribers</a></td></tr>
					<tr><td nowrap><a class="subNav" href="'.$live_site_admin.'/uploads/uploads.php">Upload Files</a></td></tr>
					<tr><td nowrap><a class="subNav" href="'.$live_site_admin.'/matrix/matrix.php">Matrix Prefs</a></td></tr>
					<tr><td nowrap><a class="subNav" href="'.$live_site_admin.'/content/content.php">Background Info</a></td></tr>
					'.$bg.'
					<tr><td nowrap><a class="subNav" href="'.$live_site_admin.'/pr/pr.php">Press Releases</a></td></tr>
					<tr><td nowrap><a class="subNav" href="'.$live_site_admin.'/admins/admins.php">Admin Access</a></td></tr>
					<tr><td nowrap><a class="subNav" href="'.$live_site_admin.'/sfsupload/sfsupload.php">Sales Forecast Upload</a></td></tr>
					'.$sf.'
					<tr><td nowrap><a class="subNav" href="http://demo.eautopacific.com/index.php" target="_blank">View Client Site</a></td></tr>	
					</table>
					<br /><br />
				</td>
			</tr>
			<tr>
				<td bgcolor="#BFA395" valign="middle" colspan="2"><img src="'.$live_site_admin.'/media/images/spacer.gif" border="0" width="15" height="35" /></td>
			</tr>
			</table>	
		';
		
		return $profileBox;
	}
?>