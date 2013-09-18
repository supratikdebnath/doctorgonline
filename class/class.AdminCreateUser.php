<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################
class AdminCreateUser{
	public function createNewUser($globalUtil,$data){
		$data['password']=$globalUtil->encryptAccountPassword($data['password']);
		//$globalUtil->printArray($data);
		if($globalUtil->sqlinsert($data,TABLE_ADMIN_USERS)){
		return true;
		}
		else{
		return false;
		}
	}
	public function validateData($globalUtil,$data){
		$error=false;
		$errormsg="";
		if($data['fullname']==''){
			$error=true;
			$errormsg .= "Please enter fullname<br/>";
			}
		if($data['username']==''){
			$error=true;
			$errormsg .= "Please enter username<br/>";
			}
		if($data['username']!='' && $this->checkAdminUsernameExists($globalUtil,$data['username'])){
			$error=true;
			$errormsg .= "Username already exists<br/>";
			}
		if($data['email']==''){
			$error=true;
			$errormsg .= "Please enter email address<br />";
			}
		if($data['email']!='' && !$globalUtil->checkMail($data['email'])){
			$error=true;
			$errormsg .= "Invalid email address<br />";
			}				
		if($data['email']!='' && $this->checkAdminEmailExists($globalUtil,$data['email'])){
			$error=true;
			$errormsg .= "Email address already exists<br/>";
			}
		if($data['password']==''){
			$error=true;
			$errormsg .= "Please enter password<br />";
			}
		if($data['privilege']==''){
			$error=true;
			$errormsg .= "Please select privilege<br />";
			}									
		
		$return=array("errors"=>$error,"errormsgs"=>$errormsg);
		return $return;
	}
	public function checkAdminUsernameExists($globalUtil,$val){
		$queryUserExists="SELECT * FROM ".TABLE_ADMIN_USERS." WHERE username='".$val."'";
		if($globalUtil->sqlNumRows($queryUserExists,2)>0){
			return true;
			}
		else{
			return false;
			}	
		}
	public function checkAdminEmailExists($globalUtil,$val){
		$queryUserExists="SELECT * FROM ".TABLE_ADMIN_USERS." WHERE email='".$val."'";
		if($globalUtil->sqlNumRows($queryUserExists,2)>0){
			return true;
			}
		else{
			return false;
			}	
		}		
}
?>