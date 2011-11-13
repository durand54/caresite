<?php
	function delete($file) { 
		@chmod($file,0777); 
		if (@is_dir($file)) { 
			$handle = @opendir($file); 
			while($filename = @readdir($handle)) { 
				if ($filename != "." && $filename != "..") { 
					delete($file."/".$filename); 
				} 
			}
			@closedir($handle); 
			@rmdir($file); 
		} else { 
			@unlink($file); 
		}
	}

	function int ($num)
	{ // returns an integer
		return (int)$num;
	}
	
	function makeThumbnail ($source, $destination, $dest_width="154", $dest_height="93", $quality="100")
	{
		$src_img     = imagecreatefromjpeg($source);
		$size        = getimagesize ($source); // 0 = width, 1 = height
		$deltaw      = ($size[0] / $dest_width);
		$deltah      = ($size[1] / $dest_height);
		$too_wide    = ($size[0] / $deltah);
		$too_tall    = ($size[1] / $deltaw);
		$x           = ($dest_width / 2) - int($too_wide / 2);
		$y           = ($dest_height / 2) - int($too_tall / 2);
		
		if ($size[0] > $size[1] && $too_wide >= $dest_width)
		{ // make the height match up to the edges
			$dst_img = imagecreatetruecolor($dest_width,$dest_height);
			imagefilledrectangle($dst_img, 0, 0, $dest_width, $dest_height, ImageColorAllocate($dst_img, 255, 255, 255));
			imagecopyresampled($dst_img, $src_img, $x, 0, 0, 0, $too_wide, $dest_height, $size[0], $size[1]);
			
		} else if ($size[1] > $size[0] && $too_tall >= $dest_height)
		{ // make the width match up to the edges
			$dst_img = imagecreatetruecolor($dest_width,$dest_height);
			imagefilledrectangle($dst_img, 0, 0, $dest_width, $dest_height, ImageColorAllocate($dst_img, 255, 255, 255));
			imagecopyresampled($dst_img, $src_img, 0, $y, 0, 0, $dest_width, $too_tall, $size[0], $size[1]);
			
		} else if ($size[0] > $size[1] && $too_wide < $dest_width)
		{
			$too_tall    = ($size[1] / $deltaw);
			$y           = ($dest_height / 2) - int($too_tall / 2);
			
			$dst_img = imagecreatetruecolor($dest_width,$dest_height);
			imagefilledrectangle($dst_img, 0, 0, $dest_width, $dest_height, ImageColorAllocate($dst_img, 255, 255, 255));
			imagecopyresampled($dst_img, $src_img, 0, $y, 0, 0, $dest_width, $too_tall, $size[0], $size[1]);
			
		} else if ($size[1] > $size[0] && $too_tall < $dest_height)
		{
			$too_wide    = ($size[0] / $deltah);
			$x           = ($dest_width / 2) - int($too_wide / 2);
			
			$dst_img = imagecreatetruecolor($dest_width,$dest_height);
			imagefilledrectangle($dst_img, 0, 0, $dest_width, $dest_height, ImageColorAllocate($dst_img, 255, 255, 255));
			imagecopyresampled($dst_img, $src_img, $x, 0, 0, 0, $too_wide, $dest_height, $size[0], $size[1]);
			
		}
		imagejpeg($dst_img, $destination, $quality);
		imagedestroy($src_img);
		imagedestroy($dst_img);
	}
	
	function makeMedium ($source, $destination, $dest_width="245", $dest_height="150", $quality="100")
	{
		$src_img     = imagecreatefromjpeg($source);
		$size        = getimagesize ($source);
		$deltaw      = ($size[0] / $dest_width);
		$deltah      = ($size[1] / $dest_height);
		$too_wide    = ($size[0] / $deltah);
		$too_tall    = ($size[1] / $deltaw);
		$x           = ($dest_width / 2) - int($too_wide / 2);
		$y           = ($dest_height / 2) - int($too_tall / 2);
		
		if ($size[0] > $size[1])
		{ // wide
			/* crops the photo
			$dst_img = imagecreatetruecolor($dest_width,$dest_height);
			imagefilledrectangle($dst_img, 0, 0, 400, 400, ImageColorAllocate($dst_img, 255, 255, 255));
			imagecopyresampled($dst_img, $src_img, $x, 0, 0, 0, $too_wide, $dest_height, $size[0], $size[1]);
			// keeps the scale */
			$too_tall    = ($size[1] / $deltaw);
			$y           = ($dest_height / 2) - int($too_tall / 2);
			$dst_img = imagecreatetruecolor($dest_width,$dest_height);
			imagefilledrectangle($dst_img, 0, 0, $dest_width, $dest_height, ImageColorAllocate($dst_img, 255, 255, 255));
			imagecopyresampled($dst_img, $src_img, 0, $y, 0, 0, $dest_width, $too_tall, $size[0], $size[1]);
			
		} else if ($size[1] > $size[0])
		{ // tall
			/* crops the photo
			$dst_img = imagecreatetruecolor($dest_width,$dest_height);
			imagefilledrectangle($dst_img, 0, 0, 400, 400, ImageColorAllocate($dst_img, 255, 255, 255));
			imagecopyresampled($dst_img, $src_img, 0, $y, 0, 0, $dest_width, $too_tall, $size[0], $size[1]);
			// keeps the scale */
			$dst_img = imagecreatetruecolor($dest_width,$dest_height);
			imagefilledrectangle($dst_img, 0, 0, $dest_width, $dest_height, ImageColorAllocate($dst_img, 255, 255, 255));
			imagecopyresampled($dst_img, $src_img, $x, 0, 0, 0, $too_wide, $dest_height, $size[0], $size[1]);
			
		}
		imagejpeg($dst_img, $destination, $quality);
		imagedestroy($src_img);
		imagedestroy($dst_img);
	}
	
	function monthsSelectList ($spacer="", $selected="")
	{
		$months = array (
			"01" => "January",
			"02" => "February",
			"03" => "March",
			"04" => "April",
			"05" => "May",
			"06" => "June",
			"07" => "July",
			"08" => "August",
			"09" => "September",
			"10" => "October",
			"11" => "November",
			"12" => "December"
		);
		
		foreach ($months as $key => $val)
		{
			$choice = ($key == $selected) ? "selected" : "";
			echo "$spacer<option $choice value=\"$key\">$val</option>\n";
		}
	}
	
	function daysSelectList ($spacer="", $selected="")
	{
		$days = array (
			"01" => "01",
			"02" => "02",
			"03" => "03",
			"04" => "04",
			"05" => "05",
			"06" => "06",
			"07" => "07",
			"08" => "08",
			"09" => "09",
			"10" => "10",
			"11" => "11",
			"12" => "12",
			"13" => "13",
			"14" => "14",
			"15" => "15",
			"16" => "16",
			"17" => "17",
			"18" => "18",
			"19" => "19",
			"20" => "20",
			"21" => "21",
			"22" => "22",
			"23" => "23",
			"24" => "24",
			"25" => "25",
			"26" => "26",
			"27" => "27",
			"28" => "28",
			"29" => "29",
			"30" => "30",
			"31" => "31",
		);
		
		foreach ($days as $key => $val)
		{
			$choice = ($key == $selected) ? "selected" : "";
			echo "$spacer<option $choice value=\"$key\">$val</option>\n";
		}
	}
	
	function yearsSelectList ($spacer="", $selected="")
	{
		for ($i = 2000; $i <= 2010; $i++)
		{
			$choice = ($i == $selected) ? "selected" : "";
			echo "$spacer<option $choice value=\"$i\">$i</option>\n";
		}
	}
	
	function decimal($num="0", $places=0) {
		if ($places == 0)
		{ // lop off the decimal and return a whole number
			$dec = strstr($num, '.');
			$num = str_replace($dec, '', $num);
			return $num;
		} else if ($dec = strstr($num, '.')) // set dec equal to everything from the decimal point on.
		{ // has a decimal and trailing numbers. get rid of the ones we don't need and round the decimal.
			$num = str_replace($dec, '', $num); // lop off the decimal from our whole number.
			$round = substr($dec, $places+1, 1); // grab the number right after the last decimal point to see if we should round up or leave as is.
			if ($round < 5) // leave as is.
			{
				$dec = substr($dec, 0, $places+1); // cut off what we don't need.
			} else if ($round >= 5) // round up
			{
				$rounded_number = (int)(substr($dec, $places, 1))+1;
				if ($rounded_number >= 10 && $places == 1)
				{
					$num++;
					$dec = substr($dec, 0, $places).substr($rounded_number, -1); // cut off what we don't need.
				} else
				{
					$dec = substr($dec, 0, $places).$rounded_number; // cut off what we don't need.
				}
				$dec = substr($dec, 0, $places+1); // cut off what we don't need.
			}
			$len = $dec;
			if (strlen($dec) < $places+1)
			{
				for ($i = 0; $i < (($places+1) - strlen($len)); $i++)
				{
					$dec = $dec.'0';
				}
			}
			return (is_numeric($num)) ? $num.$dec : "0".$dec;
		} else
		{ // started as a whole number. add a decimal and as many zeros as specified in the function call
			
			$addTo = is_numeric($num);
			$num = $num.".";
			for($i = 0; $i < $places; $i++)
			{
				$num.= "0";
			}
			return ($addTo) ? $num : "0".$num;
		}
	}
	
	function getOppositeServiceID ($ServiceID="")
	{
		$q = "
			SELECT	GPID
			FROM	CategoryItem
			WHERE	CategoryItemID = '".$ServiceID."'
		";
		$qr= mysql_query($q);
		$osID = mysql_fetch_array($qr);
		return $osID['GPID'];
	}
	
	function getCousinID ($ServiceID="", $CategoryItemID="")
	{
		// get opposing service id
		$osID = getOppositeServiceID($ServiceID);
		
		// get parent id
		$q = "
			SELECT	CategoryItemParent
			FROM	CategoryItem
			WHERE	CategoryItemID = '".$CategoryItemID."'
		";
		$qr= mysql_query($q);
		$pID = mysql_fetch_array($qr);
		
		// get cousin id
		$q = "
			SELECT	CategoryItemID
			FROM	CategoryItem
			WHERE	CategoryItemParent = '".$pID['CategoryItemParent']."'
			AND		ServiceID = '".$osID."'
			AND		ActiveFlag = '1'
			AND		DeleteFlag = '0'
		";
		$qr= mysql_query($q);
		$cID = mysql_fetch_array($qr);
		return $cID['CategoryItemID'];
	}
	
	
	
	
	
	
	
	
	
	
	
?>