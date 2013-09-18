<?php
$insuranceTPAList=new InsuranceTPA;
/*If Delete Requested Starts*/
if(isset($_GET['id']) && isset($_GET['do'])){
$id=$_GET['id'];
$action=$_GET['do'];
if($action=='del' && $id!=''){
	
	//$globalUtil->printValue($id);
	$sqlExists="SELECT * FROM ".TABLE_INSURANCE_TPA." WHERE id='".$id."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	//$globalUtil->printValue($ifExists);
	if($ifExists>0){
	if($insuranceTPAList->deleteInsuranceTPA($globalUtil,$adminUtil,$id)!=0){
	$msgInfo->setMessage("listInsuranceTPAmsg",SUCCESS_MSG_INSURANCE_TPA_DELETE,"successmsg");
	$msgInfo->saveMessage();
	}
	else{
	$msgInfo->setMessage("listInsuranceTPAmsg",ERROR_MSG_INSURANCE_TPA_DELETE,"errormsg");
	$msgInfo->saveMessage();	
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."InsuranceTPAList.php"));
	
	}
	else{
	$msgInfo->setMessage("listInsuranceTPAmsg",ERROR_MSG_INSURANCE_TPA_EXISTS,"errormsg");
	$msgInfo->saveMessage();
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."InsuranceTPAList.php"));	
	}
}
/*If Delete Requested Ends*/
if($action=='status' && $id!=''){
	$currentStatus=$insuranceTPAList->checkCurrentStatus($globalUtil,$id);
	if($currentStatus==0){
		$data=array("status"=>1);
		if($insuranceTPAList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listInsuranceTPAmsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."InsuranceTPAList.php"));
			}
		 else{
			$msgInfo->setMessage("listInsuranceTPAmsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."InsuranceTPAList.php"));
			 }	
		}// Change from Inactive to Active

	else if($currentStatus==1){ // Change from Active to Inactive
		$data=array("status"=>0);
		if($insuranceTPAList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listInsuranceTPAmsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."InsuranceTPAList.php"));
			}
		 else{
			$msgInfo->setMessage("listInsuranceTPAmsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."InsuranceTPAList.php"));
			 }
		}
	}	
}
else{
$allInsuranceTPA=$insuranceTPAList->getInsuranceTPA($globalUtil);
}
//$globalUtil->printArray($allAdminUsers);
?>