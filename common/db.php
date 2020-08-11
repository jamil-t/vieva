<?php
function get_records($table,$where="",$sort="",$limit="",$fields="*",$show="")
{
	global $conn;
	
	$sql = "SELECT ".$fields." FROM `".$table."`";
	
	if($where != "")
	{
		$sql .= " WHERE ".$where;
	}
	if($sort != "")
	{
		$sql .= " ORDER BY ".$sort;
	}
	if($limit != "")
	{
		$sql .= " LIMIT ".$limit;
	}
	if($show){
		echo "SQL: ".$sql;
	}

	$result = mysqli_query($conn,$sql);
	$array = array();
	while($row = @mysqli_fetch_assoc($result))
	{
		$temp_array = array();
		foreach($row as $index=>$temp){
			$temp_array[$index] = stripslashes($temp);
		}
		$array[] = $temp_array;
	}

	return $array;
}

function sql($sql)
{
	global $conn;
	//echo $sql;exit;
	$result = mysqli_query($conn,$sql);
	$array = array();
	while($row = @mysqli_fetch_assoc($result))
	{
		$temp_array = array();
		foreach($row as $index=>$temp){
			$temp_array[$index] = stripslashes($temp);
		}
		$array[] = $temp_array;
	}	
	return $array;
}

function delete_records($table,$where="",$show="")
{
	global $conn;
	$sql = "DELETE FROM $table";
	if($where != "")
	{
		$sql .= " WHERE $where";
	}
	if($show){
		echo "SQL: ".$sql;
	}
	$result = mysqli_query($conn,$sql);
	return $result;
}

function insert_record($table,$data,$show="")
{
	
	global $conn;
	
	$sql = "INSERT INTO ".$table." SET ";
	if(count($data)>0){
		$comma = '';
		foreach($data as $k=>$v){
			$sql .= $comma." `$k` = '".addslashes($v)."'";
			$comma = ', ';
		}
	}
	if($show){
		echo "<br>SQL: ".$sql;
	}

	$result = mysqli_query($conn,$sql);
	$id = 0;
	if($result){
		$id = mysqli_insert_id($conn);
	}
	
	return $id;
}

function update_record($table,$data=array(),$condition=array(),$show="")
{
	global $conn;
	
	  $sql = "UPDATE ".$table." SET ";
	if(count($data)>0){
		$comma = '';
		foreach($data as $k=>$v){
			$sql .= $comma." `$k` = '".addslashes($v)."'";
			$comma = ', ';
			
		}
	}
	if(count($condition)>0){
		$and = '';
		$sql .= ' WHERE ';
		foreach($condition as $k=>$v){
			$sql .= $and." `$k` = '".$v."'";
			$and = ' AND ';
		}
	}
	if($show){
		echo "SQL: ".$sql;
	}
	$result = mysqli_query($conn,$sql);
	return $result;
}
function table_fields($table)
{
	global $conn;
	$sql = "SHOW COLUMNS FROM ".$table;
	$result = mysqli_query($conn,$sql);
	$array = array();
	while($row = mysqli_fetch_array($result))
	{
		$array[$row['Field']] = '';
	}
	return $array;
}
?>