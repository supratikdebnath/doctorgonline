<?php
require("../includes/connection.php");
$latestNews=new LatestNews;
//For Inserting	
if(isset($_POST['Submit']) && $_POST['Submit']=="Submit"){
	 $userFullName=$adminUtil->getAdminName($globalUtil,$_SESSION['adminUserSession']['uid']);
	 $formData=array("topicName"=>$_POST["topicName"],"topicBody"=>$_POST['topicBody'],"createDt"=>time(),"modifyDt"=>time(),"postedBy"=>$userFullName,"status"=>$_POST["status"]);
	 $validData=$latestNews->validateLatestNews($globalUtil,$formData);
	 if(!$validData['errors']){
	 $newLatestNewsAdded=$latestNews->insertLatestNews($globalUtil,$formData);
		if($newLatestNewsAdded){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("modifylatestnewsmsg",SUCCESS_MSG_NEW_LATEST_NEWS,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("modifylatestnewsmsg",ERROR_MSG_NEW_LATEST_NEWS,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		$adminUtil->setPostFormData($_POST);
		$msgInfo->setMessage("modifylatestnewsmsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ModifyLatestNews.php"));
	}
//For Updating	
else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && $_POST["id"]!=''){
	 $userFullName=$adminUtil->getAdminName($globalUtil,$_SESSION['adminUserSession']['uid']);
	 $formData=array("id"=>$_POST["id"],"topicName"=>$_POST["topicName"],"topicBody"=>$_POST['topicBody'],"modifyDt"=>time(),"postedBy"=>$userFullName,"status"=>$_POST["status"]);
	 $validData=$latestNews->validateLatestNews($globalUtil,$formData);
	 if(!$validData['errors']){
	 $LatestNewsUpdated=$latestNews->updateLatestNews($globalUtil,$formData);
		if($LatestNewsUpdated){
		$adminUtil->unsetPostFormDataAll();	
		$msgInfo->setMessage("listlatestnewsmsg",SUCCESS_MSG_UPDATE_LATEST_NEWS,"successmsg");
		$msgInfo->saveMessage();
		}
		else{
		$msgInfo->setMessage("listlatestnewsmsg",ERROR_MSG_UPDATE_LATEST_NEWS,"errormsg");
		$msgInfo->saveMessage();		
		}	 
	 }
	 else{
		/*$adminUtil->setPostFormData($_POST);*/
		$msgInfo->setMessage("listlatestnewsmsg",$validData['errormsgs'],"errormsg");
		$msgInfo->saveMessage();
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."LatestNewsList.php"));
	
	}	
?>