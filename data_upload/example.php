<?php
error_reporting(0);
mysql_connect("localhost","thinkdmn_dgodev","Nych]4#(ULMq");
mysql_select_db("thinkdmn_doctorgonline_dev");
require_once 'excel_reader2.php';
  if ($_FILES["file"]["error"] > 0)
    {
   	 	echo "Return Code: " . $_FILES["file"]["error"] . "<br>"; die;
    }
  else
    {
		move_uploaded_file($_FILES["file"]["tmp_name"],
      "" . $_FILES["file"]["name"]);
      echo "Successfully Uploaded";
	}
$data = new Spreadsheet_Excel_Reader($_FILES["file"]["name"]);
?>
<html>
<head>
<style>
table.excel {
	border-style:ridge;
	border-width:1;
	border-collapse:collapse;
	font-family:sans-serif;
	font-size:12px;
}
table.excel thead th, table.excel tbody th {
	background:#CCCCCC;
	border-style:ridge;
	border-width:1;
	text-align: center;
	vertical-align:bottom;
}
table.excel tbody th {
	text-align:center;
	width:20px;
}
table.excel tbody td {
	vertical-align:bottom;
}
table.excel tbody td {
    padding: 0 3px;
	border: 1px solid #EEEEEE;
}
</style>
</head>

<body>
<?php 
//echo $data->dump(true,true); 

$values="";
$zone="";
$state="";
$city ="";
$area ="";
$specid="";

for($j=2;$j<=$data->rowcount($sheet_index=0);$j++){ 
if($data->val($j,'I')!=""){ 
			$sqlzone = "select * from dgo_zones where zoneName='".$data->val($j,'I')."'";
			$reszone = mysql_query($sqlzone);
			if(mysql_num_rows($reszone)>0){ 
				while($reczone = mysql_fetch_object($reszone)){
					$zone = $reczone->id;
				}
			}
			else{
			$sqlzone="insert into dgo_zones (zoneName,createDt,status) values ('".$data->val($j,'I')."','1355078535','1')";
			mysql_query($sqlzone);
			$sqlzone = "select * from dgo_zones order by id desc limit 0,1";
			$reszone = mysql_query($sqlzone);
			while($reczone  =  mysql_fetch_object($reszone)){
				$zone = $reczone->id;
			}
		}
		}else{
			$zone = "";
		}
		
		if($data->val($j,'H')!=""){
			$sqlstate = "select * from dgo_states where stateName='".$data->val($j,'H')."'";
			$resstate = mysql_query($sqlstate);
			if(mysql_num_rows($resstate)>0){
				while($recstate = mysql_fetch_object($resstate)){
					$state = $recstate->id;
				}
			}
			else{
				$sqlstate="insert into dgo_states (cid,stateName,createDt,status) values ('1','".$data->val($j,'H')."','1355078535','1')";
				mysql_query($sqlstate);
				$sqlstate = "select * from dgo_states order by id desc limit 0,1";
				$resstate = mysql_query($sqlstate);
				while($recstate  =  mysql_fetch_object($resstate)){
					$state = $recstate->id;
				}
			}
		
		}else{
			$state="";
		}
		
		
		//echo $data->val(19,'B',1);
		//$sql = "insert into dgo_user_doctor_details () values()";
		if($data->val($j,'G')!=""){
		$citysql = "select * from dgo_city where cityName='".$data->val($j,'G')."'";
		$cityres = mysql_query($citysql);
		$numcity = mysql_num_rows($cityres);
		if($numcity>0){
			while($reccity = mysql_fetch_object($cityres)){ 
				$city = $reccity->id;
			}
		}
		else{ 
				$citysql="insert into dgo_city (sid,zid,cityName,createDt,status) values ('".$state."','".$zone."','".$data->val($j,'G')."','1355078535','1')";
				mysql_query($citysql);
				$citysql = "select * from dgo_city order by id desc limit 0,1";
				$cityres = mysql_query($citysql);
				while($reccity  =  mysql_fetch_object($cityres)){
					$city = $reccity->id;
				}
			}
		}
		else{
			$city = "";
		}
		
		
		if($data->val($j,'J')!=""){
			$sqlarea = "select * from dgo_areas where areaName='".$data->val($j,'J')."'"; 
			$resarea = mysql_query($sqlarea);
			if(mysql_num_rows($resarea)>0){
				while($recarea = mysql_fetch_object($resarea)){
					$area = $recarea->id;
				}
			}else{
				$sqlarea="insert into dgo_areas (areaName,sid,zid,createDt,status) values ('".$data->val($j,'J')."','".$state."','".$zone."','1355078535','1')";
				mysql_query($sqlarea);
				$sqlarea = "select * from dgo_city order by id desc limit 0,1";
				$resarea = mysql_query($sqlarea);
				while($recarea  =  mysql_fetch_object($resarea)){
					$area = $recarea->id;
				}
			}
		
		}else{
			$area="";
		}
		
		
		if($data->val($j,'S')!=""){
			$sqlspecid = "select * from dgo_specialization where specName='".$data->val($j,'S')."'"; 
			$resspecid = mysql_query($sqlspecid);
			if(mysql_num_rows($resspecid)>0){
				while($recspecid = mysql_fetch_object($resspecid)){
					$specid = $recspecid->id;
				}
			}else{
				$sqlspecid="insert into dgo_specialization (specName,createDt,status) values ('".$data->val($j,'S')."','1355078535','1')";
				mysql_query($sqlspecid);
				$sqlspecid = "select * from dgo_specialization order by id desc limit 0,1";
				$resspecid = mysql_query($sqlspecid);
				while($recspecid  =  mysql_fetch_object($resspecid)){
					$specid = $recspecid->id;
				}
			}
		
		}else{
			$specid="";
		}
		
		
		
	for($i=1;$i<=$data->colcount($sheet_index=0);$i++){
		$values.= "'";
		if($i==19){
			$values.= $specid;
		}
		else if($i==10){
			$values.= $area;
		}
		else if($i==9){
			$values.= $zone;
		}
		else if($i==8){
			$values.= $state;
		}
		else if($i==7){
			$values.= $city;
		}
		else{
			$values.=$data->val($j,$i);
		}
		$values.= "'";
		if($i<$data->colcount($sheet_index=0)){
			$values.=",";
		}
		
	}
	
	$sql = "INSERT INTO `dgo_user_doctor_details` (`firstName`, `lastName`, `middleName`, `gender`, `dateOfBirth`, `address`, `cid`, `sid`, `zid`, `aid`, `pincode`, `emailAlternate`, `website`, `mobileNo`, `phoneNo`, `phoneNoAlternate`, `fax`, `creditCardAccept`, `specid`, `available24Hrs`, `about`, `yearsOfExp`, `registrationNo`, `designation`, `consultancyFees`, `doctorImg`, `featured_value`, `status`) VALUES  (".$values.")";
	mysql_query($sql);
}
?>
</body>
</html>
