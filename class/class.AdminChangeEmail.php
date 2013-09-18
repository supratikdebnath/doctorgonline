<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################
class AdminChangeEmail{
public function changeEmail($globalUtil,$data){
	//$globalUtil->printArray($data);
	//$globalUtil->printValue($sql);
	if($this->checkValidEmail($globalUtil,$data['email'])){
	$updateData=array("email"=>$data['email']);
	$updateEmail=$globalUtil->sqlupdate($updateData,"WHERE id='".$_SESSION['adminUserSession']['uid']."' AND status='1'",TABLE_ADMIN_USERS);
	if($updateEmail=='-1'){
	die("Unable to update password to DataBase. Click Back on your Browser. Contact Administrator.");
	    }
	return true;	
	}
	else{
	return false;
	}
 }
public function checkValidEmail($globalUtil,$val){
	$sql="SELECT * FROM ".TABLE_ADMIN_USERS." WHERE id <> '".$_SESSION['adminUserSession']['uid']."' AND email='".$val."'";
	//$globalUtil->printValue($sql);
	$validPassword=$globalUtil->sqlNumRows($sql,2);
	if($validPassword=='0'){
		return true;
		}
	else{
		return false;
		}	
	} 
}
?>