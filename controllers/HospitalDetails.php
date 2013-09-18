<?php
if(isset($_REQUEST['hid']) && $_REQUEST['hid']!=''){
$hid=$_REQUEST['hid'];

$selectCount=mysql_fetch_array(mysql_query("SELECT viewedcount FROM dgo_user_hospital_details WHERE id='".$hid."'"));

if($selectCount['viewedcount']==0)
{
$updateCount=mysql_query("UPDATE dgo_user_hospital_details SET viewedcount=1 WHERE id='".$hid."'");

}
else if($selectCount['viewedcount']>0)
{

      $selectCount['viewedcount']=$selectCount['viewedcount']+1;
	 // echo "UPDATE dgo_user_doctor_details SET viewedcount=".$selectCount['viewedcount']." WHERE id='".$did;
	  $updateCount=mysql_query("UPDATE dgo_user_hospital_details SET viewedcount=".$selectCount['viewedcount']." WHERE id='".$hid."'"); 

}
$hospitalCondition = "WHERE id='".$hid."' AND status='1'";
$hospitalDetails=$hospital->getHospital($globalUtil,$hospitalCondition);


$hospitalGeoLocationString='';
if($hospitalGeoLocation=getCountryNameByStateId($hospitalDetails['data'][0]['cid'])){
$hospitalGeoLocationString="'+'".str_replace(array(' ','-','_','&'),'+',$hospitalGeoLocation['cityName']."+".$hospitalGeoLocation['stateName']."+".$hospitalGeoLocation['countryName']);

$hospitalGeoLocationForAddress = ', '.$hospitalGeoLocation['cityName'].', '.$hospitalGeoLocation['stateName'].', '.$hospitalGeoLocation['countryName'];

$googleMapAddressString= str_replace(array(' ','-','_','&'),"+",$hospitalDetails['data'][0]['hospitalName']).$globalUtil->removeLineBreakHTML(str_replace(array(' ','-','_','&'),"+",$hospitalDetails['data'][0]['address'])).$hospitalGeoLocationString;
//echo $googleMapAddressString;

$googleMapAddressParameter=$globalUtil->removeLineBreakHTML(str_replace(' ','+',$hospitalDetails['data'][0]['address']));
//echo $googleMapAddressParameter; die();
//echo $googleMapAddressString; die();

$hospitalPathology=$hospital->getHospitalPathology($globalUtil,"WHERE hid='".$hid."'");
$hospitalPathologyAccredition=$hospital->getHospitalAccreditation($globalUtil,$condition="WHERE id='".$hospitalPathology['data'][0]['haid']."' AND status='1'");

//print_r($hospitalPathologyAccredition);
$hospitalPathologyAccreditionName=$hospitalPathologyAccredition[0]['accreditationName'];
}



if($hospitalDetails['numrows']==0){
	$globalUtil->redirectUrl($globalUtil->generateUrl(MAIN_SITE_URL."index.php"));
	}
}
else{
	$globalUtil->redirectUrl($globalUtil->generateUrl(MAIN_SITE_URL."index.php"));
	}
	
function getCountryNameByStateId($id){
	global $globalUtil;
	$state=new City;
	$countryDetails=$state->getCity($globalUtil,"WHERE city.id='".$id."'");
	if($countryDetails['numrows']>0){
			return $countryDetails['data'][0];
		}
	else {	return '';};	
	}	
?>