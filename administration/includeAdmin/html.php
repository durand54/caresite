<?php
class html{

	function getInput($method,$param,$default=''){
//		$count = count($method);
//if($param == 'task' && $default == 'list'){echo "THIS IS COUNT $count of METHOD<br />THIS IS METHOD $method[comp]<br />THIS IS $param<br />THIS IS $default<br />";}
		$input = '';
		if($param != ''){
		$input=$method[$param];
		}
//		echo "this is $input";
		$input = $input==''?$default:$input;
//		echo "this is input $default this is $input";
		return $input;
		
	}
	
	function selectOptions($result,$option,$value,$selected_value=''){
		while($row=mysql_fetch_object($result)){
			$selected=$row->$value==$selected_value?'selected="selected"':'';
?>
	<option value="<?php echo  $row->$value; ?>" <?php echo $selected; ?>><?php echo $row->$option; ?></option>
<?php	}
	}
	function getPosts($fields,$html){
		global $system;
		
		foreach($fields as $name=>$require){
			$value=html::getInput($_POST,$name);
			$sets[$name]=$value;
			$html->$name=$value;
			if($require&&$value==''){
				$system->errors[]="$require is required.";
			}
		}
		return $sets;
	}
}


?>