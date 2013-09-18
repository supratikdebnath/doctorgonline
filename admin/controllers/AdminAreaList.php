<?php
$areaList=new Area;
/*If Delete Requested Starts*/
if(isset($_GET['id']) && isset($_GET['do'])){
$id=$_GET['id'];
$action=$_GET['do'];
if($action=='del' && $id!=''){
	
	//$globalUtil->printValue($id);
	$sqlExists="SELECT * FROM ".TABLE_AREAS." WHERE id='".$id."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	//$globalUtil->printValue($ifExists);
	if($ifExists>0){
	if($areaList->deleteCity($globalUtil,$adminUtil,$id)!=0){
	$msgInfo->setMessage("listareamsg",SUCCESS_MSG_AREA_DELETE,"successmsg");
	$msgInfo->saveMessage();
	}
	else{
	$msgInfo->setMessage("listareamsg",ERROR_MSG_AREA_DELETE,"errormsg");
	$msgInfo->saveMessage();	
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."AreaList.php"));
	
	}
	else{
	$msgInfo->setMessage("listareamsg",ERROR_MSG_AREA_EXISTS,"errormsg");
	$msgInfo->saveMessage();
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."AreaList.php"));	
	}
}
/*If Delete Requested Ends*/
if($action=='status' && $id!=''){
	$currentStatus=$areaList->checkCurrentStatus($globalUtil,$id);
	if($currentStatus==0){
		$data=array("status"=>1);
		if($areaList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listareamsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."AreaList.php"));
			}
		 else{
			$msgInfo->setMessage("listareamsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."AreaList.php"));
			 }	
		}// Change from Inactive to Active

	else if($currentStatus==1){ // Change from Active to Inactive
		$data=array("status"=>0);
		if($areaList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listareamsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."AreaList.php"));
			}
		 else{
			$msgInfo->setMessage("listareamsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."AreaList.php"));
			 }
		}
	}	
}
else{
$allArea=$areaList->getAreas($globalUtil);
}
//$globalUtil->printArray($allAdminUsers);
?>