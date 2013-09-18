<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################
class AdminUserSessionLog{
	public function getUserLogList($globalUtil){
		$sql="SELECT username,fullname,loginTime,LastActivityTime,LoginStatus FROM ".TABLE_ADMIN_USERS." tau INNER JOIN ".TABLE_ADMIN_SESSION_DETAILS." tasd ON tau.id=tasd.adminId ORDER BY tasd.loginTime DESC";
		//echo $sql;
		//die();
		$userLogList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $userLogList;
		}
	public function deleteLog($globalUtil,$adminUtil){
		$currentTime=time();
		$time1DayBack=$currentTime-86400;
		$globalUtil->sqldelete(TABLE_ADMIN_SESSION_DETAILS,"WHERE loginTime<'".$time1DayBack."'");
		return true;
	  }	
}
?>