<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################
class AdminModifyUser{
	public function updateUser($globalUtil,$data){
		if($data['password']!=''){
		$data['password']=$globalUtil->encryptAccountPassword($data['password']);
		}
		//$globalUtil->printArray($data);
		if($globalUtil->sqlupdate($data,"WHERE id='".$data['id']."'",TABLE_ADMIN_USERS)!='-1'){
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
		if($data['email']==''){
			$error=true;
			$errormsg .= "Please enter email address<br />";
			}
		if($data['email']!='' && !$globalUtil->checkMail($data['email'])){
			$error=true;
			$errormsg .= "Invalid email address<br />";
			}				
		if($data['email']!='' && $this->checkAdminEmailExists($globalUtil,$data['email'],$data['id'])){
			$error=true;
			$errormsg .= "Email address already exists<br/>";
			}
		if($data['privilege']==''){
			$error=true;
			$errormsg .= "Please select privilege<br />";
			}									
		
		$return=array("errors"=>$error,"errormsgs"=>$errormsg);
		return $return;
	}
	public function checkAdminEmailExists($globalUtil,$val,$currentUserId){
		$queryUserExists="SELECT * FROM ".TABLE_ADMIN_USERS." WHERE email='".$val."' AND id <> '".$currentUserId."'";
		if($globalUtil->sqlNumRows($queryUserExists,2)>0){
			return true;
			}
		else{
			return false;
			}	
		}
}
?>