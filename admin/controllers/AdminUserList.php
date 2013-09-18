<?php
$adminUserList=new AdminUserList;
/*If Delete Requested Starts*/
$uid=$_GET['uid'];
$action=$_GET['do'];
if($action=='del' && $uid!=''){
	
	//$globalUtil->printValue($uid);
	$sqlExists="SELECT * FROM ".TABLE_ADMIN_USERS." WHERE id='".$uid."'";
	$ifExists=$globalUtil->sqlNumRows($sqlExists,2);
	//$globalUtil->printValue($ifExists);
	if($ifExists>0){
	if($adminUserList->deleteUser($globalUtil,$adminUtil,$uid)){
	$msgInfo->setMessage("listadminusermsg",SUCCESS_MSG_ADMIN_USER_DELETE,"successmsg");
	$msgInfo->saveMessage();
	}
	else{
	$msgInfo->setMessage("listadminusermsg",ERROR_MSG_ADMIN_USER_DELETE_NOT_ALLOWED,"errormsg");
	$msgInfo->saveMessage();	
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."AdminUserList.php"));
	
	}
	else{
	$msgInfo->setMessage("listadminusermsg",ERROR_MSG_ADMIN_USER_DELETE,"errormsg");
	$msgInfo->saveMessage();
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."AdminUserList.php"));	
	}
}
/*If Delete Requested Ends*/
else{
$allAdminUsers=$adminUserList->getUserList($globalUtil);
}
//$globalUtil->printArray($allAdminUsers);
?>