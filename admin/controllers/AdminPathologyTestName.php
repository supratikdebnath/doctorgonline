<?php
require("../includes/connection.php");
$pathologyTestName=new PathologyTestName;
//For Inserting	
if(isset($_POST['Submit']) && $_POST['Submit']=="Submit"){
	 $formData=array("tid"=>$_POST["tid"],"test_name"=>$_POST["test_name"],"createDt"=>time(),"modifyDt"=>time(),"status"=>$_POST["status"]);
	 $validData=$pathologyTestName->validatepathologyTestName($globalUtil,$formData);
	 if(!$validData['errors']){
	 $newpathologyTestNameAdded=$pathologyTestName->insertpathologyTestName($globalUtil,$formData);
		if($newpathologyTestNameAdded){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("modifypathologyTestNamemsg",SUCCESS_MSG_NEW_PATHOLOGY_TEST_NAME,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("modifypathologyTestNamemsg",ERROR_MSG_NEW_PATHOLOGY_TEST_NAME,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		$adminUtil->setPostFormData($_POST);
		$msgInfo->setMessage("modifypathologyTestNamemsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyPathologyTestName.php"));
	}
//For Updating	
else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && $_POST["id"]!=''){
	 $formData=array("id"=>$_POST["id"],"tid"=>$_POST["tid"],"test_name"=>$_POST["test_name"],"modifyDt"=>time(),"status"=>$_POST["status"]);
	 $validData=$pathologyTestName->validatepathologyTestName($globalUtil,$formData);
	 if(!$validData['errors']){
	 $pathologyTestNameUpdated=$pathologyTestName->updatepathologyTestName($globalUtil,$formData);
		if($pathologyTestNameUpdated){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("listPathologyTestNamemsg",SUCCESS_MSG_UPDATE_PATHOLOGY_TEST_NAME,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("listPathologyTestNamemsg",ERROR_MSG_UPDATE_PATHOLOGY_TEST_NAME,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		/*$adminUtil->setPostFormData($_POST);*/
		$msgInfo->setMessage("listPathologyTestNamemsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."PathologyTestNameList.php"));
	
	}	
?>