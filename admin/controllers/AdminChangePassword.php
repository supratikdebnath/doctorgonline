<?php
require("../includes/connection.php");
$adminChangePassword=new AdminChangePassword;
//$globalUtil->printArray($_POST);
$formdata=array('oldpassword'=>md5($_POST['oldpass']),'newpassword'=>md5($_POST['newpass']));
$changePassword=$adminChangePassword->changePassword($globalUtil,$formdata);
if($changePassword){
		$msgInfo->setMessage("changepasswordmsg",SUCCESS_MSG_CHANGE_PASSWORD,"successmsg");
		$msgInfo->saveMessage();
}
else{
		$msgInfo->setMessage("changepasswordmsg",ERROR_MSG_CHANGE_PASSWORD,"errormsg");
		$msgInfo->saveMessage();
	}
$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."ChangePassword.php"));	
?>