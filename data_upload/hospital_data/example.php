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
$type="";
$category="";
$accreditation="";
$facilities="";
$discipline = "";


for($j=2;$j<=$data->rowcount($sheet_index=0);$j++){ 
if($data->val($j,'F')!=""){ 
			$sqlzone = "select * from dgo_zones where zoneName='".$data->val($j,'F')."'";
			$reszone = mysql_query($sqlzone);
			if(mysql_num_rows($reszone)>0){ 
				while($reczone = mysql_fetch_object($reszone)){
					$zone = $reczone->id;
				}
			}
			else{
			$sqlzone="insert into dgo_zones (zoneName,createDt,status) values ('".$data->val($j,'F')."','1355078535','1')";
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
		
		if($data->val($j,'E')!=""){
			$sqlstate = "select * from dgo_states where stateName='".$data->val($j,'E')."'";
			$resstate = mysql_query($sqlstate);
			if(mysql_num_rows($resstate)>0){
				while($recstate = mysql_fetch_object($resstate)){
					$state = $recstate->id;
				}
			}
			else{
				$sqlstate="insert into dgo_states (cid,stateName,createDt,status) values ('1','".$data->val($j,'E')."','1355078535','1')";
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
		if($data->val($j,'D')!=""){
		$citysql = "select * from dgo_city where cityName='".$data->val($j,'D')."'";
		$cityres = mysql_query($citysql);
		$numcity = mysql_num_rows($cityres);
		if($numcity>0){
			while($reccity = mysql_fetch_object($cityres)){ 
				$city = $reccity->id;
			}
		}
		else{ 
				$citysql="insert into dgo_city (sid,zid,cityName,createDt,status) values ('".$state."','".$zone."','".$data->val($j,'D')."','1355078535','1')";
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
		
		
		if($data->val($j,'G')!=""){
			$sqlarea = "select * from dgo_areas where areaName='".$data->val($j,'G')."'"; 
			$resarea = mysql_query($sqlarea);
			if(mysql_num_rows($resarea)>0){
				while($recarea = mysql_fetch_object($resarea)){
					$area = $recarea->id;
				}
			}else{
				$sqlarea="insert into dgo_areas (areaName,sid,zid,createDt,status) values ('".$data->val($j,'G')."','".$state."','".$zone."','1355078535','1')";
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
		
		if($data->val($j,'W')!=""){
			$sqlarea = "select * from dgo_hospital_type where typeName='".$data->val($j,'W')."'"; 
			$resarea = mysql_query($sqlarea);
			if(mysql_num_rows($resarea)>0){
				while($recarea = mysql_fetch_object($resarea)){
					$type = $recarea->id;
				}
			}else{
				$sqlarea="insert into dgo_hospital_type (typeName,status) values ('".$data->val($j,'W')."','1')";
				mysql_query($sqlarea);
				$sqlarea = "select * from dgo_hospital_type order by id desc limit 0,1";
				$resarea = mysql_query($sqlarea);
				while($recarea  =  mysql_fetch_object($resarea)){
					$type = $recarea->id;
				}
			}
		
		}else{
			$type="";
		}
		
		if($data->val($j,'X')!=""){
			$sqlarea = "select * from dgo_hospital_category where categoryName='".$data->val($j,'X')."'"; 
			$resarea = mysql_query($sqlarea);
			if(mysql_num_rows($resarea)>0){
				while($recarea = mysql_fetch_object($resarea)){
					$category = $recarea->id;
				}
			}else{
				$sqlarea="insert into dgo_hospital_category (categoryName,status) values ('".$data->val($j,'X')."','1')";
				mysql_query($sqlarea);
				$sqlarea = "select * from dgo_hospital_category order by id desc limit 0,1";
				$resarea = mysql_query($sqlarea);
				while($recarea  =  mysql_fetch_object($resarea)){
					$category = $recarea->id;
				}
			}
		
		}else{
			$category="";
		}
		
		
		if($data->val($j,'Y')!=""){
			$sqlarea = "select * from dgo_hospital_accreditations where accreditationName='".$data->val($j,'Y')."'"; 
			$resarea = mysql_query($sqlarea);
			if(mysql_num_rows($resarea)>0){
				while($recarea = mysql_fetch_object($resarea)){
					$accreditation = $recarea->id;
				}
			}else{
				$sqlarea="insert into dgo_hospital_accreditations (accreditationName,status) values ('".$data->val($j,'Y')."','1')";
				mysql_query($sqlarea);
				$sqlarea = "select * from dgo_hospital_accreditations order by id desc limit 0,1";
				$resarea = mysql_query($sqlarea);
				while($recarea  =  mysql_fetch_object($resarea)){
					$accreditation = $recarea->id;
				}
			}
		
		}else{
			$accreditation="";
		}
		if($data->val($j,'Z')!=""){
			$arr = explode(",",$data->val($j,'Z'));
			for($k=0;$k<count($arr);$k++){
			$sqlarea = "select * from dgo_hospital_facilities where facilityName='".$arr[$k]."'"; 
			$resarea = mysql_query($sqlarea);
			if(mysql_num_rows($resarea)>0){
				while($recarea = mysql_fetch_object($resarea)){
					$facilities .= $recarea->id;
				}
			}else{
				$sqlarea="insert into dgo_hospital_facilities (facilityName,status) values ('".$arr[$k]."','1')";
				mysql_query($sqlarea);
				$sqlarea = "select * from dgo_hospital_facilities order by id desc limit 0,1";
				$resarea = mysql_query($sqlarea);
				while($recarea  =  mysql_fetch_object($resarea)){
					$facilities .= $recarea->id;
				}
			}
				if(($k+1)<count($arr)){
					$facilities.=",";
				}
			}
		}else{
			$facilities="";
		}
		
		
		
		
		
		
		if($data->val($j,'AA')!=""){
			$arr = explode(",",$data->val($j,'AA'));
			for($k=0;$k<count($arr);$k++){
			$sqlarea = "select * from dgo_hospital_discipline where disciplineName='".$arr[$k]."'"; 
			$resarea = mysql_query($sqlarea);
			if(mysql_num_rows($resarea)>0){
				while($recarea = mysql_fetch_object($resarea)){
					$discipline .= $recarea->id;
				}
			}else{
				$sqlarea="insert into dgo_hospital_discipline (disciplineName,status) values ('".$arr[$k]."','1')";
				mysql_query($sqlarea);
				$sqlarea = "select * from dgo_hospital_discipline order by id desc limit 0,1";
				$resarea = mysql_query($sqlarea);
				while($recarea  =  mysql_fetch_object($resarea)){
					$discipline .= $recarea->id;
				}
			}
				if(($k+1)<count($arr)){
					$discipline.=",";
				}
			}
		}else{
			$discipline="";
		}
		
		
		
		
		
		
	for($i=2;$i<=$data->colcount($sheet_index=0);$i++){
		$values.= "'";
		
		if($i==27){
			$values.= $discipline;
		}
		
		else if($i==26){
			$values.= $facilities;
		}
		
		else if($i==25){
			$values.= $accreditation;
		}
		else if($i==24){
			$values.= $category;
		}
		else if($i==23){
			$values.= $type;
		}
		else if($i==7){
			$values.= $area;
		}
		else if($i==6){
			$values.= $zone;
		}
		else if($i==5){
			$values.= $state;
		}
		else if($i==4){
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
	
	echo $sql = "INSERT INTO `thinkdmn_doctorgonline_dev`.`dgo_user_hospital_details` (`hospitalName`, `address`, `cid`, `sid`, `zid`, `aid`, `pincode`, `emailAlternate`, `website`, `phoneNo`, `phoneNoAlternate`, `fax`, `creditCardAccept`, `available24Hrs`, `about`, `registrationNo`, `hospitalImg`, `hospitalImgDetails`, `medicoLegalCases`, `noOfBeds`, `authorizedBy`, `htid`, `hcid`, `haid`, `hfid`, `hdid`, `YrofEstablishment`, `otherFacility`, `oPDContactNoAvailable`, `oPDContactNo`, `bloodBankNoAvailable`, `bloodBankNo`, `emergencyServiceNoAvailable`, `emergencyServiceNo`, `eyeBankNoAvailable`, `eyeBankNo`, `organBankNoAvailable`, `organBankNo`, `ambulenceNoAvailable`, `ambulenceNo`, `healthInsurenceTieUpsNoAvailable`, `healthInsurenceTieUpsNo`, `guestHouseNoAvailable`, `guestHouseNo`, `status`,featured_value,createDt) VALUES (".$values.",'1','1365144921');";
	mysql_query($sql);
}
?>
</body>
</html>
