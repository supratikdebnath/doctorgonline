<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################
class AdminUserList{
	public function getUserList($globalUtil){
		$sql="SELECT * FROM ".TABLE_ADMIN_USERS." WHERE id <> '1'";
		$userList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $userList;
		}
	public function deleteUser($globalUtil,$adminUtil,$uid){
		if($uid!=$adminUtil->administratorUserId()){
		$globalUtil->sqldelete(TABLE_ADMIN_USERS,"WHERE id='".$uid."'");
		$globalUtil->sqldelete(TABLE_ADMIN_SESSION_DETAILS,"WHERE adminId='".$uid."'");
		return true;
		}
		else {
		return false;
		}
	  }	
	}
?>