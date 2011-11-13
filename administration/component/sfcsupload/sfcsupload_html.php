<?php
class sfcsuploadHTML{
	function edit(){
		global $system;
		
		$system->breadcrumbs['Sales Forecast Upload']='';
		$result=db::getResult('administrators','order by name');
?>
<br />
<form method="post" enctype="multipart/form-data" action="index.php?comp=sfcsupload&task=upload">
<table style="margin-left:50px;"border="0" cellpadding="5" cellspacing="0" bgcolor="#eeeeee">
	<tr bgcolor="#dddddd">
		<td colspan="3"><strong>Upload Sales Forecast Data</strong><?php echo ($result>-1) ? " - ".$results[$result] : ""; ?></td>
	</tr>
	<tr><td width="25">&nbsp;</td><td colspan="2"><br /></td></tr>
	<tr>
		<td width="25">&nbsp;</td>
		<td colspan="2">
			<span style="font-weight: bold;">Sample CSV Format: <span style="color: red;">*Include Column Headers</span></span>
			<br />
			VehicleID, BodyStyle, 2002, 2003, 2004, 2005, 2006, 2007
		</td>
	</tr>
	
	<tr><td width="25">&nbsp;</td><td colspan="2"><br /></td></tr>
	<tr>
		<td width="25">&nbsp;</td>
		<td align="right">Starting Year:</td>
		<td>
			<select name="start_year">
				<?php
					for ($i = 1987; $i < (date("Y") + 20); $i++)
					{
						echo "<option value=\"$i\">$i</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td width="25">&nbsp;</td>
		<td align="right">Number of Years:</td>
		<td>
			<select name="num_years">
				<?php
					for ($i = 1; $i < 26; $i++)
					{
						echo "<option value=\"$i\">$i</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td width="25">&nbsp;</td>
		<td align="right">File:</td>
		<td><input type="file" name="csv" accept="text/plain" /></td>
	</tr>
	<tr>
		<td width="25">&nbsp;</td>
		<td>&nbsp;</td>
		<td><input type="submit" name="submit" value="Upload" /></td>
	</tr>
	<tr><td width="25">&nbsp;</td><td colspan="2"><br /></td></tr>
</table>
</form>
<?php
	}
	
	function recalculate(){
		global $system;
		
		$system->breadcrumbs['Sales Forecast Upload']='index.php?comp=sfcsupload';
		$system->breadcrumbs['Recalculate Totals']='';
?>
<br /><br /><br /><br /><br />
<form action="" method="post">
	<input type="hidden" name="op"  value=""/>
<table style="margin-left:200px">
	<tr>
		<td align="right">
			Start Year:
		</td>
		<td>
			<select name="start_year" >
				<?for($year=1987;$year <= date("Y")+10;$year++ ){?>
				<option ><?php echo $year?></option>
				<?}?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right">
			Number of Years:
		</td>
		<td>
			<select name="num_years" >
				<?for($year=1;$year < 25;$year++ ){?>
				<option ><?php echo $year?></option>
				<?}?>
			</select>
		</td>
	</tr>
  <tr>
     <td colspan="2"><input type="submit" value="Recalculate Totals" onclick="this.form.op.value='recalc'"/></td>
  </tr>
  <tr>
     <td colspan="2"><input type="submit" value="CSV" onclick="this.form.op.value='csv'"/></td>
  </tr>
</table>
</form>
<?php
	}
}
?>