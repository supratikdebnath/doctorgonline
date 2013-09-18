<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################
class AdminLogin{
	public function validAdminLogin($obj,$uname,$pass){
			$query_string="SELECT * FROM ".TABLE_ADMIN_USERS." WHERE username='".$uname."' AND password='".$obj->encryptAccountPassword($pass)."' AND status='1'";
			$isValid=$obj->sqlNumRows($query_string,2);
			if($isValid==1){
				$userdetails=$this->loginAdminUserDetails($obj,$query_string);
				$this->createAdminSession($obj,$userdetails);
				return true;
			}
			else{
				return false;	
			}
		}
	public function createAdminSession($obj,$userdetails){
		    
			//$obj->printArray($userdetails);
			$loginDataDetails=array("adminId"=>$userdetails['id'],"loginTime"=>time(),"LastActivityTime"=>time(),"LoginStatus"=>"1");
			$sessionId=$obj->sqlinsert($loginDataDetails,TABLE_ADMIN_SESSION_DETAILS,2);	
			$_SESSION['adminUserSession']['sessionId']=$sessionId;
			$_SESSION['adminUserSession']['uid']=$userdetails['id'];
			$_SESSION['adminUserSession']['LastActivityTime']=time();
			$_SESSION['adminUserSession']['privs']=$userdetails['privilege'];
			$_SESSION['adminUserSession']['status']="1";
		}
	public function loginAdminUserDetails($obj,$query_string){
		    $loginData=$obj->sqlFetchRowsAssoc($query_string,2);
			$userData=array("id"=>$loginData['data'][0]['id'],"username"=>$loginData['data'][0]['username'],"privilege"=>$loginData['data'][0]['privilege'],"status"=>$loginData['data'][0]['status']);
			return $userData;
			
		}		
}
?>