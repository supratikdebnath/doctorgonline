<?php
#############################
#By Samannoy Chatterjee		#
#Date : 17072012			#
#Last Updated: 23122012		#
#www.samannoychatterjee.net #
#############################
class Country{
	public function insertCountry($globalUtil,$data){
			if($globalUtil->sqlinsert($data,TABLE_COUNTRIES)){
			return true;
			}
			else{
			return false;
			}
		}
	public function updateCountry($globalUtil,$data){
		
			if($globalUtil->sqlupdate($data,"WHERE id='".$data['id']."'",TABLE_COUNTRIES)!='-1'){
			return true;
			}
			else{
			return false;
			}
		}
	public function deleteCountry($globalUtil,$adminUtil,$id){
		$delete=$globalUtil->sqldelete(TABLE_COUNTRIES,"WHERE id='".$id."' AND status='0'");
		return $delete;
		}
	public function changeStatus($globalUtil,$data,$id){
		$checkifExists=$globalUtil->sqlNumRows("SELECT status FROM ".TABLE_COUNTRIES." WHERE id='".$id."'",2);
		if($checkifExists==1){
		if($globalUtil->sqlupdate($data,"WHERE id='".$id."'",TABLE_COUNTRIES)!='-1'){
			return true;
		  }
		}
		else{
			return false;
			} 
		}
	public function getCountries($globalUtil,$condition=""){
		$sql="SELECT * FROM ".TABLE_COUNTRIES." ".$condition." ORDER BY countryName ASC";
		$countryList=$globalUtil->sqlFetchRowsAssoc($sql,2);
		return $countryList;
		}
	public function validateCountry($globalUtil,$data){
		$error=false;
		$errormsg="";
		if($data['countryName']==''){
			$error=true;
			$errormsg .= "Please enter country name<br/>";
			}
		if($data['countryCode']==''){
			$error=true;
			$errormsg .= "Please enter country code<br/>";
			}	
		if($data['status']==''){
			$error=true;
			$errormsg .= "Please select status<br/>";
			}	
		$return=array("errors"=>$error,"errormsgs"=>$errormsg);
		return $return;	
		}
	public function checkCurrentStatus($globalUtil,$id){
		$sql="SELECT status FROM ".TABLE_COUNTRIES." WHERE id='".$id."'";
		$countryStatus=$globalUtil->sqlFetchRowsAssoc($sql,2);
		$res=$countryStatus['data'][0]['status'];
		return $res;
		}						
}
?>