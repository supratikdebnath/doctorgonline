<?php
$latestNewsList=new LatestNews;
/*If Delete Requested Starts*/
if(isset($_GET['id']) && isset($_GET['do'])){
$id=$_GET['id'];
$action=$_GET['do'];
if($action=='del' && $id!=''){
	
	//$globalUtil->printValue($id);
	$sqlExists="SELECT * FROM ".TABLE_LATEST_NEWS." WHERE id='".$id."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	//$globalUtil->printValue($ifExists);
	if($ifExists>0){
	if($latestNewsList->deleteLatestNews($globalUtil,$adminUtil,$id)!=0){
	$msgInfo->setMessage("listlatestnewsmsg",SUCCESS_MSG_LATEST_NEWS_DELETE,"successmsg");
	$msgInfo->saveMessage();
	}
	else{
	$msgInfo->setMessage("listlatestnewsmsg",ERROR_MSG_LATEST_NEWS_DELETE,"errormsg");
	$msgInfo->saveMessage();	
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."LatestNewsList.php"));
	
	}
	else{
	$msgInfo->setMessage("listlatestnewsmsg",ERROR_MSG_ADMIN_USER_DELETE,"errormsg");
	$msgInfo->saveMessage();
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."LatestNewsList.php"));	
	}
}
/*If Delete Requested Ends*/
if($action=='status' && $id!=''){
	$currentStatus=$latestNewsList->checkCurrentStatus($globalUtil,$id);
	if($currentStatus==0){
		$data=array("status"=>1);
		if($latestNewsList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listlatestnewsmsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."LatestNewsList.php"));
			}
		 else{
			$msgInfo->setMessage("listlatestnewsmsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."LatestNewsList.php"));
			 }	
		}// Change from Inactive to Active

	else if($currentStatus==1){ // Change from Active to Inactive
		$data=array("status"=>0);
		if($latestNewsList->changeStatus($globalUtil,$data,$id)){
			$msgInfo->setMessage("listlatestnewsmsg",SUCCESS_MSG_STATUS_UPDATE,"successmsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."LatestNewsList.php"));
			}
		 else{
			$msgInfo->setMessage("listlatestnewsmsg",ERROR_MSG_STATUS_UPDATE,"errormsg");
			$msgInfo->saveMessage();
			$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."LatestNewsList.php"));
			 }
		}
	}	
}
else{
$allLatestNews=$latestNewsList->getLastestNews($globalUtil);
}
//$globalUtil->printArray($allAdminUsers);
?>