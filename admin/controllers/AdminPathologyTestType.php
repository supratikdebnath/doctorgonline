<?php
require("../includes/connection.php");
$pathologyTestType=new PathologyTestType;
//For Inserting	
if(isset($_POST['Submit']) && $_POST['Submit']=="Submit"){
	 $formData=array("test_type"=>$_POST["test_type"],"createDt"=>time(),"modifyDt"=>time(),"status"=>$_POST["status"]);
	 $validData=$pathologyTestType->validatePathologyTestType($globalUtil,$formData);
	 if(!$validData['errors']){
	 $newPathologyTestTypeAdded=$pathologyTestType->insertPathologyTestType($globalUtil,$formData);
		if($newPathologyTestTypeAdded){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("modifyPathologyTestTypemsg",SUCCESS_MSG_NEW_PATHOLOGY_TEST_TYPE,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("modifyPathologyTestTypemsg",ERROR_MSG_NEW_PATHOLOGY_TEST_TYPE,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		$adminUtil->setPostFormData($_POST);
		$msgInfo->setMessage("modifyPathologyTestTypemsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyPathologyTestType.php"));
	}
//For Updating	
else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && $_POST["id"]!=''){
	 $formData=array("id"=>$_POST["id"],"test_type"=>$_POST["test_type"],"modifyDt"=>time(),"status"=>$_POST["status"]);
	 $validData=$pathologyTestType->validatePathologyTestType($globalUtil,$formData);
	 if(!$validData['errors']){
	 $pathologyTestTypeUpdated=$pathologyTestType->updatePathologyTestType($globalUtil,$formData);
		if($pathologyTestTypeUpdated){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("listPathologyTestTypemsg",SUCCESS_MSG_UPDATE_PATHOLOGY_TEST_TYPE,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("listPathologyTestTypemsg",ERROR_MSG_UPDATE_PATHOLOGY_TEST_TYPE,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		/*$adminUtil->setPostFormData($_POST);*/
		$msgInfo->setMessage("listPathologyTestTypemsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyTestTypeList.php"));
	
	}	
?>