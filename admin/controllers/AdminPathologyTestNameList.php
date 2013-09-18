<?php
$pathologyTestNameList=new PathologyTestName;
$pathology=new Pathology;
/*If Delete Requested Starts*/
if(isset($_GET['id']) && isset($_GET['do'])){
$id=$_GET['id'];
$action=$_GET['do'];
if($action=='del' && $id!=''){
	
	//$globalUtil->printValue($id);
	$sqlExists="SELECT * FROM ".TABLE_PATHOLOGY_TEST_NAME." WHERE id='".$id."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	//$globalUtil->printValue($ifExists);
	if($ifExists>0){
	if($pathologyTestNameList->deletePathologyTestName($globalUtil,$adminUtil,$id)!=0){
	$sqlExists="SELECT * FROM ".TABLE_PATHOLOGY_TESTS." WHERE testNameId='".$id."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	if($ifExists>0){
	if($pathology->deletePathologyInfo($globalUtil,$adminUtil,$id,'')!=0){
    $msgInfo->setMessage("listPathologyTestNamemsg",SUCCESS_MSG_PATHOLOGY_TEST_NAME_DELETE,"successmsg");
	$msgInfo->saveMessage();
	}
	else{
	$msgInfo->setMessage("listPathologyTestNamemsg",ERROR_MSG_PATHOLOGY_TEST_NAME_DELETE,"errormsg");
	$msgInfo->saveMessage();
		}
	}
	$msgInfo->setMessage("listPathologyTestNamemsg",SUCCESS_MSG_PATHOLOGY_TEST_NAME_DELETE,"successmsg");
	$msgInfo->saveMessage();
	}
	else{
	$msgInfo->setMessage("listPathologyTestNamemsg",ERROR_MSG_PATHOLOGY_TEST_NAME_DELETE,"errormsg");
	$msgInfo->saveMessage();	
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyTestNameList.php"));
	
	}
	else{
	$msgInfo->setMessage("listPathologyTestNamemsg",ERROR_MSG_PATHOLOGY_TEST_NAME_EXISTS,"errormsg");
	$msgInfo->saveMessage();
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyTestNameList.php"));	
	}
}
/*If Delete Requested Ends*/
if($action=='status' && $id!=''){
	$currentStatus=$pathologyTestNameList->checkCurrentStatus($globalUtil,$id);
	if($currentStatus==0){
		$data=array("status"=>1);
		if($pathologyTestNameList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listPathologyTestNamemsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyTestNameList.php"));
			}
		 else{
			$msgInfo->setMessage("listPathologyTestNamemsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyTestNameList.php"));
			 }	
		}// Change from Inactive to Active

	else if($currentStatus==1){ // Change from Active to Inactive
		$data=array("status"=>0);
		if($pathologyTestNameList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listPathologyTestNamemsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyTestNameList.php"));
			}
		 else{
			$msgInfo->setMessage("listPathologyTestNamemsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyTestNameList.php"));
			 }
		}
	}	
}
else{
$allPathologyTestName=$pathologyTestNameList->getPathologyTestName($globalUtil);
}
//$globalUtil->printArray($allAdminUsers);
?>