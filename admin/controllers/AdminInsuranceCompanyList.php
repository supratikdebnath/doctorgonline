<?php
$insuranceCompanyList=new InsuranceCompany;
/*If Delete Requested Starts*/
if(isset($_GET['id']) && isset($_GET['do'])){
$id=$_GET['id'];
$action=$_GET['do'];
if($action=='del' && $id!=''){
	
	//$globalUtil->printValue($id);
	$sqlExists="SELECT * FROM ".TABLE_INSURANCE_COMPANY." WHERE id='".$id."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	//$globalUtil->printValue($ifExists);
	if($ifExists>0){
	if($insuranceCompanyList->deleteInsuranceCompany($globalUtil,$adminUtil,$id)!=0){
	$msgInfo->setMessage("listInsuranceCompanymsg",SUCCESS_MSG_INSURANCE_COMPANY_DELETE,"successmsg");
	$msgInfo->saveMessage();
	}
	else{
	$msgInfo->setMessage("listInsuranceCompanymsg",ERROR_MSG_INSURANCE_COMPANY_DELETE,"errormsg");
	$msgInfo->saveMessage();	
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."InsuranceCompanyList.php"));
	
	}
	else{
	$msgInfo->setMessage("listInsuranceCompanymsg",ERROR_MSG_INSURANCE_COMPANY_EXISTS,"errormsg");
	$msgInfo->saveMessage();
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."InsuranceCompanyList.php"));	
	}
}
/*If Delete Requested Ends*/
if($action=='status' && $id!=''){
	$currentStatus=$insuranceCompanyList->checkCurrentStatus($globalUtil,$id);
	if($currentStatus==0){
		$data=array("status"=>1);
		if($insuranceCompanyList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listInsuranceCompanymsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."InsuranceCompanyList.php"));
			}
		 else{
			$msgInfo->setMessage("listInsuranceCompanymsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."InsuranceCompanyList.php"));
			 }	
		}// Change from Inactive to Active

	else if($currentStatus==1){ // Change from Active to Inactive
		$data=array("status"=>0);
		if($insuranceCompanyList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listInsuranceCompanymsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."InsuranceCompanyList.php"));
			}
		 else{
			$msgInfo->setMessage("listInsuranceCompanymsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."InsuranceCompanyList.php"));
			 }
		}
	}	
}
else{
$allInsuranceCompany=$insuranceCompanyList->getInsuranceCompany($globalUtil);
}
//$globalUtil->printArray($allAdminUsers);
?>