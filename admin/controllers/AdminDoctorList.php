<?php
$doctorList=new Doctor;
$areaObj=new Area;
/*If Delete Requested Starts*/
if(isset($_GET['id']) && isset($_GET['do'])){
$id=$_GET['id'];
$action=$_GET['do'];
if($action=='del' && $id!=''){
	
	//$globalUtil->printValue($id);
	$sqlExists="SELECT * FROM ".TABLE_USER_DOCTOR." WHERE id='".$id."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	//$globalUtil->printValue($ifExists);
	if($ifExists>0){
	if($doctorList->deleteDoctor($globalUtil,$adminUtil,$id)!=0){
	$msgInfo->setMessage("listdoctormsg",SUCCESS_MSG_DOCTOR_DELETE,"successmsg");
	$msgInfo->saveMessage();
	}
	else{
	$msgInfo->setMessage("listdoctormsg",ERROR_MSG_DOCTOR_DELETE,"errormsg");
	$msgInfo->saveMessage();	
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."DoctorList.php"));
	
	}
	else{
	$msgInfo->setMessage("listdoctormsg",ERROR_MSG_DOCTOR_EXISTS,"errormsg");
	$msgInfo->saveMessage();
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."DoctorList.php"));	
	}
}
/*If Delete Requested Ends*/
if($action=='status' && $id!=''){
	$currentStatus=$doctorList->checkCurrentStatus($globalUtil,$id);
	if($currentStatus==0){
		$data=array("status"=>1);
		if($doctorList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listdoctormsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."DoctorList.php"));
			}
		 else{
			$msgInfo->setMessage("listdoctormsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."DoctorList.php"));
			 }	
		}// Change from Inactive to Active

	else if($currentStatus==1){ // Change from Active to Inactive
		$data=array("status"=>0);
		if($doctorList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listdoctormsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."DoctorList.php"));
			}
		 else{
			$msgInfo->setMessage("listdoctormsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."DoctorList.php"));
			 }
		}
	}	
}
else{
$allDoctor=$doctorList->getDoctor($globalUtil,'');
}
//$globalUtil->printArray($allAdminUsers);
?>