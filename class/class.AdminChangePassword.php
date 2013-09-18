<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################
class AdminChangePassword{
public function changePassword($globalUtil,$data){
	//$globalUtil->printArray($data);
	//$globalUtil->printValue($sql);
	if($this->checkValidOldPassword($globalUtil,$data['oldpassword'])){
	$updateData=array("password"=>$data['newpassword']);
	$updatePassword=$globalUtil->sqlupdate($updateData,"WHERE id='".$_SESSION['adminUserSession']['uid']."' AND password='".$data['oldpassword']."'",TABLE_ADMIN_USERS);
	if($updatePassword=='-1'){
	die("Unable to update password to DataBase. Click Back on your Browser. Contact Administrator.");
	    }
	return true;	
	}
	else{
	return false;
	}
 }
public function checkValidOldPassword($globalUtil,$val){
	$sql="SELECT * FROM ".TABLE_ADMIN_USERS." WHERE id='".$_SESSION['adminUserSession']['uid']."' AND password='".$val."'";
	//$globalUtil->printValue($sql);
	$validPassword=$globalUtil->sqlNumRows($sql,2);
	if($validPassword=='1'){
		return true;
		}
	else{
		return false;
		}	
	} 
}
?>