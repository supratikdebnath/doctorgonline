<?php
require("../includes/connection.php");
$state=new State;
//For Inserting	
if(isset($_POST['Submit']) && $_POST['Submit']=="Submit"){
	 $formData=array("stateName"=>$_POST["stateName"],"cid"=>$_POST["cid"],"createDt"=>time(),"modifyDt"=>time(),"status"=>$_POST["status"]);
	 $validData=$state->validateState($globalUtil,$formData);
	 if(!$validData['errors']){
	 $newStateAdded=$state->insertState($globalUtil,$formData);
		if($newStateAdded){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("modifystatemsg",SUCCESS_MSG_NEW_STATE,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("modifystatemsg",ERROR_MSG_NEW_STATE,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		$adminUtil->setPostFormData($_POST);
		$msgInfo->setMessage("modifystatemsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyState.php"));
	}
//For Updating	
else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && $_POST["id"]!=''){
	 $formData=array("id"=>$_POST["id"],"stateName"=>$_POST["stateName"],"cid"=>$_POST["cid"],"modifyDt"=>time(),"status"=>$_POST["status"]);
	 $validData=$state->validateState($globalUtil,$formData);
	 if(!$validData['errors']){
	 $stateUpdated=$state->updateState($globalUtil,$formData);
		if($stateUpdated){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("liststatemsg",SUCCESS_MSG_UPDATE_STATE,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("liststatemsg",ERROR_MSG_UPDATE_STATE,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		/*$adminUtil->setPostFormData($_POST);*/
		$msgInfo->setMessage("liststatemsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."StateList.php"));
	
	}	
?>