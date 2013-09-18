<?php
$pathologyTestTypeList=new PathologyTestType;
/*If Delete Requested Starts*/
if(isset($_GET['id']) && isset($_GET['do'])){
$id=$_GET['id'];
$action=$_GET['do'];
if($action=='del' && $id!=''){
	
	//$globalUtil->printValue($id);
	$sqlExists="SELECT * FROM ".TABLE_PATHOLOGY_TEST_TYPE." WHERE id='".$id."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	//$globalUtil->printValue($ifExists);
	if($ifExists>0){
	if($pathologyTestTypeList->deletePathologyTestType($globalUtil,$adminUtil,$id)!=0){
	$msgInfo->setMessage("listPathologyTestTypemsg",SUCCESS_MSG_PATHOLOGY_TEST_TYPE_DELETE,"successmsg");
	$msgInfo->saveMessage();
	}
	else{
	$msgInfo->setMessage("listPathologyTestTypemsg",ERROR_MSG_PATHOLOGY_TEST_TYPE_DELETE,"errormsg");
	$msgInfo->saveMessage();	
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyTestTypeList.php"));
	
	}
	else{
	$msgInfo->setMessage("listPathologyTestTypemsg",ERROR_MSG_PATHOLOGY_TEST_TYPE_EXISTS,"errormsg");
	$msgInfo->saveMessage();
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyTestTypeList.php"));	
	}
}
/*If Delete Requested Ends*/
if($action=='status' && $id!=''){
	$currentStatus=$pathologyTestTypeList->checkCurrentStatus($globalUtil,$id);
	if($currentStatus==0){
		$data=array("status"=>1);
		if($pathologyTestTypeList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listPathologyTestTypemsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyTestTypeList.php"));
			}
		 else{
			$msgInfo->setMessage("listPathologyTestTypemsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyTestTypeList.php"));
			 }	
		}// Change from Inactive to Active

	else if($currentStatus==1){ // Change from Active to Inactive
		$data=array("status"=>0);
		if($pathologyTestTypeList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listPathologyTestTypemsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyTestTypeList.php"));
			}
		 else{
			$msgInfo->setMessage("listPathologyTestTypemsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyTestTypeList.php"));
			 }
		}
	}	
}
else{
$allPathologyTestType=$pathologyTestTypeList->getPathologyTestType($globalUtil);
}
//$globalUtil->printArray($allAdminUsers);
?>