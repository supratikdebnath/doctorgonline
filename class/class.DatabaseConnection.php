<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################
class DatabaseConnection{
 public function __construct($hostname,$username,$password,$dbname){
	 	$conn=mysql_connect($hostname,$username,$password) or die("<h1>".mysql_error()."<br />"."Error In Connecting Database"."</h1>");
		$db=mysql_select_db($dbname,$conn) or die("<h1>".mysql_error()."<br />"."Error in Selecting Database"."</h1>");
		}
  public static function sqlQuery($sql,$type){
	  if($type==1){// Returns only query
	  $res=mysql_query($sql);
	  }
	  if($type==2){// Returns no of rows effected by query
	  $res=mysql_query($sql);
	  $res=mysql_affected_rows();
	  }
	  return $res;
  }
  public static function sqlNumRows($sql,$type){
	  if($type==1){// Returns only number of rows
	  $res=@mysql_num_rows($sql);
	  }
	  if($type==2){// Result executes the query and returns number of rows
	  $res=self::sqlQuery($sql,1);
	  $res=mysql_num_rows($res);
	  }
	  return $res;
  }
  public static function sqlFetchRowsAssoc($sql,$type){
	  if($type==1){// Only Return Rows,Associative Data Array
	  $numofrows=self::sqlNumRows($sql,1);
	  $res_array=array("numrows"=>$numofrows);
	  if($numofrows>0){
	  while($data=mysql_fetch_assoc($sql)){
		  $res_array['data'][]=$data;	  
		  }
	  }
	  else{
		 	$res_array['data'][0]="No Record Found";
		  }
	  }
	  if($type==2){// Result executes the query,return Rows,Associative Data Array
	  $sql=self::sqlQuery($sql,1);
	  $numofrows=self::sqlNumRows($sql,1);
	  $res_array=array("numrows"=>$numofrows);
	  if($numofrows>0){
	  while($data=mysql_fetch_assoc($sql)){
	        $res_array['data'][]=$data;
		  }
	  }
	  else{
		 	$res_array['data'][0]="No Record Found";
		  }
	  }
	  return $res_array;
  }
  public static function sqlFetchRowsArray($sql,$type){
	  if($type==1){// Only Return Rows,Both Numeric & Associative Data Array
	  $numofrows=self::sqlNumRows($sql,1);
	  $res_array=array("numrows"=>$numofrows);
	  if($numofrows>0){
	  while($data=mysql_fetch_array($sql)){
		  $res_array['data'][]=$data;	  
		  }
	  }
	  else{
		 	$res_array['data'][0]="No Record Found";
		  }
	  }
	  if($type==2){// Result executes the query,return Rows,Both Numeric & Associative Data Array
	  $sql=self::sqlQuery($sql,1);
	  $numofrows=self::sqlNumRows($sql,1);
	  $res_array=array("numrows"=>$numofrows);
	  if($numofrows>0){
	  while($data=mysql_fetch_array($sql)){
		  $res_array['data'][]=$data;	  
		  }
	  }
	  else{
		 	$res_array['data'][0]="No Record Found";
		  }
	  }
	  return $res_array;
  }
  public static function sqlinsert($data,$tablename,$type=1){//Insert Data Into Table
	  $fields="";
	  $values="";
	  if($type==1)
	  {
		  $fields .= "(";
		  $values .= "(";
		  foreach($data as $key => $val)
		  {
			  $fields .= $key.",";
			  $values .= "'".mysql_escape_string($val)."',";
		  }
		  $fields = rtrim($fields,',').")";
		  $values = rtrim($values,',').")";
		  
		  $sql = "INSERT INTO ".$tablename." ".$fields." VALUES ".$values;
		  //echo $sql;
		  //die();
		  $res  = self::sqlQuery($sql,2);
		  
	  }
	  else if($type==2){
		  $datastring="";
		  foreach($data as $field => $val)
		  {
			  $datastring .= $field."='".mysql_escape_string($val)."',";
		  }
		  $datastring = rtrim($datastring,',');	  
	  	   
	      $sql="INSERT INTO ".$tablename." SET ".$datastring;
		  //echo $sql;
		  //die();
		  $res  = self::sqlQuery($sql,2);
	  }
	  $lastInsertId=mysql_insert_id();
	  return $lastInsertId;
  }
  public static function sqlupdate($data,$condition="",$tablename){//Update Data in Table
		  $datastring="";
		  foreach($data as $field => $val)
		  {
			  $datastring .= $field."='".mysql_escape_string($val)."',";
		  }
		  $datastring = rtrim($datastring,',');	  
	  	   
	      $sql="UPDATE ".$tablename." SET ".$datastring." ".$condition;
		  //echo $sql;
		  //die();
		  $res  = self::sqlQuery($sql,2);
		  return $res;
  }  
  public static function sqldelete($tablename,$condition){ // Delete data from table
		  $sqlquery="DELETE FROM ".$tablename." ".$condition;
		  $res  = self::sqlQuery($sqlquery,2);
		  return $res;
  }
}
?>