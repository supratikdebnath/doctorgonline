<?php
if(isset($_REQUEST['pid']) && $_REQUEST['pid']!=''){
$pid=$_REQUEST['pid'];

$selectCount=mysql_fetch_array(mysql_query("SELECT viewedcount FROM dgo_user_pathology_details WHERE id='".$pid."'"));

if($selectCount['viewedcount']==0)
{
$updateCount=mysql_query("UPDATE dgo_user_pathology_details SET viewedcount=1 WHERE id='".$pid."'");

}
else if($selectCount['viewedcount']>0)
{

      $selectCount['viewedcount']=$selectCount['viewedcount']+1;
	 // echo "UPDATE dgo_user_doctor_details SET viewedcount=".$selectCount['viewedcount']." WHERE id='".$did;
	  $updateCount=mysql_query("UPDATE dgo_user_pathology_details SET viewedcount=".$selectCount['viewedcount']." WHERE id='".$pid."'"); 

}
$pathologyCondition = "WHERE id='".$pid."' AND status='1'";
$pathologyDetails=$pathology->getPathology($globalUtil,$pathologyCondition);


$pathologyGeoLocationString='';
if($pathologyGeoLocation=getCountryNameByStateId($pathologyDetails['data'][0]['cid'])){
$pathologyGeoLocationString='+'.str_replace(array(' ','-','_','&'),'+',$pathologyGeoLocation['cityName'].'+'.$pathologyGeoLocation['stateName'].'+'.$pathologyGeoLocation['countryName']);

$pathologyGeoLocationForAddress = ', '.$pathologyGeoLocation['cityName'].', '.$pathologyGeoLocation['stateName'].', '.$pathologyGeoLocation['countryName'];
}



if($pathologyDetails['numrows']==0){
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