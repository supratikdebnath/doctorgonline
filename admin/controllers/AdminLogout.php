<?php
require("../includes/connection.php");
require(ADMIN_DOCUMENT_PATH.INCLUDE_FOLDER.PAGE_AUTHENTICATE_LOGIN);
$adminLogout=new AdminLogout();
if($adminLogout->logoutAdmin($globalUtil)){
	$msgInfo->setMessage("usersessionmsg",SUCCESS_MSG_LOGOUT,"successmsg");
	$msgInfo->saveMessage();	
	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."index.php"));
}
?>