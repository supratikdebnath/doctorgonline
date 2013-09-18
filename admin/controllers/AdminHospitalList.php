<?php
$hospitalList=new Hospital;
$areaObj=new Area;
/*If Delete Requested Starts*/
if(isset($_GET['id']) && isset($_GET['do'])){
$id=$_GET['id'];
$action=$_GET['do'];
if($action=='del' && $id!=''){
	
	//$globalUtil->printValue($id);
	$sqlExists="SELECT * FROM ".TABLE_USER_HOSPITAL." WHERE id='".$id."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	//$globalUtil->printValue($ifExists);
	if($ifExists>0){
	if($hospitalList->deleteHospital($globalUtil,$adminUtil,$id)!=0){
	$msgInfo->setMessage("listhospitalmsg",SUCCESS_MSG_HOSPITAL_DELETE,"successmsg");
	$msgInfo->saveMessage();
	}
	else{
	$msgInfo->setMessage("listhospitalmsg",ERROR_MSG_HOSPITAL_DELETE,"errormsg");
	$msgInfo->saveMessage();	
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."HospitalList.php"));
	
	}
	else{
	$msgInfo->setMessage("listhospitalmsg",ERROR_MSG_HOSPITAL_EXISTS,"errormsg");
	$msgInfo->saveMessage();
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."HospitalList.php"));	
	}
}
/*If Delete Requested Ends*/
if($action=='status' && $id!=''){
	$currentStatus=$hospitalList->checkCurrentStatus($globalUtil,$id);
	if($currentStatus==0){
		$data=array("status"=>1);
		if($hospitalList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listhospitalmsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."HospitalList.php"));
			}
		 else{
			$msgInfo->setMessage("listhospitalmsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."HospitalList.php"));
			 }	
		}// Change from Inactive to Active

	else if($currentStatus==1){ // Change from Active to Inactive
		$data=array("status"=>0);
		if($hospitalList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listhospitalmsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."HospitalList.php"));
			}
		 else{
			$msgInfo->setMessage("listhospitalmsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."HospitalList.php"));
			 }
		}
	}	
}
else{
$allHospital=$hospitalList->getHospital($globalUtil);
}
//$globalUtil->printArray($allAdminUsers);
?>