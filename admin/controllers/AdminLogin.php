<?php
require("../includes/connection.php");
$adminLogin=new AdminLogin();
$loginStatus=$adminLogin->validAdminLogin($globalUtil,$_POST['uname'],$_POST['pass']);
if($loginStatus){
		$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."home.php"));
	}
else
	{
		$msgInfo->setMessage("usersessionmsg",ERROR_MSG_LOGIN,"errormsg");
		$msgInfo->saveMessage();
		$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."index.php"));
	}	
ob_end_flush();	
?>