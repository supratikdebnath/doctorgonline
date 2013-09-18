<?php
$adminUserSessionLog=new AdminUserSessionLog;
/*If Delete Requested Starts*/
$action=$_GET['do'];
if($action=='del'){
if($adminUserSessionLog->deleteLog($globalUtil,$adminUtil)){
	$msgInfo->setMessage("adminuserlogmsg",SUCCESS_MSG_ADMIN_USER_LOG_DELETE,"successmsg");
	$msgInfo->saveMessage();
	}
	else{
	$msgInfo->setMessage("adminuserlogmsg",ERROR_MSG_ADMIN_USER_LOG_DELETE,"errormsg");
	$msgInfo->saveMessage();	
	}
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."AdminUserSessionLog.php"));
}
else{
$adminUserLogList=$adminUserSessionLog->getUserLogList($globalUtil);
//$globalUtil->printArray($adminUserLogList);
}
?>