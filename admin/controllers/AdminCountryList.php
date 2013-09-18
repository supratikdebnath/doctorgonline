<?php
$countryList=new Country;
/*If Delete Requested Starts*/
if(isset($_GET['id']) && isset($_GET['do'])){
$id=$_GET['id'];
$action=$_GET['do'];
if($action=='del' && $id!=''){
	
	//$globalUtil->printValue($id);
	$sqlExists="SELECT * FROM ".TABLE_COUNTRIES." WHERE id='".$id."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	//$globalUtil->printValue($ifExists);
	if($ifExists>0){
	if($countryList->deleteCountry($globalUtil,$adminUtil,$id)!=0){
	$msgInfo->setMessage("listcountrymsg",SUCCESS_MSG_COUNTRY_DELETE,"successmsg");
	$msgInfo->saveMessage();
	}
	else{
	$msgInfo->setMessage("listcountrymsg",ERROR_MSG_COUNTRY_DELETE,"errormsg");
	$msgInfo->saveMessage();	
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."CountryList.php"));
	
	}
	else{
	$msgInfo->setMessage("listcountrymsg",ERROR_MSG_COUNTRY_EXISTS,"errormsg");
	$msgInfo->saveMessage();
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."CountryList.php"));	
	}
}
/*If Delete Requested Ends*/
if($action=='status' && $id!=''){
	$currentStatus=$countryList->checkCurrentStatus($globalUtil,$id);
	if($currentStatus==0){
		$data=array("status"=>1);
		if($countryList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listcountrymsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."CountryList.php"));
			}
		 else{
			$msgInfo->setMessage("listcountrymsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."CountryList.php"));
			 }	
		}// Change from Inactive to Active

	else if($currentStatus==1){ // Change from Active to Inactive
		$data=array("status"=>0);
		if($countryList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listcountrymsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."CountryList.php"));
			}
		 else{
			$msgInfo->setMessage("listcountrymsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."CountryList.php"));
			 }
		}
	}	
}
else{
$allCountries=$countryList->getCountries($globalUtil);
}
//$globalUtil->printArray($allAdminUsers);
?>