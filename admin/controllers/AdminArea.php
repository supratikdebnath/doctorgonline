<?php
require("../includes/connection.php");
$area=new Area;
//For Inserting	
if(isset($_POST['Submit']) && $_POST['Submit']=="Submit"){
	 $formData=array("areaName"=>$_POST["areaName"],"sid"=>$_POST["sid"],"zid"=>$_POST["zid"],"createDt"=>time(),"modifyDt"=>time(),"status"=>$_POST["status"]);
	 $validData=$area->validateArea($globalUtil,$formData);
	 if(!$validData['errors']){
	 $newAreaAdded=$area->insertArea($globalUtil,$formData);
		if($newAreaAdded){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("modifyareamsg",SUCCESS_MSG_NEW_AREA,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("modifyareamsg",ERROR_MSG_NEW_AREA,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		$adminUtil->setPostFormData($_POST);
		$msgInfo->setMessage("modifyareamsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyArea.php"));
	}
//For Updating	
else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && $_POST["id"]!=''){
	 $formData=array("id"=>$_POST["id"],"areaName"=>$_POST["areaName"],"sid"=>$_POST["sid"],"zid"=>$_POST["zid"],"modifyDt"=>time(),"status"=>$_POST["status"]);
	 $validData=$area->validateArea($globalUtil,$formData);
	 if(!$validData['errors']){
	 $areaUpdated=$area->updateArea($globalUtil,$formData);
		if($areaUpdated){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("listareamsg",SUCCESS_MSG_UPDATE_AREA,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("listareamsg",ERROR_MSG_UPDATE_AREA,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		/*$adminUtil->setPostFormData($_POST);*/
		$msgInfo->setMessage("listareamsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."AreaList.php"));
	
	}	
?>