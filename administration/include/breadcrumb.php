<?php
	function breadCrumb ()
	{
		$breadcrumb = '
			<table border="0" cellpadding="10" cellspacing="0" width="100%">
			<tr>
				<td valign="top">
					You Are Here:';
		
		$thisURL = explode ("/", $_SERVER["REQUEST_URI"]);
		$page = $thisURL[2];
		$qpos = (strpos ($page, "?") !== false) ? strpos ($page, "?") : strlen($page);
		switch (strtolower(substr($page, 0, $qpos-4)))
		{
			case "index":
				$breadcrumb.= " Home";
				break;
				
			case "categories":
				if (isset($_GET["action"]) && !isset($_GET["main"]))
				{
					$q = "SELECT CategoryID, CategoryName FROM Category WHERE CategoryID = '$_GET[id]'";
					$qr= mysql_query($q);
					$r = mysql_fetch_array($qr);
					$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "<a href=\"/categories/categories.php\" class=\"linkBlack\">Categories</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= ucwords($_GET["action"])." $r[CategoryName]";
				} else if (isset($_GET["action"]) && isset($_GET["main"]) && !isset($_GET["edit"]) && !isset($_GET['sub']))
				{
					$q = "SELECT CategoryID, CategoryName FROM Category WHERE CategoryID = '$_GET[main]'";
					$qr= mysql_query($q);
					$r = mysql_fetch_array($qr);
					$q2 = "SELECT CategoryItemID, CategoryItemName FROM CategoryItem WHERE CategoryItemID = '$_GET[id]' AND CategoryID = '$_GET[main]'";
					$qr2= mysql_query($q2);
					$r2 = mysql_fetch_array($qr2);
					$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "<a href=\"/categories/categories.php\" class=\"linkBlack\">Categories</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "<a href=\"/categories/categories.php?action=view&id=$_GET[main]\" class=\"linkBlack\">View $r[CategoryName]</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= ucwords($_GET["action"])." $r2[CategoryItemName]";
				} else if (isset($_GET["action"]) && isset($_GET["main"]) && (isset($_GET["edit"]) || isset($_GET['sub'])))
				{
					if (!isset($_GET['sub']) && $_GET['action'] != "addMPR")
					{
						$q = "SELECT CategoryID, CategoryName FROM Category WHERE CategoryID = '$_GET[main]'";
						$qr= mysql_query($q);
						$r = mysql_fetch_array($qr);
						$q2 = "SELECT CategoryItemID, CategoryItemName FROM CategoryItem WHERE CategoryItemID = '$_GET[id]' AND CategoryID = '$_GET[main]'";
						$qr2= mysql_query($q2);
						$r2 = mysql_fetch_array($qr2);
						$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
						$breadcrumb.= "<a href=\"/categories/categories.php\" class=\"linkBlack\">Categories</a>&nbsp;&gt;&nbsp;";
						$breadcrumb.= "<a href=\"/categories/categories.php?action=view&id=$_GET[main]\" class=\"linkBlack\">View $r[CategoryName]</a>&nbsp;&gt;&nbsp;";
						$breadcrumb.= "<a href=\"/categories/categories.php?action=edit&main=$_GET[main]&id=$_GET[id]\" class=\"linkBlack\">Edit $r2[CategoryItemName]</a>&nbsp;&gt;&nbsp;";
						$breadcrumb.= "Edit Background Text";
					} else
					{
						switch ($_GET['action'])
						{
							case "addMPR":
								$q = "SELECT CategoryID, CategoryName FROM Category WHERE CategoryID = '$_GET[main]'";
								$qr= mysql_query($q);
								$r = mysql_fetch_array($qr);
								$q2 = "SELECT CategoryItemID, CategoryItemName FROM CategoryItem WHERE CategoryItemID = '$_GET[id]' AND CategoryID = '$_GET[main]'";
								$qr2= mysql_query($q2);
								$r2 = mysql_fetch_array($qr2);
								$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
								$breadcrumb.= "<a href=\"/categories/categories.php\" class=\"linkBlack\">Categories</a>&nbsp;&gt;&nbsp;";
								$breadcrumb.= "<a href=\"/categories/categories.php?action=view&id=$_GET[main]\" class=\"linkBlack\">View $r[CategoryName]</a>&nbsp;&gt;&nbsp;";
								$breadcrumb.= "<a href=\"/categories/categories.php?action=edit&main=$_GET[main]&id=$_GET[id]\" class=\"linkBlack\">Edit $r2[CategoryItemName]</a>&nbsp;&gt;&nbsp;";
								$breadcrumb.= "<a href=\"/categories/categories.php?action=backgroundText&main=$_GET[main]&id=$_GET[id]&edit=$_GET[sub]\" class=\"linkBlack\">Edit Background Text</a>&nbsp;&gt;&nbsp;";
								$breadcrumb.= "Add Press Release";
								break;
								
							case "editMPR":
								$q = "SELECT CategoryID, CategoryName FROM Category WHERE CategoryID = '$_GET[main]'";
								$qr= mysql_query($q);
								$r = mysql_fetch_array($qr);
								$q2 = "SELECT CategoryItemID, CategoryItemName FROM CategoryItem WHERE CategoryItemID = '$_GET[id]' AND CategoryID = '$_GET[main]'";
								$qr2= mysql_query($q2);
								$r2 = mysql_fetch_array($qr2);
								$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
								$breadcrumb.= "<a href=\"/categories/categories.php\" class=\"linkBlack\">Categories</a>&nbsp;&gt;&nbsp;";
								$breadcrumb.= "<a href=\"/categories/categories.php?action=view&id=$_GET[main]\" class=\"linkBlack\">View $r[CategoryName]</a>&nbsp;&gt;&nbsp;";
								$breadcrumb.= "<a href=\"/categories/categories.php?action=edit&main=$_GET[main]&id=$_GET[id]\" class=\"linkBlack\">Edit $r2[CategoryItemName]</a>&nbsp;&gt;&nbsp;";
								$breadcrumb.= "<a href=\"/categories/categories.php?action=backgroundText&main=$_GET[main]&id=$_GET[id]&edit=$_GET[sub]\" class=\"linkBlack\">Edit Background Text</a>&nbsp;&gt;&nbsp;";
								$breadcrumb.= "Edit Press Release";
								break;
								
							case "deleteMPR":
								$q = "SELECT CategoryID, CategoryName FROM Category WHERE CategoryID = '$_GET[main]'";
								$qr= mysql_query($q);
								$r = mysql_fetch_array($qr);
								$q2 = "SELECT CategoryItemID, CategoryItemName FROM CategoryItem WHERE CategoryItemID = '$_GET[id]' AND CategoryID = '$_GET[main]'";
								$qr2= mysql_query($q2);
								$r2 = mysql_fetch_array($qr2);
								$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
								$breadcrumb.= "<a href=\"/categories/categories.php\" class=\"linkBlack\">Categories</a>&nbsp;&gt;&nbsp;";
								$breadcrumb.= "<a href=\"/categories/categories.php?action=view&id=$_GET[main]\" class=\"linkBlack\">View $r[CategoryName]</a>&nbsp;&gt;&nbsp;";
								$breadcrumb.= "<a href=\"/categories/categories.php?action=edit&main=$_GET[main]&id=$_GET[id]\" class=\"linkBlack\">Edit $r2[CategoryItemName]</a>&nbsp;&gt;&nbsp;";
								$breadcrumb.= "<a href=\"/categories/categories.php?action=backgroundText&main=$_GET[main]&id=$_GET[id]&edit=$_GET[sub]\" class=\"linkBlack\">Edit Background Text</a>&nbsp;&gt;&nbsp;";
								$breadcrumb.= "Delete Press Release";
								break;
						}
					}
				} else
				{
					$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "Categories";
				}
				break;
				
			case "sfsupload":
				if (isset($_GET["action"]) && $_GET['action'] == "uploadSFS")
				{
					$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "Sales Forecast Upload";
				} else if (isset($_GET["action"]) && $_GET['action'] == "recalculateSFS")
				{
					$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "Recalculate Sales Forecast";
				} else
				{
					$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "Sales Forecast Upload";
				}
				break;
				
			case "matrix":
				$breadcrumb.= " <a href=\"/index.php\" class=\"linkBlack\">Home</a> &gt; Matrix Prefs";
				break;
				
			case "pr":
				if ($_GET["action"] == "viewHPR" || $_GET["action"] == "editHPR" || $_GET["action"] == "addHPR" || $_GET["action"] == "deleteHPR" || $_GET["action"] == "updateHPR")
				{
					$breadcrumb.= " <a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= " <a href=\"/pr/pr.php\" class=\"linkBlack\">Press Releases</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= ucwords(substr($_GET["action"], 0, -3))." Home Page Press Releases";
					break;
				} else if ($_GET["action"] == "viewMPR" || $_GET["action"] == "editMPR" || $_GET["action"] == "addMPR" || $_GET["action"] == "deleteMPR" || $_GET["action"] == "updateMPR")
				{
					$breadcrumb.= " <a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= " <a href=\"/pr/pr.php\" class=\"linkBlack\">Press Releases</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= ucwords(substr($_GET["action"], 0, -3))." Make Press Releases";
					break;
				} else if ($_GET["action"] == "viewVPR" || $_GET["action"] == "editVPR" || $_GET["action"] == "addVPR" || $_GET["action"] == "deleteVPR" || $_GET["action"] == "updateVPR")
				{
					$breadcrumb.= " <a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= " <a href=\"/pr/pr.php\" class=\"linkBlack\">Press Releases</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= ucwords(substr($_GET["action"], 0, -3))." Make Press Releases";
					break;
				} else
				{
					$breadcrumb.= " <a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;Press Releases";
					break;
				}
				
			case "vehicles":
				if (isset($_GET["id"]) && !isset($_GET["main"]) && !isset($_GET["sub"]))
				{
					$q = "SELECT CategoryItemID, CategoryItemName FROM CategoryItem WHERE CategoryItemID = '$_GET[id]'";
					$qr= mysql_query($q);
					$r = mysql_fetch_array($qr);
					$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "<a href=\"/vehicles/vehicles.php\" class=\"linkBlack\">Vehicle List</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "$r[CategoryItemName]";
					
				} else if (isset($_GET["id"]) && isset($_GET["main"]) && !isset($_GET["sub"]))
				{
					$q = "SELECT CategoryItemID, CategoryItemName FROM CategoryItem WHERE CategoryItemID = '$_GET[main]'";
					$qr= mysql_query($q);
					$r = mysql_fetch_array($qr);
					$q2 = "SELECT CategoryItemID, CategoryItemName FROM CategoryItem WHERE CategoryItemID = '$_GET[id]'";
					$qr2= mysql_query($q2);
					$r2 = mysql_fetch_array($qr2);
					$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "<a href=\"/vehicles/vehicles.php\" class=\"linkBlack\">Vehicle List</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&id=$_GET[main]\" class=\"linkBlack\">$r[CategoryItemName]</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= ucwords($_GET["action"])." $r2[CategoryItemName]";

				} else if (isset($_GET["id"]) && isset($_GET["main"]) && isset($_GET["sub"]))
				{
					$q = "SELECT CategoryItemID, CategoryItemName FROM CategoryItem WHERE CategoryItemID = '$_GET[main]'";
					$qr= mysql_query($q);
					$r = mysql_fetch_array($qr);
					$q2 = "SELECT CategoryItemID, CategoryItemName FROM CategoryItem WHERE CategoryItemID = '$_GET[sub]'";
					$qr2= mysql_query($q2);
					$r2 = mysql_fetch_array($qr2);
					$q3 = "SELECT VehicleID, VehicleName FROM Vehicles WHERE VehicleID = '$_GET[id]'";
					$qr3= mysql_query($q3);
					$r3 = mysql_fetch_array($qr3);
					
					$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "<a href=\"/vehicles/vehicles.php\" class=\"linkBlack\">Vehicle List</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&id=$_GET[main]\" class=\"linkBlack\">$r[CategoryItemName]</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&id=$_GET[sub]\" class=\"linkBlack\">View $r2[CategoryItemName]</a>&nbsp;&gt;&nbsp;";
					switch ($_GET['action'])
					{
						case "view":
							$breadcrumb.= "View ".str_replace("<p>", " - ", str_replace("</p>", "", $r3["VehicleName"]));
							break;
							
						case "edit":
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[id]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Edit Competitive Battleground Info";
							break;
						
						case "viewList":
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[id]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "View Battleground Cycle Text";
							break;
						
						case "deleteList":
							$q3 = "SELECT VehicleID, VehicleName FROM Vehicles WHERE VehicleID = '$_GET[tert]'";
							$qr3= mysql_query($q3);
							$r3 = mysql_fetch_array($qr3);
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=viewList&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">View Battleground Cycle Text</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Delete Battleground Cycle Text";
							break;
						
						case "editList":
							$q3 = "SELECT VehicleID, VehicleName FROM Vehicles WHERE VehicleID = '$_GET[tert]'";
							$qr3= mysql_query($q3);
							$r3 = mysql_fetch_array($qr3);
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=viewList&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">View Battleground Cycle Text</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Edit Battleground Cycle Text";
							break;
						
						case "viewSfcs":
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[id]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Sales Forecast Vehicle Edit";
							break;
						
						case "editSfcs":
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[id]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=viewSfcs&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[id]\" class=\"linkBlack\">View Sales Forecast Info</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Edit Sales Forecast Info";
							break;
						
						case "editVolume":
							$q3 = "SELECT VehicleID, VehicleName FROM Vehicles WHERE VehicleID = '$_GET[tert]'";
							$qr3= mysql_query($q3);
							$r3 = mysql_fetch_array($qr3);
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=viewSfcs&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">View Sales Forecast Info</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Edit Vehicle Bodystyle Volume";
							break;
						
						case "viewPhoto":
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[id]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Photo Selection";
							break;
						
						case "addPhoto":
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[id]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Add Photo";
							break;
						
						case "deletePhoto":
							$q3 = "SELECT VehicleID, VehicleName FROM Vehicles WHERE VehicleID = '$_GET[tert]'";
							$qr3= mysql_query($q3);
							$r3 = mysql_fetch_array($qr3);
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=viewPhoto&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">Photo Selection</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Delete Photo";
							break;
						
						case "editPhoto":
							$q3 = "SELECT VehicleID, VehicleName FROM Vehicles WHERE VehicleID = '$_GET[tert]'";
							$qr3= mysql_query($q3);
							$r3 = mysql_fetch_array($qr3);
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=viewPhoto&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">Photo Selection</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Edit Photo";
							break;
						
						case "editBodystyle":
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[id]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Assign Bodystyle";
							break;
						
						case "editDivision":
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[id]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Assign Division";
							break;
						
						case "editDriveConfig":
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[id]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Assign Drive Configuration";
							break;
						
						case "editSeatingCapacity":
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[id]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Assign Seating Capacity";
							break;
						
						case "editTransmission":
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[id]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Assign Transmission";
							break;
						
						case "editSegment":
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[id]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Assign Segment";
							break;
						
						case "editDimension":
							$q3 = "SELECT VehicleID, VehicleName FROM Vehicles WHERE VehicleID = '$_GET[tert]'";
							$qr3= mysql_query($q3);
							$r3 = mysql_fetch_array($qr3);
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Edit Dimension";
							break;
						
						case "deleteDimension":
							$q3 = "SELECT VehicleID, VehicleName FROM Vehicles WHERE VehicleID = '$_GET[tert]'";
							$qr3= mysql_query($q3);
							$r3 = mysql_fetch_array($qr3);
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Delete Dimension";
							break;
						
						case "editTireSize":
							$q3 = "SELECT VehicleID, VehicleName FROM Vehicles WHERE VehicleID = '$_GET[tert]'";
							$qr3= mysql_query($q3);
							$r3 = mysql_fetch_array($qr3);
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Edit Tire Size";
							break;
						
						case "deleteTireSize":
							$q3 = "SELECT VehicleID, VehicleName FROM Vehicles WHERE VehicleID = '$_GET[tert]'";
							$qr3= mysql_query($q3);
							$r3 = mysql_fetch_array($qr3);
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Delete Tire Size";
							break;
						
						case "editEngine":
							$q3 = "SELECT VehicleID, VehicleName FROM Vehicles WHERE VehicleID = '$_GET[tert]'";
							$qr3= mysql_query($q3);
							$r3 = mysql_fetch_array($qr3);
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Edit Engine";
							break;
						
						case "deleteEngine":
							$q3 = "SELECT VehicleID, VehicleName FROM Vehicles WHERE VehicleID = '$_GET[tert]'";
							$qr3= mysql_query($q3);
							$r3 = mysql_fetch_array($qr3);
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Delete Engine";
							break;
						
						case "editSuspension":
							$q3 = "SELECT VehicleID, VehicleName FROM Vehicles WHERE VehicleID = '$_GET[tert]'";
							$qr3= mysql_query($q3);
							$r3 = mysql_fetch_array($qr3);
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Edit Suspension";
							break;
						
						case "deleteSuspension":
							$q3 = "SELECT VehicleID, VehicleName FROM Vehicles WHERE VehicleID = '$_GET[tert]'";
							$qr3= mysql_query($q3);
							$r3 = mysql_fetch_array($qr3);
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Delete Suspension";
							break;
						
						case "editPriceRange":
							$q3 = "SELECT VehicleID, VehicleName FROM Vehicles WHERE VehicleID = '$_GET[tert]'";
							$qr3= mysql_query($q3);
							$r3 = mysql_fetch_array($qr3);
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Edit Price Range";
							break;
						
						case "deletePriceRange":
							$q3 = "SELECT VehicleID, VehicleName FROM Vehicles WHERE VehicleID = '$_GET[tert]'";
							$qr3= mysql_query($q3);
							$r3 = mysql_fetch_array($qr3);
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[tert]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Delete Price Range";
							break;
						
						case "addVPR":
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[id]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Add Vehicle Press Release";
							break;
						
						case "editVPR":
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[id]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Edit Vehicle Press Release";
							break;
						
						case "deleteVPR":
							$breadcrumb.= "<a href=\"/vehicles/vehicles.php?action=view&main=$_GET[main]&sub=$_GET[sub]&id=$_GET[id]\" class=\"linkBlack\">View $r3[VehicleName]</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Delete Vehicle Press Release";
							break;
					}
				} else
				{
					$breadcrumb.= " <a href=\"/index.php\" class=\"linkBlack\">Home</a> &gt; Vehicle List";
				}
				break;
				
			case "uploads":
				if (isset($_GET["action"]) && !isset($_GET["main"]))
				{
					$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "<a href=\"/uploads/uploads.php\" class=\"linkBlack\">Upload Files</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= ucwords($_GET["action"])." File";
				} else
				{
					$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "Upload Files";
				}
				break;
				
			case "subscribers":
				if (isset($_GET["action"]) && !isset($_GET["main"]))
				{
					$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "<a href=\"/subscribers/subscribers.php\" class=\"linkBlack\">Subscribers</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= ucwords($_GET["action"])." Subscriber";
				} else if (isset($_GET["action"]) && isset($_GET["main"]))
				{
					$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "<a href=\"/subscribers/subscribers.php\" class=\"linkBlack\">Subscribers</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "<a href=\"/subscribers/subscribers.php?action=edit&id=$_GET[main]\" class=\"linkBlack\">Edit Subscriber</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= ucwords($_GET["action"])." User";
				} else
				{
					$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "Subscribers";
				}
				break;
				
			case "admins":
				if (isset($_GET["action"]))
				{
					$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "<a href=\"/admins/admins.php\" class=\"linkBlack\">Administrator Access</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= ucwords($_GET["action"])." Administrator";
				} else
				{
					$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "Administrator Access";
				}
				break;
				
			case "template2":
				$breadcrumb.= " and you shouldn't be.";
				break;
				
			case "content":
				if (isset($_GET["action"]))
				{
					$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "<a href=\"/content/content.php\" class=\"linkBlack\">Background Information</a>&nbsp;&gt;&nbsp;";
					switch($_GET["action"])
					{
						case "editM":
							$breadcrumb.= "Edit Methodology";
							break;
						case "editROS":
							$breadcrumb.= "Edit Rationale of Segmentation";
							break;
						case "editES":
							$breadcrumb.= "<a href=\"/content/content.php?action=viewES\" class=\"linkBlack\">Executive Summary</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Edit Executive Summary";
							break;
						case "deleteES":
							$breadcrumb.= "<a href=\"/content/content.php?action=viewES\" class=\"linkBlack\">Executive Summary</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Delete Executive Summary";
							break;
						case "addES":
							$breadcrumb.= "<a href=\"/content/content.php?action=viewES\" class=\"linkBlack\">Executive Summary</a>&nbsp;&gt;&nbsp;";
							$breadcrumb.= "Add Executive Summary";
							break;
						case "viewES":
							$breadcrumb.= "Executive Summary";
							break;
					}
				} else
				{
					$breadcrumb.= "&nbsp;<a href=\"/index.php\" class=\"linkBlack\">Home</a>&nbsp;&gt;&nbsp;";
					$breadcrumb.= "Background Information";
				}
				break;
		}
		
		$breadcrumb.= '
				</td>
			</tr>
			</table>
		';
		return $breadcrumb;
	}
?>