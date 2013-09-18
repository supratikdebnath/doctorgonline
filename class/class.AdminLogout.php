<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################
class AdminLogout{
	public function logoutAdmin($globalUtil){
		$this->destroyAdminSession($globalUtil,$uname);
		return true;
	}
	public function destroyAdminSession($globalUtil,$uname){
		$logoutdata=array("LastActivityTime"=>time(),"LoginStatus"=>"0");
		$updateLogout=$globalUtil->sqlupdate($logoutdata,"WHERE adminId='".$_SESSION['adminUserSession']['uid']."' AND id='".$_SESSION['adminUserSession']['sessionId']."'",TABLE_ADMIN_SESSION_DETAILS); // Update Logout to database.
		if($updateLogout!="-1"){
		unset($_SESSION['adminUserSession']);
		}else{
		die("Error : Unable to update logout to database. Contact Website Administrator");
		}
	}
		
}
?>