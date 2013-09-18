<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################
class AdminUtil{
/*Get Admin Last Login Time*/
public function adminLastLogin($globalUtil,$adminId,$usersessionid){
	$sql="SELECT LastActivityTime FROM ".TABLE_ADMIN_SESSION_DETAILS." WHERE adminId=".$adminId." AND id <> '".$usersessionid."' ORDER BY id DESC LIMIT 0,1";
	$lastLoginArray=$globalUtil->sqlFetchRowsAssoc($sql,2);
	$lastLoginTime=$lastLoginArray['data'][0]['LastActivityTime'];
	$result=$globalUtil->dateFromTime($lastLoginTime,"dS M Y, H:i:s A");
	return $result;
	}
/*Get Admin Last Login Time*/	 
/*Check Admin user session*/	
public function checkAdminSession($globalUtil,$msgInfo){
	if(!isset($_SESSION['adminUserSession']) || !isset($_SESSION['adminUserSession']['sessionId']) || !isset($_SESSION['adminUserSession']['uid']) || !isset($_SESSION['adminUserSession']['LastActivityTime']) || $_SESSION['adminUserSession']['status']!="1"){
		$msgInfo->setMessage("usersessionmsg",ERROR_MSG_USER_AUTHETICATION,"errormsg");
		$msgInfo->saveMessage();
		$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."index.php"));
		}
	 else{
		 $query_string="SELECT id FROM ".TABLE_ADMIN_SESSION_DETAILS." WHERE id='".$_SESSION['adminUserSession']['sessionId']."' AND adminId='".$_SESSION['adminUserSession']['uid']."' AND LoginStatus='1'";
	  	 $isValid=$globalUtil->sqlNumRows($query_string,2);
		 if($isValid!=1){
		 $msgInfo->setMessage("usersessionmsg",ERROR_MSG_SESSION_EXPIRED,"errormsg");
		 $msgInfo->saveMessage();
		 $globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."index.php"));
			}
		 }	
	}	
/*Check Admin user session*/

/*Check Admin user privilege*/
public function CheckAdminPagePrivs($globalUtil,$userId,$privId,$PageId){
  if($privId=="0"){ // *** Dont Change This ***.
	  	return true;
	  }
  else{
	  	$globalUtil->redirectUrl($globalUtil->generateUrl(ADMIN_SITE_URL."NoPrivilege.php"));
	  }	  
  }	
/*Check Admin user privilege*/ 	
/*Get Admin User Details*/
public function getAdminDetails($globalUtil,$userId){
	$sql="SELECT username,privilege,fullname,email FROM ".TABLE_ADMIN_USERS." WHERE id='".$userId."'";
	$adminDetails=$globalUtil->sqlFetchRowsAssoc($sql,2);
	return $adminDetails;
	}
/*Get Admin User Details*/
/*Get Admin UserName*/	
public function getAdminUsername($globalUtil,$userId){
	$adminDetails=$this->getAdminDetails($globalUtil,$userId);
	//$globalUtil->printArray($adminDetails);
	$adminUsername=ucfirst($adminDetails['data'][0]['username']);
	return $adminUsername;
	}
/*Get Admin UserName*/
/*Get Admin Privilege*/
public function getAdminPrivilege($globalUtil,$userId){
	$adminDetails=$this->getAdminDetails($globalUtil,$userId);
	//$globalUtil->printArray($adminDetails);
	$adminUserPrivs=$adminDetails['data'][0]['privilege'];
	return $adminUserPrivs;
	}
public function getAdminPrivilegeName($globalUtil,$privId){
	$sql="SELECT privilegeName FROM ".TABLE_ADMIN_PRIVS_MASTER." WHERE id='".$privId."'";
	$PrivsArray=$globalUtil->sqlFetchRowsAssoc($sql,2);
	return $PrivsArray['data']['0']['privilegeName'];
	}	
/*Get Admin Privilege*/	

/*Get Admin Full Name*/
public function getAdminName($globalUtil,$userId){
	$adminDetails=$this->getAdminDetails($globalUtil,$userId);
	//$globalUtil->printArray($adminDetails);
	$adminUserFullName=$adminDetails['data'][0]['fullname'];
	return $adminUserFullName;
	}
/*Get Admin Full Name*/	

/*Set/Unset Post Form Data */
public function setPostFormData($val){
	foreach($val as $keys=>$values){
		$_SESSION['postData'][$keys]=$values;
		}
	}
public function unsetPostFormDataAll(){
	foreach($_SESSION['postData'] as $keys=>$values){
	unset($_SESSION['postData'][$keys]);
	}
	}
public function unsetPostFormData($key){
	unset($_SESSION['postData'][$key]);
	}	
public function getPostFormData($key){
	$val="";
	if(isset($_SESSION['postData'][$key])){
	$val=$_SESSION['postData'][$key];
	$this->unsetPostFormData($key);
	return $val;
	}
	else{
		return $val;
		}
	}	
/*Set/Unset Post Form Data */	
/*Get Administrator User ID*/
public function administratorUserId(){
	return 1;
	}
/*Get Administrator User ID*/


/*Set/Unset Get Form Data */
public function setGetUrlData($val){
	foreach($val as $keys=>$values){
		$_SESSION['postData'][$keys]=$values;
		}
	}
public function unsetGetUrlDataAll(){
	foreach($_SESSION['postData'] as $keys=>$values){
	unset($_SESSION['postData'][$keys]);
	}
	}
public function unsetGetUrlData($key){
	unset($_SESSION['postData'][$key]);
	}	
public function getGetUrlData($key){
	$val="";
	if(isset($_SESSION['postData'][$key])){
	$val=$_SESSION['postData'][$key];
	$this->unsetGetUrlData($key);
	return $val;
	}
	else{
		return $val;
		}
	}	
/*Set/Unset Post Form Data */
}
?>