<?php
class db{
	function init(){
		global $host,$database,$user, $password;
		
		$db_connection = mysql_connect($host, $user, $password) or
			die ("Could Not Log On To The Database " . mysql_error());
		$db_select = mysql_select_db ($database) or
			die ("Could not select the specified database. " . mysql_error());
	}
	
	function executeQuery($query){
		global $system;
		
		$system->querys.=$query.'<br />';
		$result=mysql_query($query);
		if (!$result) {
	    $system->querys.= mysql_error().'<br />';
		}else{
			return $result;
		}
	}
	
	function debugQuery($query){
		global $system;
		
		$system->querys.=$query.'<br />';
	}
	
	function executeFetchObject($query){
		$result=db::executeQuery($query);
		$row=mysql_fetch_object($result);
		return($row);
	}
	function getResult($table,$query_extra=''){
		$query = "SELECT * from $table ";
		$query .="$query_extra";
		$result=db::executeQuery($query);
		return $result;
	}
	
	function getResultByColumn($table,$column,$value,$query_extra=''){
		$query = "SELECT * from $table where $column='$value' ";
		$query .="$query_extra";
		$result=db::executeQuery($query);
		return $result;
	}
	function getResultByColumns($table,$columns,$query_extra=''){
		foreach($columns as $column=>$value){
			$where.="$column='$value' and ";
		}
		$where=substr($where, 0, -4);  
		$query = "SELECT * from $table where $where ";
		$query .="$query_extra";
		$result=db::executeQuery($query);
		return $result;
	}
	function fetchObject($table,$tableid){
		$query = "SELECT * from $table where {$table}id = $tableid";
		$result=db::executeQuery($query);
		$row=mysql_fetch_object($result);
		return $row;
	}
	
	function fetchObjectByColumn($table,$column,$value,$extra=''){
		$query = "SELECT * from $table where $column='$value'";
		$query .= "$extra";
		$result=db::executeQuery($query);
		$row=mysql_fetch_object($result);
		return($row);
	}
	function fetchObjectByColumns($table,$columns){
		$query = "SELECT * from $table where ";
		foreach($columns as $column=>$value){
			$where.="$column='$value' and ";
		}
		$where=substr($where, 0, -4);  
		$query.=$where;
		$result=db::executeQuery($query);
		$row=mysql_fetch_object($result);
		return($row);
	}
	function getRelationResult($table1,$table2,$id1,$extra=''){
		$relation_table=$table1.$table2;
		$query = "SELECT * from  $table2,$relation_table ";
		$query .= "WHERE $relation_table.{$table1}id =  $id1 ";
		$query .= "AND {$table2}.{$table2}id =  {$relation_table}.{$table2}id ";
		$query .= "$extra";
		$result=db::executeQuery($query);
		return $result;
	}
	
	function update($table,$id,$columns,$debug=false){
		foreach($columns as $column=>$value){
			$sets.="$column=$value,";
		}
		$sets=rtrim($sets,',');
		$query="update $table set $sets where {$table}id = $id";
		if($debug){
			db::debugQuery($query);
		}else{
			db::executeQuery($query);
		}
	}
	function updateByColumn($table,$column,$id,$columns,$debug=false){
		foreach($columns as $set_column=>$value){
			$sets.="$set_column=$value,";
		}
		$sets=rtrim($sets,',');
		$query="update $table set $sets where $column = $id";
		if($debug){
			db::debugQuery($query);
		}else{
			db::executeQuery($query);
		}
	}
	function updateByColumns($table,$columns,$values,$debug=false){
		foreach($values as $set_column=>$value){
			$sets.="$set_column=$value,";
		}
		$sets=rtrim($sets,',');
		foreach($columns as $column=>$value){
			$where.="$column=$value and ";
		}
		$where=substr($where, 0, -4);  
		$query="update $table set $sets where $where";
		if($debug){
			db::debugQuery($query);
		}else{
			db::executeQuery($query);
		}
	}
	function insert($table,$columns,$debug=false){
		foreach($columns as $column=>$value){
			$sets.="$column=$value,";
		}
		$sets=rtrim($sets,',');
		$query="insert $table set $sets ";
		if($debug){
			db::debugQuery($query);
		}else{
			db::executeQuery($query);
			return mysql_insert_id();
		}
	}
	function delete($table,$id,$debug=false){
		$query="delete from $table where {$table}id='$id'";
		if($debug){
			db::debugQuery($query);
		}else{
			db::executeQuery($query);
		}
	}
	function deleteByColumn($table,$column,$value,$debug=false){
		$query="delete from $table where $column='$value'";
		if($debug){
			db::debugQuery($query);
		}else{
			db::executeQuery($query);
		}
	}
	function deleteByColumns($table,$columns,$debug=false){
		$query = "delete from $table where ";
		foreach($columns as $column=>$value){
			$where.="$column=$value and ";
		}
		$where=substr($where, 0, -4);  
		$query.=$where;
		if($debug){
			db::debugQuery($query);
		}else{
			db::executeQuery($query);
		}
	}
	function addQuotes(&$sets){
		while (list($variable, $value) = each ($sets)) {
	    $sets[$variable]="'$value'";
		}
	}
}

?>