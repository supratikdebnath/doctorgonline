<?php
$pathologyList=new Pathology;
$areaObj=new Area;

/*If Delete Requested Starts*/
if(isset($_GET['id']) && isset($_GET['do'])){
$id=$_GET['id'];
$action=$_GET['do'];
if($action=='del' && $id!=''){
	
	//$globalUtil->printValue($id);
	$sqlExists="SELECT * FROM ".TABLE_PATHOLOGY_DETAILS." WHERE id='".$id."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	//$globalUtil->printValue($ifExists);
	if($ifExists>0){
	if($pathologyList->deletePathology($globalUtil,$adminUtil,$id)!=0){
	$msgInfo->setMessage("listpathologymsg",SUCCESS_MSG_PATHOLOGY_DELETE,"successmsg");
	$msgInfo->saveMessage();
	}
	else{
	$msgInfo->setMessage("listpathologymsg",ERROR_MSG_PATHOLOGY_DELETE,"errormsg");
	$msgInfo->saveMessage();	
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyList.php"));
	
	}
	else{
	$msgInfo->setMessage("listpathologymsg",ERROR_MSG_PATHOLOGY_EXISTS,"errormsg");
	$msgInfo->saveMessage();
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyList.php"));	
	}
}
/*If Delete Requested Ends*/
if($action=='status' && $id!=''){
	$currentStatus=$pathologyList->checkCurrentStatus($globalUtil,$id);
	if($currentStatus==0){
		$data=array("status"=>1);
		if($pathologyList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listpathologymsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyList.php"));
			}
		 else{
			$msgInfo->setMessage("listpathologymsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyList.php"));
			 }	
		}// Change from Inactive to Active

	else if($currentStatus==1){ // Change from Active to Inactive
		$data=array("status"=>0);
		if($pathologyList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listpathologymsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyList.php"));
			}
		 else{
			$msgInfo->setMessage("listpathologymsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyList.php"));
			 }
		}
	}	
}
else{
$allPathology=$pathologyList->getPathology($globalUtil,'');
}
//$globalUtil->printArray($allAdminUsers);
?>