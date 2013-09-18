<?php
if(isset($_REQUEST['did']) && $_REQUEST['did']!=''){
$did=$_REQUEST['did'];


$selectCount=mysql_fetch_array(mysql_query("SELECT viewedcount FROM dgo_user_doctor_details WHERE id='".$did."'"));

if($selectCount['viewedcount']==0)
{
$updateCount=mysql_query("UPDATE dgo_user_doctor_details SET viewedcount=1 WHERE id='".$did."'");

}
else if($selectCount['viewedcount']>0)
{

      $selectCount['viewedcount']=$selectCount['viewedcount']+1;
	 // echo "UPDATE dgo_user_doctor_details SET viewedcount=".$selectCount['viewedcount']." WHERE id='".$did;
	  $updateCount=mysql_query("UPDATE dgo_user_doctor_details SET viewedcount=".$selectCount['viewedcount']." WHERE id='".$did."'"); 

}
$doctorCondition = "WHERE id='".$did."' AND status='1'";

$doctorDetails=$doctor->getDoctor($globalUtil,$doctorCondition);

$doctorQualificationList=$doctor->getDoctorQualifications($globalUtil," WHERE dq.did='".$doctorDetails['data'][0]['doctorDetailsid']."' AND tq.status='1' AND ts.status='1' ORDER BY dq.id ASC");

$doctorGeoLocationString='';
if($doctorGeoLocation=getCountryNameByStateId($doctorDetails['data'][0]['cid'])){
$doctorGeoLocationString='+'.str_replace(array(' ','-','_','&'),'+',$doctorGeoLocation['cityName'].'+'.$doctorGeoLocation['stateName'].'+'.$doctorGeoLocation['countryName']);

$doctorGeoLocationForAddress = ', '.$doctorGeoLocation['cityName'].', '.$doctorGeoLocation['stateName'].', '.$doctorGeoLocation['countryName'];
}



if($doctorDetails['numrows']==0){
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